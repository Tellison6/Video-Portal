<?php
session_start();
require_once '../includes/db.php';

// Giriş kontrolü
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Video ekleme
$add_error = '';
$add_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_video'])) {
    $title = $_POST['title'] ?? '';
    $vimeo_url = $_POST['vimeo_url'] ?? '';
    $category_id = $_POST['category_id'] ?? null;

    if ($title && $vimeo_url) {
        $stmt = $pdo->prepare("INSERT INTO videos (title, vimeo_url, category_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $vimeo_url, $category_id ?: null]);
        $add_success = "Video başarıyla eklendi.";
    } else {
        $add_error = "Tüm alanlar doldurulmalıdır.";
    }
}

// Video silme
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM videos WHERE id = ?")->execute([$id]);
    header("Location: videos.php");
    exit;
}

// Kategorileri al
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Videoları al (kategori adıyla)
$stmt = $pdo->query("SELECT v.*, c.name AS category_name 
                     FROM videos v 
                     LEFT JOIN categories c ON v.category_id = c.id 
                     ORDER BY v.id DESC");
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Video Yönetimi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold">Videoları Yönet</h2>
      <a href="dashboard.php" class="text-blue-600 hover:underline">← Admin Panel</a>
    </div>

    <?php if ($add_error): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $add_error ?></div>
    <?php endif; ?>
    <?php if ($add_success): ?>
      <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $add_success ?></div>
    <?php endif; ?>

    <!-- Video Ekle -->
    <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <input type="hidden" name="add_video" value="1">
      <input type="text" name="title" placeholder="Video Başlığı" required class="border p-2 rounded">
      <input type="input" name="vimeo_url" placeholder="Vimeo URL" required class="border p-2 rounded">
      <select name="category_id" class="border p-2 rounded">
        <option value="">Kategori Seç</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white rounded px-4 py-2">Ekle</button>
    </form>

    <!-- Video Listesi -->
    <table class="w-full border">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">Başlık</th>
          <th class="p-2">Kategori</th>
          <th class="p-2">Vimeo</th>
          <th class="p-2">İşlem</th>
          <th class="p-2">Kategoriyi Düzenle</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($videos as $video): ?>
          <tr class="border-t">
            <td class="p-2"><?= htmlspecialchars($video['title']) ?></td>
            <td class="p-2"><?= $video['category_name'] ?? '—' ?></td>
            <td class="p-2">
              <a href="https://vimeo.com/<?= $video['vimeo_url'] ?>" target="_blank" class="text-blue-600 underline">İzle</a>
            </td>
            <td class="p-2">
              <a href="?delete=<?= $video['id'] ?>" onclick="return confirm('Bu videoyu silmek istediğinizden emin misiniz?')" class="text-red-600 hover:underline">Sil</a>
            </td>
            <td>
          <!-- 🔹 Tam buraya ekle -->
          <a href="video_edit.php?id=<?= $video['id'] ?>" class="text-blue-600 hover:underline">Düzenle</a>
        </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
