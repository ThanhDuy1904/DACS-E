<?php
require_once 'app/config/database.php';

class DiscountModel {
    private $conn;
    private $table_name = "Discount";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllDiscounts() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDiscountByCode($maDiscount) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE maDiscount = :maDiscount LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maDiscount', $maDiscount);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createDiscount($maDiscount, $tenDiscount) {
        $query = "INSERT INTO " . $this->table_name . " (maDiscount, tenDiscount) VALUES (:maDiscount, :tenDiscount)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maDiscount', $maDiscount);
        $stmt->bindParam(':tenDiscount', $tenDiscount);
        return $stmt->execute();
    }

    public function deleteDiscount($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
