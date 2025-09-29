<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login');
    }

    public function login(): void
    {
        $this->csrfCheck();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', ['error' => 'Invalid credentials']);
            return;
        }
        Session::regenerate();
        Session::put('user_id', (int)$user['id']);
        Session::put('user_role', $user['role']);
        $this->redirect('/');
    }

    public function showRegister(): void
    {
        $this->view('auth/register');
    }

    public function register(): void
    {
        $this->csrfCheck();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirmation'] ?? '';

        if ($name === '' || $email === '' || $password === '' || $password !== $confirm) {
            $this->view('auth/register', ['error' => 'Invalid input or passwords do not match']);
            return;
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $this->view('auth/register', ['error' => 'Email already in use']);
            return;
        }

        $id = $userModel->create($name, $email, $password);
        Session::regenerate();
        Session::put('user_id', $id);
        Session::put('user_role', 'user');
        $this->redirect('/');
    }

    public function logout(): void
    {
        Session::forget('user_id');
        Session::forget('user_role');
        Session::regenerate();
        $this->redirect('/');
    }
}


