<?php

namespace App\Models;

use App\Core\Model;

class Blog extends Model
{
    public function getAll(string $lang, int $page = 1, int $perPage = 9): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare('
            SELECT b.*, bt.title, bt.excerpt, bct.name as category_name
            FROM blogs b
            JOIN blog_translations bt ON b.id = bt.blog_id AND bt.lang = ?
            LEFT JOIN blog_categories bc ON b.category_id = bc.id
            LEFT JOIN blog_category_translations bct ON bc.id = bct.category_id AND bct.lang = ?
            WHERE b.is_published = 1
            ORDER BY b.published_at DESC
            LIMIT ? OFFSET ?
        ');
        $stmt->execute([$lang, $lang, $perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function getLatest(string $lang, int $limit = 3): array
    {
        $stmt = $this->db->prepare('
            SELECT b.*, bt.title, bt.excerpt
            FROM blogs b
            JOIN blog_translations bt ON b.id = bt.blog_id AND bt.lang = ?
            WHERE b.is_published = 1
            ORDER BY b.published_at DESC LIMIT ?
        ');
        $stmt->execute([$lang, $limit]);
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug, string $lang): ?array
    {
        $stmt = $this->db->prepare('
            SELECT b.*, bt.title, bt.excerpt, bt.content, bt.meta_title, bt.meta_description,
                   bct.name as category_name, bc.slug as category_slug
            FROM blogs b
            JOIN blog_translations bt ON b.id = bt.blog_id AND bt.lang = ?
            LEFT JOIN blog_categories bc ON b.category_id = bc.id
            LEFT JOIN blog_category_translations bct ON bc.id = bct.category_id AND bct.lang = ?
            WHERE b.slug = ? AND b.is_published = 1
        ');
        $stmt->execute([$lang, $lang, $slug]);
        return $stmt->fetch() ?: null;
    }

    public function getTags(int $blogId): array
    {
        $stmt = $this->db->prepare('SELECT tag FROM blog_tags WHERE blog_id = ?');
        $stmt->execute([$blogId]);
        return array_column($stmt->fetchAll(), 'tag');
    }

    public function getRelated(int $blogId, ?int $categoryId, string $lang, int $limit = 3): array
    {
        $stmt = $this->db->prepare('
            SELECT b.*, bt.title, bt.excerpt
            FROM blogs b
            JOIN blog_translations bt ON b.id = bt.blog_id AND bt.lang = ?
            WHERE b.is_published = 1 AND b.id != ? AND (b.category_id = ? OR ? IS NULL)
            ORDER BY b.published_at DESC LIMIT ?
        ');
        $stmt->execute([$lang, $blogId, $categoryId, $categoryId, $limit]);
        return $stmt->fetchAll();
    }

    public function search(string $query, string $lang): array
    {
        $stmt = $this->db->prepare('
            SELECT b.*, bt.title, bt.excerpt
            FROM blogs b
            JOIN blog_translations bt ON b.id = bt.blog_id AND bt.lang = ?
            WHERE b.is_published = 1 AND (bt.title LIKE ? OR bt.excerpt LIKE ? OR bt.content LIKE ?)
            ORDER BY b.published_at DESC
        ');
        $q = '%' . $query . '%';
        $stmt->execute([$lang, $q, $q, $q]);
        return $stmt->fetchAll();
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM blogs')->fetchColumn();
    }

    public function getAllAdmin(): array
    {
        return $this->db->query('
            SELECT b.*, bt.title FROM blogs b
            LEFT JOIN blog_translations bt ON b.id = bt.blog_id AND bt.lang = "en"
            ORDER BY b.created_at DESC
        ')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM blogs WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTranslations(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM blog_translations WHERE blog_id = ?');
        $stmt->execute([$id]);
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['lang']] = $row;
        }
        return $result;
    }
}
