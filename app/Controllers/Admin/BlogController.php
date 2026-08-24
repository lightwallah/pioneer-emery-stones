<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(): void
    {
        $this->adminView('blogs/index', [
            'blogs' => (new Blog())->getAllAdmin(),
        ]);
    }

    public function delete(string $id): void
    {
        $db = \App\Core\Database::getInstance();
        $db->prepare('DELETE FROM blogs WHERE id = ?')->execute([(int)$id]);
        $this->redirect(rtrim($this->config['url'], '/') . '/admin/blogs');
    }
}
