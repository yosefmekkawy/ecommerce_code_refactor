<?php
class Order extends BaseModel {

    public function getAll() {
        $stmt = $this->db->query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserOrders($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
