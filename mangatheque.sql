-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 25 juil. 2025 à 16:10
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

CREATE TABLE `favorites` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `manga_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `manga_id`, `created_at`) VALUES
(1, 3, 8, '2025-07-25 15:38:33'),
(2, 3, 7, '2025-07-25 15:38:44'),
(3, 3, 5, '2025-07-25 15:39:03');

-- --------------------------------------------------------

--
-- Structure de la table `mangas`
--

CREATE TABLE `mangas` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'placeholder.png',
  `publisher` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` enum('Shonen','Kodomo','Shôjo','Seinen','Josei') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Shonen'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mangas`
--

INSERT INTO `mangas` (`id`, `title`, `author`, `volume`, `description`, `created_at`, `cover_image`, `publisher`, `type`) VALUES
(1, 'Naruto', 'Masashi Kishimoto', 72, 'L\'histoire de Naruto Uzumaki, un jeune ninja qui rêve de devenir Hokage.', '2025-07-09 14:09:47', '686e9d0cc9a52_Naruto.jpg', 'Kana', 'Shonen'),
(2, 'One Piece', 'Eiichiro Oda', 109, 'Les aventures de Monkey D. Luffy et de son équipage de pirates.', '2025-07-09 14:09:47', '686e9158e16da_One Piece.jpg', 'Shūeisha', 'Shonen'),
(3, 'Attack on Titan', 'Hajime Isayama', 34, 'L\'humanité vit derrière d\'immenses murs pour se protéger des Titans.', '2025-07-09 14:09:47', '686ea899a218d_Attack-on-Titan.png', 'Kōdansha', 'Shonen'),
(4, 'Death Note', 'Tsugumi Ohba & Takeshi Obata', 12, 'Un lycéen trouve un carnet mystérieux qui lui permet de tuer quiconque dont le nom y est écrit.', '2025-07-25 13:42:04', '6883a2a773026_death-note.jpg', 'Kana', 'Shonen'),
(5, 'Bakuman', 'Tsugumi Ohba & Takeshi Obata', 20, 'Deux lycéens décident de devenir mangakas pour réaliser leurs rêves.', '2025-07-25 13:42:04', 'bakuman.jpg', 'Kana', 'Shonen'),
(6, 'My Hero Academia', 'Kohei Horikoshi', 42, 'Dans un monde où 80% de la population possède des super-pouvoirs, un jeune homme sans alter rêve de devenir un héros.', '2025-07-25 13:42:04', '6883a28dc1b91_My Hero Academia.jpg', 'Ki-oon', 'Shonen'),
(7, 'Demon Slayer', 'Koyoharu Gotouge', 23, 'Après l\'assassinat de sa famille par des démons et la transformation de sa sœur en démon, Tanjiro Kamado devient pourfendeur de démons.', '2025-07-25 13:42:04', '6883a2795353e_Demon Slayer.jpg', 'Panini Manga', 'Shonen'),
(8, 'Dragon Ball', 'Akira Toriyama', 42, 'Les aventures de Son Goku, un jeune garçon doté d\'une force surhumaine, qui part à la recherche des Dragon Balls.', '2025-07-25 13:42:04', '6883a2618c2c2_Dragon Ball.jpg', 'Glénat', 'Shonen');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `manga_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `manga_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 3, 3, 1, 'pas mal', '2025-07-25 13:56:07'),
(2, 2, 3, 3, 'délire', '2025-07-25 15:56:33');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `password`, `created_at`) VALUES
(3, 'dede', 'dede@laposte.net', '$2y$10$MfjNPJJtpYUeH4vl9C80S.s/DPVvgQAgRdonvSQ.2bJ3cocIKv2qu', '2025-07-10 17:01:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_user_manga_favorite` (`user_id`,`manga_id`),
  ADD KEY `FK_favorite_manga` (`manga_id`);

--
-- Index pour la table `mangas`
--
ALTER TABLE `mangas`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_user_manga_review` (`manga_id`,`user_id`),
  ADD KEY `FK_review_user` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `mangas`
--
ALTER TABLE `mangas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
