<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    private function adminBase(): string
    {
        return rtrim($this->config['url'], '/') . '/admin';
    }

    public function index(): void
    {
        $this->adminView('banners/index', [
            'banners' => (new Banner())->getAllAdmin(),
            'flash' => $_SESSION['admin_flash'] ?? null,
        ]);
        unset($_SESSION['admin_flash']);
    }

    public function create(): void
    {
        $this->adminView('banners/form', [
            'banner' => null,
            'translations' => [],
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/banners');
            return;
        }

        $path = upload_image($_FILES['image'] ?? [], 'banners');
        if (!$path) {
            $_SESSION['admin_flash'] = 'Please upload a banner image.';
            $this->redirect($this->adminBase() . '/banners/create');
            return;
        }

        $model = new Banner();
        $id = $model->create($path, [
            'link' => trim($_POST['link'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        foreach (['en', 'hi'] as $lang) {
            $model->saveTranslation($id, $lang, [
                'title' => trim($_POST["title_{$lang}"] ?? ''),
                'subtitle' => trim($_POST["subtitle_{$lang}"] ?? ''),
                'button_text' => trim($_POST["button_text_{$lang}"] ?? ''),
            ]);
        }

        $_SESSION['admin_flash'] = 'Banner added successfully.';
        $this->redirect($this->adminBase() . '/banners');
    }

    public function edit(string $id): void
    {
        $model = new Banner();
        $banner = $model->find((int) $id);
        if (!$banner) {
            $this->redirect($this->adminBase() . '/banners');
            return;
        }
        $this->adminView('banners/form', [
            'banner' => $banner,
            'translations' => $model->getTranslations((int) $id),
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function update(string $id): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/banners');
            return;
        }

        $id = (int) $id;
        $model = new Banner();
        $banner = $model->find($id);
        if (!$banner) {
            $this->redirect($this->adminBase() . '/banners');
            return;
        }

        $newImage = null;
        if (!empty($_FILES['image']['name'])) {
            $newImage = upload_image($_FILES['image'], 'banners');
        }

        $model->update($id, [
            'link' => trim($_POST['link'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ], $newImage);

        foreach (['en', 'hi'] as $lang) {
            $model->saveTranslation($id, $lang, [
                'title' => trim($_POST["title_{$lang}"] ?? ''),
                'subtitle' => trim($_POST["subtitle_{$lang}"] ?? ''),
                'button_text' => trim($_POST["button_text_{$lang}"] ?? ''),
            ]);
        }

        $_SESSION['admin_flash'] = 'Banner updated successfully.';
        $this->redirect($this->adminBase() . '/banners');
    }

    public function delete(string $id): void
    {
        (new Banner())->delete((int) $id);
        $_SESSION['admin_flash'] = 'Banner deleted.';
        $this->redirect($this->adminBase() . '/banners');
    }
}
