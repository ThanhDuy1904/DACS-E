<?php 

if (!isset($_SESSION['user_id'])) {
    header('Location: /buoi2/User/login');
    exit();
}
// include 'app/views/shares/header.php'; 
?>

<style>
:root {
    --primary-color: #6366f1;
    --primary-hover: #4f46e5;
    --secondary-color: #64748b;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --input-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

* {
    box-sizing: border-box;
}

body {
    background: var(--bg-gradient);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    min-height: 100vh;
    margin: 0;
    padding: 20px 0;
}

.modern-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
    color: white;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: -0.025em;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-top: 8px;
    font-weight: 400;
}

.error-alert {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 1px solid #fca5a5;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: var(--input-shadow);
}

.error-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.error-item {
    color: var(--danger-color);
    font-weight: 500;
    padding: 8px 0;
    display: flex;
    align-items: center;
}

.error-item:before {
    content: "⚠️";
    margin-right: 10px;
}

.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 40px;
    box-shadow: var(--card-shadow);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.form-group {
    margin-bottom: 25px;
    position: relative;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 0.95rem;
    letter-spacing: 0.025em;
}

.form-control {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #ffffff;
    color: #374151;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    transform: translateY(-2px);
}

.form-control:hover {
    border-color: #d1d5db;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
    padding-right: 45px;
    appearance: none;
}

.file-input-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
    width: 100%;
}

.file-input {
    position: absolute;
    left: -9999px;
    opacity: 0;
}

.file-label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px 20px;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    background: #f9fafb;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6b7280;
    font-weight: 500;
}

.file-label:hover {
    border-color: var(--primary-color);
    background: rgba(99, 102, 241, 0.05);
    color: var(--primary-color);
}

.file-icon {
    margin-right: 10px;
    font-size: 1.2rem;
}

.current-image {
    margin-top: 15px;
    border-radius: 12px;
    box-shadow: var(--input-shadow);
    border: 3px solid #ffffff;
    max-width: 200px;
    height: auto;
    transition: transform 0.3s ease;
}

.current-image:hover {
    transform: scale(1.05);
}

.image-preview-wrapper {
    text-align: center;
    margin-top: 15px;
}

.image-label {
    display: block;
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 8px;
    font-weight: 500;
}

.btn {
    padding: 15px 30px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 140px;
    position: relative;
    overflow: hidden;
}

.btn:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn:hover:before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, #8b5cf6 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
}

.btn-secondary {
    background: linear-gradient(135deg, var(--secondary-color) 0%, #475569 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(100, 116, 139, 0.4);
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(100, 116, 139, 0.6);
}

.button-group {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 40px;
    flex-wrap: wrap;
}

.input-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
}

.form-group.has-icon .form-control {
    padding-right: 45px;
}

.floating-shapes {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
}

.shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.shape:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.shape:nth-child(2) {
    width: 120px;
    height: 120px;
    top: 60%;
    right: 10%;
    animation-delay: 2s;
}

.shape:nth-child(3) {
    width: 60px;
    height: 60px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.form-card {
    animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.loading-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .modern-container {
        padding: 0 15px;
    }
    
    .form-card {
        padding: 25px;
        border-radius: 15px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .button-group {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 300px;
    }
}

.success-message {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 1px solid #6ee7b7;
    color: var(--success-color);
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    font-weight: 500;
}

.success-message:before {
    content: "✅";
    margin-right: 10px;
    font-size: 1.2rem;
}
</style>

<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<div class="modern-container">
    <div class="page-header">
        <h1 class="page-title">Sửa sản phẩm</h1>
        <p class="page-subtitle">Cập nhật thông tin sản phẩm của bạn</p>
    </div>

    <?php if (!empty($errors)): ?>
    <div class="error-alert">
        <ul class="error-list">
            <?php foreach ($errors as $error): ?>
                <li class="error-item"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="/buoi2/Product/update" onsubmit="return validateForm();" enctype="multipart/form-data" id="productForm">
            <input type="hidden" name="id" value="<?php echo isset($product->id) ? $product->id : ''; ?>">
            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product->image ?? '', ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group has-icon">
                <label for="name" class="form-label"> Tên sản phẩm</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($product->name) ? htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8') : ''; ?>" required placeholder="Nhập tên sản phẩm...">
                <span class="input-icon"></span>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Mô tả sản phẩm</label>
                <textarea id="description" name="description" class="form-control" rows="5" required placeholder="Mô tả chi tiết về sản phẩm..."><?php echo isset($product->description) ? htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="image" class="form-label"> Hình ảnh sản phẩm</label>
                <div class="file-input-wrapper">
                    <input type="file" id="image" name="image" class="file-input" accept="image/*" onchange="previewImage(this)">
                    <label for="image" class="file-label">
                        <span class="file-icon"></span>
                        <span>Chọn hình ảnh mới</span>
                    </label>
                </div>
                
                <?php if (!empty($product->image)): ?>
                <div class="image-preview-wrapper">
                    <span class="image-label">Hình ảnh hiện tại:</span>
                    <img src="/buoi2/<?php echo htmlspecialchars($product->image); ?>" alt="Hình ảnh sản phẩm" class="current-image" id="imagePreview">
                </div>
                <?php endif; ?>
            </div>

            <div class="form-group has-icon">
                <label for="price" class="form-label"> Giá sản phẩm</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo isset($product->price) ? htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8') : ''; ?>" required placeholder="0.00">
                <span class="input-icon"></span>
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label"> Danh mục</label>
                <select id="category_id" name="category_id" class="form-control form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo isset($product->category_id) && $category->id == $product->category_id ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                </button>
                <a href="/buoi2/Product" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
                <a href="/buoi2/Dashboard" class="btn btn-secondary">
                    🏠 Về trang tổng quan
                </a>
            </div>
        </form>
    </div>
</div>

<script>

// Add modal to page
document.body.insertAdjacentHTML('beforeend', successModalHTML);

function validateForm() {
    const form = document.getElementById('productForm');
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    
    // Remove previous error styling
    inputs.forEach(input => {
        input.style.borderColor = '#e5e7eb';
    });
    
    // Validate each required field
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#ef4444';
            input.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
            isValid = false;
            
            // Add shake animation
            input.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                input.style.animation = '';
            }, 500);
        }
    });
    
    // Validate price
    const price = document.getElementById('price');
    if (price.value && (isNaN(price.value) || parseFloat(price.value) < 0)) {
        price.style.borderColor = '#ef4444';
        price.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
        isValid = false;
    }
    
    if (isValid) {
        showLoading();
        
        // Submit form via AJAX
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            hideLoading();
            if (data.includes('success') || !data.includes('error')) {
                showSuccessModal();
            } else {
                // Handle error
                alert('Có lỗi xảy ra khi cập nhật sản phẩm');
            }
        })
        .catch(error => {
            hideLoading();
            alert('Có lỗi xảy ra: ' + error.message);
        });
        
        return false; // Prevent default form submission
    }
    
    return false;
}

function showSuccessModal() {
    const modal = new bootstrap.Modal(document.getElementById('successModal'));
    modal.show();
}

function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

function goToProductList() {
    window.location.href = '/buoi2/Product/index';
}

function goToDashboard() {
    window.location.href = '/buoi2/DashboardProduct/index';
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const preview = document.getElementById('imagePreview');
        
        reader.onload = function(e) {
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            } else {
                // Create preview if doesn't exist
                const wrapper = document.querySelector('.image-preview-wrapper') || document.createElement('div');
                wrapper.className = 'image-preview-wrapper';
                wrapper.innerHTML = `
                    <span class="image-label">Xem trước hình ảnh:</span>
                    <img src="${e.target.result}" alt="Preview" class="current-image" id="imagePreview">
                `;
                input.closest('.form-group').appendChild(wrapper);
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

// Add shake animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);

// Auto-resize textarea
document.getElementById('description').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Add focus effects
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.closest('.form-group').style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
        this.closest('.form-group').style.transform = 'translateY(0)';
    });
});

// Price formatting
document.getElementById('price').addEventListener('input', function() {
    let value = this.value;
    if (value && !isNaN(value)) {
        // Format number with commas for better readability
        this.setAttribute('data-formatted', parseFloat(value).toLocaleString('vi-VN'));
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>