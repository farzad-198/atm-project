<?php

require_once 'src/db.php';

$pdo->exec("DELETE FROM transactions");
$pdo->exec("DELETE FROM accounts");
$pdo->exec("DELETE FROM users");

$adminPin = password_hash('1111', PASSWORD_DEFAULT);
$userPin = password_hash('1234', PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (name, card_number, pin_hash, role)
    VALUES (?, ?, ?, ?)
");

$stmt->execute(['Admin User', '405198286421', $adminPin, 'admin']);
$stmt->execute(['John Doe', '428613759204', $userPin, 'user']);
$userOneId = $pdo->lastInsertId();

$stmt->execute(['Emma Johnson', '436158613451', $userPin, 'user']);
$userTwoId = $pdo->lastInsertId();

$stmt = $pdo->prepare("
    INSERT INTO accounts (user_id, account_type, balance)
    VALUES (?, ?, ?)
");

$stmt->execute([$userOneId, 'Swedbank', 3000]);
$stmt->execute([$userOneId, 'Resurs bank', 7000]);

$stmt->execute([$userTwoId, 'Swedbank', 5000]);
$stmt->execute([$userTwoId, 'Resurs bank', 10000]);

echo "Seed data created successfully.";