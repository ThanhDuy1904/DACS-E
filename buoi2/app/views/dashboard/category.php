<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Danh mục - Quản trị hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            transform: translateY(-5px) scale(1.02);
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
            padding: 1.5rem 2rem;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .welcome-section {
            background: #ffffff;
            color: #333;
            padding: 2.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/buoi2/Dashboard">
                <i class="fas fa-tags me-2"></i>
                Dashboard Danh mục
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/buoi2/Dashboard">
                    <i class="fas fa-arrow-left me-1"></i>Quay lại Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="main-container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2 text-dark">
                            <i class="fas fa-tags me-3" style="color: #6c757d;"></i>
                            Quản lý Danh mục
                        </h2>
                        <p class="mb-0 text-muted">Thống kê và quản lý tất cả danh mục sản phẩm</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="/buoi2/Category/add" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Thêm danh mục
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #6c757d, #495057); margin: 0 auto;">
                                <i class="fas fa-tags text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($categoryStats['total_categories'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Tổng danh mục</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #28a745, #218838); margin: 0 auto;">
                                <i class="fas fa-cube text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #28a745;"><?= number_format($categoryStats['total_products'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Tổng sản phẩm</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ffc107, #e0a800); margin: 0 auto;">
                                <i class="fas fa-crown text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #ffc107;"><?= number_format($categoryStats['top_category_count'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Sản phẩm nhiều nhất</p>
                            <small class="text-muted"><?= htmlspecialchars($categoryStats['top_category'] ?? 'Không có') ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #dc3545, #c82333); margin: 0 auto;">
                                <i class="fas fa-exclamation-triangle text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #dc3545;"><?= number_format($categoryStats['empty_categories'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Danh mục trống</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category List -->
            <div class="table-container">
                <h5 class="table-header"><i class="fas fa-list me-2"></i>Danh sách danh mục</h5>
                <div class="table-responsive">
                    <?php if (!empty($allCategories) && is_array($allCategories)): ?>
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">ID</th>
                                    <th class="text-dark">Tên danh mục</th>
                                    <th class="text-dark">Mô tả</th>
                                    <th class="text-dark">Số sản phẩm</th>
                                    <th class="text-dark">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allCategories as $category): ?>
                                    <?php 
                                    // Tìm số sản phẩm trong danh mục này
                                    $productCount = 0;
                                    if (is_array($productStats)) {
                                        foreach ($productStats as $stat) {
                                            if (isset($stat['name']) && isset($category['name']) && $stat['name'] === $category['name']) {
                                                $productCount = $stat['product_count'] ?? 0;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><span class="badge bg-primary">#<?= htmlspecialchars($category['id'] ?? '') ?></span></td>
                                        <td class="text-dark">
                                            <i class="fas fa-tag me-2 text-muted"></i>
                                            <?= htmlspecialchars($category['name'] ?? 'Không có tên') ?>
                                        </td>
                                        <td class="text-dark">
                                            <small><?= htmlspecialchars(substr($category['description'] ?? '', 0, 50)) ?><?= strlen($category['description'] ?? '') > 50 ? '...' : '' ?></small>
                                        </td>
                                        <td>
                                            <span class="badge <?= $productCount > 0 ? 'bg-success' : 'bg-warning' ?>">
                                                <?= number_format($productCount) ?> sản phẩm
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="/buoi2/Category/edit?id=<?= $category['id'] ?? '' ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(<?= $category['id'] ?? 0 ?>)">
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
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <p class="text-muted">
                                <?php if (!isset($allCategories)): ?>
                                    Lỗi: Không thể tải dữ liệu danh mục
                                <?php elseif (!is_array($allCategories)): ?>
                                    Lỗi: Dữ liệu danh mục không đúng định dạng
                                <?php else: ?>
                                    Chưa có danh mục nào
                                <?php endif; ?>
                            </p>
                            <a href="/buoi2/Category/add" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Thêm danh mục đầu tiên
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteCategory(id) {
            if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/buoi2/Category/delete';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
