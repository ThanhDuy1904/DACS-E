<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết bán hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1200px;
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
        }
        .order-info {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .section-title::before {
            content: "📝";
            margin-right: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .form-control {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        .product-item {
            background: #ffffff;
            border: 2px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .product-item:hover {
            border-color: #0d6efd;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .product-options {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .btn-remove {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-remove:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        }
        .btn-add-product {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }
        .btn-update {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 10px;
        }
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }
        .btn-save {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 10px;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }
        .btn-cancel {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
        }
        .order-total {
            background: linear-gradient(135deg, #fff9c4, #f7f3ff);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            font-weight: 600;
            color: #856404;
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .quantity-input {
            width: 80px;
            text-align: center;
        }
        .price-input {
            width: 120px;
        }
        .form-row {
            display: flex;
            gap: 15px;
            align-items: end;
            margin-bottom: 15px;
        }
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        .form-row .form-group.small {
            flex: 0 0 100px;
        }
        .form-row .form-group.medium {
            flex: 0 0 150px;
        }
        
        /* Modal styles */
        .modal-header {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
            border-radius: 12px 12px 0 0;
        }
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .modal-body {
            padding: 25px;
        }
        
        /* Product grid in modal */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            max-height: 400px;
            overflow-y: auto;
        }
        .product-card {
            background: white;
            border: 2px solid #dee2e6;
            border-radius: 12px;
            padding: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }
        .product-card:hover {
            border-color: #0d6efd;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .product-card.selected {
            border-color: #28a745;
            background: #f8fff9;
        }
        .product-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .product-card h6 {
            font-weight: 600;
            margin-bottom: 5px;
            color: #2d3748;
        }
        .product-card .price {
            color: #dc3545;
            font-weight: 600;
            font-size: 16px;
        }
        
        /* Search box */
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            border-radius: 25px;
            padding: 10px 20px;
            border: 2px solid #dee2e6;
        }
        .search-box input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        /* Options form */
        .options-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            display: none;
        }
        .options-form.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Chi tiết đơn hàng #<?= htmlspecialchars($order['id']) ?></h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <div class="order-info">
            <h4>📋 Thông tin đơn hàng</h4>
            <div class="row">
                <div class="col-md-4">
                    <strong>Mã đơn hàng:</strong> #<?= htmlspecialchars($order['id']) ?>
                </div>
                <div class="col-md-4">
                    <strong>Nhân viên:</strong> <?= htmlspecialchars($order['username'] ?? 'N/A') ?>
                </div>
                <div class="col-md-4">
                    <strong>Ngày tạo:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                </div>
            </div>
        </div>

        <form id="order-form" method="POST">
            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

            <!-- Thông tin khách hàng -->
            <div class="form-section">
                <div class="section-title">👤 Thông tin khách hàng</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_name">Tên khách hàng</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                   value="<?= htmlspecialchars($order['customer_name'] ?? '') ?>" 
                                   placeholder="Tên khách hàng">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?= htmlspecialchars($order['phone'] ?? '') ?>" 
                                   placeholder="Số điện thoại">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="form-section">
                <div class="section-title"> Phương thức thanh toán</div>
                <div class="form-group">
                    <select class="form-control" name="payment_method" required>
                        <option value="cod" <?= $order['payment_method'] === 'cod' ? 'selected' : '' ?>>Tiền mặt (COD)</option>
                        <option value="bank" <?= $order['payment_method'] === 'bank' ? 'selected' : '' ?>>Chuyển khoản</option>
                        <option value="zalopay" <?= $order['payment_method'] === 'zalopay' ? 'selected' : '' ?>>ZaloPay</option>
                    </select>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="form-section">
                <div class="section-title"> Danh sách sản phẩm</div>
                
                <div id="products-list">
                    <?php foreach ($order['details'] as $index => $detail): ?>
                        <div class="product-item" data-index="<?= $index ?>">
                            <div class="d-flex align-items-center">
                                <?php if (!empty($detail['image'])): ?>
                                    <img src="/buoi2/<?= htmlspecialchars($detail['image']) ?>" 
                                         alt="<?= htmlspecialchars($detail['product_name']) ?>" 
                                         class="product-image">
                                <?php endif; ?>
                                <div class="product-info">
                                    <div class="product-name"><?= htmlspecialchars($detail['product_name']) ?></div>
                                    <div class="product-options">
                                        <?php if (!empty($detail['sugar_level'])): ?>
                                            🍯 <?= htmlspecialchars($detail['sugar_level']) ?> | 
                                        <?php endif; ?>
                                        <?php if (!empty($detail['ice_level'])): ?>
                                            🧊 <?= htmlspecialchars($detail['ice_level']) ?> | 
                                        <?php endif; ?>
                                        <?php if (!empty($detail['cup_size'])): ?>
                                            🥤 <?= htmlspecialchars($detail['cup_size']) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group small">
                                        <label>Số lượng</label>
                                        <input type="number" class="form-control quantity-input" 
                                               name="products[<?= $index ?>][quantity]" 
                                               value="<?= $detail['quantity'] ?>" 
                                               min="1" required onchange="updateTotal()">
                                    </div>
                                    <div class="form-group medium">
                                        <label>Giá</label>
                                        <input type="number" class="form-control price-input" 
                                               name="products[<?= $index ?>][price]" 
                                               value="<?= $detail['price'] ?>" 
                                               min="0" required onchange="updateTotal()">
                                    </div>
                                    
                                </div>
                            </div>
                            <input type="hidden" name="products[<?= $index ?>][id]" value="<?= $detail['id'] ?>">
                            <input type="hidden" name="products[<?= $index ?>][product_id]" value="<?= $detail['product_id'] ?>">
                            <input type="hidden" name="products[<?= $index ?>][sugar_level]" value="<?= $detail['sugar_level'] ?>">
                            <input type="hidden" name="products[<?= $index ?>][ice_level]" value="<?= $detail['ice_level'] ?>">
                            <input type="hidden" name="products[<?= $index ?>][cup_size]" value="<?= $detail['cup_size'] ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/buoi2/Dashboard" class="btn-update">
                         Quay về Dashboard chính
                    </a>
                <?php endif; ?>
                
                <a href="/buoi2/Order/index" class="btn-cancel">
                    ↩ Quay lại
                </a>
            </div>
        </form>
    </div>

    <script>
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.product-item').forEach(item => {
                const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(item.querySelector('.price-input').value) || 0;
                total += quantity * price;
            });
            document.getElementById('order-total').innerText = total.toFixed(2);
        }
    </script>
</body>
</html>

