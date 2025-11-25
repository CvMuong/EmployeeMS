<div class="d-flex justify-content-between mb-3">
  <form class="d-flex" method="GET">
    <input type="hidden" name="route" value="employees/index">
    <input class="form-control me-2" name="keyword" placeholder="Tìm kiếm..." value="<?=htmlspecialchars($keyword)?>">
    <button class="btn btn-outline-secondary">Tìm</button>
  </form>
  <?php if($_SESSION['user']['role']==='admin'): ?>
    <a class="btn btn-success" href="?route=employees/create">+ Thêm nhân viên</a>
  <?php endif; ?>
</div>

<table class="table table-bordered table-hover align-middle">
  <thead class="table-light">
    <tr>
      <th>#</th><th>Avatar</th><th>Mã</th><th>Họ tên</th><th>Email</th><th>Phone</th><th>Phòng ban</th><th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($employees as $e): ?>
      <tr>
        <td><?= $e['id'] ?></td>
        <td>
          <?php if($e['avatar']): ?>
            <img src="<?= (getenv('APP_URL')?:'') . '/' . (getenv('UPLOAD_DIR')?:'uploads') . '/' . $e['avatar'] ?>" width="50" class="rounded">
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($e['employee_code']) ?></td>
        <td><?= htmlspecialchars($e['fullname']) ?></td>
        <td><?= htmlspecialchars($e['email']) ?></td>
        <td><?= htmlspecialchars($e['phone']) ?></td>
        <td><?= htmlspecialchars($e['department']) ?></td>
        <td>
          <a class="btn btn-sm btn-info" href="?route=employees/show&id=<?= $e['id'] ?>">Xem</a>
          <?php if($_SESSION['user']['role']==='admin'): ?>
            <a class="btn btn-sm btn-warning" href="?route=employees/edit&id=<?= $e['id'] ?>">Sửa</a>
            <form style="display:inline" method="POST" action="?route=employees/delete" onsubmit="return confirm('Xóa?')">
              <?= csrf_field() ?>
              <input type="hidden" name="id" value="<?= $e['id'] ?>">
              <button class="btn btn-sm btn-danger">Xóa</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<nav>
  <ul class="pagination">
    <?php for($i=1;$i<=$totalPages;$i++): ?>
      <li class="page-item <?= $i==$page ? 'active' : '' ?>">
        <a class="page-link" href="?route=employees/index&page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
