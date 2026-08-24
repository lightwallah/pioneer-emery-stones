<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin;

class AuthController extends Controller
{
    public function login(): void
    {
        if (isset($_SESSION['admin_id'])) {
            $this->redirect(rtrim($this->config['url'], '/') . '/admin/dashboard');
            return;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $admin = (new Admin())->findByUsername($username);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $this->redirect(rtrim($this->config['url'], '/') . '/admin/dashboard');
                return;
            }
            $error = 'Invalid username or password';
        }

        $error = $error;
        $baseUrl = rtrim($this->config['url'], '/');
        require dirname(__DIR__, 2) . '/Views/admin/auth/login.php';
    }

    public function logout(): void
    {
        unset($_SESSION['admin_id'], $_SESSION['admin_name']);
        $this->redirect(rtrim($this->config['url'], '/') . '/admin/login');
    }
}
