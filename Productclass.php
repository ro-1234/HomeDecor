<?php

class ProductClass {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔹 GET ALL PRODUCTS
    public function getAll() {

        $query = "
            SELECT p.*, u.username AS creator_name
            FROM products p
            LEFT JOIN users u ON p.created_by = u.id
            ORDER BY p.id DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 ADD PRODUCT
    public function add($title, $description, $image, $pdf, $price, $user_id) {

        $query = "
            INSERT INTO products(title, description, image, pdf, price, created_by)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $title,
            $description,
            $image,
            $pdf,
            $price,
            $user_id
        ]);
    }

    // 🔹 DELETE PRODUCT
    public function delete($id) {

        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // 🔹 UPDATE PRODUCT
    public function update($id, $title, $description, $price) {

        $stmt = $this->conn->prepare("
            UPDATE products
            SET title = ?, description = ?, price = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $title,
            $description,
            $price,
            $id
        ]);
    }
}