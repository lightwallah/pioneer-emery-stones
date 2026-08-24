<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index(): void
    {
        $this->adminView('testimonials/index', [
            'testimonials' => (new Testimonial())->getAllAdmin(),
        ]);
    }

    public function delete(string $id): void
    {
        $db = \App\Core\Database::getInstance();
        $db->prepare('DELETE FROM testimonials WHERE id = ?')->execute([(int)$id]);
        $this->redirect(rtrim($this->config['url'], '/') . '/admin/testimonials');
    }
}
