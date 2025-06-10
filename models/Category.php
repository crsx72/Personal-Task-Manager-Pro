<?php
require_once __DIR__ . '/../config.php';

class Category {
    public static function add($userId, $name): bool {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT id FROM categories WHERE user_id = :uid AND name = :name");
        $stmt->execute(['uid' => $userId, 'name' => $name]);
        if ($stmt->fetch()) return false;

        $stmt = $pdo->prepare("INSERT INTO categories (user_id, name) VALUES (:uid, :name)");
        return $stmt->execute(['uid' => $userId, 'name' => $name]);
    }

    public static function getAll($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = :uid");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }
}