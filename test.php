<?php
require 'Database.php';

$db = new Database();
$conn = $db->connect();

if($conn) {
    echo "Database connected successfully!";
} else {
    echo "Connection failed!";
}
?>