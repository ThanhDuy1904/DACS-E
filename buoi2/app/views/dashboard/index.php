<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Quản trị hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000000;
        }
        
        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .stats-card {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            border: 1px solid #e9ecef;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .stats-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        
        .stats-card .card-body {
            padding: 2.5rem;
            text-align: center;
        }
        
        .stats-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .stats-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg);
            transition: all 0.5s;
        }
        
        .stats-card:hover .stats-icon::before {
            animation: shimmer 1s ease-in-out;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .bg-primary-gradient { background: linear-gradient(135deg, #667eea, #764ba2); }
        .bg-success-gradient { background: linear-gradient(135deg, #56ab2f, #a8e6cf); }
        .bg-warning-gradient { background: linear-gradient(135deg, #ffecd2, #fcb69f); }
        .bg-info-gradient { background: linear-gradient(135deg, #89f7fe, #66a6ff); }
        .bg-danger-gradient { background: linear-gradient(135deg, #ff9a9e, #fecfef); }
        .bg-purple-gradient { background: linear-gradient(135deg, #a8edea, #fed6e3); }
        
        .stats-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            line-height: 1;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .chart-container {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        
        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
            background-size: 200% 100%;
            animation: gradientMove 3s ease-in-out infinite;
        }
        
        @keyframes gradientMove {
            0%, 100% { background-position: 0% 0%; }
            50% { background-position: 100% 0%; }
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }
        
        .period-buttons .btn {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .period-buttons .btn:not(.active) {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-color: rgba(102, 126, 234, 0.2);
        }
        
        .period-buttons .btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .period-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .table-container {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        
        .table-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1.5rem 2rem;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .welcome-section {
            background: #ffffff;
            backdrop-filter: blur(10px);
            color: #000000;
            padding: 2.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        
        .time-stats {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .action-btn {
            border-radius: 20px;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translate(-50%, -50%);
        }
        
        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .chart-canvas {
            border-radius: 15px;
            background: rgba(255,255,255,0.5);
            padding: 20px;
        }
        
        .navbar-brand {
            font-size: 2.5rem !important;
            font-weight: 800 !important;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .view-web-link {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff !important;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            margin-right: 15px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .view-web-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            color: #ffffff !important;
            background: linear-gradient(135deg, #764ba2, #667eea);
        }
        
        .navbar-nav-right {
            display: flex;
            align-items: center;
        }
        
        .nav-link.dropdown-toggle {
            font-size: 1.3rem !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            padding: 0.75rem 1rem !important;
        }
        
        .nav-link.dropdown-toggle i {
            font-size: 1.2rem !important;
            margin-right: 0.5rem !important;
        }
        
        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                padding: 20px;
            }
            .stats-card .card-body {
                padding: 1.5rem;
            }
            .stats-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/buoi2/Dashboard">
                <i class="fas fa-tachometer-alt me-3"></i>
                Dashboard
            </a>
            <div class="navbar-nav-right ms-auto">
                <a href="/buoi2/Product/index" class="view-web-link">
                    <i class="fas fa-globe me-2"></i>
                    ViewWeb
                </a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/buoi2/User/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">Chào mừng trở lại, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
                    <p class="mb-0 text-muted">Đây là trang quản lý của bạn</p>
                </div>
                <div class="col-md-4 text-end">
                    <h4 class="mb-0"><?= date('d/m/Y') ?></h4>
                    <p class="mb-0 text-muted" id="currentTime"><?= date('H:i:s') ?></p>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/buoi2/Dashboard">Trang chủ</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon bg-primary-gradient mx-auto">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['total_users'] ?>"><?= number_format($stats['total_users']) ?></h3>
                        <p class="stats-label">Tài khoản</p>
                        <div onclick="window.location.href='/buoi2/DashboardUser/index'" class="action-btn w-100" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; cursor: pointer;">
                            <i class="fas fa-eye me-2"></i>Chi tiết
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon bg-success-gradient mx-auto">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['valid_orders'] ?>"><?= number_format($stats['valid_orders']) ?></h3>
                        <p class="stats-label">Đơn hàng hợp lệ</p>
                        <div onclick="window.location.href='/buoi2/DashboardOrder/index'" class="action-btn w-100" style="background: linear-gradient(135deg, #56ab2f, #a8e6cf); color: white; cursor: pointer;">
                            <i class="fas fa-eye me-2"></i>Chi tiết
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #ff6b6b, #ff5252);">
                            <i class="fas fa-ban"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['cancelled_orders'] ?>"><?= number_format($stats['cancelled_orders']) ?></h3>
                        <p class="stats-label">Đơn hàng đã hủy</p>
                        <div onclick="window.location.href='/buoi2/DashboardOrder/index'" class="action-btn w-100" style="background: linear-gradient(135deg, #ff6b6b, #ff5252); color: white; cursor: pointer;">
                            <i class="fas fa-eye me-2"></i>Chi tiết
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon bg-warning-gradient mx-auto">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['total_products'] ?>"><?= number_format($stats['total_products']) ?></h3>
                        <p class="stats-label">Sản phẩm</p>
                        <div onclick="window.location.href='/buoi2/DashboardProduct/index'" class="action-btn w-100" style="background: linear-gradient(135deg, #ffecd2, #fcb69f); color: #333; cursor: pointer;">
                            <i class="fas fa-eye me-2"></i>Chi tiết
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon bg-info-gradient mx-auto">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['total_categories'] ?>"><?= number_format($stats['total_categories']) ?></h3>
                        <p class="stats-label">Danh mục</p>
                        <div onclick="window.location.href='/buoi2/DashboardCategory/index'" class="action-btn w-100" style="background: linear-gradient(135deg, #89f7fe, #66a6ff); color: white; cursor: pointer;">
                            <i class="fas fa-eye me-2"></i>Chi tiết
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon bg-purple-gradient mx-auto">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['total_customers'] ?>"><?= number_format($stats['total_customers']) ?></h3>
                        <p class="stats-label">Khách hàng</p>
                        <div onclick="window.location.href='/buoi2/DashboardCustomer/index'" class="action-btn w-100" style="background: linear-gradient(135deg, #a8edea, #fed6e3); color: #333; cursor: pointer;">
                            <i class="fas fa-eye me-2"></i>Chi tiết
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2 - Thêm dòng thứ 2 cho các card còn lại -->
        <div class="row mb-5">
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #ff6b6b, #feca57);">
                            <i class="fas fa-percent"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['total_promotions'] ?>"><?= number_format($stats['total_promotions']) ?></h3>
                        <p class="stats-label">Khuyến mãi</p>
                        <div onclick="window.location.href='/buoi2/DashboardDiscount/index'" class="action-btn w-100" style="background: linear-gradient(135deg, #ff6b6b, #feca57); color: white; cursor: pointer;">
                            <i class="fas fa-eye me-2"></i>Chi tiết
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card stats-card h-100">
                    <div class="card-body">
                        <div class="stats-icon bg-danger-gradient mx-auto">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 class="stats-number" data-target="<?= $stats['total_revenue'] ?>"><?= number_format($stats['total_revenue']) ?>đ</h3>
                        <p class="stats-label">Doanh thu hợp lệ</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Revenue Chart -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="chart-container">
                    <div class="chart-header">
                        <h2 class="chart-title">
                            <i class="fas fa-chart-area me-3"></i>Biểu Đồ Doanh Thu Chi Tiết
                        </h2>
                        <div class="period-buttons btn-group" role="group">
                            <button type="button" class="btn active" data-period="7days">7 Ngày</button>
                            <button type="button" class="btn" data-period="30days">30 Ngày</button>
                            <button type="button" class="btn" data-period="months">12 Tháng</button>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 style="color: #667eea; font-weight: 700;"><?= number_format($timeStats['today_revenue']) ?>đ</h4>
                                <small class="text-muted">Doanh thu hôm nay</small>
                                <div class="mt-1">
                                    <span class="badge bg-success"><i class="fas fa-arrow-up me-1"></i>Hôm nay</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 style="color: #56ab2f; font-weight: 700;"><?= number_format($timeStats['today_orders']) ?></h4>
                                <small class="text-muted">Đơn hàng hôm nay (hợp lệ)</small>
                                <div class="mt-1">
                                    <span class="badge bg-success"><i class="fas fa-shopping-cart me-1"></i>Đơn</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 style="color: #fcb69f; font-weight: 700;"><?= number_format($timeStats['week_orders']) ?></h4>
                                <small class="text-muted">Đơn hàng tuần này (hợp lệ)</small>
                                <div class="mt-1">
                                    <span class="badge bg-warning"><i class="fas fa-calendar-week me-1"></i>Tuần</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 style="color: #ff9a9e; font-weight: 700;"><?= number_format($timeStats['month_orders']) ?></h4>
                                <small class="text-muted">Đơn hàng tháng này (hợp lệ)</small>
                                <div class="mt-1">
                                    <span class="badge bg-info"><i class="fas fa-calendar-alt me-1"></i>Tháng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="chart-canvas">
                        <canvas id="revenueChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-lg-4">
                <div class="table-container">
                    <h5 class="table-header"><i class="fas fa-star me-2"></i>Top sản phẩm bán chạy</h5>
                    <div class="p-3">
                        <?php if (!empty($topProducts)): ?>
                            <?php foreach ($topProducts as $index => $product): ?>
                                <div class="d-flex align-items-center mb-3 <?= $index < count($topProducts) - 1 ? 'border-bottom pb-3' : '' ?>">
                                    <div class="position-relative me-3">
                                        <?php if (!empty($product['image'])): ?>
                                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                                        <?php else: ?>
                                            <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                            #<?= $index + 1 ?>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($product['name']) ?></h6>
                                        <small class="text-muted">Đã bán: <?= number_format($product['total_sold']) ?></small><br>
                                        <small class="text-success fw-bold"><?= number_format($product['revenue']) ?>đ</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có dữ liệu sản phẩm</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="table-container">
                    <h5 class="table-header"><i class="fas fa-shopping-bag me-2"></i>Đơn hàng gần đây</h5>
                    <div class="table-responsive">
                        <?php if (!empty($recentOrders)): ?>
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>Thời gian</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td><strong>#<?= $order['id'] ?></strong></td>
                                            <td>
                                                <?php if (!empty($order['customer_name'])): ?>
                                                    <i class="fas fa-user me-1 text-muted"></i>
                                                    <?= htmlspecialchars($order['customer_name']) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">
                                                        <i class="fas fa-user-slash me-1"></i>
                                                        Khách vãng lai
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($order['phone'])): ?>
                                                    <i class="fas fa-phone me-1 text-muted"></i>
                                                    <?= htmlspecialchars($order['phone']) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-clock me-1 text-muted"></i>
                                                <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = 'bg-secondary';
                                                $statusIcon = 'fas fa-question';
                                                switch ($order['status']) {
                                                    case 'Đang chuẩn bị':
                                                        $statusClass = 'bg-warning text-dark';
                                                        $statusIcon = 'fas fa-clock';
                                                        break;
                                                    case 'Đang giao':
                                                        $statusClass = 'bg-info';
                                                        $statusIcon = 'fas fa-truck';
                                                        break;
                                                    case 'Hoàn thành':
                                                    case 'đã hoàn thành':
                                                        $statusClass = 'bg-success';
                                                        $statusIcon = 'fas fa-check';
                                                        break;
                                                    case 'Đã hủy':
                                                        $statusClass = 'bg-danger';
                                                        $statusIcon = 'fas fa-times';
                                                        break;
                                                }
                                                ?>
                                                <span class="status-badge <?= $statusClass ?>">
                                                    <i class="<?= $statusIcon ?> me-1"></i>
                                                    <?= htmlspecialchars($order['status']) ?>
                                                </span>
                                                
                                                <?php if ($order['status'] === 'Đã hủy' && !empty($order['cancel_reason'])): ?>
                                                    <div class="mt-2" style="background: #fef2f2; color: #dc2626; padding: 0.5rem; border-radius: 8px; font-size: 0.75rem; border-left: 3px solid #dc2626; line-height: 1.3;">
                                                        <strong>💥 Lý do hủy:</strong><br>
                                                        <?= htmlspecialchars($order['cancel_reason']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($order['status'] === 'Đã hủy'): ?>
                                                    <strong style="color: #dc2626; text-decoration: line-through;">
                                                        <i class="fas fa-money-bill-wave me-1"></i>
                                                        <?= number_format($order['total_amount'] ?? 0) ?>đ
                                                    </strong>
                                                    <br><small class="text-muted">(Không tính doanh thu)</small>
                                                <?php else: ?>
                                                    <strong class="text-success">
                                                        <i class="fas fa-money-bill-wave me-1"></i>
                                                        <?= number_format($order['total_amount'] ?? 0) ?>đ
                                                    </strong>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    
                                                    <button onclick="window.location.href='/buoi2/Order/edit?id=<?= $order['id'] ?>'" class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có đơn hàng nào</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($recentOrders)): ?>
                        <div class="p-3 bg-light text-center">
                            <button onclick="window.location.href='/buoi2/DashboardOrder/index'" class="btn btn-primary">
                                <i class="fas fa-list me-1"></i>
                                Xem tất cả đơn hàng
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <h2 class="chart-title mb-4">
                        <i class="fas fa-bolt me-3"></i>Thao Tác Nhanh
                    </h2>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/Product/add'" class="action-btn w-100 text-center py-4" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; cursor: pointer;">
                                <i class="fas fa-plus-circle fa-2x d-block mb-3"></i>
                                <h5 class="mb-0">Thêm Sản Phẩm</h5>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/Category/add'" class="action-btn w-100 text-center py-4" style="background: linear-gradient(135deg, #56ab2f, #a8e6cf); color: white; cursor: pointer;">
                                <i class="fas fa-tags fa-2x d-block mb-3"></i>
                                <h5 class="mb-0">Thêm Danh Mục</h5>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/DashboardDiscount/add'" class="action-btn w-100 text-center py-4" style="background: linear-gradient(135deg, #ff6b6b, #feca57); color: white; cursor: pointer;">
                                <i class="fas fa-percent fa-2x d-block mb-3"></i>
                                <h5 class="mb-0">Tạo Khuyến Mãi</h5>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/User/register'" class="action-btn w-100 text-center py-4" style="background: linear-gradient(135deg, #48dbfb, #0abde3); color: white; cursor: pointer;">
                                <i class="fas fa-user-plus fa-2x d-block mb-3"></i>
                                <h5 class="mb-0">Tạo Tài Khoản</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit', 
                second: '2-digit',
                hour12: false
            });
            document.getElementById('currentTime').textContent = timeString;
        }

        // Update time immediately and then every second
        updateTime();
        setInterval(updateTime, 1000);

        // Advanced Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        let revenueChart;

        function initChart() {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
            gradient.addColorStop(0.5, 'rgba(118, 75, 162, 0.4)');
            gradient.addColorStop(1, 'rgba(118, 75, 162, 0.1)');

            const borderGradient = ctx.createLinearGradient(0, 0, 0, 400);
            borderGradient.addColorStop(0, '#667eea');
            borderGradient.addColorStop(1, '#764ba2');

            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // Sẽ được cập nhật từ API
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: [], // Sẽ được cập nhật từ API
                        borderColor: '#667eea',
                        backgroundColor: gradient,
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#667eea',
                        pointBorderWidth: 3,
                        pointRadius: 8,
                        pointHoverRadius: 12,
                        pointHoverBackgroundColor: '#667eea',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6c757d',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6c757d',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND',
                                        minimumFractionDigits: 0
                                    }).format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#667eea',
                            borderWidth: 2,
                            cornerRadius: 10,
                            displayColors: false,
                            titleFont: {
                                size: 14,
                                weight: '600'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                title: function(context) {
                                    return 'Ngày: ' + context[0].label;
                                },
                                label: function(context) {
                                    return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND',
                                        minimumFractionDigits: 0
                                    }).format(context.parsed.y);
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutCubic'
                    }
                }
            });
        }

        function updateChart(period) {
            // Gọi API để lấy dữ liệu thực từ server
            fetch(`/buoi2/Dashboard/getStatsApi?type=revenue&period=${period}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const labels = data.map(item => {
                        const date = new Date(item.date);
                        if (period === 'months') {
                            return date.toLocaleDateString('vi-VN', { year: 'numeric', month: 'short' });
                        } else {
                            return date.toLocaleDateString('vi-VN');
                        }
                    });
                    const revenues = data.map(item => parseFloat(item.revenue) || 0);
                    
                    revenueChart.data.labels = labels;
                    revenueChart.data.datasets[0].data = revenues;
                    revenueChart.update('active');
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                    // Fallback to demo data if API fails
                    let newData, newLabels;
                    
                    switch(period) {
                        case '7days':
                            newLabels = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
                            newData = [0, 0, 0, 0, 0, 0, 0]; // Mặc định là 0 khi không có dữ liệu
                            break;
                        case '30days':
                            newLabels = Array.from({length: 30}, (_, i) => `${i+1}/11`);
                            newData = Array.from({length: 30}, () => 0);
                            break;
                        case 'months':
                            newLabels = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];
                            newData = Array.from({length: 12}, () => 0);
                            break;
                    }
                    
                    revenueChart.data.labels = newLabels;
                    revenueChart.data.datasets[0].data = newData;
                    revenueChart.update('active');
                });
        }

        // Initialize chart
        initChart();
        // Load initial data
        updateChart('7days');

        // Period buttons handler
        document.querySelectorAll('.period-buttons .btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.period-buttons .btn').forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                // Update chart
                updateChart(this.dataset.period);
            });
        });

        // Animation on load
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stats cards
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.8s cubic-bezier(0.4, 0.0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });

            // Animate chart container
            const chartContainer = document.querySelector('.chart-container');
            setTimeout(() => {
                chartContainer.style.opacity = '0';
                chartContainer.style.transform = 'translateY(30px)';
                chartContainer.style.transition = 'all 1s ease';
                
                setTimeout(() => {
                    chartContainer.style.opacity = '1';
                    chartContainer.style.transform = 'translateY(0)';
                }, 100);
            }, 800);
        });

        // Counter animation for stats numbers - sử dụng dữ liệu thực từ server
        function animateCounter(element, target) {
            const originalValue = target;
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    // Hiển thị giá trị gốc với format đúng
                    if (element.textContent.includes('đ')) {
                        element.textContent = new Intl.NumberFormat('vi-VN').format(originalValue) + 'đ';
                    } else {
                        element.textContent = new Intl.NumberFormat('vi-VN').format(originalValue);
                    }
                    clearInterval(timer);
                } else {
                    const currentFormatted = new Intl.NumberFormat('vi-VN').format(Math.floor(current));
                    if (element.textContent.includes('đ')) {
                        element.textContent = currentFormatted + 'đ';
                    } else {
                        element.textContent = currentFormatted;
                    }
                }
            }, 20);
        }

        // Start counter animations when page loads
        setTimeout(() => {
            document.querySelectorAll('.stats-number[data-target]').forEach(el => {
                const target = parseInt(el.getAttribute('data-target'));
                if (!isNaN(target)) {
                    animateCounter(el, target);
                }
            });
        }, 1000);

        // Auto refresh chart every 30 seconds
        setInterval(() => {
            const activeButton = document.querySelector('.period-buttons .btn.active');
            if (activeButton) {
                updateChart(activeButton.dataset.period);
            }
        }, 30000);

        // Add hover effects to action buttons
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.05)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>