<?php

namespace App\Models;

use App\Core\Model;

class ProcessStep extends Model
{
    public function getActive(string $lang): array
    {
        $stmt = $this->db->prepare('
            SELECT ps.*,
                COALESCE(NULLIF(pt.label, ""), pt_en.label, "") AS label,
                COALESCE(NULLIF(pt.description, ""), pt_en.description, "") AS description
            FROM process_steps ps
            LEFT JOIN process_step_translations pt ON ps.id = pt.process_step_id AND pt.lang = ?
            LEFT JOIN process_step_translations pt_en ON ps.id = pt_en.process_step_id AND pt_en.lang = "en"
            WHERE ps.is_active = 1
            ORDER BY ps.sort_order, ps.id
        ');
        $stmt->execute([$lang]);
        return $stmt->fetchAll();
    }

    public function getAllAdmin(): array
    {
        return $this->db->query('
            SELECT ps.*, pt.label, pt.description
            FROM process_steps ps
            LEFT JOIN process_step_translations pt ON ps.id = pt.process_step_id AND pt.lang = "en"
            ORDER BY ps.sort_order, ps.id
        ')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM process_steps WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTranslations(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM process_step_translations WHERE process_step_id = ?');
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
            INSERT INTO process_steps (icon, image, image_position, sort_order, is_active)
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            $data['icon'] ?? 'bi-gear',
            $data['image'] ?? null,
            $data['image_position'] ?? 'center',
            (int) ($data['sort_order'] ?? 0),
            (int) ($data['is_active'] ?? 1),
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data, ?string $image = null): void
    {
        if ($image !== null) {
            $old = $this->find($id);
            if ($old && !empty($old['image']) && $old['image'] !== $image) {
                delete_upload($old['image']);
            }
            $this->db->prepare('
                UPDATE process_steps
                SET icon = ?, image = ?, image_position = ?, sort_order = ?, is_active = ?
                WHERE id = ?
            ')->execute([
                $data['icon'] ?? 'bi-gear',
                $image,
                $data['image_position'] ?? 'center',
                (int) ($data['sort_order'] ?? 0),
                (int) ($data['is_active'] ?? 1),
                $id,
            ]);
            return;
        }

        $this->db->prepare('
            UPDATE process_steps
            SET icon = ?, image_position = ?, sort_order = ?, is_active = ?
            WHERE id = ?
        ')->execute([
            $data['icon'] ?? 'bi-gear',
            $data['image_position'] ?? 'center',
            (int) ($data['sort_order'] ?? 0),
            (int) ($data['is_active'] ?? 1),
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $step = $this->find($id);
        if ($step && !empty($step['image'])) {
            delete_upload($step['image']);
        }
        $this->db->prepare('DELETE FROM process_steps WHERE id = ?')->execute([$id]);
    }

    public function saveTranslation(int $stepId, string $lang, array $data): void
    {
        $stmt = $this->db->prepare('
            INSERT INTO process_step_translations (process_step_id, lang, label, description)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE label = VALUES(label), description = VALUES(description)
        ');
        $stmt->execute([
            $stepId,
            $lang,
            $data['label'] ?? '',
            $data['description'] ?? '',
        ]);
    }

    public function getSectionForLang(string $lang, array $fallbackTranslations = []): array
    {
        $settings = (new Setting())->getAll();
        $titleKey = 'manufacturing_process_title_' . $lang;
        $descKey = 'manufacturing_process_desc_' . $lang;

        return [
            'title' => trim($settings[$titleKey] ?? '') ?: ($fallbackTranslations['landing_process_title'] ?? ''),
            'desc' => trim($settings[$descKey] ?? '') ?: ($fallbackTranslations['landing_process_desc'] ?? ''),
            'step_label' => $fallbackTranslations['landing_process_step_label'] ?? 'Step',
        ];
    }

    public function saveSectionSettings(array $data): void
    {
        $setting = new Setting();
        foreach ($data as $key => $value) {
            $setting->set($key, trim((string) $value));
        }
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM process_steps')->fetchColumn();
    }

    public function getDisplaySteps(string $lang, array $fallbackTranslations = []): array
    {
        $steps = $this->getActive($lang);
        $fallbackSteps = $fallbackTranslations['landing_process_steps'] ?? [];
        $fallbackImages = [
            asset('images/pioneer-banner.png'),
            asset('images/company-flyer.png'),
            upload_url('products/vertical-danish-10-inch.png'),
            asset('images/pioneer-banner.png'),
            asset('images/landing-hero-products.png'),
            upload_url('products/vertical-danish-14-inch.png'),
            upload_url('products/flour-mill-stone.png'),
            upload_url('products/horizontal-16-inch.png'),
        ];

        if (empty($steps)) {
            $result = [];
            foreach ($fallbackSteps as $idx => $step) {
                $result[] = [
                    'icon' => $step['icon'] ?? 'bi-gear',
                    'label' => $step['label'] ?? '',
                    'desc' => $step['desc'] ?? '',
                    'image' => $fallbackImages[$idx] ?? asset('images/pioneer-banner.png'),
                    'pos' => 'center',
                ];
            }
            return $result;
        }

        $result = [];
        foreach ($steps as $idx => $step) {
            $result[] = [
                'icon' => $step['icon'] ?? 'bi-gear',
                'label' => $step['label'] ?? '',
                'desc' => $step['description'] ?? '',
                'image' => !empty($step['image'])
                    ? upload_url($step['image'])
                    : ($fallbackImages[$idx] ?? asset('images/pioneer-banner.png')),
                'pos' => $step['image_position'] ?? 'center',
            ];
        }

        return $result;
    }
}
