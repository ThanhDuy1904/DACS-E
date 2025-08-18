<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đặt hàng thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #007bff, #e0f0ff);
            font-family: Arial, sans-serif;
        }
        .success-container {
            background: white;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            color: #007bff;
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            font-weight: 500;
        }
        .btn-back {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #0056b3;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h2>Đặt hàng thành công!</h2>
        <a href="/buoi2/Product/" class="btn-back">Quay lại danh sách sản phẩm</a>
    </div>
</body>
</html>
