<?php
// Tạo session name unique dựa trên query parameter để hỗ trợ đa phiên đăng nhập
$sessionId = $_GET['session_id'] ?? 'default';
$sessionName = 'PHPSESSID_' . preg_replace('/[^a-zA-Z0-9]/', '', $sessionId);
session_name($sessionName);
session_start();

// Tắt error reporting cho API requests
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xử lý API routes trước - hỗ trợ cả uppercase và lowercase
if (isset($url[0]) && (strtolower($url[0]) === 'api' || $url[0] === 'Api')) {
    // Tắt error output cho API
    error_reporting(E_ERROR | E_PARSE);
    ini_set('display_errors', 0);
    
    // Clear any previous output
    ob_clean();
    
    // Set headers cho API
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    // Handle preflight OPTIONS request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
    
    $resource = isset($url[1]) ? strtolower($url[1]) : '';
    $id = $url[2] ?? null;
    $method = $_SERVER['REQUEST_METHOD'];
    
    try {
        require_once 'app/models/ProductModel.php';
        require_once 'app/controllers/ProductApiController.php';
        require_once 'app/controllers/CategoryApiController.php';
        
        switch ($resource) {
            case 'product':
                $controller = new ProductApiController();
                switch ($method) {
                    case 'GET':
                        if ($id) {
                            $controller->show($id);
                        } else {
                            $controller->index();
                        }
                        break;
                    case 'POST':
                        $controller->store();
                        break;
                    case 'PUT':
                        if ($id) {
                            $controller->update($id);
                        } else {
                            http_response_code(400);
                            echo json_encode(['message' => 'ID là bắt buộc để cập nhật']);
                        }
                        break;
                    case 'DELETE':
                        if ($id) {
                            $controller->destroy($id);
                        } else {
                            http_response_code(400);
                            echo json_encode(['message' => 'ID là bắt buộc để xóa']);
                        }
                        break;
                    default:
                        http_response_code(405);
                        echo json_encode(['message' => 'Phương thức không được phép']);
                        break;
                }
                break;
                
            case 'category':
                require_once 'app/controllers/CategoryApiController.php';
                $controller = new CategoryApiController();
                switch ($method) {
                    case 'GET':
                        $controller->index();
                        break;
                    case 'POST':
                        $controller->store();
                        break;
                    case 'PUT':
                        if ($id) {
                            $controller->update($id);
                        } else {
                            http_response_code(400);
                            echo json_encode(['message' => 'ID là bắt buộc để cập nhật']);
                        }
                        break;
                    case 'DELETE':
                        if ($id) {
                            $controller->destroy($id);
                        } else {
                            http_response_code(400);
                            echo json_encode(['message' => 'ID là bắt buộc để xóa']);
                        }
                        break;
                    default:
                        http_response_code(405);
                        echo json_encode(['message' => 'Phương thức không được phép']);
                        break;
                }
                break;
                
            case 'user':
                require_once 'app/controllers/UserApiController.php';
                $controller = new UserApiController();
                switch ($method) {
                    case 'POST':
                        $controller->store();
                        break;
                    default:
                        http_response_code(405);
                        echo json_encode(['message' => 'Phương thức không được phép']);
                        break;
                }
                break;
                
            default:
                http_response_code(404);
                echo json_encode(['message' => 'Không tìm thấy API resource']);
                break;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Lỗi server nội bộ: ' . $e->getMessage()]);
    }
    exit;
}

// Phần routing cũ cho web interface
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : '';

// Nếu không có controller được chỉ định (truy cập trang chủ), chuyển hướng đến trang đăng nhập
if ($controllerName == '') {
    // Kiểm tra nếu đã đăng nhập thì chuyển đến trang sản phẩm
    if (isset($_SESSION['user_id'])) {
        header("Location: /buoi2/Product/index");
        exit;
    } else {
        // Nếu chưa đăng nhập, chuyển đến trang đăng nhập
        header("Location: /buoi2/User/login");
        exit;
    }
}

$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Kiểm tra đăng nhập cho các trang yêu cầu xác thực
// Các controller/actions công cộng không yêu cầu đăng nhập
$publicControllers = ['User'];
$publicActions = [
    'User' => ['login', 'register', 'forgotPasswordStep1', 'forgotPasswordStep2']
];

// Kiểm tra nếu controller không phải là controller công cộng
if (!in_array(str_replace('Controller', '', $controllerName), $publicControllers)) {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user_id'])) {
        header("Location: /buoi2/User/login");
        exit;
    }
} else {
    // Kiểm tra action công cộng trong controller công cộng
    $controllerShortName = str_replace('Controller', '', $controllerName);
    if (isset($publicActions[$controllerShortName]) && !in_array($action, $publicActions[$controllerShortName])) {
        // Nếu action không nằm trong danh sách công cộng, kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: /buoi2/User/login");
            exit;
        }
    }
}

// Thêm require cho CustomerController nếu cần
if ($controllerName === 'CustomerController') {
    require_once 'app/controllers/CustomerController.php';
}

// Tạo đối tượng controller tương ứng cho các yêu cầu không phải API
if (file_exists('app/controllers/' . $controllerName . '.php')) {
    require_once 'app/controllers/' . $controllerName . '.php';
    $controller = new $controllerName();
} else {
    die('Controller not found');
}

// Kiểm tra và gọi action
if (method_exists($controller, $action)) {
    call_user_func_array([$controller, $action], array_slice($url, 2));
} else {
    die('Action not found');
}
?>