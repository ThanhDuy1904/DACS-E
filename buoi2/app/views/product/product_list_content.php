<?php
// Nội dung chính của trang danh sách sản phẩm, tách từ product/list.php
?>

<div class="main-content">
    <div class="content-header">
        <div>
            <h2 style="margin: 0; color: var(--text-dark); font-weight: 700;">Tất cả sản phẩm</h2>
            <p style="margin: 5px 0 0 0; color: var(--text-light);">
                <?= !empty($products) ? count($products) : 0 ?> sản phẩm được tìm thấy
            </p>
        </div>
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/buoi2/Product/add" class="add-product-btn">
                <span>+</span>
                Thêm sản phẩm mới
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($products)): ?>
        <div class="products-grid">
            <?php foreach ($products as $index => $product): ?>
                <div class="product-card" style="animation-delay: <?= $index * 0.1 ?>s;">
                    <div class="product-image-container">
                        <img src="<?php echo htmlspecialchars($product->image ? '/buoi2/' . ltrim($product->image, '/') : '/buoi2/uploads/th.jfif'); ?>" 
                             class="product-image" 
                             alt="<?php echo htmlspecialchars($product->name); ?>">
                        <div class="product-badge">Mới</div>
                    </div>
                    
                    <div class="product-body">
                        <h3 class="product-title">
                            <a href="/buoi2/Product/show/<?php echo $product->id; ?>" style="text-decoration: none; color: inherit;">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h3>
                        <p class="product-description">
                            <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <div class="product-price">
                            <?php echo number_format($product->price, 0, ',', '.'); ?>đ
                        </div>
                        
                    </div>

                    <div class="product-footer">
                        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <div class="admin-actions">
                                <a href="/buoi2/Product/edit/<?php echo $product->id; ?>" class="btn btn-edit">
                                    ✏️ Sửa
                                </a>
                                <a href="/buoi2/Product/delete/<?php echo $product->id; ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    🗑️ Xóa
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="/buoi2/Cart/add" class="cart-form" onsubmit="return openOptionsModal(event, <?php echo $product->id; ?>, '<?php echo htmlspecialchars($product->category_name ?? '', ENT_QUOTES); ?>')">
                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                            <input type="hidden" name="quantity" value="1" min="1" class="quantity-input">
                            <button type="submit" class="add-to-cart-btn">
                                🛒 Thêm vào giỏ
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-products">
            <div class="no-products-icon">📦</div>
            <div class="no-products-text">
                Không có sản phẩm nào trong danh sách
            </div>
        </div>
    <?php endif; ?>
</div>
