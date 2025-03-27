<?php
session_start();
require_once '../includes/db.php';

// Giriş kontrolü
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Yeni kategori ekleme
$add_error = '';
$add_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = $_POST['name'] ?? '';
    $parent_id = $_POST['parent_id'] ?? null;
    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        $stmt->execute([$name, $parent_id ?: null]);
        $add_success = "Kategori başarıyla eklendi.";
    } else {
        $add_error = "Kategori adı boş bırakılamaz.";
    }
}

// Kategori silme
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
    header("Location: categories.php");
    exit;
}

// Tüm kategorileri al
$all_categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Hiyerarşik yapı için diziler
function getCategoriesTree($categories, $parent_id = null, $level = 0) {
  $tree = '';
  foreach ($categories as $cat) {
      if ($cat['parent_id'] == $parent_id) {
          $indent = str_repeat('— ', $level);
          $tree .= "<tr class='border-t'>
              <td class='p-2'>{$cat['id']}</td>
              <td class='p-2'>{$indent}" . htmlspecialchars($cat['name']) . "</td>
              <td class='p-2'>" . ($cat['parent_id'] ?? 'Yok') . "</td>
              <td class='p-2'><a href='?delete={$cat['id']}' onclick='return confirm(\"Silmek istediğinize emin misiniz?\")' class='text-red-600 hover:underline'>Sil</a></td>
          </tr>";
          $tree .= getCategoriesTree($categories, $cat['id'], $level + 1);
      }
  }
  return $tree;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Kategori Yönetimi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold">Kategorileri Yönet</h2>
      <a href="dashboard.php" class="text-blue-600 hover:underline">← Admin Panel</a>
    </div>

    <?php if ($add_error): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $add_error ?></div>
    <?php endif; ?>
    <?php if ($add_success): ?>
      <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $add_success ?></div>
    <?php endif; ?>

    <!-- Kategori Ekle -->
    <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <input type="hidden" name="add_category" value="1">
      <input type="text" name="name" placeholder="Kategori Adı" required class="border p-2 rounded">
      <select name="parent_id" class="border p-2 rounded">
        <option value="">Ana Kategori</option>
        <?php foreach ($all_categories as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white rounded px-4 py-2">Ekle</button>
    </form>

    <!-- Kategori Listesi -->
    <table class="w-full border">
    <thead>
  <tr class="bg-gray-200 text-left">
    <th class="p-2">ID</th>
    <th class="p-2">Kategori Adı</th>
    <th class="p-2">Üst Kategori</th>
    <th class="p-2">İşlem</th>
  </tr>
</thead>
      <tbody>
        <?= getCategoriesTree($all_categories) ?>
      </tbody>
    </table>

  </div>
</body>
</html>
