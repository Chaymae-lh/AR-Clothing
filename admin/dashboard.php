<?php

include '../includes/config.php';
include 'auth.php';


// Handle Add Product
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $old_price = $_POST['old_price'] ?: 0;
    $description = $_POST['description'];

    // Handle Image Upload
    if($_FILES['image']['name']){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time().'.'.$ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$filename);
    } else {
        $filename = '';
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, category, price, old_price, image, description) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$name, $category, $price, $old_price, $filename, $description]);
}


// Handle Delete Product
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id=?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if($product && $product['image']){
        @unlink('../uploads/'.$product['image']);
    }
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
}

// Fetch Products
$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - AR Clothing</title>
<link rel="stylesheet" href="style.css">
<style>
body { font-family:Arial; margin:0; background:#f0f0f0; }
header { background:#222; color:#fff; padding:10px 20px; display:flex; justify-content:space-between; align-items:center; }
.container { padding:20px; max-width:900px; margin:auto; }
form input, form select, form textarea { width:100%; padding:8px; margin:5px 0; border-radius:5px; border:1px solid #ccc; }
form button { padding:10px 15px; border:none; border-radius:5px; background:yellow; cursor:pointer; font-weight:bold; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
table, th, td { border:1px solid #ccc; }
th, td { padding:10px; text-align:center; }
a.delete { color:red; text-decoration:none; }
</style>
</head>
<body>
<header>
<h2>Admin Dashboard</h2>
<a href="logout.php" style="color:yellow;">Logout</a>
</header>

<div class="container">
<h3>Ajouter un produit</h3>
<form method="post" enctype="multipart/form-data">
<input type="text" name="name" placeholder="Nom du produit" required>
<input type="text" name="category" placeholder="Catégorie" required>
<input type="number" name="price" placeholder="Prix" step="0.01" required>
<input type="number" name="old_price" placeholder="Ancien prix (optionnel)" step="0.01">
<textarea name="description" placeholder="Description du produit"></textarea>
<input type="file" name="image" required>
<button type="submit" name="add">Ajouter</button>
</form>

<h3>Produits existants</h3>
<table>
<tr>
<th>ID</th>
<th>Nom</th>
<th>Catégorie</th>
<th>Prix</th>
<th>Image</th>
<th>Action</th>
</tr>
<?php foreach($products as $p): ?>
<tr>
<td><?= $p['id'] ?></td>
<td><?= htmlspecialchars($p['name']) ?></td>
<td><?= $p['category'] ?></td>
<td><?= $p['price'] ?> MAD</td>
<td><img src="../uploads/<?= $p['image'] ?>" width="50"></td>
<td><a href="?delete=<?= $p['id'] ?>" class="delete" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a></td>
</tr>
<?php endforeach; ?>
</table>
</div>
</body>
</html>
