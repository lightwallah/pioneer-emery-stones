<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    private function adminBase(): string
    {
        return rtrim($this->config['url'], '/') . '/admin';
    }

    private function formData(Product $model, ?array $product, int $productId = 0): array
    {
        return [
            'product' => $product,
            'translations' => $productId ? $model->getTranslations($productId) : [],
            'images' => $productId ? $model->getImages($productId) : [],
            'sizes' => $productId ? $model->getSizes($productId) : [],
            'categories' => (new Category())->getAllAdmin(),
            'stoneTypes' => stone_types(),
            'csrf' => $this->csrfToken(),
        ];
    }

    public function index(): void
    {
        $products = (new Product())->getAllAdmin();
        foreach ($products as &$p) {
            $p['thumb'] = (new Product())->getImages($p['id'])[0]['image_path'] ?? null;
            $p['stone_type_label'] = !empty($p['stone_type']) ? stone_type_label($p['stone_type']) : '-';
        }
        $this->adminView('products/index', ['products' => $products]);
    }

    public function create(): void
    {
        $this->adminView('products/form', $this->formData(new Product(), null));
    }

    public function store(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/products');
            return;
        }

        $model = new Product();
        $slug = slugify($_POST['slug'] ?? $_POST['name_en'] ?? 'product');
        if ($model->slugExists($slug)) {
            $slug .= '-' . time();
        }

        $id = $model->create([
            'category_id' => $_POST['category_id'] ?? 1,
            'stone_type' => trim($_POST['stone_type'] ?? '') ?: null,
            'slug' => $slug,
            'sku' => trim($_POST['sku'] ?? ''),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ]);

        $uploadResult = $this->saveProductMeta($model, $id);
        $_SESSION['admin_flash'] = 'Product created successfully.' . $this->uploadFlashMessage($uploadResult, false);
        $this->redirect($this->adminBase() . '/products/edit/' . $id);
    }

    public function edit(string $id): void
    {
        $model = new Product();
        $product = $model->find((int) $id);
        if (!$product) {
            $this->redirect($this->adminBase() . '/products');
            return;
        }
        $data = $this->formData($model, $product, (int) $id);
        $data['flash'] = $_SESSION['admin_flash'] ?? null;
        $this->adminView('products/form', $data);
        unset($_SESSION['admin_flash']);
    }

    public function update(string $id): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect($this->adminBase() . '/products');
            return;
        }

        $id = (int) $id;
        $model = new Product();
        $product = $model->find($id);
        if (!$product) {
            $this->redirect($this->adminBase() . '/products');
            return;
        }

        if (!empty($_POST['delete_image_id'])) {
            $model->deleteImage((int) $_POST['delete_image_id']);
            $_SESSION['admin_flash'] = 'Image deleted.';
            $this->redirect($this->adminBase() . '/products/edit/' . $id);
            return;
        }
        if (!empty($_POST['primary_image_id'])) {
            $model->setPrimaryImage($id, (int) $_POST['primary_image_id']);
            $_SESSION['admin_flash'] = 'Primary image updated.';
            $this->redirect($this->adminBase() . '/products/edit/' . $id);
            return;
        }
        if (!empty($_POST['upload_images_only'])) {
            $uploadResult = $this->handleImageUploads($model, $id, empty($model->getImages($id)));
            $_SESSION['admin_flash'] = $this->uploadFlashMessage($uploadResult);
            $this->redirect($this->adminBase() . '/products/edit/' . $id);
            return;
        }

        $slug = slugify($_POST['slug'] ?? $_POST['name_en'] ?? $product['slug']);
        if ($model->slugExists($slug, $id)) {
            $slug = $product['slug'];
        }

        $model->update($id, [
            'category_id' => $_POST['category_id'] ?? $product['category_id'],
            'stone_type' => trim($_POST['stone_type'] ?? '') ?: null,
            'slug' => $slug,
            'sku' => trim($_POST['sku'] ?? ''),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ]);

        $uploadResult = $this->saveProductMeta($model, $id);
        $_SESSION['admin_flash'] = 'Product updated successfully.' . $this->uploadFlashMessage($uploadResult, false);
        $this->redirect($this->adminBase() . '/products/edit/' . $id);
    }

    public function delete(string $id): void
    {
        (new Product())->delete((int) $id);
        $_SESSION['admin_flash'] = 'Product deleted.';
        $this->redirect($this->adminBase() . '/products');
    }

    private function saveProductMeta(Product $model, int $id): array
    {
        foreach (['en', 'hi'] as $lang) {
            $model->saveTranslation($id, $lang, [
                'name' => trim($_POST["name_{$lang}"] ?? ''),
                'short_description' => trim($_POST["short_description_{$lang}"] ?? ''),
                'description' => trim($_POST["description_{$lang}"] ?? ''),
                'meta_title' => trim($_POST["meta_title_{$lang}"] ?? ''),
                'meta_description' => trim($_POST["meta_description_{$lang}"] ?? ''),
            ]);
        }

        if (isset($_POST['sizes']) && is_array($_POST['sizes'])) {
            $model->replaceSizes($id, $this->parseSizesFromPost());
        }

        return $this->handleImageUploads($model, $id, empty($model->getImages($id)));
    }

    private function uploadFlashMessage(array $result, bool $standalone = true): string
    {
        $parts = [];
        if (($result['uploaded'] ?? 0) > 0) {
            $parts[] = ($result['uploaded'] === 1 ? '1 image uploaded.' : $result['uploaded'] . ' images uploaded.');
        }
        if (!empty($result['errors'])) {
            $parts[] = 'Upload failed: ' . implode(' ', $result['errors']);
        }
        if (empty($parts)) {
            return $standalone ? 'No images were uploaded. Choose JPG/PNG files and try again.' : '';
        }
        return ($standalone ? '' : ' ') . implode(' ', $parts);
    }

    private function parseSizesFromPost(): array
    {
        $sizes = [];
        $posted = $_POST['sizes'] ?? [];
        if (!is_array($posted)) {
            return $sizes;
        }
        foreach ($posted as $row) {
            if (empty($row['enabled'])) {
                continue;
            }
            $diameter = trim($row['diameter'] ?? '');
            if ($diameter === '') {
                continue;
            }
            $weight = trim($row['weight'] ?? '');
            if ($weight !== '' && !str_contains(strtolower($weight), 'kg')) {
                $weight .= ' kg';
            }
            $sizes[] = [
                'sl_no' => (int) ($row['sl'] ?? 0),
                'size_label' => $diameter,
                'diameter' => $diameter,
                'bore' => trim($row['bore'] ?? ''),
                'thickness' => trim($row['thickness'] ?? ''),
                'weight' => $weight,
            ];
        }
        return $sizes;
    }

    private function handleImageUploads(Product $model, int $id, bool $firstPrimary): array
    {
        $result = ['uploaded' => 0, 'errors' => []];
        if (empty($_FILES['images']['name'])) {
            return $result;
        }

        $files = $_FILES['images'];
        $names = is_array($files['name']) ? $files['name'] : [$files['name']];
        $count = count($names);

        for ($i = 0; $i < $count; $i++) {
            if (empty($names[$i])) {
                continue;
            }
            $error = null;
            $path = upload_image([
                'name' => is_array($files['name']) ? $files['name'][$i] : $files['name'],
                'type' => is_array($files['type']) ? $files['type'][$i] : $files['type'],
                'tmp_name' => is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'],
                'error' => is_array($files['error']) ? $files['error'][$i] : $files['error'],
                'size' => is_array($files['size']) ? $files['size'][$i] : $files['size'],
            ], 'products', $error);
            if ($path) {
                $model->addImage($id, $path, $firstPrimary && $result['uploaded'] === 0);
                $result['uploaded']++;
            } elseif ($error) {
                $result['errors'][] = $names[$i] . ' — ' . $error;
            }
        }

        return $result;
    }
}
