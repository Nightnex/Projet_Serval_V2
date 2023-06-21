-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 21 juin 2023 à 07:55
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fpview_second`
--

-- --------------------------------------------------------

--
-- Structure de la table `compass`
--

DROP TABLE IF EXISTS `compass`;
CREATE TABLE IF NOT EXISTS `compass` (
  `id` int NOT NULL AUTO_INCREMENT,
  `orientation` varchar(155) NOT NULL,
  `map_direction` varchar(155) NOT NULL,
  `c_path` varchar(155) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `compass`
--

INSERT INTO `compass` (`id`, `orientation`, `map_direction`, `c_path`) VALUES
(1, 'east', '0', 'BoussoleE.png'),
(2, 'north', '90', 'BoussoleN.png'),
(3, 'west', '180', 'BoussoleW.png'),
(4, 'south', '270', 'BoussoleS.png');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `map_id` int NOT NULL,
  `path` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `map_id`, `path`) VALUES
(3, 1, 'vue1.png'),
(4, 2, 'vue3.png'),
(5, 3, 'dog.png'),
(7, 5, 'vue1_appr.png '),
(8, 6, 'vue1_apprG.png'),
(9, 7, 'vue1_arriere.jpg'),
(10, 8, 'vue1_apprD.png'),
(11, 9, 'vue2_apprG.png'),
(12, 10, 'vue2_arriere.jpg'),
(13, 11, 'vue2_apprD.png'),
(14, 12, 'vue2_appr.png'),
(15, 13, 'vue3_apprD.png'),
(16, 14, 'vue3_appr.png'),
(17, 15, 'vue3_apprG.png'),
(18, 16, 'vue3_arriere.jpg'),
(6, 4, 'vue2.png');

-- --------------------------------------------------------

--
-- Structure de la table `map`
--

DROP TABLE IF EXISTS `map`;
CREATE TABLE IF NOT EXISTS `map` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coordX` int NOT NULL,
  `coordY` int NOT NULL,
  `direction` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `map`
--

INSERT INTO `map` (`id`, `coordX`, `coordY`, `direction`) VALUES
(1, 1, 1, 0),
(2, 1, 1, 90),
(3, 1, 1, 180),
(4, 1, 1, 270),
(5, 2, 1, 0),
(6, 2, 1, 90),
(7, 2, 1, 180),
(8, 2, 1, 270),
(9, 1, 0, 0),
(10, 1, 0, 90),
(11, 1, 0, 180),
(12, 1, 0, 270),
(13, 1, 2, 0),
(14, 1, 2, 90),
(15, 1, 2, 180),
(16, 1, 2, 270);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
