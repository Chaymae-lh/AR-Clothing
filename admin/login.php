<?php
session_start();
include '../includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {

        // Sécurité contre le vol de session
        session_regenerate_id(true);

        $_SESSION['admin'] = $admin['username'];

        header('Location: dashboard.php');
        exit;

    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin Login - AR Clothing</title>
<style>
body {
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
     background: linear-gradient(rgba(85, 81, 75, 0.85), rgba(27, 27, 26, 0.85)),
              url("../images/logo1.jpeg") center/cover no-repeat; 
    font-family:Arial;
    color:yellow
}
form {
    background:#292925;
    padding:30px;
    border-radius:20px;
    width:300px;
    text-align:center;
}
input {
    width:90%;
    padding:10px;
    margin:10px 0;
    border-radius:10px;
    border:none;
}
button {
    padding:10px 20px;
    border:none;
    border-radius:10px;
    background:yellow;
    font-weight:bold;
    cursor:pointer;
}
.error {
    color:red;
    margin-bottom:10px;
}
    @media (max-width: 768px) {
  body {
    padding: 20px;
    height: auto;
    min-height: 100vh;
  }
  form {
    width: 90%;
    max-width: 400px;
    padding: 40px 25px;
  }
  h2 {
    font-size: 24px;
    margin-bottom: 20px;
  }
  input {
    width: 100%;
    padding: 15px;
    margin: 15px 0;
    font-size: 16px;
  }
  button {
    width: 100%;
    padding: 15px;
    font-size: 16px;
    margin-top: 10px;
  }
}

</style>
</head>
<body>

<form method="post">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
