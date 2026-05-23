<?php

session_start();

require_once '../src/db.php';
require_once '../src/functions.php';
require_once '../src/AccountRepository.php';

require_login();

$accountRepository = new AccountRepository($pdo);
$accounts = $accountRepository->getAccountsByUserId($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/atm-project/style.css">
</head>
<body>

<div class="container">
    <h1>Welcome, <?= escape($_SESSION['name']) ?></h1>

    <h2>Your Accounts</h2>

    <table>
        <tr>
            <th>Account Type</th>
            <th>Balance</th>
        </tr>

        <?php foreach ($accounts as $account): ?>
            <tr>
                <td><?= escape($account['account_type']) ?></td>
                <td><?= escape($account['balance']) ?> kr</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p class="links">
        <a href="deposit.php">Deposit</a> |
        <a href="withdraw.php">Withdraw</a> |
        <a href="transfer.php">Transfer</a> |
        <a href="logout.php">Logout</a>
    </p>
</div>

</body>
</html>