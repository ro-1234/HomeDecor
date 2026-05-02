<?php
session_start();

require "database.php";
require "users.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(empty($name) || empty($username) || empty($email) || empty($password)){
        echo "All fields are required";
        exit;
    }

    $db = (new Database())->getConnection();
    $user = new Users($db);

    $result = $user->register($name, $username, $email, $password, "user");

    if($result === true){
        echo "success";
    } else {
        echo $result;
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="register.css">
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

  <!-- LEFT SIDE -->
  <div class="left">
    <div class="text">
      <h1>Create Account</h1>
      <p>Welcome</p>
      <h2>Join us and start your journey!</h2>
    </div>

    <form id="registerForm" method="POST" action="register.php">

      <div class="input-box">
        <input type="text" name="name" id="name" placeholder="Full Name">
      </div>

      <div class="input-box">
        <input type="text" name="username" id="username" placeholder="Username">
      </div>

      <div class="input-box">
        <input type="email" name="email" id="email" placeholder="Email">
      </div>

      <div class="input-box">
        <input type="password" name="password" id="password" placeholder="Password">
      </div>

      <button type="submit">Create Account</button>

      <div id="error" style="color:red; margin-top:10px;"></div>

    </form>

    <p style="margin-top:15px;">
      Already have an account?
      <a href="login.php">Login</a>
    </p>

  </div>

  <!-- RIGHT SIDE -->
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

<script src="register.js"></script>
</body>
</html>