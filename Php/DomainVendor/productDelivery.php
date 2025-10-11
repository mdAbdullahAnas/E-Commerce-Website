<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/SSM/Connection/db.php");

// Only vendors
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'vendor'){
    header("Location: ../Auth/login.php");
    exit;
}

// ✅ Get numeric vendor ID
$vendor_username = $_SESSION['userid'];
$stmt = $conn->prepare("SELECT id FROM vendors WHERE username=? LIMIT 1");
$stmt->bind_param("s", $vendor_username);
$stmt->execute();
$res = $stmt->get_result();
if($row = $res->fetch_assoc()){
    $vendor_id = $row['id'];
} else {
    die("Vendor not found!");
}

// --- Handle status update & assign delivery man ---
if(isset($_POST['update_order'])){
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $delivery_man_id = !empty($_POST['delivery_man_id']) ? intval($_POST['delivery_man_id']) : null;
    $expected_delivery = !empty($_POST['expected_delivery']) ? $_POST['expected_delivery'] : null;

    $stmt = $conn->prepare("
        UPDATE orders 
        SET status=?, delivery_man_id=?, expected_delivery=? 
        WHERE id=? AND id IN (
            SELECT o.id FROM orders o 
            JOIN order_items oi ON o.id=oi.order_id 
            JOIN products p ON oi.product_id=p.id 
            WHERE p.vendor_id=?
        )
    ");
    $stmt->bind_param("sissi",$status,$delivery_man_id,$expected_delivery,$order_id,$vendor_id);
    $stmt->execute();
    $_SESSION['success'] = "Order #$order_id updated.";
}

// --- Fetch all orders for this vendor ---
$sql = "
SELECT o.*, u.fullname AS customer_name
FROM orders o
JOIN users u ON o.customer_id = u.id
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE p.vendor_id = ?
GROUP BY o.id
ORDER BY o.created_at DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$vendor_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

// --- Fetch all delivery men for this vendor ---
$dm_result = $conn->prepare("SELECT * FROM delivery_men WHERE vendor_id=?");
$dm_result->bind_param("i",$vendor_id);
$dm_result->execute();
$dm_res = $dm_result->get_result();
$delivery_men = $dm_res->fetch_all(MYSQLI_ASSOC);

include("../DomainVendor/navbar.php");
?>
<link rel="stylesheet" href="/SSM/Asset/Css/Domain/Customer/cartPayment.css">

<div class="main-content">
    <h2>Vendor Orders</h2>
    <?php if(isset($_SESSION['success'])){ echo "<p style='color:green'>".$_SESSION['success']."</p>"; unset($_SESSION['success']); } ?>

    <?php if(empty($orders)): ?>
        <p>No orders found for your products.</p>
    <?php else: ?>
        <?php foreach($orders as $order): ?>
            <div class="order-card">
                <h3>Order #<?= $order['id'] ?> | Status: <?= $order['status'] ?> | <?= $order['created_at'] ?></h3>
                <p><b>Customer:</b> <?= htmlspecialchars($order['customer_name']) ?></p>
                <p><b>Address:</b> <?= htmlspecialchars($order['address']) ?></p>
                <p><b>Contact:</b> <?= htmlspecialchars($order['contact_number']) ?></p>
                <p><b>Total:</b> $<?= number_format($order['total'],2) ?> | <b>Discount:</b> $<?= number_format($order['discount'],2) ?></p>
                <p><b>Payment:</b> <?= htmlspecialchars($order['payment_method']) ?></p>

                <?php if(!empty($order['delivery_man_id'])): ?>
                    <?php
                    $stmtDel = $conn->prepare("SELECT name, phone FROM delivery_men WHERE id=? LIMIT 1");
                    $stmtDel->bind_param("i", $order['delivery_man_id']);
                    $stmtDel->execute();
                    $resDel = $stmtDel->get_result();
                    $del = $resDel->fetch_assoc();
                    ?>
                    <p><b>Delivery Man:</b> <?= htmlspecialchars($del['name']) ?> (<?= htmlspecialchars($del['phone']) ?>)</p>
                <?php else: ?>
                    <p><b>Delivery Man:</b> Not assigned</p>
                <?php endif; ?>

                <?php if(!empty($order['expected_delivery'])): ?>
                    <p><b>Expected Delivery:</b> <?= $order['expected_delivery'] ?></p>
                <?php endif; ?>

                <h4>Items:</h4>
                <ul>
                    <?php
                    $stmtItem = $conn->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE order_id=?");
                    $stmtItem->bind_param("i",$order['id']);
                    $stmtItem->execute();
                    $resItem = $stmtItem->get_result();
                    while($item = $resItem->fetch_assoc()):
                    ?>
                        <li><?= htmlspecialchars($item['name']) ?> - <?= $item['quantity'] ?> × $<?= number_format($item['price'],2) ?></li>
                    <?php endwhile; ?>
                </ul>

                <!-- Vendor can assign delivery man and update status -->
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <label>Status:</label>
                    <select name="status">
                        <option value="Pending" <?= $order['status']=='Pending'?'selected':'' ?>>Pending</option>
                        <option value="Processing" <?= $order['status']=='Processing'?'selected':'' ?>>Processing</option>
                        <option value="Shipped" <?= $order['status']=='Shipped'?'selected':'' ?>>Shipped</option>
                        <option value="Delivered" <?= $order['status']=='Delivered'?'selected':'' ?>>Delivered</option>
                        <option value="Cancelled" <?= $order['status']=='Cancelled'?'selected':'' ?>>Cancelled</option>
                    </select>
                    <label>Delivery Man:</label>
                    <select name="delivery_man_id">
                        <option value="">-- Select --</option>
                        <?php foreach($delivery_men as $dm): ?>
                            <option value="<?= $dm['id'] ?>" <?= $dm['id']==$order['delivery_man_id']?'selected':'' ?>>
                                <?= htmlspecialchars($dm['name']) ?> (<?= htmlspecialchars($dm['phone']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label>Expected Delivery:</label>
                    <input type="date" name="expected_delivery" value="<?= $order['expected_delivery'] ?>">
                    <button type="submit" name="update_order" class="btn">Update</button>
                </form>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
