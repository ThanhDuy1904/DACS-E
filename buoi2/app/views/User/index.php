<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Hệ thống tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #ffffff;
            color: #212529;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            font-size: 15px;
        }
        thead tr {
            background-color: #0d6efd;
            color: white;
            border-radius: 10px;
        }
        thead th {
            padding: 15px 10px;
            text-align: left;
            border: none;
        }
        tbody tr {
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            transition: transform 0.2s ease;
        }
        tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            border: none;
        }
        .password-cell {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #0d6efd;
            font-size: 1.2rem;
        }
        button.btn-warning, button.btn-danger, a.btn-warning, a.btn-danger {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 5px;
        }
        a.btn-warning {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
            text-decoration: none;
        }
        a.btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: #fff;
        }
        a.btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            text-decoration: none;
        }
        a.btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include 'app/views/shares/header.php'; ?>

    <div class="container">
        <h1>Danh sách tài khoản đã đăng ký</h1>
        <a href="/buoi2/Product/index" class="btn btn-primary mb-3">Quay trở lại danh sách sản phẩm</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Mật khẩu</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td class="password-cell">
                                <input type="password" value="<?= htmlspecialchars($user['password']) ?>" readonly id="password-<?= $user['id'] ?>" class="form-control" style="border:none; background:none; padding-right: 30px;"/>
                                <span class="toggle-password" onclick="togglePassword(<?= $user['id'] ?>)">&#128065;</span>
                            </td>
                            <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td>
                                <a href="/buoi2/User/edit?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="/buoi2/User/delete?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Chưa có tài khoản nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'app/views/shares/footer.php'; ?>

    <script>
        function togglePassword(id) {
            const input = document.getElementById('password-' + id);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</body>
</html>
