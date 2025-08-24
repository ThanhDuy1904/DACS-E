<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Khách hàng - Quản trị hệ thống</title>
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
            background: linear-gradient(90deg, #007bff, #0056b3);
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
            background: linear-gradient(135deg, #007bff, #0056b3);
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
        
        .customer-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/buoi2/Dashboard">
                <i class="fas fa-users me-2"></i>
                Dashboard Khách hàng
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
                            <i class="fas fa-users me-3" style="color: #007bff;"></i>
                            Quản lý Khách hàng
                        </h2>
                        <p class="mb-0 text-muted">Thống kê và quản lý thông tin khách hàng</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #007bff, #0056b3); margin: 0 auto;">
                                <i class="fas fa-users text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($customerStats['total_customers'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Tổng khách hàng</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #28a745, #218838); margin: 0 auto;">
                                <i class="fas fa-shopping-bag text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($customerStats['orders_with_customers'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Đơn có tên KH</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ffc107, #e0a800); margin: 0 auto;">
                                <i class="fas fa-user-secret text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($customerStats['guest_orders'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Đơn khách vãng lai</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #007bff, #0056b3); margin: 0 auto;">
                                <i class="fas fa-crown text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($customerStats['loyal_customers'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Khách hàng thân thiết</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer List -->
            <div class="table-container">
                <h5 class="table-header"><i class="fas fa-list me-2"></i>Danh sách khách hàng</h5>
                <div class="table-responsive">
                    <?php if (!empty($allCustomers) && is_array($allCustomers)): ?>
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">Tên khách hàng</th>
                                    <th class="text-dark">Số điện thoại</th>
                                    <th class="text-dark">Số đơn hàng</th>
                                    <th class="text-dark">Tổng chi tiêu</th>
                                    <th class="text-dark">Đơn hàng đầu</th>
                                    <th class="text-dark">Đơn hàng cuối</th>
                                    <th class="text-dark">Loại khách</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allCustomers as $customer): ?>
                                    <tr>
                                        <td class="text-dark">
                                            <i class="fas fa-user me-2 text-muted"></i>
                                            <?= htmlspecialchars($customer['customer_name']) ?>
                                        </td>
                                        <td class="text-dark"><?= htmlspecialchars($customer['phone'] ?? '-') ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= number_format($customer['order_count']) ?> đơn</span>
                                        </td>
                                        <td>
                                            <strong style="color: #007bff;">
                                                <?= number_format($customer['total_spent'] ?? 0) ?>đ
                                            </strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d/m/Y', strtotime($customer['first_order'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d/m/Y', strtotime($customer['last_order'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php
                                            $orderCount = $customer['order_count'];
                                            if ($orderCount >= 10) {
                                                echo '<span class="customer-badge bg-warning text-dark"><i class="fas fa-crown me-1"></i>VIP</span>';
                                            } elseif ($orderCount >= 5) {
                                                echo '<span class="customer-badge bg-success"><i class="fas fa-star me-1"></i>Thân thiết</span>';
                                            } elseif ($orderCount >= 3) {
                                                echo '<span class="customer-badge bg-info"><i class="fas fa-heart me-1"></i>Thường xuyên</span>';
                                            } else {
                                                echo '<span class="customer-badge bg-secondary"><i class="fas fa-user me-1"></i>Mới</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có khách hàng nào</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
