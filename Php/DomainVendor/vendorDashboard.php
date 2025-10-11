<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'vendor') {
    header("Location: ../Auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Vendor</title>
</head>
<body style="
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#fd7e14; /* orange shade for vendor */
    font-family:sans-serif;
    color:white;
    font-size:28px;
    text-align:center;
">
    <div>
        👋 Welcome 😄 <br><br>
        Mr.Vendror 
        <?php echo htmlspecialchars($_SESSION['userid']); ?>! 
    </div>

    <script>
        // Auto redirect to vendor dashboard
        setTimeout(function(){
            window.location.href = "/SSM/Php/Product/menu.php";
        }, 2000);
    </script>
</body>
</html>
