<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(): void
    {
        $this->adminView('faqs/index', [
            'faqs' => (new Faq())->getAllAdmin(),
        ]);
    }

    public function delete(string $id): void
    {
        $db = \App\Core\Database::getInstance();
        $db->prepare('DELETE FROM faqs WHERE id = ?')->execute([(int)$id]);
        $this->redirect(rtrim($this->config['url'], '/') . '/admin/faqs');
    }
}
