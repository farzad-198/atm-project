<?php

session_start();

require_once '../src/db.php';
require_once '../src/functions.php';
require_once '../src/AccountRepository.php';
require_once '../src/TransactionRepository.php';

require_login();

$message = '';
$error = '';

$accountRepository = new AccountRepository($pdo);
$transactionRepository = new TransactionRepository($pdo);

$accounts = $accountRepository->getAccountsByUserId($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $accountId = $_POST['account_id'] ?? '';
    $amount = $_POST['amount'] ?? 0;

    if (!check_csrf_token($csrfToken)) {
        $error = 'Invalid form token';
    } elseif ($amount <= 0) {
        $error = 'Amount must be more than zero';
    } else {
      $account = $accountRepository->findUserAccountById($accountId, $_SESSION['user_id']);

        if (!$account) {
            $error = 'Account not found';
        } elseif ($account['balance'] < $amount) {
            $error = 'Not enough balance';
        } else {
          $accountRepository->withdraw($accountId, $amount);
          $transactionRepository->createWithdraw($amount, $accountId);

            $message = 'Money withdrawn successfully';
            $accounts = $accountRepository->getAccountsByUserId($_SESSION['user_id']);
        }
    }
}

$csrfToken = generate_csrf_token();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Withdraw</title>
    <link rel="stylesheet" href="/atm-project/style.css">
</head>
<body>

<div class="container">
    <h1>Withdraw Money</h1>

    <?php if ($message): ?>
        <p class="success"><?= escape($message) ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= escape($csrfToken) ?>">

        <label>Account</label>
        <select name="account_id" required>
            <?php foreach ($accounts as $account): ?>
                <option value="<?= escape($account['id']) ?>">
                    <?= escape($account['account_type']) ?> - <?= escape($account['balance']) ?> kr
                </option>
            <?php endforeach; ?>
        </select>

        <label>Amount</label>
        <input type="number" name="amount" step="0.01" required>

        <button type="submit">Withdraw</button>
    </form>

    <p>
        <a href="dashboard.php">Back to dashboard</a>
    </p>
</div>

</body>
</html>