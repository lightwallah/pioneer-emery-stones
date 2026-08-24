<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    private function adminBase(): string
    {
        return rtrim($this->config['url'], '/') . '/admin';
    }

    public function index(): void
    {
        $this->adminView('categories/index', [
            'categories' => (new Category())->getAllAdmin(),
            'flash' => $_SESSION['admin_flash'] ?? null,
        ]);
        unset($_SESSION['admin_flash']);
    }

    public function create(): void
    {
        $this->adminView('categories/form', [
            'category' => null,
            'translations' => [],
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/categories');
            return;
        }

        $slug = slugify($_POST['slug'] ?? $_POST['name_en'] ?? 'category');
        $model = new Category();
        if ($model->slugExists($slug)) {
            $slug .= '-' . time();
        }

        $image = null;
        if (!empty($_FILES['image']['name'])) {
            $error = null;
            $image = upload_image($_FILES['image'], 'categories', $error);
            if (!$image && $error) {
                $_SESSION['admin_flash'] = $error;
                $this->redirect($this->adminBase() . '/categories/create');
                return;
            }
        }

        $id = $model->create([
            'slug' => $slug,
            'image' => $image,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        $this->saveTranslations($model, $id);
        $_SESSION['admin_flash'] = 'Category created successfully.';
        $this->redirect($this->adminBase() . '/categories');
    }

    public function edit(string $id): void
    {
        $model = new Category();
        $category = $model->find((int) $id);
        if (!$category) {
            $this->redirect($this->adminBase() . '/categories');
            return;
        }

        $this->adminView('categories/form', [
            'category' => $category,
            'translations' => $model->getTranslations((int) $id),
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function update(string $id): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/categories');
            return;
        }

        $id = (int) $id;
        $model = new Category();
        $category = $model->find($id);
        if (!$category) {
            $this->redirect($this->adminBase() . '/categories');
            return;
        }

        $slug = slugify($_POST['slug'] ?? $_POST['name_en'] ?? $category['slug']);
        if ($model->slugExists($slug, $id)) {
            $slug = $category['slug'];
        }

        $image = $category['image'];
        if (!empty($_FILES['image']['name'])) {
            $error = null;
            $newImage = upload_image($_FILES['image'], 'categories', $error);
            if ($newImage) {
                if ($image) {
                    delete_upload($image);
                }
                $image = $newImage;
            } elseif ($error) {
                $_SESSION['admin_flash'] = $error;
                $this->redirect($this->adminBase() . '/categories/edit/' . $id);
                return;
            }
        }

        $model->update($id, [
            'slug' => $slug,
            'image' => $image,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        $this->saveTranslations($model, $id);
        $_SESSION['admin_flash'] = 'Category updated successfully.';
        $this->redirect($this->adminBase() . '/categories');
    }

    public function delete(string $id): void
    {
        $id = (int) $id;
        $model = new Category();
        if (!$model->find($id)) {
            $this->redirect($this->adminBase() . '/categories');
            return;
        }

        if (!$model->delete($id)) {
            $_SESSION['admin_flash'] = 'Cannot delete: this category has products. Move or delete products first.';
            $this->redirect($this->adminBase() . '/categories');
            return;
        }

        $_SESSION['admin_flash'] = 'Category deleted.';
        $this->redirect($this->adminBase() . '/categories');
    }

    private function saveTranslations(Category $model, int $id): void
    {
        foreach (['en', 'hi'] as $lang) {
            $model->saveTranslation($id, $lang, [
                'name' => trim($_POST["name_{$lang}"] ?? ''),
                'description' => trim($_POST["description_{$lang}"] ?? ''),
                'meta_title' => trim($_POST["meta_title_{$lang}"] ?? ''),
                'meta_description' => trim($_POST["meta_description_{$lang}"] ?? ''),
            ]);
        }
    }
}
