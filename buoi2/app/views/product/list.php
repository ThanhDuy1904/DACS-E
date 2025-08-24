<?php 
include 'app/views/shares/header.php'; 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
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
        background: #ffffff;
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
        background: #ffffff;
    }

    /* Header */
    .header-section {
        text-align: center;
        margin-bottom: 30px;
        background: #ffffff;
        padding: 40px 20px;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        border: 2px solid #e2e8f0;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #000000;
        margin-bottom: 8px;
        text-shadow: none;
    }

    .page-subtitle {
        color: #000000;
        font-size: 1rem;
        font-weight: 400;
    }

    /* Category Filter */
    .category-filter {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 25px;
        background: var(--white);
        backdrop-filter: blur(20px);
        padding: 15px;
        border-radius: 15px;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e2e8f0;
    }

    .filter-btn {
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #000000;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #e2e8f0;
        color: #000000;
        border-color: #000000;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* Admin Controls */
    .admin-controls {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 25px;
    }

    .add-product-btn {
        background: #f8fafc;
        color: #000000;
        padding: 10px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
    }

    .add-product-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-xl);
        color: #000000;
        background: #e2e8f0;
    }

    /* Category Section */
    .category-section {
        margin-bottom: 40px;
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e2e8f0;
    }

    .category-header {
        background: #ffffff;
        color: #000000;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        border-bottom: 2px solid #e2e8f0;
    }

    .category-header::before {
        display: none;
    }

    .category-icon {
        font-size: 2rem;
        filter: none;
    }

    .category-info h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 4px;
        position: relative;
        z-index: 1;
        color: #000000;
    }

    .category-info p {
        font-size: 0.9rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
        color: #000000;
    }

    .category-divider {
        height: 3px;
        background: #e2e8f0;
        background-size: 200% 100%;
        animation: none;
    }

    .products-container {
        padding: 25px;
        background: #ffffff;
    }

    /* Products Grid - Desktop Only */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 18px;
        align-items: stretch;
    }

    .product-card {
        background: var(--white);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-color);
    }

    .product-image-container {
        position: relative;
        overflow: hidden;
        height: 180px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .stock-toggle-btn {
        position: absolute;
        top: 8px;
        left: 8px;
        width: 24px;
        height: 24px;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid var(--success-color);
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        user-select: none;
    }

    .stock-toggle-btn:hover {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .stock-toggle-btn::after {
        content: "✓";
        color: var(--success-color);
        font-weight: bold;
    }

    .stock-toggle-btn.out-of-stock {
        background: var(--danger-color);
        border-color: var(--danger-color);
    }

    .stock-toggle-btn.out-of-stock::after {
        content: "✗";
        color: white;
    }

    .out-of-stock-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        border-radius: 14px 14px 0 0;
    }

    .out-of-stock-text {
        background: var(--danger-color);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .stock-status {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(255, 255, 255, 0.9);
        color: var(--success-color);
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 3;
        user-select: none;
        pointer-events: none;
    }

    .stock-status::after {
        content: "Còn hàng";
    }

    /* Out of stock styles */
    .out-of-stock .out-of-stock-overlay {
        opacity: 1;
        visibility: visible;
    }

    .out-of-stock .out-of-stock-text {
        transform: scale(1);
    }

    .out-of-stock .stock-status {
        background: var(--danger-color);
        color: white;
    }

    .out-of-stock .stock-status::after {
        content: "Hết hàng";
    }

    .out-of-stock .add-to-cart-btn {
        background: #e2e8f0;
        color: #a0aec0;
        cursor: not-allowed;
        pointer-events: none;
    }

    .out-of-stock .product-image {
        filter: grayscale(0.5) brightness(0.8);
    }

    /* Ensure toggle button stays clickable */
    .out-of-stock .stock-toggle-btn {
        z-index: 4;
        pointer-events: auto;
    }

    /* Remove conflicting overlay styles */
    .out-of-stock::after {
        display: none;
    }

    .out-of-stock > *:not(.stock-status):not(.stock-toggle-btn):not(.out-of-stock-overlay) {
        opacity: 0.6;
    }

    .product-body {
        padding: 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #000000;
        margin-bottom: 6px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.3em;
    }

    .product-title a {
        text-decoration: none;
        color: #000000;
        transition: color 0.3s ease;
    }

    .product-title a:hover {
        color: #000000;
    }

    .product-description {
        color: #000000;
        font-size: 0.75rem;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
        min-height: 2em;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: #000000;
        margin-bottom: 10px;
    }

    .product-footer {
        padding: 0 12px 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-top: auto;
    }

    .admin-actions {
        display: flex;
        gap: 4px;
    }

    .btn {
        padding: 5px 10px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.7rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 3px;
    }

    .btn-edit {
        background: #f8fafc;
        color: #000000;
        border: 1px solid #e2e8f0;
        flex: 1;
    }

    .btn-delete {
        background: #f8fafc;
        color: #000000;
        border: 1px solid #e2e8f0;
        flex: 1;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .cart-form {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        padding: 6px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .cart-form:hover {
        border-color: #000000;
        background: #e2e8f0;
    }

    .quantity-input {
        width: 35px;
        padding: 3px;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        text-align: center;
        font-weight: 600;
        background: white;
        transition: all 0.3s ease;
        font-size: 0.75rem;
    }

    .quantity-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 1px rgba(102, 126, 234, 0.1);
    }

    .add-to-cart-btn {
        background: linear-gradient(135deg, #0891b2, #06b6d4);
        color: #ffffff;
        padding: 6px 10px;
        border: 1px solid #0891b2;
        border-radius: 6px;
        font-weight: 600;
        flex: 1;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 0.75rem;
    }

    .add-to-cart-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, #0e7490, #0891b2);
        color: #ffffff;
    }

    /* Empty State */
    .no-products {
        text-align: center;
        padding: 50px 20px;
        background: var(--white);
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        box-shadow: var(--shadow-lg);
    }

    .no-products-icon {
        font-size: 3rem;
        color: #000000;
        margin-bottom: 15px;
    }

    .no-products-text {
        font-size: 1rem;
        color: #000000;
        font-weight: 500;
    }

    /* Out of stock styles */
    .out-of-stock {
        position: relative;
    }

    .out-of-stock::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 14px;
        z-index: 1;
    }

    .out-of-stock .stock-status {
        background: var(--danger-color);
        color: white;
        z-index: 3;
    }

    .out-of-stock .stock-status::after {
        content: "Hết hàng";
    }

    .out-of-stock .add-to-cart-btn {
        background: #e2e8f0;
        color: #a0aec0;
        cursor: not-allowed;
        pointer-events: none;
    }

    .out-of-stock > *:not(.stock-status) {
        opacity: 0.6;
    }

    /* Modal Styles - Simplified */
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

    .modal-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        transform: scale(0.8) translateY(30px);
        transition: all 0.3s ease;
    }

    .modal-overlay.active .modal-container {
        transform: scale(1) translateY(0);
    }

    .modal-header {
        background: #ffffff;
        color: #000000;
        padding: 20px;
        border-radius: 15px 15px 0 0;
        position: relative;
        border-bottom: 2px solid #e2e8f0;
    }

    .modal-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 3px;
        color: #000000;
    }

    .modal-subtitle {
        font-size: 0.85rem;
        opacity: 0.9;
        color: #000000;
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #000000;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        background: #e2e8f0;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 20px;
    }

    .option-group {
        margin-bottom: 20px;
    }

    .option-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #000000;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .option-label::before {
        content: '';
        width: 3px;
        height: 15px;
        background: #e2e8f0;
        border-radius: 1px;
        margin-right: 8px;
    }

    .option-items {
        display: grid;
        gap: 8px;
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
        padding: 12px 15px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }

    .option-item:hover label {
        border-color: #000000;
        background: #e2e8f0;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .option-item input:checked + label {
        background: #e2e8f0;
        border-color: #000000;
        color: #000000;
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .check-icon {
        width: 16px;
        height: 16px;
        border: 1px solid #cbd5e0;
        border-radius: 50%;
        position: relative;
        transition: all 0.3s ease;
        flex-shrink: 0;
        margin-left: 8px;
    }

    .option-item input:checked + label .check-icon {
        background: white;
        border-color: #000000;
    }

    .option-item input:checked + label .check-icon::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #000000;
        font-weight: bold;
        font-size: 10px;
    }

    .modal-footer {
        padding: 0 20px 20px;
        display: flex;
        gap: 12px;
    }

    .modal-footer .btn {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    .btn-primary {
        background: #f8fafc;
        color: #000000;
        border: 1px solid #e2e8f0;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: #e2e8f0;
    }

    /* Out of Stock Notification Modal */
    .stock-notification-overlay {
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
        z-index: 1001;
    }

    .stock-notification-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .stock-notification-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        max-width: 500px;
        width: 90%;
        max-height: 70vh;
        overflow-y: auto;
        transform: scale(0.8) translateY(30px);
        transition: all 0.3s ease;
    }

    .stock-notification-overlay.active .stock-notification-container {
        transform: scale(1) translateY(0);
    }

    .stock-notification-header {
        background: #ffffff;
        color: #000000;
        padding: 20px;
        border-radius: 15px 15px 0 0;
        position: relative;
        text-align: center;
        border-bottom: 2px solid #e2e8f0;
    }

    .stock-notification-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #000000;
    }

    .stock-notification-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
        color: #000000;
    }

    .stock-notification-close {
        position: absolute;
        top: 15px;
        right: 20px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #000000;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .stock-notification-close:hover {
        background: #e2e8f0;
        transform: rotate(90deg);
    }

    .stock-notification-body {
        padding: 20px;
    }

    .out-of-stock-item {
        display: flex;
        align-items: center;
        padding: 12px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .out-of-stock-item:hover {
        background: #fee2e2;
        transform: translateX(3px);
    }

    .out-of-stock-icon {
        width: 40px;
        height: 40px;
        background: #ff6b6b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .out-of-stock-info h4 {
        font-size: 0.9rem;
        color: #000000;
        margin-bottom: 2px;
        font-weight: 600;
    }

    .out-of-stock-info p {
        font-size: 0.8rem;
        color: #000000;
        opacity: 0.8;
    }

    .no-out-of-stock {
        text-align: center;
        padding: 30px 20px;
        color: #000000;
    }

    .no-out-of-stock-icon {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .stock-notification-footer {
        padding: 0 20px 20px;
        text-align: center;
    }

    .dismiss-notification-btn {
        background: #f8fafc;
        color: #000000;
        padding: 10px 25px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dismiss-notification-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: #e2e8f0;
    }
</style>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">TD COFFEE</h1>
        <p class="page-subtitle">Thưởng thức những món ăn ngon và thức uống tuyệt vời</p>
    </div>

    <!-- Category Filter -->
    <div class="category-filter">
        <a href="?" class="filter-btn <?= !isset($_GET['category_id']) ? 'active' : '' ?>">
            📋 Tất cả
        </a>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <?php
                    $iconMap = [
                        'Đồ ăn' => '🍽️',
                        'Trà sữa' => '🥤',
                        'Cà phê' => '☕',
                        'Trà trái cây' => '🥤',
                        'Soda' => '🥤',
                        'Món chính' => '🍖',
                        'Tráng miệng' => '🍰',
                        'Pizza' => '🍕',
                        'Burger' => '🍔',
                        'Mì' => '🍜',
                        'Cơm' => '🍚',
                        'Salad' => '🥗'
                    ];
                    $icon = isset($iconMap[$category->name]) ? $iconMap[$category->name] : '🍽️';
                    $isActive = isset($_GET['category_id']) && $_GET['category_id'] == $category->id;
                ?>
                <a href="?category_id=<?= htmlspecialchars($category->id) ?>" 
                   class="filter-btn <?= $isActive ? 'active' : '' ?>">
                    <?= $icon ?> <?= htmlspecialchars($category->name) ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Admin Controls -->
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="admin-controls">
            <a href="/buoi2/Product/add" class="add-product-btn">
                <span>+</span>
                Thêm sản phẩm mới
            </a>
        </div>
    <?php endif; ?>

    <!-- Categories with Products -->
    <div class="categories-container">
        <?php
        // Nhóm sản phẩm theo danh mục
        $productsByCategory = [];
        if (!empty($products)) {
            foreach ($products as $product) {
                $categoryName = $product->category_name ?? 'Chưa phân loại';
                if (!isset($productsByCategory[$categoryName])) {
                    $productsByCategory[$categoryName] = [];
                }
                $productsByCategory[$categoryName][] = $product;
            }
        }
        
        // Nếu có filter theo category_id, chỉ hiển thị category đó
        if (isset($_GET['category_id']) && !empty($categories)) {
            $selectedCategory = null;
            foreach ($categories as $category) {
                if ($category->id == $_GET['category_id']) {
                    $selectedCategory = $category;
                    break;
                }
            }
            
            if ($selectedCategory) {
                $filteredProducts = [];
                if (isset($productsByCategory[$selectedCategory->name])) {
                    $filteredProducts[$selectedCategory->name] = $productsByCategory[$selectedCategory->name];
                }
                $productsByCategory = $filteredProducts;
            }
        }
        ?>

        <?php if (!empty($productsByCategory)): ?>
            <?php foreach ($productsByCategory as $categoryName => $categoryProducts): ?>
                <div class="category-section">
                    <div class="category-header">
                        <?php
                            $iconMap = [
                        'Soda' => '🥤',
                        'Trà sữa' => '🥤',
                        'Cà phê' => '☕',
                        'Trà trái cây' => '🥤',
                        'Món chính' => '🍖',
                        'Tráng miệng' => '🍰',
                        'Pizza' => '🍕',
                        'Burger' => '🍔',
                        'Mì' => '🍜',
                        'Cơm' => '🍚',
                        'Salad' => '🥗'
                    ];
                            $categoryIcon = isset($iconMap[$categoryName]) ? $iconMap[$categoryName] : '🍽️';
                        ?>
                        <span class="category-icon"><?= $categoryIcon ?></span>
                        <div class="category-info">
                            <h3><?= htmlspecialchars($categoryName) ?></h3>
                            <p><?= count($categoryProducts) ?> sản phẩm có sẵn</p>
                        </div>
                    </div>
                    <div class="category-divider"></div>
                    
                    <div class="products-container">
                        <div class="products-grid">
                            <?php foreach ($categoryProducts as $index => $product): ?>
                                <div class="product-card" data-product-id="<?php echo $product->id; ?>">
                                    <div class="product-image-container">
                                        <div class="stock-toggle-btn" onclick="toggleStock(this, <?php echo $product->id; ?>)"></div>
                                        <div class="stock-status"></div>
                                        <div class="out-of-stock-overlay">
                                            <div class="out-of-stock-text">HẾT HÀNG</div>
                                        </div>
                                        <img src="<?php echo htmlspecialchars($product->image ? '/buoi2/' . ltrim($product->image, '/') : '/buoi2/uploads/th.jfif'); ?>" 
                                             class="product-image" 
                                             alt="<?php echo htmlspecialchars($product->name); ?>">
                                    </div>
                                    
                                    <div class="product-body">
                                        <h3 class="product-title">
                                            <a href="/buoi2/Product/show/<?php echo $product->id; ?>">
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
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-products">
                <div class="no-products-icon">📦</div>
                <div class="no-products-text">
                    Không có sản phẩm nào trong danh sách
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

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
                    <div class="option-label">🧊Lượng đá</div>
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

<!-- Stock Notification Modal -->
<div id="stockNotificationModal" class="stock-notification-overlay">
    <div class="stock-notification-container">
        <div class="stock-notification-header">
            <h3 class="stock-notification-title">
                Thông báo hết hàng
            </h3>
            <p class="stock-notification-subtitle">Các sản phẩm hiện đã hết hàng</p>
            <button type="button" class="stock-notification-close" onclick="closeStockNotification()">×</button>
        </div>
        
        <div class="stock-notification-body">
            <div id="outOfStockList">
                <!-- Out of stock items will be populated here -->
            </div>
        </div>

        <div class="stock-notification-footer">
            <button type="button" class="dismiss-notification-btn" onclick="closeStockNotification()">
                Đã hiểu
            </button>
        </div>
    </div>
</div>

<script>


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
        const cartForm = card.querySelector('.cart-form');
        
        // Toggle trạng thái
        if (card.classList.contains('out-of-stock')) {
            // Chuyển từ hết hàng về còn hàng
            card.classList.remove('out-of-stock');
            element.classList.remove('out-of-stock');
            addToCartBtn.disabled = false;
            cartForm.style.pointerEvents = 'auto';
            localStorage.removeItem(`product_${productId}_stock`);
        } else {
            // Chuyển từ còn hàng thành hết hàng
            card.classList.add('out-of-stock');
            element.classList.add('out-of-stock');
            addToCartBtn.disabled = true;
            cartForm.style.pointerEvents = 'none';
            localStorage.setItem(`product_${productId}_stock`, 'out');
        }
    }

    // Khôi phục trạng thái hết hàng khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.product-card').forEach(card => {
            const productId = card.dataset.productId;
            const toggleBtn = card.querySelector('.stock-toggle-btn');
            const addToCartBtn = card.querySelector('.add-to-cart-btn');
            const cartForm = card.querySelector('.cart-form');
            
            if (localStorage.getItem(`product_${productId}_stock`) === 'out') {
                card.classList.add('out-of-stock');
                toggleBtn.classList.add('out-of-stock');
                addToCartBtn.disabled = true;
                cartForm.style.pointerEvents = 'none';
            }
        });
    });

    // Check if user just logged in and show stock notification
    document.addEventListener('DOMContentLoaded', function() {
        // ...existing DOMContentLoaded code...
        
        // Check if user is logged in and show stock notification
        <?php if (isset($_SESSION['user_id']) && !isset($_SESSION['stock_notification_shown'])): ?>
            showStockNotification();
            <?php $_SESSION['stock_notification_shown'] = true; ?>
        <?php endif; ?>
    });

    function showStockNotification() {
        const outOfStockProducts = getOutOfStockProducts();
        const outOfStockList = document.getElementById('outOfStockList');
        
        if (outOfStockProducts.length > 0) {
            outOfStockList.innerHTML = outOfStockProducts.map(product => `
                <div class="out-of-stock-item">
                    <div class="out-of-stock-icon">!</div>
                    <div class="out-of-stock-info">
                        <h4>${product.name}</h4>
                        <p>Sản phẩm đã được đánh dấu hết hàng</p>
                    </div>
                </div>
            `).join('');
        } else {
            outOfStockList.innerHTML = `
                <div class="no-out-of-stock">
                    <div class="no-out-of-stock-icon">✅</div>
                    <h4>Tất cả sản phẩm đều còn hàng!</h4>
                    <p>Hiện tại không có sản phẩm nào hết hàng</p>
                </div>
            `;
        }
        
        const modal = document.getElementById('stockNotificationModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function getOutOfStockProducts() {
        const outOfStockProducts = [];
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            const productId = card.dataset.productId;
            const productName = card.querySelector('.product-title a').textContent.trim();
            
            if (localStorage.getItem(`product_${productId}_stock`) === 'out') {
                outOfStockProducts.push({
                    id: productId,
                    name: productName
                });
            }
        });
        
        return outOfStockProducts;
    }

    function closeStockNotification() {
        const modal = document.getElementById('stockNotificationModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close stock notification when clicking outside
    document.getElementById('stockNotificationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStockNotification();
        }
    });

    // Close stock notification with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.getElementById('stockNotificationModal').classList.contains('active')) {
            closeStockNotification();
        }
    });

    // ...existing code...
</script>

<?php include 'app/views/shares/footer.php'; ?>


