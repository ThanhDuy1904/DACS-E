<?php
require_once 'app/config/database.php';
require_once 'app/models/CustomerModel.php';

class CustomerController {
    private $customerModel;

    public function __construct() {
        $database = new Database();
        $conn = $database->getConnection();
        $this->customerModel = new CustomerModel($conn);
    }

    /**
     * Hiển thị danh sách khách hàng
     */
    public function index() {
        try {
            $customers = $this->customerModel->getFrequentCustomers(50);
            require_once 'app/views/customer/list.php';
        } catch (Exception $e) {
            error_log("Error in CustomerController::index: " . $e->getMessage());
            $this->setErrorMessage('Lỗi khi tải danh sách khách hàng.');
            $this->redirect('/buoi2/Customer');
        }
    }

    /**
     * Hiển thị form thêm khách hàng mới và xử lý thêm
     */
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleAddCustomer();
            return;
        }
        
        require_once 'app/views/customer/add.php';
    }

    /**
     * Xử lý thêm khách hàng mới
     */
    private function handleAddCustomer() {
        try {
            $name = trim($_POST['customer_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            // Validation
            if (empty($name) || empty($phone)) {
                $this->setErrorMessage('Tên và số điện thoại không được để trống!');
                require_once 'app/views/customer/add.php';
                return;
            }

            if (!$this->isValidPhone($phone)) {
                $this->setErrorMessage('Số điện thoại không hợp lệ!');
                require_once 'app/views/customer/add.php';
                return;
            }

            // Kiểm tra khách hàng đã tồn tại
            if ($this->customerModel->getCustomerByPhone($phone)) {
                $this->setErrorMessage('Khách hàng với số điện thoại này đã tồn tại!');
                require_once 'app/views/customer/add.php';
                return;
            }

            // Thêm khách hàng mới
            $customerId = $this->customerModel->addCustomerAndReturnId($name, $phone);

            if ($customerId) {
                $this->setSuccessMessage('Thêm khách hàng thành công!');
                $this->redirect('/buoi2/Customer/view?id=' . $customerId);
            } else {
                throw new Exception('Không thể thêm khách hàng');
            }

        } catch (Exception $e) {
            error_log("Error in handleAddCustomer: " . $e->getMessage());
            $this->setErrorMessage('Có lỗi xảy ra khi thêm khách hàng!');
            $this->redirect('/buoi2/Customer');
        }
    }

    /**
     * Hiển thị form sửa khách hàng và xử lý cập nhật
     */
    public function edit() {
        $id = $this->getValidId($_GET['id'] ?? null);
        $phone = trim($_GET['phone'] ?? '');
        
        if (!$id && !$phone) {
            $this->setErrorMessage('Thiếu thông tin khách hàng!');
            $this->redirect('/buoi2/Customer');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleEditCustomer($id, $phone);
            return;
        }

        // Lấy thông tin khách hàng để hiển thị form
        $customer = $this->getCustomerData($id, $phone);
        if (!$customer) {
            $this->setErrorMessage('Không tìm thấy khách hàng!');
            $this->redirect('/buoi2/Customer');
            return;
        }

        require_once 'app/views/customer/edit.php';
    }

    /**
     * Xử lý cập nhật thông tin khách hàng
     */
    private function handleEditCustomer($id, $phone) {
        try {
            $name = trim($_POST['customer_name'] ?? '');
            $newPhone = trim($_POST['phone'] ?? '');

            // Validation
            if (empty($name) || empty($newPhone)) {
                $this->setErrorMessage('Tên và số điện thoại không được để trống!');
                $this->redirect('/buoi2/Customer/edit' . ($id ? "?id=$id" : "?phone=$phone"));
                return;
            }

            if (!$this->isValidPhone($newPhone)) {
                $this->setErrorMessage('Số điện thoại không hợp lệ!');
                $this->redirect('/buoi2/Customer/edit' . ($id ? "?id=$id" : "?phone=$phone"));
                return;
            }

            // Lấy thông tin khách hàng hiện tại
            $customer = $this->getCustomerData($id, $phone);
            if (!$customer) {
                throw new Exception('Không tìm thấy khách hàng');
            }

            // Cập nhật thông tin
            $result = $this->customerModel->updateCustomerFull($customer['phone'], $name, $newPhone);

            if ($result) {
                $this->setSuccessMessage('Cập nhật thông tin khách hàng thành công!');
            } else {
                throw new Exception('Không thể cập nhật thông tin');
            }

        } catch (Exception $e) {
            error_log("Error in handleEditCustomer: " . $e->getMessage());
            $this->setErrorMessage('Có lỗi xảy ra khi cập nhật thông tin khách hàng!');
        }

        $this->redirect('/buoi2/Customer');
    }

    /**
     * Xem chi tiết khách hàng
     */
    public function view() {
        try {
            $id = $this->getValidId($_GET['id'] ?? null);
            if (!$id) {
                $this->setErrorMessage('ID khách hàng không hợp lệ!');
                $this->redirect('/buoi2/Customer');
                return;
            }

            $customer = $this->customerModel->getCustomerById($id);
            if (!$customer) {
                $this->setErrorMessage('Không tìm thấy khách hàng!');
                $this->redirect('/buoi2/Customer');
                return;
            }

            $orders = $this->customerModel->getOrdersByCustomerId($id);
            
            require_once 'app/views/customer/view.php';

        } catch (Exception $e) {
            error_log("Error in CustomerController::view: " . $e->getMessage());
            $this->setErrorMessage('Lỗi khi tải thông tin khách hàng.');
            $this->redirect('/buoi2/Customer');
        }
    }

    /**
     * Xóa khách hàng
     */
    public function delete() {
        try {
            $phone = trim($_GET['phone'] ?? '');
            if (empty($phone)) {
                $this->setErrorMessage('Thiếu số điện thoại khách hàng!');
                $this->redirect('/buoi2/Customer');
                return;
            }

            $customer = $this->customerModel->getCustomerByPhone($phone);
            if (!$customer) {
                $this->setErrorMessage('Không tìm thấy khách hàng!');
                $this->redirect('/buoi2/Customer');
                return;
            }

            $result = $this->customerModel->deleteCustomer($phone);
            
            if ($result) {
                $this->setSuccessMessage('Xóa khách hàng thành công!');
            } else {
                throw new Exception('Không thể xóa khách hàng');
            }

        } catch (Exception $e) {
            error_log("Error in CustomerController::delete: " . $e->getMessage());
            $this->setErrorMessage('Có lỗi xảy ra khi xóa khách hàng!');
        }

        $this->redirect('/buoi2/Customer');
    }

    /**
     * Lấy thông tin khách hàng theo ID hoặc phone
     */
    private function getCustomerData($id, $phone) {
        if ($id) {
            return $this->customerModel->getCustomerById($id);
        } elseif ($phone) {
            return $this->customerModel->getCustomerByPhone($phone);
        }
        return null;
    }

    /**
     * Validate và convert ID
     */
    private function getValidId($id) {
        if ($id === null || $id === '') {
            return null;
        }
        $id = (int)$id;
        return $id > 0 ? $id : null;
    }

    /**
     * Validate số điện thoại
     */
    private function isValidPhone($phone) {
        // Kiểm tra số điện thoại Việt Nam (10-11 số, bắt đầu bằng 0)
        return preg_match('/^0[0-9]{8,9}$/', $phone);
    }

    /**
     * Set thông báo lỗi
     */
    private function setErrorMessage($message) {
        $_SESSION['error'] = $message;
    }

    /**
     * Set thông báo thành công
     */
    private function setSuccessMessage($message) {
        $_SESSION['success'] = $message;
    }

    /**
     * Chuyển hướng
     */
    private function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}