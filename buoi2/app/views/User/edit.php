<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tài khoản</title>
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
            max-width: 600px;
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
            color: var(--error-color);
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .alert-error::before {
            content: '⚠️';
            margin-right: 0.75rem;
            font-size: 1.25rem;
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
        .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgb(99 102 241 / 0.1);
            transform: translateY(-1px);
        }

        .form-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-right: 45px;
            appearance: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
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
            position: relative;
            overflow: hidden;
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

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
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

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.125rem;
        }

        .has-icon .form-input {
            padding-left: 3rem;
        }

        .role-indicator {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .role-admin {
            background: linear-gradient(135deg, #fef3c7, #fbbf24);
            color: #92400e;
        }

        .role-employee {
            background: linear-gradient(135deg, #d1fae5, #10b981);
            color: #047857;
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
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
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

        .success-message {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border: 1px solid #6ee7b7;
            color: var(--success-color);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .success-message::before {
            content: '✅';
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="container">
        <div class="form-card">
            <h1 class="page-title">Chỉnh sửa tài khoản</h1>
            <p class="page-subtitle">Cập nhật thông tin và quyền hạn người dùng</p>
            
            <?php if (isset($error) && $error): ?>
                <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="post" action="" id="editForm">
                <div class="form-group">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <div class="input-group has-icon">
                        <span class="input-icon"></span>
                        <input type="text" class="form-input" id="username" name="username" 
                               value="<?= htmlspecialchars($user['username']) ?>" required 
                               placeholder="Nhập tên đăng nhập">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <div class="input-group has-icon">
                            <span class="input-icon"></span>
                            <input type="text" class="form-input" id="phone" name="phone" 
                                   value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                                   placeholder="Số điện thoại">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group has-icon">
                            <span class="input-icon"></span>
                            <input type="email" class="form-input" id="email" name="email" 
                                   value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                                   placeholder="Địa chỉ email">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <div class="input-group has-icon">
                            <span class="input-icon"></span>
                            <input type="password" class="form-input" id="password" name="password"
                                   placeholder="Để trống nếu không đổi">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                        <div class="input-group has-icon">
                            <span class="input-icon"></span>
                            <input type="password" class="form-input" id="confirm_password" name="confirm_password"
                                   placeholder="Xác nhận mật khẩu mới">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Vai trò</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Quản trị viên</option>
                        <option value="employee" <?= $user['role'] === 'employee' ? 'selected' : '' ?>>Nhân viên</option>
                    </select>
                    <div class="role-indicator <?= $user['role'] === 'admin' ? 'role-admin' : 'role-employee' ?>" id="roleIndicator">
                        <span id="roleText">
                            <?= $user['role'] === 'admin' ? 'Quản trị viên' : ' Nhân viên' ?>
                        </span>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        Lưu thay đổi
                    </button>
                    <a href="/buoi2/DashboardUser/index" class="btn btn-secondary">
                        Hủy bỏ
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form validation and submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                showError('Mật khẩu xác nhận không khớp!');
                return;
            }
            
            showLoading();
            
            // Submit form
            setTimeout(() => {
                this.submit();
            }, 500);
        });

        // Role change indicator
        document.getElementById('role').addEventListener('change', function() {
            const roleIndicator = document.getElementById('roleIndicator');
            const roleText = document.getElementById('roleText');
            
            if (this.value === 'admin') {
                roleIndicator.className = 'role-indicator role-admin';
                roleText.textContent = 'Quản trị viên';
            } else {
                roleIndicator.className = 'role-indicator role-employee';
                roleText.textContent = ' Nhân viên';
            }
        });

        // Input focus effects
        document.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.form-group').style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.closest('.form-group').style.transform = 'translateY(0)';
            });
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            if (password.length > 0 && password.length < 6) {
                this.style.borderColor = '#f59e0b';
            } else if (password.length >= 6) {
                this.style.borderColor = '#10b981';
            } else {
                this.style.borderColor = 'var(--border-color)';
            }
        });

        function showLoading() {
            document.getElementById('loadingOverlay').classList.add('show');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('show');
        }

        function showError(message) {
            // Create temporary error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert-error';
            errorDiv.textContent = message;
            
            const form = document.getElementById('editForm');
            form.insertBefore(errorDiv, form.firstChild);
            
            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }
    </script>
</body>
</html>
