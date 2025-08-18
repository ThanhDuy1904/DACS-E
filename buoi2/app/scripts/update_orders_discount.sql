-- Cập nhật bảng orders để lưu thông tin giảm giá
ALTER TABLE orders ADD discount_code VARCHAR(50) NULL;
ALTER TABLE orders ADD discount_amount DECIMAL(10,2) DEFAULT 0;
ALTER TABLE orders ADD original_total DECIMAL(10,2) NULL;
ALTER TABLE orders ADD final_total DECIMAL(10,2) NULL;

-- Cập nhật các đơn hàng hiện tại
UPDATE orders SET discount_amount = 0 WHERE discount_amount IS NULL;
