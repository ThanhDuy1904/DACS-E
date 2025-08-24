<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Khuyến mãi - Quản trị hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .main-container {
            background: #ffffff;
            border-radius: 20px;
            margin: 20px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        
        .stats-card {
            border: 1px solid #e9ecef;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ffc107, #fd7e14);
        }
        
        .stats-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .table-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        
        .table-header {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
            padding: 1.5rem 2rem;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .welcome-section {
            background: #ffffff;
            color: #333;
            padding: 2.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/buoi2/Dashboard">
                <i class="fas fa-percent me-2"></i>
                Dashboard Khuyến mãi
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/buoi2/Dashboard">
                    <i class="fas fa-arrow-left me-1"></i>Quay lại Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="main-container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2 text-dark">
                            <i class="fas fa-percent me-3" style="color: #ffc107;"></i>
                            Quản lý Khuyến mãi
                        </h2>
                        <p class="mb-0 text-muted">Thống kê và quản lý tất cả mã khuyến mãi trong hệ thống</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="/buoi2/DashboardDiscount/add" class="btn" style="background: linear-gradient(135deg, #ffc107, #fd7e14); color: white;">
                            <i class="fas fa-plus me-2"></i>Tạo khuyến mãi mới
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ffc107, #fd7e14); margin: 0 auto;">
                                <i class="fas fa-percent text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($discountStats['total_discounts']) ?></h3>
                            <p class="text-muted mb-0">Tổng khuyến mãi</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); margin: 0 auto;">
                                <i class="fas fa-calendar-day text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #667eea;"><?= number_format($discountStats['today_discounts']) ?></h3>
                            <p class="text-muted mb-0">Tạo hôm nay</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discount List -->
            <div class="table-container">
                <h5 class="table-header"><i class="fas fa-list me-2"></i>Danh sách khuyến mãi</h5>
                <div class="table-responsive">
                    <?php if (!empty($allDiscounts)): ?>
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">ID</th>
                                    <th class="text-dark">Mã khuyến mãi</th>
                                    <th class="text-dark">Tên khuyến mãi</th>
                                    <th class="text-dark">Ngày tạo</th>
                                    <th class="text-dark">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allDiscounts as $discount): ?>
                                    <tr>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($discount['id']) ?></span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2" style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #ffc107, #fd7e14); display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-percent text-white fa-sm"></i>
                                                </div>
                                                <strong style="color: #ffc107;"><?= htmlspecialchars($discount['maDiscount']) ?></strong>
                                            </div>
                                        </td>
                                        <td class="text-dark"><?= htmlspecialchars($discount['tenDiscount']) ?></td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= isset($discount['created_at']) ? date('d/m/Y H:i', strtotime($discount['created_at'])) : 'N/A' ?>
                                            </small>
                                        </td>
                                        <td>
                                            <form method="POST" action="/buoi2/DashboardDiscount/delete" class="d-inline" 
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?')">
                                                <input type="hidden" name="id" value="<?= $discount['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-percent fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có khuyến mãi nào</p>
                            <a href="/buoi2/DashboardDiscount/add" class="btn" style="background: linear-gradient(135deg, #ffc107, #fd7e14); color: white;">
                                <i class="fas fa-plus me-2"></i>Tạo khuyến mãi đầu tiên
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
