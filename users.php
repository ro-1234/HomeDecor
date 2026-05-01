<?php

class Users {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // 🔵 REGISTER USER
    public function register($name, $username, $email, $password, $role = "user"){

        $sql = "INSERT INTO users (name, username, email, password, role)
                VALUES (:name, :username, :email, :password, :role)";

        $stmt = $this->conn->prepare($sql);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $role);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // 🔵 LOGIN USER
    public function login($email, $password){

        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){
            return $user; // kthe user-in komplet
        }

        return false;
    }
}
?>