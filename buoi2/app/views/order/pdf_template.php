<h1>CHI TIẾT ĐƠN HÀNG</h1>
<p><strong>Mã đơn hàng:</strong> <?php echo $order['id']; ?></p>
<p><strong>Ngày đặt:</strong> <?php echo $order['order_date']; ?></p>
<p><strong>Tên khách hàng:</strong> <?php echo $order['customer_name']; ?></p>
<p><strong>Địa chỉ giao hàng:</strong> <?php echo $order['shipping_address']; ?></p>
<br>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="width: 5%;">STT</th>
            <th style="width: 45%;">Tên sản phẩm</th>
            <th style="width: 20%;">Số lượng</th>
            <th style="width: 30%;">Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php $stt = 1; ?>
        <?php foreach ($order['details'] as $detail): ?>
            <tr>
                <td><?php echo $stt++; ?></td>
                <td><?php echo $detail['product_name']; ?></td>
                <td><?php echo $detail['quantity']; ?></td>
                <td><?php echo number_format($detail['price'], 0, ',', '.'); ?> VND</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<p style="text-align: right;"><strong>Tổng tiền:</strong> <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</p>