<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng - Quản trị hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .order-info {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .order-info h5 {
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
        }
        
        .order-info h5::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 4px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(90deg, #56ab2f, #a8e6cf);
        }
        
        .order-details {
            margin-top: 20px;
        }
        
        .order-details th {
            background: #f1f5f9;
            font-weight: 600;
        }
        
        .order-details td {
            vertical-align: middle;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            margin-left: 10px;
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
            <!-- Order Info -->
            <div class="order-info">
                <h5 class="mb-4">
                    <i class="fas fa-shopping-cart me-2" style="color: #56ab2f;"></i>
                    Thông tin đơn hàng #<?= htmlspecialchars($order['id']) ?>
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                        <p class="mb-1"><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                        <p class="mb-1"><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['address'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                        <p class="mb-1"><strong>Trạng thái:</strong> 
                            <span class="status-badge <?= $order['status'] == 'Đã hủy' ? 'bg-danger' : ($order['status'] == 'Hoàn thành' ? 'bg-success' : 'bg-warning') ?>">
                                <?= htmlspecialchars($order['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="mb-3">Chi tiết đơn hàng</h6>
                    <table class="table table-bordered order-details">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalAmount = 0; ?>
                            <?php foreach ($order['details'] as $index => $detail): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($detail['image'])): ?>
                                                <img src="<?= htmlspecialchars($detail['image']) ?>" alt="<?= htmlspecialchars($detail['product_name']) ?>" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?= htmlspecialchars($detail['product_name']) ?></strong>
                                                <?php if (!empty($detail['attributes'])): ?>
                                                    <div class="small text-muted">
                                                        <?= htmlspecialchars($detail['attributes']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= number_format($detail['price'], 0, ',', '.') ?>đ</td>
                                    <td><?= htmlspecialchars($detail['quantity']) ?></td>
                                    <td>
                                        <?php
                                        $lineTotal = $detail['price'] * $detail['quantity'];
                                        $totalAmount += $lineTotal;
                                        ?>
                                        <?= number_format($lineTotal, 0, ',', '.') ?>đ
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mb-3">
                <a href="/buoi2/Order/index" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Quay lại
                </a>
                <a href="/buoi2/Order/edit?id=<?= $order['id'] ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>Chỉnh sửa
                </a>
                <a href="/buoi2/Order/exportToPdf/<?= $order['id'] ?>" class="btn btn-success" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i>Xuất PDF
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>