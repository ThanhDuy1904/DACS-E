<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'app/config/database.php';

class DashboardCustomerController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy thống kê khách hàng
        $customerStats = $this->getCustomerStats();
        
        // Lấy danh sách khách hàng từ đơn hàng
        $allCustomers = $this->getAllCustomers();
        
        // Lấy top khách hàng
        $topCustomers = $this->getTopCustomers();

        require 'app/views/dashboard/customer.php';
    }

    private function getCustomerStats() {
        try {
            $stats = [];

            // Tổng số khách hàng duy nhất (từ đơn hàng)
            $query = "SELECT COUNT(DISTINCT CASE WHEN customer_name IS NOT NULL AND customer_name != '' THEN customer_name END) as total_customers FROM orders";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_customers'];

            // Tổng số đơn hàng có tên khách
            $query = "SELECT COUNT(*) as orders_with_customers FROM orders WHERE customer_name IS NOT NULL AND customer_name != ''";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['orders_with_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['orders_with_customers'];

            // Đơn hàng khách vãng lai
            $query = "SELECT COUNT(*) as guest_orders FROM orders WHERE customer_name IS NULL OR customer_name = ''";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['guest_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['guest_orders'];

            // Khách hàng thân thiết (có từ 3 đơn trở lên)
            $query = "SELECT COUNT(*) as loyal_customers FROM (
                        SELECT customer_name, COUNT(*) as order_count 
                        FROM orders 
                        WHERE customer_name IS NOT NULL AND customer_name != '' 
                        GROUP BY customer_name 
                        HAVING order_count >= 3
                      ) as loyal";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['loyal_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['loyal_customers'];

            return $stats;

        } catch (PDOException $e) {
            error_log("Error in getCustomerStats: " . $e->getMessage());
            return [
                'total_customers' => 0,
                'orders_with_customers' => 0,
                'guest_orders' => 0,
                'loyal_customers' => 0
            ];
        }
    }

    private function getAllCustomers() {
        try {
            $query = "SELECT 
                        o.customer_name,
                        o.phone,
                        COUNT(DISTINCT o.id) as order_count,
                        COALESCE(SUM(od.price * od.quantity), 0) as total_spent,
                        MAX(o.created_at) as last_order,
                        MIN(o.created_at) as first_order
                      FROM orders o
                      LEFT JOIN order_details od ON o.id = od.order_id
                      WHERE o.customer_name IS NOT NULL AND o.customer_name != ''
                      GROUP BY o.customer_name, o.phone
                      ORDER BY total_spent DESC, order_count DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getAllCustomers: " . $e->getMessage());
            return [];
        }
    }

    private function getTopCustomers() {
        try {
            $query = "SELECT 
                        o.customer_name,
                        o.phone,
                        COUNT(DISTINCT o.id) as order_count,
                        COALESCE(SUM(od.price * od.quantity), 0) as total_spent
                      FROM orders o
                      LEFT JOIN order_details od ON o.id = od.order_id
                      WHERE o.customer_name IS NOT NULL AND o.customer_name != ''
                      GROUP BY o.customer_name, o.phone
                      ORDER BY total_spent DESC
                      LIMIT 10";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getTopCustomers: " . $e->getMessage());
            return [];
        }
    }
}
?>
