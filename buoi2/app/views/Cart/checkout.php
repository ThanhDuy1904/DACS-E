<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thanh toán</title>
    <style>
        body {
            background-color: #e6f0ff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .cart-container {
            background: white;
            margin: 40px 0;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
            width: 90%;
            max-width: 800px;
        }
        h2 {
            text-align: center;
            color: #004080;
            margin-bottom: 20px;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            margin-bottom: 15px;
            color: #004080;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .back-button svg {
            margin-right: 6px;
            width: 16px;
            height: 16px;
            fill: #004080;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #004080;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f0f8ff;
        }
        .quantity {
            text-align: center;
        }
        .total {
            font-weight: bold;
            font-size: 1.1em;
            text-align: right;
            margin-top: 15px;
        }
        .btn-checkout {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #004080;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            text-align: center;
            text-decoration: none;
        }
        .btn-checkout:hover {
            background-color: #00264d;
        }
        .btn-delete {
            background-color: #ff4d4d;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #cc0000;
        }
        input.quantity-input {
            width: 50px;
            text-align: center;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 4px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }
        .form-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: #004080;
        }
        input.form-control, textarea.form-control, select.form-select {
            border-radius: 12px;
            border: 1.5px solid #004080;
            padding: 12px 15px;
            font-size: 1.1rem;
            transition: border-color 0.3s ease;
        }
        input.form-control:focus, textarea.form-control:focus, select.form-select:focus {
            border-color: #00264d;
            box-shadow: 0 0 10px rgba(0, 38, 77, 0.4);
            outline: none;
        }
        .selected-products {
            background-color: #f0f8ff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: inset 0 0 15px rgba(0, 102, 204, 0.15);
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .selected-products h3 {
            margin-top: 0;
            color: #004080;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 20px;
            border-bottom: 2px solid #004080;
            padding-bottom: 8px;
        }
        table.table-bordered {
            border: 1px solid #004080;
            width: 100%;
            border-collapse: collapse;
        }
        table.table-bordered th, table.table-bordered td {
            border: 1px solid #004080;
            padding: 12px 8px;
            text-align: left;
        }
        table.table-bordered th {
            background-color: #004080;
            color: white;
            font-weight: bold;
        }
        table.table-bordered tr:hover {
            background-color: #e6f0ff;
        }
        .summary-section {
            font-size: 1.2rem;
            color: #004080;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-top: 2px solid #004080;
            padding-top: 15px;
            margin-bottom: 20px;
        }
        .summary-label {
            font-weight: 700;
        }
        .summary-value {
            font-weight: 800;
            float: right;
        }
        .payment-methods {
            border-top: 2px solid #004080;
            padding-top: 20px;
            margin-bottom: 20px;
        }
        .payment-methods .form-check {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #004080;
            border: none;
            border-radius: 15px;
            padding: 15px 0;
            font-weight: 800;
            font-size: 1.3rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.4);
        }
        .btn-primary:hover {
            background-color: #00264d;
            box-shadow: 0 7px 20px rgba(0, 38, 77, 0.6);
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <a href="/buoi2/app/views/Cart/" class="back-button" title="Quay lại giỏ hàng">
            <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            Quay lại giỏ hàng
        </a>
        <h2>Thanh toán</h2>
        <form method="POST" action="/buoi2/Cart/process_payment" novalidate>
            <div class="payment-methods">
                <label class="form-label">Phương thức thanh toán</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                    <label class="form-check-label" for="bank">Thanh toán ngân hàng</label>
                </div>
            </div>
            <button type="submit" class="btn-primary btn-submit">Xác nhận thanh toán</button>
        </form>
    </div>
    
    <script>
        // JavaScript validation for required fields before form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                // Không kiểm tra các trường fullname, email, phone, address theo yêu cầu
            });
        });
    </script>
</body>
</html>
