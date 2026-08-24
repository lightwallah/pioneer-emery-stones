<?php

namespace App\Models;

use App\Core\Model;

class Faq extends Model
{
    public function getAll(string $lang): array
    {
        $stmt = $this->db->prepare('
            SELECT f.id, ft.question, ft.answer
            FROM faqs f
            JOIN faq_translations ft ON f.id = ft.faq_id AND ft.lang = ?
            WHERE f.is_active = 1
            ORDER BY f.sort_order
        ');
        $stmt->execute([$lang]);
        return $stmt->fetchAll();
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM faqs')->fetchColumn();
    }

    public function getAllAdmin(): array
    {
        return $this->db->query('
            SELECT f.*, ft.question FROM faqs f
            LEFT JOIN faq_translations ft ON f.id = ft.faq_id AND ft.lang = "en"
            ORDER BY f.sort_order
        ')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM faqs WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTranslations(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM faq_translations WHERE faq_id = ?');
        $stmt->execute([$id]);
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['lang']] = $row;
        }
        return $result;
    }
}
