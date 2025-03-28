<?php

session_start();
require_once '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'E-posta veya şifre hatalı.';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Admin Giriş</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="w-full max-w-sm bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold text-center mb-6">Admin Panel Girişi</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">E-posta</label>
        <input type="email" name="email" required class="w-full border border-gray-300 p-2 rounded mt-1" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Şifre</label>
        <input type="password" name="password" required class="w-full border border-gray-300 p-2 rounded mt-1" />
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
        Giriş Yap
      </button>
    </form>
  </div>

</body>
</html>
