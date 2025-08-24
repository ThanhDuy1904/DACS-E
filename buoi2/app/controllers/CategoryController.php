<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        include 'app/views/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $result = $this->categoryModel->addCategory($name, $description);
            if ($result) {
                header('Location: /buoi2/DashboardUser/index');
                exit();
            } else {
                echo "Lỗi khi thêm danh mục.";
            }
        }
    }

    public function edit($id)
    {
        $categories = $this->categoryModel->getCategories();
        $category = null;
        foreach ($categories as $cat) {
            if ($cat->id == $id) {
                $category = $cat;
                break;
            }
        }
        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            echo "Không tìm thấy danh mục.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $result = $this->categoryModel->updateCategory($id, $name, $description);
            if ($result) {
                header('Location: /buoi2/Category/list');
                exit();
            } else {
                echo "Lỗi khi cập nhật danh mục.";
            }
        }
    }

    public function delete($id)
{
    $categoryModel = new CategoryModel($this->db);
    if ($categoryModel->hasProducts($id)) {
        echo "Danh mục này đang có sản phẩm, không thể xóa.";
        return;
    }
    if ($categoryModel->deleteCategory($id)) {
        header('Location: /buoi2/Category/list');
        exit();
    } else {
        echo "Lỗi khi xóa danh mục.";
    }
}

}
?>