<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>EMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="?route=employees/index">EmployeeMS</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <?php if(isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="?route=employees/index">Nhân sự</a></li>
          <li class="nav-item"><a class="nav-link" href="?route=employees/profile">Hồ sơ</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if(isset($_SESSION['user'])): ?>
          <li class="nav-item"><span class="nav-link">Xin chào <?=htmlspecialchars($_SESSION['user']['username'])?> (<?=htmlspecialchars($_SESSION['user']['role'])?>)</span></li>
          <li class="nav-item"><a class="nav-link" href="?route=logout">Đăng xuất</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="?route=login">Đăng nhập</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-4">
    <?php if($flash = Middleware::flash()): ?>
      <div class="alert alert-<?= $flash['type'] ?? 'info' ?>"><?= htmlspecialchars($flash['msg']) ?></div>
    <?php endif; ?>

    <?php
      // load view content
      // $view variable expected by View::render is like 'employees/index' -> main loads that file
      if (!empty($view)) {
          require __DIR__ . "/../{$view}.php";
      } else {
          echo "<p>Không có view</p>";
      }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
