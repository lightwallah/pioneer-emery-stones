<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;

class SeoController extends Controller
{
    public function sitemap(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $config = app_config();
        $base = rtrim($config['url'], '/');
        $langs = $config['languages'];

        $urls = [];
        $staticPages = ['', 'about', 'products', 'blog', 'faq', 'contact', 'dealer-inquiry', 'compare'];

        foreach ($langs as $lang) {
            foreach ($staticPages as $page) {
                $urls[] = ['loc' => $page ? "{$base}/{$lang}/{$page}" : "{$base}/{$lang}", 'priority' => $page === '' ? '1.0' : '0.8'];
            }
        }

        $categories = (new Category())->getAll('en');
        foreach ($categories as $cat) {
            foreach ($langs as $lang) {
                $urls[] = ['loc' => "{$base}/{$lang}/products/{$cat['slug']}", 'priority' => '0.7'];
            }
        }

        $products = (new Product())->getAll('en');
        foreach ($products as $prod) {
            foreach ($langs as $lang) {
                $urls[] = ['loc' => "{$base}/{$lang}/product/{$prod['slug']}", 'priority' => '0.9'];
            }
        }

        $blogs = (new Blog())->getAll('en', 1, 1000);
        foreach ($blogs as $blog) {
            foreach ($langs as $lang) {
                $urls[] = ['loc' => "{$base}/{$lang}/blog/{$blog['slug']}", 'priority' => '0.6'];
            }
        }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $url) {
            echo "  <url><loc>{$url['loc']}</loc><priority>{$url['priority']}</priority></url>\n";
        }
        echo '</urlset>';
        exit;
    }
}
