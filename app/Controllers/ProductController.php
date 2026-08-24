<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): void
    {
        $categories = (new Category())->getAll($this->lang);
        $products = (new Product())->getAll($this->lang);

        $this->view('products/index', [
            'seo' => $this->setSeo([
                'title' => 'Emery Stone Products | Pioneer Emery Stones',
                'description' => 'Browse Natraj, Surabhi, Ravi & Savaliya emery stones for flour mills.',
                'canonical' => url($this->lang, 'products'),
            ]),
            'categories' => $categories,
            'products' => $products,
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['products']],
            ],
        ]);
    }

    public function category(string $slug): void
    {
        $category = (new Category())->findBySlug($slug, $this->lang);
        if (!$category) {
            (new HomeController())->notFound();
            return;
        }

        $products = (new Product())->getAll($this->lang, $category['id']);

        $this->view('products/category', [
            'seo' => $this->setSeo([
                'title' => $category['meta_title'] ?? $category['name'],
                'description' => $category['meta_description'] ?? '',
                'canonical' => url($this->lang, 'products/' . $slug),
            ]),
            'category' => $category,
            'products' => $products,
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['products'], 'url' => url($this->lang, 'products')],
                ['name' => $category['name']],
            ],
        ]);
    }

    public function show(string $slug): void
    {
        $productModel = new Product();
        $product = $productModel->findBySlug($slug, $this->lang);
        if (!$product) {
            (new HomeController())->notFound();
            return;
        }

        $this->view('products/show', [
            'seo' => $this->setSeo([
                'title' => $product['meta_title'] ?? $product['name'],
                'description' => $product['meta_description'] ?? $product['short_description'],
                'canonical' => url($this->lang, 'product/' . $slug),
            ]),
            'product' => $product,
            'images' => $productModel->getImages($product['id']),
            'sizes' => $productModel->getSizes($product['id']),
            'specs' => $productModel->getSpecs($product['id'], $this->lang),
            'related' => $productModel->getRelated($product['id'], $product['category_id'], $this->lang),
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['products'], 'url' => url($this->lang, 'products')],
                ['name' => $product['category_name'], 'url' => url($this->lang, 'products/' . $product['category_slug'])],
                ['name' => $product['name']],
            ],
            'productSchema' => $this->productSchema($product),
        ]);
    }

    private function productSchema(array $product): string
    {
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'],
            'description' => $product['short_description'],
            'brand' => ['@type' => 'Brand', 'name' => 'Pioneer Emery Stones'],
            'manufacturer' => ['@type' => 'Organization', 'name' => 'Pioneer Emery Stones'],
            'url' => url($this->lang, 'product/' . $product['slug']),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
