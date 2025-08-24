<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sản Phẩm - Hệ Thống Quản Lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .main-container {
            background: #ffffff;
            border-radius: 20px;
            margin: 20px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        
        .stats-card {
            border: 1px solid #e9ecef;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            height: 100%;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6c757d, #495057);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stats-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin: 0 auto 1rem;
        }
        
        .bg-primary-gradient { background: linear-gradient(135deg, #6c757d, #495057); }
        .bg-success-gradient { background: linear-gradient(135deg, #28a745, #20c997); }
        .bg-warning-gradient { background: linear-gradient(135deg, #ffc107, #fd7e14); }
        .bg-info-gradient { background: linear-gradient(135deg, #17a2b8, #007bff); }
        .bg-danger-gradient { background: linear-gradient(135deg, #dc3545, #e83e8c); }
        
        .chart-container {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }
        
        .chart-header {
            margin-bottom: 1.5rem;
        }
        
        .chart-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin: 0;
        }
        
        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .table-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        
        .table-header {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            padding: 1.5rem;
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
        }
        
        .welcome-section {
            background: #ffffff;
            color: #333;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #333;
        }
        
        .category-badge {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .price-tag {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            display: inline-block;
        }
        
        .sold-count {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .back-btn {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
            color: white;
        }

        /* Image handling */
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #f0f0f0;
        }

        .product-img-placeholder {
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #f0f0f0;
        }

        .btn-action {
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        /* Styles cho sản phẩm bị ẩn */
        .product-hidden {
            background: #6c757d !important;
            color: white !important;
            opacity: 0.7;
        }

        .product-hidden .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .product-hidden .category-badge {
            background: linear-gradient(135deg, #495057, #343a40) !important;
        }

        .product-hidden .price-tag {
            background: linear-gradient(135deg, #6c757d, #495057) !important;
        }

        .hidden-badge {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 8px;
        }
        
        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                padding: 20px;
            }
            .stats-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/buoi2/Dashboard">
                <i class="fas fa-box me-2"></i>
                Dashboard Sản Phẩm
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/buoi2/User/profile"><i class="fas fa-user me-2"></i>Hồ sơ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/buoi2/User/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 text-dark">
                        <i class="fas fa-box me-3" style="color: #6c757d;"></i>
                        Dashboard Sản Phẩm
                    </h2>
                    <p class="mb-0 text-muted">Thông tin tổng quan về sản phẩm trong hệ thống</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="/buoi2/Dashboard" class="back-btn">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/buoi2/Dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Sản phẩm</li>
            </ol>
        </nav>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="card-body text-center p-4">
                        <div class="stats-icon bg-primary-gradient">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3 class="stats-number"><?= number_format($productStats['total_products']) ?></h3>
                        <p class="mb-0 text-muted">Tổng sản phẩm</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="card-body text-center p-4">
                        <div class="stats-icon bg-info-gradient">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3 class="stats-number"><?= number_format($productStats['active_categories']) ?></h3>
                        <p class="mb-0 text-muted">Danh mục có sản phẩm</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Products -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="table-container">
                    <h5 class="table-header">
                        <i class="fas fa-list me-2"></i>Tất cả sản phẩm
                    </h5>
                    <div class="table-responsive">
                        <?php if (!empty($allProducts)): ?>
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-dark">ID</th>
                                        <th class="text-dark">Sản phẩm</th>
                                        <th class="text-dark">Danh mục</th>
                                        <th class="text-dark">Giá</th>
                                        <th class="text-dark">Đã bán</th>
                                        <th class="text-dark">Doanh thu</th>
                                        <th class="text-dark">Đơn hàng</th>
                                        <th class="text-dark">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allProducts as $product): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary"><?= htmlspecialchars($product['id']) ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php 
                                                    $imagePath = '';
                                                    if (!empty($product['image'])) {
                                                        // Xử lý đường dẫn hình ảnh
                                                        if (strpos($product['image'], 'http') === 0) {
                                                            // URL đầy đủ
                                                            $imagePath = $product['image'];
                                                        } elseif (strpos($product['image'], 'uploads/') !== false) {
                                                            // Đã có đường dẫn uploads
                                                            $imagePath = '/buoi2/' . $product['image'];
                                                        } elseif (strpos($product['image'], '/') === 0) {
                                                            // Đường dẫn tuyệt đối
                                                            $imagePath = $product['image'];
                                                        } else {
                                                            // Tên file thuần
                                                            $imagePath = '/buoi2/uploads/products/' . $product['image'];
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    <?php if (!empty($imagePath)): ?>
                                                        <img src="<?= htmlspecialchars($imagePath) ?>" 
                                                             alt="<?= htmlspecialchars($product['name']) ?>" 
                                                             class="product-img me-3"
                                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                        <div class="product-img-placeholder me-3" style="display: none;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="product-img-placeholder me-3">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <div>
                                                        <h6 class="mb-1 text-dark"><?= htmlspecialchars($product['name']) ?></h6>
                                                        <small class="text-muted">
                                                            <?= substr(htmlspecialchars($product['description'] ?? ''), 0, 50) ?>
                                                            <?= strlen($product['description'] ?? '') > 50 ? '...' : '' ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="category-badge">
                                                    <?= htmlspecialchars($product['category_name'] ?? 'N/A') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="price-tag">
                                                    <?= number_format($product['price']) ?>đ
                                                </span>
                                            </td>
                                            <td>
                                                <span class="sold-count">
                                                    <i class="fas fa-shopping-cart me-1"></i>
                                                    <?= number_format($product['total_sold']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-success">
                                                    <?= number_format($product['total_revenue']) ?>đ
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= number_format($product['order_count']) ?> đơn
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/buoi2/Product/edit/<?= $product['id'] ?>" 
                                                       class="btn btn-outline-primary btn-sm btn-action" 
                                                       title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <!-- Nút Tạm ẩn/Hiện -->
                                                    <button onclick="toggleProductVisibility(<?= $product['id'] ?>, <?= ($product['hidden'] ?? 0) ? 'false' : 'true' ?>)" 
                                                            class="btn btn-outline-<?= ($product['hidden'] ?? 0) ? 'success' : 'warning' ?> btn-sm btn-action" 
                                                            title="<?= ($product['hidden'] ?? 0) ? 'Hiện sản phẩm' : 'Tạm ẩn sản phẩm' ?>"
                                                            id="hide-btn-<?= $product['id'] ?>">
                                                        <i class="fas fa-<?= ($product['hidden'] ?? 0) ? 'eye' : 'eye-slash' ?>"></i>
                                                    </button>
                                                    
                                                    <button onclick="confirmDelete(<?= $product['id'] ?>)" 
                                                            class="btn btn-outline-danger btn-sm btn-action" 
                                                            title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có sản phẩm nào</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <h3 class="chart-title mb-4">
                        <i class="fas fa-bolt me-2"></i>Thao tác nhanh
                    </h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/Product/add'" 
                                 class="text-center py-4" 
                                 style="background: linear-gradient(135deg, #6c757d, #495057); color: white; cursor: pointer; border-radius: 15px; transition: all 0.3s ease;">
                                <i class="fas fa-plus-circle fa-3x d-block mb-3"></i>
                                <h5 class="mb-0">Thêm sản phẩm mới</h5>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/Product'" 
                                 class="text-center py-4" 
                                 style="background: linear-gradient(135deg, #6c757d, #495057); color: white; cursor: pointer; border-radius: 15px; transition: all 0.3s ease;">
                                <i class="fas fa-plus-circle fa-3x d-block mb-3"></i>
                                <h5 class="mb-0">Quản lý sản phẩm</h5>
                            </div>
                        </div>
                      
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/Category/list'" 
                                 class="text-center py-4" 
                                 style="background: linear-gradient(135deg, #ffecd2, #fcb69f); color: #333; cursor: pointer; border-radius: 15px; transition: all 0.3s ease;">
                                <i class="fas fa-tags fa-3x d-block mb-3"></i>
                                <h5 class="mb-0">Quản lý danh mục</h5>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div onclick="window.location.href='/buoi2/Order/index'" 
                                 class="text-center py-4" 
                                 style="background: linear-gradient(135deg, #ff9a9e, #fecfef); color: #333; cursor: pointer; border-radius: 15px; transition: all 0.3s ease;">
                                <i class="fas fa-shopping-cart fa-3x d-block mb-3"></i>
                                <h5 class="mb-0">Xem đơn hàng</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit product function - updated to use proper routing
        function editProduct(productId) {
            window.location.href = '/buoi2/Product/edit/' + productId;
        }

        // Delete product function - updated with better confirmation
        function confirmDelete(productId) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?\nHành động này không thể hoàn tác!')) {
                // Use POST method for delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/buoi2/Product/delete/' + productId;
                
                // Add CSRF token if available
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = '_token';
                    input.value = csrfToken.getAttribute('content');
                    form.appendChild(input);
                }
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Hàm ẩn/hiện sản phẩm
        function toggleProductVisibility(productId, hide) {
            const btn = document.getElementById('hide-btn-' + productId);
            const row = btn.closest('tr');
            const originalBtnContent = btn.innerHTML;
            
            // Hiển thị trạng thái đang tải
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            fetch('/buoi2/DashboardProduct/toggleVisibility', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    hidden: hide
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật giao diện nút
                    if (hide) {
                        // Chuyển sang trạng thái ẩn
                        btn.className = 'btn btn-outline-success btn-sm btn-action';
                        btn.innerHTML = '<i class="fas fa-eye"></i>';
                        btn.title = 'Hiện sản phẩm';
                        btn.onclick = function() { toggleProductVisibility(productId, false); };
                        
                        // Thêm style tối cho hàng
                        row.classList.add('product-hidden');
                        
                        // Thêm badge "ẨN"
                        const nameCell = row.querySelector('td:nth-child(2) h6');
                        if (nameCell && !nameCell.querySelector('.hidden-badge')) {
                            nameCell.innerHTML += '<span class="hidden-badge">ẨN</span>';
                        }
                    } else {
                        // Chuyển sang trạng thái hiện
                        btn.className = 'btn btn-outline-warning btn-sm btn-action';
                        btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                        btn.title = 'Tạm ẩn sản phẩm';
                        btn.onclick = function() { toggleProductVisibility(productId, true); };
                        
                        // Xóa style tối
                        row.classList.remove('product-hidden');
                        
                        // Xóa badge "ẨN"
                        const hiddenBadge = row.querySelector('.hidden-badge');
                        if (hiddenBadge) {
                            hiddenBadge.remove();
                        }
                    }
                    
                    // Hiển thị thông báo thành công
                    showNotification(hide ? 'Sản phẩm đã được ẩn' : 'Sản phẩm đã được hiện', 'success');
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                btn.innerHTML = originalBtnContent;
                showNotification('Lỗi: ' + error.message, 'error');
            })
            .finally(() => {
                btn.disabled = false;
            });
        }

        // Hàm hiển thị thông báo
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : 'success'} position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Tự động xóa sau 3 giây
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 3000);
        }

        // Image error handling function
        function handleImageError(img) {
            img.style.display = 'none';
            const placeholder = img.nextElementSibling;
            if (placeholder) {
                placeholder.style.display = 'flex';
            }
        }

        // Preload images and handle errors
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.product-img');
            images.forEach(img => {
                // Test if image exists
                const testImg = new Image();
                testImg.onload = function() {
                    // Image loaded successfully
                    img.style.opacity = '1';
                };
                testImg.onerror = function() {
                    // Image failed to load
                    handleImageError(img);
                };
                testImg.src = img.src;
            });

            // Animate stats cards
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Animate product cards
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 800 + (index * 50));
            });

            // Áp dụng style tối cho sản phẩm đã bị ẩn
            <?php foreach ($allProducts as $product): ?>
                <?php if ($product['hidden'] ?? 0): ?>
                    const buttons = document.querySelectorAll(`button[id="hide-btn-<?= $product['id'] ?>"]`);
                    buttons.forEach(btn => {
                        const row = btn.closest('tr');
                        if (row) {
                            row.classList.add('product-hidden');
                            const nameCell = row.querySelector('td:nth-child(2) h6');
                            if (nameCell && !nameCell.querySelector('.hidden-badge')) {
                                nameCell.innerHTML += '<span class="hidden-badge">ẨN</span>';
                            }
                        }
                    });
                <?php endif; ?>
            <?php endforeach; ?>
        });

        // Quick action hover effects
        document.querySelectorAll('[onclick^="window.location"]').forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.05)';
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>