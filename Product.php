<?php
class Product extends BaseModel {
    protected $table_name = "products";

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM " . $this->table_name);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($product_id) {
        $query = "SELECT p.id, p.title, p.description, p.quantity, p.image, c.name as category
                  FROM " . $this->table_name . " p
                  JOIN categories c ON p.category = c.id
                  WHERE p.id = :product_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
