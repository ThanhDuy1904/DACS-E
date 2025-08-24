<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tài khoản - Quản trị hệ thống</title>
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
        
        .role-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/buoi2/Dashboard">
                <i class="fas fa-users me-2"></i>
                Dashboard Tài khoản
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
                            <i class="fas fa-users me-3" style="color: #6c757d;"></i>
                            Quản lý Tài khoản
                        </h2>
                        <p class="mb-0 text-muted">Thống kê và quản lý tất cả tài khoản trong hệ thống</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="/buoi2/User/register" class="btn" style="background: linear-gradient(135deg, #6c757d, #495057); color: white;">
                            <i class="fas fa-user-plus me-2"></i>Tạo tài khoản mới
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
                                <i class="fas fa-users text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1 text-dark"><?= number_format($userStats['total_users'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Tổng tài khoản</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ff6b6b, #feca57); margin: 0 auto;">
                                <i class="fas fa-crown text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #ff6b6b;"><?= number_format($userStats['admin_users'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Quản trị viên</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #56ab2f, #a8e6cf); margin: 0 auto;">
                                <i class="fas fa-user-tie text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #56ab2f;"><?= number_format($userStats['employee_users'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Nhân viên</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ffeaa7, #fdcb6e); margin: 0 auto;">
                                <i class="fas fa-calendar-day text-white fa-lg"></i>
                            </div>
                            <h3 class="mb-1" style="color: #fdcb6e;"><?= number_format($userStats['today_users'] ?? 0) ?></h3>
                            <p class="text-muted mb-0">Tạo hôm nay</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User List -->
            <div class="table-container">
                <h5 class="table-header"><i class="fas fa-list me-2"></i>Danh sách tài khoản</h5>
                <div class="table-responsive">
                    <?php if (!empty($allUsers) && is_array($allUsers)): ?>
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">ID</th>
                                    <th class="text-dark">Tên đăng nhập</th>
                                    <th class="text-dark">Email</th>
                                    <th class="text-dark">Vai trò</th>
                                    <th class="text-dark">Ngày tạo</th>
                                    <th class="text-dark">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allUsers as $user): ?>
                                    <tr>
                                        <td><span class="badge bg-primary">#<?= htmlspecialchars($user['id']) ?></span></td>
                                        <td class="text-dark">
                                            <i class="fas fa-user me-2 text-muted"></i>
                                            <?= htmlspecialchars($user['username']) ?>
                                        </td>
                                        <td class="text-dark"><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <?php
                                            $roleClass = 'bg-secondary';
                                            $roleIcon = 'fas fa-user';
                                            switch ($user['role']) {
                                                case 'admin':
                                                    $roleClass = 'bg-danger';
                                                    $roleIcon = 'fas fa-crown';
                                                    break;
                                                case 'employee':
                                                    $roleClass = 'bg-success';
                                                    $roleIcon = 'fas fa-user-tie';
                                                    break;
                                            }
                                            ?>
                                            <span class="role-badge <?= $roleClass ?>">
                                                <i class="<?= $roleIcon ?> me-1"></i>
                                                <?= ucfirst($user['role']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="/buoi2/User/edit?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <form method="POST" action="/buoi2/DashboardUser/delete" class="d-inline" 
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có tài khoản nào</p>
                            <a href="/buoi2/DashboardUser/add" class="btn" style="background: linear-gradient(135deg, #6c757d, #495057); color: white;">
                                <i class="fas fa-user-plus me-2"></i>Tạo tài khoản đầu tiên
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
