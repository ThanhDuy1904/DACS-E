<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Thêm khách hàng mới
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/buoi2/Customer/add" id="customerForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="customer_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Tên khách hàng <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="customer_name" 
                                           name="customer_name" 
                                           class="form-control" 
                                           required 
                                           placeholder="Nhập tên khách hàng"
                                           value="<?php echo htmlspecialchars($_POST['customer_name'] ?? ''); ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-1"></i>
                                        Số điện thoại <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           class="form-control" 
                                           required 
                                           placeholder="Nhập số điện thoại"
                                           pattern="[0-9]{10,11}"
                                           value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" />
                                    <div class="form-text">Nhập 10-11 chữ số</div>
                                </div>
                            </div>
                        </div>

                        

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="/buoi2/Customer" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Thêm khách hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('customerForm').addEventListener('submit', function(e) {
    const phone = document.getElementById('phone').value;
    const phoneRegex = /^[0-9]{10,11}$/;
    
    if (!phoneRegex.test(phone)) {
        e.preventDefault();
        alert('Số điện thoại phải có 10-11 chữ số');
        return false;
    }
    
    const name = document.getElementById('customer_name').value.trim();
    if (name.length < 2) {
        e.preventDefault();
        alert('Tên khách hàng phải có ít nhất 2 ký tự');
        return false;
    }
});

// Auto format phone number
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});
</script>

<?php include 'app/views/shares/footer.php'; ?>