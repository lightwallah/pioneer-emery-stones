<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Inquiry;
use App\Models\PageSeo;
use App\Models\Setting;

class ContactController extends Controller
{
    public function index(): void
    {
        $pageSeo = (new PageSeo())->get('contact', $this->lang);
        $success = $_SESSION['contact_success'] ?? false;
        unset($_SESSION['contact_success']);

        $this->view('contact/index', [
            'seo' => $this->setSeo([
                'title' => $pageSeo['meta_title'] ?? 'Contact Us',
                'description' => $pageSeo['meta_description'] ?? '',
                'canonical' => url($this->lang, 'contact'),
            ]),
            'settings' => (new Setting())->getAll(),
            'success' => $success,
            'csrf' => $this->csrfToken(),
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['contact']],
            ],
        ]);
    }

    public function submit(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect(url($this->lang, 'contact'));
            return;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'subject' => trim($_POST['subject'] ?? ''),
            'message' => trim($_POST['message'] ?? ''),
        ];

        if ($data['name'] && $data['phone']) {
            (new Inquiry())->create($data);
            $_SESSION['contact_success'] = true;
        }

        $this->redirect(url($this->lang, 'contact'));
    }
}
