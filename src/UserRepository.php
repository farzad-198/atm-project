<?php

class UserRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByCardNumber($cardNumber) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE card_number = ?");
        $stmt->execute([$cardNumber]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT id, name, card_number, role, created_at FROM users");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}