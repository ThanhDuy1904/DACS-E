<?php 
include 'app/views/shares/header.php'; 
?>

<style>
    :root {
        --primary-color: #667eea;
        --primary-dark: #5a6fd8;
        --secondary-color: #764ba2;
        --accent-color: #f093fb;
        --success-color: #4ecdc4;
        --warning-color: #ffe066;
        --danger-color: #ff6b6b;
        --text-dark: #2d3748;
        --text-light: #718096;
        --bg-light: #f7fafc;
        --white: #ffffff;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        min-height: 100vh;
    }

    .header-section {
        text-align: center;
        margin-bottom: 40px;
        animation: fadeInDown 0.8s ease-out;
    }

    .page-title {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--white), rgba(255,255,255,0.8));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 1.2rem;
        font-weight: 400;
    }

    .content-wrapper {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* Sidebar Styles */
    .sidebar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 25px;
        box-shadow: var(--shadow-xl);
        position: sticky;
        top: 20px;
        animation: fadeInLeft 0.8s ease-out;
    }

    .sidebar-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: var(--shadow-md);
    }

    .sidebar-header .icon {
        margin-right: 12px;
        font-size: 1.3rem;
    }

    .category-list {
        list-style: none;
    }

    .category-item {
        margin-bottom: 8px;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .category-item:hover {
        transform: translateX(8px);
        box-shadow: var(--shadow-md);
    }

    .category-link {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        text-decoration: none;
        color: var(--text-dark);
        font-weight: 500;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, transparent, transparent);
    }

    .category-link:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        transform: scale(1.02);
    }

    .category-icon {
        margin-right: 12px;
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
    }

    /* Main Content */
    .main-content {
        animation: fadeInRight 0.8s ease-out;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 20px 25px;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
    }

    .add-product-btn {
        background: linear-gradient(135deg, var(--success-color), #36b3a8);
        color: white;
        padding: 12px 24px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .add-product-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
        color: white;
    }

    /* Product Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        padding: 0;
    }

    .product-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        animation: fadeInUp 0.6s ease-out;
    }

    .product-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-xl);
    }

    .product-image-container {
        position: relative;
        overflow: hidden;
        height: 250px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, var(--accent-color), #f093fb);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
    }

    .product-body {
        padding: 25px;
    }

    .product-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
        line-height: 1.3;
        display: -webkit-box;

        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-description {
        color: var(--text-light);
        font-size: 0.95rem;
        margin-bottom: 15px;
        display: -webkit-box;

        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--danger-color), #ff5252);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 15px;
    }

    /* Rating Stars */
    .rating-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        color: #ffd700;
        font-size: 1.2rem;
        transition: all 0.2s ease;
    }

    .star.empty {
        color: #e2e8f0;
    }

    .rating-text {
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Card Footer */
    .product-footer {
        padding: 0 25px 25px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .admin-actions {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-edit {
        background: linear-gradient(135deg, var(--warning-color), #ffeb3b);
        color: var(--text-dark);
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--danger-color), #f44336);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .cart-form {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(102, 126, 234, 0.1);
        padding: 12px;
        border-radius: 15px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .cart-form:hover {
        border-color: var(--primary-color);
        background: rgba(102, 126, 234, 0.15);
    }

    .quantity-input {
        width: 60px;
        padding: 8px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        text-align: center;
        font-weight: 600;
        background: white;
        transition: all 0.3s ease;
    }

    .quantity-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .add-to-cart-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 600;
        flex: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .add-to-cart-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }

    .no-products {
        text-align: center;
        padding: 60px 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
    }

    .no-products-icon {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 20px;
    }

    .no-products-text {
        font-size: 1.2rem;
        color: var(--text-light);
        font-weight: 500;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stock-status {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.9);
        color: var(--danger-color);
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .stock-status::after {
        content: "";  /* Mặc định hiển thị con mắt */
    }

    .out-of-stock .stock-status::after {
        content: "Hết hàng";  /* Đổi thành chữ "Hết hàng" khi out of stock */
    }

    .out-of-stock .stock-status {
        background: var(--danger-color);
        color: white;
        padding: 6px 15px;
    }

    .stock-badge {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: var(--danger-color);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        white-space: nowrap;
        z-index: 1;
    }

    .out-of-stock {
        position: relative;  /* Thêm vị trí relative */
    }

    .out-of-stock::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        pointer-events: none;  /* Cho phép click xuyên qua lớp overlay */
        z-index: 1;
    }

    .out-of-stock .stock-status {
        display: block;  /* Giữ hiển thị con mắt */
        z-index: 3;  /* Đảm bảo con mắt luôn ở trên cùng */
    }

    .out-of-stock .add-to-cart-btn {
        background: #e2e8f0;
        color: #a0aec0;
        cursor: not-allowed;
        pointer-events: none;  /* Vô hiệu hóa nút thêm vào giỏ */
    }

    .out-of-stock > *:not(.stock-status):not(.stock-badge) {
        opacity: 0.6;  /* Làm mờ tất cả trừ con mắt và badge */
    }
</style>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title"></h1>
        <p class="page-subtitle"></p>
    </div>

    <div class="content-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <span class="icon"></span>
                Danh mục sản phẩm
            </div>
            <ul class="category-list">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <li class="category-item">
                            <?php
                                $iconMap = [
                                    'Điện thoại' => '📱',
                                    'iPhone' => '🍎',
                                    'Tablet' => '📱',
                                    'Apple Chính Hãng' => '🍎',
                                    'Máy Cũ' => '🔄',
                                    'Smart Watch' => '⌚',
                                    'Phụ Kiện' => '🎧',
                                    'Tai Nghe' => '🎧',
                                    'Tin Công Nghệ' => '📰',
                                ];
                                $icon = isset($iconMap[$category->name]) ? $iconMap[$category->name] : '';
                            ?>
                            <a href="?category_id=<?= htmlspecialchars($category->id) ?>" class="category-link">
                                <span class="category-icon"><?= $icon ?></span>
                                <?= htmlspecialchars($category->name) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="category-item">
                        <span class="category-link">
                            <span class="category-icon">❌</span>
                            Không có danh mục
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <div>
                    <h2 style="margin: 0; color: var(--text-dark); font-weight: 700;">Tất cả sản phẩm</h2>
                    <p style="margin: 5px 0 0 0; color: var(--text-light);">
                        <?= !empty($products) ? count($products) : 0 ?> sản phẩm được tìm thấy
                    </p>
                </div>
                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/buoi2/Product/add" class="add-product-btn">
                        <span>+</span>
                        Thêm sản phẩm mới
                    </a>
                <?php endif; ?>
            </div>

            <?php if (!empty($products)): ?>
                <div class="products-grid">
                    <?php foreach ($products as $index => $product): ?>
                        <div class="product-card" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="product-image-container">
                                <div class="stock-status" onclick="toggleStock(this, <?php echo $product->id; ?>)">
                                    👁️
                                </div>
                                <div class="stock-badge">Hết hàng</div>
                                <img src="<?php echo htmlspecialchars($product->image ? '/buoi2/' . ltrim($product->image, '/') : '/buoi2/uploads/th.jfif'); ?>" 
                                     class="product-image" 
                                     alt="<?php echo htmlspecialchars($product->name); ?>">
                                <div class="product-badge">Mới</div>
                            </div>
                            
                            <div class="product-body">
                                <h3 class="product-title">
                                    <a href="/buoi2/Product/show/<?php echo $product->id; ?>" style="text-decoration: none; color: inherit;">
                                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h3>
                                <p class="product-description">
                                    <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                                <div class="product-price">
                                    <?php echo number_format($product->price, 0, ',', '.'); ?>đ
                                </div>
                                
                            </div>

                            <div class="product-footer">
                                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <div class="admin-actions">
                                        <a href="/buoi2/Product/edit/<?php echo $product->id; ?>" class="btn btn-edit">
                                            ✏️ Sửa
                                        </a>
                                        <a href="/buoi2/Product/delete/<?php echo $product->id; ?>" 
                                           class="btn btn-delete" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                            🗑️ Xóa
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
<form method="POST" action="/buoi2/Cart/add" class="cart-form" onsubmit="return openOptionsModal(event, <?php echo $product->id; ?>, '<?php echo htmlspecialchars($product->category_name ?? '', ENT_QUOTES); ?>')">
    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
    <input type="hidden" name="quantity" value="1" min="1" class="quantity-input">
    <button type="submit" class="add-to-cart-btn">
        🛒 Thêm vào giỏ
    </button>
</form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-products">
                    <div class="no-products-icon">📦</div>
                    <div class="no-products-text">
                        Không có sản phẩm nào trong danh sách
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<title>Modal Chọn Tùy Chọn</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Modal Container */
        .modal-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.7) translateY(50px);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-overlay.active .modal-container {
            transform: scale(1) translateY(0);
        }

        /* Modal Header */
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 20px 20px 0 0;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .modal-subtitle {
            font-size: 14px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 25px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        /* Modal Body */
        .modal-body {
            padding: 30px;
        }

        .option-group {
            margin-bottom: 30px;
        }

        .option-group:last-of-type {
            margin-bottom: 20px;
        }

        .option-label {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .option-label::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 2px;
            margin-right: 10px;
        }

        .option-items {
            display: grid;
            gap: 10px;
        }

        .option-item {
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .option-item input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .option-item label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .option-item label::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .option-item:hover label::before {
            left: 100%;
        }

        .option-item:hover label {
            border-color: #667eea;
            background: #f0f4ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .option-item input:checked + label {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: #667eea;
            color: white;
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .option-text {
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        .option-price {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }

        .option-item input:checked + label .option-price {
            opacity: 1;
        }

        /* Check Icon */
        .check-icon {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e0;
            border-radius: 50%;
            position: relative;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-left: 10px;
        }

        .option-item input:checked + label .check-icon {
            background: white;
            border-color: white;
        }

        .option-item input:checked + label .check-icon::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #667eea;
            font-weight: bold;
            font-size: 12px;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 0 30px 30px;
            display: flex;
            gap: 15px;
        }

        .btn {
            flex: 1;
            padding: 15px 25px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Demo Button */
        .demo-btn {
            display: block;
            margin: 20px auto;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .demo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .modal-container {
                width: 95%;
                margin: 10px;
            }
            
            .modal-header {
                padding: 20px 25px;
            }
            
            .modal-body {
                padding: 25px;
            }
            
            .modal-footer {
                padding: 0 25px 25px;
                flex-direction: column;
            }
            
            .option-item label {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    

    <!-- Modal for product options -->
    <div id="optionsModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Tùy chỉnh đồ uống</h3>
                <p class="modal-subtitle">Chọn các tùy chọn yêu thích của bạn</p>
                <button type="button" class="close-btn" onclick="closeOptionsModal()">×</button>
            </div>
            
            <div class="modal-body">
                <form id="optionsForm">
                    <input type="hidden" name="product_id" id="modal_product_id" value="">
                    
                    <div class="option-group">
                        <div class="option-label">🧊 Lượng ngọt</div>
                        <div class="option-items">
                            <div class="option-item">
                                <input type="checkbox" name="sugar_level[]" value="Bình thường" id="sugar_normal" checked>
                                <label for="sugar_normal">
                                    <span class="option-text">Bình thường</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" name="sugar_level[]" value="Ít ngọt" id="sugar_less">
                                <label for="sugar_less">
                                    <span class="option-text">Ít ngọt</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" name="sugar_level[]" value="Nhiều ngọt" id="sugar_more">
                                <label for="sugar_more">
                                    <span class="option-text">Nhiều ngọt</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="option-group">
                        <div class="option-label">🧊 Lượng đá</div>
                        <div class="option-items">
                            <div class="option-item">
                                <input type="checkbox" name="ice_level[]" value="Bình thường" id="ice_normal" checked>
                                <label for="ice_normal">
                                    <span class="option-text">Bình thường</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" name="ice_level[]" value="Ít đá" id="ice_less">
                                <label for="ice_less">
                                    <span class="option-text">Ít đá</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" name="ice_level[]" value="Nhiều đá" id="ice_more">
                                <label for="ice_more">
                                    <span class="option-text">Nhiều đá</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="option-group">
                        <div class="option-label">🥤 Kích thước ly</div>
                        <div class="option-items">
                            <div class="option-item">
                                <input type="checkbox" name="cup_size[]" value="Ly thường" id="cup_normal" checked>
                                <label for="cup_normal">
                                    <span class="option-text">Ly thường</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" name="cup_size[]" value="Ly lớn" id="cup_large">
                                <label for="cup_large">
                                    <span class="option-text">Ly lớn</span>
                                    <span class="option-price">+5,000đ</span>
                                    <div class="check-icon"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeOptionsModal()">
                    Hủy bỏ
                </button>
                <button type="submit" form="optionsForm" class="btn btn-primary">
                    🛒 Thêm vào giỏ
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentProductId = null;

        function openOptionsModal(event, productId, category) {
            // Kiểm tra xem sản phẩm có thuộc danh mục đặc biệt không
            const specialCategories = ['cơm', 'mì', 'topping', 'đồ ăn thêm'];
            const isSpecialCategory = specialCategories.some(special => 
                category && category.toLowerCase().includes(special)
            );
            
            // Nếu là sản phẩm đặc biệt, thêm trực tiếp vào giỏ hàng mà không mở modal
            if (isSpecialCategory) {
                // Tạo form data để gửi request
                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('quantity', 1);
                
                const addToCartBtn = event.target.querySelector('.add-to-cart-btn');
                const originalText = addToCartBtn.innerHTML;
                addToCartBtn.innerHTML = '⏳ Đang xử lý...';
                addToCartBtn.disabled = true;

                fetch('/buoi2/Cart/add', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        addToCartBtn.innerHTML = '✅ Đã thêm vào giỏ!';
                        setTimeout(() => {
                            addToCartBtn.innerHTML = originalText;
                            addToCartBtn.disabled = false;
                        }, 1000);
                    } else {
                        throw new Error('Thêm vào giỏ hàng thất bại');
                    }
                }).catch(error => {
                    addToCartBtn.innerHTML = '❌ Thất bại';
                    setTimeout(() => {
                        addToCartBtn.innerHTML = originalText;
                        addToCartBtn.disabled = false;
                    }, 2000);
                    alert('Lỗi khi thêm vào giỏ hàng: ' + error.message);
                });
                
                event.preventDefault();
                return false;
            }
            
            // Nếu không phải sản phẩm đặc biệt, mở modal như bình thường
            event.preventDefault();
            currentProductId = productId;
            document.getElementById('modal_product_id').value = productId;
            const modal = document.getElementById('optionsModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            return false;
        }

        function closeOptionsModal() {
            const modal = document.getElementById('optionsModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('optionsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeOptionsModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeOptionsModal();
            }
        });

        document.getElementById('optionsForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            formData.append('quantity', 1);

            // Show loading state
            const submitBtn = document.querySelector('.btn-primary');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '⏳ Đang xử lý...';
            submitBtn.disabled = true;

            fetch('/buoi2/Cart/add', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    submitBtn.innerHTML = '✅ Đã thêm vào giỏ!';
                    setTimeout(() => {
                        closeOptionsModal();
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 1000);
                } else {
                    throw new Error('Thêm vào giỏ hàng thất bại');
                }
            }).catch(error => {
                submitBtn.innerHTML = '❌ Thất bại';
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
                alert('Lỗi khi thêm vào giỏ hàng: ' + error.message);
            });
        });

        // Radio behavior for checkboxes in each group
        document.querySelectorAll('.option-group').forEach(group => {
            group.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox') {
                    const checkboxes = group.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(cb => {
                        if (cb !== e.target) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });

        function toggleStock(element, productId) {
            const card = element.closest('.product-card');
            const addToCartBtn = card.querySelector('.add-to-cart-btn');
            
            if (!card.classList.contains('out-of-stock')) {
                card.classList.add('out-of-stock');
                addToCartBtn.disabled = true;
                localStorage.setItem(`product_${productId}_stock`, 'out');
            } else {
                card.classList.remove('out-of-stock');
                addToCartBtn.disabled = false;
                localStorage.removeItem(`product_${productId}_stock`);
            }
        }

        // Khôi phục trạng thái hết hàng khi tải trang
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product-card').forEach(card => {
                const productId = card.querySelector('input[name="product_id"]').value;
                if (localStorage.getItem(`product_${productId}_stock`) === 'out') {
                    card.classList.add('out-of-stock');
                    const addToCartBtn = card.querySelector('.add-to-cart-btn');
                    addToCartBtn.disabled = true;
                }
            });
        });
    </script>
</body>
</html>

<?php include 'app/views/shares/footer.php'; ?>
