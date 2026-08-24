<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DealerInquiry;
use App\Models\Setting;

class DealerController extends Controller
{
    public function index(): void
    {
        $success = $_SESSION['dealer_success'] ?? false;
        unset($_SESSION['dealer_success']);

        $this->view('dealer/index', [
            'seo' => $this->setSeo([
                'title' => 'Dealer / Distributor Inquiry | Pioneer Emery Stones',
                'description' => 'Become a Pioneer Emery Stones dealer or distributor. Submit your inquiry today.',
                'canonical' => url($this->lang, 'dealer-inquiry'),
            ]),
            'settings' => (new Setting())->getAll(),
            'success' => $success,
            'csrf' => $this->csrfToken(),
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['dealer_inquiry']],
            ],
        ]);
    }

    public function submit(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect(url($this->lang, 'dealer-inquiry'));
            return;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'company_name' => trim($_POST['company_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'state' => trim($_POST['state'] ?? ''),
            'business_type' => trim($_POST['business_type'] ?? ''),
            'annual_requirement' => trim($_POST['annual_requirement'] ?? ''),
            'message' => trim($_POST['message'] ?? ''),
        ];

        if ($data['name'] && $data['company_name'] && $data['phone'] && $data['city'] && $data['state']) {
            (new DealerInquiry())->create($data);
            $_SESSION['dealer_success'] = true;
        }

        $this->redirect(url($this->lang, 'dealer-inquiry'));
    }
}
