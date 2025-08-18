<?php
// Tạo file debug_api.php để test routing
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Bắt đầu output buffering
ob_start();

// Log request để debug
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$rawInput = file_get_contents('php://input');

error_log("=== API DEBUG ===");
error_log("Request URI: $requestUri");
error_log("Request Method: $requestMethod");
error_log("Raw Input: $rawInput");
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

// Hàm trả về JSON an toàn
function sendJsonResponse($data, $statusCode = 200) {
    ob_clean(); // Xóa mọi output trước đó
    http_response_code($statusCode);
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Xử lý CORS preflight
if ($requestMethod === 'OPTIONS') {
    sendJsonResponse(['message' => 'CORS OK']);
}

// Test basic response
if (strpos($requestUri, '/api/test') !== false) {
    sendJsonResponse([
        'message' => 'API is working',
        'time' => date('Y-m-d H:i:s'),
        'method' => $requestMethod,
        'uri' => $requestUri
    ]);
}

// Routing cho Product API
if (preg_match('/\/api\/product(?:\/(\d+))?/', $requestUri, $matches)) {
    error_log("Product API route matched");
    
    try {
        // Include files
        if (file_exists('app/config/database.php')) {
            require_once('app/config/database.php');
        } else {
            sendJsonResponse(['error' => 'Database config not found'], 500);
        }
        
        if (file_exists('app/controllers/ProductApiController.php')) {
            require_once('app/controllers/ProductApiController.php');
        } else {
            sendJsonResponse(['error' => 'ProductApiController not found'], 500);
        }
        
        $controller = new ProductApiController();
        $id = isset($matches[1]) ? intval($matches[1]) : null;
        
        error_log("Controller created, ID: $id, Method: $requestMethod");
        
        switch ($requestMethod) {
            case 'GET':
                if ($id) {
                    error_log("Calling show($id)");
                    $controller->show($id);
                } else {
                    error_log("Calling index()");
                    $controller->index();
                }
                break;
                
            case 'POST':
                error_log("Calling store()");
                $controller->store();
                break;
                
            case 'PUT':
                if ($id) {
                    error_log("Calling update($id)");
                    $controller->update($id);
                } else {
                    sendJsonResponse(['error' => 'ID required for PUT'], 400);
                }
                break;
                
            case 'DELETE':
                if ($id) {
                    error_log("Calling destroy($id)");
                    $controller->destroy($id);
                } else {
                    sendJsonResponse(['error' => 'ID required for DELETE'], 400);
                }
                break;
                
            default:
                sendJsonResponse(['error' => 'Method not allowed'], 405);
        }
        
    } catch (Exception $e) {
        error_log("Router exception: " . $e->getMessage());
        sendJsonResponse([
            'error' => 'Internal server error',
            'message' => $e->getMessage(),
            'file' => basename($e->getFile()),
            'line' => $e->getLine()
        ], 500);
    }
} else {
    // Route không tìm thấy
    error_log("No route matched for: $requestUri");
    sendJsonResponse([
        'error' => 'Route not found',
        'uri' => $requestUri,
        'method' => $requestMethod
    ], 404);
}

// Nếu đến đây thì có lỗi
error_log("Reached end of router without response");
sendJsonResponse(['error' => 'Unexpected end of router'], 500);
?>