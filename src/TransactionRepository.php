<?php

class TransactionRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createDeposit($amount, $toAccountId) {
        $stmt = $this->pdo->prepare("
            INSERT INTO transactions (type, amount, from_account_id, to_account_id)
            VALUES ('deposit', ?, NULL, ?)
        ");

        $stmt->execute([$amount, $toAccountId]);
    }

    public function createWithdraw($amount, $fromAccountId) {
        $stmt = $this->pdo->prepare("
            INSERT INTO transactions (type, amount, from_account_id, to_account_id)
            VALUES ('withdraw', ?, ?, NULL)
        ");

        $stmt->execute([$amount, $fromAccountId]);
    }

    public function createTransfer($amount, $fromAccountId, $toAccountId) {
        $stmt = $this->pdo->prepare("
            INSERT INTO transactions (type, amount, from_account_id, to_account_id)
            VALUES ('transfer', ?, ?, ?)
        ");

        $stmt->execute([$amount, $fromAccountId, $toAccountId]);
    }

    public function getAllTransactions() {
        $stmt = $this->pdo->query("
            SELECT *
            FROM transactions
            ORDER BY created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}