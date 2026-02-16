<?php
include 'includes/config.php';
include 'includes/header.php';

if(!isset($_GET['id'])) {
    echo "<p>Produit introuvable.</p>";
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if(!$product) {
    echo "<p>Produit introuvable.</p>";
    
    exit;
}

/* 🔹 CONFIG */
$phone = "212648723910"; // numéro vendeur sans +
$siteUrl = "https://ar-clothing.great-site.net"; // ⚠️ ton domaine
$imageUrl = $siteUrl . "/uploads/" . $product['image'];
$productUrl = $siteUrl . "/product.php?id=" . $product['id'];

/* 🔹 MESSAGE WHATSAPP */
$message = "Bonjour, je souhaite commander :\n\n"
         . "🛍️ Produit : " . $product['name'] . "\n"
         . "💰 Prix : " . $product['price'] . " MAD\n\n"
         . " Lien produit : " . $productUrl;

$whatsappLink = "https://wa.me/$phone?text=" . urlencode($message);
?>

<section class="product-detail">
    <img src="uploads/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    
    <h2><?= htmlspecialchars($product['name']) ?></h2>

    <p>
        <?php if($product['old_price'] > 0): ?>
            <del><?= $product['old_price'] ?> MAD</del>
        <?php endif; ?>
        <strong><?= $product['price'] ?> MAD</strong>
    </p>

    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

    <a href="<?= $whatsappLink ?>" target="_blank" class="btn whatsapp">
        Order Now
    </a>
</section>

<?php include 'includes/footer.php'; ?>


