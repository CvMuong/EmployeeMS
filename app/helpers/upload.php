<?php
function handleUpload($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Upload lỗi');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    ];

    if (!isset($allowed[$mime])) {
        throw new Exception('File không phù hợp');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new Exception('Kích thước vượt quá 2MB');
    } 

    $ext = $allowed[$mime];
    $name = uniqid('img_', true) . '.' . $ext;

    $target = __DIR__ . '/../../public/uploads/' . $name;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new Exception('Không thể lưu file');
    }

    return $name;
}
?>