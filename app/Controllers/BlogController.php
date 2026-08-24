<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $blogs = (new Blog())->getAll($this->lang, $page);

        $this->view('blog/index', [
            'seo' => $this->setSeo([
                'title' => 'Blog | Pioneer Emery Stones',
                'description' => 'Tips on emery stones, flour mill maintenance, and business guides.',
                'canonical' => url($this->lang, 'blog'),
            ]),
            'blogs' => $blogs,
            'page' => $page,
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['blog']],
            ],
        ]);
    }

    public function show(string $slug): void
    {
        $blogModel = new Blog();
        $blog = $blogModel->findBySlug($slug, $this->lang);
        if (!$blog) {
            (new HomeController())->notFound();
            return;
        }

        $this->view('blog/show', [
            'seo' => $this->setSeo([
                'title' => $blog['meta_title'] ?? $blog['title'],
                'description' => $blog['meta_description'] ?? $blog['excerpt'],
                'canonical' => url($this->lang, 'blog/' . $slug),
            ]),
            'blog' => $blog,
            'tags' => $blogModel->getTags($blog['id']),
            'related' => $blogModel->getRelated($blog['id'], $blog['category_id'], $this->lang),
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['blog'], 'url' => url($this->lang, 'blog')],
                ['name' => $blog['title']],
            ],
            'articleSchema' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $blog['title'],
                'description' => $blog['excerpt'],
                'author' => ['@type' => 'Person', 'name' => $blog['author']],
                'datePublished' => $blog['published_at'],
            ], JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function search(): void
    {
        $query = trim($_GET['q'] ?? '');
        $blogs = $query ? (new Blog())->search($query, $this->lang) : [];

        $this->view('blog/search', [
            'seo' => $this->setSeo(['title' => 'Search Blog | Pioneer Emery Stones']),
            'blogs' => $blogs,
            'query' => $query,
        ]);
    }
}
