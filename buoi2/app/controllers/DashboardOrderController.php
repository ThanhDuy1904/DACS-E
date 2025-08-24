<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'app/config/database.php';
require_once 'app/models/OrderModel.php';

class DashboardOrderController {
    private $conn;
    private $orderModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->orderModel = new OrderModel($this->conn);
    }

    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        try {
            // Lấy thống kê đơn hàng từ OrderModel
            $orderStats = $this->orderModel->getOrderStatistics();
            
            // Lấy tất cả đơn hàng từ OrderModel
            $allOrders = $this->orderModel->getOrders();
            
            // Tính toán tổng tiền và số lượng món cho mỗi đơn hàng
            foreach ($allOrders as &$order) {
                $details = $this->orderModel->getOrderDetails($order['id']);
                $totalAmount = 0;
                $itemCount = 0;
                
                foreach ($details as $detail) {
                    $totalAmount += ($detail['price'] * $detail['quantity']);
                    $itemCount += $detail['quantity'];
                }
                
                // Trừ discount_amount
                $discountAmount = floatval($order['discount_amount'] ?? 0);
                $order['total_amount'] = $totalAmount - $discountAmount;
                $order['item_count'] = $itemCount;
            }
            unset($order);
            
            // Lấy thống kê theo trạng thái
            $statusStats = $this->getStatusStats();

            require 'app/views/dashboard/order.php';
            
        } catch (Exception $e) {
            error_log("Error in DashboardOrderController::index: " . $e->getMessage());
            
            // Khởi tạo dữ liệu mặc định nếu có lỗi
            $orderStats = [
                'total_orders' => 0,
                'total_revenue' => 0,
                'today_orders' => 0,
                'today_revenue' => 0
            ];
            $allOrders = [];
            $statusStats = [];
            
            require 'app/views/dashboard/order.php';
        }
    }

    private function getStatusStats() {
        try {
            $query = "SELECT status, COUNT(*) as count FROM orders GROUP BY status ORDER BY count DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getStatusStats: " . $e->getMessage());
            return [];
        }
    }

    private function getOrderStatistics() {
        try {
            $stats = [];
            
            // Tổng số đơn hàng (bao gồm cả đã hủy)
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total_orders FROM orders");
            $stmt->execute();
            $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'] ?? 0;
            
            // Tổng doanh thu (chỉ tính đơn hàng không bị hủy) - CÔNG THỨC ĐỒNG NHẤT
            $stmt = $this->conn->prepare("
                SELECT COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as total_revenue
                FROM order_details od
                INNER JOIN orders o ON od.order_id = o.id
                WHERE o.status != 'Đã hủy'
            ");
            $stmt->execute();
            $stats['total_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;
            
            // Đơn hàng hôm nay (bao gồm cả đã hủy)
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) as today_orders
                FROM orders
                WHERE DATE(created_at) = CURDATE()
            ");
            $stmt->execute();
            $stats['today_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['today_orders'] ?? 0;
            
            // Doanh thu hôm nay (chỉ tính đơn hàng không bị hủy) - CÔNG THỨC ĐỒNG NHẤT
            $stmt = $this->conn->prepare("
                SELECT COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as today_revenue
                FROM order_details od
                INNER JOIN orders o ON od.order_id = o.id
                WHERE DATE(o.created_at) = CURDATE() AND o.status != 'Đã hủy'
            ");
            $stmt->execute();
            $stats['today_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['today_revenue'] ?? 0;
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error in getOrderStatistics: " . $e->getMessage());
            return [
                'total_orders' => 0,
                'total_revenue' => 0,
                'today_orders' => 0,
                'today_revenue' => 0
            ];
        }
    }

    private function getAllOrdersWithDetails() {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    o.id,
                    o.customer_name,
                    o.phone,
                    o.status,
                    o.created_at,
                    o.cancel_reason,
                    COUNT(od.id) as item_count,
                    COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(o.discount_amount, 0) as total_amount
                FROM orders o
                LEFT JOIN order_details od ON o.id = od.order_id
                GROUP BY o.id, o.customer_name, o.phone, o.status, o.created_at, o.cancel_reason, o.discount_amount
                ORDER BY o.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllOrdersWithDetails: " . $e->getMessage());
            return [];
        }
    }
}
?>
