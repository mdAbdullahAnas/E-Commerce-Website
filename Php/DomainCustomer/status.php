<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/SSM/Connection/db.php");

// ✅ Only customers
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../Auth/login.php");
    exit;
}

// ✅ Get correct customer_id
$stmt = $conn->prepare("SELECT id FROM users WHERE id=? OR username=? LIMIT 1");
$checkId = is_numeric($_SESSION['userid']) ? intval($_SESSION['userid']) : 0;
$checkUser = $_SESSION['userid'];
$stmt->bind_param("is", $checkId, $checkUser);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $customer_id = $row['id'];
} else {
    die("Customer not found!");
}

// ✅ Fetch all orders of this customer
$stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

include("navbar.php");
?>
<link rel="stylesheet" href="/SSM/Asset/Css/Domain/Customer/cartPayment.css">
<link rel="stylesheet" href="/SSM/Asset/Css/Domain/Customer/style.css">

<div class="main-content">
    <h2>My Orders</h2>

    <!-- Debug (remove later) -->
    <?php if(false): ?>
<p style="color:red;">
    Debug → Session UserID: <?= htmlspecialchars($_SESSION['userid']) ?> | Using CustomerID: <?= $customer_id ?>
</p>
<?php endif; ?>


    <?php if(empty($orders)): ?>
        <p>You have not purchased anything yet.</p>
    <?php else: ?>
        <?php foreach($orders as $order): ?>
            <div class="order-card">
                <h3>
                    Order #<?= $order['id'] ?> |
                    <span style="color:green;">Status: <?= htmlspecialchars($order['status']) ?></span>
                </h3>

                <p><b>Total:</b> $<?= number_format($order['total'],2) ?> |
                   <b>Discount:</b> $<?= number_format($order['discount'],2) ?></p>

                <p><b>Address:</b> <?= htmlspecialchars($order['address']) ?></p>
                <p><b>Contact:</b> <?= htmlspecialchars($order['contact_number']) ?></p>
                <p><b>Payment:</b> <?= htmlspecialchars($order['payment_method']) ?></p>
                <p><b>Created:</b> <?= $order['created_at'] ?></p>

                <?php if(!empty($order['expected_delivery'])): ?>
                    <p><b>Expected Delivery:</b> <?= $order['expected_delivery'] ?></p>
                <?php endif; ?>

                <?php if(!empty($order['delivered_at'])): ?>
                    <p><b>Delivered At:</b> <?= $order['delivered_at'] ?></p>
                <?php endif; ?>

                <!-- ✅ Delivery Man Info -->
                <?php if(!empty($order['delivery_man_id'])): ?>
                    <?php
                    $stmtDel = $conn->prepare("SELECT name, phone FROM delivery_men WHERE id=? LIMIT 1");
                    $stmtDel->bind_param("i", $order['delivery_man_id']);
                    $stmtDel->execute();
                    $resDel = $stmtDel->get_result();
                    if($del = $resDel->fetch_assoc()):
                    ?>
                        <p><b>Delivery Man:</b> <?= htmlspecialchars($del['name']) ?> (<?= htmlspecialchars($del['phone']) ?>)</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p><b>Delivery Man:</b> Not Assigned</p>
                <?php endif; ?>

                <h4>Items:</h4>
                <ul>
                    <?php
                    $stmtItem = $conn->prepare("
                        SELECT oi.*, p.name 
                        FROM order_items oi 
                        JOIN products p ON oi.product_id=p.id 
                        WHERE order_id=?
                    ");
                    $stmtItem->bind_param("i", $order['id']);
                    $stmtItem->execute();
                    $resItem = $stmtItem->get_result();
                    while($item = $resItem->fetch_assoc()):
                    ?>
                        <li><?= htmlspecialchars($item['name']) ?> - <?= $item['quantity'] ?> × $<?= number_format($item['price'],2) ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
