<?php
class User extends BaseModel {

    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email AND pass = :password";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkEmailExists($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($username, $email, $password, $phone) {
        $sql = "INSERT INTO users (username, email, pass, phone, type) VALUES (:username, :email, :password, :phone, 'client')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone
        ]);
        return $this->checkEmailExists($email);
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
