<?php

namespace App\Models;

use App\Core\Model;

class Inquiry extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO inquiries (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['name'],
            $data['email'] ?? '',
            $data['phone'],
            $data['subject'] ?? '',
            $data['message'] ?? '',
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM inquiries')->fetchColumn();
    }

    public function countUnread(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM inquiries WHERE is_read = 0')->fetchColumn();
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM inquiries ORDER BY created_at DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM inquiries WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $this->db->prepare('UPDATE inquiries SET is_read = 1 WHERE id = ?')->execute([$id]);
        }
        return $row ?: null;
    }

    public function delete(int $id): void
    {
        $this->db->prepare('DELETE FROM inquiries WHERE id = ?')->execute([$id]);
    }
}
