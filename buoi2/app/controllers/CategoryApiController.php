<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryApiController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Lấy danh sách danh mục
    public function index()
    {
        header('Content-Type: application/json');
        $categories = $this->categoryModel->getCategories();
        echo json_encode($categories);
    }

    // Thêm danh mục mới
    public function store()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['name'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Tên danh mục không được để trống']);
            return;
        }

        $name = $data['name'];
        $description = $data['description'] ?? '';

        if ($this->categoryModel->addCategory($name, $description)) {
            http_response_code(201);
            echo json_encode(['message' => 'Thêm danh mục thành công']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Thêm danh mục thất bại']);
        }
    }

    // Cập nhật danh mục
    public function update($id)
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['name'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Tên danh mục không được để trống']);
            return;
        }

        $name = $data['name'];
        $description = $data['description'] ?? '';

        if ($this->categoryModel->updateCategory($id, $name, $description)) {
            echo json_encode(['message' => 'Cập nhật danh mục thành công']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Cập nhật danh mục thất bại']);
        }
    }

    // Xóa danh mục
    public function destroy($id)
    {
        header('Content-Type: application/json');

        // Kiểm tra xem danh mục có sản phẩm không
        if ($this->categoryModel->hasProducts($id)) {
            http_response_code(400);
            echo json_encode(['message' => 'Không thể xóa danh mục vì có sản phẩm liên quan']);
            return;
        }

        if ($this->categoryModel->deleteCategory($id)) {
            echo json_encode(['message' => 'Xóa danh mục thành công']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Xóa danh mục thất bại']);
        }
    }
}
?>
