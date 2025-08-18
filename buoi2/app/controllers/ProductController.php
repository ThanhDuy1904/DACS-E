<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $category_id = $_GET['category_id'] ?? null;
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();

        if ($category_id) {
            $products = $this->productModel->getProductsByCategory($category_id);
        } else {
            $products = $this->productModel->getProducts();
        }

        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            // Map category_name to category for backward compatibility in view
            $product->category = $product->category_name ?? '';
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {

        if (!isset($_SESSION['user_id'])) {
            header('Location: /buoi2/User/login');
            exit();
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /buoi2/User/login');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /buoi2/Product');
                exit();
            }
        }
    }

    public function edit($id)
    {

        if (!isset($_SESSION['user_id'])) {
            header('Location: /buoi2/User/login');
            exit();
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {

        if (!isset($_SESSION['user_id'])) {
            header('Location: /buoi2/User/login');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /buoi2/Product');
                exit();
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /buoi2/User/login');
            exit();
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /buoi2/Product');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        // Bỏ kiểm tra định dạng file để cho phép tất cả định dạng
        // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        //     throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        // }
        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    public function addToCart()
    {
        session_start();
        $id = $_POST['product_id'] ?? null;
        if (!$id) {
            echo "Không có sản phẩm được chọn.";
            return;
        }
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            // Chuẩn hóa trường image chỉ lấy tên file, không lấy đường dẫn
            $imageName = basename($product->image);
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $imageName
            ];
        }
        header('Location: /buoi2/Cart');
        exit();
    }

    public function placeOrder()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                echo "Bạn cần đăng nhập để đặt hàng.";
                return;
            }
            $user_id = $_SESSION['user_id'];
            $full_name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $payment_method = $_POST['payment_method'] ?? '';

            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            try {
                $this->db->beginTransaction();

                $query = "INSERT INTO orders (user_id, full_name, email, phone, address, payment_method) 
                          VALUES (:user_id, :full_name, :email, :phone, :address, :payment_method)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':full_name', $full_name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':payment_method', $payment_method);
                $stmt->execute();

                $order_id = $this->db->lastInsertId();

                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                              VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                $this->db->commit();

                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                echo "Đặt hàng thành công!";
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Lỗi khi đặt hàng: " . $e->getMessage();
            }
        }
    }
    public function cart()
        {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /buoi2/User/login');
            exit();
        }
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        // Chuẩn hóa cartItems: thêm 'id' nếu chưa có
        foreach ($cartItems as $key => &$item) {
            if (!isset($item['id'])) {
                $item['id'] = $key;
            }
        }
        unset($item);
        $selectedIndexes = [];
        include 'app/views/Cart/cart.php';
    }
    
}

?>
