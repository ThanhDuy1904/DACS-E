<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

class DashboardCategoryController {
    private $conn;
    private $categoryModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->categoryModel = new CategoryModel($this->conn);
    }

    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy thống kê danh mục
        $categoryStats = $this->getCategoryStats();
        
        // Lấy tất cả danh mục và convert sang array
        $allCategories = $this->getAllCategoriesAsArray();
        
        // Lấy thống kê sản phẩm theo danh mục
        $productStats = $this->getProductStatsByCategory();

        require 'app/views/dashboard/category.php';
    }

    private function getAllCategoriesAsArray() {
        try {
            $query = "SELECT id, name, description FROM category ORDER BY name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getAllCategoriesAsArray: " . $e->getMessage());
            return [];
        }
    }

    private function getCategoryStats() {
        try {
            $stats = [];

            // Tổng số danh mục
            $query = "SELECT COUNT(*) as total_categories FROM category";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_categories'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_categories'];

            // Tổng số sản phẩm
            $query = "SELECT COUNT(*) as total_products FROM product";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];

            // Danh mục có nhiều sản phẩm nhất
            $query = "SELECT c.name, COUNT(p.id) as product_count 
                      FROM category c 
                      LEFT JOIN product p ON c.id = p.category_id 
                      GROUP BY c.id, c.name 
                      ORDER BY product_count DESC 
                      LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['top_category'] = $result['name'] ?? 'Không có';
            $stats['top_category_count'] = $result['product_count'] ?? 0;

            // Danh mục trống
            $query = "SELECT COUNT(*) as empty_categories 
                      FROM category c 
                      LEFT JOIN product p ON c.id = p.category_id 
                      WHERE p.id IS NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['empty_categories'] = $stmt->fetch(PDO::FETCH_ASSOC)['empty_categories'];

            return $stats;

        } catch (PDOException $e) {
            error_log("Error in getCategoryStats: " . $e->getMessage());
            return [
                'total_categories' => 0,
                'total_products' => 0,
                'top_category' => 'Không có',
                'top_category_count' => 0,
                'empty_categories' => 0
            ];
        }
    }

    private function getProductStatsByCategory() {
        try {
            $query = "SELECT c.name, COUNT(p.id) as product_count 
                      FROM category c 
                      LEFT JOIN product p ON c.id = p.category_id 
                      GROUP BY c.id, c.name 
                      ORDER BY product_count DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getProductStatsByCategory: " . $e->getMessage());
            return [];
        }
    }
}
?>
