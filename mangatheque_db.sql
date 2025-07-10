-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 09 juil. 2025 à 20:13
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mangatheque_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `mangas`
--

CREATE TABLE `mangas` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'placeholder.png',
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mangas`
--

INSERT INTO `mangas` (`id`, `title`, `author`, `volume`, `description`, `created_at`, `cover_image`, `publisher`) VALUES
(1, 'Naruto', 'Masashi Kishimoto', 1, 'L\'histoire de Naruto Uzumaki, un jeune ninja qui rêve de devenir Hokage.', '2025-07-09 14:09:47', '686e9d0cc9a52_Naruto.jpg', 'Kana'),
(2, 'One Piece', 'Eiichiro Oda', 1, 'Les aventures de Monkey D. Luffy et de son équipage de pirates.', '2025-07-09 14:09:47', '686e9158e16da_One Piece.jpg', 'Shūeisha'),
(3, 'Attack on Titan', 'Hajime Isayama', 1, 'L\'humanité vit derrière d\'immenses murs pour se protéger des Titans.', '2025-07-09 14:09:47', '686ea899a218d_Attack-on-Titan.png', 'Kōdansha');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `mangas`
--
ALTER TABLE `mangas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `mangas`
--
ALTER TABLE `mangas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
