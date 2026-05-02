<?php

class Users {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // REGISTER
    public function register($name, $username, $email, $password, $role = "user"){

        try {

            // kontrollo nëse ekziston user
            $check = "SELECT id FROM users WHERE username = :username OR email = :email";
            $stmt = $this->conn->prepare($check);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if($stmt->fetch()){
                return false; // user ekziston
            }

            $sql = "INSERT INTO users (name, username, email, password, role)
                    VALUES (:name, :username, :email, :password, :role)";

            $stmt = $this->conn->prepare($sql);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":role", $role);

            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    // LOGIN me USERNAME
    public function login($username, $password){

        try {
            $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])){
                return $user;
            }

            return false;

        } catch (PDOException $e) {
            return false;
        }
    }
}