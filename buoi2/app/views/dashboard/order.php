<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Đơn hàng - Quản trị hệ thống</title>
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
            background: linear-gradient(90deg, #28a745, #20c997);
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
            background: linear-gradient(135deg, #28a745, #20c997);
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
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/buoi2/Dashboard">
                <i class="fas fa-shopping-cart me-2"></i>
                Dashboard Đơn hàng
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
                            <i class="fas fa-shopping-cart me-3" style="color: #28a745;"></i>
                            Quản lý Đơn hàng
                        </h2>
                        <p class="mb-0 text-muted">Thống kê và quản lý tất cả đơn hàng trong hệ thống</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <?php if (!empty($statusStats)): ?>
                                <div class="small">
                                    <?php foreach ($statusStats as $status): ?>
                                        <span class="badge bg-secondary me-1">
                                            <?= htmlspecialchars($status['status']) ?>: <?= $status['count'] ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #28a745, #20c997); margin: 0 auto;">
                                <i class="fas fa-shopping-cart text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($orderStats['total_orders'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Tổng đơn hàng</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ff9a9e, #fecfef); margin: 0 auto;">
                                <i class="fas fa-money-bill-wave text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #ff9a9e;"><?= number_format($orderStats['total_revenue'] ?? 0) ?>đ</h3>
                            <p class="text-muted mb-0">Tổng doanh thu</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); margin: 0 auto;">
                                <i class="fas fa-calendar-day text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #667eea;"><?= number_format($orderStats['today_orders'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Đơn hôm nay</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ffeaa7, #fdcb6e); margin: 0 auto;">
                                <i class="fas fa-chart-line text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #fdcb6e;"><?= number_format($orderStats['today_revenue'] ?? 0) ?>đ</h3>
                            <p class="text-muted mb-0">Doanh thu hôm nay</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order List -->
            <div class="table-container">
                <h5 class="table-header"><i class="fas fa-list me-2"></i>Danh sách đơn hàng</h5>
                <div class="table-responsive">
                    <?php if (!empty($allOrders) && is_array($allOrders) && count($allOrders) > 0): ?>
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">ID</th>
                                    <th class="text-dark">Khách hàng</th>
                                    <th class="text-dark">Số điện thoại</th>
                                    <th class="text-dark">Trạng thái</th>
                                    <th class="text-dark">Số món</th>
                                    <th class="text-dark">Tổng tiền</th>
                                    <th class="text-dark">Ngày đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allOrders as $order): ?>
                                    <tr>
                                        <td><span class="badge bg-primary">#<?= htmlspecialchars($order['id']) ?></span></td>
                                        <td class="text-dark">
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
                                        <td class="text-dark"><?= htmlspecialchars($order['phone'] ?? '-') ?></td>
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
                                                <div class="mt-2" style="background: #fef2f2; color: #dc2626; padding: 0.5rem; border-radius: 8px; font-size: 0.8rem; border-left: 3px solid #dc2626;">
                                                    <strong>💥 Lý do hủy:</strong><br>
                                                    <?= htmlspecialchars($order['cancel_reason']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= number_format($order['item_count']) ?> món</span>
                                        </td>
                                        <td>
                                            <?php if ($order['status'] === 'Đã hủy'): ?>
                                                <strong style="color: #dc3545; text-decoration: line-through;">
                                                    <?= number_format($order['total_amount'] ?? 0) ?>đ
                                                </strong>
                                                <br><small class="text-muted">(Đã hủy)</small>
                                            <?php else: ?>
                                                <strong style="color: #28a745;">
                                                    <?= number_format($order['total_amount'] ?? 0) ?>đ
                                                </strong>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="text-muted">
                                Chưa có đơn hàng nào được tìm thấy
                            </p>
                            <small class="text-danger">
                                Debug: 
                                <?php if (!isset($allOrders)): ?>
                                    allOrders variable is not set
                                <?php elseif (!is_array($allOrders)): ?>
                                    allOrders is not an array: <?= gettype($allOrders) ?>
                                <?php elseif (empty($allOrders)): ?>
                                    allOrders array is empty
                                <?php else: ?>
                                    allOrders count: <?= count($allOrders) ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
