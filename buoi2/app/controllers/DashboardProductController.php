<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

class DashboardProductController {
    private $conn;
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->productModel = new ProductModel($this->conn);
        $this->categoryModel = new CategoryModel($this->conn);
    }

    public function index() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        // Lấy thống kê sản phẩm
        $productStats = $this->getProductStats();
        
        // Lấy tất cả sản phẩm với thông tin bán hàng
        $allProducts = $this->getAllProductsWithSales();
        
        // Lấy sản phẩm sắp hết hàng (nếu có)
        $lowStockProducts = $this->getLowStockProducts();
        
        require_once 'app/views/dashboard/product.php';
    }

    public function add() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $categoryId = intval($_POST['category_id'] ?? 0);
            
            // Xử lý upload ảnh
            $imagePath = $this->handleImageUpload();
            
            if ($name && $price > 0 && $categoryId > 0) {
                if ($this->addProductToDatabase($name, $description, $price, $categoryId, $imagePath)) {
                    $_SESSION['success_message'] = 'Sản phẩm đã được thêm thành công.';
                    header("Location: /buoi2/DashboardProduct/index");
                    exit;
                } else {
                    $error = "Có lỗi xảy ra khi thêm sản phẩm!";
                }
            } else {
                $error = "Vui lòng điền đầy đủ thông tin!";
            }
        }
        
        $categories = $this->categoryModel->getCategories();
        require_once 'app/views/dashboard/product_add.php';
    }

    public function edit() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        $productId = intval($_GET['id'] ?? 0);
        if (!$productId) {
            $_SESSION['error_message'] = 'Không tìm thấy sản phẩm.';
            header("Location: /buoi2/DashboardProduct/index");
            exit;
        }

        $product = $this->getProductById($productId);
        if (!$product) {
            $_SESSION['error_message'] = 'Không tìm thấy sản phẩm.';
            header("Location: /buoi2/DashboardProduct/index");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $categoryId = intval($_POST['category_id'] ?? 0);
            
            // Xử lý upload ảnh mới (nếu có)
            $imagePath = $this->handleImageUpload();
            if (!$imagePath) {
                $imagePath = $product['image']; // Giữ ảnh cũ
            }
            
            if ($name && $price > 0 && $categoryId > 0) {
                if ($this->updateProductInDatabase($productId, $name, $description, $price, $categoryId, $imagePath)) {
                    $_SESSION['success_message'] = 'Sản phẩm đã được cập nhật thành công.';
                    header("Location: /buoi2/DashboardProduct/index");
                    exit;
                } else {
                    $error = "Có lỗi xảy ra khi cập nhật sản phẩm!";
                }
            } else {
                $error = "Vui lòng điền đầy đủ thông tin!";
            }
        }
        
        $categories = $this->categoryModel->getCategories();
        require_once 'app/views/dashboard/product_edit.php';
    }

    public function delete() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productId = intval($_POST['id']);
            
            if ($this->deleteProductFromDatabase($productId)) {
                $_SESSION['success_message'] = 'Sản phẩm đã được xóa thành công.';
            } else {
                $_SESSION['error_message'] = 'Không thể xóa sản phẩm.';
            }
        }
        
        header("Location: /buoi2/DashboardProduct/index");
        exit;
    }

    public function toggleVisibility() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Phương thức không được phép']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $productId = intval($input['product_id'] ?? 0);
        $hidden = $input['hidden'] ?? false;

        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
            exit;
        }

        // Đảm bảo cột hidden tồn tại
        $this->ensureHiddenColumnExists();

        try {
            $query = "UPDATE product SET hidden = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$hidden ? 1 : 0, $productId]);

            if ($result) {
                echo json_encode([
                    'success' => true, 
                    'message' => $hidden ? 'Sản phẩm đã được ẩn' : 'Sản phẩm đã được hiện'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể cập nhật sản phẩm']);
            }
        } catch (PDOException $e) {
            error_log("Lỗi trong toggleVisibility: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi cơ sở dữ liệu']);
        }
        exit;
    }

    private function ensureHiddenColumnExists() {
        try {
            // Kiểm tra xem cột hidden có tồn tại không
            $query = "SHOW COLUMNS FROM product LIKE 'hidden'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                // Thêm cột hidden nếu chưa có
                $query = "ALTER TABLE product ADD COLUMN hidden TINYINT(1) DEFAULT 0";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            error_log("Lỗi khi tạo cột hidden: " . $e->getMessage());
        }
    }

    private function getProductStats() {
        try {
            $stats = [];

            // Tổng số sản phẩm
            $query = "SELECT COUNT(*) as total_products FROM product";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];

            // Số danh mục có sản phẩm
            $query = "SELECT COUNT(DISTINCT p.category_id) as active_categories 
                      FROM product p 
                      INNER JOIN category c ON p.category_id = c.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['active_categories'] = $stmt->fetch(PDO::FETCH_ASSOC)['active_categories'];

            return $stats;

        } catch (PDOException $e) {
            error_log("Error in getProductStats: " . $e->getMessage());
            return [
                'total_products' => 0,
                'active_categories' => 0
            ];
        }
    }

    private function getAllProductsWithSales() {
        try {
            // Đảm bảo cột hidden tồn tại
            $this->ensureHiddenColumnExists();

            $query = "SELECT p.id, p.name, p.price, p.image, p.description, p.category_id,
                             COALESCE(p.hidden, 0) as hidden,
                             c.name as category_name,
                             COALESCE(SUM(od.quantity), 0) as total_sold,
                             COALESCE(SUM(od.price * od.quantity), 0) as total_revenue,
                             COUNT(DISTINCT od.order_id) as order_count
                      FROM product p
                      LEFT JOIN category c ON p.category_id = c.id
                      LEFT JOIN order_details od ON p.id = od.product_id
                      GROUP BY p.id, p.name, p.price, p.image, p.description, p.category_id, p.hidden, c.name
                      ORDER BY p.hidden ASC, p.name ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Lỗi trong getAllProductsWithSales: " . $e->getMessage());
            return [];
        }
    }

    private function getLowStockProducts($threshold = 10) {
        try {
            // Kiểm tra xem table có cột quantity không
            $query = "SHOW COLUMNS FROM product LIKE 'quantity'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $query = "SELECT p.id, p.name, p.price, p.image, p.quantity,
                                 c.name as category_name
                          FROM product p
                          LEFT JOIN category c ON p.category_id = c.id
                          WHERE p.quantity <= ? AND p.quantity > 0
                          ORDER BY p.quantity ASC
                          LIMIT 10";
                
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(1, $threshold, PDO::PARAM_INT);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return [];

        } catch (PDOException $e) {
            error_log("Error in getLowStockProducts: " . $e->getMessage());
            return [];
        }
    }

    private function getProductById($productId) {
        try {
            $query = "SELECT * FROM product WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$productId]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getProductById: " . $e->getMessage());
            return null;
        }
    }

    private function addProductToDatabase($name, $description, $price, $categoryId, $imagePath) {
        try {
            $query = "INSERT INTO product (name, description, price, category_id, image, created_at) 
                      VALUES (?, ?, ?, ?, ?, NOW())";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$name, $description, $price, $categoryId, $imagePath]);

        } catch (PDOException $e) {
            error_log("Error in addProductToDatabase: " . $e->getMessage());
            return false;
        }
    }

    private function updateProductInDatabase($productId, $name, $description, $price, $categoryId, $imagePath) {
        try {
            $query = "UPDATE product SET name = ?, description = ?, price = ?, category_id = ?, image = ? WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$name, $description, $price, $categoryId, $imagePath, $productId]);

        } catch (PDOException $e) {
            error_log("Error in updateProductInDatabase: " . $e->getMessage());
            return false;
        }
    }

    private function deleteProductFromDatabase($productId) {
        try {
            // Xóa ảnh cũ nếu có
            $product = $this->getProductById($productId);
            if ($product && !empty($product['image'])) {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/buoi2/' . $product['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $query = "DELETE FROM product WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$productId]);

        } catch (PDOException $e) {
            error_log("Error in deleteProductFromDatabase: " . $e->getMessage());
            return false;
        }
    }

    private function handleImageUpload() {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return '';
        }

        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/buoi2/uploads/products/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['image']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            return '';
        }

        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            return 'uploads/products/' . $fileName;
        }

        return '';
    }
}