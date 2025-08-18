<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng #<?= $order['id'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .order-info { margin-bottom: 20px; }
        .products table { width: 100%; border-collapse: collapse; }
        .products th, .products td { border: 1px solid #000; padding: 5px; }
        .total { margin-top: 20px; text-align: right; }
        .staff-info { margin: 30px 0; border-top: 1px dashed #ccc; padding-top: 20px; }
        .signature-area { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature-box { text-align: center; width: 200px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TD COFFEE</h1>
        <h2>ĐƠN HÀNG #<?= $order['id'] ?></h2>
    </div>

    <div class="order-info">
        <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name'] ?? 'Khách vãng lai') ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone'] ?? 'N/A') ?></p>
        <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
        <p><strong>Nhân viên xử lý:</strong> <?= htmlspecialchars($order['username'] ?? 'N/A') ?></p>
    </div>

    <div class="products">
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                    <th>Tùy chọn</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $subtotal = 0;
                foreach ($order['details'] as $detail): 
                    $itemTotal = $detail['price'] * $detail['quantity'];
                    $subtotal += $itemTotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['product_name']) ?></td>
                        <td><?= $detail['quantity'] ?></td>
                        <td><?= number_format($detail['price'], 0, ',', '.') ?>đ</td>
                        <td><?= number_format($itemTotal, 0, ',', '.') ?>đ</td>
                        <td>
                            <?php
                            $options = [];
                            if (!empty($detail['sugar_level'])) $options[] = "Đường: " . $detail['sugar_level'];
                            if (!empty($detail['ice_level'])) $options[] = "Đá: " . $detail['ice_level'];
                            if (!empty($detail['cup_size'])) $options[] = "Size: " . $detail['cup_size'];
                            echo implode(", ", $options);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="total">
        <?php if (!empty($order['discount_amount'])): ?>
            <p><strong>Tổng tiền hàng:</strong> <?= number_format($subtotal + $order['discount_amount'], 0, ',', '.') ?>đ</p>
            <p><strong>Giảm giá:</strong> -<?= number_format($order['discount_amount'], 0, ',', '.') ?>đ</p>
        <?php endif; ?>
        <p><strong>Thành tiền:</strong> <?= number_format($subtotal, 0, ',', '.') ?>đ</p>
    </div>

  
    <div style="margin-top: 40px; text-align: center;">
        <p>Cảm ơn quý khách đã sử dụng dịch vụ của TD COFFEE!</p>
        <p style="font-size: 12px; color: #666;">In lúc: <?= date('d/m/Y H:i:s') ?></p>
    </div>
</body>
</html>
