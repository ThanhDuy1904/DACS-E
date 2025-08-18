<?php include 'app/views/shares/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Custom Styles */
    body {
        background-color: #f8f9fa;
    }

    .customer-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    }

    .customer-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }

    .customer-card .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 15px 15px 0 0;
        border: none;
    }

    .customer-card .card-footer {
        background-color: #ffffff;
        border-top: 1px solid #e3e6f0;
        border-radius: 0 0 15px 15px;
    }

    .customer-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 1.4rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }
    
    .info-item {
        padding: 8px 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item i {
        width: 20px;
        margin-right: 8px;
    }
    
    .empty-state {
        text-align: center;
        padding: 5rem 1rem;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,.08);
    }

    .stats-card {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 15px;
        color: white;
        border: none;
    }

    .vip-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .search-box {
        position: relative;
        margin-bottom: 20px;
    }

    .search-box input {
        border-radius: 25px;
        padding-left: 50px;
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .search-box .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 1.2rem;
    }

    .action-buttons .btn {
        border-radius: 20px;
        padding: 6px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container my-5">
    <!-- Header with stats -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0 text-primary fw-bold">
                <i class="bi bi-people-fill me-2"></i>Quản lý Khách hàng
            </h2>
        </div>
       
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <div class="position-relative">
            <i class="bi bi-search search-icon"></i>
            <input type="text" 
                   class="form-control" 
                   placeholder="Tìm kiếm khách hàng theo tên hoặc số điện thoại..." 
                   id="searchInput"
                   onkeyup="searchCustomers(this.value)">
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    <h3 class="mt-2 mb-0"><?php echo count($customers); ?></h3>
                    <p class="mb-0">Tổng khách hàng</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="bi bi-star-fill" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    <h3 class="mt-2 mb-0">
                        <?php 
                        $vipCount = 0;
                        foreach ($customers as $customer) {
                            if ($customer['order_count'] >= 5) $vipCount++;
                        }
                        echo $vipCount;
                        ?>
                    </h3>
                    <p class="mb-0">Khách hàng VIP</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="bi bi-currency-dollar" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    <h3 class="mt-2 mb-0">
                        <?php 
                        $totalRevenue = 0;
                        foreach ($customers as $customer) {
                            $totalRevenue += $customer['total_spent'];
                        }
                        echo number_format($totalRevenue, 0, ',', '.');
                        ?>
                    </h3>
                    <p class="mb-0">Tổng doanh thu (VND)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer List -->
    <div id="customerList">
        <?php if (empty($customers)): ?>
            <div class="empty-state">
                <i class="bi bi-person-bounding-box" style="font-size: 5rem; color: #6c757d; opacity: 0.5;"></i>
                <h4 class="mt-3 text-muted">Chưa có khách hàng nào</h4>
                <p class="text-muted">Hãy bắt đầu bằng cách thêm khách hàng đầu tiên của bạn.</p>
                <a href="/buoi2/Customer/add" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle-fill me-2"></i>Thêm khách hàng đầu tiên
                </a>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($customers as $customer): ?>
                    <div class="col customer-item">
                        <div class="card h-100 shadow-sm customer-card">
                            <div class="card-header d-flex align-items-center gap-3">
                                <div class="customer-avatar">
                                    <?= htmlspecialchars(mb_substr($customer['customer_name'], 0, 1)) ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0 fw-bold text-white">
                                        <?= htmlspecialchars($customer['customer_name']) ?>
                                        <?php if ($customer['order_count'] >= 5): ?>
                                            <span class="vip-badge ms-2">VIP</span>
                                        <?php endif; ?>
                                    </h5>
<small class="text-white-50">
    <i class="bi bi-calendar-check me-1"></i>
    <?php if (!empty($customer['customer_created_at'])): ?>
        Tham gia: <?= date('d/m/Y', strtotime($customer['customer_created_at'])) ?>
    <?php else: ?>
        Tham gia: N/A
    <?php endif; ?>
</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <i class="bi bi-telephone-fill text-primary"></i>
                                    <strong>SĐT:</strong> <?= htmlspecialchars($customer['phone']) ?>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-receipt text-success"></i>
                                    <strong>Số lần mua:</strong> 
                                    <span class="badge bg-success"><?= $customer['order_count'] ?></span>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-calendar-check text-info"></i>
                                    <strong>Mua gần nhất:</strong> 
                                    <?php if ($customer['last_order_date']): ?>
                                        <?= date('d/m/Y', strtotime($customer['last_order_date'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Chưa có đơn hàng</span>
                                    <?php endif; ?>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-cash-coin text-warning"></i>
                                    <strong>Tổng chi tiêu:</strong> 
                                    <span class="fw-bold text-success">
                                        <?= number_format($customer['total_spent'], 0, ',', '.') ?> đ
                                    </span>
                                </div>

                            </div>
<div class="card-footer d-flex justify-content-between action-buttons">
 
    
</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>

//Search functionality
function searchCustomers(keyword) {
    const customerItems = document.querySelectorAll('.customer-item');
    const searchTerm = keyword.toLowerCase();
    
    customerItems.forEach(item => {
        const customerName = item.querySelector('.card-title').textContent.toLowerCase();
        const customerPhone = item.querySelector('.info-item').textContent.toLowerCase();
        
        if (customerName.includes(searchTerm) || customerPhone.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show/hide empty state
    const visibleItems = document.querySelectorAll('.customer-item[style*="block"], .customer-item:not([style*="none"])').length;
    const emptyState = document.querySelector('.empty-state');
    
    if (visibleItems === 0 && keyword.trim() !== '') {
        if (!emptyState) {
            const customerList = document.getElementById('customerList');
            customerList.innerHTML = `
                <div class="empty-state">
                    <i class="bi bi-search" style="font-size: 5rem; color: #6c757d; opacity: 0.5;"></i>
                    <h4 class="mt-3 text-muted">Không tìm thấy khách hàng nào</h4>
                    <p class="text-muted">Thử tìm kiếm với từ khóa khác hoặc kiểm tra lại thông tin.</p>
                </div>
            `;
        }
    }
}

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?php include 'app/views/shares/footer.php'; ?>