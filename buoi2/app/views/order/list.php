<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - TD Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .main-container {
            max-width: 1600px; /* Tăng độ rộng container */
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Header Section */
        .page-header {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }
        
        .page-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .page-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        
        .page-title .icon {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.5rem;
        }
        
        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }
        
        /* Statistics Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--info-color));
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        
        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--white);
        }
        
        .stat-icon.orders { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .stat-icon.cups { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-icon.revenue { background: linear-gradient(135deg, #10b981, #059669); }
        
        .stat-content h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }
        
        .stat-content p {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin: 0;
        }
        
        /* Filter Section */
        .filter-section {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }
        
        .filter-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .filter-group label {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: var(--white);
        }
        
        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.1);
        }
        
        .search-section {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .search-input {
            flex: 1;
            min-width: 300px;
            padding: 0.875rem 1rem 0.875rem 2.5rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            background: var(--white);
            position: relative;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.1);
        }
        
        .search-container {
            position: relative;
            flex: 1;
            min-width: 300px;
        }
        
        .search-container i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }
        
        .btn-modern {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-secondary {
            background: var(--secondary-color);
            color: var(--white);
        }
        
        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
        }
        
        /* Orders Table */
        .orders-container {
            background: var(--white);
            border-radius: var(--radius-xl);
            overflow: visible; /* Bỏ scroll ngang */
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }
        
        .table-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 1.5rem 2rem;
        }
        
        .table-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Cố định layout bảng */
        }
        
        .orders-table thead th {
            background: #f1f5f9;
            padding: 0.75rem 0.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.8rem;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Đặt độ rộng tối ưu cho các cột */
        .orders-table th:nth-child(1) { width: 8%; } /* Đơn hàng */
        .orders-table th:nth-child(2) { width: 15%; } /* Khách hàng */
        .orders-table th:nth-child(3) { width: 10%; } /* Nhân viên */
        .orders-table th:nth-child(4) { width: 8%; } /* Thanh toán */
        .orders-table th:nth-child(5) { width: 10%; } /* Ngày đặt */
        .orders-table th:nth-child(6) { width: 25%; } /* Sản phẩm */
        .orders-table th:nth-child(7) { width: 10%; } /* Trạng thái */
        .orders-table th:nth-child(8) { width: 14%; } /* Thao tác */
        
        .orders-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-color);
        }
        
        .orders-table tbody tr:hover {
            background: #f8fafc;
        }

        /* Màu sắc cho các trạng thái đơn hàng */
        .row-completed {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7) !important; /* Xanh lá nhạt */
            border-left: 4px solid var(--success-color);
        }

        .row-completed:hover {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0) !important; /* Xanh lá đậm hơn khi hover */
        }

        .row-cancelled {
            background: linear-gradient(135deg, #fef2f2, #fecaca) !important; /* Đỏ nhạt cho đơn bị hủy */
            border-left: 4px solid var(--danger-color);
        }

        .row-cancelled:hover {
            background: linear-gradient(135deg, #fecaca, #fca5a5) !important; /* Đỏ đậm hơn khi hover */
        }

        /* Đảm bảo các ô trong hàng đã hoàn thành có màu phù hợp */
        .row-completed .customer-card {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-left-color: var(--success-color);
        }

        .row-completed .employee-card {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-left-color: var(--success-color);
        }

        .row-completed .order-total {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-left-color: var(--success-color);
        }

        /* Styling cho đơn hàng bị hủy */
        .row-cancelled .customer-card {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-left-color: var(--danger-color);
        }

        .row-cancelled .employee-card {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-left-color: var(--danger-color);
        }

        .row-cancelled .order-total {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-left-color: var(--danger-color);
            text-decoration: line-through;
            opacity: 0.7;
        }

        .orders-table tbody td {
            padding: 1rem 0.5rem;
            vertical-align: top;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Order Cards - Compact */
        .order-id {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .cancel-reason {
            background: #fef2f2;
            color: var(--danger-color);
            padding: 0.75rem; /* Tăng padding */
            border-radius: var(--radius-md); /* Tăng border radius */
            font-size: 1.2rem; /* Tăng gấp 3 lần từ 0.4rem lên 1.2rem */
            font-weight: 600; /* Thêm font-weight */
            border-left: 4px solid var(--danger-color); /* Tăng border */
            margin-top: 0.5rem;
            line-height: 1.4; /* Thêm line-height */
            box-shadow: var(--shadow-sm); /* Thêm shadow */
        }
        
        .customer-card {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            padding: 0.5rem;
            border-radius: var(--radius-md);
            border-left: 3px solid var(--info-color);
        }
        
        .customer-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.8rem;
        }
        
        .customer-phone {
            color: var(--text-secondary);
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .employee-card {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            padding: 0.5rem;
            border-radius: var(--radius-md);
            border-left: 3px solid var(--warning-color);
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.8rem;
            text-align: center;
        }
        
        .payment-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            text-align: center;
        }
        
        .payment-cod { background: #fef3c7; color: #92400e; }
        .payment-bank { background: #dbeafe; color: #1e40af; }
        
        .order-date {
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
        }
        
        /* Product Table - Compact */
        .product-table {
            width: 100%;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }
        
        .product-table thead {
            background: #1e293b;
            color: var(--white);
        }
        
        .product-table th,
        .product-table td {
            padding: 0.8rem 0.4rem; /* Tăng padding */
            font-size: 1rem; /* Tăng font-size từ 0.8rem lên 1rem */
            border-bottom: 1px solid var(--border-color);
        }
        
        .product-table tbody tr {
            background: #f8fafc;
        }
        
        .product-table tbody tr:hover {
            background: #f1f5f9;
        }
        
        .product-image {
            width: 3rem; /* Tăng từ 2.5rem lên 3rem */
            height: 3rem;
            object-fit: cover;
            border-radius: var(--radius-md);
            margin-right: 0.8rem; /* Tăng margin */
            box-shadow: var(--shadow-sm);
        }
        
        .product-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem; /* Tăng từ 0.8rem lên 1rem */
            line-height: 1.4; /* Tăng line-height */
        }
        
        .product-options {
            font-size: 0.9rem; /* Tăng từ 0.7rem lên 0.9rem */
            color: var(--text-secondary);
            margin-top: 0.3rem; /* Tăng margin */
            line-height: 1.3; /* Tăng line-height */
        }
        
        .product-price {
            font-weight: 600;
            color: var(--success-color);
            font-size: 1rem; /* Tăng từ 0.8rem lên 1rem */
        }
        
        .order-total {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            padding: 0.8rem; /* Tăng padding */
            border-radius: var(--radius-md);
            border-left: 4px solid var(--success-color); /* Tăng border */
            font-weight: 600;
            font-size: 1rem; /* Tăng từ 0.8rem lên 1rem */
            line-height: 1.4; /* Tăng line-height */
        }
        
        /* Status Badges - Compact */
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            text-align: center;
        }
        
        .status-preparing {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-completed {
            background: #dcfce7;
            color: #166534;
        }
        
        .status-cancelled {
            background: #fecaca;
            color: #991b1b;
        }
        
        /* Action Buttons - Compact */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            min-width: auto;
        }
        
        .btn-action {
            padding: 0.375rem 0.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.65rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            white-space: nowrap;
            line-height: 1;
        }
        
        .btn-view {
            background: linear-gradient(135deg, var(--success-color), #047857);
            color: var(--white);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, var(--danger-color), #b91c1c);
            color: var(--white);
        }
        
        .btn-cancel {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: var(--white);
        }
        
        .btn-print {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: var(--white);
        }
        
        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            color: var(--white);
            text-decoration: none;
        }
        
        .btn-action i {
            font-size: 0.6rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
                max-width: 100%;
            }
            
            .page-header {
                padding: 1.5rem;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .search-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-container {
                min-width: auto;
            }
            
            .orders-table {
                font-size: 0.65rem;
            }
            
            .orders-table th,
            .orders-table td {
                padding: 0.5rem 0.25rem;
            }
            
            .product-table th,
            .product-table td {
                padding: 0.6rem 0.3rem;
                font-size: 0.9rem; /* Tăng font-size cho mobile */
            }
            
            .product-name {
                font-size: 0.9rem;
            }
            
            .product-options {
                font-size: 0.8rem;
            }
            
            .product-price {
                font-size: 0.9rem;
            }
            
            .order-total {
                font-size: 0.9rem;
            }
            
            .cancel-reason {
                font-size: 1rem; /* Giữ font lớn trên mobile */
                padding: 0.5rem;
            }
            
            /* Ẩn một số cột ít quan trọng trên mobile */
            .orders-table th:nth-child(3),
            .orders-table td:nth-child(3) { /* Nhân viên */
                display: none;
            }
            
            .orders-table th:nth-child(4),
            .orders-table td:nth-child(4) { /* Thanh toán */
                display: none;
            }
            
            /* Điều chỉnh lại độ rộng cột cho mobile */
            .orders-table th:nth-child(1) { width: 10%; }
            .orders-table th:nth-child(2) { width: 20%; }
            .orders-table th:nth-child(5) { width: 15%; }
            .orders-table th:nth-child(6) { width: 30%; }
            .orders-table th:nth-child(7) { width: 10%; }
            .orders-table th:nth-child(8) { width: 15%; }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.125rem;
            }
            
            .btn-action {
                font-size: 0.6rem;
                padding: 0.25rem 0.375rem;
            }
        }
        
        @media (min-width: 1200px) {
            .main-container {
                max-width: 1800px; /* Tăng thêm cho màn hình lớn */
            }
            
            .orders-table th,
            .orders-table td {
                padding: 1rem 0.75rem;
            }
            
            .orders-table thead th {
                font-size: 0.875rem;
            }
            
            .btn-action {
                font-size: 0.75rem;
                padding: 0.5rem 0.75rem;
            }
            
            .product-table th,
            .product-table td {
                padding: 1rem 0.5rem; /* Tăng padding cho màn hình lớn */
                font-size: 1.1rem; /* Tăng font-size cho màn hình lớn */
            }
            
            .product-name {
                font-size: 1.1rem;
            }
            
            .product-options {
                font-size: 1rem;
            }
            
            .product-price {
                font-size: 1.1rem;
            }
            
            .order-total {
                font-size: 1.1rem;
                padding: 1rem;
            }
            
            .product-image {
                width: 3.5rem; /* Tăng kích thước ảnh trên màn hình lớn */
                height: 3.5rem;
            }
            
            .cancel-reason {
                font-size: 1.4rem; /* Tăng thêm trên màn hình lớn */
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'app/views/shares/header.php'; ?>

    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h1>Quản lý đơn hàng</h1>
                    <p class="page-subtitle">Theo dõi và quản lý tất cả đơn hàng của cửa hàng</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon orders">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>
                        <?php 
                        $validOrders = array_filter($orders ?? [], function($order) {
                            return $order['status'] !== 'Đã hủy';
                        });
                        echo count($validOrders);
                        ?>
                    </h3>
                    <p>Đơn hàng hợp lệ</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon cups">
                        <i class="fas fa-coffee"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>
                        <?php 
                        $totalCups = 0;
                        if (!empty($orders)) {
                            foreach ($orders as $order) {
                                if ($order['status'] !== 'Đã hủy') {
                                    foreach ($order['details'] as $detail) {
                                        $totalCups += $detail['quantity'];
                                    }
                                }
                            }
                        }
                        echo $totalCups;
                        ?>
                    </h3>
                    <p>Sản phẩm đã bán</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon revenue">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>
                        <?php 
                        $totalRevenue = 0;
                        if (!empty($orders)) {
                            foreach ($orders as $order) {
                                // Chỉ tính doanh thu từ đơn hàng không bị hủy
                                if ($order['status'] !== 'Đã hủy') {
                                    $orderTotal = 0;
                                    foreach ($order['details'] as $detail) {
                                        $orderTotal += $detail['price'] * $detail['quantity'];
                                    }
                                    // Trừ đi discount amount
                                    $discountAmount = floatval($order['discount_amount'] ?? 0);
                                    $finalOrderTotal = $orderTotal - $discountAmount;
                                    $totalRevenue += $finalOrderTotal;
                                }
                            }
                        }
                        echo number_format($totalRevenue, 0, ',', '.');
                        ?>đ
                    </h3>
                    <p>Tổng doanh thu hợp lệ</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <i class="fas fa-filter"></i>
                <h3>Bộ lọc tìm kiếm</h3>
            </div>
            
            <form method="GET" action="/buoi2/Order/index">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label><i class="fas fa-calendar"></i> Lọc theo ngày</label>
                        <select name="date_filter" onchange="toggleCustomDate()">
                            <option value="">Tất cả</option>
                            <option value="today" <?= ($_GET['date_filter'] ?? '') === 'today' ? 'selected' : '' ?>>Hôm nay</option>
                            <option value="yesterday" <?= ($_GET['date_filter'] ?? '') === 'yesterday' ? 'selected' : '' ?>>Hôm qua</option>
                            <!-- <option value="7days" <?= ($_GET['date_filter'] ?? '') === '7days' ? 'selected' : '' ?>>7 ngày trước</option>
                            <option value="30days" <?= ($_GET['date_filter'] ?? '') === '30days' ? 'selected' : '' ?>>30 ngày trước</option>
                            <option value="custom" <?= ($_GET['date_filter'] ?? '') === 'custom' ? 'selected' : '' ?>>Chọn ngày</option> -->
                        </select>
                    </div>
                    
                    <div class="filter-group" id="custom-date-group" style="display: <?= ($_GET['date_filter'] ?? '') === 'custom' ? 'block' : 'none' ?>;">
                        <label><i class="fas fa-calendar-day"></i> Từ ngày</label>
                        <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
                    </div>
                    
                    <div class="filter-group" id="custom-date-to-group" style="display: <?= ($_GET['date_filter'] ?? '') === 'custom' ? 'block' : 'none' ?>;">
                        <label><i class="fas fa-calendar-day"></i> Đến ngày</label>
                        <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label><i class="fas fa-clock"></i> Lọc theo giờ</label>
                        <select name="time_filter">
                            <option value="">Cả ngày</option>
                            <option value="morning" <?= ($_GET['time_filter'] ?? '') === 'morning' ? 'selected' : '' ?>>Sáng (8h-14h)</option>
                            <option value="afternoon" <?= ($_GET['time_filter'] ?? '') === 'afternoon' ? 'selected' : '' ?>>Chiều (14h-22h)</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label><i class="fas fa-credit-card"></i> Thanh toán</label>
                        <select name="payment_filter">
                            <option value="">Tất cả</option>
                            <option value="cod" <?= ($_GET['payment_filter'] ?? '') === 'cod' ? 'selected' : '' ?>>Tiền mặt</option>
                            <option value="bank" <?= ($_GET['payment_filter'] ?? '') === 'bank' ? 'selected' : '' ?>>Chuyển khoản</option>
                        </select>
                    </div>
                </div>
                
                <div class="search-section">
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" name="keyword" class="search-input" 
                               placeholder="Tìm kiếm theo tên khách hàng, số điện thoại, nhân viên..." 
                               value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                    </div>
                    <button type="submit" class="btn-modern btn-primary">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                    <a href="/buoi2/Order/index" class="btn-modern btn-secondary">
                        <i class="fas fa-redo"></i>
                        Đặt lại
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="orders-container">
            <div class="table-header">
                <h3>
                    <i class="fas fa-list"></i>
                    Danh sách đơn hàng
                </h3>
            </div>
            
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Nhân viên</th>
                        <th>Thanh toán</th>
                        <th>Ngày đặt</th>
                        <th>Sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr <?php 
                                if ($order['status'] === 'đã hoàn thành') {
                                    echo 'class="row-completed"';
                                } elseif ($order['status'] === 'Đã hủy') {
                                    echo 'class="row-cancelled"';
                                }
                            ?>>
                                <td>
                                    <div class="order-id">#<?= htmlspecialchars($order['id']) ?></div>
                                </td>
                                
                                <td>
                                    <div class="customer-card">
                                        <div class="customer-name">
                                            <i class="fas fa-user"></i>
                                            <?= htmlspecialchars($order['customer_name'] ?? 'Khách vãng lai') ?>
                                        </div>
                                        <?php if (!empty($order['phone'])): ?>
                                            <div class="customer-phone">
                                                <i class="fas fa-phone"></i>
                                                <?= htmlspecialchars($order['phone']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="employee-card">
                                        <i class="fas fa-user-tie"></i>
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
                                    <span class="payment-badge <?= $paymentClass ?>">
                                        <?= htmlspecialchars($order['payment_method']) ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="order-date">
                                        <i class="fas fa-calendar-alt"></i>
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
                                            $subtotal = 0;
                                            foreach ($order['details'] as $detail): 
                                                $itemTotal = $detail['price'] * $detail['quantity'];
                                                $subtotal += $itemTotal;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div style="display: flex; align-items: center;">
                                                            <?php if (!empty($detail['image'])): ?>
                                                                <img src="/buoi2/<?= htmlspecialchars($detail['image']) ?>" 
                                                                     alt="<?= htmlspecialchars($detail['product_name']) ?>" 
                                                                     class="product-image">
                                                            <?php endif; ?>
                                                            <div class="product-name">
                                                                <?= htmlspecialchars($detail['product_name']) ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= htmlspecialchars($detail['quantity']) ?></td>
                                                    <td>
                                                        <div class="product-price">
                                                            <?= number_format($detail['price'], 0, ',', '.') ?>đ
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
                                            $discountAmount = floatval($order['discount_amount'] ?? 0);
                                            $finalTotal = $subtotal - $discountAmount;
                                            ?>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="order-total">
                                                        <?php if ($discountAmount > 0): ?>
                                                            <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem;">
                                                                Tổng gốc: <?= number_format($subtotal, 0, ',', '.') ?>đ
                                                            </div>
                                                            <div style="color: #dc2626; font-size: 0.875rem; margin-bottom: 0.25rem;">
                                                                💸 Giảm giá: -<?= number_format($discountAmount, 0, ',', '.') ?>đ
                                                                <?php if (!empty($order['discount_code'])): ?>
                                                                    <br>📋 Mã: <?= htmlspecialchars($order['discount_code']) ?>
                                                                <?php endif; ?>
                                                            </div>
                                                            💰 Thành tiền: <?= number_format($finalTotal, 0, ',', '.') ?>đ
                                                        <?php else: ?>
                                                            💰 Tổng cộng: <?= number_format($subtotal, 0, ',', '.') ?>đ
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                
                                <td>
                                    <form method="POST" action="/buoi2/Order/updateOrderStatus" style="display: inline;">
                                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                        <select name="status" onchange="this.form.submit()" class="status-badge 
                                            <?php 
                                            if ($order['status'] === 'đã hoàn thành') echo 'status-completed';
                                            elseif ($order['status'] === 'Đã hủy') echo 'status-cancelled';
                                            else echo 'status-preparing';
                                            ?>" <?= $order['status'] === 'Đã hủy' ? 'disabled' : '' ?>>
                                            <option value="Đang chuẩn bị" <?= $order['status'] === 'Đang chuẩn bị' ? 'selected' : '' ?>>Đang chuẩn bị</option>
                                            <option value="đã hoàn thành" <?= $order['status'] === 'đã hoàn thành' ? 'selected' : '' ?>>Đã hoàn thành</option>
                                            <?php if ($order['status'] === 'Đã hủy'): ?>
                                                <!-- Chỉ hiển thị tùy chọn "Đã hủy" khi đơn hàng đã bị hủy, không cho chọn từ dropdown -->
                                                <option value="Đã hủy" selected disabled>Đã hủy</option>
                                            <?php endif; ?>
                                        </select>
                                    </form>
                                    
                                    <?php if ($order['status'] === 'Đã hủy' && !empty($order['cancel_reason'])): ?>
                                        <div class="cancel-reason">
                                            <strong>Lý do hủy đơn:</strong><br>
                                            <?= htmlspecialchars($order['cancel_reason']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($order['status'] !== 'Đã hủy'): ?>
                                        <a href="/buoi2/Order/edit?id=<?= $order['id']  ?>" class="btn-action btn-view">
                                            <i class="fas fa-eye"></i>
                                            Chi tiết
                                        </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <form method="POST" action="/buoi2/Order/deleteOrder" 
                                              onsubmit="return confirm('⚠️ Bạn có chắc muốn xóa đơn hàng #<?= $order['id'] ?> không?');"
                                              style="margin: 0;">
                                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                            <button type="submit" class="btn-action btn-delete">
                                                <i class="fas fa-trash"></i>
                                                Xóa
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        
                                        <?php if ($order['status'] !== 'Đã hủy'): ?>
                                        <button type="button" class="btn-action btn-cancel" onclick="showCancelModal(<?= $order['id'] ?>)">
                                            <i class="fas fa-ban"></i>
                                            Hủy đơn
                                        </button>
                                        
                                        <a href="/buoi2/Order/exportToPdf/<?= $order['id'] ?>" class="btn-action btn-print" target="_blank">
                                            <i class="fas fa-print"></i>
                                            In PDF
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">
                                <div class="no-orders">
                                    <i class="fas fa-inbox"></i>
                                    <h3>Chưa có đơn hàng nào</h3>
                                    <p>Hãy tạo đơn hàng đầu tiên để bắt đầu!</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: var(--radius-lg); border: none; box-shadow: var(--shadow-xl);">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--danger-color), #b91c1c); color: white; border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
                    <h5 class="modal-title" id="cancelOrderModalLabel">
                        <i class="fas fa-ban"></i>
                        Hủy đơn hàng
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/buoi2/Order/cancelOrder">
                    <div class="modal-body" style="padding: 2rem;">
                        <input type="hidden" id="cancelOrderId" name="order_id" value="">
                        <div class="mb-3">
                            <label for="cancelReason" class="form-label" style="font-weight: 600; color: var(--text-primary);">
                                Lý do hủy đơn hàng <span style="color: var(--danger-color);">*</span>
                            </label>
                            <textarea class="form-control" id="cancelReason" name="cancel_reason" rows="4" 
                                      placeholder="Vui lòng nhập lý do hủy đơn hàng..." required
                                      style="border: 2px solid var(--border-color); border-radius: var(--radius-md);"></textarea>
                        </div>
                        <div class="alert alert-warning" style="border-radius: var(--radius-md); border-left: 4px solid var(--warning-color);">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Lưu ý:</strong> Việc hủy đơn hàng sẽ không thể hoàn tác và đơn hàng sẽ không được tính vào doanh thu.
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 1rem 2rem 2rem;">
                        <button type="button" class="btn-modern btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Đóng
                        </button>
                        <button type="submit" class="btn-modern" style="background: var(--danger-color); color: var(--white);">
                            <i class="fas fa-ban"></i>
                            Xác nhận hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'app/views/shares/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleCustomDate() {
            const dateFilter = document.querySelector('select[name="date_filter"]').value;
            const customDateGroup = document.getElementById('custom-date-group');
            const customDateToGroup = document.getElementById('custom-date-to-group');
            
            if (dateFilter === 'custom') {
                customDateGroup.style.display = 'block';
                customDateToGroup.style.display = 'block';
            } else {
                customDateGroup.style.display = 'none';
                customDateToGroup.style.display = 'none';
            }
        }
        
        function showCancelModal(orderId) {
            document.getElementById('cancelOrderId').value = orderId;
            document.getElementById('cancelReason').value = '';
            const modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
            modal.show();
        }
    </script>
</body>
</html>