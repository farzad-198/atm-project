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
    $accountId = $_POST['account_id'] ?? '';
    $amount = $_POST['amount'] ?? 0;

    if (!check_csrf_token($csrfToken)) {
        $error = 'Invalid form token';
    } elseif ($amount <= 0) {
        $error = 'Amount must be more than zero';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ? AND user_id = ?");
        $stmt->execute([$accountId, $_SESSION['user_id']]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$account) {
            $error = 'Account not found';
        } else {
            $stmt = $pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$amount, $accountId]);

            $stmt = $pdo->prepare("
                INSERT INTO transactions (type, amount, from_account_id, to_account_id)
                VALUES ('deposit', ?, NULL, ?)
            ");
            $stmt->execute([$amount, $accountId]);

            $message = 'Money deposited successfully';
        }
    }
}

$csrfToken = generate_csrf_token();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Deposit</title>
    <link rel="stylesheet" href="../src/style.css">
</head>
<body>

<div class="container">
    <h1>Deposit Money</h1>

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

        <button type="submit">Deposit</button>
    </form>

    <p>
        <a href="dashboard.php">Back to dashboard</a>
    </p>
</div>

</body>
</html>