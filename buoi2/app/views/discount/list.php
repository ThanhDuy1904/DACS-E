<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Danh sách mã giảm giá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            margin-top: 2rem;
            margin-bottom: 2rem;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .main-content {
            padding: 2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .table {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            border: none;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            color: #495057;
            font-weight: 700;
            font-size: 1rem;
            padding: 1.5rem 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        .table thead th:first-child {
            border-radius: 20px 0 0 0;
        }

        .table thead th:last-child {
            border-radius: 0 20px 0 0;
        }

        .table tbody td {
            border: none;
            padding: 1.5rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
            transition: all 0.3s ease;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            transform: scale(1.01);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:last-child td:first-child {
            border-radius: 0 0 0 20px;
        }

        .table tbody tr:last-child td:last-child {
            border-radius: 0 0 20px 0;
        }

        .discount-id {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            min-width: 60px;
            text-align: center;
        }

        .discount-code {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 1rem;
            display: inline-block;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .discount-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            border: none;
            border-radius: 25px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ff5252 0%, #d32f2f 100%);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            font-size: 5rem;
            color: #e0e0e0;
            margin-bottom: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        .empty-state h4 {
            color: #6c757d;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .empty-state p {
            color: #adb5bd;
            font-size: 1.1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .page-header {
                padding: 2rem 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .table-responsive {
                border-radius: 20px;
                overflow: hidden;
            }
            
            .container {
                margin-top: 1rem;
                margin-bottom: 1rem;
                border-radius: 20px;
            }
        }

        /* Loading Animation */
        .table tbody tr {
            animation: slideUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .table tbody tr:nth-child(1) { animation-delay: 0.1s; }
        .table tbody tr:nth-child(2) { animation-delay: 0.2s; }
        .table tbody tr:nth-child(3) { animation-delay: 0.3s; }
        .table tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .table tbody tr:nth-child(5) { animation-delay: 0.5s; }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <?php include 'app/views/shares/header.php'; ?>

    <div class="container mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="bi bi-tags-fill me-3"></i>Danh sách mã giảm giá
                    </h1>
                    <p class="page-subtitle mb-0">Quản lý tất cả mã giảm giá của cửa hàng</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="/buoi2/Discount/add" class="btn btn-primary">
                        <i class="bi bi-plus-circle-fill me-2"></i>Thêm mã giảm giá mới
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <?php if (!empty($discounts)): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><i class="bi bi-hash me-2"></i>ID</th>
                                <th><i class="bi bi-tag-fill me-2"></i>Mã giảm giá</th>
                                <th><i class="bi bi-card-text me-2"></i>Số tiền giảm giá</th>
                                <th><i class="bi bi-gear-fill me-2"></i>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($discounts as $discount): ?>
                                <tr>
                                    <td>
                                        <span class="discount-id"><?= htmlspecialchars($discount['id']) ?></span>
                                    </td>
                                    <td>
                                        <span class="discount-code"><?= htmlspecialchars($discount['maDiscount']) ?></span>
                                    </td>
                                    <td>
                                        <span class="discount-name"><?= htmlspecialchars($discount['tenDiscount']) ?></span>
                                    </td>
                                    <td>
                                        <form method="POST" action="/buoi2/Discount/delete" onsubmit="return confirm('Bạn có chắc muốn xóa mã giảm giá này?');" class="d-inline">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($discount['id']) ?>" />
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3-fill me-1"></i>Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h4>Chưa có mã giảm giá nào</h4>
                    <p>Hãy tạo mã giảm giá đầu tiên cho cửa hàng của bạn</p>
                    <a href="/buoi2/Discount/add" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle-fill me-2"></i>Tạo mã giảm giá đầu tiên
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'app/views/shares/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>