<?php
require_once 'app/config/database.php';
require_once 'app/models/DiscountModel.php';

class DashboardDiscountController {
    private $conn;
    private $discountModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->discountModel = new DiscountModel($this->conn);
    }

    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy thống kê khuyến mãi
        $discountStats = $this->getDiscountStats();
        
        // Lấy tất cả khuyến mãi
        $allDiscounts = $this->getAllDiscounts();

        require 'app/views/dashboard/discount.php';
    }

    private function getDiscountStats() {
        try {
            $stats = [];

            // Thử với các tên bảng có thể có
            $possibleTableNames = ['discount', 'Discount', 'promotion', 'promotions'];
            $stats['total_discounts'] = 0;
            $stats['today_discounts'] = 0;
            
            foreach ($possibleTableNames as $tableName) {
                try {
                    // Tổng số khuyến mãi
                    $query = "SELECT COUNT(*) as total_discounts FROM `{$tableName}`";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($result) {
                        $stats['total_discounts'] = $result['total_discounts'];
                        
                        // Khuyến mãi được tạo hôm nay (nếu có cột created_at)
                        try {
                            $query = "SELECT COUNT(*) as today_discounts FROM `{$tableName}` WHERE DATE(created_at) = CURDATE()";
                            $stmt = $this->conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $stats['today_discounts'] = $result ? $result['today_discounts'] : 0;
                        } catch (PDOException $e) {
                            // Cột created_at không tồn tại
                            $stats['today_discounts'] = 0;
                        }
                        
                        error_log("Found discount table: {$tableName} with {$stats['total_discounts']} records");
                        break; // Tìm thấy bảng, thoát khỏi vòng lặp
                    }
                } catch (PDOException $e) {
                    // Bảng không tồn tại, thử bảng tiếp theo
                    continue;
                }
            }

            return $stats;

        } catch (PDOException $e) {
            error_log("Error in getDiscountStats: " . $e->getMessage());
            return [
                'total_discounts' => 0,
                'today_discounts' => 0
            ];
        }
    }

    private function getAllDiscounts() {
        try {
            $discounts = $this->discountModel->getAllDiscounts();
            
            // Debug log
            error_log("DashboardDiscount: Found " . count($discounts) . " discounts");
            
            return $discounts;
        } catch (Exception $e) {
            error_log("Error in DashboardDiscount getAllDiscounts: " . $e->getMessage());
            return [];
        }
    }

    public function add() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maDiscount = trim($_POST['maDiscount'] ?? '');
            $tenDiscount = trim($_POST['tenDiscount'] ?? '');
            
            if ($maDiscount && $tenDiscount) {
                $existing = $this->discountModel->getDiscountByCode($maDiscount);
                if ($existing) {
                    $error = "Mã khuyến mãi đã tồn tại!";
                } else {
                    if ($this->discountModel->createDiscount($maDiscount, $tenDiscount)) {
                        header("Location: /buoi2/DashboardDiscount/index?success=1");
                        exit;
                    } else {
                        $error = "Có lỗi xảy ra khi tạo khuyến mãi!";
                    }
                }
            } else {
                $error = "Vui lòng điền đầy đủ thông tin!";
            }
        }
        
        require_once 'app/views/dashboard/discount_add.php';
    }

    public function delete() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                $this->discountModel->deleteDiscount($id);
            }
        }
        
        header("Location: /buoi2/DashboardDiscount/index");
        exit;
    }
}
?>
