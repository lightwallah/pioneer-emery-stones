<?php

namespace App\Models;

use App\Core\Model;

class PageSeo extends Model
{
    public function get(string $pageKey, string $lang): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM page_seo WHERE page_key = ? AND lang = ?');
        $stmt->execute([$pageKey, $lang]);
        return $stmt->fetch() ?: null;
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM page_seo ORDER BY page_key, lang')->fetchAll();
    }

    public function save(string $pageKey, string $lang, array $data): void
    {
        $stmt = $this->db->prepare('
            INSERT INTO page_seo (page_key, lang, meta_title, meta_description, meta_keywords, og_title, og_description)
            VALUES (?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE meta_title=?, meta_description=?, meta_keywords=?, og_title=?, og_description=?
        ');
        $stmt->execute([
            $pageKey, $lang,
            $data['meta_title'], $data['meta_description'], $data['meta_keywords'] ?? '',
            $data['og_title'] ?? '', $data['og_description'] ?? '',
            $data['meta_title'], $data['meta_description'], $data['meta_keywords'] ?? '',
            $data['og_title'] ?? '', $data['og_description'] ?? '',
        ]);
    }
}
