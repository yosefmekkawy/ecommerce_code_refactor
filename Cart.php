<?php
class Cart extends BaseModel {
    protected $table_name = "cart";

    public function addProduct($user_id, $product_id, $quantity = 1) {
        $query = "SELECT quantity FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = "UPDATE " . $this->table_name . " SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id";
        } else {
            $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }
    public function getAll($user_id = null) {
        if ($user_id) {
            $query = "SELECT c.id as cart_id, c.quantity as cart_quantity, 
                             p.id as product_id, p.title, p.description, p.quantity as product_quantity, p.image 
                      FROM " . $this->table_name . " c
                      JOIN products p ON c.product_id = p.id
                      WHERE c.user_id = :user_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        } else {
            $query = "SELECT c.id as cart_id, c.quantity as cart_quantity, 
                             p.id as product_id, p.title, p.description, p.quantity as product_quantity, p.image, 
                             u.id as user_id, u.username 
                      FROM " . $this->table_name . " c
                      JOIN products p ON c.product_id = p.id
                      JOIN users u ON c.user_id = u.id";

            $stmt = $this->db->prepare($query);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
