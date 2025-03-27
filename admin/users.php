<?php
session_start();
require_once '../includes/db.php';

// Giriş kontrolü
 if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
     header('Location: index.php');
     exit;
 }

// Yeni kullanıcı ekleme
$add_error = '';
$add_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($name && $email && $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admin_users (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $hashed]);
            $add_success = "Kullanıcı başarıyla eklendi.";
        } catch (PDOException $e) {
            $add_error = "Hata: " . $e->getMessage();
        }
    } else {
        $add_error = "Tüm alanlar doldurulmalı.";
    }
}

// Kullanıcı silme
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM admin_users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: users.php");
    exit;
}

// Kullanıcıları çek
$users = $pdo->query("SELECT * FROM admin_users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Kullanıcı Yönetimi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold">Admin Kullanıcıları</h2>
      <a href="dashboard.php" class="text-blue-600 hover:underline">← Admin Panel</a>
    </div>

    <?php if ($add_error): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $add_error ?></div>
    <?php endif; ?>
    <?php if ($add_success): ?>
      <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $add_success ?></div>
    <?php endif; ?>

    <!-- Yeni Kullanıcı Ekle -->
    <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <input type="hidden" name="add_user" value="1">
      <input type="text" name="name" placeholder="Ad Soyad" required class="border p-2 rounded">
      <input type="email" name="email" placeholder="E-posta" required class="border p-2 rounded">
      <input type="password" name="password" placeholder="Şifre" required class="border p-2 rounded">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2">Ekle</button>
    </form>

    <!-- Kullanıcı Listesi -->
    <table class="w-full border">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">Ad Soyad</th>
          <th class="p-2">E-posta</th>
          <th class="p-2">Oluşturulma</th>
          <th class="p-2">İşlem</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <tr class="border-t">
            <td class="p-2"><?= htmlspecialchars($user['name']) ?></td>
            <td class="p-2"><?= htmlspecialchars($user['email']) ?></td>
            <td class="p-2"><?= $user['created_at'] ?></td>
            <td class="p-2">
              <a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')" class="text-red-600 hover:underline">Sil</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
