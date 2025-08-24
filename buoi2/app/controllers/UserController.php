<?php
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';

class UserController {
    private $conn;
    private $userModel;

    public function __construct() {
        // Khởi tạo kết nối cơ sở dữ liệu
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->userModel = new UserModel($this->conn);
    }

    // Thêm hàm profile để xử lý trang thông tin tài khoản
    public function profile() {

        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
        if ($_SESSION['role'] === 'admin') {
            header("Location: /buoi2/Product/index");
            exit;
        }

        $user = $this->userModel->getUserById($_SESSION['user_id']);
        if (!$user) {
            header("Location: /buoi2/User/login");
            exit;
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không đúng.";
            } else {
                if ($password !== '') {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $result = $this->userModel->updateUserProfileWithPassword($user['id'], $phone, $email, $hashedPassword);
                } else {
                    $result = $this->userModel->updateUserProfile($user['id'], $phone, $email);
                }

                if ($result) {
                    $success = "Cập nhật thông tin thành công.";
                    $user = $this->userModel->getUserById($_SESSION['user_id']); // Cập nhật lại thông tin user
                } else {
                    $error = "Cập nhật không thành công.";
                }
            }
        }

        require 'app/views/User/profile.php';
    }

    // Hiển thị danh sách tài khoản
    public function index() {
        $users = $this->userModel->getAllUsers();
        require 'app/views/User/index.php';
    }

    // Xóa tài khoản
    public function delete() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->userModel->deleteUser($id);
        }
        header("Location: /buoi2/User/index");
        exit;
    }

    // Trang sửa tài khoản
    public function edit() {
        $error = null;
        if (!isset($_GET['id'])) {
            header("Location: /buoi2/DashboardUser/index");
            exit;
        }
        $id = intval($_GET['id']);
        $users = $this->userModel->getAllUsers();
        $user = null;
        foreach ($users as $u) {
            if ($u['id'] === $id) {
                $user = $u;
                break;
            }
        }
        if (!$user) {
            header("Location: /buoi2/DashboardUser/index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'];
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không đúng.";
            } else {
                if ($password !== '') {
                    // Mã hóa mật khẩu mới
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    // Cập nhật username, phone, email, role và password
                    $query = "UPDATE users SET username = :username, phone = :phone, email = :email, role = :role, password = :password WHERE id = :id";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $result = $stmt->execute();
                } else {
                    // Cập nhật username, phone, email và role, không đổi mật khẩu
                    $query = "UPDATE users SET username = :username, phone = :phone, email = :email, role = :role WHERE id = :id";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $result = $stmt->execute();
                }

                if ($result) {
                    header("Location: /buoi2/DashboardUser/index");
                    exit;
                } else {
                    $error = "Cập nhật không thành công.";
                }
            }
        }
        require 'app/views/User/edit.php';
    }

    // Trang đăng nhập
public function login() {
    $error = null; // Biến lưu lỗi để truyền sang view

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Chuẩn bị câu lệnh SQL
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Kiểm tra session đã được bắt đầu
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            // Redirect theo role
            if ($user['role'] === 'admin') {
                header("Location: /buoi2/Dashboard");
            } else {
                header("Location: /buoi2/Product/");
            }
            exit;
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    }

    // Truyền biến $error sang view
    require_once 'app/views/User/login.php';
}

    // Trang quên mật khẩu - bước 1: xác thực thông tin
    public function forgotPasswordStep1() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            $user = $this->userModel->checkUserByUsernamePhoneEmail($username, $phone, $email);
            if ($user) {
                // Lưu id user vào session để bước 2 sử dụng
                session_start();
                $_SESSION['reset_user_id'] = $user['id'];
                header("Location: /buoi2/User/forgotPasswordStep2");
                exit;
            } else {
                $error = "Thông tin không khớp với tài khoản nào.";
            }
        }

        require 'app/views/User/forgot_password_step1.php';
    }

    // Trang quên mật khẩu - bước 2: nhập mật khẩu mới
    public function forgotPasswordStep2() {
        session_start();
        if (!isset($_SESSION['reset_user_id'])) {
            header("Location: /buoi2/User/forgotPasswordStep1");
            exit;
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không đúng.";
            } else {
                $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
                if ($this->userModel->updatePassword($_SESSION['reset_user_id'], $hashedPassword)) {
                    $success = "Đặt lại mật khẩu thành công. Bạn có thể đăng nhập với mật khẩu mới.";
                    unset($_SESSION['reset_user_id']);
                } else {
                    $error = "Đặt lại mật khẩu không thành công. Vui lòng thử lại.";
                }
            }
        }

        require 'app/views/User/forgot_password_step2.php';
    }

    // Đăng xuất
    public function logout() {
        session_start();
        session_destroy();
        header("Location: /buoi2/Product/");
        exit;
    }

    // Trang đăng ký
    public function register() {
        $error = null; // Biến lưu lỗi để truyền sang view

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Kiểm tra mật khẩu xác nhận
            if ($password !== $confirmPassword) {
                $error = "Mật khẩu xác nhận không đúng.";
            } else {
                // Kiểm tra username đã tồn tại chưa
                $checkQuery = "SELECT id FROM users WHERE username = :username";
                $checkStmt = $this->conn->prepare($checkQuery);
                $checkStmt->bindValue(':username', $username, PDO::PARAM_STR);
                $checkStmt->execute();
                if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
                    $error = "Tên đăng nhập đã tồn tại.";
                } else {
                    // Mã hóa mật khẩu
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                    // Chuẩn bị câu lệnh SQL
                    $query = "INSERT INTO users (username, phone, email, password) VALUES (:username, :phone, :email, :password)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
                    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        header("Location: /buoi2/DashboardUser/index");
                        exit;
                    } else {
                        $error = "Đăng ký không thành công. Vui lòng thử lại.";
                    }
                }
            }
        }

        // Truyền biến $error sang view
        require_once 'app/views/User/register.php';
    }
}
