<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Auth/login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Admin</title>
</head>
<body style="
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#198754; /* green shade for admin */
    font-family:sans-serif;
    color:white;
    font-size:28px;
    text-align:center;
">
    <div>
        👋 Welcome 😄 <br><br>
        Mr. Admin <?php echo htmlspecialchars($_SESSION['userid']); ?>! 
    </div>

    <script>
        // Auto redirect to admin dashboard
        setTimeout(function(){
            window.location.href = "/SSM/Php/Product/menu.php";
        }, 2000);
    </script>
</body>
</html>
