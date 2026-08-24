<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\ProcessStep;

class ManufacturingProcessController extends Controller
{
    private function adminBase(): string
    {
        return rtrim($this->config['url'], '/') . '/admin';
    }

    public function index(): void
    {
        $model = new ProcessStep();
        $this->adminView('manufacturing-process/index', [
            'steps' => $model->getAllAdmin(),
            'section' => [
                'title_en' => (new \App\Models\Setting())->get('manufacturing_process_title_en'),
                'title_hi' => (new \App\Models\Setting())->get('manufacturing_process_title_hi'),
                'desc_en' => (new \App\Models\Setting())->get('manufacturing_process_desc_en'),
                'desc_hi' => (new \App\Models\Setting())->get('manufacturing_process_desc_hi'),
            ],
            'csrf' => $this->csrfToken(),
            'flash' => $_SESSION['admin_flash'] ?? null,
        ]);
        unset($_SESSION['admin_flash']);
    }

    public function section(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/manufacturing-process');
            return;
        }

        (new ProcessStep())->saveSectionSettings([
            'manufacturing_process_title_en' => $_POST['title_en'] ?? '',
            'manufacturing_process_title_hi' => $_POST['title_hi'] ?? '',
            'manufacturing_process_desc_en' => $_POST['desc_en'] ?? '',
            'manufacturing_process_desc_hi' => $_POST['desc_hi'] ?? '',
        ]);

        $_SESSION['admin_flash'] = 'Section heading updated.';
        $this->redirect($this->adminBase() . '/manufacturing-process');
    }

    public function create(): void
    {
        $this->adminView('manufacturing-process/form', [
            'step' => null,
            'translations' => [],
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/manufacturing-process');
            return;
        }

        $image = null;
        if (!empty($_FILES['image']['name'])) {
            $image = upload_image($_FILES['image'], 'process-steps');
        }

        $model = new ProcessStep();
        $id = $model->create([
            'icon' => trim($_POST['icon'] ?? 'bi-gear'),
            'image' => $image,
            'image_position' => trim($_POST['image_position'] ?? 'center'),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        foreach (['en', 'hi'] as $lang) {
            $model->saveTranslation($id, $lang, [
                'label' => trim($_POST["label_{$lang}"] ?? ''),
                'description' => trim($_POST["description_{$lang}"] ?? ''),
            ]);
        }

        $_SESSION['admin_flash'] = 'Process step added.';
        $this->redirect($this->adminBase() . '/manufacturing-process');
    }

    public function edit(string $id): void
    {
        $model = new ProcessStep();
        $step = $model->find((int) $id);
        if (!$step) {
            $this->redirect($this->adminBase() . '/manufacturing-process');
            return;
        }

        $this->adminView('manufacturing-process/form', [
            'step' => $step,
            'translations' => $model->getTranslations((int) $id),
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function update(string $id): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/manufacturing-process');
            return;
        }

        $id = (int) $id;
        $model = new ProcessStep();
        $step = $model->find($id);
        if (!$step) {
            $this->redirect($this->adminBase() . '/manufacturing-process');
            return;
        }

        $newImage = null;
        if (!empty($_FILES['image']['name'])) {
            $newImage = upload_image($_FILES['image'], 'process-steps');
        }

        $data = [
            'icon' => trim($_POST['icon'] ?? 'bi-gear'),
            'image_position' => trim($_POST['image_position'] ?? 'center'),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        if ($newImage) {
            $model->update($id, $data, $newImage);
        } else {
            $model->update($id, $data);
        }

        foreach (['en', 'hi'] as $lang) {
            $model->saveTranslation($id, $lang, [
                'label' => trim($_POST["label_{$lang}"] ?? ''),
                'description' => trim($_POST["description_{$lang}"] ?? ''),
            ]);
        }

        $_SESSION['admin_flash'] = 'Process step updated.';
        $this->redirect($this->adminBase() . '/manufacturing-process');
    }

    public function delete(string $id): void
    {
        (new ProcessStep())->delete((int) $id);
        $_SESSION['admin_flash'] = 'Process step deleted.';
        $this->redirect($this->adminBase() . '/manufacturing-process');
    }
}
