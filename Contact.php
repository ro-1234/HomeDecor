<?php
require "database.php";

$success = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if(!$name || !$email || !$subject || !$message){
        $error = "All fields are required";
    } else {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO contacts (name, email, subject, message) 
                  VALUES (:name, :email, :subject, :message)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":message", $message);

        if($stmt->execute()){
            $success = "Message sent successfully!";
        } else {
            $error = "Something went wrong!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Contact us page for a furniture website" />
  <title>Contact Us | Elegant Furniture</title>
  <link rel="stylesheet" href="contact.css" />
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
  <main class="page">
    <section class="info-panel">
      <h1>Contact Us</h1>
      <p>
        Have questions about our furniture collection, custom orders, or interior styling?
        Our team is here to help you create the perfect space.
      </p>

      <div class="contact-details">
        <div><strong>Address:</strong> Dardania Street, Gjakova</div>
        <div><strong>Phone:</strong> +383 44 123 456</div>
        <div><strong>Email:</strong> info@elegantfurniture.com</div>
      </div>
    </section>

    <section class="form-panel">
     <form class="contact-form" action="contact.php" method="post">
  <h2>Send a Message</h2>

  <?php if(!empty($success)): ?>
    <p style="color:green;"><?php echo $success; ?></p>
  <?php endif; ?>

  <?php if(!empty($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
  <?php endif; ?>

  <div class="form-grid">
    <div class="field">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required />
    </div>

    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />
    </div>

    <div class="field full">
      <label for="subject">Subject</label>
      <input type="text" id="subject" name="subject" required />
    </div>

    <div class="field full">
      <label for="message">Message</label>
      <textarea id="message" name="message" required></textarea>
    </div>
  </div>

  <button type="submit">Send Message</button>
</form>
    </section>
  </main>
  <footer class="footer">
  <div class="footer-container">
    <!-- Brand / About -->
    <div class="footer-column">
      <h3>HomeDecor</h3>
      <p>Elegant furniture & decor for the modern home. Crafted with quality and care.</p>
    </div>

    <!-- Quick Links -->
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
</body>
</html>