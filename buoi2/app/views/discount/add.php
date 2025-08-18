<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thêm mã giảm giá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <?php include 'app/views/shares/header.php'; ?>

    <div class="container mt-4">
        <h1>Thêm mã giảm giá mới</h1>
        <form method="POST" action="/buoi2/Discount/add">
            <div class="mb-3">
                <label for="maDiscount" class="form-label">Mã giảm giá</label>
                <input type="text" class="form-control" id="maDiscount" name="maDiscount" required>
            </div>
            <div class="mb-3">
                <label for="tenDiscount" class="form-label">Số tiền giảm giá</label>
                <input type="text" class="form-control" id="tenDiscount" name="tenDiscount" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="/buoi2/Discount/index" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <?php include 'app/views/shares/footer.php'; ?>
</body>
</html>
