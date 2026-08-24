<?php

namespace App\Models;

use App\Core\Model;

class Banner extends Model
{
    public function getActive(string $lang): array
    {
        $stmt = $this->db->prepare('
            SELECT b.*,
                COALESCE(NULLIF(bt.title, ""), bt_en.title, "") AS title,
                COALESCE(NULLIF(bt.subtitle, ""), bt_en.subtitle, "") AS subtitle,
                COALESCE(NULLIF(bt.button_text, ""), bt_en.button_text, "") AS button_text
            FROM banners b
            LEFT JOIN banner_translations bt ON b.id = bt.banner_id AND bt.lang = ?
            LEFT JOIN banner_translations bt_en ON b.id = bt_en.banner_id AND bt_en.lang = "en"
            WHERE b.is_active = 1
            ORDER BY b.sort_order, b.id
        ');
        $stmt->execute([$lang]);
        return $stmt->fetchAll();
    }

    public function getAllAdmin(): array
    {
        return $this->db->query('
            SELECT b.*, bt.title FROM banners b
            LEFT JOIN banner_translations bt ON b.id = bt.banner_id AND bt.lang = "en"
            ORDER BY b.sort_order
        ')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM banners WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTranslations(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM banner_translations WHERE banner_id = ?');
        $stmt->execute([$id]);
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['lang']] = $row;
        }
        return $result;
    }

    public function create(string $image, array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO banners (image, link, sort_order, is_active) VALUES (?,?,?,?)');
        $stmt->execute([
            $image,
            $data['link'] ?? null,
            (int) ($data['sort_order'] ?? 0),
            (int) ($data['is_active'] ?? 1),
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data, ?string $image = null): void
    {
        if ($image) {
            $old = $this->find($id);
            if ($old && $old['image'] !== $image) {
                delete_upload($old['image']);
            }
            $this->db->prepare('UPDATE banners SET image=?, link=?, sort_order=?, is_active=? WHERE id=?')
                ->execute([$image, $data['link'] ?? null, (int) ($data['sort_order'] ?? 0), (int) ($data['is_active'] ?? 1), $id]);
        } else {
            $this->db->prepare('UPDATE banners SET link=?, sort_order=?, is_active=? WHERE id=?')
                ->execute([$data['link'] ?? null, (int) ($data['sort_order'] ?? 0), (int) ($data['is_active'] ?? 1), $id]);
        }
    }

    public function delete(int $id): void
    {
        $banner = $this->find($id);
        if ($banner) {
            delete_upload($banner['image']);
        }
        $this->db->prepare('DELETE FROM banners WHERE id=?')->execute([$id]);
    }

    public function saveTranslation(int $bannerId, string $lang, array $data): void
    {
        $stmt = $this->db->prepare('
            INSERT INTO banner_translations (banner_id, lang, title, subtitle, button_text)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE title=?, subtitle=?, button_text=?
        ');
        $stmt->execute([
            $bannerId, $lang,
            $data['title'] ?? '', $data['subtitle'] ?? '', $data['button_text'] ?? '',
            $data['title'] ?? '', $data['subtitle'] ?? '', $data['button_text'] ?? '',
        ]);
    }
}
