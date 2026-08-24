<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    public function getAll(string $lang, ?int $categoryId = null, int $limit = 0): array
    {
        $sql = '
            SELECT p.*, pt.name, pt.short_description, pt.meta_title,
                   ct.name AS category_name, c.slug AS category_slug,
                   (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_primary DESC, sort_order LIMIT 1) as image,
                   (SELECT COUNT(*) FROM product_sizes ps WHERE ps.product_id = p.id) AS size_count
            FROM products p
            JOIN product_translations pt ON p.id = pt.product_id AND pt.lang = ?
            JOIN categories c ON p.category_id = c.id
            JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
            WHERE p.is_active = 1
        ';
        $params = [$lang, $lang];
        if ($categoryId) {
            $sql .= ' AND p.category_id = ?';
            $params[] = $categoryId;
        }

        $sql .= ' ORDER BY p.sort_order';

        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int)$limit;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getFeatured(string $lang, int $limit = 6): array
    {
        $stmt = $this->db->prepare('
            SELECT p.*, pt.name, pt.short_description,
                   ct.name AS category_name, c.slug AS category_slug,
                   (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_primary DESC, sort_order LIMIT 1) as image,
                   (SELECT COUNT(*) FROM product_sizes ps WHERE ps.product_id = p.id) AS size_count
            FROM products p
            JOIN product_translations pt ON p.id = pt.product_id AND pt.lang = ?
            JOIN categories c ON p.category_id = c.id
            JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
            WHERE p.is_active = 1 AND p.is_featured = 1
            ORDER BY p.sort_order LIMIT ?
        ');
        $stmt->execute([$lang, $lang, $limit]);
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug, string $lang): ?array
    {
        $stmt = $this->db->prepare('
            SELECT p.*, pt.name, pt.short_description, pt.description, pt.benefits, pt.applications, pt.meta_title, pt.meta_description,
                   ct.name as category_name, c.slug as category_slug
            FROM products p
            JOIN product_translations pt ON p.id = pt.product_id AND pt.lang = ?
            JOIN categories c ON p.category_id = c.id
            JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
            WHERE p.slug = ? AND p.is_active = 1
        ');
        $stmt->execute([$lang, $lang, $slug]);
        return $stmt->fetch() ?: null;
    }

    public function getImages(int $productId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC, sort_order');
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function getSizes(int $productId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_sizes WHERE product_id = ? ORDER BY sort_order');
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function getSpecs(int $productId, string $lang): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_specs WHERE product_id = ? AND lang = ? ORDER BY sort_order');
        $stmt->execute([$productId, $lang]);
        return $stmt->fetchAll();
    }

    public function getRelated(int $productId, int $categoryId, string $lang, int $limit = 4): array
    {
        $stmt = $this->db->prepare('
            SELECT p.*, pt.name, pt.short_description,
                   (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_primary DESC LIMIT 1) as image
            FROM products p
            JOIN product_translations pt ON p.id = pt.product_id AND pt.lang = ?
            WHERE p.category_id = ? AND p.id != ? AND p.is_active = 1
            ORDER BY RAND() LIMIT ?
        ');
        $stmt->execute([$lang, $categoryId, $productId, $limit]);
        return $stmt->fetchAll();
    }

    public function getByIds(array $ids, string $lang): array
    {
        if (empty($ids)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $params = array_merge([$lang, $lang], $ids);
        $stmt = $this->db->prepare("
            SELECT p.*, pt.name, pt.short_description, pt.benefits, pt.applications,
                   ct.name as category_name
            FROM products p
            JOIN product_translations pt ON p.id = pt.product_id AND pt.lang = ?
            JOIN categories c ON p.category_id = c.id
            JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
            WHERE p.id IN ({$placeholders}) AND p.is_active = 1
        ");
        $stmt->execute($params);
        $products = $stmt->fetchAll();
        foreach ($products as &$product) {
            $product['sizes'] = $this->getSizes($product['id']);
            $product['specs'] = $this->getSpecs($product['id'], $lang);
        }
        return $products;
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }

    public function getAllAdmin(): array
    {
        $rows = $this->db->query('
            SELECT p.*, pt.name, ct.name as category_name,
                   (SELECT COUNT(*) FROM product_sizes ps WHERE ps.product_id = p.id) as size_count
            FROM products p
            LEFT JOIN product_translations pt ON p.id = pt.product_id AND pt.lang = "en"
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = "en"
            ORDER BY p.sort_order
        ')->fetchAll();
        return $rows;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTranslations(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_translations WHERE product_id = ?');
        $stmt->execute([$id]);
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['lang']] = $row;
        }
        return $result;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO products (category_id, stone_type, slug, sku, is_featured, is_active, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            (int) $data['category_id'],
            $data['stone_type'] ?? null,
            $data['slug'],
            $data['sku'] ?? null,
            (int) ($data['is_featured'] ?? 0),
            (int) ($data['is_active'] ?? 1),
            (int) ($data['sort_order'] ?? 0),
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('
            UPDATE products SET category_id=?, stone_type=?, slug=?, sku=?, is_featured=?, is_active=?, sort_order=?
            WHERE id=?
        ');
        $stmt->execute([
            (int) $data['category_id'],
            $data['stone_type'] ?? null,
            $data['slug'],
            $data['sku'] ?? null,
            (int) ($data['is_featured'] ?? 0),
            (int) ($data['is_active'] ?? 1),
            (int) ($data['sort_order'] ?? 0),
            $id,
        ]);
    }

    public function replaceSizes(int $productId, array $sizes): void
    {
        $this->db->prepare('DELETE FROM product_sizes WHERE product_id=?')->execute([$productId]);
        $stmt = $this->db->prepare('
            INSERT INTO product_sizes (product_id, sl_no, size_label, diameter, bore, thickness, weight, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');
        foreach ($sizes as $i => $size) {
            $stmt->execute([
                $productId,
                (int) ($size['sl_no'] ?? $i + 1),
                $size['size_label'],
                $size['diameter'] ?? '',
                $size['bore'] ?? '',
                $size['thickness'] ?? '',
                $size['weight'] ?? '',
                (int) ($size['sort_order'] ?? $i),
            ]);
        }
    }

    public function countSizes(int $productId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM product_sizes WHERE product_id=?');
        $stmt->execute([$productId]);
        return (int) $stmt->fetchColumn();
    }

    public function delete(int $id): void
    {
        foreach ($this->getImages($id) as $img) {
            delete_upload($img['image_path']);
        }
        $this->db->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
    }

    public function saveTranslation(int $productId, string $lang, array $data): void
    {
        $stmt = $this->db->prepare('
            INSERT INTO product_translations (product_id, lang, name, short_description, description, benefits, applications, meta_title, meta_description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE name=?, short_description=?, description=?, benefits=?, applications=?, meta_title=?, meta_description=?
        ');
        $stmt->execute([
            $productId, $lang,
            $data['name'], $data['short_description'] ?? '', $data['description'] ?? '',
            $data['benefits'] ?? '', $data['applications'] ?? '',
            $data['meta_title'] ?? '', $data['meta_description'] ?? '',
            $data['name'], $data['short_description'] ?? '', $data['description'] ?? '',
            $data['benefits'] ?? '', $data['applications'] ?? '',
            $data['meta_title'] ?? '', $data['meta_description'] ?? '',
        ]);
    }

    public function addImage(int $productId, string $path, bool $primary = false): void
    {
        if ($primary) {
            $this->db->prepare('UPDATE product_images SET is_primary=0 WHERE product_id=?')->execute([$productId]);
        }
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM product_images WHERE product_id=?');
        $stmt->execute([$productId]);
        $sort = (int) $stmt->fetchColumn();
        $this->db->prepare('INSERT INTO product_images (product_id, image_path, is_primary, sort_order) VALUES (?,?,?,?)')
            ->execute([$productId, $path, $primary ? 1 : 0, $sort]);
    }

    public function deleteImage(int $imageId): void
    {
        $stmt = $this->db->prepare('SELECT * FROM product_images WHERE id=?');
        $stmt->execute([$imageId]);
        $img = $stmt->fetch();
        if ($img) {
            delete_upload($img['image_path']);
            $this->db->prepare('DELETE FROM product_images WHERE id=?')->execute([$imageId]);
        }
    }

    public function setPrimaryImage(int $productId, int $imageId): void
    {
        $this->db->prepare('UPDATE product_images SET is_primary=0 WHERE product_id=?')->execute([$productId]);
        $this->db->prepare('UPDATE product_images SET is_primary=1 WHERE id=? AND product_id=?')->execute([$imageId, $productId]);
    }

    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $sql = 'SELECT id FROM products WHERE slug=?';
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
