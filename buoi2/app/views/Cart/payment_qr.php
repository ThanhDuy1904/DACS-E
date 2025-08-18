<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thanh toán mã QR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #007bff, #e0f0ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .qr-container {
            background: white;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .qr-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .info-text {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h2>Thanh toán bằng mã QR</h2>

        <?php
        // Hàm tạo chuỗi ngẫu nhiên 6 ký tự chữ và số
        function generateRandomString($length = 6) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        $randomContent = generateRandomString();
        ?>

        <div class="info-text">Nội dung đơn hàng: <strong><?php echo $randomContent; ?></strong></div>

        <?php if ($method === 'bank'): ?>
            <div class="info-text">Quét mã QR để thanh toán ngân hàng</div>
            <img src="/buoi2//uploads/z6621726084699_e533c16aad6e47e97d1c0a308279e4c9.jpg" alt="Mã QR thanh toán ngân hàng" class="qr-image" />
        <?php elseif ($method === 'zalopay'): ?>
            <div class="info-text">Quét mã QR để thanh toán Zalo Pay</div>
            <img src="/buoi2/uploads/z6621726084699_e533c16aad6e47e97d1c0a308279e4c9.jpg" alt="Mã QR thanh toán Zalo Pay" class="qr-image" />
        <?php else: ?>
            <div class="info-text text-danger">Phương thức thanh toán không hợp lệ.</div>
        <?php endif; ?>


        <div class="info-text mt-3">Tổng giá sản phẩm cần thanh toán: <strong><?php echo number_format($totalAmount ?? 0, 0, ',', '.'); ?> đ</strong></div>

        <form method="POST" action="/buoi2/Cart/success">
            <button type="submit" class="btn btn-primary mt-3">Đã quét mã thanh toán</button>
        </form>

        <a href="/buoi2/Cart" class="back-link">Quay lại giỏ hàng</a>
    </div>
</body>
</html>
