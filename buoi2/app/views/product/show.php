<?php include 'app/views/shares/header.php'; ?>

<?php
function getImageUrl($imagePath) {
    if (empty($imagePath)) {
        return '/buoi2/uploads/th.jfif';
    }
    if (strpos($imagePath, 'http') === 0 || strpos($imagePath, '/') === 0) {
        return $imagePath;
    }
    return '/buoi2/' . $imagePath;
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative">
                <?php if (!empty($product->is_new)): ?>
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">Mới</span>
                <?php endif; ?>
                <img src="<?php echo htmlspecialchars(getImageUrl($product->image)); ?>" class="img-fluid border rounded main-product-image" alt="<?php echo htmlspecialchars($product->name); ?>">
            </div>
            <div class="d-flex gap-2 mt-3">
                <?php if (!empty($product->images) && is_array($product->images)): ?>
                    <?php foreach ($product->images as $img): ?>
                        <img src="<?php echo htmlspecialchars(getImageUrl($img)); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" onclick="document.querySelector('.main-product-image').src=this.src;" alt="Thumbnail">
                    <?php endforeach; ?>
                <?php else: ?>
                    <img src="<?php echo htmlspecialchars(getImageUrl($product->image)); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;" alt="Thumbnail">
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <h2 class="mb-3 fw-bold"><?php echo htmlspecialchars($product->name); ?></h2>
            <hr>
            <div class="mb-3">
                <div><strong>Loại:</strong> <a href="/buoi2/Product/category/<?php echo urlencode($product->category_id ?? ''); ?>"><?php echo htmlspecialchars($product->category_name ?? ''); ?></a></div>
                <div><strong>Thương hiệu:</strong> <a href="/buoi2/Product/brand/<?php echo urlencode($product->brand ?? ''); ?>"><?php echo htmlspecialchars($product->brand ?? ''); ?></a></div>
                <div><strong>Tình trạng:</strong> <span class="text-success"><?php echo htmlspecialchars($product->status ?? 'Còn hàng'); ?></span></div>
                <div><strong>Mã sản phẩm:</strong> <span><?php echo htmlspecialchars($product->code ?? 'Đang cập nhật'); ?></span></div>
            </div>
            <div class="mb-4">
                <h4 class="text-danger fw-bold fs-3">
                    <?php echo number_format($product->price ?? 0, 0, ',', '.'); ?>đ
                </h4>
                <?php if (!empty($product->old_price) && $product->old_price > $product->price): ?>
                    <small class="text-muted text-decoration-line-through">
                        <?php echo number_format($product->old_price, 0, ',', '.'); ?>đ
                    </small>
                <?php endif; ?>
            </div>
            <form method="POST" action="/buoi2/Product/addToCart">
                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                <div class="mb-3 d-flex align-items-center gap-2">
                    <label for="quantity" class="form-label fw-semibold mb-0">Số lượng:</label>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="changeQuantity(-1)">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control form-control-sm" style="width: 60px;">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="changeQuantity(1)">+</button>
                </div>
                <button type="submit" class="btn btn-warning w-100 fw-bold py-3">THÊM VÀO GIỎ<br><small></small></button>
            </form>
        </div>
    </div>
</div>

<script>
function changeQuantity(delta) {
    const qtyInput = document.getElementById('quantity');
    let current = parseInt(qtyInput.value) || 1;
    current += delta;
    if (current < 1) current = 1;
    qtyInput.value = current;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
