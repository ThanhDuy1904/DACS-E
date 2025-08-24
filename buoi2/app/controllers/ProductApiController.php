<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductApiController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        // Tắt error reporting để tránh HTML error xuất hiện trong JSON response
        error_reporting(E_ERROR | E_PARSE);
        ini_set('display_errors', 0);
        
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Lấy danh sách sản phẩm
    public function index()
    {
        try {
            $products = $this->productModel->getProducts();
            $this->sendJsonResponse($products);
        } catch (Exception $e) {
            $this->sendJsonResponse(['message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }

    // Lấy thông tin sản phẩm theo ID
    public function show($id)
    {
        if (!$id || !is_numeric($id)) {
            $this->sendJsonResponse(['message' => 'ID sản phẩm không hợp lệ'], 400);
            return;
        }

        try {
            $product = $this->productModel->getProductById($id);
            if ($product) {
                $this->sendJsonResponse($product);
            } else {
                $this->sendJsonResponse(['message' => 'Không tìm thấy sản phẩm'], 404);
            }
        } catch (Exception $e) {
            $this->sendJsonResponse(['message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }

    // Thêm sản phẩm mới
    public function store()
    {
        try {
            // Lấy dữ liệu từ POST
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $description = $_POST['description'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            // Validation
            if (empty(trim($name))) {
                $this->sendJsonResponse(['message' => 'Tên sản phẩm không được để trống'], 400);
                return;
            }

            if (!is_numeric($price) || $price <= 0) {
                $this->sendJsonResponse(['message' => 'Giá sản phẩm phải là số dương'], 400);
                return;
            }

            // Xử lý upload ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                try {
                    $image = $this->uploadImage($_FILES['image']);
                } catch (Exception $e) {
                    $this->sendJsonResponse(['message' => 'Lỗi upload ảnh: ' . $e->getMessage()], 400);
                    return;
                }
            }

            // Thêm sản phẩm
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);
            
            if ($result) {
                $this->sendJsonResponse([
                    'message' => 'Thêm sản phẩm thành công',
                    'product_id' => $result
                ], 201);
            } else {
                $this->sendJsonResponse(['message' => 'Thêm sản phẩm thất bại'], 500);
            }
        } catch (Exception $e) {
            $this->sendJsonResponse(['message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }

    public function update($id)
    {
        // Bắt đầu với clean slate - tắt tất cả output buffering
        $this->cleanOutput();
        
        try {
            // Debug log - ghi vào file thay vì echo
            error_log("ProductAPI Update called with ID: " . $id);
            
            // Kiểm tra ID hợp lệ
            if (!$id || !is_numeric($id)) {
                $this->sendJsonResponse(['message' => 'ID sản phẩm không hợp lệ'], 400);
                return;
            }
            
            // Kiểm tra sản phẩm tồn tại
            $existingProduct = $this->productModel->getProductById($id);
            if (!$existingProduct) {
                $this->sendJsonResponse(['message' => 'Không tìm thấy sản phẩm'], 404);
                return;
            }

            // Đọc input data với error handling tốt hơn
            $inputData = file_get_contents("php://input");
            error_log("Raw input data: " . $inputData);
            
            if ($inputData === false || $inputData === '') {
                $this->sendJsonResponse(['message' => 'Không có dữ liệu để cập nhật'], 400);
                return;
            }
            
            $input = json_decode($inputData, true);
            if ($input === null) {
                $jsonError = json_last_error_msg();
                error_log("JSON decode error: " . $jsonError);
                $this->sendJsonResponse([
                    'message' => 'Dữ liệu JSON không hợp lệ: ' . $jsonError,
                    'received_data' => substr($inputData, 0, 200)
                ], 400);
                return;
            }
            
            // Đảm bảo $input là array
            if (!is_array($input)) {
                $input = [];
            }
            
            error_log("Parsed input: " . print_r($input, true));
            error_log("Existing product: " . print_r($existingProduct, true));
            
            // Xử lý dữ liệu an toàn hơn
            $name = isset($input['name']) && trim($input['name']) !== '' ? trim($input['name']) : $existingProduct->name;
            $description = array_key_exists('description', $input) ? trim($input['description']) : $existingProduct->description;
            $price = isset($input['price']) && is_numeric($input['price']) ? (float)$input['price'] : (float)$existingProduct->price;
            $category_id = isset($input['category_id']) && is_numeric($input['category_id']) ? (int)$input['category_id'] : ($existingProduct->category_id ? (int)$existingProduct->category_id : null);
            $image = $existingProduct->image; // Giữ nguyên ảnh cũ nếu không có ảnh mới

            error_log("Final values - name: $name, price: $price, description: $description, category_id: $category_id");

            // Validation
            if (empty($name)) {
                $this->sendJsonResponse(['message' => 'Tên sản phẩm không được để trống'], 400);
                return;
            }

            if ($price <= 0) {
                $this->sendJsonResponse(['message' => 'Giá sản phẩm phải là số dương'], 400);
                return;
            }

            // Kiểm tra category_id có tồn tại không (nếu được cung cấp)
            if ($category_id) {
                try {
                    $categoryModel = new CategoryModel($this->db);
                    $category = $categoryModel->getCategoryById($category_id);
                    if (!$category) {
                        $this->sendJsonResponse(['message' => 'Danh mục không tồn tại'], 400);
                        return;
                    }
                } catch (Exception $catEx) {
                    error_log("Category check error: " . $catEx->getMessage());
                    // Tiếp tục với category_id = null thay vì fail
                    $category_id = null;
                }
            }

            // Thực hiện update với error handling
            error_log("Calling updateProduct with params: id=$id, name=$name, desc=$description, price=$price, cat_id=$category_id, img=$image");
            
            $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            error_log("Update result: " . ($result ? 'true' : 'false'));

            if ($result) {
                $this->sendJsonResponse([
                    'message' => 'Cập nhật sản phẩm thành công',
                    'product' => [
                        'id' => (int)$id,
                        'name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'category_id' => $category_id,
                        'image' => $image
                    ]
                ], 200);
            } else {
                $this->sendJsonResponse(['message' => 'Cập nhật sản phẩm thất bại - không có thay đổi nào được thực hiện'], 400);
            }
            
        } catch (Exception $e) {
            error_log("Exception in update: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            $this->sendJsonResponse([
                'message' => 'Lỗi server: ' . $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine()
            ], 500);
        } catch (Error $e) {
            error_log("Fatal error in update: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            $this->sendJsonResponse([
                'message' => 'Lỗi nghiêm trọng: ' . $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine()
            ], 500);
        }
    }
    
    // Xóa sản phẩm theo ID
    public function destroy($id)
    {
        try {
            if (!$id || !is_numeric($id)) {
                $this->sendJsonResponse(['message' => 'ID sản phẩm không hợp lệ'], 400);
                return;
            }

            // Kiểm tra sản phẩm có tồn tại không
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                $this->sendJsonResponse(['message' => 'Không tìm thấy sản phẩm'], 404);
                return;
            }

            $result = $this->productModel->deleteProduct($id);
            
            if ($result) {
                // Xóa file ảnh nếu có
                if ($product['image'] && file_exists($product['image'])) {
                    unlink($product['image']);
                }
                
                $this->sendJsonResponse(['message' => 'Xóa sản phẩm thành công']);
            } else {
                $this->sendJsonResponse(['message' => 'Xóa sản phẩm thất bại'], 500);
            }
        } catch (Exception $e) {
            $this->sendJsonResponse(['message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }

    // Helper method để clean output buffer - cải thiện
    private function cleanOutput() {
        // Tắt tất cả output buffering levels
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set headers ngay lập tức nếu chưa gửi
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
        }
    }
    
    // Helper method để gửi JSON response an toàn - cải thiện
    private function sendJsonResponse($data, $statusCode = 200) {
        try {
            // Ensure we can set headers
            if (!headers_sent()) {
                http_response_code($statusCode);
                header('Content-Type: application/json; charset=utf-8');
            }
            
            // Ensure data is properly encoded
            $jsonOptions = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
            
            $jsonData = json_encode($data, $jsonOptions);
            if ($jsonData === false) {
                $jsonData = json_encode([
                    'error' => true,
                    'message' => 'Lỗi encode JSON: ' . json_last_error_msg()
                ], JSON_UNESCAPED_UNICODE);
            }
            
            // Clean any existing output
            if (ob_get_level()) {
                ob_clean();
            }
            
            // Output the JSON
            echo $jsonData;
            
            // Force output
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            } else {
                if (ob_get_level()) {
                    ob_end_flush();
                }
                flush();
            }
            
        } catch (Exception $e) {
            error_log("Error in sendJsonResponse: " . $e->getMessage());
            // Last resort - try to send basic error
            echo json_encode(['error' => true, 'message' => 'Response encoding failed']);
        }
        
        // Ensure we exit cleanly
        exit(0);
    }
    
    // Hàm upload ảnh
    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $fileName = uniqid() . '_' . time() . '.' . $imageFileType;
        $target_file = $target_dir . $fileName;
        
        // Kiểm tra file có phải là ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là ảnh");
        }
        
        // Kiểm tra kích thước file (10MB max)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Kích thước file quá lớn");
        }
        
        // Định dạng file được phép
        $allowedTypes = ['jpg', 'jpeg', 'jfif', 'png', 'gif', 'webp', 'bmp'];
        if (!in_array($imageFileType, $allowedTypes)) {
            throw new Exception("Định dạng file không được hỗ trợ");
        }
        
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Upload file thất bại");
        }
        
        return $target_file;
    }
}
?>