<?php

session_start();

require_once '../src/functions.php';

require_login();
require_admin();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/atm-project/style.css">
</head>
<body>

<div class="container">
    <h1>Admin Panel</h1>

    <p class="links">
        Welcome, <?= escape($_SESSION['name']) ?>
    </p>

    <p class="links">
        <a href="admin_users.php">Users</a> |
        <a href="admin_accounts.php">Accounts</a> |
        <a href="admin_transactions.php">Transactions</a> |
        <a href="logout.php">Logout</a>
    </p>
</div>

</body>
</html>