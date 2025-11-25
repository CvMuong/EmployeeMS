<?php
// app/views/employees/show.php
// expects: $emp (array)
?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Chi tiết nhân viên</h5>
    <div>
      <a href="?route=employees/index" class="btn btn-sm btn-secondary">Quay lại</a>
      <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="?route=employees/edit&id=<?= $emp['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="card-body">
    <div class="row">
      <div class="col-md-3 text-center">
        <?php if (!empty($emp['avatar'])): ?>
          <img src="<?= (getenv('APP_URL')?:'') . '/' . (getenv('UPLOAD_DIR')?:'uploads') . '/' . htmlspecialchars($emp['avatar']) ?>" class="img-thumbnail mb-2" style="max-width:200px;">
        <?php else: ?>
          <div class="bg-light p-5 rounded">No avatar</div>
        <?php endif; ?>
      </div>

      <div class="col-md-9">
        <table class="table table-borderless">
          <tr><th style="width:180px">Mã nhân viên</th><td><?= htmlspecialchars($emp['employee_code']) ?></td></tr>
          <tr><th>Họ và tên</th><td><?= htmlspecialchars($emp['fullname']) ?></td></tr>
          <tr><th>Email</th><td><?= htmlspecialchars($emp['email']) ?></td></tr>
          <tr><th>Phone</th><td><?= htmlspecialchars($emp['phone']) ?></td></tr>
          <tr><th>Giới tính</th><td><?= htmlspecialchars($emp['gender']) ?></td></tr>
          <tr><th>Ngày sinh</th><td><?= htmlspecialchars($emp['dob']) ?></td></tr>
          <tr><th>Phòng ban</th><td><?= htmlspecialchars($emp['department'] ?? $emp['department_id']) ?></td></tr>
          <tr><th>Chức vụ</th><td><?= htmlspecialchars($emp['position']) ?></td></tr>
          <tr><th>Ngày vào làm</th><td><?= htmlspecialchars($emp['start_date']) ?></td></tr>
          <tr><th>Lương</th><td><?= htmlspecialchars($emp['salary']) ?></td></tr>
          <tr><th>Ghi chú</th><td><?= nl2br(htmlspecialchars($emp['notes'])) ?></td></tr>
        </table>
      </div>
    </div>
  </div>
</div>
