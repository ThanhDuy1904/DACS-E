<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lấy danh sách đơn hàng với thông tin nhân viên và discount
     */
    public function getOrders() {
        try {
            $query = "SELECT o.id, o.user_id, o.payment_method, o.customer_name, o.phone, 
                             o.created_at, o.status, o.discount_code, o.discount_amount, o.cancel_reason,
                             u.username 
                      FROM orders o 
                      LEFT JOIN users u ON o.user_id = u.id 
                      ORDER BY o.created_at DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getOrders: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy đơn hàng theo ID
     */
    public function getOrderById($orderId) {
        try {
            $query = "SELECT o.*, u.username 
                      FROM orders o 
                      LEFT JOIN users u ON o.user_id = u.id 
                      WHERE o.id = :order_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getOrderById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Lấy chi tiết đơn hàng
     */
    public function getOrderDetails($orderId) {
        try {
            $query = "SELECT od.*, p.name as product_name, p.image 
                      FROM order_details od 
                      LEFT JOIN product p ON od.product_id = p.id 
                      WHERE od.order_id = :order_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getOrderDetails: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Tạo đơn hàng mới - discount áp dụng cho tổng đơn hàng
     */
    public function addOrderWithDetails($userId, $paymentMethod, $products, $customerName = null, $phone = null, $discountCode = null, $discountAmount = 0) {
        try {
            $this->conn->beginTransaction();

            // Tạo đơn hàng chính
            $query = "INSERT INTO orders (user_id, payment_method, customer_name, phone, discount_code, discount_amount, created_at, status) 
                      VALUES (:user_id, :payment_method, :customer_name, :phone, :discount_code, :discount_amount, CURRENT_TIMESTAMP, 'Đang chuẩn bị')";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':user_id', $userId);
            $stmt->bindValue(':payment_method', $paymentMethod);
            $stmt->bindValue(':customer_name', $customerName);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':discount_code', $discountCode);
            $stmt->bindValue(':discount_amount', $discountAmount);
            $stmt->execute();
            
            $orderId = $this->conn->lastInsertId();
            
            // Thêm chi tiết đơn hàng với giá gốc (KHÔNG áp dụng discount vào giá sản phẩm)
            $detailQuery = "INSERT INTO order_details (order_id, product_id, quantity, sugar_level, ice_level, cup_size, price) 
                           VALUES (:order_id, :product_id, :quantity, :sugar_level, :ice_level, :cup_size, :price)";
            
            $detailStmt = $this->conn->prepare($detailQuery);
            
            foreach ($products as $product) {
                $detailStmt->bindValue(':order_id', $orderId);
                $detailStmt->bindValue(':product_id', $product['product_id']);
                $detailStmt->bindValue(':quantity', $product['quantity']);
                $detailStmt->bindValue(':sugar_level', $product['sugar_level']);
                $detailStmt->bindValue(':ice_level', $product['ice_level']);
                $detailStmt->bindValue(':cup_size', $product['cup_size']);
                $detailStmt->bindValue(':price', $product['price']); // Giữ nguyên giá gốc
                
                $detailStmt->execute();
            }
            
            $this->conn->commit();
            return $orderId;
            
        } catch (PDOException $e) {
            $this->conn->rollback();
            error_log("Error in addOrderWithDetails: " . $e->getMessage());
            throw new Exception("Không thể tạo đơn hàng: " . $e->getMessage());
        }
    }

    /**
     * Cập nhật thông tin đơn hàng
     */
    public function updateOrder($orderId, $customerName, $phone, $paymentMethod) {
        try {
            $query = "UPDATE orders SET 
                        customer_name = :customer_name, 
                        phone = :phone, 
                        payment_method = :payment_method 
                      WHERE id = :order_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':customer_name', $customerName, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':payment_method', $paymentMethod, PDO::PARAM_STR);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in updateOrder: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateOrderStatus($orderId, $status) {
        try {
            $query = "UPDATE orders SET status = :status WHERE id = :order_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in updateOrderStatus: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật chi tiết đơn hàng
     */
    public function updateOrderDetails($orderId, $products) {
        try {
            $this->conn->beginTransaction();
            
            foreach ($products as $product) {
                if (isset($product['id']) && !empty($product['id'])) {
                    $query = "UPDATE order_details SET 
                                quantity = :quantity, 
                                price = :price 
                              WHERE id = :detail_id AND order_id = :order_id";
                    
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':quantity', $product['quantity'], PDO::PARAM_INT);
                    $stmt->bindParam(':price', $product['price'], PDO::PARAM_STR);
                    $stmt->bindParam(':detail_id', $product['id'], PDO::PARAM_INT);
                    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollback();
            error_log("Error in updateOrderDetails: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Thêm sản phẩm mới vào đơn hàng
     */
    public function addNewOrderDetails($orderId, $newProducts) {
        try {
            $this->conn->beginTransaction();
            
            $query = "INSERT INTO order_details (order_id, product_id, quantity, sugar_level, ice_level, cup_size, price) 
                      VALUES (:order_id, :product_id, :quantity, :sugar_level, :ice_level, :cup_size, :price)";
            
            $stmt = $this->conn->prepare($query);
            
            foreach ($newProducts as $product) {
                $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $product['product_id'], PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $product['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':sugar_level', $product['sugar_level'], PDO::PARAM_STR);
                $stmt->bindParam(':ice_level', $product['ice_level'], PDO::PARAM_STR);
                $stmt->bindParam(':cup_size', $product['cup_size'], PDO::PARAM_STR);
                $stmt->bindParam(':price', $product['price'], PDO::PARAM_STR); // Giữ nguyên giá gốc
                $stmt->execute();
            }
            
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollback();
            error_log("Error in addNewOrderDetails: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa một sản phẩm khỏi đơn hàng
     */
    public function deleteOrderItem($itemId) {
        try {
            $query = "DELETE FROM order_details WHERE id = :item_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deleteOrderItem: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa đơn hàng
     */
    public function deleteOrder($orderId) {
        try {
            $this->conn->beginTransaction();
            
            // Xóa chi tiết đơn hàng trước
            $query = "DELETE FROM order_details WHERE order_id = :order_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Xóa đơn hàng chính
            $query = "DELETE FROM orders WHERE id = :order_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            $this->conn->commit();
            return $result;
        } catch (PDOException $e) {
            $this->conn->rollback();
            error_log("Error in deleteOrder: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Tìm kiếm đơn hàng với bộ lọc
     */
    public function searchOrders($filters) {
        try {
            $sql = "SELECT o.*, u.username 
                    FROM orders o 
                    LEFT JOIN users u ON o.user_id = u.id 
                    WHERE 1=1";
            
            $params = [];
            
            // Tìm kiếm theo keyword
            if (!empty($filters['keyword'])) {
                $sql .= " AND (o.customer_name LIKE ? OR o.phone LIKE ? OR u.username LIKE ? OR o.id LIKE ?)";
                $keyword = '%' . $filters['keyword'] . '%';
                $params = array_merge($params, [$keyword, $keyword, $keyword, $keyword]);
            }
            
            // Lọc theo ngày
            if (!empty($filters['date_from'])) {
                $sql .= " AND DATE(o.created_at) >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $sql .= " AND DATE(o.created_at) <= ?";
                $params[] = $filters['date_to'];
            }
            
            // Lọc theo phương thức thanh toán
            if (!empty($filters['payment_method'])) {
                $sql .= " AND o.payment_method = ?";
                $params[] = $filters['payment_method'];
            }
            
            // Lọc theo nhân viên
            if (!empty($filters['user_id'])) {
                $sql .= " AND o.user_id = ?";
                $params[] = $filters['user_id'];
            }
            
            // Lọc theo trạng thái
            if (!empty($filters['status'])) {
                $sql .= " AND o.status = ?";
                $params[] = $filters['status'];
            }
            
            $sql .= " ORDER BY o.created_at DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error in searchOrders: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Tìm kiếm đơn hàng với bộ lọc - alias cho searchOrders
     */
    public function searchOrdersWithFilters($filters) {
        return $this->searchOrders($filters);
    }

    /**
     * Tìm kiếm đơn hàng nâng cao
     */
    public function searchOrdersAdvanced($filters) {
        return $this->searchOrders($filters);
    }

    /**
     * Lấy thống kê đơn hàng - loại trừ đơn hàng đã hủy khỏi doanh thu
     */
    public function getOrderStatistics() {
        try {
            $stats = [];
            
            // Tổng số đơn hàng (bao gồm cả đã hủy)
            $query = "SELECT COUNT(*) as total_orders FROM orders";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];
            
            // Tổng doanh thu (chỉ tính đơn hàng không bị hủy)
            $query = "SELECT COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as total_revenue 
                      FROM order_details od
                      INNER JOIN orders o ON od.order_id = o.id
                      WHERE o.status != 'Đã hủy'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;
            
            // Đơn hàng hôm nay (bao gồm cả đã hủy)
            $query = "SELECT COUNT(*) as today_orders 
                      FROM orders 
                      WHERE DATE(created_at) = CURDATE()";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['today_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['today_orders'];
            
            // Doanh thu hôm nay (chỉ tính đơn hàng không bị hủy)
            $query = "SELECT COALESCE(SUM(od.price * od.quantity), 0) - COALESCE(SUM(o.discount_amount), 0) as today_revenue 
                      FROM order_details od 
                      INNER JOIN orders o ON od.order_id = o.id 
                      WHERE DATE(o.created_at) = CURDATE() AND o.status != 'Đã hủy'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['today_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['today_revenue'] ?? 0;
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error in getOrderStatistics: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy danh sách nhân viên
     */
    public function getEmployees() {
        try {
            $query = "SELECT id, username FROM users WHERE role IN ('employee', 'admin')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getEmployees: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Áp dụng discount cho đơn hàng - chỉ cập nhật thông tin discount, không thay đổi giá sản phẩm
     */
    public function applyDiscount($orderId, $discountCode, $discountAmount) {
        try {
            // Chỉ cập nhật thông tin discount trong bảng orders
            $stmt = $this->conn->prepare("
                UPDATE orders 
                SET discount_code = ?, discount_amount = ? 
                WHERE id = ?
            ");
            
            return $stmt->execute([$discountCode, $discountAmount, $orderId]);
            
        } catch (PDOException $e) {
            error_log("Error in applyDiscount: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Hủy đơn hàng với lý do
     */
    public function cancelOrder($orderId, $cancelReason) {
        try {
            $query = "UPDATE orders SET 
                        status = 'Đã hủy', 
                        cancel_reason = :cancel_reason 
                      WHERE id = :order_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cancel_reason', $cancelReason, PDO::PARAM_STR);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in cancelOrder: " . $e->getMessage());
            return false;
        }
    }
}