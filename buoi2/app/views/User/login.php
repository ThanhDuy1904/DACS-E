<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            /* A more subtle and modern gradient */
            background: #e0eafc;
            background: -webkit-linear-gradient(to right, #e0eafc, #cfdef3);
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            font-weight: 700;
            color: #212529;
        }
        
        /* Input group styling for icons */
        .input-group-text {
            background-color: transparent;
            border-right: 0;
            color: #6c757d;
        }
        
        .form-control {
            border-left: 0;
            padding-left: 0;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        
        .input-group:focus-within {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-radius: .375rem;
        }

        .btn-primary {
            font-weight: 500;
            padding: 0.75rem;
            border-radius: 0.5rem;
        }
        
        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="text-center mb-4">
            <i class="bi bi-person-circle" style="font-size: 3.5rem; color: #0d6efd;"></i>
        </div>
        <h2 class="text-center mb-4">Đăng nhập tài khoản</h2>
        
        <?php if (isset($error)) : ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required />
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-left: 0;">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
            
            <div class="d-flex justify-content-end mb-4">
                <a href="/buoi2/User/forgotPasswordStep1" class="text-decoration-none">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

       
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>

</body>
</html>