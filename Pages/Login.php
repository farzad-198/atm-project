<?php

session_start();

require_once '../src/db.php';
require_once '../src/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardNumber = $_POST['card_number'] ?? '';
    $pin = $_POST['pin'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE card_number = ?");
    $stmt->execute([$cardNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pin, $user['pin_hash'])) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: dashboard.php');
        }

        exit;
    } else {
        $error = 'Wrong card number or PIN';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ATM Login</title>
    <link rel="stylesheet" href="../src/style.css">
</head>
<body>

<div class="container">
    <h1>ATM Login</h1>

    <?php if ($error): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Card Number</label>
        <input type="text" name="card_number" required>

        <label>PIN</label>
        <input type="password" name="pin" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>