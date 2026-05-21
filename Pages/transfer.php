<?php

session_start();

require_once '../src/db.php';
require_once '../src/functions.php';

require_login();

$message = '';
$error = '';

$stmt = $pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $fromAccountId = $_POST['from_account_id'] ?? '';
    $toAccountId = $_POST['to_account_id'] ?? '';
    $amount = $_POST['amount'] ?? 0;

    if (!check_csrf_token($csrfToken)) {
        $error = 'Invalid form token';
    } elseif ($amount <= 0) {
        $error = 'Amount must be more than zero';
    } elseif ($fromAccountId == $toAccountId) {
        $error = 'You cannot transfer to the same account';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ? AND user_id = ?");
        $stmt->execute([$fromAccountId, $_SESSION['user_id']]);
        $fromAccount = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ? AND user_id = ?");
        $stmt->execute([$toAccountId, $_SESSION['user_id']]);
        $toAccount = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fromAccount || !$toAccount) {
            $error = 'Account not found';
        } elseif ($fromAccount['balance'] < $amount) {
            $error = 'Not enough balance';
        } else {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?");
            $stmt->execute([$amount, $fromAccountId]);

            $stmt = $pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$amount, $toAccountId]);

            $stmt = $pdo->prepare("
                INSERT INTO transactions (type, amount, from_account_id, to_account_id)
                VALUES ('transfer', ?, ?, ?)
            ");
            $stmt->execute([$amount, $fromAccountId, $toAccountId]);

            $pdo->commit();

            $message = 'Money transferred successfully';
        }
    }
}

$csrfToken = generate_csrf_token();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transfer</title>
    <link rel="stylesheet" href="/atm-project/style.css">
</head>
<body>

<div class="container">
    <h1>Transfer Money</h1>

    <?php if ($message): ?>
        <p class="success"><?= escape($message) ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= escape($csrfToken) ?>">

        <label>From Account</label>
        <select name="from_account_id" required>
            <?php foreach ($accounts as $account): ?>
                <option value="<?= escape($account['id']) ?>">
                    <?= escape($account['account_type']) ?> - <?= escape($account['balance']) ?> kr
                </option>
            <?php endforeach; ?>
        </select>

        <label>To Account</label>
        <select name="to_account_id" required>
            <?php foreach ($accounts as $account): ?>
                <option value="<?= escape($account['id']) ?>">
                    <?= escape($account['account_type']) ?> - <?= escape($account['balance']) ?> kr
                </option>
            <?php endforeach; ?>
        </select>

        <label>Amount</label>
        <input type="number" name="amount" step="0.01" required>

        <button type="submit">Transfer</button>

    </form>

    <p class="links">
        <a href="dashboard.php">Back to dashboard</a>
    </p>
</div>

</body>
</html>