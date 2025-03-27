<?php
session_start();
require_once '../includes/db.php';
require_once '../autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Giriş kontrolü
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // İlk satır başlık satırıysa atla
        unset($rows[0]);

        $stmt = $pdo->prepare("INSERT INTO videos (title, vimeo_url, category_id) VALUES (?, ?, ?)");

        foreach ($rows as $row) {
            $title = $row[0] ?? '';
            $vimeo_url = $row[1] ?? '';
            $category_id = $row[2] ?? null;

            if ($title && $vimeo_url && $category_id) {
                $stmt->execute([$title, $vimeo_url, $category_id]);
            }
        }

        $success = "Excel dosyasındaki videolar başarıyla eklendi.";

    } catch (Exception $e) {
        $error = "Hata: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Excel ile Video Yükle</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold">Excel ile Toplu Video Ekle</h2>
      <a href="dashboard.php" class="text-blue-600 hover:underline">← Admin Panel</a>
    </div>

    <?php if ($success): ?>
      <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="file" name="excel_file" accept=".xls,.xlsx" required class="border p-2 rounded w-full">
      <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
        Yükle ve Ekle
      </button>
    </form>

    <div class="mt-6 text-sm text-gray-500">
      <strong>Excel Formatı:</strong><br>
      <code>Başlık | Vimeo Linki | Kategori ID</code><br>
      Her video bir satırda olmalıdır.
    </div>
  </div>
</body>
</html>
