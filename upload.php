<?php
$fileName = trim($_POST['file_name'] ?? '');
$fileName = basename($fileName);

if ($fileName === '') {
    header('Location: index.html');
    exit;
}

if (!isset($_FILES['content']) || $_FILES['content']['error'] !== UPLOAD_ERR_OK) {
    header('Location: index.html');
    exit;
}

if (pathinfo($fileName, PATHINFO_EXTENSION) === '') {
    $originalName = $_FILES['content']['name'];
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    if ($extension !== '') {
        $fileName .= '.' . $extension;
    }
}

if (!is_dir('upload')) {
    mkdir('upload', 0755, true);
}

$targetPath = 'upload/' . $fileName;
if (move_uploaded_file($_FILES['content']['tmp_name'], $targetPath)) {
    $fullPath = realpath($targetPath);
    $fileSize = filesize($fullPath);
    echo "Файл сохранён: $fullPath" . PHP_EOL;
    echo "Размер: $fileSize байт" . PHP_EOL;
} else {
    echo "Ошибка при сохранении файла" . PHP_EOL;
}
