<?php
class AuthController {
    public function showLogin() {
        View::render('auth/login', ['flash'=>Middleware::flash()]);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: ?route=login"); exit; }
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['flash'] = ['type'=>'danger','msg'=>'CSRF token invalid'];
            header("Location: ?route=login"); exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = User::findByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = ['type'=>'danger','msg'=>'Sai username/mật khẩu'];
            header("Location: ?route=login"); exit;
        }

        $_SESSION['user'] = ['id'=>$user['id'],'username'=>$user['username'],'role'=>$user['role'],'employee_id'=>$user['employee_id']];
        header("Location: ?route=employees/index"); exit;
    }

    public function logout() {
        session_destroy();
        header("Location: ?route=login"); exit;
    }
}
