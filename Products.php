<?php
session_start();

require_once "database.php";
require_once "ProductClass.php";

$db = new Database();
$conn = $db->getConnection();

$productObj = new ProductClass($conn);
$products = $productObj->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HomeDecor - Products</title>
  <link rel="stylesheet" href="Products.css">
</head>
<body>

<!-- NAVBAR -->
<nav>
  <div class="logo">HomeDecor</div>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
</nav>

<!-- PRODUCTS GRID -->
<div class="products-grid">

<?php foreach($products as $p): ?>

  <div class="product-card">

    <!-- IMAGE -->
    <img src="<?= $p['image'] ?>" alt="product image">

    <!-- TITLE -->
    <h3><?= htmlspecialchars($p['title']) ?></h3>

    <!-- DESCRIPTION -->
    <p><?= htmlspecialchars($p['description']) ?></p>

    <!-- PRICE -->
    <p class="price">$<?= $p['price'] ?> EUR</p>

  </div>

<?php endforeach; ?>

</div>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-container">

    <div class="footer-column">
      <h3>HomeDecor</h3>
      <p>Elegant furniture & decor for the modern home.</p>
    </div>

    <div class="footer-column">
      <h3>Links</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>

  </div>

  <div class="footer-bottom">
    <p>&copy; 2026 HomeDecor</p>
  </div>
</footer>

</body>
</html>