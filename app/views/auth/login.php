<?php
// $flash may be passed
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title mb-3">Đăng nhập</h4>
        <?php if(!empty($flash)): ?>
          <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['msg']) ?></div>
        <?php endif; ?>
        <form method="POST" action="?route=login/submit">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control" required>
          </div>
          <button class="btn btn-primary" type="submit">Đăng nhập</button>
        </form>
      </div>
    </div>
  </div>
</div>
