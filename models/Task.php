<?php
require_once __DIR__ . '/../config.php';

class Task {
    public static function add($userId, $title, $description, $categoryId, $priority, $dueDate): bool {
        $pdo = getPDO();
        $sql = "INSERT INTO tasks (user_id, title, description, category_id, priority, due_date)
                VALUES (:user_id, :title, :description, :category_id, :priority, :due_date)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description ?: null,
            'category_id' => $categoryId ?: null,
            'priority' => $priority,
            'due_date' => $dueDate ?: null
        ]);
    }

    public static function getAll($userId, $sort = null): array {
        $pdo = getPDO();

        $validSorts = ['priority', 'due_date', 'status'];
        $order = in_array($sort, $validSorts) ? "ORDER BY $sort ASC" : "ORDER BY created_at DESC";

        $sql = "SELECT tasks.*, categories.name AS category_name
            FROM tasks
            LEFT JOIN categories ON tasks.category_id = categories.id
            WHERE tasks.user_id = :uid
            $order";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }


    public static function getById($userId, $taskId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :uid");
        $stmt->execute(['id' => $taskId, 'uid' => $userId]);
        return $stmt->fetch();
    }

    public static function update($userId, $taskId, $title, $description, $categoryId, $priority, $dueDate, $status): bool {
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :desc, category_id = :cat, priority = :priority, due_date = :due, status = :status WHERE id = :id AND user_id = :uid");
        return $stmt->execute([
            'title' => $title,
            'desc' => $description ?: null,
            'cat' => $categoryId ?: null,
            'priority' => $priority,
            'due' => $dueDate ?: null,
            'status' => $status,
            'id' => $taskId,
            'uid' => $userId
        ]);
    }

    public static function setStatus($userId, $taskId, $status): bool {
        $pdo = getPDO();
        $completedAt = ($status === 'done') ? date('Y-m-d H:i:s') : null;

        $stmt = $pdo->prepare("UPDATE tasks SET status = :status, completed_at = :completed WHERE id = :id AND user_id = :uid");
        return $stmt->execute([
            'status' => $status,
            'completed' => $completedAt,
            'id' => $taskId,
            'uid' => $userId
        ]);
    }

    public static function search($userId, $term, $categoryId, $priority, $status) {
        $pdo = getPDO();

        $sql = "SELECT tasks.*, categories.name AS category_name
            FROM tasks
            LEFT JOIN categories ON tasks.category_id = categories.id
            WHERE tasks.user_id = :uid
              AND (tasks.title LIKE :term OR tasks.description LIKE :term)";

        $params = [
            'uid' => $userId,
            'term' => "%$term%"
        ];

        if ($categoryId) {
            $sql .= " AND tasks.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if ($priority) {
            $sql .= " AND tasks.priority = :priority";
            $params['priority'] = $priority;
        }

        if ($status) {
            $sql .= " AND tasks.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY tasks.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function countByStatus($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT status, COUNT(*) AS count FROM tasks WHERE user_id = :uid GROUP BY status");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public static function countOverdue($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = :uid AND status != 'done' AND due_date IS NOT NULL AND due_date < NOW()");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchColumn();
    }

    public static function categorySummary($userId) {
        $pdo = getPDO();
        $sql = "SELECT c.name, 
                   COUNT(t.id) AS total, 
                   SUM(CASE WHEN t.status = 'done' THEN 1 ELSE 0 END) AS done
            FROM categories c
            LEFT JOIN tasks t ON c.id = t.category_id
            WHERE c.user_id = :uid
            GROUP BY c.name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public static function delete($userId, $taskId): bool {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :uid");
        return $stmt->execute(['id' => $taskId, 'uid' => $userId]);
    }

}