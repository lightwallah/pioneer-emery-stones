<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class CompareController extends Controller
{
    public function index(): void
    {
        $ids = $_SESSION['compare'] ?? [];
        $products = (new Product())->getByIds($ids, $this->lang);

        $this->view('compare/index', [
            'seo' => $this->setSeo([
                'title' => 'Compare Emery Stones | Pioneer Emery Stones',
                'description' => 'Compare emery stone products, sizes, specifications and applications.',
                'canonical' => url($this->lang, 'compare'),
            ]),
            'products' => $products,
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['compare']],
            ],
        ]);
    }

    public function add(): void
    {
        $id = (int)($_POST['product_id'] ?? 0);
        $max = $this->config['compare_max'];

        if (!isset($_SESSION['compare'])) {
            $_SESSION['compare'] = [];
        }

        if ($id && !in_array($id, $_SESSION['compare']) && count($_SESSION['compare']) < $max) {
            $_SESSION['compare'][] = $id;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->json(['success' => true, 'count' => count($_SESSION['compare'])]);
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? url($this->lang, 'products');
        $this->redirect($referer);
    }

    public function remove(): void
    {
        $id = (int)($_POST['product_id'] ?? 0);
        if (isset($_SESSION['compare'])) {
            $_SESSION['compare'] = array_values(array_filter($_SESSION['compare'], fn($i) => $i !== $id));
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->json(['success' => true, 'count' => count($_SESSION['compare'] ?? [])]);
        }

        $this->redirect(url($this->lang, 'compare'));
    }
}
