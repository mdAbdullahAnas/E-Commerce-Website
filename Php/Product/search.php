<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include($_SERVER['DOCUMENT_ROOT'] . "/SSM/Connection/db.php");

// Get the search query
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

$products = [];
if ($searchQuery !== '') {
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("
        SELECT p.*, v.fullname AS vendor_name
        FROM products p
        JOIN vendors v ON p.vendor_id = v.id
        WHERE p.status = 'accepted' AND p.name LIKE ?
        ORDER BY p.name ASC
    ");
    $likeQuery = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
}

// Include navbar
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'customer') {
        include($_SERVER['DOCUMENT_ROOT'] . "/SSM/Php/DomainCustomer/navbar.php");
    } elseif ($_SESSION['role'] === 'vendor') {
        include($_SERVER['DOCUMENT_ROOT'] . "/SSM/Php/DomainVendor/navbar.php");
    } elseif ($_SESSION['role'] === 'admin') {
        include($_SERVER['DOCUMENT_ROOT'] . "/SSM/Php/DomainAdmin/navbar.php");
    }
}
?>

<link rel="stylesheet" href="/SSM/Asset/Css/menu.css">

<div class="main-content">
    <h1>Search Results for "<?= htmlspecialchars($searchQuery) ?>"</h1>

    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $p):
                $imgUrl = htmlspecialchars($p['img'] ?? '/SSM/Asset/Img/placeholder.png');
            ?>
            <div class="product-card">
                <a href="productDetails.php?id=<?= (int)$p['id'] ?>">
                    <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:150px;height:150px;object-fit:cover;">
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                </a>
                <p class="price">$<?= number_format((float)$p['price'], 2) ?></p>
                <p>Available: <?= (int)$p['quantity'] ?></p>
                <p>Vendor: <?= htmlspecialchars($p['vendor_name']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
// Include footer
include($_SERVER['DOCUMENT_ROOT'] . "/SSM/Php/Includes/footer.php");
?>
