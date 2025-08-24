<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary-color: #667eea;
            --primary-dark: #5a6fd8;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --success-color: #4ecdc4;
            --warning-color: #ffe066;
            --danger-color: #ff6b6b;
            --text-dark: #2d3748;
            --text-light: #718096;
            --bg-light: #f7fafc;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            padding-top: 76px;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
            background: #ffffff;
        }
        
        /* Header Section */
        .header-section {
            text-align: center;
            margin-bottom: 30px;
            background: #ffffff;
            padding: 40px 20px;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            border: 2px solid #e2e8f0;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #000000;
            margin-bottom: 8px;
            text-shadow: none;
        }

        .page-subtitle {
            color: #000000;
            font-size: 1rem;
            font-weight: 400;
        }

        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            margin-bottom: 25px;
            color: #000000;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #e2e8f0;
            color: #000000;
            transform: translateX(-5px);
        }
        
        .back-button svg {
            margin-right: 6px;
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* Cart Content */
        .cart-content {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .cart-header {
            background: #ffffff;
            color: #000000;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        .cart-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: #000000;
        }

        .cart-divider {
            height: 3px;
            background: #e2e8f0;
            background-size: 200% 100%;
            animation: none;
        }

        .cart-table-container {
            padding: 25px;
            background: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
            font-size: 15px;
        }

        thead tr {
            background: #f8fafc;
            border-radius: 12px;
        }

        thead th {
            padding: 18px 15px;
            text-align: left;
            border: none;
            font-weight: 700;
            color: #000000;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        thead th:first-child {
            border-radius: 12px 0 0 12px;
        }

        thead th:last-child {
            border-radius: 0 12px 12px 0;
        }

        tbody tr {
            background: var(--white);
            box-shadow: var(--shadow-md);
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
        }

        tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-color);
        }

        tbody td {
            padding: 20px 15px;
            vertical-align: middle;
            border: none;
        }

        tbody td:first-child {
            border-radius: 12px 0 0 12px;
        }

        tbody td:last-child {
            border-radius: 0 12px 12px 0;
        }

        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.05);
        }
        
        .product-name {
            font-weight: 700;
            color: #000000;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .product-options {
            margin-top: 8px;
        }
        
        .option-tag {
            display: inline-block;
            background: #f8fafc;
            color: #000000;
            padding: 4px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 15px;
            margin: 2px;
            font-size: 11px;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }
        
        .option-group {
            margin-bottom: 6px;
        }
        
        .option-group-title {
            font-weight: 700;
            color: #000000;
            font-size: 12px;
            margin-right: 6px;
        }
        
        .details-column {
            max-width: 220px;
            word-wrap: break-word;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger-color), #ff5252);
            border: none;
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-size: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .total-row {
            background: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
        }

        .total-row td {
            font-weight: 800 !important;
            color: #000000 !important;
            font-size: 18px !important;
        }

        /* Customer Info Section */
        .customer-info-section {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .customer-info-header {
            background: #ffffff;
            color: #000000;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        .customer-info-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: #000000;
        }

        .customer-info-body {
            padding: 30px 25px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            font-weight: 700;
            color: #000000;
            margin-bottom: 10px;
            display: block;
            font-size: 14px;
        }

        .form-control {
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
            background: white;
        }

        .btn-search {
            background: #f8fafc;
            color: #000000;
            border: 1px solid #e2e8f0;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: #e2e8f0;
        }

        #search-results {
            margin-top: 15px;
            padding: 15px;
            border-radius: 12px;
            min-height: 20px;
            transition: all 0.3s ease;
        }

        #search-results.success {
            background: #f0f9f0;
            border: 2px solid #d4edda;
            color: #000000;
        }

        #search-results.error {
            background: #fdf2f2;
            border: 2px solid #f5c6cb;
            color: #000000;
        }

        .discount-section {
            background: #f0f9f0;
            border: 2px solid #d4edda;
            border-radius: 15px;
            padding: 20px;
            margin-top: 15px;
            box-shadow: var(--shadow-md);
        }

        .discount-info {
            color: #000000;
            font-weight: 700;
            margin-bottom: 0;
            font-size: 14px;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            padding: 18px;
            background: #f8fafc;
            color: #000000;
            font-weight: 800;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            cursor: pointer;
            margin-top: 25px;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            box-shadow: var(--shadow-lg);
        }

        .btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
            color: #000000;
            background: #e2e8f0;
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
        }

        .empty-cart-icon {
            font-size: 4rem;
            color: #000000;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            color: #000000;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .empty-cart p {
            color: #000000;
            margin-bottom: 25px;
        }

        .btn-primary-custom {
            background: #f8fafc;
            color: #000000;
            padding: 12px 25px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: #000000;
            background: #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 15px;
            }
            
            table {
                font-size: 12px;
            }
            
            thead th, tbody td {
                padding: 12px 8px;
            }
            
            .product-image {
                width: 50px;
                height: 50px;
            }
            
            .details-column {
                max-width: 120px;
            }

            .quantity-input {
                width: 50px;
                padding: 6px;
            }

            .customer-info-body {
                padding: 20px 15px;
            }
        }
    </style>
    <script>
        let cartItems = <?php echo json_encode($cartItems ?? []); ?>;
        let discounts = <?php echo json_encode($discounts ?? []); ?>;
        
        function updateCart() {
            const form = document.getElementById('cart-form');
            form.submit();
        }
        
        function deleteItem(index) {
            const form = document.getElementById('cart-form');
            const deleteInput = document.getElementById('delete_index');
            deleteInput.value = index;
            form.submit();
        }
        
        function onQuantityChange(index) {
            updateCart();
        }

        function onDiscountChange() {
            updateTotalDisplay();
        }

        function updateTotalDisplay() {
            const discountSelect = document.getElementById('discount_code');
            const selectedDiscountCode = discountSelect.value;
            
            // Tính tổng tiền gốc
            let originalTotal = <?php 
                $originalTotal = 0;
                if (!empty($cartItems)) {
                    foreach ($cartItems as $item) {
                        $price = $item['final_price'] ?? $item['price'];
                        $originalTotal += $price * $item['quantity'];
                    }
                }
                echo $originalTotal;
            ?>;
            
            let discountAmount = 0;
            let discountName = '';
            
            // Tìm thông tin giảm giá được chọn
            if (selectedDiscountCode && discounts) {
                const selectedDiscount = discounts.find(d => d.maDiscount === selectedDiscountCode);
                if (selectedDiscount) {
                    // Lấy số tiền giảm từ tenDiscount (giả sử tenDiscount chứa số tiền)
                    const discountValue = parseInt(selectedDiscount.tenDiscount.replace(/\D/g, '')) || 0;
                    discountAmount = discountValue;
                    discountName = selectedDiscount.tenDiscount;
                }
            }
            
            const finalTotal = Math.max(0, originalTotal - discountAmount);
            
            // Cập nhật hiển thị tổng tiền
            const totalCell = document.getElementById('total-amount');
            const checkoutButton = document.getElementById('checkout-button');
            const discountSection = document.getElementById('discount-section');
            
            if (totalCell) {
                totalCell.innerHTML = new Intl.NumberFormat('vi-VN').format(finalTotal) + ' đ';
            }
            
            if (checkoutButton) {
                checkoutButton.innerHTML = '🛒 Thanh toán - ' + new Intl.NumberFormat('vi-VN').format(finalTotal) + ' đ';
            }
            
            // Hiển thị thông tin giảm giá
            if (discountSection) {
                if (discountAmount > 0) {
                    discountSection.style.display = 'block';
                    discountSection.innerHTML = `
                        <p class="discount-info">
                            🎉 Áp dụng mã giảm giá: <strong>${selectedDiscountCode}</strong><br>
                            💰 Giảm: <strong>${new Intl.NumberFormat('vi-VN').format(discountAmount)} đ</strong><br>
                            📋 Chi tiết: ${discountName}
                        </p>
                    `;
                } else {
                    discountSection.style.display = 'none';
                }
            }
        }

        function searchCustomer() {
            const phoneInput = document.getElementById('phone');
            const phone = phoneInput.value.trim();
            const resultsDiv = document.getElementById('search-results');
            
            // Reset results
            resultsDiv.innerHTML = '';
            resultsDiv.className = '';
            
            if (phone === '') {
                alert('Vui lòng nhập số điện thoại để tra cứu.');
                return;
            }
            
            // Show loading
            resultsDiv.innerHTML = '<p>🔍 Đang tra cứu...</p>';
            
            fetch('/buoi2/Cart/searchCustomerByPhone', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'phone=' + encodeURIComponent(phone)
            })
            .then(response => response.json())
            .then(data => {
                if (data.found) {
                    resultsDiv.className = 'success';
                    resultsDiv.innerHTML = `
                        <p><strong>✅ Tìm thấy khách hàng!</strong></p>
                        <p>👤 Tên: <strong>${data.customer_name}</strong></p>
                    `;
                    if (data.discount > 0) {
                        resultsDiv.innerHTML += `<p>🎉 <strong>Khách hàng VIP:</strong> Đã mua trên 5 lần, được giảm $3000 đ</p>`;
                    }
                    // Tự động điền tên khách hàng
                    document.getElementById('customer_name').value = data.customer_name;
                } else {
                    resultsDiv.className = 'error';
                    resultsDiv.innerHTML = '<p><strong>❌ Không tìm thấy khách hàng</strong></p><p>Số điện thoại chưa có trong hệ thống.</p>';
                    // Xóa tên khách hàng nếu không tìm thấy
                    document.getElementById('customer_name').value = '';
                }
            })
            .catch(error => {
                resultsDiv.className = 'error';
                resultsDiv.innerHTML = '<p><strong>⚠️ Lỗi hệ thống</strong></p><p>Không thể tra cứu khách hàng. Vui lòng thử lại.</p>';
                console.error('Error:', error);
            });
        }

        function validateCheckout() {
            return true;
        }

        // Khởi tạo khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotalDisplay();
        });
    </script>
</head>
<body>
    <?php include 'app/views/shares/header.php'; ?>

    <div class="main-container">
        <!-- Modern Header Section -->
        <div class="header-section">
            <h1 class="page-title"><i class="fas fa-shopping-cart me-3"></i>Giỏ Hàng</h1>
            <p class="page-subtitle">Xem lại đơn hàng và hoàn tất thanh toán của bạn</p>
        </div>
        
        <a href="/buoi2/Product" class="back-button" title="Quay lại danh sách sản phẩm">
            <i class="fas fa-arrow-left me-2"></i>
            Quay lại danh sách sản phẩm
        </a>
        
        <?php if (empty($cartItems)): ?>
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm nhé!</p>
                <a href="/buoi2/Product" class="btn-primary-custom">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Khám phá sản phẩm
                </a>
            </div>
        <?php else: ?>
            <!-- Cart Content -->
            <div class="cart-content">
                <div class="cart-header">
                    <i class="fas fa-list-ul fa-2x"></i>
                    <div>
                        <h3>Danh sách sản phẩm</h3>
                        <p class="mb-0 opacity-75">Xem lại các món bạn đã chọn</p>
                    </div>
                </div>
                <div class="cart-divider"></div>
                
                <div class="cart-table-container">
                    <form id="cart-form" method="POST" action="/buoi2/Cart/update">
                        <input type="hidden" id="delete_index" name="delete_index" value="" />
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-box me-2"></i>Sản phẩm</th>
                                    <th><i class="fas fa-cogs me-2"></i>Chi tiết</th>
                                    <th><i class="fas fa-tag me-2"></i>Giá</th>
                                    <th><i class="fas fa-sort-numeric-up me-2"></i>Số lượng</th>
                                    <th><i class="fas fa-calculator me-2"></i>Tổng</th>
                                    <th><i class="fas fa-tools me-2"></i>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($cartItems as $index => $item):
                                    $price = $item['final_price'] ?? $item['price'];
                                    $subtotal = $price * $item['quantity'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <img src="<?php echo !empty($item['image']) ? '/buoi2/' . htmlspecialchars($item['image']) : '/buoi2/uploads/default-product.jpg'; ?>" 
                                                 alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                                 class="product-image">
                                            <div>
                                                <div class="product-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="details-column">
                                        <?php if (!empty($item['sugar_level'])): ?>
                                            <div class="option-group">
                                                <span class="option-group-title">🍯 Ngọt:</span>
                                                <?php 
                                                $sugarLevels = is_array($item['sugar_level']) ? $item['sugar_level'] : [$item['sugar_level']];
                                                foreach ($sugarLevels as $sugar): ?>
                                                    <span class="option-tag"><?php echo htmlspecialchars($sugar); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($item['ice_level'])): ?>
                                            <div class="option-group">
                                                <span class="option-group-title">🧊 Đá:</span>
                                                <?php 
                                                $iceLevels = is_array($item['ice_level']) ? $item['ice_level'] : [$item['ice_level']];
                                                foreach ($iceLevels as $ice): ?>
                                                    <span class="option-tag"><?php echo htmlspecialchars($ice); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($item['cup_size'])): ?>
                                            <div class="option-group">
                                                <span class="option-group-title">🥤 Size:</span>
                                                <?php 
                                                $cupSizes = is_array($item['cup_size']) ? $item['cup_size'] : [$item['cup_size']];
                                                foreach ($cupSizes as $size): ?>
                                                    <span class="option-tag"><?php echo htmlspecialchars($size); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (empty($item['sugar_level']) && empty($item['ice_level']) && empty($item['cup_size'])): ?>
                                            <small class="text-muted">Không có tùy chọn</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</strong></td>
                                    <td class="text-center">
                                        <input type="number" name="quantities[<?php echo $index; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input" onchange="onQuantityChange(<?php echo $index; ?>)" />
                                    </td>
                                    <td><strong style="color: var(--success-color); font-size: 16px;"><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</strong></td>
                                    <td>
                                        <button type="button" onclick="deleteItem(<?php echo $index; ?>)" class="btn-delete" title="Xóa sản phẩm">
                                            <i class="fas fa-trash me-1"></i>
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td colspan="4" style="text-align:right;">
                                        <i class="fas fa-wallet me-2"></i>
                                        <strong>TỔNG CỘNG:</strong>
                                    </td>
                                    <td id="total-amount">
                                        <strong><?php echo number_format($total, 0, ',', '.'); ?> đ</strong>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="customer-info-section">
                <div class="customer-info-header">
                    <i class="fas fa-user-circle fa-2x"></i>
                    <div>
                        <h3>Thông tin khách hàng</h3>
                        <p class="mb-0 opacity-75">Điền thông tin để hoàn tất đơn hàng</p>
                    </div>
                </div>
                
                <div class="customer-info-body">
                    <form id="checkout-form" method="POST" action="/buoi2/Cart/process_payment" onsubmit="return validateCheckout()">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">
                                        <i class="fas fa-user me-2"></i>
                                        Tên khách hàng
                                    </label>
                                    <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Nhập tên khách hàng" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">
                                        <i class="fas fa-phone me-2"></i>
                                        Số điện thoại
                                    </label>
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" />
                                    <button type="button" onclick="searchCustomer()" class="btn-search">
                                        <i class="fas fa-search"></i>
                                        Tra cứu khách hàng
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount_code">
                                        <i class="fas fa-ticket-alt me-2"></i>
                                        Mã khuyến mãi
                                    </label>
                                    <select id="discount_code" name="discount_code" class="form-control" onchange="onDiscountChange()">
                                        <option value="">-- Chọn mã giảm giá --</option>
                                        <?php if (!empty($discounts)): ?>
                                            <?php foreach ($discounts as $discount): ?>
                                                <option value="<?= htmlspecialchars($discount['maDiscount']) ?>">
                                                    <?= htmlspecialchars($discount['maDiscount']) ?> - <?= htmlspecialchars($discount['tenDiscount']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Phương thức thanh toán
                                    </label>
                                    <select id="payment_method" name="payment_method" class="form-control">
                                        <option value="cod" selected>💵 Thanh toán tiền mặt</option>
                                        <option value="bank">🏦 Chuyển khoản ngân hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Discount Section -->
                        <div id="discount-section" class="discount-section" style="display: none;">
                            <!-- Discount info will be updated by JavaScript -->
                        </div>
                        
                        <div id="search-results"></div>
                        
                        <button type="submit" class="btn-checkout" id="checkout-button">
                            <i class="fas fa-credit-card me-2"></i>
                            Thanh toán - <?php echo number_format($total, 0, ',', '.'); ?> đ
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'app/views/shares/footer.php'; ?>
</body>
</html>