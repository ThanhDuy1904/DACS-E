<?php
include 'app/views/shares/header.php';
?>

<style>
    .combined-container {
        display: flex;
        gap: 30px;
        max-width: 1400px;
        margin: 20px auto;
        padding: 20px;
        min-height: 100vh;
    }
    .left-panel {
        flex: 2;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 20px 25px rgba(0,0,0,0.1);
        overflow-y: auto;
        max-height: 90vh;
    }
    .right-panel {
        flex: 1;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 20px 25px rgba(0,0,0,0.1);
        overflow-y: auto;
        max-height: 90vh;
    }
</style>

<div class="combined-container">
    <div class="left-panel">
        <?php
        // Biến $products cần được truyền từ controller
        include 'app/views/product/product_list_content.php';
        ?>
    </div>
    <div class="right-panel">
        <?php
        // Biến $cartItems, $discounts cần được truyền từ controller
        include 'app/views/cart/cart_content.php';
        ?>
    </div>
</div>

<?php
include 'app/views/shares/footer.php';
?>
