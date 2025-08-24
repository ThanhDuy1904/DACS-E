<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn #<?php echo $order['id']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.4;
        }
        
        @media print {
            body { margin: 0; padding: 15mm; }
            .no-print { display: none; }
            @page { margin: 10mm; }
        }
        
        @media screen {
            body { max-width: 800px; margin: 0 auto; background: white; }
            .print-button {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                z-index: 1000;
            }
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #0066cc;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 18px;
            color: #333;
            margin-top: 10px;
        }
        
        .order-info {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .info-row {
            margin-bottom: 8px;
            overflow: hidden;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
            float: left;
            width: 150px;
        }
        
        .info-value {
            margin-left: 155px;
            color: #555;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border: 1px solid #ddd;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            text-align: center;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .total-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e8;
            border: 2px solid #28a745;
            border-radius: 5px;
        }
        
        .total-row {
            margin-bottom: 5px;
            overflow: hidden;
        }
        
        .total-label {
            font-weight: bold;
            float: left;
            color: #333;
        }
        
        .total-amount {
            font-weight: bold;
            font-size: 16px;
            color: #28a745;
            float: right;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ In hóa đơn</button>
    
    <div class="header">
        <div class="company-name">🥤 TD COFFEE</div>
        <div class="invoice-title">HÓA ĐƠN BÁN HÀNG</div>
    </div>

    <div class="order-info">
        <div class="info-row">
            <span class="info-label">Mã đơn hàng:</span>
            <div class="info-value">#<?php echo htmlspecialchars($order['id']); ?></div>
        </div>
        <div class="info-row">
            <span class="info-label">Ngày đặt:</span>
            <div class="info-value"><?php echo date('d/m/Y H:i:s', strtotime($order['created_at'])); ?></div>
        </div>
        <div class="info-row">
            <span class="info-label">Khách hàng:</span>
            <div class="info-value"><?php echo htmlspecialchars($order['customer_name'] ?: 'Khách vãng lai'); ?></div>
        </div>
        <?php if (!empty($order['phone'])): ?>
        <div class="info-row">
            <span class="info-label">Số điện thoại:</span>
            <div class="info-value"><?php echo htmlspecialchars($order['phone']); ?></div>
        </div>
        <?php endif; ?>
        <div class="info-row">
            <span class="info-label">Phương thức thanh toán:</span>
            <div class="info-value"><?php echo htmlspecialchars($order['payment_method']); ?></div>
        </div>
        <div class="info-row">
            <span class="info-label">Trạng thái:</span>
            <div class="info-value"><?php echo htmlspecialchars($order['status']); ?></div>
        </div>
        <div class="info-row">
            <span class="info-label">Nhân viên:</span>
            <div class="info-value"><?php echo htmlspecialchars($order['username'] ?? 'N/A'); ?></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">STT</th>
                <th style="width: 35%;">Tên sản phẩm</th>
                <th style="width: 15%;">Số lượng</th>
                <th style="width: 20%;">Đơn giá</th>
                <th style="width: 25%;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $stt = 1; 
            $totalAmount = 0; // Tổng tiền từ giá gốc
            ?>
            <?php foreach ($order['details'] as $detail): ?>
                <?php 
                $subtotal = $detail['price'] * $detail['quantity'];
                $totalAmount += $subtotal; // Cộng dồn từ giá gốc
                ?>
                <tr>
                    <td class="text-center"><?php echo $stt++; ?></td>
                    <td>
                        <?php echo htmlspecialchars($detail['product_name']); ?>
                        <?php if (!empty($detail['sugar_level']) || !empty($detail['ice_level']) || !empty($detail['cup_size'])): ?>
                        <br><small style="color: #666;">
                            <?php if (!empty($detail['sugar_level'])): ?>🍯 <?php echo htmlspecialchars($detail['sugar_level']); ?> <?php endif; ?>
                            <?php if (!empty($detail['ice_level'])): ?>🧊 <?php echo htmlspecialchars($detail['ice_level']); ?> <?php endif; ?>
                            <?php if (!empty($detail['cup_size'])): ?>🥤 <?php echo htmlspecialchars($detail['cup_size']); ?><?php endif; ?>
                        </small>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?php echo number_format($detail['quantity']); ?></td>
                    <td class="text-right"><?php echo number_format($detail['price'], 0, ',', '.'); ?>đ</td>
                    <td class="text-right"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-section">
        <?php 
        $discountAmount = floatval($order['discount_amount'] ?? 0); 
        $finalTotal = $totalAmount - $discountAmount; // Tổng cuối = Tổng gốc - Giảm giá
        ?>
        <?php if ($discountAmount > 0): ?>
            <div class="total-row">
                <span class="total-label">Tổng gốc:</span>
                <span style="float: right;"><?php echo number_format($totalAmount, 0, ',', '.'); ?>đ</span>
            </div>
            <div class="total-row" style="color: #dc3545;">
                <span class="total-label">Giảm giá:</span>
                <span style="float: right;">-<?php echo number_format($discountAmount, 0, ',', '.'); ?>đ</span>
            </div>
            <?php if (!empty($order['discount_code'])): ?>
            <div class="total-row" style="font-size: 12px;">
                <span>Mã giảm giá: <?php echo htmlspecialchars($order['discount_code']); ?></span>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="total-row" style="border-top: 2px solid #28a745; padding-top: 8px; margin-top: 8px;">
            <span class="total-label" style="font-size: 16px;">TỔNG THANH TOÁN:</span>
            <span class="total-amount"><?php echo number_format($finalTotal, 0, ',', '.'); ?>đ</span>
        </div>
    </div>

    <div class="footer">
        <p><strong>Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi!</strong></p>
        <p>📞 Hotline: 0966.106.xxx | 📧 Email: contact@tdcoffe.com</p>
        <p>📅 Ngày in: <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>

    <script>
        // Auto print when page loads
        setTimeout(function() {
            window.print();
        }, 500);
    </script>
</body>
</html>