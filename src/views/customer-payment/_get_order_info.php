<?php

use modava\customer\models\table\CustomerPaymentTable;

/* @var $order \modava\customer\models\table\CustomerOrderTable */
?>
<div class="order-info table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Product ID</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total Price</th>
            <th>Discount</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php if (is_array($order->orderDetailHasMany)) {
            foreach ($order->orderDetailHasMany as $order_detail) {
                $total_price = $order_detail->price * $order_detail->qty;
                $discount = 0;
                if ($order_detail->discount_by == CustomerPaymentTable::DISCOUNT_BY_MONEY) $discount = $order_detail->discount;
                else if ($order_detail->discount_by == CustomerPaymentTable::DISCOUNT_BY_PERCENT) $discount = $total_price * $order_detail->discount / 100;
                ?>
                <tr>
                    <td><?= $order_detail->productHasOne->name ?></td>
                    <td><?= $order_detail->price ?></td>
                    <td><?= $order_detail->qty ?></td>
                    <td><?= $total_price ?></td>
                    <td><?= $discount ?></td>
                    <td><?= $total_price - $discount ?></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
</div>