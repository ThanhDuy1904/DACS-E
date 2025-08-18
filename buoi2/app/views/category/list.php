<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background-color: #ffffff;
        color: #212529;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
        max-width: 1200px;
        margin: 40px auto;
        background: rgba(255, 255, 255, 0.98);
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-top: 30px;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    thead tr {
        background: linear-gradient(120deg, #4f46e5 0%, #6366f1 100%);
        color: white;
    }

    thead th {
        padding: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    tbody tr {
        transition: all 0.3s ease;
    }

    tbody tr:hover {
        transform: translateY(-2px);
        background: #f8fafc;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    tbody td {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    button.btn-primary, button.btn-danger, button.btn-success {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }
    button.btn-primary {
        background: linear-gradient(120deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    button.btn-primary:hover {
        background-color: #084298;
        border-color: #084298;
    }
    button.btn-danger {
        background: linear-gradient(120deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    button.btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #b02a37;
    }
    button.btn-success {
        background: linear-gradient(120deg, #10b981 0%, #059669 100%);
        color: white;
    }
    button.btn-success:hover {
        background-color: #146c43;
        border-color: #146c43;
    }

    .category-form {
        background: #f8fafc;
        padding: 30px;
        border-radius: 16px;
        margin-top: 20px;
        border: 1px solid #e2e8f0;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }
</style>

<div class="container">
    <h1>Quản lý danh mục</h1>
    <?php if (!empty($categories)): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tên danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm btn-edit-category" data-id="<?= $category->id ?>" data-name="<?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>" data-description="<?= htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8') ?>">Sửa</button>
                                <a href="/buoi2/Category/delete/<?= $category->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">Chưa có danh mục nào.</p>
    <?php endif; ?>

    <button id="show-add-category-btn" class="btn btn-success mt-3">Thêm danh mục mới</button>

    <form id="add-category-form" action="/buoi2/Category/save" method="POST" style="display:none; margin-top: 15px;">
        <div class="mb-2">
            <input type="text" name="name" class="form-control" placeholder="Tên danh mục" required>
        </div>
        <div class="mb-2">
            <textarea name="description" class="form-control" placeholder="Mô tả"></textarea>
        </div>
        <button type="submit" class="btn btn-success btn-sm">Thêm</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var showAddBtn = document.getElementById('show-add-category-btn');
    var addForm = document.getElementById('add-category-form');
    showAddBtn.addEventListener('click', function() {
        if (addForm.style.display === 'none') {
            addForm.style.display = 'block';
            showAddBtn.textContent = 'Ẩn form thêm danh mục';
        } else {
            addForm.style.display = 'none';
            showAddBtn.textContent = 'Thêm danh mục mới';
        }
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
