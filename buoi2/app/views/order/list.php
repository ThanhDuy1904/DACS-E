<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng - Quản lý bán hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1400px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        h1::before {
            content: "📋";
            margin-right: 15px;
            font-size: 36px;
        }
        
        /* Statistics Section */
        .statistics-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            color: white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .stat-card {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
        }
        
        .stat-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .stat-title {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .stat-detail {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 5px;
        }
        
        /* Filter Section */
        .filter-section {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .filter-row {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .filter-group label {
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 10px 15px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            min-width: 150px;
        }
        
        .filter-group select:focus,
        .filter-group input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .search-section {
            background: transparent;
            padding: 0;
            margin: 0;
            box-shadow: none;
        }
        
        form.search-form {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        form.search-form input[type="text"] {
            flex-grow: 1;
            min-width: 300px;
            padding: 12px 20px;
            border: 2px solid #0d6efd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        form.search-form input[type="text"]:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            transform: translateY(-2px);
        }
        
        .btn-filter {
            padding: 12px 25px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .btn-filter:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        }
        
        .btn-reset {
            padding: 12px 25px;
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }
        
        .orders-table {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
        }
        
        thead tr {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
        }
        
        thead th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        tbody tr {
            background-color: #ffffff;
            transition: all 0.3s ease;
            border-bottom: 1px solid #e9ecef;
        }
        
        tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        tbody td {
            padding: 20px 15px;
            vertical-align: middle;
            border: none;
        }
        
        .order-id {
            font-weight: 700;
            color: #0d6efd;
            font-size: 16px;
        }
        
        .customer-info {
            background: linear-gradient(135deg, #e8f5e8, #f0f8ff);
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .customer-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
        }
        
        .customer-name::before {
            content: "👤";
            margin-right: 8px;
        }
        
        .customer-phone {
            color: #6c757d;
            font-size: 13px;
            display: flex;
            align-items: center;
        }
        
        .customer-phone::before {
            content: "📱";
            margin-right: 8px;
        }
        
        .payment-method {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .payment-cod {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .payment-bank {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #99d6ff;
        }
        
        .payment-zalopay {
            background-color: #e6f3ff;
            color: #0066cc;
            border: 1px solid #b3d9ff;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-preparing {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .row-completed {
            background-color: #f8f9fa;
        }
        
        /* CSS để áp dụng màu xám cho toàn bộ hàng khi trạng thái là "đã hoàn thành" */
        tr.row-completed {
            background-color: #f0f0f0;
        }
        
        tr.row-completed:hover {
            background-color: #e0e0e0;
        }
        
        .order-date {
            color: #6c757d;
            font-size: 13px;
        }
        
        .employee-info {
            background: linear-gradient(135deg, #fff3e0, #fce4ec);
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid #ff9800;
        }
        
        .product-table {
            margin: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .product-table thead tr {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
        }
        
        .product-table th, .product-table td {
            padding: 12px;
            border: 1px solid #dee2e6;
            font-size: 13px;
        }
        
        .product-table tbody tr {
            background: #f8f9fa;
        }
        
        .product-table tbody tr:hover {
            background: #e9ecef;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 10px;
            vertical-align: middle;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .product-name {
            font-weight: 600;
            color: #2d3748;
        }
        
        .product-options {
            font-size: 11px;
            color: #6c757d;
            margin-top: 4px;
        }
        
        .product-price {
            font-weight: 600;
            color: #28a745;
        }
        
        .order-total {
            background: linear-gradient(135deg, #fff9c4, #f7f3ff);
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #ffc107;
            font-weight: 600;
            color: #856404;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 120px;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            font-size: 13px;
        }
        
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 13px;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
            color: white;
        }
        
        .btn-print {
            background: linear-gradient(135deg, #6610f2, #6f42c1);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            font-size: 13px;
            margin-top: 5px;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 16, 242, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .no-orders {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .no-orders::before {
            content: "📦";
            font-size: 48px;
            display: block;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-group {
                width: 100%;
            }
            
            .filter-group select,
            .filter-group input {
                min-width: auto;
                width: 100%;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: row;
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <?php include 'app/views/shares/header.php'; ?>

    <div class="container">
        <h1>Danh sách đơn hàng</h1>
        
        <!-- Statistics Section -->
        <div class="statistics-section">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-title">Tổng đơn hàng</div>
                    <div class="stat-value"><?= count($orders ?? []) ?></div>
                    <div class="stat-detail">Đơn hàng được hiển thị</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🥤</div>
                    <div class="stat-title">Tổng số cốc</div>
                    <div class="stat-value">
                        <?php 
                        $totalCups = 0;
                        if (!empty($orders)) {
                            foreach ($orders as $order) {
                                foreach ($order['details'] as $detail) {
                                    $totalCups += $detail['quantity'];
                                }
                            }
                        }
                        echo $totalCups;
                        ?>
                    </div>
                    <div class="stat-detail">Cốc đã bán</div>
                </div>
                <div class="stat-card">
    <div class="stat-icon">💰</div>
    <div class="stat-title">Tổng doanh thu</div>
    <div class="stat-value">
        <?php 
        $totalRevenue = 0;
        if (!empty($orders)) {
            foreach ($orders as $order) {
                // Sử dụng giá đã được tính toán sẵn trong database
                $orderTotal = 0;
                foreach ($order['details'] as $detail) {
                    // Sử dụng price (đã giảm giá nếu có)
                    $orderTotal += $detail['price'] * $detail['quantity'];
                }
                
                // KHÔNG trừ discount_amount nữa vì giá đã được tính sẵn
                $totalRevenue += $orderTotal;
            }
        }
        echo number_format($totalRevenue, 0, ',', '.');
        ?>đ
    </div>
    <div class="stat-detail">Doanh thu hiện tại</div>
</div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="/buoi2/Order/index">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>📅 Lọc theo ngày</label>
                        <select name="date_filter" onchange="toggleCustomDate()">
                            <option value="">Tất cả</option>
                            <option value="today" <?= ($_GET['date_filter'] ?? '') === 'today' ? 'selected' : '' ?>>Hôm nay</option>
                            <option value="yesterday" <?= ($_GET['date_filter'] ?? '') === 'yesterday' ? 'selected' : '' ?>>Hôm qua</option>
                            <option value="7days" <?= ($_GET['date_filter'] ?? '') === '7days' ? 'selected' : '' ?>>7 ngày trước</option>
                            <option value="30days" <?= ($_GET['date_filter'] ?? '') === '30days' ? 'selected' : '' ?>>30 ngày trước</option>
                            <option value="custom" <?= ($_GET['date_filter'] ?? '') === 'custom' ? 'selected' : '' ?>>Chọn ngày</option>
                        </select>
                    </div>
                    
                    <div class="filter-group" id="custom-date-group" style="display: <?= ($_GET['date_filter'] ?? '') === 'custom' ? 'flex' : 'none' ?>;">
                        <label>Từ ngày</label>
                        <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
                    </div>
                    
                    <div class="filter-group" id="custom-date-to-group" style="display: <?= ($_GET['date_filter'] ?? '') === 'custom' ? 'flex' : 'none' ?>;">
                        <label>Đến ngày</label>
                        <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label>🕐 Lọc theo giờ</label>
                        <select name="time_filter">
                            <option value="">Cả ngày</option>
                            <option value="morning" <?= ($_GET['time_filter'] ?? '') === 'morning' ? 'selected' : '' ?>>Sáng (8h-14h)</option>
                            <option value="afternoon" <?= ($_GET['time_filter'] ?? '') === 'afternoon' ? 'selected' : '' ?>>Chiều (14h-22h)</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>💳 Thanh toán</label>
                        <select name="payment_filter">
                            <option value="">Tất cả</option>
                            <option value="cod" <?= ($_GET['payment_filter'] ?? '') === 'cod' ? 'selected' : '' ?>>Tiền mặt</option>
                            <option value="bank" <?= ($_GET['payment_filter'] ?? '') === 'bank' ? 'selected' : '' ?>>Chuyển khoản</option>
                        </select>
                    </div>
                </div>
                
                <div class="search-section">
                    <div class="search-form">
                        <input type="text" name="keyword" placeholder="🔍 Tìm kiếm theo tên khách hàng, số điện thoại, nhân viên..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                        <button type="submit" class="btn btn-filter">🔍 Lọc & Tìm kiếm</button>
                        <a href="/buoi2/Order/index" class="btn btn-reset">🔄 Đặt lại</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Nhân viên</th>
                        <th>Thanh toán</th>
                        <th>Ngày đặt</th>
                        <th>Sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr <?= $order['status'] === 'đã hoàn thành' ? 'class="row-completed"' : '' ?>>
                                <td>
                                    <div class="order-id">#<?= htmlspecialchars($order['id']) ?></div>
                                </td>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-name">
                                            <?= htmlspecialchars($order['customer_name'] ?? 'Khách vãng lai') ?>
                                        </div>
                                        <?php if (!empty($order['phone'])): ?>
                                            <div class="customer-phone">
                                                <?= htmlspecialchars($order['phone']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="employee-info">
                                        <?= htmlspecialchars($order['username'] ?? 'N/A') ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $paymentClass = '';
                                    switch(strtolower($order['payment_method'])) {
                                        case 'cod':
                                        case 'tiền mặt':
                                            $paymentClass = 'payment-cod';
                                            break;
                                        case 'bank':
                                        case 'chuyển khoản':
                                            $paymentClass = 'payment-bank';
                                            break;
                                        default:
                                            $paymentClass = 'payment-cod';
                                    }
                                    ?>
                                    <span class="payment-method <?= $paymentClass ?>">
                                        <?= htmlspecialchars($order['payment_method']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="order-date">
                                        <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                    </div>
                                </td>
                                
                                <td>
    <table class="product-table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>SL</th>
                <th>Giá</th>
                <th>Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Tách riêng tổng gốc và tổng sau giảm giá
            $originalSubtotal = 0; // Tổng từ original_price
            $discountedSubtotal = 0; // Tổng từ price (đã giảm)
            
            foreach ($order['details'] as $detail): 
                // Sử dụng original_price nếu có, nếu không thì dùng price
                $originalPrice = isset($detail['original_price']) ? $detail['original_price'] : $detail['price'];
                $finalPrice = $detail['price']; // Giá cuối cùng (có thể đã giảm)
                
                $originalItemTotal = $originalPrice * $detail['quantity'];
                $discountedItemTotal = $finalPrice * $detail['quantity'];
                
                $originalSubtotal += $originalItemTotal;
                $discountedSubtotal += $discountedItemTotal;
            ?>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <?php if (!empty($detail['image'])): ?>
                                <img src="/buoi2/<?= htmlspecialchars($detail['image']) ?>" 
                                     alt="<?= htmlspecialchars($detail['product_name']) ?>" 
                                     class="product-image">
                            <?php endif; ?>
                            <div>
                                <div class="product-name">
                                    <?= htmlspecialchars($detail['product_name']) ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($detail['quantity']) ?></td>
                    <td>
                        <div class="product-price">
                            <?php if (isset($detail['original_price']) && $detail['original_price'] != $detail['price']): ?>
                                <!-- Hiển thị giá gốc bị gạch -->
                                <div style="text-decoration: line-through; color: #6c757d; font-size: 11px;">
                                    <?= number_format($detail['original_price'], 0, ',', '.') ?>đ
                                </div>
                                <!-- Hiển thị giá sau giảm -->
                                <?= number_format($detail['price'], 0, ',', '.') ?>đ
                            <?php else: ?>
                                <?= number_format($detail['price'], 0, ',', '.') ?>đ
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div class="product-options">
                            <?php if (!empty($detail['sugar_level'])): ?>
                                🍯 <?= htmlspecialchars($detail['sugar_level']) ?><br>
                            <?php endif; ?>
                            <?php if (!empty($detail['ice_level'])): ?>
                                🧊 <?= htmlspecialchars($detail['ice_level']) ?><br>
                            <?php endif; ?>
                            <?php if (!empty($detail['cup_size'])): ?>
                                🥤 <?= htmlspecialchars($detail['cup_size']) ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            
            <?php
            // Logic tính tổng được sửa lại
            $discountAmount = floatval($order['discount_amount'] ?? 0);
            
            // Nếu có discount_amount thì hiển thị chi tiết giảm giá
            if ($discountAmount > 0): ?>
                <!-- Hiển thị tổng cộng với thông tin giảm giá -->
                <tr>
                    <td colspan="4">
                        <div class="order-total">
                            <!-- Hiển thị tổng gốc -->
                            <div style="text-decoration: line-through; color: #6c757d; font-size: 12px;">
                                Tổng gốc: <?= number_format($originalSubtotal, 0, ',', '.') ?>đ
                            </div>
                            <!-- Hiển thị thông tin giảm giá -->
                            <div class="discount-info">
                                💸 Giảm giá: -<?= number_format($discountAmount, 0, ',', '.') ?>đ
                                <?php if (!empty($order['discount_code'])): ?>
                                    <br>📋 Mã: <?= htmlspecialchars($order['discount_code']) ?>
                                <?php endif; ?>
                            </div>
                            <!-- Hiển thị tổng cuối (sử dụng discountedSubtotal) -->
                            💰 Thành tiền: <?= number_format($discountedSubtotal, 0, ',', '.') ?>đ
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <!-- Không có giảm giá -->
                <tr>
                    <td colspan="4">
                        <div class="order-total">
                            💰 Tổng cộng: <?= number_format($discountedSubtotal, 0, ',', '.') ?>đ
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</td>   
                                
                                <td>
                                    <form method="POST" action="/buoi2/Order/updateOrderStatus" style="display: inline;">
                                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                        <select name="status" onchange="this.form.submit()" class="payment-method 
                                            <?= $order['status'] === 'đã hoàn thành' ? 'status-completed' : 'status-preparing' ?>">
                                            <option value="Đang chuẩn bị" <?= $order['status'] === 'Đang chuẩn bị' ? 'selected' : '' ?>>Đang chuẩn bị</option>
                                            <option value="đã hoàn thành" <?= $order['status'] === 'đã hoàn thành' ? 'selected' : '' ?>>Đã hoàn thành</option>
                                        </select>
                                    </form>
                                </td>
                                
                                <td>
                                    <div class="action-buttons">
                                        <form method="POST" action="/buoi2/Order/deleteOrder" 
                                              onsubmit="return confirm('⚠️ Bạn có chắc muốn xóa đơn hàng #<?= $order['id'] ?> không?');"
                                              style="margin: 0;">
                                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                            <button type="submit" class="btn-delete">
                                                🗑️ Xóa
                                            </button>
                                        </form>
                                        <!-- Thêm nút in -->
                                        <a href="/buoi2/Order/exportToWord/<?= $order['id'] ?>" class="btn-print">
                                            🖨️ In đơn
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">
                                <div class="no-orders">
                                    <strong>Chưa có đơn hàng nào</strong>
                                    <p>Hãy tạo đơn hàng đầu tiên để bắt đầu!</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'app/views/shares/footer.php'; ?>
    
    <script>
        function toggleCustomDate() {
            const dateFilter = document.querySelector('select[name="date_filter"]').value;
            const customDateGroup = document.getElementById('custom-date-group');
            const customDateToGroup = document.getElementById('custom-date-to-group');
            
            if (dateFilter === 'custom') {
                customDateGroup.style.display = 'flex';
                customDateToGroup.style.display = 'flex';
            } else {
                customDateGroup.style.display = 'none';
                customDateToGroup.style.display = 'none';
            }
        }
    </script>
</body>
</html>