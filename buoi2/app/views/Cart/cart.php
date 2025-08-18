<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color:rgb(0, 0, 0);
            color: #212529;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 76px; /* Thêm padding-top để tránh bị header che */
        }
        .container {
            max-width: 1400px;
            margin: 20px auto; /* Giảm margin-top xuống */
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative; /* Thêm position relative */
            z-index: 1; /* Đảm bảo container nằm dưới header */
        }
        h2 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            margin-bottom: 15px;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        .back-button svg {
            margin-right: 6px;
            width: 16px;
            height: 16px;
            fill: #0d6efd;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            font-size: 15px;
        }
        thead tr {
            background-color: #0d6efd;
            color: white;
            border-radius: 10px;
        }
        thead th {
            padding: 15px 10px;
            text-align: left;
            border: none;
        }
        tbody tr {
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            transition: transform 0.2s ease;
        }
        tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            border: none;
        }
        .quantity {
            text-align: center;
        }
        .btn-checkout {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }
        .btn-checkout:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #b02a37;
        }
        input.quantity-input {
            width: 50px;
            text-align: center;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 4px;
        }
        
        /* Product Options Styles */
        .product-options {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .option-tag {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            margin: 2px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .option-group {
            margin-bottom: 4px;
        }
        
        .option-group-title {
            font-weight: 600;
            color: #495057;
            font-size: 11px;
            margin-right: 5px;
        }
        
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-right: 10px;
            vertical-align: middle;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .product-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .details-column {
            max-width: 200px;
            word-wrap: break-word;
        }

        .customer-info-section {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-left: 5px solid #0d6efd;
        }

        .customer-info-section h3 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .customer-info-section h3::before {
            content: "👤";
            margin-right: 10px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            outline: none;
        }

        .btn-search {
            background-color: #17a2b8;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 8px;
        }

        .btn-search:hover {
            background-color: #138496;
        }

        #search-results {
            margin-top: 15px;
            padding: 15px;
            border-radius: 8px;
            min-height: 20px;
        }

        #search-results.success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        #search-results.error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .discount-section {
            background-color: #e8f5e8;
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
        }

        .discount-info {
            color: #155724;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 20px auto;
            }
            
            table {
                font-size: 12px;
            }
            
            thead th, tbody td {
                padding: 8px 5px;
            }
            
            .product-image {
                width: 40px;
                height: 40px;
            }
            
            .details-column {
                max-width: 150px;
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

    <div class="container">
        <a href="/buoi2/Product" class="back-button" title="Quay lại danh sách sản phẩm">
            <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            Danh sách sản phẩm
        </a>
        <h2>Giỏ hàng của bạn</h2>
        
        <?php if (empty($cartItems)): ?>
            <div class="text-center py-5">
                <h3>🛒 Giỏ hàng trống</h3>
                <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm!</p>
                <a href="/buoi2/Product" class="btn btn-primary">Xem sản phẩm</a>
            </div>
        <?php else: ?>
            <!-- Form cập nhật giỏ hàng -->
            <form id="cart-form" method="POST" action="/buoi2/Cart/update">
                <input type="hidden" id="delete_index" name="delete_index" value="" />
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Chi tiết</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th></th>
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
                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                            <td class="quantity">
                                <input type="number" name="quantities[<?php echo $index; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input" onchange="onQuantityChange(<?php echo $index; ?>)" />
                            </td>
                            <td><strong><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</strong></td>
                            <td>
                                <button type="button" onclick="deleteItem(<?php echo $index; ?>)" class="btn-delete" title="Xóa sản phẩm">🗑️ Xóa</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: #e3f2fd;">
                            <td colspan="4" style="text-align:right; font-weight: 700; color: #1976d2; font-size: 18px;">💰 Tổng cộng:</td>
                            <td style="font-weight: 700; color: #1976d2; font-size: 20px;" id="total-amount">
                                <?php echo number_format($total, 0, ',', '.'); ?> đ
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </form>

            <!-- Thông tin khách hàng -->
            <div class="customer-info-section">
                <h3>Thông tin khách hàng</h3>
                <form id="checkout-form" method="POST" action="/buoi2/Cart/process_payment" onsubmit="return validateCheckout()">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_name">👤 Tên khách hàng</label>
                                <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Nhập tên khách hàng" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">📱 Số điện thoại</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" />
                                <button type="button" onclick="searchCustomer()" class="btn-search">🔍 Tra cứu khách hàng</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_code">🎟️ Chọn mã khuyến mãi</label>
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
                                <label for="payment_method">💳 Phương thức thanh toán</label>
                                <select id="payment_method" name="payment_method" class="form-control">
                                    <option value="cod" selected>Thanh toán tiền mặt</option>
                                    <option value="bank">Chuyển khoản ngân hàng</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hiển thị thông tin giảm giá -->
                    <div id="discount-section" class="discount-section" style="display: none;">
                        <!-- Thông tin giảm giá sẽ được cập nhật bởi JavaScript -->
                    </div>
                    
                    <div id="search-results"></div>
                    
                    <button type="submit" class="btn-checkout" id="checkout-button">
                        🛒 Thanh toán - <?php echo number_format($total, 0, ',', '.'); ?> đ
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'app/views/shares/footer.php'; ?>
</body>
</html>