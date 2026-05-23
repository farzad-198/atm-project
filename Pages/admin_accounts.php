<?php

session_start();

require_once '../src/db.php';
require_once '../src/functions.php';
require_once '../src/AccountRepository.php';

require_login();
require_admin();

$accountRepository = new AccountRepository($pdo);
$accounts = $accountRepository->getAllAccountsWithOwner();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Accounts</title>
    <link rel="stylesheet" href="/atm-project/style.css">
</head>
<body>

<div class="container large">
    <h1>Accounts</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Owner</th>
            <th>Account</th>
            <th>Balance</th>
        </tr>

        <?php foreach ($accounts as $account): ?>
            <tr>
                <td><?= escape($account['id']) ?></td>
                <td><?= escape($account['name']) ?></td>
                <td><?= escape($account['account_type']) ?></td>
                <td><?= escape($account['balance']) ?> kr</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p class="links">
        <a href="admin.php">Back to admin panel</a>
    </p>
</div>

</body>
</html>