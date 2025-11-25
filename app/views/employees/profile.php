<?php
// app/views/employees/profile.php
// expects: $emp (array) — can be null
?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Hồ sơ của tôi</h5>
    <a href="?route=employees/index" class="btn btn-sm btn-secondary">Danh sách</a>
  </div>

  <div class="card-body">
    <?php if (!$emp): ?>
      <div class="alert alert-warning">Chưa liên kết thông tin nhân viên với tài khoản của bạn.</div>
      <?php return; ?>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-3 text-center">
        <?php if (!empty($emp['avatar'])): ?>
          <img src="<?= (getenv('APP_URL')?:'') . '/' . (getenv('UPLOAD_DIR')?:'uploads') . '/' . htmlspecialchars($emp['avatar']) ?>" class="img-thumbnail mb-2" style="max-width:200px;">
        <?php else: ?>
          <div class="bg-light p-5 rounded">No avatar</div>
        <?php endif; ?>
        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
          <div class="mt-2"><a class="btn btn-sm btn-outline-primary" href="?route=employees/edit&id=<?= $emp['id'] ?>">Sửa</a></div>
        <?php endif; ?>
      </div>

      <div class="col-md-9">
        <table class="table table-borderless">
          <tr><th style="width:180px">Mã nhân viên</th><td><?= htmlspecialchars($emp['employee_code']) ?></td></tr>
          <tr><th>Họ và tên</th><td><?= htmlspecialchars($emp['fullname']) ?></td></tr>
          <tr><th>Email</th><td><?= htmlspecialchars($emp['email']) ?></td></tr>
          <tr><th>Phone</th><td><?= htmlspecialchars($emp['phone']) ?></td></tr>
          <tr><th>Phòng ban</th><td><?= htmlspecialchars($emp['department'] ?? $emp['department_id']) ?></td></tr>
          <tr><th>Vị trí</th><td><?= htmlspecialchars($emp['position']) ?></td></tr>
          <tr><th>Ngày vào làm</th><td><?= htmlspecialchars($emp['start_date']) ?></td></tr>
          <tr><th>Lương</th><td><?= htmlspecialchars($emp['salary']) ?></td></tr>
        </table>
      </div>
    </div>
  </div>
</div>
