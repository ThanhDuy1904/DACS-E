<?php
require_once 'app/config/database.php';

class DiscountModel {
    private $conn;
    private $tableName;

    public function __construct($db) {
        $this->conn = $db;
        $this->tableName = $this->findDiscountTable();
    }

    /**
     * Tìm tên bảng discount thực tế trong database
     */
    private function findDiscountTable() {
        $possibleTableNames = ['discount', 'Discount', 'promotion', 'promotions'];
        
        foreach ($possibleTableNames as $tableName) {
            try {
                $query = "SELECT 1 FROM `{$tableName}` LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return $tableName; // Tìm thấy bảng
            } catch (PDOException $e) {
                continue; // Bảng không tồn tại, thử tiếp
            }
        }
        
        // Mặc định sử dụng 'discount' nếu không tìm thấy
        return 'discount';
    }

    public function getAllDiscounts() {
        try {
            $query = "SELECT * FROM `{$this->tableName}` ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $discounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("DiscountModel: Found " . count($discounts) . " discounts from table: {$this->tableName}");
            
            return $discounts;
        } catch (PDOException $e) {
            error_log("Error in getAllDiscounts: " . $e->getMessage());
            return [];
        }
    }

    public function getDiscountByCode($code) {
        try {
            $query = "SELECT * FROM `{$this->tableName}` WHERE maDiscount = :code";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getDiscountByCode: " . $e->getMessage());
            return null;
        }
    }

    public function createDiscount($maDiscount, $tenDiscount) {
        try {
            // Kiểm tra xem bảng có cột created_at không
            $hasCreatedAt = $this->hasCreatedAtColumn();
            
            if ($hasCreatedAt) {
                $query = "INSERT INTO `{$this->tableName}` (maDiscount, tenDiscount, created_at) VALUES (:maDiscount, :tenDiscount, NOW())";
            } else {
                $query = "INSERT INTO `{$this->tableName}` (maDiscount, tenDiscount) VALUES (:maDiscount, :tenDiscount)";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':maDiscount', $maDiscount);
            $stmt->bindParam(':tenDiscount', $tenDiscount);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in createDiscount: " . $e->getMessage());
            return false;
        }
    }

    public function deleteDiscount($id) {
        try {
            $query = "DELETE FROM `{$this->tableName}` WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deleteDiscount: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Kiểm tra xem bảng có cột created_at không
     */
    private function hasCreatedAtColumn() {
        try {
            $query = "SHOW COLUMNS FROM `{$this->tableName}` LIKE 'created_at'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
