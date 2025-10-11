<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include($_SERVER['DOCUMENT_ROOT'] . "/SSM/Connection/db.php");


// Debug mode: append ?debug=1 to the page URL to get per-image debug HTML comments
$DEBUG = isset($_GET['debug']) && $_GET['debug'] == '1';

/**
 * Resolve an image to a correct web path.
 * Tries:
 *  - If input is empty -> placeholder
 *  - full http(s) URL or data: URI -> return as-is
 *  - absolute web path (starts with /) -> check filesystem and return if exists
 *  - several candidate folders (like /SSM/uploads/, /uploads/, /SSM/Asset/Img/, etc.)
 *  - returns placeholder if nothing found
 */
function getImageUrl($img) {
    $img = trim((string)$img);
    $placeholder = '/SSM/Asset/Img/placeholder.png';

    if ($img === '') return $placeholder;

    // full URL or data URI
    if (preg_match('#^(https?://|data:)#i', $img)) {
        return $img;
    }

    // If it's already an absolute web path (starts with '/'), check existence
    if (strpos($img, '/') === 0) {
        $fs = $_SERVER['DOCUMENT_ROOT'] . $img;
        if (file_exists($fs)) {
            // URL-encode path parts (to handle spaces)
            $encoded = '/' . implode('/', array_map('rawurlencode', explode('/', ltrim($img, '/'))));
            return $encoded;
        } else {
            // try encoded variant
            $encoded = '/' . implode('/', array_map('rawurlencode', explode('/', ltrim($img, '/'))));
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $encoded)) return $encoded;
            return $placeholder;
        }
    }

    // Not starting with slash -> try likely locations
    $candidates = [
        '/SSM/Asset/Images' . $img,
        '/uploads/' . $img,
        '/SSM/Asset/Img/' . $img,
        '/SSM/' . $img,
        '/' . $img
    ];

    foreach ($candidates as $candidate) {
        $fs = $_SERVER['DOCUMENT_ROOT'] . $candidate;
        if (file_exists($fs)) {
            // return URL-encoded web path
            $encoded = '/' . implode('/', array_map('rawurlencode', explode('/', ltrim($candidate, '/'))));
            return $encoded;
        }
    }

    // nothing found -> placeholder
    return $placeholder;
}

// Fetch products (accepted)
$result = $conn->query("SELECT p.*, v.fullname AS vendor_name 
                        FROM products p 
                        JOIN vendors v ON p.vendor_id=v.id 
                        WHERE p.status='accepted'
                        ORDER BY p.name ASC");

$products = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Include navbar based on role (keep your existing structure)
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'customer') {
        include("../DomainCustomer/navbar.php");
    } elseif ($_SESSION['role'] === 'vendor') {
        include("../DomainVendor/navbar.php");
    } elseif ($_SESSION['role'] === 'admin') {
        include("../DomainAdmin/navbar.php");
    }
} 

 
?>

 

 
 
<link rel="stylesheet" href="/SSM/Asset/Css/menu.css">

<div class="main-content">
    <h1>Our Products</h1>
    <div class="product-grid">
        <?php foreach ($products as $p): 
            // Resolve image URL for this product (this function will try multiple paths)
            $imgUrl = getImageUrl($p['img'] ?? '');
        ?>
            <div class="product-card">
                <!-- debug info (visible in page source when ?debug=1) -->
                <?php if ($DEBUG): ?>
                    <!-- DEBUG: original="<?= htmlspecialchars($p['img'] ?? '') ?>" resolved="<?= htmlspecialchars($imgUrl) ?>" -->
                <?php endif; ?>

                <a href="productDetails.php?id=<?= urlencode($p['id']) ?>">
                    <img 
                        src="<?= htmlspecialchars($imgUrl) ?>" 
                        alt="<?= htmlspecialchars($p['name'] ?? 'Product') ?>"
                        style="width:150px;height:150px;object-fit:cover;"
                        onerror="this.onerror=null;this.src='/SSM/Asset/Img/placeholder.png';"
                    >
                    <h3><?= htmlspecialchars($p['name'] ?? 'Unnamed') ?></h3>
                </a>

                <p class="price">$<?= number_format((float)($p['price'] ?? 0), 2) ?></p>
                <p>Available: <?= (int)($p['quantity'] ?? 0) ?></p>
                <p>Vendor: <?= htmlspecialchars($p['vendor_name'] ?? 'Unknown') ?></p>

                <?php if (!isset($_SESSION['role'])): ?>
                    <a href="/SSM/Php/Auth/login.php" class="btn">Login to Buy</a>
                     

                <?php elseif ($_SESSION['role'] === 'customer'): ?>
                    <form action="/SSM/Php/DomainCustomer/addToCart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
                        <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                    </form>

                    <form action="/SSM/Php/DomainCustomer/makePayment.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
                        <button type="submit" name="buy_now" class="btn">Buy Now</button>
                    </form>

                <?php else: ?>
                    <form action="/SSM/Php/Domain/editProduct.php" method="GET" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <button type="submit" class="btn">Edit</button>
                    </form>

                    <form action="/SSM/Php/Domain/deleteProduct.php" method="POST" style="display:inline-block;"
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/SSM/Php/Includes/footer.php"); ?>
