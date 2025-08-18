<?php
require_once 'app/config/database.php';
require_once 'app/models/DiscountModel.php';

class DiscountController {
    private $conn;
    private $discountModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->discountModel = new DiscountModel($this->conn);
    }

    // Danh sách Discount
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        $discounts = $this->discountModel->getAllDiscounts();
        require_once 'app/views/discount/list.php';
    }

    // Thêm Discount mới
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maDiscount = $_POST['maDiscount'] ?? '';
            $tenDiscount = $_POST['tenDiscount'] ?? '';
            if ($maDiscount && $tenDiscount) {
                $this->discountModel->createDiscount($maDiscount, $tenDiscount);
            }
            header("Location: /buoi2/Discount/index");
            exit;
        }
        require_once 'app/views/discount/add.php';
    }

    // Xóa Discount
    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            if ($id) {
                $this->discountModel->deleteDiscount($id);
            }
            header("Location: /buoi2/Discount/index");
            exit;
        }
    }
}
?>
