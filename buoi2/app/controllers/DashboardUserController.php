<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';

class DashboardUserController {
    private $conn;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->userModel = new UserModel($this->conn);
    }

    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        // Lấy thống kê tài khoản
        $userStats = $this->getUserStats();
        
        // Lấy tất cả tài khoản
        $allUsers = $this->getAllUsers();

        require 'app/views/dashboard/user.php';
    }

    public function add() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'employee';
            
            if ($username && $email && $password) {
                // Kiểm tra username đã tồn tại
                if ($this->checkUsernameExists($username)) {
                    $error = "Tên đăng nhập đã tồn tại!";
                } elseif ($this->checkEmailExists($email)) {
                    $error = "Email đã được sử dụng!";
                } else {
                    if ($this->createUser($username, $email, $password, $role)) {
                        $_SESSION['success_message'] = 'Tài khoản đã được tạo thành công.';
                        header("Location: /buoi2/DashboardUser/index");
                        exit;
                    } else {
                        $error = "Có lỗi xảy ra khi tạo tài khoản!";
                    }
                }
            } else {
                $error = "Vui lòng điền đầy đủ thông tin!";
            }
        }
        
        require_once 'app/views/dashboard/user_add.php';
    }

    public function edit() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }

        $userId = intval($_GET['id'] ?? 0);
        if (!$userId) {
            $_SESSION['error_message'] = 'Không tìm thấy tài khoản.';
            header("Location: /buoi2/DashboardUser/index");
            exit;
        }

        $user = $this->getUserById($userId);
        if (!$user) {
            $_SESSION['error_message'] = 'Không tìm thấy tài khoản.';
            header("Location: /buoi2/DashboardUser/index");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'employee';
            
            if ($username && $email) {
                // Kiểm tra username đã tồn tại (trừ user hiện tại)
                $existingUser = $this->getUserByUsername($username);
                if ($existingUser && $existingUser['id'] != $userId) {
                    $error = "Tên đăng nhập đã tồn tại!";
                } else {
                    $existingEmail = $this->getUserByEmail($email);
                    if ($existingEmail && $existingEmail['id'] != $userId) {
                        $error = "Email đã được sử dụng!";
                    } else {
                        if ($this->updateUser($userId, $username, $email, $password, $role)) {
                            $_SESSION['success_message'] = 'Tài khoản đã được cập nhật thành công.';
                            header("Location: /buoi2/DashboardUser/index");
                            exit;
                        } else {
                            $error = "Có lỗi xảy ra khi cập nhật tài khoản!";
                        }
                    }
                }
            } else {
                $error = "Vui lòng điền đầy đủ thông tin!";
            }
        }
        
        require_once 'app/views/dashboard/user_edit.php';
    }

    public function delete() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /buoi2/User/login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0 && $id != $_SESSION['user_id']) { // Không cho phép xóa chính mình
                if ($this->deleteUser($id)) {
                    $_SESSION['success_message'] = 'Tài khoản đã được xóa thành công.';
                } else {
                    $_SESSION['error_message'] = 'Không thể xóa tài khoản.';
                }
            } else {
                $_SESSION['error_message'] = 'Không thể xóa tài khoản này.';
            }
        }
        
        header("Location: /buoi2/DashboardUser/index");
        exit;
    }

    // Phương thức helper - lấy tất cả users
    private function getAllUsers() {
        try {
            $query = "SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllUsers: " . $e->getMessage());
            return [];
        }
    }

    // Phương thức helper - lấy user theo ID
    private function getUserById($userId) {
        try {
            $query = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getUserById: " . $e->getMessage());
            return null;
        }
    }

    // Phương thức helper - lấy user theo username
    private function getUserByUsername($username) {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getUserByUsername: " . $e->getMessage());
            return null;
        }
    }

    // Phương thức helper - lấy user theo email
    private function getUserByEmail($email) {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getUserByEmail: " . $e->getMessage());
            return null;
        }
    }

    // Phương thức helper - kiểm tra username tồn tại
    private function checkUsernameExists($username) {
        return $this->getUserByUsername($username) !== null;
    }

    // Phương thức helper - kiểm tra email tồn tại
    private function checkEmailExists($email) {
        return $this->getUserByEmail($email) !== null;
    }

    // Phương thức helper - tạo user mới
    private function createUser($username, $email, $password, $role) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO users (username, email, password, role, created_at) VALUES (:username, :email, :password, :role, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in createUser: " . $e->getMessage());
            return false;
        }
    }

    // Phương thức helper - cập nhật user
    private function updateUser($userId, $username, $email, $password, $role) {
        try {
            if (!empty($password)) {
                // Cập nhật kèm mật khẩu
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':password', $hashedPassword);
            } else {
                // Cập nhật không thay đổi mật khẩu
                $query = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
                $stmt = $this->conn->prepare($query);
            }
            
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in updateUser: " . $e->getMessage());
            return false;
        }
    }

    // Phương thức helper - xóa user
    private function deleteUser($userId) {
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deleteUser: " . $e->getMessage());
            return false;
        }
    }

    private function getUserStats() {
        try {
            $stats = [];

            // Tổng số tài khoản
            $query = "SELECT COUNT(*) as total_users FROM users";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

            // Tài khoản admin
            $query = "SELECT COUNT(*) as admin_users FROM users WHERE role = 'admin'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['admin_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['admin_users'];

            // Tài khoản nhân viên
            $query = "SELECT COUNT(*) as employee_users FROM users WHERE role = 'employee'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stats['employee_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['employee_users'];

            // Tài khoản được tạo hôm nay
            $query = "SELECT COUNT(*) as today_users FROM users WHERE DATE(created_at) = CURDATE()";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['today_users'] = $result ? $result['today_users'] : 0;

            return $stats;

        } catch (PDOException $e) {
            error_log("Error in getUserStats: " . $e->getMessage());
            return [
                'total_users' => 0,
                'admin_users' => 0,
                'employee_users' => 0,
                'today_users' => 0
            ];
        }
    }
}
?>
