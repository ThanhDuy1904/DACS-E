<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h2>Sửa thông tin khách hàng</h2>
    <form method="POST" action="/buoi2/Customer/edit?phone=<?php echo urlencode($customer['phone']); ?>">
        <div class="form-group">
            <label for="customer_name">Tên khách hàng</label>
            <input type="text" id="customer_name" name="customer_name" class="form-control" required value="<?php echo htmlspecialchars($customer['Customer_name']); ?>" />
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" class="form-control" required value="<?php echo htmlspecialchars($customer['phone']); ?>" />
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
        <a href="/buoi2/Customer" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>