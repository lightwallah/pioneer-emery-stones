<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\PageSeo;

class SeoController extends Controller
{
    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pageKey = $_POST['page_key'] ?? '';
            foreach (['en', 'hi'] as $lang) {
                (new PageSeo())->save($pageKey, $lang, [
                    'meta_title' => $_POST["meta_title_{$lang}"] ?? '',
                    'meta_description' => $_POST["meta_description_{$lang}"] ?? '',
                    'meta_keywords' => $_POST["meta_keywords_{$lang}"] ?? '',
                    'og_title' => $_POST["og_title_{$lang}"] ?? '',
                    'og_description' => $_POST["og_description_{$lang}"] ?? '',
                ]);
            }
            $_SESSION['seo_saved'] = true;
        }

        $allSeo = (new PageSeo())->getAll();
        $seoByPage = [];
        foreach ($allSeo as $row) {
            $seoByPage[$row['page_key']][$row['lang']] = $row;
        }

        $this->adminView('seo/index', [
            'seoByPage' => $seoByPage,
            'saved' => $_SESSION['seo_saved'] ?? false,
        ]);
        unset($_SESSION['seo_saved']);
    }
}
