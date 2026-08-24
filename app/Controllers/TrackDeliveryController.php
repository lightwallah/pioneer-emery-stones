<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;

class TrackDeliveryController extends Controller
{
    public function index(): void
    {
        $settings = (new Setting())->getAll();
        $trackBaseUrl = trim($settings['track_delivery_url'] ?? '');
        $trackingId = trim($_GET['id'] ?? '');
        $error = $_SESSION['track_error'] ?? '';
        unset($_SESSION['track_error']);

        $redirectUrl = '';
        if ($trackingId && $trackBaseUrl) {
            $redirectUrl = $this->buildTrackingUrl($trackBaseUrl, $trackingId);
        }

        $this->view('track-delivery/index', [
            'seo' => $this->setSeo([
                'title' => $this->translations['track_delivery'] . ' | Pioneer Emery Stones',
                'description' => $this->translations['track_delivery_desc'] ?? 'Track your emery stone delivery order status.',
                'canonical' => url($this->lang, 'track-delivery'),
            ]),
            'settings' => $settings,
            'trackBaseUrl' => $trackBaseUrl,
            'trackingId' => $trackingId,
            'redirectUrl' => $redirectUrl,
            'error' => $error,
            'breadcrumbs' => [
                ['name' => $this->translations['home'], 'url' => url($this->lang)],
                ['name' => $this->translations['track_delivery']],
            ],
        ]);
    }

    public function submit(): void
    {
        $settings = (new Setting())->getAll();
        $trackBaseUrl = trim($settings['track_delivery_url'] ?? '');
        $trackingId = trim($_POST['tracking_id'] ?? '');

        if (!$trackingId) {
            $_SESSION['track_error'] = $this->translations['track_id_required'] ?? 'Please enter your tracking number.';
            $this->redirect(url($this->lang, 'track-delivery'));
            return;
        }

        if (!$trackBaseUrl) {
            $_SESSION['track_error'] = $this->translations['track_url_not_set'] ?? 'Tracking portal is not configured yet. Please contact us.';
            $this->redirect(url($this->lang, 'track-delivery'));
            return;
        }

        $this->redirect($this->buildTrackingUrl($trackBaseUrl, $trackingId));
    }

    private function buildTrackingUrl(string $baseUrl, string $trackingId): string
    {
        $trackingId = rawurlencode($trackingId);

        if (str_contains($baseUrl, '{id}')) {
            return str_replace('{id}', $trackingId, $baseUrl);
        }

        if (str_ends_with($baseUrl, '=') || str_ends_with($baseUrl, '/')) {
            return $baseUrl . $trackingId;
        }

        $separator = str_contains($baseUrl, '?') ? '&' : '?';
        return $baseUrl . $separator . 'id=' . $trackingId;
    }
}
