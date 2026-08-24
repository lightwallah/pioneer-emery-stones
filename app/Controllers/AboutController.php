<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\PageSeo;
use App\Models\Setting;

class AboutController extends Controller
{
    public function index(): void
    {
        $pageSeo = (new PageSeo())->get('about', $this->lang);

        $this->view('about/index', [
            'seo' => $this->setSeo([
                'title' => $pageSeo['meta_title'] ?? 'About Us - Pioneer Emery Stones',
                'description' => $pageSeo['meta_description'] ?? '',
                'canonical' => url($this->lang, 'about'),
            ]),
            'settings' => (new Setting())->getAll(),
        ]);
    }
}
