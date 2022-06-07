-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 juin 2022 à 12:22
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `solution`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `text`) VALUES
(1, 'name', 'novikova.a13@gmail.com', 'Text'),
(2, 'My Name', 'novikova_a@yahoo.fr', 'My Text'),
(3, 'My Name', 'novikova_a@yahoo.fr', 'My Text'),
(4, 'My Name', 'novikova_a@yahoo.fr', 'My text'),
(5, 'My Name', 'novikova_a@yahoo.fr', 'Message'),
(6, 'My Name', 'novikova_a@yahoo.fr', 'Message 1'),
(7, 'My Name', 'novikova_a@yahoo.fr', 'Message 2'),
(8, 'My Name', 'novikova_a@yahoo.fr', 'Message 2'),
(9, 'My Name', 'novikova_a@yahoo.fr', 'My text'),
(10, 'My Name', 'novikova.a13@gmail.com', 'Mon text final');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220603145715', '2022-06-03 15:08:42', 315),
('DoctrineMigrations\\Version20220603151128', '2022-06-03 15:11:40', 80);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `image`, `title`, `text`) VALUES
(1, 'news1.jpg', 'Aenean ultrices lorem quis blandit tempor urabitur accumsan.', 'Donec non sem mi. In hac habitasse platea dictumst. Nullam a feugiat augue, et porta metus. Nulla mollis lobortis leet. Maecenas tincidunt, arcu sed ornare purus risus'),
(2, 'news2.jpg', 'Nam vel nisi eget odio pulvinar iaculis. Fusce aliquet. Nam vel nisi eget odio pulvinar iaculis. Fusce aliquet.', 'Donec non sem mi. In hac habitasse platea dictumst. Nullam a feugiat augue, et porta metus. Nulla mollis lobortis leet. Maecenas tincidunt, arcu sed ornare purus risus'),
(3, 'news3.jpg', 'Morbi faucibus odio sollicitudin risus scelerisque dignissim. ', 'Donec non sem mi. In hac habitasse platea dictumst. Nullam a feugiat augue, et porta metus. Nulla mollis lobortis leet. Maecenas tincidunt, arcu sed ornare purus risus');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `image`, `title`, `text`) VALUES
(1, 'web-design.png', 'Web Design', 'Nullam quis libero in lorem accumsan sodales. Nam vel nisi eget.'),
(2, 'seo.png', 'SEO', 'Nullam quis libero in lorem accumsan sodales. Nam vel nisi eget.'),
(3, 'marketing.png', 'Marketing', 'Graphics Design\r\nNullam quis libero in lorem accumsan sodales. Nam vel nisi eget.'),
(4, 'graphics-design.png', 'Graphics Design', 'Nullam quis libero in lorem accumsan sodales. Nam vel nisi eget.');

-- --------------------------------------------------------

--
-- Structure de la table `stats`
--

DROP TABLE IF EXISTS `stats`;
CREATE TABLE IF NOT EXISTS `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stats`
--

INSERT INTO `stats` (`id`, `title`, `quantity`) VALUES
(1, 'Active Projects', 125),
(2, 'Business Growth', 200),
(3, 'Completed Projects', 530),
(4, 'Happy Clients', 941);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
