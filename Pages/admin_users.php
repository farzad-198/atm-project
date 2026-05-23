<?php

session_start();

require_once '../src/db.php';
require_once '../src/functions.php';
require_once '../src/UserRepository.php';

require_login();
require_admin();

$userRepository = new UserRepository($pdo);
$users = $userRepository->getAllUsers();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link rel="stylesheet" href="/atm-project/style.css">
</head>
<body>

<div class="container large">
    <h1>Users</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Card Number</th>
            <th>Role</th>
            <th>Created At</th>
        </tr>

        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= escape($user['id']) ?></td>
                <td><?= escape($user['name']) ?></td>
                <td><?= escape($user['card_number']) ?></td>
                <td><?= escape($user['role']) ?></td>
                <td><?= escape($user['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p class="links">
        <a href="admin.php">Back to admin panel</a>
    </p>
</div>

</body>
</html>