<?php

session_start();

require_once '../src/db.php';
require_once '../src/functions.php';
require_once '../src/TransactionRepository.php';

require_login();
require_admin();

$transactionRepository = new TransactionRepository($pdo);
$transactions = $transactionRepository->getAllTransactions();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transactions</title>
    <link rel="stylesheet" href="/atm-project/style.css">
</head>
<body>

<div class="container large">
    <h1>Transactions</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Amount</th>
            <th>From Account</th>
            <th>To Account</th>
            <th>Created At</th>
        </tr>

        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= escape($transaction['id']) ?></td>
                <td><?= escape($transaction['type']) ?></td>
                <td><?= escape($transaction['amount']) ?> kr</td>
                <td><?= escape($transaction['from_account_id'] ?? '-') ?></td>
                <td><?= escape($transaction['to_account_id'] ?? '-') ?></td>
                <td><?= escape($transaction['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p class="links">
        <a href="admin.php">Back to admin panel</a>
    </p>
</div>

</body>
</html>