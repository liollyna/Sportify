-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 31 mai 2024 à 13:02
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `spotify2`
--

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

DROP TABLE IF EXISTS `activites`;
CREATE TABLE IF NOT EXISTS `activites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `activites`
--

INSERT INTO `activites` (`id`, `nom`) VALUES
(1, 'Séance de Natation'),
(2, 'Entraînement de Rugby'),
(3, 'Musculation'),
(4, 'tennis'),
(5, 'basketball'),
(6, 'football');

-- --------------------------------------------------------

--
-- Structure de la table `coachs`
--

DROP TABLE IF EXISTS `coachs`;
CREATE TABLE IF NOT EXISTS `coachs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `CV` varchar(255) NOT NULL,
  `bureau` varchar(255) NOT NULL,
  `Telephone` int NOT NULL,
  `Email` varchar(255) NOT NULL,
  `activite_id` int NOT NULL,
  `salle_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `activite_id` (`activite_id`),
  KEY `salle_id` (`salle_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `coachs`
--

INSERT INTO `coachs` (`id`, `nom`, `photo`, `CV`, `bureau`, `Telephone`, `Email`, `activite_id`, `salle_id`) VALUES
(3, 'Pedro', 'image/pedro.jpg', 'cv/pedro.xml', '12 rue de Serray', 615859423, 'pedropot@omnessports.fr', 3, 3),
(1, 'Marie', 'image/marie.jpg', 'cv/marie.xml', '11 rue de la Pléiade', 789653416, 'marierozo@omnessports.fr', 1, 1),
(2, 'Antoine', 'image/antoine.jpg', 'cv/antoine.xml', '13 rue du stade', 618953746, 'antoinedupont@omnessports.fr', 2, 2),
(4, 'Gaël', 'image/gael.jpg', 'cv/gael.xml', 'Roland Garros', 613598743, 'gaëlmonfils@omnessports.fr', 4, 4),
(5, 'Tony', 'image/tony.jpg', 'cv/tony.xml', 'Accord hôtel Arena Bercy', 756325968, 'tonyparker@omnessports.fr', 5, 5),
(6, 'Zidane', 'image/zidane.jpg', 'cv/zidane.xml', 'Parc des princes Paris', 765983214, 'zidane@omnessports.fr', 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `creneaux`
--

DROP TABLE IF EXISTS `creneaux`;
CREATE TABLE IF NOT EXISTS `creneaux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coach_id` int NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `type` enum('disponible','reserve','conge') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coach_id` (`coach_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `creneaux`
--

INSERT INTO `creneaux` (`id`, `coach_id`, `date`, `heure_debut`, `heure_fin`, `type`) VALUES
(1, 1, '2024-06-01', '10:00:00', '12:00:00', 'disponible'),
(2, 2, '2024-06-02', '15:00:00', '17:00:00', 'disponible'),
(3, 3, '2024-06-03', '09:00:00', '11:00:00', 'reserve'),
(4, 1, '2024-06-04', '10:00:00', '12:00:00', 'conge'),
(5, 2, '2024-06-05', '14:00:00', '16:00:00', 'reserve'),
(6, 3, '2024-06-06', '15:00:00', '17:00:00', 'disponible'),
(7, 1, '2024-06-07', '09:00:00', '11:00:00', 'disponible'),
(8, 2, '2024-06-08', '10:00:00', '12:00:00', 'reserve');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `coach_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `contenu` text NOT NULL,
  `date_envoi` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `coach_id` (`coach_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

DROP TABLE IF EXISTS `rendez_vous`;
CREATE TABLE IF NOT EXISTS `rendez_vous` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `activite_id` int NOT NULL,
  `coach_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `activite_id` (`activite_id`),
  KEY `coach_id` (`coach_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`id`, `utilisateur_id`, `date`, `heure`, `activite_id`, `coach_id`) VALUES
(1, 1, '2024-06-01', '10:00:00', 1, 1),
(2, 2, '2024-06-02', '15:00:00', 2, 2),
(3, 1, '2024-06-03', '09:00:00', 3, 3),
(4, 2, '2024-06-04', '10:00:00', 4, 4),
(5, 1, '2024-06-05', '14:00:00', 5, 5),
(6, 2, '2024-06-06', '15:00:00', 6, 6),
(7, 1, '2024-06-07', '09:00:00', 1, 1),
(8, 2, '2024-06-08', '10:00:00', 2, 3),
(9, 1, '2024-06-03', '10:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

DROP TABLE IF EXISTS `salles`;
CREATE TABLE IF NOT EXISTS `salles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`id`, `nom`) VALUES
(3, 'Salle A-01'),
(2, 'Stade toulousain'),
(1, 'piscine de la foret'),
(4, 'court Philippe Chatrier'),
(5, 'Arena Bercy'),
(6, 'Parc des princes');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `adresse`, `telephone`, `mot_de_passe`, `type`) VALUES
(1, 'John Doe', 'johndoe@example.com', '123 Rue Sport, Ville Sportive', '123-456-7890', 'password1', 'client'),
(2, 'Jane Smith', 'janesmith@example.com', '456 Avenue Gym, Ville Active', '098-765-4321', 'password2', 'client'),
(3, 'Dupont', 'antoinedupont@omnessports.fr', 'stade Toulousain', '635986532', 'coachpassword', 'coach'),
(4, 'admin', 'admin@omnessports.fr', 'ECE', '0635987463', 'adminpassword', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
