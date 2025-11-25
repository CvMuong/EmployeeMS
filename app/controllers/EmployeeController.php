<?php
class EmployeeController {
    public function __construct() {
        Middleware::requireLogin();
    }

    public function index() {
        $keyword = trim($_GET['keyword'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page-1)*$limit;

        // If you want users to see only their profile, comment below and use findByUserId
        // if ($_SESSION['user']['role'] === 'user') { ... }

        $employees = Employee::all($limit,$offset,$keyword);
        $total = Employee::countAll($keyword);
        $totalPages = max(1, ceil($total / $limit));
        View::render('employees/index', compact('employees','keyword','page','totalPages','total'));
    }

    public function create() {
        Middleware::requireRole('admin');
        $departments = Department::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf($_POST['csrf_token'] ?? '')) { $_SESSION['flash']=['type'=>'danger','msg'=>'CSRF invalid']; header("Location:?route=employees/create"); exit; }
            $v = new Validator();
            $v->validateRequired('employee_code', $_POST['employee_code'], 'Mã nhân viên bắt buộc');
            $v->validateRequired('fullname', $_POST['fullname'], 'Họ tên bắt buộc');
            $v->validateEmail('email', $_POST['email']);
            if ($v->hasErrors()) {
                View::render('employees/create', ['errors'=>$v->errors(), 'old'=>$_POST]);
                return;
            }
            $avatarName = null;
            if (!empty($_FILES['avatar']['name'])) {
                try { $avatarName = handleUpload($_FILES['avatar']); } catch (Exception $e) { $v->addError('avatar',$e->getMessage()); View::render('employees/create',['errors'=>$v->errors(),'old'=>$_POST]); return; }
            }
            Employee::create(array_merge($_POST, ['avatar'=>$avatarName]));
            $_SESSION['flash']=['type'=>'success','msg'=>'Thêm nhân viên thành công'];
            header("Location:?route=employees/index"); exit;
        }
        View::render('employees/create', [
            'errors'=>[],
            'old'=>[],
            'departments' => $departments
        ]);
    }

    public function edit() {
        Middleware::requireRole('admin');
        $departments = Department::all();
        $id = (int)($_GET['id'] ?? 0);
        $emp = Employee::find($id);
        if (!$emp) { $_SESSION['flash']=['type'=>'danger','msg'=>'Không tìm thấy nhân viên']; header("Location:?route=employees/index"); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf($_POST['csrf_token'] ?? '')) { $_SESSION['flash']=['type'=>'danger','msg'=>'CSRF invalid']; header("Location:?route=employees/edit&id={$id}"); exit; }
            $v = new Validator();
            $v->validateRequired('employee_code', $_POST['employee_code'], 'Mã NV bắt buộc');
            $v->validateRequired('fullname', $_POST['fullname'], 'Họ tên bắt buộc');
            $v->validateEmail('email', $_POST['email']);
            if ($v->hasErrors()) { View::render('employees/edit',['errors'=>$v->errors(),'old'=>$_POST,'emp'=>$emp]); return; }

            $avatarName = $emp['avatar'];
            if (!empty($_FILES['avatar']['name'])) {
                try {
                    $avatarName = handleUpload($_FILES['avatar']);
                    // optional: unlink old avatar
                    if ($emp['avatar']) {
                        @unlink(__DIR__ . '/../../public/' . (getenv('UPLOAD_DIR')?:'uploads') . '/' . $emp['avatar']);
                    }
                } catch (Exception $e) {
                    $v->addError('avatar',$e->getMessage());
                    View::render('employees/edit',['errors'=>$v->errors(),'old'=>$_POST,'emp'=>$emp]); return;
                }
            }

            Employee::update($id, array_merge($_POST,['avatar'=>$avatarName]));
            $_SESSION['flash']=['type'=>'success','msg'=>'Cập nhật thành công'];
            header("Location:?route=employees/index"); exit;
        }

        View::render('employees/edit',[
            'emp'=>$emp,
            'errors'=>[],
            'old'=>[],
            'departments' => $departments
        ]);
    }

    public function delete() {
        Middleware::requireRole('admin');
        $id = (int)($_POST['id'] ?? 0);
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { $_SESSION['flash']=['type'=>'danger','msg'=>'CSRF invalid']; header("Location:?route=employees/index"); exit; }
        Employee::softDelete($id);
        $_SESSION['flash']=['type'=>'success','msg'=>'Xóa thành công'];
        header("Location:?route=employees/index"); exit;
    }

    public function show() {
        $id = (int)($_GET['id'] ?? 0);
        $emp = Employee::find($id);
        if (!$emp) { $_SESSION['flash']=['type'=>'danger','msg'=>'Không tìm thấy']; header("Location:?route=employees/index"); exit; }
        View::render('employees/show',['emp'=>$emp]);
    }

    public function profile() {
        $userId = $_SESSION['user']['id'];
        $emp = Employee::findByUserId($userId);
        View::render('employees/profile',['emp'=>$emp]);
    }
}
