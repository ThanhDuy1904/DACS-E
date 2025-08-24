<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khuyến mãi - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 50px auto;
            padding: 40px;
            max-width: 600px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .btn-action {
            border-radius: 20px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .form-control:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 8px rgba(255, 107, 107, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="text-center mb-4">
                <a href="/buoi2/DashboardDiscount/index" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                </a>
                <h2 style="color: #ff6b6b;">
                    <i class="fas fa-percent me-3"></i>
                    Thêm Khuyến mãi Mới
                </h2>
                <p class="text-muted">Tạo mã khuyến mãi cho khách hàng</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="maDiscount" class="form-label">
                        <i class="fas fa-tag me-2"></i>Mã khuyến mãi
                    </label>
                    <input type="text" class="form-control" id="maDiscount" name="maDiscount" 
                           placeholder="VD: GIAM10, FREESHIP..." required>
                    <div class="form-text">Mã khuyến mãi phải là duy nhất và dễ nhớ</div>
                </div>

                <div class="mb-4">
                    <label for="tenDiscount" class="form-label">
                        <i class="fas fa-edit me-2"></i>Tên khuyến mãi
                    </label>
                    <input type="text" class="form-control" id="tenDiscount" name="tenDiscount" 
                           placeholder="VD: Giảm giá 10% cho đơn hàng đầu tiên..." required>
                    <div class="form-text">Mô tả chi tiết về khuyến mãi</div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-action w-100" 
                                style="background: linear-gradient(135deg, #ff6b6b, #feca57); color: white;">
                            <i class="fas fa-save me-2"></i>Tạo khuyến mãi
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="/buoi2/DashboardDiscount/index" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-2"></i>Hủy bỏ
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
