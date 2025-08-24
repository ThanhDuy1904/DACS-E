<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/models/OrderModel.php';

class ProductDashboardController {
    private $conn;
    private $productModel;
    private $categoryModel;
    private $orderModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->productModel = new ProductModel($this->conn);
        $this->categoryModel = new CategoryModel($this->conn);
        $this->orderModel = new OrderModel($this->conn);
    }

    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy thống kê tổng quan sản phẩm
        $productStats = $this->getProductStats();
        
        // Lấy sản phẩm theo danh mục
        $productsByCategory = $this->getProductsByCategory();
        
        // Lấy tất cả sản phẩm
        $allProducts = $this->getAllProducts();
        
        // Lấy sản phẩm mới nhất
        $latestProducts = $this->getLatestProducts(8);
        
        // Lấy sản phẩm sắp hết hàng (nếu có trường quantity)
        $lowStockProducts = $this->getLowStockProducts();
        
        // Lấy thống kê giá sản phẩm
        $priceStats = $this->getPriceStats();

        require 'app/views/product/dashboard.php';
    }

    private function getProductStats() {
        try {
            $stats = [];

            // Tổng số sản phẩm
            $query = "SELECT COUNT(*) as total_products FROM product";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];

            // Số sản phẩm đã bán
            $query = "SELECT COUNT(DISTINCT od.product_id) as sold_products 
                      FROM order_details od";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['sold_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['sold_products'];

            // Số sản phẩm chưa bán
            $stats['unsold_products'] = $stats['total_products'] - $stats['sold_products'];

            // Tổng số danh mục có sản phẩm
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
                'sold_products' => 0,
                'unsold_products' => 0,
                'active_categories' => 0
            ];
        }
    }

    private function getProductsByCategory() {
        try {
            $query = "SELECT c.name as category_name, c.id as category_id,
                             COUNT(p.id) as product_count,
                             COALESCE(SUM(od.quantity), 0) as total_sold
                      FROM category c
                      LEFT JOIN product p ON c.id = p.category_id
                      LEFT JOIN order_details od ON p.id = od.product_id
                      GROUP BY c.id, c.name
                      ORDER BY product_count DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getProductsByCategory: " . $e->getMessage());
            return [];
        }
    }

    private function getAllProducts() {
        try {
            $query = "SELECT p.id, p.name, p.price, p.image, p.description,
                             c.name as category_name,
                             COALESCE(SUM(od.quantity), 0) as total_sold,
                             COALESCE(SUM(od.price * od.quantity), 0) as total_revenue,
                             COUNT(DISTINCT od.order_id) as order_count
                      FROM product p
                      LEFT JOIN category c ON p.category_id = c.id
                      LEFT JOIN order_details od ON p.id = od.product_id
                      GROUP BY p.id, p.name, p.price, p.image, p.description, c.name
                      ORDER BY p.name ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Process image paths - giống như trong Dashboard chính
            foreach ($products as &$product) {
                if (!empty($product['image'])) {
                    // Clean up image path
                    $product['image'] = trim($product['image']);
                    
                    // Kiểm tra các đường dẫn có thể có
                    $possiblePaths = [
                        $_SERVER['DOCUMENT_ROOT'] . '/buoi2/buoi2/uploads/products/' . basename($product['image']),
                        $_SERVER['DOCUMENT_ROOT'] . '/buoi2/buoi2/uploads/' . basename($product['image']),
                        $_SERVER['DOCUMENT_ROOT'] . '/buoi2/uploads/products/' . basename($product['image']),
                        $_SERVER['DOCUMENT_ROOT'] . '/buoi2/uploads/' . basename($product['image'])
                    ];
                    
                    $fileExists = false;
                    $foundPath = '';
                    foreach ($possiblePaths as $path) {
                        if (file_exists($path) && is_file($path)) {
                            $fileExists = true;
                            $foundPath = $path;
                            break;
                        }
                    }
                    
                    if ($fileExists) {
                        // Tạo đường dẫn web từ đường dẫn file system
                        $webPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $foundPath);
                        $webPath = str_replace('\\', '/', $webPath);
                        $product['image_web_path'] = $webPath;
                        
                        error_log("Found image for product {$product['name']}: {$foundPath} -> {$webPath}");
                    } else {
                        error_log("Image not found for product {$product['name']}: {$product['image']}");
                        error_log("Checked paths: " . implode(', ', $possiblePaths));
                        $product['image_web_path'] = '';
                    }
                } else {
                    $product['image_web_path'] = '';
                }
            }
            
            return $products;

        } catch (PDOException $e) {
            error_log("Error in getAllProducts: " . $e->getMessage());
            return [];
        }
    }

    private function getLatestProducts($limit = 8) {
        try {
            $query = "SELECT p.id, p.name, p.price, p.image, p.description, p.created_at,
                             c.name as category_name,
                             COALESCE(SUM(od.quantity), 0) as total_sold
                      FROM product p
                      LEFT JOIN category c ON p.category_id = c.id
                      LEFT JOIN order_details od ON p.id = od.product_id
                      GROUP BY p.id, p.name, p.price, p.image, p.description, p.created_at, c.name
                      ORDER BY p.created_at DESC
                      LIMIT ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getLatestProducts: " . $e->getMessage());
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
                
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Process image paths - giống như getAllProducts
                foreach ($products as &$product) {
                    if (!empty($product['image'])) {
                        $product['image'] = trim($product['image']);
                        
                        $possiblePaths = [
                            $_SERVER['DOCUMENT_ROOT'] . '/buoi2/buoi2/uploads/products/' . basename($product['image']),
                            $_SERVER['DOCUMENT_ROOT'] . '/buoi2/buoi2/uploads/' . basename($product['image']),
                            $_SERVER['DOCUMENT_ROOT'] . '/buoi2/uploads/products/' . basename($product['image']),
                            $_SERVER['DOCUMENT_ROOT'] . '/buoi2/uploads/' . basename($product['image'])
                        ];
                        
                        $fileExists = false;
                        $foundPath = '';
                        foreach ($possiblePaths as $path) {
                            if (file_exists($path) && is_file($path)) {
                                $fileExists = true;
                                $foundPath = $path;
                                break;
                            }
                        }
                        
                        if ($fileExists) {
                            $webPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $foundPath);
                            $webPath = str_replace('\\', '/', $webPath);
                            $product['image_web_path'] = $webPath;
                        } else {
                            $product['image_web_path'] = '';
                            error_log("Low stock product image not found: {$product['image']}");
                        }
                    } else {
                        $product['image_web_path'] = '';
                    }
                }
                
                return $products;
            }
            
            return [];

        } catch (PDOException $e) {
            error_log("Error in getLowStockProducts: " . $e->getMessage());
            return [];
        }
    }

    private function getPriceStats() {
        try {
            $query = "SELECT 
                        MIN(price) as min_price,
                        MAX(price) as max_price,
                        AVG(price) as avg_price,
                        COUNT(*) as total_products
                      FROM product 
                      WHERE price > 0";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Thống kê theo khoảng giá
            $priceRanges = [
                'under_100k' => 0,
                '100k_500k' => 0,
                '500k_1m' => 0,
                'over_1m' => 0
            ];
            
            $query = "SELECT 
                        SUM(CASE WHEN price < 100000 THEN 1 ELSE 0 END) as under_100k,
                        SUM(CASE WHEN price >= 100000 AND price < 500000 THEN 1 ELSE 0 END) as '100k_500k',
                        SUM(CASE WHEN price >= 500000 AND price < 1000000 THEN 1 ELSE 0 END) as '500k_1m',
                        SUM(CASE WHEN price >= 1000000 THEN 1 ELSE 0 END) as over_1m
                      FROM product 
                      WHERE price > 0";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rangeResult = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return array_merge($result ?: [], $rangeResult ?: []);

        } catch (PDOException $e) {
            error_log("Error in getPriceStats: " . $e->getMessage());
            return [
                'min_price' => 0,
                'max_price' => 0,
                'avg_price' => 0,
                'total_products' => 0,
                'under_100k' => 0,
                '100k_500k' => 0,
                '500k_1m' => 0,
                'over_1m' => 0
            ];
        }
    }

    private function getTopSellingProducts($limit = 5) {
        try {
            $query = "SELECT p.id, p.name, p.price, p.image,
                             COALESCE(SUM(od.quantity), 0) as total_sold,
                             COALESCE(SUM(od.price * od.quantity), 0) as total_revenue,
                             COUNT(DISTINCT od.order_id) as order_count
                      FROM product p
                      LEFT JOIN order_details od ON p.id = od.product_id
                      GROUP BY p.id, p.name, p.price, p.image
                      HAVING total_sold > 0
                      ORDER BY total_sold DESC
                      LIMIT ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error in getTopSellingProducts: " . $e->getMessage());
            return [];
        }
    }

    // API để lấy dữ liệu cho biểu đồ
    public function getProductStatsApi() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }

        header('Content-Type: application/json');
        
        try {
            $type = $_GET['type'] ?? 'category';
            
            switch ($type) {
                case 'category':
                    $data = $this->getProductsByCategory();
                    break;
                case 'price':
                    $data = $this->getPriceStats();
                    break;
                case 'sales':
                    $data = $this->getTopSellingProducts(5);
                    break;
                default:
                    $data = [];
            }
            
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Không thể lấy thống kê sản phẩm']);
        }
        exit;
    }
}