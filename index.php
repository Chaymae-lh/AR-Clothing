<?php
include 'includes/config.php';
include 'includes/header.php';

$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
?>

<section class="hero" id="hero">
  <div class="hero-overlay">
    <img src="images/logo.jpeg" class="logo">
    <h1>AR Clothing</h1>
    <p>Style jeune • ستايل شبابي</p>
    <a href="#products" class="btn">Shop Now</a>
  </div>
</section>
<section>
  <div class="header-search">
    <input type="text" id="searchInput" placeholder="Search...">
  </div>
</section>    
<section class="categories">
  <div class="cat" onclick="showAll()">ALL</div>
  <div class="cat" onclick="filterCategory('jeans')">Jeans</div>
  <div class="cat" onclick="filterCategory('Tracksuits')">Tracksuits</div>
  <div class="cat" onclick="filterCategory('hoodies')">hoodies</div>
  <div class="cat" onclick="filterCategory('jackets')">Jackets</div>
  <div class="cat" onclick="filterCategory('Sneakers')">Sneakers</div>
  <div class="cat" onclick="filterCategory('T-shirts')">T-shirts</div>
  <div class="cat" onclick="filterCategory('shorts')">Shorts</div>
  <div class="cat" onclick="filterCategory('Outfits')">Outfits</div>
</section>

<p class="counter"> products: <span id="count">0</span></p>

<section class="products" id="products">
<?php foreach($products as $p): ?>
  <div class="product" data-category="<?= $p['category'] ?>">
    <?php if($p['old_price'] > 0): ?>
      <span class="badge">NEW</span>
    <?php endif; ?>
    <img src="uploads/<?= $p['image'] ?>" alt="<?= $p['name'] ?>">
    <h3><?= htmlspecialchars($p['name']) ?></h3>
    <p>
      <?php if($p['old_price'] > 0): ?>
        <del><?= $p['old_price'] ?> MAD</del>
      <?php endif; ?>
      <strong><?= $p['price'] ?> MAD</strong>
    </p>
    <a href="product.php?id=<?= $p['id'] ?>" class="btn">View product</a>
  </div>
<?php endforeach; ?>
</section>

<?php include 'includes/footer.php'; ?>
