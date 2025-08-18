<?php
class CustomerModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tìm khách hàng theo số điện thoại trong bảng Customer
    public function getCustomerByPhone($phone) {
        try {
            $query = "SELECT id, Customer_name as name, phone 
                      FROM Customer 
                      WHERE phone = :phone 
                      LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getCustomerByPhone: " . $e->getMessage());
            return null;
        }
    }

    // Đếm số lần mua hàng của khách hàng
    public function getCustomerOrderCount($phone) {
        try {
            $query = "SELECT COUNT(*) as order_count 
                      FROM orders 
                      WHERE phone = :phone";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['order_count'] : 0;
        } catch (PDOException $e) {
            error_log("Error in getCustomerOrderCount: " . $e->getMessage());
            return 0;
        }
    }

    // Thêm khách hàng vào bảng Customer mới (nếu chưa tồn tại)
    public function addCustomerToTable($name, $phone) {
        try {
            // Kiểm tra khách hàng đã tồn tại chưa
            $query = "SELECT id FROM Customer WHERE phone = :phone LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            $exists = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$exists) {
                $query = "INSERT INTO Customer (Customer_name, phone) VALUES (:name, :phone)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->execute();
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in addCustomerToTable: " . $e->getMessage());
            return false;
        }
    }

    // Thêm khách hàng mới (sẽ được thêm khi tạo đơn hàng)
    public function addCustomer($name, $phone) {
        // Thêm vào bảng Customer mới nếu chưa có
        $this->addCustomerToTable($name, $phone);
        // Khách hàng sẽ được thêm tự động khi tạo đơn hàng
        // Phương thức này có thể được mở rộng nếu cần bảng customers riêng
        return true;
    }

    // Thêm khách hàng đồng bộ cả bảng Customer và orders
    public function addCustomerFull($name, $phone) {
        try {
            $this->conn->beginTransaction();

            // Thêm hoặc lấy id khách hàng trong bảng Customer
            $query = "SELECT id FROM Customer WHERE phone = :phone LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$customer) {
                $insertQuery = "INSERT INTO Customer (Customer_name, phone) VALUES (:name, :phone)";
                $insertStmt = $this->conn->prepare($insertQuery);
                $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
                $insertStmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $insertStmt->execute();
            }

            // Cập nhật bảng orders với customer_name và phone
            $updateQuery = "UPDATE orders SET customer_name = :name, phone = :phone WHERE phone = :phone";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
            $updateStmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $updateStmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error in addCustomerFull: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật khách hàng đồng bộ cả bảng Customer và orders
    public function updateCustomerFull($oldPhone, $newName, $newPhone) {
        try {
            $this->conn->beginTransaction();

            // Cập nhật bảng Customer
            $updateCustomerQuery = "UPDATE Customer SET Customer_name = :name, phone = :newPhone WHERE phone = :oldPhone";
            $stmtCustomer = $this->conn->prepare($updateCustomerQuery);
            $stmtCustomer->bindParam(':name', $newName, PDO::PARAM_STR);
            $stmtCustomer->bindParam(':newPhone', $newPhone, PDO::PARAM_STR);
            $stmtCustomer->bindParam(':oldPhone', $oldPhone, PDO::PARAM_STR);
            $stmtCustomer->execute();

            // Cập nhật bảng orders
            $updateOrdersQuery = "UPDATE orders SET customer_name = :name, phone = :newPhone WHERE phone = :oldPhone";
            $stmtOrders = $this->conn->prepare($updateOrdersQuery);
            $stmtOrders->bindParam(':name', $newName, PDO::PARAM_STR);
            $stmtOrders->bindParam(':newPhone', $newPhone, PDO::PARAM_STR);
            $stmtOrders->bindParam(':oldPhone', $oldPhone, PDO::PARAM_STR);
            $stmtOrders->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error in updateCustomerFull: " . $e->getMessage());
            return false;
        }
    }

    // Lấy thông tin khách hàng kết hợp từ bảng Customer và orders
    public function getCustomerFullByPhone($phone) {
        try {
            $query = "SELECT c.id, c.Customer_name, c.phone, COUNT(o.id) as order_count
                      FROM Customer c
                      LEFT JOIN orders o ON c.phone = o.phone
                      WHERE c.phone = :phone
                      GROUP BY c.id, c.Customer_name, c.phone";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getCustomerFullByPhone: " . $e->getMessage());
            return null;
        }
    }

    // Cập nhật thông tin khách hàng
    public function updateCustomer($customerId, $name, $phone) {
        // Cập nhật thông tin khách hàng trong các đơn hàng có cùng số điện thoại
        try {
            $query = "UPDATE orders 
                      SET customer_name = :name 
                      WHERE phone = :phone";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in updateCustomer: " . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách khách hàng thường xuyên - đếm số đơn hàng (order_count)
    public function getFrequentCustomers($limit = 10) {
        try {
            $query = "SELECT 
                        o.customer_name, 
                        o.phone, 
                        COUNT(DISTINCT o.id) as order_count, 
                        MAX(o.created_at) as last_order_date,
                        SUM(od.price * od.quantity) as total_spent,
                        MIN(o.id) as id,
                        MIN(o.created_at) as customer_created_at
                      FROM orders o
                      LEFT JOIN order_details od ON o.id = od.order_id
                      WHERE o.customer_name IS NOT NULL AND o.customer_name != '' AND o.phone IS NOT NULL AND o.phone != ''
                      GROUP BY o.customer_name, o.phone
                      ORDER BY order_count DESC, total_spent DESC
                      LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getFrequentCustomers: " . $e->getMessage());
            return [];
        }
    }

    // Lấy thống kê khách hàng
    public function getCustomerStats() {
        try {
            $stats = [];
            
            // Tổng số khách hàng duy nhất
            $query = "SELECT COUNT(DISTINCT phone) as total_customers 
                      FROM orders 
                      WHERE phone IS NOT NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_customers'];
            
            // Khách hàng mới tháng này
            $query = "SELECT COUNT(DISTINCT phone) as new_customers 
                      FROM orders 
                      WHERE phone IS NOT NULL 
                      AND YEAR(created_at) = YEAR(GETDATE()) 
                      AND MONTH(created_at) = MONTH(GETDATE())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['new_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['new_customers'];
            
            // Khách hàng VIP (mua từ 5 lần trở lên)
            $query = "SELECT COUNT(*) as vip_customers 
                      FROM (
                          SELECT phone 
                          FROM orders 
                          WHERE phone IS NOT NULL 
                          GROUP BY phone 
                          HAVING COUNT(*) >= 5
                      ) as vip";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['vip_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['vip_customers'];
            
            return $stats;
            
        } catch (PDOException $e) {
            error_log("Error in getCustomerStats: " . $e->getMessage());
            return [];
        }
    }

    // Thêm khách hàng mới vào bảng Customer và trả về id
    public function addCustomerAndReturnId($name, $phone) {
        try {
            // Kiểm tra khách hàng đã tồn tại chưa
            $query = "SELECT id FROM Customer WHERE phone = :phone LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            $exists = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($exists) {
                return $exists['id'];
            } else {
                $query = "INSERT INTO Customer (Customer_name, phone) VALUES (:name, :phone)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->execute();
                return $this->conn->lastInsertId();
            }
        } catch (PDOException $e) {
            error_log("Error in addCustomerAndReturnId: " . $e->getMessage());
            return null;
        }
    }

    // Thêm phương thức xóa khách hàng
    public function deleteCustomer($phone) {
        try {
            $this->conn->beginTransaction();

            // Xóa order_details trước (foreign key constraint)
            $deleteOrderDetailsQuery = "DELETE FROM order_details WHERE order_id IN (SELECT id FROM orders WHERE phone = :phone)";
            $stmt = $this->conn->prepare($deleteOrderDetailsQuery);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();

            // Xóa orders
            $deleteOrdersQuery = "DELETE FROM orders WHERE phone = :phone";
            $stmt = $this->conn->prepare($deleteOrdersQuery);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();

            // Xóa khách hàng từ bảng Customer
            $deleteCustomerQuery = "DELETE FROM Customer WHERE phone = :phone";
            $stmt = $this->conn->prepare($deleteCustomerQuery);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error in deleteCustomer: " . $e->getMessage());
            return false;
        }
    }

    // Lấy khách hàng theo ID
    public function getCustomerById($id) {
        try {
            // Thử lấy từ bảng Customer trước
            $query = "SELECT c.id, c.Customer_name, c.phone, c.created_at 
                      FROM Customer c 
                      WHERE c.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($customer) {
                return $customer;
            }

            // Nếu không có trong bảng Customer, lấy từ orders
            $query = "SELECT DISTINCT 
                        MIN(o.id) as id,
                        o.customer_name as Customer_name, 
                        o.phone, 
                        MIN(o.created_at) as created_at
                      FROM orders o
                      WHERE o.id = :id 
                      GROUP BY o.customer_name, o.phone";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getCustomerById: " . $e->getMessage());
            return null;
        }
    }

    // Lấy đơn hàng theo customer ID
    public function getOrdersByCustomerId($customerId) {
        try {
            // Lấy phone của customer
            $customer = $this->getCustomerById($customerId);
            if (!$customer) {
                return [];
            }

            $query = "SELECT o.id, o.customer_name, o.phone, o.created_at, o.status,
                             SUM(od.price * od.quantity) as total_amount,
                             COUNT(od.id) as total_items
                      FROM orders o
                      LEFT JOIN order_details od ON o.id = od.order_id
                      WHERE o.phone = :phone
                      GROUP BY o.id, o.customer_name, o.phone, o.created_at, o.status
                      ORDER BY o.created_at DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':phone', $customer['phone'], PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getOrdersByCustomerId: " . $e->getMessage());
            return [];
        }
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetails($orderId) {
        try {
            $query = "SELECT od.product_name, od.quantity, od.price, p.image_url
                      FROM order_details od
                      LEFT JOIN products p ON od.product_name = p.name
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
}