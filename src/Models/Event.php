<?php

namespace App\Models;

use PDO;

class Event
{
    public static function getAll($conn)
    {
        $stmt = $conn->prepare("SELECT * FROM events");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM events WHERE id=:id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($conn, $data)
    {
        $stmt = $conn->prepare("INSERT INTO events (name, date, location, description) VALUES (:name, :date, :location, :description)");
        return $stmt->execute($data);
    }

    public static function update($conn, $id, $data)
    {
        $stmt = $conn->prepare("UPDATE events SET name=:name, date=:date, location=:location, description=:description WHERE id=:id");
        return $stmt->execute(array_merge($data, ['id' => $id]));
    }

    public static function delete($conn, $id)
    {
        $stmt = $conn->prepare("DELETE FROM events WHERE id=:id");
        return $stmt->execute(['id' => $id]);
    }

    public static function getTotalEvents($conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM events");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
