<?php
session_start();
include("../../Connection/db.php");

// ✅ Only Admin Access
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Auth/login.php");
    exit();
}

$filter = isset($_POST['filter']) ? $_POST['filter'] : 'daily';

// --- Build SQL condition based on filter ---
if ($filter == 'daily') {
    $dateCondition = "DATE(created_at) = CURDATE()";
    $reportTitle = "Today's Delivered Orders";
} elseif ($filter == 'weekly') {
    $dateCondition = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
    $reportTitle = "This Week's Delivered Orders";
} else { // monthly
    $dateCondition = "YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())";
    $reportTitle = "This Month's Delivered Orders";
}

// ✅ Fetch delivered orders based on filter
$sql = "SELECT * FROM orders WHERE status='Delivered' AND $dateCondition ORDER BY created_at DESC";
$result = $conn->query($sql);

$orders = [];
$totalSales = 0;

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
        $totalSales += $row['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Report</title>
<link rel="stylesheet" href="../../Asset/Css/Domain/manage.css">
<style>
.report-card {
    border: 2px solid #333;
    padding: 15px;
    margin-bottom: 20px;
    background: #f4f4f4;
}
.report-card h3 { margin: 0; }
</style>
</head>
<body>
<?php include("navbar.php"); ?>

<main class="admin-main">
    <h2>Sales Report</h2>

    <!-- Filter Form -->
    <form method="POST">
        <label for="filter">Select Report Type:</label>
        <select name="filter" id="filter">
            <option value="daily" <?= $filter=='daily'?'selected':'' ?>>Daily</option>
            <option value="weekly" <?= $filter=='weekly'?'selected':'' ?>>Weekly</option>
            <option value="monthly" <?= $filter=='monthly'?'selected':'' ?>>Monthly</option>
        </select>
        <button type="submit" name="generate">Generate Report</button>
    </form>

    <!-- Report Summary Card -->
    <div class="report-card">
        <h3><?= $reportTitle ?></h3>
        <p><strong>Total Sales:</strong> $<?= number_format($totalSales, 2) ?></p>
        <p><strong>Total Orders:</strong> <?= count($orders) ?></p>
    </div>

    <!-- Detailed Orders Table -->
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Coupon</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Payment Method</th>
                <th>Wallet/Bank</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if($orders): foreach($orders as $o): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= $o['customer_id'] ?></td>
                <td>$<?= number_format($o['total'],2) ?></td>
                <td>$<?= number_format($o['discount'],2) ?></td>
                <td><?= $o['coupon_code'] ?? 'N/A' ?></td>
                <td><?= $o['address'] ?></td>
                <td><?= $o['contact_number'] ?></td>
                <td><?= $o['payment_method'] ?></td>
                <td>
                    <?php 
                    if($o['payment_method'] == 'Mobile Wallet') echo $o['wallet_type'].' ('.$o['wallet_phone'].')';
                    else echo $o['card_number'] ?? 'N/A';
                    ?>
                </td>
                <td><?= $o['status'] ?></td>
                <td><?= $o['created_at'] ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="11">No delivered orders found for this period.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
