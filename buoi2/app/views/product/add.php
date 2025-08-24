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
    --primary-dark: #4f46e5;
    --secondary-color: #f8fafc;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --border-color: #e2e8f0;
    --success-color: #10b981;
    --error-color: #ef4444;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    color: var(--text-primary);
    line-height: 1.6;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    width: 100%;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
}

.page-title {
    text-align: center;
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.page-subtitle {
    text-align: center;
    color: var(--text-secondary);
    font-size: 1.125rem;
    margin-bottom: 3rem;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.alert-error ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.alert-error li {
    color: var(--error-color);
    font-weight: 500;
    margin-bottom: 0.5rem;
    padding-left: 1.5rem;
    position: relative;
}

.alert-error li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--error-color);
}

.form-group {
    margin-bottom: 2rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
    letter-spacing: 0.025em;
    text-transform: uppercase;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
    color: var(--text-primary);
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgb(99 102 241 / 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.file-upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 12px;
    padding: 3rem 2rem;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
    background: #fafafa;
}

.file-upload-area:hover {
    border-color: var(--primary-color);
    background: #f8fafc;
}

.file-upload-area.has-file {
    border-color: var(--success-color);
    background: #f0fdf4;
}

.file-upload-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-content {
    pointer-events: none;
}

.file-upload-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.file-upload-subtitle {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.file-preview {
    margin-bottom: 1rem;
}

.file-preview img {
    max-width: 200px;
    max-height: 150px;
    border-radius: 8px;
    box-shadow: var(--shadow-md);
}

.btn-group {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 3rem;
    flex-wrap: wrap;
}

.btn {
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    min-width: 140px;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-secondary {
    background: white;
    color: var(--text-secondary);
    border-color: var(--border-color);
}

.btn-secondary:hover {
    background: var(--secondary-color);
    color: var(--text-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .form-card {
        padding: 2rem 1.5rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .page-title {
        font-size: 1.875rem;
    }
    
    .btn-group {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 300px;
    }
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loading-spinner {
    width: 48px;
    height: 48px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="container">
    <div class="form-card">
        <h1 class="page-title">Thêm Sản Phẩm Mới</h1>
        <p class="page-subtitle">Điền thông tin chi tiết để thêm sản phẩm vào hệ thống</p>
        
        <?php if (!empty($errors)): ?>
            <div class="alert-error">
                <ul>
                    <?php foreach ($errors as $field => $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="/buoi2/Product/save" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="form-label">Tên Sản Phẩm</label>
                <input type="text" class="form-input" id="name" name="name" required 
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                       placeholder="Nhập tên sản phẩm">
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Mô Tả Chi Tiết</label>
                <textarea class="form-textarea" id="description" name="description" required
                          placeholder="Mô tả chi tiết về sản phẩm"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price" class="form-label">Giá Bán (VNĐ)</label>
                    <input type="number" class="form-input" id="price" name="price" required min="0"
                           value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>"
                           placeholder="0">
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">Danh Mục</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Chọn danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" 
                                    <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Hình Ảnh Sản Phẩm</label>
                <div class="file-upload-area" id="fileUploadArea">
                    <input type="file" class="file-upload-input" id="image" name="image" accept="image/*">
                    <div class="file-upload-content">
                        <div class="file-upload-title">Chọn hình ảnh sản phẩm</div>
                        <div class="file-upload-subtitle">PNG, JPG, GIF tối đa 5MB</div>
                    </div>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    Lưu Sản Phẩm
                </button>
                
                <a href="/buoi2/Product" class="btn btn-secondary">
                    Quay lại danh sách
                </a>
                
                <a href="/buoi2/Dashboard" class="btn btn-secondary">
                    Trang tổng quan
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// File upload handling
document.getElementById('image').addEventListener('change', function(e) {
    const fileUploadArea = document.getElementById('fileUploadArea');
    const file = e.target.files[0];
    
    if (file) {
        const fileName = file.name;
        
        const reader = new FileReader();
        reader.onload = function(event) {
            fileUploadArea.classList.add('has-file');
            fileUploadArea.querySelector('.file-upload-content').innerHTML = `
                <div class="file-preview">
                    <img src="${event.target.result}" alt="Preview">
                </div>
                <div class="file-upload-title">Đã chọn: ${fileName}</div>
                <div class="file-upload-subtitle">Nhấn để thay đổi</div>
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Form submission
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const inputs = this.querySelectorAll('.form-input, .form-textarea, .form-select');
    let isValid = true;
    
    inputs.forEach(input => {
        if (input.hasAttribute('required') && !input.value.trim()) {
            input.style.borderColor = 'var(--error-color)';
            input.style.boxShadow = '0 0 0 3px rgb(239 68 68 / 0.1)';
            isValid = false;
            
            setTimeout(() => {
                input.style.borderColor = 'var(--border-color)';
                input.style.boxShadow = 'none';
            }, 3000);
        }
    });
    
    if (isValid) {
        showLoading();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            hideLoading();
            if (data.includes('success') || !data.includes('error')) {
                showSuccessModal();
            } else {
                alert('Có lỗi xảy ra khi thêm sản phẩm');
            }
        })
        .catch(error => {
            hideLoading();
            alert('Có lỗi xảy ra: ' + error.message);
        });
    }
});

function showLoading() {
    const loadingHTML = `
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>`;
    document.body.insertAdjacentHTML('beforeend', loadingHTML);
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.remove();
    }
}

function showSuccessModal() {
    if (confirm('Sản phẩm đã được thêm thành công! Bạn có muốn chuyển đến danh sách sản phẩm?')) {
        window.location.href = '/buoi2/Product/index';
    } else {
        window.location.href = '/buoi2/Product/add';
    }
}
</script>

<?php include 'app/views/shares/footer.php'; ?>