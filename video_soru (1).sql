-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 Mar 2025, 08:56:30
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `video_soru`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(3, 'Özhan Tellioğlu', 'a@a.com', '$2y$10$N2p.g.oJXd3sPrNl9Fa6XOMuMxTRlUxIUS9M01tOm9ykAYq8JsIBG', '2025-03-27 17:46:14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `created_at`) VALUES
(6, 'DENEME', NULL, '2025-03-27 17:59:39'),
(7, 'DENEME1', NULL, '2025-03-27 19:36:57'),
(8, 'DENEME2', NULL, '2025-03-27 19:36:57'),
(9, 'DENEME3', NULL, '2025-03-27 19:36:57'),
(10, 'DENEME4', NULL, '2025-03-27 19:36:57'),
(11, 'DENEME5', NULL, '2025-03-27 19:36:57'),
(12, 'DENEME6', NULL, '2025-03-27 19:36:57'),
(13, 'DENEME7', NULL, '2025-03-27 19:36:57'),
(14, 'DENEME8', NULL, '2025-03-27 19:36:57'),
(15, 'DENEME9', NULL, '2025-03-27 19:36:57'),
(16, 'DENEME10', NULL, '2025-03-27 19:36:57'),
(17, 'DENEME11', NULL, '2025-03-27 19:36:57'),
(18, 'DENEME12', NULL, '2025-03-27 19:36:57'),
(19, 'DENEME13', NULL, '2025-03-27 19:36:57'),
(20, 'DENEME20', 6, '2025-03-27 19:38:48'),
(21, 'DENEME20', 7, '2025-03-27 19:38:48'),
(22, 'DENEME20', 8, '2025-03-27 19:38:48'),
(23, 'DENEME20', 9, '2025-03-27 19:38:48'),
(24, 'DENEME20', 10, '2025-03-27 19:38:48'),
(25, 'DENEME20', 11, '2025-03-27 19:38:48'),
(26, 'DENEME20', 12, '2025-03-27 19:38:48'),
(27, 'DENEME20', 13, '2025-03-27 19:38:48'),
(28, 'DENEME20', 14, '2025-03-27 19:38:48'),
(29, 'DENEME20', 15, '2025-03-27 19:38:48'),
(30, 'DENEME20', 16, '2025-03-27 19:38:48'),
(31, 'DENEME20', 17, '2025-03-27 19:38:48'),
(32, 'DENEME20', 18, '2025-03-27 19:38:48');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `vimeo_url` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `videos`
--

INSERT INTO `videos` (`id`, `title`, `vimeo_url`, `category_id`, `created_at`) VALUES
(9, 'DENEME VİDEO1', '347119375', 20, '2025-03-27 19:42:51'),
(10, 'DENEME VİDEO2', '347119375', 21, '2025-03-27 19:42:51'),
(11, 'DENEME VİDEO3', '347119375', 22, '2025-03-27 19:42:51'),
(12, 'DENEME VİDEO4', '347119375', 23, '2025-03-27 19:42:51'),
(13, 'DENEME VİDEO5', '347119375', 24, '2025-03-27 19:42:51'),
(14, 'DENEME VİDEO6', '347119375', 25, '2025-03-27 19:42:51'),
(15, 'DENEME VİDEO7', '347119375', 26, '2025-03-27 19:42:51'),
(16, 'DENEME VİDEO8', '347119375', 27, '2025-03-27 19:42:51'),
(17, 'DENEME VİDEO9', '347119375', 28, '2025-03-27 19:42:51'),
(18, 'DENEME VİDEO10', '347119375', 29, '2025-03-27 19:42:51'),
(19, 'DENEME VİDEO11', '347119375', 30, '2025-03-27 19:42:51'),
(20, 'DENEME VİDEO12', '347119375', 31, '2025-03-27 19:42:51'),
(21, 'DENEME VİDEO13', '347119375', 32, '2025-03-27 19:42:51'),
(22, 'DENEME VİDEO14', '347119375', 20, '2025-03-27 19:42:51'),
(23, 'DENEME VİDEO15', '347119375', 21, '2025-03-27 19:42:51'),
(24, 'DENEME VİDEO16', '347119375', 22, '2025-03-27 19:42:51'),
(25, 'DENEME VİDEO17', '347119375', 23, '2025-03-27 19:42:51'),
(26, 'DENEME VİDEO18', '347119375', 24, '2025-03-27 19:42:51'),
(27, 'DENEME VİDEO19', '347119375', 25, '2025-03-27 19:42:51'),
(28, 'DENEME VİDEO20', '347119375', 26, '2025-03-27 19:42:51'),
(29, 'DENEME VİDEO21', '347119375', 27, '2025-03-27 19:42:51'),
(30, 'DENEME VİDEO22', '347119375', 28, '2025-03-27 19:42:51'),
(31, 'DENEME VİDEO23', '347119375', 29, '2025-03-27 19:42:51'),
(32, 'DENEME VİDEO24', '347119375', 30, '2025-03-27 19:42:51'),
(33, 'DENEME VİDEO25', '347119375', 31, '2025-03-27 19:42:51'),
(34, 'DENEME VİDEO26', '347119375', 32, '2025-03-27 19:42:51'),
(35, 'DENEME VİDEO27', '347119375', 20, '2025-03-27 19:42:51'),
(36, 'DENEME VİDEO28', '347119375', 21, '2025-03-27 19:42:51'),
(37, 'DENEME VİDEO29', '347119375', 22, '2025-03-27 19:42:51'),
(38, 'DENEME VİDEO30', '347119375', 23, '2025-03-27 19:42:51'),
(39, 'DENEME VİDEO31', '347119375', 24, '2025-03-27 19:42:51'),
(40, 'DENEME VİDEO32', '347119375', 25, '2025-03-27 19:42:51');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Tablo için AUTO_INCREMENT değeri `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
