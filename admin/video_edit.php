<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Video ID kontrolü
$video_id = $_GET['id'] ?? null;
if (!$video_id) {
    die("Geçersiz video ID");
}

// Video bilgilerini çek
$stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->execute([$video_id]);
$video = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$video) {
    die("Video bulunamadı.");
}

// Kategorileri al
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$success = '';
$error = '';

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $vimeo_url = $_POST['vimeo_url'] ?? '';
    $category_id = $_POST['category_id'] ?? null;

    if ($title && $vimeo_url) {
        $update = $pdo->prepare("UPDATE videos SET title = ?, vimeo_url = ?, category_id = ? WHERE id = ?");
        $update->execute([$title, $vimeo_url, $category_id, $video_id]);
        $success = "Video başarıyla güncellendi.";
        // Güncel verileri tekrar al
        $stmt->execute([$video_id]);
        $video = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error = "Başlık ve Vimeo linki boş bırakılamaz.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Video Düzenle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-2xl mx-auto bg-white shadow rounded p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">🎬 Videoyu Düzenle</h2>
        <a href="videos.php" class="text-blue-600 hover:underline">← Geri Dön</a>
    </div>

    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block font-semibold mb-1">Başlık</label>
            <input type="text" name="title" value="<?= htmlspecialchars($video['title']) ?>" required class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-semibold mb-1">Vimeo Linki</label>
            <input type="url" name="vimeo_url" value="<?= htmlspecialchars($video['vimeo_url']) ?>" required class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category_id" class="w-full border p-2 rounded">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $video['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Kaydet</button>
    </form>
</div>

</body>
</html>
