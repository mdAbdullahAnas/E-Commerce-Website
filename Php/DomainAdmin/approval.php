<?php
session_start();

// Check session & role
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Auth/login.php");
    exit();
}

include("../../Connection/db.php");
include("navbar.php");

$success = $error = "";

// --- Handle Approval / Rejection ---
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if(in_array($action, ['accepted','rejected'])){
        $stmt = $conn->prepare("UPDATE products SET status=? WHERE id=?");
        $stmt->bind_param("si",$action,$id);
        if($stmt->execute()){
            $success = "Product status updated to ".ucfirst($action)."!";
        } else {
            $error = "Failed to update status: " . $stmt->error;
        }
    }
}

// --- Fetch All Vendor Products ---
$products = [];
$sql = "SELECT p.*, v.fullname AS vendor_name 
        FROM products p
        JOIN vendors v ON p.vendor_id = v.id
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Approval</title>
<link rel="stylesheet" href="../../Asset/Css/Domain/manage.css">
</head>
<body>
<main class="admin-main">
<h2>Product Approval Panel</h2>

<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

<table border="1" cellpadding="5">
<thead>
<tr>
<th>ID</th><th>Image</th><th>Name</th><th>Price</th><th>Qty</th><th>Description</th><th>Status</th><th>Vendor</th><th>Actions</th>
</tr>
</thead>
<tbody>
<?php if($products): foreach($products as $p): ?>
<tr>
<td><?= $p['id'] ?></td>
<td><img src="<?= $p['img'] ?>" width="80" alt="<?= $p['name'] ?>"></td>
<td><?= $p['name'] ?></td>
<td>$<?= $p['price'] ?></td>
<td><?= $p['quantity'] ?></td>
<td><?= $p['description'] ?></td>
<td>
<?php 
if($p['status']=="pending") echo "<span style='color:orange;'>Pending</span>";
elseif($p['status']=="accepted") echo "<span style='color:green;'>Accepted</span>";
else echo "<span style='color:red;'>Rejected</span>";
?>
</td>
<td><?= $p['vendor_name'] ?></td>
<td>
<?php if($p['status']=="pending"): ?>
<a href="?action=accepted&id=<?= $p['id'] ?>" class="btn btn-success">Accept</a>
<a href="?action=rejected&id=<?= $p['id'] ?>" class="btn btn-danger">Reject</a>
<?php else: ?>
No action
<?php endif; ?>
</td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="9">No products found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</main>
</body>
</html>
