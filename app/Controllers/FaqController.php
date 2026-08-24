<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(): void
    {
        $faqs = (new Faq())->getAll($this->lang);

        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [],
        ];
        foreach ($faqs as $faq) {
            $faqSchema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ];
        }

        $this->view('faq/index', [
            'seo' => $this->setSeo([
                'title' => 'FAQ | Pioneer Emery Stones',
                'description' => 'Frequently asked questions about emery stones, sizes, maintenance and bulk orders.',
                'canonical' => url($this->lang, 'faq'),
            ]),
            'faqs' => $faqs,
            'faqSchema' => json_encode($faqSchema, JSON_UNESCAPED_UNICODE),
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['faq']],
            ],
        ]);
    }
}
