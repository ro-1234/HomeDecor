
<?php
session_start();
require_once "database.php";

$db = new Database();
$conn = $db->getConnection();

/* LOGIN CHECK */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

/* ADMIN ONLY */
if($_SESSION['role'] != "admin"){
    die("Access denied");
}

/* ================= PRODUCTS ================= */

/* ADD PRODUCT */
if(isset($_POST['add_product'])){

    $title = $_POST['title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    if($title && $desc && $price){

        $image = null;
        if(!empty($_FILES['image']['name'])){
            $image = "uploads/".basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        $pdf = null;
        if(!empty($_FILES['pdf']['name'])){
            $pdf = "uploads/".basename($_FILES['pdf']['name']);
            move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf);
        }

        $stmt = $conn->prepare("
            INSERT INTO products(title, description, image, pdf, price, created_by)
            VALUES(?,?,?,?,?,?)
        ");

        $stmt->execute([
            $title,
            $desc,
            $image,
            $pdf,
            $price,
            $_SESSION['user_id']
        ]);
    }
}

/* DELETE PRODUCT */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
}

/* EDIT PRODUCT */
if(isset($_POST['edit_product'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $conn->prepare("
        UPDATE products 
        SET title=?, price=? 
        WHERE id=?
    ")->execute([$title,$price,$id]);
}

/* ================= USERS ================= */

/* DELETE USER */
if(isset($_GET['delete_user'])){
    $id = $_GET['delete_user'];
    $conn->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
}

/* ADD USER */
if(isset($_POST['add_user'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if($username && $_POST['password']){
        $conn->prepare("
            INSERT INTO users(username,password,role)
            VALUES(?,?,?)
        ")->execute([$username,$password,$role]);
    }
}

/* ================= CONTACTS ================= */

/* DELETE CONTACT */
if(isset($_GET['delete_contact'])){
    $id = $_GET['delete_contact'];
    $conn->prepare("DELETE FROM contacts WHERE id=?")->execute([$id]);
}

/* ================= DATA ================= */

$users = $conn->query("SELECT * FROM users")->fetchAll();

$products = $conn->query("
SELECT p.*, u.username AS creator
FROM products p
LEFT JOIN users u ON p.created_by = u.id
")->fetchAll();

$contacts = $conn->query("SELECT * FROM contacts")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>
body{margin:0;font-family:Arial;display:flex;background:#f4f4f4;}
.sidebar{width:220px;background:#111;color:white;height:100vh;padding:20px;}
.sidebar h2{color:#00d9ff;}
.sidebar a{display:block;color:white;text-decoration:none;padding:10px 0;}
.sidebar a:hover{color:#00d9ff;}
.main{flex:1;padding:20px;}
.box{background:white;padding:15px;margin-bottom:20px;border-radius:10px;}
input, select{padding:8px;margin:5px 0;width:300px;}
button{padding:8px 15px;background:#00d9ff;border:none;cursor:pointer;}
img{margin-top:5px;}
</style>

</head>
<body>

<div class="sidebar">
<h2>Admin Panel</h2>

<a href="#add">➕ Add Product</a>
<a href="#products">📦 Products</a>
<a href="#users">👤 Users</a>
<a href="#contacts">📩 Contacts</a>
<a href="logout.php">🚪 Logout</a>
</div>

<div class="main">

<h2>Welcome <?= $_SESSION['username'] ?></h2>

<!-- ADD PRODUCT -->
<div class="box" id="add">
<h3>Add Product</h3>

<form method="POST" enctype="multipart/form-data">
<input name="title" placeholder="Title"><br>
<input name="description" placeholder="Description"><br>
<input name="price" placeholder="Price"><br>

Image: <input type="file" name="image"><br>
PDF: <input type="file" name="pdf"><br><br>

<button name="add_product">Add Product</button>
</form>
</div>

<!-- PRODUCTS -->
<div class="box" id="products">
<h3>Products</h3>

<?php foreach($products as $p): ?>
<div style="border-bottom:1px solid #ddd;margin-bottom:10px;">
    <b><?= $p['title'] ?></b> - $<?= $p['price'] ?><br>
    <?= $p['description'] ?><br>
    Created by: <b><?= $p['creator'] ?></b><br>

    <?php if($p['image']): ?>
        <img src="<?= $p['image'] ?>" width="70"><br>
    <?php endif; ?>

    <?php if($p['pdf']): ?>
        <a href="<?= $p['pdf'] ?>" target="_blank">View PDF</a><br>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <input name="title" value="<?= $p['title'] ?>">
        <input name="price" value="<?= $p['price'] ?>">
        <button name="edit_product">Edit</button>
    </form>

    <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete product?')">❌ Delete</a>
</div>
<?php endforeach; ?>

</div>

<!-- USERS -->
<div class="box" id="users">
<h3>Users</h3>

<form method="POST">
<input name="username" placeholder="Username" required>
<input name="password" placeholder="Password" required>

<select name="role">
<option value="user">User</option>
<option value="admin">Admin</option>
</select>

<button name="add_user">➕ Add User</button>
</form>

<hr>

<?php foreach($users as $u): ?>
<div style="margin-bottom:10px;border-bottom:1px solid #ddd;padding:5px;">
<b><?= $u['username'] ?></b> (<?= $u['role'] ?>)

<a href="?delete_user=<?= $u['id'] ?>" 
onclick="return confirm('Delete user?')" 
style="color:red;margin-left:10px;">
❌ Delete
</a>
</div>
<?php endforeach; ?>

</div>

<!-- CONTACTS -->
<div class="box" id="contacts">
<h3>Contacts</h3>

<?php foreach($contacts as $c): ?>
<div style="border-bottom:1px solid #ddd;margin-bottom:10px;">
<b><?= $c['name'] ?></b> (<?= $c['email'] ?>)<br>
<?= $c['message'] ?><br>

<a href="?delete_contact=<?= $c['id'] ?>" 
onclick="return confirm('Delete message?')" 
style="color:red;">
❌ Delete
</a>
</div>
<?php endforeach; ?>

</div>

</div>

</body>
</html>
```
