<?php

class AccountRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAccountsByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUserAccountById($accountId, $userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE id = ? AND user_id = ?");
        $stmt->execute([$accountId, $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deposit($accountId, $amount) {
        $stmt = $this->pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$amount, $accountId]);
    }

    public function withdraw($accountId, $amount) {
        $stmt = $this->pdo->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?");
        $stmt->execute([$amount, $accountId]);
    }

    public function getAllAccountsWithOwner() {
        $stmt = $this->pdo->query("
            SELECT accounts.id, users.name, accounts.account_type, accounts.balance
            FROM accounts
            JOIN users ON accounts.user_id = users.id
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}