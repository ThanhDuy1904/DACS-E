<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Modern Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-glass: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="25" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="25" cy="75" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            pointer-events: none;
            z-index: -1;
        }

        .modern-navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-glass);
            position: relative;
            overflow: hidden;
        }

        .modern-navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.8s;
        }

        .modern-navbar:hover::before {
            left: 100%;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: none;
            position: relative;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-gradient);
            transition: width 0.3s ease;
        }

        .navbar-brand:hover::after {
            width: 100%;
        }

        .nav-link {
            color: white !important;
            font-weight: 600;
            position: relative;
            padding: 0.75rem 1.25rem !important;
            margin: 0 0.25rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover {
            transform: translateY(-2px);
            color: white !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .nav-link:hover::before {
            left: 0;
        }

        .nav-link i {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            font-size: 1.2rem;
        }

        .user-icon:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.35);
        }

        .user-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 55px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            min-width: 200px;
            border-radius: 16px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-glass);
            z-index: 1000;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .user-dropdown:hover .user-dropdown-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .user-dropdown-content a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-dropdown-content a:last-child {
            border-bottom: none;
        }

        .user-dropdown-content a i {
            margin-right: 10px;
            width: 16px;
        }

        .user-dropdown-content a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .auth-buttons .btn {
            margin: 0 0.25rem;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-outline-light {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.3) !important;
            color: white;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .btn-primary-gradient {
            background: var(--secondary-gradient);
            color: white;
            border: none;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4);
            filter: brightness(1.1);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .navbar-toggler {
            border: none;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                border-radius: 16px;
                margin-top: 1rem;
                padding: 1rem;
                border: 1px solid var(--glass-border);
            }
        }

        .hero-section {
            padding: 4rem 0;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .feature-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-glass);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg modern-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shopping-bag me-2"></i>ModernStore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <!-- Menu dành cho Admin - có thể truy cập tất cả -->
                        <li class="nav-item">
                            <a class="nav-link" href="/buoi2/Product/">
                                <i class="fas fa-boxes"></i>Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/buoi2/Category/list">
                                <i class="fas fa-list"></i>Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/buoi2/Cart">
                                <i class="fas fa-shopping-cart"></i>Giỏ hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/buoi2/User/index">
                                <i class="fas fa-users-cog"></i>Hệ thống tài khoản
                            </a>
                        </li>
                    <?php elseif (isset($_SESSION['user_id'])): ?>
                        <!-- Menu dành cho User thường - chỉ truy cập được một số trang -->
                        <li class="nav-item">
                            <a class="nav-link" href="/buoi2/Product/">
                                <i class="fas fa-boxes"></i>Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/buoi2/Cart">
                                <i class="fas fa-shopping-cart"></i>Giỏ hàng
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Menu dành cho khách chưa đăng nhập - chỉ xem sản phẩm -->
                        <li class="nav-item">
                            <a class="nav-link" href="/buoi2/Product/">
                                <i class="fas fa-boxes"></i>Sản phẩm
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <div class="auth-buttons d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-dropdown">
                            <div class="user-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-dropdown-content">
                                <div style="padding: 15px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); color: white; font-weight: 600;">
                                    <i class="fas fa-user-circle me-2"></i>
                                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </div>
                                <?php if ($_SESSION['role'] !== 'admin'): ?>
                                    <a href="/buoi2/User/profile">
                                        <i class="fas fa-user-edit"></i>Thông tin tài khoản
                                    </a>
                                <?php endif; ?>
                                <a href="/buoi2/User/logout">
                                    <i class="fas fa-sign-out-alt"></i>Đăng xuất
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/buoi2/User/login" class="btn btn-outline-light me-2">
                            <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                        </a>
                        <a href="/buoi2/User/register" class="btn btn-primary-gradient">
                            <i class="fas fa-user-plus me-1"></i>Đăng ký
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section Demo -->
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Chào mừng đến với ModernStore</h1>
            <p class="hero-subtitle">Trải nghiệm mua sắm hiện đại với giao diện đẹp mắt</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>