<?php
session_start();
require_once '../includes/db.php';
require '../autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header('Location: login.php');
  exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
  $file = $_FILES['excel_file']['tmp_name'];

  try {
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    $pdo->beginTransaction();
    foreach ($rows as $index => $row) {
      if ($index === 0) continue; // Başlık satırını atla

      $name = trim($row[0]);
      $parent_id = is_numeric($row[1]) ? (int)$row[1] : null;

      if ($name !== '') {
        $stmt = $pdo->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        $stmt->execute([$name, $parent_id]);
      }
    }
    $pdo->commit();
    $message = 'Kategoriler başarıyla yüklendi.';
  } catch (Exception $e) {
    $pdo->rollBack();
    $message = 'Hata: ' . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Excel ile Kategori Yükle</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-2xl bg-white p-6 rounded shadow">
    <div class="mb-4 flex justify-between items-center">
      <h1 class="text-xl font-bold">📂 Excel ile Kategori Yükle</h1>
      <a href="dashboard.php" class="text-blue-600 hover:underline">← Admin Panel</a>
    </div>

    <?php if ($message): ?>
      <div class="<?= str_starts_with($message, 'Hata') ? 'bg-red-100 text-red-800 p-2 rounded mb-4' : 'bg-green-100 text-green-800 p-2 rounded mb-4' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="file" name="excel_file" accept=".xlsx,.xls" class="block w-full border p-2 rounded" required>
      <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded">Yükle ve Ekle</button>
    </form>

    <div class="mt-6 text-sm text-gray-600">
      <strong>Excel Formatı:</strong><br>
      <code>name | parent_id</code><br>
      İlk satır başlık olmalı. Her kategori bir satırda.
    </div>
  </div>

</body>
</html>