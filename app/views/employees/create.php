<?php
// app/views/employees/create.php
// expects: $errors (array), $old (array)
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Thêm nhân viên</h5>
        <a href="?route=employees/index" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $f => $m): ?>
                        <li><?= htmlspecialchars($m) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" novalidate>
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Mã nhân viên <span class="text-danger">*</span></label>
                    <input name="employee_code" class="form-control" required
                        value="<?= htmlspecialchars($old['employee_code'] ?? '') ?>">
                </div>

                <div class="col-md-8">
                    <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input name="fullname" class="form-control" required
                        value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Số điện thoại</label>
                    <input name="phone" class="form-control" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <?php $g = $old['gender'] ?? 'other'; ?>
                        <option value="male" <?= $g === 'male' ? 'selected' : '' ?>>Nam</option>
                        <option value="female" <?= $g === 'female' ? 'selected' : '' ?>>Nữ</option>
                        <option value="other" <?= $g === 'other' ? 'selected' : '' ?>>Khác</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ngày sinh</label>
                    <input name="dob" class="form-control" type="date" value="<?= htmlspecialchars($old['dob'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Phòng ban</label>
                    <select name="department_id" class="form-select">
                        <option value="">-- Chọn phòng ban --</option>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?= $d['id'] ?>"
                                <?= (($old['department_id'] ?? '') == $d['id'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($d['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Chức vụ</label>
                    <input name="position" class="form-control" value="<?= htmlspecialchars($old['position'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Ngày vào làm</label>
                    <input name="start_date" type="date" class="form-control" value="<?= htmlspecialchars($old['start_date'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Lương</label>
                    <input name="salary" type="number" step="0.01" class="form-control" value="<?= htmlspecialchars($old['salary'] ?? '') ?>">
                </div>

                <div class="col-md-8">
                    <label class="form-label">Ghi chú</label>
                    <input name="notes" class="form-control" value="<?= htmlspecialchars($old['notes'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ảnh đại diện (JPG/PNG/WebP, ≤2MB)</label>
                    <input name="avatar" type="file" accept="image/*" class="form-control">
                    <?php if (!empty($errors['avatar'])): ?>
                        <small class="text-danger"><?= htmlspecialchars($errors['avatar']) ?></small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Lưu</button>
                <a href="?route=employees/index" class="btn btn-light">Hủy</a>
            </div>
        </form>
    </div>
</div>