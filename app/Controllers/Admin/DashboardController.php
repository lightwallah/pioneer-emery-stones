<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Blog;
use App\Models\DealerInquiry;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->adminView('dashboard/index', [
            'stats' => [
                'products' => (new Product())->count(),
                'inquiries' => (new Inquiry())->count(),
                'dealer_inquiries' => (new DealerInquiry())->count(),
                'blogs' => (new Blog())->count(),
                'testimonials' => (new Testimonial())->count(),
                'unread_inquiries' => (new Inquiry())->countUnread(),
                'unread_dealer' => (new DealerInquiry())->countUnread(),
            ],
        ]);
    }
}
