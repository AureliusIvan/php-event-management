<?php

namespace App\Models;

use PDO;

class Transaction
{
    public static function create($conn, $data)
    {
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, event_id, amount, status, created_at) VALUES (:user_id, :event_id, :amount, :status, :created_at)");
        return $stmt->execute($data);
    }

    public static function getByEventId($conn, $event_id)
    {
        $stmt = $conn->prepare("SELECT * FROM transactions WHERE event_id = :event_id");
        $stmt->execute(['event_id' => $event_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByUserId($conn, $user_id)
    {
        $stmt = $conn->prepare("SELECT * FROM transactions WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($conn, $id, $data)
    {
        $stmt = $conn->prepare("UPDATE transactions SET status=:status WHERE id=:id");
        return $stmt->execute(array_merge($data, ['id' => $id]));
    }

    public static function delete($conn, $id)
    {
        $stmt = $conn->prepare("DELETE FROM transactions WHERE id=:id");
        return $stmt->execute(['id' => $id]);
    }

    public static function getByUserIdAndEventId($conn, $user_id, $event_id)
    {
        $stmt = $conn->prepare("SELECT * FROM transactions WHERE user_id = :user_id AND event_id = :event_id");
        $stmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getTotalTransactions($conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM transactions");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}