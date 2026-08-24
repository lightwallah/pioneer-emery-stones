<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    public function getAll(string $lang): array
    {
        $stmt = $this->db->prepare('
            SELECT c.*, ct.name, ct.description, ct.meta_title, ct.meta_description
            FROM categories c
            JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
            WHERE c.is_active = 1
            ORDER BY c.sort_order
        ');
        $stmt->execute([$lang]);
        return $stmt->fetchAll();
    }

    public function getStoneTypesForHome(string $lang): array
    {
        $slugs = [
            'horizontal-bolt-type',
            'horizontal-janta-type',
            'vertical-danish-type',
            'vertical-bush-type',
            'vertical-rajkot-type',
        ];
        $placeholders = implode(',', array_fill(0, count($slugs), '?'));
        $stmt = $this->db->prepare("
            SELECT c.*, ct.name, ct.description,
                   (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.is_active = 1) AS product_count
            FROM categories c
            JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
            WHERE c.is_active = 1 AND c.slug IN ({$placeholders})
            ORDER BY c.sort_order
        ");
        $stmt->execute(array_merge([$lang], $slugs));
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug, string $lang): ?array
    {
        $stmt = $this->db->prepare('
            SELECT c.*, ct.name, ct.description, ct.meta_title, ct.meta_description
            FROM categories c
            JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
            WHERE c.slug = ? AND c.is_active = 1
        ');
        $stmt->execute([$lang, $slug]);
        return $stmt->fetch() ?: null;
    }

    public function getAllAdmin(): array
    {
        return $this->db->query('
            SELECT c.*, ct.name,
                   (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) AS product_count
            FROM categories c
            LEFT JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = "en"
            ORDER BY c.sort_order
        ')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTranslations(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM category_translations WHERE category_id = ?');
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['lang']] = $row;
        }
        return $result;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO categories (slug, image, sort_order, is_active)
            VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([
            $data['slug'],
            $data['image'] ?? null,
            (int) ($data['sort_order'] ?? 0),
            (int) ($data['is_active'] ?? 1),
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('
            UPDATE categories SET slug=?, image=?, sort_order=?, is_active=?
            WHERE id=?
        ');
        $stmt->execute([
            $data['slug'],
            $data['image'] ?? null,
            (int) ($data['sort_order'] ?? 0),
            (int) ($data['is_active'] ?? 1),
            $id,
        ]);
    }

    public function saveTranslation(int $categoryId, string $lang, array $data): void
    {
        $stmt = $this->db->prepare('
            INSERT INTO category_translations (category_id, lang, name, description, meta_title, meta_description)
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE name=?, description=?, meta_title=?, meta_description=?
        ');
        $stmt->execute([
            $categoryId, $lang,
            $data['name'], $data['description'] ?? '', $data['meta_title'] ?? '', $data['meta_description'] ?? '',
            $data['name'], $data['description'] ?? '', $data['meta_title'] ?? '', $data['meta_description'] ?? '',
        ]);
    }

    public function countProducts(int $categoryId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM products WHERE category_id=?');
        $stmt->execute([$categoryId]);
        return (int) $stmt->fetchColumn();
    }

    public function delete(int $id): bool
    {
        if ($this->countProducts($id) > 0) {
            return false;
        }
        $category = $this->find($id);
        if ($category && !empty($category['image'])) {
            delete_upload($category['image']);
        }
        $this->db->prepare('DELETE FROM categories WHERE id=?')->execute([$id]);
        return true;
    }

    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $sql = 'SELECT id FROM categories WHERE slug=?';
        $params = [$slug];
        if ($excludeId) {
            $sql .= ' AND id!=?';
            $params[] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetch();
    }
}
