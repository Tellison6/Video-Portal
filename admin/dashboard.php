<?php

session_start();

 //Giriş kontrolü
 if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
     exit;
 }

 $admin = $_SESSION['admin_user'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Hoş geldin, <?= htmlspecialchars($admin['name']) ?></h1>
      <a href="logout.php" class="text-sm bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Çıkış Yap</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <a href="users.php" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded text-center font-semibold">Kullanıcıları Yönet</a>
      <a href="categories.php" class="bg-red-500 hover:bg-red-600 text-white p-4 rounded text-center font-semibold">Kategorileri Yönet</a>
      <a href="videos.php" class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded text-center font-semibold">Videoları Yönet</a>
      <a href="excel_yukle.php" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded text-center font-semibold">Excel ile Toplu Video Ekle</a>
      <a href="kategori_yukle.php" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded text-center font-semibold">Excel ile Toplu kategori Ekle</a>

    </div>
  </div>

</body>
</html>
