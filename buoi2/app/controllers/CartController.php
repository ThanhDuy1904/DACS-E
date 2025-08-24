<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/CustomerModel.php';
require_once 'app/models/DiscountModel.php';

class CartController {
    private $conn;
    private $productModel;
    private $orderModel;
    private $customerModel;
    private $discountModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->productModel = new ProductModel($this->conn);
        $this->orderModel = new OrderModel($this->conn);
        $this->customerModel = new CustomerModel($this->conn);
        $this->discountModel = new DiscountModel($this->conn);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!isset($_SESSION['selected_indexes'])) {
            $_SESSION['selected_indexes'] = [];
        }
    }

    /**
     * API tra cứu khách hàng theo số điện thoại
     */
    public function searchCustomerByPhone() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $phone = trim($_POST['phone'] ?? '');
            $result = ['found' => false, 'customer_name' => '', 'discount' => 0];
            
            if ($phone !== '') {
                $query = "SELECT o.customer_name as username, COUNT(o.id) as order_count
                          FROM orders o
                          WHERE o.phone = :phone
                          GROUP BY o.customer_name
                          LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':phone', $phone);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($row) {
                    $result['found'] = true;
                    $result['customer_name'] = $row['username'];
                    // Khách hàng VIP: mua trên 5 lần được giảm 30,000 VND
                    if ($row['order_count'] > 5) {
                        $result['discount'] = 30000;
                    }
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }

    /**
     * Phương thức tính toán giảm giá
     */
    private function calculateDiscount($totalAmount, $discountCode, $customerDiscount = 0) {
        $discountAmount = 0;
        $discountInfo = [];
        
        // Giảm giá từ mã khuyến mãi
        if ($discountCode) {
            $discount = $this->discountModel->getDiscountByCode($discountCode);
            if ($discount) {
                $discountValue = $this->extractDiscountValue($discount['tenDiscount']);
                if ($discountValue > 0) {
                    $discountAmount += $discountValue;
                    $discountInfo['promotion'] = [
                        'code' => $discountCode,
                        'name' => $discount['tenDiscount'],
                        'amount' => $discountValue
                    ];
                }
            }
        }
        
        // Giảm giá cho khách hàng VIP
        if ($customerDiscount > 0) {
            $discountAmount += $customerDiscount;
            $discountInfo['vip'] = [
                'amount' => $customerDiscount,
                'description' => 'Khách hàng VIP - Đã mua trên 5 lần'
            ];
        }
        
        // Đảm bảo tổng tiền không âm
        $finalAmount = max(0, $totalAmount - $discountAmount);
        
        return [
            'original_total' => $totalAmount,
            'discount_amount' => $discountAmount,
            'final_total' => $finalAmount,
            'discount_info' => $discountInfo
        ];
    }

    /**
     * Trích xuất giá trị giảm giá từ chuỗi text
     */
    private function extractDiscountValue($discountText) {
        preg_match('/\d+/', $discountText, $matches);
        return isset($matches[0]) ? (int)$matches[0] : 0;
    }

    /**
     * API tính toán giảm giá real-time
     */
    public function calculateDiscountAPI() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $discountCode = $_POST['discount_code'] ?? '';
            $phone = $_POST['phone'] ?? '';
            
            // Tính tổng tiền giỏ hàng
            $totalAmount = $this->getCartTotal();
            
            // Kiểm tra giảm giá khách hàng VIP
           // $customerDiscount = $this->getCustomerDiscount($phone);
            
            // Tính toán giảm giá
            $discountResult = $this->calculateDiscount($totalAmount, $discountCode);
            
            header('Content-Type: application/json');
            echo json_encode($discountResult);
            exit;
        }
    }

    /**
     * Tính tổng tiền giỏ hàng
     */
    private function getCartTotal() {
        $cart = $_SESSION['cart'] ?? [];
        $totalAmount = 0;
        
        if (!empty($cart)) {
            $productIds = array_column($cart, 'product_id');
            $products = $this->productModel->getProductsByIds($productIds);
            $productMap = array_column($products, null, 'id');
            
            foreach ($cart as $item) {
                if (isset($productMap[$item['product_id']])) {
                    $product = $productMap[$item['product_id']];
                    $price = $product['price'];
                    if (!empty($item['cup_size']) && $item['cup_size'] === 'Ly lớn') {
                        $price += 5000;
                    }
                    $totalAmount += $price * $item['quantity'];
                }
            }
        }
        
        return $totalAmount;
    }

    /**
     * Lấy giảm giá cho khách hàng VIP
     */
    // private function getCustomerDiscount($phone) {
    //     if (!$phone) {
    //         return 0;
    //     }

    //     $query = "SELECT COUNT(o.id) as order_count
    //               FROM orders o
    //               WHERE o.phone = :phone";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':phone', $phone);
    //     $stmt->execute();
    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
    //     return ($row && $row['order_count'] > 5) ? 3000 : 0;
    // }

    /**
     * Lấy danh sách sản phẩm trong giỏ hàng với thông tin đầy đủ
     */
    private function getCartItems() {
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        
        if (!empty($cart)) {
            $productIds = array_column($cart, 'product_id');
            $products = $this->productModel->getProductsByIds($productIds);
            $productMap = array_column($products, null, 'id');
            
            foreach ($cart as $key => $item) {
                if (isset($productMap[$item['product_id']])) {
                    $product = $productMap[$item['product_id']];
                    $product['quantity'] = $item['quantity'] ?? 0;
                    $product['sugar_level'] = $item['sugar_level'] ?? null;
                    $product['ice_level'] = $item['ice_level'] ?? null;
                    $product['cup_size'] = $item['cup_size'] ?? null;
                    $product['final_price'] = $product['price'];
                    
                    if (!empty($item['cup_size']) && $item['cup_size'] === 'Ly lớn') {
                        $product['final_price'] += 5000;
                    }
                    $cartItems[] = $product;
                }
            }
        }
        
        return $cartItems;
    }

    /**
     * Trang giỏ hàng
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        $cartItems = $this->getCartItems();
        $discounts = $this->discountModel->getAllDiscounts();
        $selectedIndexes = $_SESSION['selected_indexes'] ?? [];
        
        require_once 'app/views/Cart/cart.php';
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $quantity = (int)($_POST['quantity'] ?? 1);

            $sugarLevel = $this->processArrayInput($_POST['sugar_level'] ?? null);
            $iceLevel = $this->processArrayInput($_POST['ice_level'] ?? null);
            $cupSize = $this->processArrayInput($_POST['cup_size'] ?? null);

            $optionKey = md5(json_encode([
                'product_id' => $productId,
                'sugar_level' => $sugarLevel,
                'ice_level' => $iceLevel,
                'cup_size' => $cupSize
            ]));

            if (!isset($_SESSION['cart'][$optionKey])) {
                $_SESSION['cart'][$optionKey] = [
                    'product_id' => $productId,
                    'quantity' => 0,
                    'sugar_level' => $sugarLevel,
                    'ice_level' => $iceLevel,
                    'cup_size' => $cupSize,
                    'price' => 0
                ];
            }
            $_SESSION['cart'][$optionKey]['quantity'] += $quantity;

            $product = $this->productModel->getProductById($productId);
            if ($product) {
                $_SESSION['cart'][$optionKey]['price'] = $product['price'];
            }

            header("Location: /buoi2/Cart");
            exit;
        }
    }

    /**
     * Xử lý input có thể là array hoặc string
     */
    private function processArrayInput($input) {
        if (is_array($input)) {
            return implode(',', $input);
        }
        return $input;
    }

    /**
     * Cập nhật giỏ hàng
     */
    public function update() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Cập nhật danh sách sản phẩm được chọn
            $_SESSION['selected_indexes'] = $_POST['selected_indexes'] ?? [];
            
            // Xóa sản phẩm
            if (isset($_POST['delete_index'])) {
                $this->deleteCartItem($_POST['delete_index']);
            }
            
            // Cập nhật số lượng
            if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
                $this->updateCartQuantities($_POST['quantities']);
            }
            
            header("Location: /buoi2/Cart");
            exit;
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    private function deleteCartItem($deleteIndex) {
        if (isset($_SESSION['cart'])) {
            $keys = array_keys($_SESSION['cart']);
            if (isset($keys[$deleteIndex])) {
                unset($_SESSION['cart'][$keys[$deleteIndex]]);
            }
        }
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    private function updateCartQuantities($quantities) {
        $keys = array_keys($_SESSION['cart']);
        foreach ($quantities as $index => $quantity) {
            if (isset($keys[$index]) && $quantity > 0) {
                $_SESSION['cart'][$keys[$index]]['quantity'] = (int)$quantity;
            }
        }
    }

    /**
     * Trang thanh toán
     */
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }

        $cartItems = $this->getCartItems();
        $totalAmount = $this->getCartTotal();
        $discounts = $this->discountModel->getAllDiscounts();

        extract(['cartItems' => $cartItems, 'totalAmount' => $totalAmount, 'discounts' => $discounts]);
        require_once 'app/views/Cart/checkout.php';
    }

    /**
     * Trang thanh toán thành công
     */
    public function success() {
        require_once 'app/views/Cart/success.php';
    }

    /**
     * Trang thanh toán QR
     */
    public function payment_qr() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePaymentMethodRedirect($_POST['payment_method'] ?? '');
        } else {
            $this->showPaymentQR();
        }
    }

    /**
     * Xử lý chuyển hướng theo phương thức thanh toán
     */
    private function handlePaymentMethodRedirect($paymentMethod) {
        switch ($paymentMethod) {
            case 'cod':
                header("Location: /buoi2/Cart/success");
                break;
            case 'bank':
            case 'zalopay':
                header("Location: /buoi2/Cart/payment_qr?method=" . urlencode($paymentMethod));
                break;
            default:
                header("Location: /buoi2/Cart/checkout");
        }
        exit;
    }

    /**
     * Hiển thị trang thanh toán QR
     */
    private function showPaymentQR() {
        $method = $_GET['method'] ?? '';
        $cartItems = $this->getCartItems();
        $totalAmount = $this->getCartTotal();
        
        require_once 'app/views/Cart/payment_qr.php';
    }

    /**
     * Xử lý thanh toán và chuyển hướng
     */
    public function process_payment() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $paymentData = $this->extractPaymentData();
                $cartItems = $this->getCartItemsForOrder();
                $totalAmount = $this->calculateOrderTotal($cartItems);
                
                // Tính toán giảm giá
               // $customerDiscount = $this->getCustomerDiscount($paymentData['phone']);
                $discountResult = $this->calculateDiscount($totalAmount, $paymentData['discountCode']);
                
                // Tạo đơn hàng
                $orderId = $this->createOrder($paymentData, $cartItems, $discountResult);
                
                if ($orderId) {
                    $this->handleSuccessfulOrder($orderId, $discountResult, $totalAmount, $paymentData);
                } else {
                    throw new Exception("Không thể tạo đơn hàng");
                }
                
            } catch (Exception $e) {
                error_log("Error in process_payment: " . $e->getMessage());
                header("Location: /buoi2/Cart/checkout");
                exit;
            }
        } else {
            header("Location: /buoi2/Cart/checkout");
            exit;
        }
    }

    /**
     * Trích xuất dữ liệu thanh toán từ POST
     */
    private function extractPaymentData() {
        return [
            'paymentMethod' => $_POST['payment_method'] ?? '',
            'customerName' => $_POST['customer_name'] ?? null,
            'phone' => $_POST['phone'] ?? null,
            'discountCode' => $_POST['discount_code'] ?? null
        ];
    }

    /**
     * Lấy danh sách sản phẩm cho đơn hàng
     */
    private function getCartItemsForOrder() {
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        
        if (!empty($cart)) {
            $productIds = array_column($cart, 'product_id');
            $products = $this->productModel->getProductsByIds($productIds);
            $productMap = array_column($products, null, 'id');
            
            foreach ($cart as $item) {
                if (isset($productMap[$item['product_id']])) {
                    $product = $productMap[$item['product_id']];
                    $cartItems[] = [
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'] ?? 0,
                        'sugar_level' => $item['sugar_level'] ?? null,
                        'ice_level' => $item['ice_level'] ?? null,
                        'cup_size' => $item['cup_size'] ?? null,
                        'price' => $product['price']
                    ];
                }
            }
        }
        
        return $cartItems;
    }

    /**
     * Tính tổng tiền đơn hàng (bao gồm phụ phí ly lớn)
     */
    private function calculateOrderTotal($cartItems) {
        $totalAmount = 0;
        
        foreach ($cartItems as $item) {
            $price = $item['price'];
            if (!empty($item['cup_size']) && $item['cup_size'] === 'Ly lớn') {
                $price += 5000;
            }
            $totalAmount += $price * $item['quantity'];
        }
        
        return $totalAmount;
    }

    /**
     * Tạo đơn hàng
     */
    private function createOrder($paymentData, $cartItems, $discountResult) {
        // Chuẩn bị dữ liệu sản phẩm cho OrderModel
        $productsForOrder = array_map(function($item) {
            $price = $item['price'];
            if (!empty($item['cup_size']) && $item['cup_size'] === 'Ly lớn') {
                $price += 5000;
            }
            return [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'sugar_level' => $item['sugar_level'],
                'ice_level' => $item['ice_level'],
                'cup_size' => $item['cup_size'],
                'price' => $price
            ];
        }, $cartItems);
        
        // Tạo đơn hàng không sử dụng customer_id
        $orderId = $this->orderModel->addOrderWithDetails(
            $_SESSION['user_id'],
            $paymentData['paymentMethod'],
            $productsForOrder,
            $paymentData['customerName'],
            $paymentData['phone'],
            $paymentData['discountCode'],
            $discountResult['discount_amount']
        );
        
        return $orderId;
    }

    /**
     * Xử lý sau khi tạo đơn hàng thành công
     */
    private function handleSuccessfulOrder($orderId, $discountResult, $totalAmount, $paymentData) {
        // Thêm khách hàng vào bảng Customer nếu chưa tồn tại
        if ($paymentData['customerName'] && $paymentData['phone']) {
            $this->customerModel->addCustomerToTable($paymentData['customerName'], $paymentData['phone']);
        }
        
        // Lưu thông tin vào session
        $_SESSION['totalAmount'] = $discountResult['final_total'];
        $_SESSION['originalAmount'] = $totalAmount;
        $_SESSION['discountAmount'] = $discountResult['discount_amount'];
        $_SESSION['order_id'] = $orderId;
        
        // Xóa giỏ hàng
        $_SESSION['cart'] = [];
        $_SESSION['selected_indexes'] = [];
        
        error_log("Order saved successfully with ID: " . $orderId);
        
        // Chuyển hướng theo phương thức thanh toán
        $this->redirectAfterPayment($paymentData['paymentMethod']);
    }

    /**
     * Chuyển hướng sau thanh toán
     */
    private function redirectAfterPayment($paymentMethod) {
        switch ($paymentMethod) {
            case 'cod':
            case 'bank':
            case 'zalopay':
                header("Location: /buoi2/Cart/success");
                break;
            default:
                header("Location: /buoi2/Cart/checkout");
        }
        exit;
    }
}