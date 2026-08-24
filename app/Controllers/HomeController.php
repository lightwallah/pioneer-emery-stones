<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\PageSeo;
use App\Models\ProcessStep;
use App\Models\Setting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index(): void
    {
        $seoModel = new PageSeo();
        $pageSeo = $seoModel->get('home', $this->lang);

        $processModel = new ProcessStep();

        $this->view('home/index', [
            'seo' => $this->setSeo([
                'title' => $pageSeo['meta_title'] ?? 'Pioneer Emery Stones',
                'description' => $pageSeo['meta_description'] ?? '',
                'keywords' => $pageSeo['meta_keywords'] ?? '',
                'canonical' => url($this->lang),
            ]),
            'banners' => (new Banner())->getActive($this->lang),
            'processSteps' => $processModel->getDisplaySteps($this->lang, $this->translations),
            'processSection' => $processModel->getSectionForLang($this->lang, $this->translations),
            'stoneCategories' => (new Category())->getStoneTypesForHome($this->lang),
            'categories' => (new Category())->getAll($this->lang),
            'testimonials' => (new Testimonial())->getAll($this->lang, 6),
            'latestBlogs' => (new Blog())->getLatest($this->lang, 3),
            'settings' => (new Setting())->getAll(),
        ]);
    }

    public function notFound(): void
    {
        http_response_code(404);
        $this->view('errors/404', [
            'seo' => $this->setSeo(['title' => 'Page Not Found']),
        ]);
    }
}
