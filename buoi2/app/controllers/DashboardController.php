<?php
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/models/CustomerModel.php';

class DashboardController {
    private $conn;
    private $userModel;
    private $orderModel;
    private $productModel;
    private $categoryModel;
    private $customerModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->userModel = new UserModel($this->conn);
        $this->orderModel = new OrderModel($this->conn);
        $this->productModel = new ProductModel($this->conn);
        $this->categoryModel = new CategoryModel($this->conn);
        $this->customerModel = new CustomerModel($this->conn);
    }

    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy thống kê tổng quan
        $stats = $this->getGeneralStats();
        
        // Lấy thống kê theo thời gian
        $timeStats = $this->getTimeStats();
        
        // Lấy top sản phẩm bán chạy
        $topProducts = $this->getTopProducts();
        
        // Lấy đơn hàng gần đây
        $recentOrders = $this->getRecentOrders();

        require 'app/views/dashboard/index.php';
    }

    // API endpoint để lấy dữ liệu thống kê cho biểu đồ
    public function getStatsApi() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $type = $_GET['type'] ?? '';
        $period = $_GET['period'] ?? '7days';
        
        header('Content-Type: application/json');
        
        try {
            switch($type) {
                case 'revenue':
                    $data = $this->getRevenueData($period);
                    break;
                default:
                    $data = [];
            }
            
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    private function getRevenueData($period) {
        $sql = "";
        $params = [];
        
        switch($period) {
            case '7days':
                $sql = "SELECT 
                            DATE(o.created_at) as date,
                            COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as revenue
                        FROM orders o
                        LEFT JOIN order_details od ON o.id = od.order_id
                        WHERE o.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        AND o.status != 'Đã hủy'
                        GROUP BY DATE(o.created_at)
                        ORDER BY date ASC";
                break;
                
            case '30days':
                $sql = "SELECT 
                            DATE(o.created_at) as date,
                            COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as revenue
                        FROM orders o
                        LEFT JOIN order_details od ON o.id = od.order_id
                        WHERE o.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                        AND o.status != 'Đã hủy'
                        GROUP BY DATE(o.created_at)
                        ORDER BY date ASC";
                break;
                
            case 'months':
                $sql = "SELECT 
                            DATE_FORMAT(o.created_at, '%Y-%m-01') as date,
                            COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as revenue
                        FROM orders o
                        LEFT JOIN order_details od ON o.id = od.order_id
                        WHERE o.created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                        AND o.status != 'Đã hủy'
                        GROUP BY DATE_FORMAT(o.created_at, '%Y-%m')
                        ORDER BY date ASC";
                break;
                
            default:
                return [];
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->fillMissingDates($results, $period);
    }

    private function fillMissingDates($data, $period) {
        $filledData = [];
        $dataMap = [];
        
        foreach ($data as $item) {
            $dataMap[$item['date']] = $item['revenue'];
        }
        
        switch($period) {
            case '7days':
                for ($i = 6; $i >= 0; $i--) {
                    $date = date('Y-m-d', strtotime("-$i days"));
                    $filledData[] = [
                        'date' => $date,
                        'revenue' => isset($dataMap[$date]) ? $dataMap[$date] : 0
                    ];
                }
                break;
                
            case '30days':
                for ($i = 29; $i >= 0; $i--) {
                    $date = date('Y-m-d', strtotime("-$i days"));
                    $filledData[] = [
                        'date' => $date,
                        'revenue' => isset($dataMap[$date]) ? $dataMap[$date] : 0
                    ];
                }
                break;
                
            case 'months':
                for ($i = 11; $i >= 0; $i--) {
                    $date = date('Y-m-01', strtotime("-$i months"));
                    $filledData[] = [
                        'date' => $date,
                        'revenue' => isset($dataMap[$date]) ? $dataMap[$date] : 0
                    ];
                }
                break;
        }
        
        return $filledData;
    }

    // Lấy thống kê tổng quan - tách riêng đơn hàng hợp lệ và đã hủy
    private function getGeneralStats() {
        $stats = [];
        
        try {
            // Tổng người dùng
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM users");
            $stmt->execute();
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Đơn hàng hợp lệ (không bao gồm đã hủy)
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM orders WHERE status != 'Đã hủy'");
            $stmt->execute();
            $stats['valid_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Đơn hàng đã hủy
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM orders WHERE status = 'Đã hủy'");
            $stmt->execute();
            $stats['cancelled_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Tổng đơn hàng (để tương thích ngược)
            $stats['total_orders'] = $stats['valid_orders'] + $stats['cancelled_orders'];
            
            // Tổng sản phẩm
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM product");
            $stmt->execute();
            $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Tổng danh mục
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM category");
            $stmt->execute();
            $stats['total_categories'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Tổng khách hàng (từ bảng Customer)
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM Customer");
            $stmt->execute();
            $stats['total_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Tổng khuyến mãi
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM discount");
            $stmt->execute();
            $stats['total_promotions'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Tổng doanh thu (chỉ tính đơn hàng không bị hủy)
            $stmt = $this->conn->prepare("
                SELECT COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as total_revenue
                FROM order_details od
                INNER JOIN orders o ON od.order_id = o.id
                WHERE o.status != 'Đã hủy'
            ");
            $stmt->execute();
            $stats['total_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;
            
        } catch (PDOException $e) {
            error_log("Error in getGeneralStats: " . $e->getMessage());
        }
        
        return $stats;
    }

    // Lấy thống kê theo thời gian - loại trừ đơn hàng đã hủy khỏi doanh thu
    private function getTimeStats() {
        $stats = [];
        
        try {
            // Doanh thu hôm nay (chỉ tính đơn hàng không bị hủy)
            $stmt = $this->conn->prepare("
                SELECT COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as today_revenue
                FROM order_details od
                INNER JOIN orders o ON od.order_id = o.id
                WHERE DATE(o.created_at) = CURDATE() AND o.status != 'Đã hủy'
            ");
            $stmt->execute();
            $stats['today_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['today_revenue'] ?? 0;
            
            // Đơn hàng hôm nay (chỉ tính đơn hàng không bị hủy)
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) as today_orders
                FROM orders
                WHERE DATE(created_at) = CURDATE() AND status != 'Đã hủy'
            ");
            $stmt->execute();
            $stats['today_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['today_orders'] ?? 0;
            
            // Đơn hàng tuần này (chỉ tính đơn hàng không bị hủy)
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) as week_orders
                FROM orders
                WHERE WEEK(created_at) = WEEK(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) AND status != 'Đã hủy'
            ");
            $stmt->execute();
            $stats['week_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['week_orders'] ?? 0;
            
            // Đơn hàng tháng này (chỉ tính đơn hàng không bị hủy)
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) as month_orders
                FROM orders
                WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) AND status != 'Đã hủy'
            ");
            $stmt->execute();
            $stats['month_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['month_orders'] ?? 0;
            
        } catch (PDOException $e) {
            error_log("Error in getTimeStats: " . $e->getMessage());
        }
        
        return $stats;
    }

    // Lấy sản phẩm bán chạy - loại trừ đơn hàng đã hủy
    private function getTopProducts() {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    p.id,
                    p.name,
                    p.image,
                    SUM(od.quantity) as total_sold,
                    SUM(od.price * od.quantity) as revenue
                FROM order_details od
                INNER JOIN product p ON od.product_id = p.id
                INNER JOIN orders o ON od.order_id = o.id
                WHERE o.status != 'Đã hủy'
                GROUP BY p.id, p.name, p.image
                ORDER BY total_sold DESC
                LIMIT 5
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getTopProducts: " . $e->getMessage());
            return [];
        }
    }

    // Lấy đơn hàng gần đây - chỉ sử dụng thông tin từ bảng orders
    private function getRecentOrders() {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    o.id,
                    o.status,
                    o.created_at,
                    o.cancel_reason,
                    o.discount_amount,
                    o.customer_name,
                    o.phone,
                    COALESCE(SUM(od.price * od.quantity), 0) as subtotal
                FROM orders o
                LEFT JOIN order_details od ON o.id = od.order_id
                GROUP BY o.id, o.status, o.created_at, o.cancel_reason, o.discount_amount, o.customer_name, o.phone
                ORDER BY o.created_at DESC
                LIMIT 10
            ");
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Tính tổng tiền sau khi trừ discount
            foreach ($orders as &$order) {
                $discountAmount = floatval($order['discount_amount'] ?? 0);
                $order['total_amount'] = $order['subtotal'] - $discountAmount;
            }
            unset($order);
            
            return $orders;
        } catch (PDOException $e) {
            error_log("Error in getRecentOrders: " . $e->getMessage());
            return [];
        }
    }
}
?>