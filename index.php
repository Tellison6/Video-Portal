<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Arama parametresi
$search = $_GET['q'] ?? null;
$parent_id = isset($_GET['kategori']) ? (int) $_GET['kategori'] : null;

// Kategorileri çek
if ($search !== null && $parent_id === null) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id IS NULL AND name LIKE ?");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id " . ($parent_id === null ? "IS NULL" : "= ?"));
    $stmt->execute($parent_id === null ? [] : [$parent_id]);
}
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Videoları çek
$videos = [];
if ($parent_id !== null) {
    $videoStmt = $pdo->prepare("SELECT * FROM videos WHERE category_id = ?");
    $videoStmt->execute([$parent_id]);
    $videos = $videoStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Seçili kategori adı
$categoryName = '';
if ($parent_id !== null) {
    $nameStmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $nameStmt->execute([$parent_id]);
    $categoryName = $nameStmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Videolu Soru Sistemi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Sayfa içeriği -->
  <main class="flex-grow max-w-5xl mx-auto p-4 mt-6 w-full">

    <!-- Başlık -->
    <div class="text-center mb-6">
      <h1 class="text-xl sm:text-2xl font-bold flex items-center justify-center gap-2">
      <a href="/video-portali/index.php"><img src="https://www.egitimdestekuzmani.com/image/catalog/lll/LOGO-SON-HAL-1s-2.png"  alt="Logo" /></a>

      </h1>
    </div>

    <!-- Arama Formu -->
    <?php if ($parent_id === null): ?>
    <form method="GET" class="flex flex-col sm:flex-row gap-2 mb-6">
      <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Ana kategori ara..." class="w-full border p-2 rounded" />
      <button type="submit" class="btn w-full sm:w-auto">Ara</button>
    </form>
    <?php endif; ?>

    <!-- Seçili Kategori Adı -->
    <?php if ($categoryName): ?>
      <p class="text-center text-gray-600 mb-6">Kategori: <strong><?= htmlspecialchars($categoryName) ?></strong></p>
    <?php endif; ?>

    <!-- Kategoriler -->
    <?php if (count($categories) > 0): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <?php foreach ($categories as $cat): ?>
          <a href="?kategori=<?= $cat['id'] ?>" class="block p-4 text-center rounded-lg border-2 border-blue-500 bg-blue-50 text-blue-800 font-semibold hover:bg-blue-100 shadow transition-all duration-200">
            <?= htmlspecialchars($cat['name']) ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php elseif ($search !== null): ?>
      <div class="alert-error">Arama sonucu bulunamadı.</div>
    <?php endif; ?>

    <!-- Videolar -->
    <?php if ($parent_id && count($videos) > 0): ?>
      <div class="space-y-6">
        <?php foreach ($videos as $video): ?>
          <div class="card">
            <h2 class="text-lg font-semibold mb-2"><?= htmlspecialchars($video['title']) ?></h2>
            <div class="w-full aspect-video">
              <iframe src="https://player.vimeo.com/video/<?= htmlspecialchars($video['vimeo_url']) ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen class="w-full h-full rounded"></iframe>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php elseif ($parent_id && count($videos) === 0 && count($categories) === 0): ?>
      <div class="alert-error">Bu kategoride henüz video veya alt kategori yok.</div>
    <?php endif; ?>

    <!-- Geri Dön -->
    <?php if ($parent_id): ?>
      <div class="mt-6 text-center">
        <a href="index.php" class="text-blue-600 hover:underline">← Ana Kategorilere Dön</a>
      </div>
    <?php endif; ?>

  </main>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
