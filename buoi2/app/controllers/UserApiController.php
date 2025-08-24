<?php
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';

class UserApiController {
    private $conn;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->userModel = new UserModel($this->conn);
    }

    // API tạo tài khoản mới qua POST
    public function store() {
        // Chỉ chấp nhận POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Phương thức không được hỗ trợ']);
            exit;
        }

        // Đọc dữ liệu JSON từ body
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $phone = $data['phone'] ?? '';
        $email = $data['email'] ?? '';
        $role = $data['role'] ?? 'customer';

        if (empty($username) || empty($password)) {
            http_response_code(400);
            echo json_encode(['error' => 'Thiếu username hoặc password']);
            exit;
        }

        // Kiểm tra username đã tồn tại chưa
        $checkQuery = "SELECT id FROM users WHERE username = :username";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindValue(':username', $username, PDO::PARAM_STR);
        $checkStmt->execute();
        if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
            http_response_code(409);
            echo json_encode(['error' => 'Tên đăng nhập đã tồn tại']);
            exit;
        }

        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Thêm user mới
        $query = "INSERT INTO users (username, phone, email, password, role, created_at) VALUES (:username, :phone, :email, :password, :role, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(['message' => 'Tạo tài khoản thành công']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Lỗi khi tạo tài khoản']);
        }
    }
}
?>
