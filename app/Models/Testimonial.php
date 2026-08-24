<?php

namespace App\Models;

use App\Core\Model;

class Testimonial extends Model
{
    public function getAll(string $lang, int $limit = 0): array
    {
        $sql = '
            SELECT t.*, tt.review
            FROM testimonials t
            JOIN testimonial_translations tt ON t.id = tt.testimonial_id AND tt.lang = ?
            WHERE t.is_active = 1
            ORDER BY t.sort_order
        ';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lang]);
        return $stmt->fetchAll();
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM testimonials')->fetchColumn();
    }

    public function getAllAdmin(): array
    {
        return $this->db->query('
            SELECT t.*, tt.review FROM testimonials t
            LEFT JOIN testimonial_translations tt ON t.id = tt.testimonial_id AND tt.lang = "en"
            ORDER BY t.sort_order
        ')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM testimonials WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTranslations(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM testimonial_translations WHERE testimonial_id = ?');
        $stmt->execute([$id]);
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['lang']] = $row;
        }
        return $result;
    }
}
