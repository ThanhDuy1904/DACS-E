<?php
// Nội dung chính của trang giỏ hàng, tách từ Cart/cart.php
?>

<div class="container" style="background: transparent; box-shadow: none; padding: 0;">
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
