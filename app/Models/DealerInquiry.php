<?php

namespace App\Models;

use App\Core\Model;

class DealerInquiry extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO dealer_inquiries (name, company_name, phone, email, city, state, business_type, annual_requirement, message)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            $data['name'],
            $data['company_name'],
            $data['phone'],
            $data['email'] ?? '',
            $data['city'],
            $data['state'],
            $data['business_type'] ?? '',
            $data['annual_requirement'] ?? '',
            $data['message'] ?? '',
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM dealer_inquiries')->fetchColumn();
    }

    public function countUnread(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM dealer_inquiries WHERE is_read = 0')->fetchColumn();
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM dealer_inquiries ORDER BY created_at DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM dealer_inquiries WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $this->db->prepare('UPDATE dealer_inquiries SET is_read = 1 WHERE id = ?')->execute([$id]);
        }
        return $row ?: null;
    }

    public function delete(int $id): void
    {
        $this->db->prepare('DELETE FROM dealer_inquiries WHERE id = ?')->execute([$id]);
    }
}
