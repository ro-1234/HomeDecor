<?php
session_start();

require_once "database.php";
require_once "users.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = (new Database())->getConnection();
    $user = new Users($db);

    $loggedUser = $user->login($username, $password);

    if($loggedUser){

        $_SESSION['user_id'] = $loggedUser['id'];
        $_SESSION['username'] = $loggedUser['username'];
        $_SESSION['role'] = $loggedUser['role'];

       
        $role = strtolower(trim($loggedUser['role'] ?? 'user'));

        exit($role);

    } else {
        exit("error");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<nav>
  <div class="logo">HomeDecor</div>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="Products.php">Products</a></li>
    <li><a href="About.php">About</a></li>
    <li><a href="Contact.php">Contact</a></li>
    <li><a href="blog.php">Blog</a></li>
  </ul>
</nav>

<div class="container">

  <!-- LEFT -->
  <div class="left">
    <div class="text">
      <h1>HomeDecor</h1>
      <p>Welcome</p>
      <h2>Your productivity starts here!</h2>
    </div>

    <form id="loginForm">
      <div class="input-box">
        <input type="text" id="username" placeholder="Username">
      </div>

      <div class="input-box">
        <input type="password" id="password" placeholder="Password">
      </div>

      <button type="submit">Login</button>
      <div id="error" style="color:red; margin-top:10px;"></div>
    </form>

    <p style="margin-top:15px;">
      Don’t have an account? 
      <a href="register.php">Sign up</a>
    </p>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <img src="furniture.jpg" alt="Visual">
  </div>

</div>

<footer class="footer">
  <div class="footer-container">

    <div class="footer-column">
      <h3>HomeDecor</h3>
      <p>Elegant furniture & decor for the modern home. Crafted with quality and care.</p>
    </div>

    <div class="footer-column">
      <h3>Quick Links</h3>
      <ul class="footer-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="Products.php">Products</a></li>
        <li><a href="About.php">About</a></li>
        <li><a href="Contact.php">Contact</a></li>
        <li><a href="blog.php">Blog</a></li>
      </ul>
    </div>

  </div>

  <div class="footer-bottom">
    <p>&copy; 2026 HomeDecor. All rights reserved.</p>
  </div>
</footer>

<script src="login.js"></script>

</body>
</html>