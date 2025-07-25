-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 25 juil. 2025 à 13:57
-- Version du serveur : 9.1.0
-- Version de PHP : 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mangatheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `manga_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_user_manga_favorite` (`user_id`,`manga_id`),
  KEY `FK_favorite_manga` (`manga_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mangas`
--

DROP TABLE IF EXISTS `mangas`;
CREATE TABLE IF NOT EXISTS `mangas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'placeholder.png',
  `publisher` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` enum('Shonen','Kodomo','Shôjo','Seinen','Josei') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Shonen',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mangas`
--

INSERT INTO `mangas` (`id`, `title`, `author`, `volume`, `description`, `created_at`, `cover_image`, `publisher`, `type`) VALUES
(1, 'Naruto', 'Masashi Kishimoto', 1, 'L\'histoire de Naruto Uzumaki, un jeune ninja qui rêve de devenir Hokage.', '2025-07-09 14:09:47', '686e9d0cc9a52_Naruto.jpg', 'Kana', 'Shonen'),
(2, 'One Piece', 'Eiichiro Oda', 1, 'Les aventures de Monkey D. Luffy et de son équipage de pirates.', '2025-07-09 14:09:47', '686e9158e16da_One Piece.jpg', 'Shūeisha', 'Shonen'),
(3, 'Attack on Titan', 'Hajime Isayama', 1, 'L\'humanité vit derrière d\'immenses murs pour se protéger des Titans.', '2025-07-09 14:09:47', '686ea899a218d_Attack-on-Titan.png', 'Kōdansha', 'Shonen'),
(4, 'Death Note', 'Tsugumi Ohba & Takeshi Obata', 12, 'Un lycéen trouve un carnet mystérieux qui lui permet de tuer quiconque dont le nom y est écrit.', '2025-07-25 13:42:04', 'death_note.jpg', 'Kana', 'Shonen'),
(5, 'Bakuman', 'Tsugumi Ohba & Takeshi Obata', 20, 'Deux lycéens décident de devenir mangakas pour réaliser leurs rêves.', '2025-07-25 13:42:04', 'bakuman.jpg', 'Kana', 'Shonen'),
(6, 'My Hero Academia', 'Kohei Horikoshi', 42, 'Dans un monde où 80% de la population possède des super-pouvoirs, un jeune homme sans alter rêve de devenir un héros.', '2025-07-25 13:42:04', 'my_hero_academia.jpg', 'Ki-oon', 'Shonen'),
(7, 'Demon Slayer', 'Koyoharu Gotouge', 23, 'Après l\'assassinat de sa famille par des démons et la transformation de sa sœur en démon, Tanjiro Kamado devient pourfendeur de démons.', '2025-07-25 13:42:04', 'demon_slayer.jpg', 'Panini Manga', 'Shonen'),
(8, 'Dragon Ball', 'Akira Toriyama', 42, 'Les aventures de Son Goku, un jeune garçon doté d\'une force surhumaine, qui part à la recherche des Dragon Balls.', '2025-07-25 13:42:04', 'dragon_ball.jpg', 'Glénat', 'Shonen');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `manga_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_user_manga_review` (`manga_id`,`user_id`),
  KEY `FK_review_user` (`user_id`)
) ;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `manga_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 3, 3, 1, 'pas mal', '2025-07-25 13:56:07');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `password`, `created_at`) VALUES
(3, 'dede', 'dede@laposte.net', '$2y$10$MfjNPJJtpYUeH4vl9C80S.s/DPVvgQAgRdonvSQ.2bJ3cocIKv2qu', '2025-07-10 17:01:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
