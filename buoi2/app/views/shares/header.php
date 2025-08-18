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
    <style>
        body {
            padding-top: 76px; /* Add padding to prevent content from hiding behind fixed navbar */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="#">TD COFFEE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Product/">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Category/list">Danh mục</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Discount/index">Khuyến mãi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Cart">Giỏ hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Order/index">Đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Customer">Khách hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/User/index">Hệ thống tài khoản</a>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link text-primary fw-semibold" href="/buoi2/User/register">Đăng ký</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Product/">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Cart">Giỏ hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary fw-semibold" href="/buoi2/Order/index">Đơn hàng</a>
                        </li>
                        
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="text-primary me-3">Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <?php if ($_SESSION['role'] !== 'admin'): ?>
                            
                            <a href="/buoi2/User/profile" class="btn btn-outline-secondary btn-sm me-2">Thông tin tài khoản</a>
                        <?php endif; ?>
                        <a href="/buoi2/User/logout" class="btn btn-outline-primary btn-sm">Đăng xuất</a>
                    <?php else: ?>
                        <a href="/buoi2/User/login" class="btn btn-outline-primary btn-sm me-2">Đăng nhập</a>
                        
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
