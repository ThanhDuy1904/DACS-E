<?php
require_once 'app/config/database.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/ProductModel.php';

class OrderController {
    private $conn;
    private $orderModel;
    private $productModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->orderModel = new OrderModel($this->conn);
        $this->productModel = new ProductModel($this->conn);
    }

    // Trang danh sách đơn hàng, chỉ admin được xem
    public function index() {
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'employee'])) {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy tất cả tham số lọc từ GET request
        $filters = [
            'keyword' => $_GET['keyword'] ?? '',
            'date_filter' => $_GET['date_filter'] ?? '',
            'from_date' => $_GET['from_date'] ?? '',
            'to_date' => $_GET['to_date'] ?? '',
            'time_filter' => $_GET['time_filter'] ?? '',
            'payment_filter' => $_GET['payment_filter'] ?? ''
        ];

        // Xử lý bộ lọc ngày
        $dateConditions = $this->processDateFilter($filters);
        
        // Gộp tất cả điều kiện lọc
        $searchParams = array_merge($filters, $dateConditions);

        // Lấy đơn hàng theo bộ lọc
        if (!empty(array_filter($searchParams))) {
            $orders = $this->orderModel->searchOrdersWithFilters($searchParams);
        } else {
            $orders = $this->orderModel->getOrders();
        }

        // Lấy chi tiết đơn hàng cho mỗi đơn hàng
        foreach ($orders as &$order) {
            $order['details'] = $this->orderModel->getOrderDetails($order['id']);
        }
        unset($order);

        require 'app/views/order/list.php';
    }

    // Xử lý bộ lọc ngày
    private function processDateFilter($filters) {
        $dateConditions = [];
        
        switch ($filters['date_filter']) {
            case 'today':
                $dateConditions['date_from'] = date('Y-m-d');
                $dateConditions['date_to'] = date('Y-m-d');
                break;
                
            case 'yesterday':
                $yesterday = date('Y-m-d', strtotime('-1 day'));
                $dateConditions['date_from'] = $yesterday;
                $dateConditions['date_to'] = $yesterday;
                break;
                
            case '7days':
                $dateConditions['date_from'] = date('Y-m-d', strtotime('-7 days'));
                $dateConditions['date_to'] = date('Y-m-d');
                break;
                
            case '30days':
                $dateConditions['date_from'] = date('Y-m-d', strtotime('-30 days'));
                $dateConditions['date_to'] = date('Y-m-d');
                break;
                
            case 'custom':
                if (!empty($filters['from_date'])) {
                    $dateConditions['date_from'] = $filters['from_date'];
                }
                if (!empty($filters['to_date'])) {
                    $dateConditions['date_to'] = $filters['to_date'];
                }
                break;
        }
        
        return $dateConditions;
    }

    // Trang chỉnh sửa đơn hàng
    public function edit() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        $orderId = $_GET['id'] ?? null;
        
        if (!$orderId) {
            $_SESSION['error_message'] = 'Không tìm thấy đơn hàng.';
            header("Location: /buoi2/Order/index");
            exit;
        }

        $order = $this->orderModel->getOrderById($orderId);
        if (!$order) {
            $_SESSION['error_message'] = 'Không tìm thấy đơn hàng.';
            header("Location: /buoi2/Order/index");
            exit;
        }

        $order['details'] = $this->orderModel->getOrderDetails($orderId);
        
        // Lấy danh sách sản phẩm để hiển thị trong form thêm sản phẩm
        $products = $this->productModel->getProducts();
        
        require 'app/views/order/edit.php';
    }

    // Cập nhật đơn hàng
    public function updateOrder() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /buoi2/Order/index");
            exit;
        }

        $orderId = $_POST['order_id'] ?? null;
        $customerName = $_POST['customer_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? '';
        $products = $_POST['products'] ?? [];
        $newProducts = $_POST['new_products'] ?? [];

        if (!$orderId) {
            $_SESSION['error_message'] = 'Không tìm thấy đơn hàng.';
            header("Location: /buoi2/Order/index");
            exit;
        }

        try {
            // Cập nhật thông tin đơn hàng
            $result = $this->orderModel->updateOrder($orderId, $customerName, $phone, $paymentMethod);
            
            if ($result) {
                // Cập nhật chi tiết đơn hàng
                if (!empty($products)) {
                    $this->orderModel->updateOrderDetails($orderId, $products);
                }
                
                // Thêm sản phẩm mới
                if (!empty($newProducts)) {
                    $this->orderModel->addNewOrderDetails($orderId, $newProducts);
                }
                
                $_SESSION['success_message'] = 'Đơn hàng đã được cập nhật thành công.';
            } else {
                $_SESSION['error_message'] = 'Không thể cập nhật đơn hàng.';
            }
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header("Location: /buoi2/Order/edit?id=" . $orderId);
        exit;
    }

    // Xóa đơn hàng
    public function deleteOrder() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
            $orderId = $_POST['order_id'];
            $result = $this->orderModel->deleteOrder($orderId);
            
            if ($result) {
                $_SESSION['success_message'] = 'Đơn hàng đã được xóa thành công.';
            } else {
                $_SESSION['error_message'] = 'Không thể xóa đơn hàng.';
            }
        }
        
        header("Location: /buoi2/Order/index");
        exit;
    }

    // Xóa sản phẩm khỏi đơn hàng
    public function deleteOrderItem() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
            $itemId = $_POST['item_id'];
            $orderId = $_POST['order_id'] ?? '';
            
            $result = $this->orderModel->deleteOrderItem($itemId);
            
            if ($result) {
                $_SESSION['success_message'] = 'Sản phẩm đã được xóa khỏi đơn hàng.';
            } else {
                $_SESSION['error_message'] = 'Không thể xóa sản phẩm.';
            }
            
            if ($orderId) {
                header("Location: /buoi2/Order/edit?id=" . $orderId);
            } else {
                header("Location: /buoi2/Order/index");
            }
        }
        
        exit;
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus() {
        // Kiểm tra đăng nhập và quyền truy cập
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || 
            ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];
            $result = $this->orderModel->updateOrderStatus($orderId, $status);
            
            if ($result) {
                $_SESSION['success_message'] = 'Trạng thái đơn hàng đã được cập nhật.';
            } else {
                $_SESSION['error_message'] = 'Không thể cập nhật trạng thái đơn hàng.';
            }
        }
        
        header("Location: /buoi2/Order/index");
        exit;
    }

    // Xem chi tiết đơn hàng
    public function view() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        $orderId = $_GET['id'] ?? null;
        
        if (!$orderId) {
            header("Location: /buoi2/Order/index");
            exit;
        }

        $order = $this->orderModel->getOrderById($orderId);
        if (!$order) {
            $_SESSION['error_message'] = 'Không tìm thấy đơn hàng.';
            header("Location: /buoi2/Order/index");
            exit;
        }

        $order['details'] = $this->orderModel->getOrderDetails($orderId);
        
        require 'app/views/order/view.php';
    }

    // API endpoint để lấy thống kê đơn hàng
    public function getOrderStats() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }

        header('Content-Type: application/json');
        
        try {
            $stats = $this->orderModel->getOrderStatistics();
            echo json_encode($stats);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Không thể lấy thống kê đơn hàng']);
        }
        exit;
    }

    

   
    // Tìm kiếm đơn hàng nâng cao
    public function search() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        $searchParams = [
            'keyword' => $_GET['keyword'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'payment_method' => $_GET['payment_method'] ?? '',
            'user_id' => $_GET['user_id'] ?? ''
        ];

        $orders = $this->orderModel->searchOrdersAdvanced($searchParams);
        
        // Lấy chi tiết đơn hàng cho mỗi đơn hàng
        foreach ($orders as &$order) {
            $order['details'] = $this->orderModel->getOrderDetails($order['id']);
        }
        unset($order);

        // Lấy danh sách nhân viên để hiển thị trong form tìm kiếm
        $employees = $this->orderModel->getEmployees();

        require 'app/views/order/search.php';
    }

    // Áp dụng giảm giá cho đơn hàng
    public function applyDiscountToOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $orderId = $_POST['order_id'] ?? null;
        $discountCode = $_POST['discount_code'] ?? '';
        $discountAmount = floatval($_POST['discount_amount'] ?? 0);

        if ($orderId && $discountAmount > 0) {
            $success = $this->orderModel->applyDiscount($orderId, $discountCode, $discountAmount);
            if ($success) {
                header('Location: /buoi2/buoi2/Order/index?success=discount_applied');
                exit;
            }
        }
        
        header('Location: /buoi2/buoi2/Order/index?error=discount_failed');
        exit;
    }

    // Xuất đơn hàng ra định dạng Word
    public function exportToWord($orderId) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy thông tin đơn hàng
        $order = $this->orderModel->getOrderById($orderId);
        if (!$order) {
            $_SESSION['error_message'] = 'Không tìm thấy đơn hàng.';
            header("Location: /buoi2/Order/index");
            exit;
        }

        $order['details'] = $this->orderModel->getOrderDetails($orderId);

        // Thiết lập header cho file Word
        header("Content-Type: application/vnd.ms-word");
        header("Content-Disposition: attachment; filename=don-hang-" . $orderId . ".doc");

        // Nạp template Word
        require 'app/views/order/word_template.php';
        exit;
    }
}