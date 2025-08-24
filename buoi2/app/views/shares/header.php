<?php
if (!defined('HEADER_INCLUDED')) {
    define('HEADER_INCLUDED', true);
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 80px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-modern {
            background: #ffffff;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand-modern {
            font-size: 1.8rem;
            font-weight: 800;
            color: #667eea !important;
            text-decoration: none;
            letter-spacing: 1px;
            text-shadow: none;
            transition: all 0.3s ease;
        }
        
        .navbar-brand-modern:hover {
            color: #5a6fd8 !important;
            transform: scale(1.05);
        }
        
        .nav-link-modern {
            color: #2d3748 !important;
            font-weight: 600;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            margin: 0 0.2rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link-modern:hover {
            color: #667eea !important;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .nav-link-modern::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link-modern:hover::before {
            width: 80%;
        }
        
        .btn-modern {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #667eea;
        }
        
        .btn-modern-primary {
            background: #667eea;
            color: #ffffff !important;
            border-color: #667eea;
        }
        
        .btn-modern-primary:hover {
            background: #5a6fd8 !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-modern-secondary {
            background: transparent;
            color: #667eea !important;
            border-color: #667eea;
        }
        
        .btn-modern-secondary:hover {
            background: #667eea !important;
            color: #ffffff !important;
            transform: translateY(-2px);
        }
        
        .user-greeting {
            color: #2d3748 !important;
            font-weight: 600;
            margin-right: 1rem;
            padding: 0.5rem 1rem;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 20px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            text-shadow: none;
        }
        
        .navbar-toggler {
            border: 1px solid #667eea;
            color: #667eea;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2861, 110, 211, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Additional fixes for text visibility */
        .navbar-nav .nav-link {
            color: #2d3748 !important;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #667eea !important;
        }
        
        .navbar-text {
            color: #2d3748 !important;
        }
        
        /* Ensure all text elements use dark colors */
        .navbar-modern .fas,
        .navbar-modern .fa {
            color: inherit;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-modern fixed-top">
        <div class="container">
            <?php
            // Determine brand link based on user role
            $brandLink = '/buoi2/Dashboard'; // Default for admin
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'employee') {
                    $brandLink = '/buoi2/Product/';
                }
                // admin stays with dashboard
            }
            ?>
            <a class="navbar-brand-modern" href="<?php echo $brandLink; ?>">
                <i class="fas fa-coffee me-2"></i>TD COFFEE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Product/">
                                <i class="fas fa-box me-1"></i>Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Category/list">
                                <i class="fas fa-tags me-1"></i>Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Discount/index">
                                <i class="fas fa-percentage me-1"></i>Khuyến mãi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Cart">
                                <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Order/index">
                                <i class="fas fa-receipt me-1"></i>Đơn hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Customer">
                                <i class="fas fa-users me-1"></i>Khách hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/User/index">
                                <i class="fas fa-user-cog me-1"></i>Hệ thống tài khoản
                            </a>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link-modern" href="/buoi2/User/register">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Product/">
                                <i class="fas fa-box me-1"></i>Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Cart">
                                <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="/buoi2/Order/index">
                                <i class="fas fa-receipt me-1"></i>Đơn hàng
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="user-greeting">
                            <i class="fas fa-user me-1"></i>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                        <?php if ($_SESSION['role'] !== 'admin'): ?>
                            <a href="/buoi2/User/profile" class="btn btn-modern btn-modern-secondary btn-sm me-2">
                                <i class="fas fa-user-edit me-1"></i>Thông tin tài khoản
                            </a>
                        <?php endif; ?>
                        <a href="/buoi2/User/logout" class="btn btn-modern btn-modern-primary btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Đăng xuất
                        </a>
                    <?php else: ?>
                        <a href="/buoi2/User/login" class="btn btn-modern btn-modern-primary btn-sm me-2">
                            <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
