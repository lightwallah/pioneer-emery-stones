<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin as AdminModel;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(): void
    {
        $settingModel = new Setting();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->verifyCsrf()) {
                $this->redirect(rtrim($this->config['url'], '/') . '/admin/settings');
                return;
            }
            $action = $_POST['action'] ?? 'settings';

            if ($action === 'password') {
                $newPass = $_POST['new_password'] ?? '';
                $confirm = $_POST['confirm_password'] ?? '';
                if ($newPass && $newPass === $confirm && strlen($newPass) >= 6) {
                    (new AdminModel())->updatePassword($_SESSION['admin_id'], $newPass);
                    $_SESSION['settings_saved'] = 'Password updated successfully';
                }
            } else {
                $keys = [
                    'site_name', 'phone', 'phone_secondary', 'contact_person', 'gst_number',
                    'email', 'whatsapp_number', 'address', 'track_delivery_url',
                    'google_map_embed', 'google_analytics', 'google_search_console',
                    'years_experience', 'facebook_url', 'instagram_url',
                ];
                foreach ($keys as $key) {
                    if (isset($_POST[$key])) {
                        $value = $key === 'track_delivery_url' ? trim($_POST[$key]) : $_POST[$key];
                        $settingModel->set($key, $value);
                    }
                }

                foreach (['site_logo', 'hero_image'] as $imgKey) {
                    if (!empty($_FILES[$imgKey]['name'])) {
                        $path = upload_image($_FILES[$imgKey], 'settings');
                        if ($path) {
                            $old = $settingModel->get($imgKey);
                            if ($old) {
                                delete_upload($old);
                            }
                            $settingModel->set($imgKey, $path);
                        }
                    }
                }

                $_SESSION['settings_saved'] = 'Settings saved successfully';
            }
        }

        $this->adminView('settings/index', [
            'settings' => $settingModel->getAll(),
            'saved' => $_SESSION['settings_saved'] ?? false,
            'csrf' => $this->csrfToken(),
        ]);
        unset($_SESSION['settings_saved']);
    }
}
