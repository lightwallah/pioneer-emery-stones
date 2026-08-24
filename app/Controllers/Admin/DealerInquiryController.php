<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\DealerInquiry;

class DealerInquiryController extends Controller
{
    public function index(): void
    {
        $this->adminView('dealer-inquiries/index', [
            'inquiries' => (new DealerInquiry())->getAll(),
        ]);
    }

    public function show(string $id): void
    {
        $inquiry = (new DealerInquiry())->find((int)$id);
        $this->adminView('dealer-inquiries/view', ['inquiry' => $inquiry]);
    }

    public function delete(string $id): void
    {
        (new DealerInquiry())->delete((int)$id);
        $this->redirect(rtrim($this->config['url'], '/') . '/admin/dealer-inquiries');
    }
}
