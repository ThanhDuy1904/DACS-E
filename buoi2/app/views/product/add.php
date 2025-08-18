<?php 
if (!isset($_SESSION['user_id'])) {
    header('Location: /buoi2/User/login');
    exit();
}
include 'app/views/shares/header.php'; 
?>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --card-shadow: 0 20px 40px rgba(0,0,0,0.1);
    --hover-shadow: 0 30px 60px rgba(0,0,0,0.15);
}

body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.modern-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 20px;
}

.glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 3rem;
    box-shadow: var(--card-shadow);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.glass-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--hover-shadow);
}

.modern-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 2rem;
    position: relative;
}

.modern-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--secondary-gradient);
    border-radius: 2px;
}

.form-floating {
    position: relative;
    margin-bottom: 2rem;
}

.modern-input {
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 16px;
    padding: 1rem 1.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
}

.modern-input:focus {
    outline: none;
    border-color: #667eea;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.modern-textarea {
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 16px;
    padding: 1rem 1.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
    resize: vertical;
    min-height: 120px;
}

.modern-textarea:focus {
    outline: none;
    border-color: #667eea;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.modern-select {
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 16px;
    padding: 1rem 1.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
    cursor: pointer;
}

.modern-select:focus {
    outline: none;
    border-color: #667eea;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.modern-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
}

.file-upload-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}

.file-upload-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(102, 126, 234, 0.1);
    border: 2px dashed rgba(102, 126, 234, 0.3);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    min-height: 100px;
}

.file-upload-label:hover {
    background: rgba(102, 126, 234, 0.2);
    border-color: #667eea;
    transform: translateY(-2px);
}

.file-upload-icon {
    font-size: 2rem;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.file-upload-text {
    color: #667eea;
    font-weight: 600;
}

.modern-btn {
    background: var(--primary-gradient);
    border: none;
    border-radius: 50px;
    padding: 1rem 3rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.modern-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.modern-btn:active {
    transform: translateY(-1px);
}

.modern-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.modern-btn:hover::before {
    left: 100%;
}

.alert-modern {
    background: rgba(245, 87, 108, 0.1);
    border: 1px solid rgba(245, 87, 108, 0.3);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    backdrop-filter: blur(10px);
}

.alert-modern ul {
    margin: 0;
    padding-left: 1.5rem;
}

.alert-modern li {
    color: #e53e3e;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .glass-card {
        padding: 2rem 1.5rem;
        margin: 1rem;
    }
    
    .modern-title {
        font-size: 2rem;
    }
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
    opacity: 0.1;
    animation: float 20s infinite linear;
}

.shape:nth-child(1) {
    top: 10%;
    left: 10%;
    width: 80px;
    height: 80px;
    background: #667eea;
    border-radius: 50%;
    animation-delay: 0s;
}

.shape:nth-child(2) {
    top: 70%;
    right: 10%;
    width: 120px;
    height: 120px;
    background: #764ba2;
    border-radius: 30%;
    animation-delay: 5s;
}

.shape:nth-child(3) {
    bottom: 20%;
    left: 20%;
    width: 60px;
    height: 60px;
    background: #f093fb;
    border-radius: 50%;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    25% {
        transform: translateY(-20px) rotate(90deg);
    }
    50% {
        transform: translateY(-40px) rotate(180deg);
    }
    75% {
        transform: translateY(-20px) rotate(270deg);
    }
}
</style>

<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<div class="modern-container">
    <div class="glass-card">
        <h1 class="modern-title">✨ Thêm Sản Phẩm Mới</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert-modern">
                <ul>
                    <?php foreach ($errors as $field => $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="/buoi2/Product/save" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="modern-label">🏷️ Tên Sản Phẩm</label>
                <input type="text" class="modern-input" id="name" name="name" required 
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                       placeholder="Nhập tên sản phẩm...">
            </div>

            <div class="form-group">
                <label for="description" class="modern-label">📝 Mô Tả Chi Tiết</label>
                <textarea class="modern-textarea" id="description" name="description" required
                          placeholder="Mô tả chi tiết về sản phẩm..."><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price" class="modern-label">💰 Giá Bán</label>
                    <input type="number" class="modern-input" id="price" name="price" required min="0"
                           value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>"
                           placeholder="0">
                </div>

                <div class="form-group">
                    <label for="category_id" class="modern-label">📂 Danh Mục</label>
                    <select class="modern-select" id="category_id" name="category_id" required>
                        <option value="">Chọn danh mục...</option>
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
                <label for="image" class="modern-label">📸 Hình Ảnh Sản Phẩm</label>
                <div class="file-upload-wrapper">
                    <input type="file" class="file-upload-input" id="image" name="image" accept="image/*">
                    <label for="image" class="file-upload-label">
                        <div>
                            <div class="file-upload-icon">📁</div>
                            <div class="file-upload-text">Chọn hình ảnh sản phẩm</div>
                            <small style="color: #666;">PNG, JPG, GIF tối đa 5MB</small>
                        </div>
                    </label>
                </div>
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <button type="submit" class="modern-btn">
                    💾 Lưu Sản Phẩm
                </button>
                
                <a href="/buoi2/Product" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Hiệu ứng cho file upload
document.getElementById('image').addEventListener('change', function(e) {
    const label = document.querySelector('.file-upload-label');
    const fileName = e.target.files[0]?.name;
    
    if (fileName) {
        label.innerHTML = `
            <div>
                <div class="file-upload-icon">✅</div>
                <div class="file-upload-text">Đã chọn: ${fileName}</div>
                <small style="color: #667eea;">Nhấn để thay đổi</small>
            </div>
        `;
        label.style.background = 'rgba(102, 126, 234, 0.2)';
        label.style.borderColor = '#667eea';
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const inputs = this.querySelectorAll('.modern-input, .modern-textarea, .modern-select');
    let isValid = true;
    
    inputs.forEach(input => {
        if (input.hasAttribute('required') && !input.value.trim()) {
            input.style.borderColor = '#e53e3e';
            input.style.boxShadow = '0 0 20px rgba(229, 62, 62, 0.2)';
            isValid = false;
            
            setTimeout(() => {
                input.style.borderColor = 'rgba(102, 126, 234, 0.2)';
                input.style.boxShadow = 'none';
            }, 3000);
        }
    });
    
    if (!isValid) {
        e.preventDefault();
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>