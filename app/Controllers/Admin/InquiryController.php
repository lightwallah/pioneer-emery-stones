<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function index(): void
    {
        $this->adminView('inquiries/index', [
            'inquiries' => (new Inquiry())->getAll(),
        ]);
    }

    public function show(string $id): void
    {
        $inquiry = (new Inquiry())->find((int)$id);
        $this->adminView('inquiries/view', ['inquiry' => $inquiry]);
    }

    public function delete(string $id): void
    {
        (new Inquiry())->delete((int)$id);
        $this->redirect(rtrim($this->config['url'], '/') . '/admin/inquiries');
    }
}
