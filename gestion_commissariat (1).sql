-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 09, 2024 at 10:03 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_commissariat`
--

-- --------------------------------------------------------

--
-- Table structure for table `autorisations`
--

DROP TABLE IF EXISTS `autorisations`;
CREATE TABLE IF NOT EXISTS `autorisations` (
  `id_autorisation` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `marque` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `modele` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `serie` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_moteur` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `couleur` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_de_cylindre` int NOT NULL,
  `annee` int NOT NULL,
  `puissance` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `no_plaque` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nom_proprietaire` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nif_cin` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_enregistrement` date NOT NULL,
  PRIMARY KEY (`id_autorisation`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `autorisations`
--

INSERT INTO `autorisations` (`id_autorisation`, `code`, `marque`, `modele`, `serie`, `no_moteur`, `couleur`, `type`, `nombre_de_cylindre`, `annee`, `puissance`, `no_plaque`, `nom_proprietaire`, `nif_cin`, `adresse`, `date_enregistrement`) VALUES
(18, 'AUT-182024', 'Toyota', 'Vue', '123-ouh-90', '678888', 'Noir', 'mini bus', 5, 2003, '5 chevraux', '2722gggw', 'Seide Awade', '0989-0987-099', 'Champin', '2024-08-05'),
(20, 'AUT-202024', 'Toyota', 'Highlander', '8383', '26266262', 'Bleu-marin', '4X4', 6, 2024, '18 chevaux', 'HT-89283', 'Suze Phara', '93939', 'Saint-raphael', '2024-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `circulation`
--

DROP TABLE IF EXISTS `circulation`;
CREATE TABLE IF NOT EXISTS `circulation` (
  `id_circulation` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nom_chauffeur` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_permis` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `no_plaque` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lieu_contravention` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_violation` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `article` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date_heure` datetime NOT NULL,
  `no_agent` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `no_matricule` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_circulation`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `circulation`
--

INSERT INTO `circulation` (`id_circulation`, `code`, `nom_chauffeur`, `no_permis`, `no_plaque`, `lieu_contravention`, `no_violation`, `article`, `date_heure`, `no_agent`, `no_matricule`) VALUES
(7, '7830', 'Pierre Richard', '0900-9080', 'HT-B123-09', 'Ouanaminte', '190_A', '30_2', '2024-01-10 23:06:00', '7726262', '0009-90980-1'),
(20, 'CTN-202024', 'Archile Desramaux', '3993-9039', 'HT-89283', 'Limbe', '21', '2.31_3', '2024-08-22 19:50:00', '234332', 'jsjsj2333'),
(21, 'CTN-212024', 'Suze', 'Para', 'HT-89283', 'Morne-rouge', '12', '1.1_2', '2024-08-01 15:33:00', '032772-HT', '004-006-0009');

-- --------------------------------------------------------

--
-- Table structure for table `detenus`
--

DROP TABLE IF EXISTS `detenus`;
CREATE TABLE IF NOT EXISTS `detenus` (
  `id_detenu` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cin_ou_nif` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `sexe` enum('masculin','féminin') COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `infraction` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `statut` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_prison` int DEFAULT NULL,
  `date_enregistrement` date NOT NULL,
  PRIMARY KEY (`id_detenu`),
  KEY `id_prison` (`id_prison`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detenus`
--

INSERT INTO `detenus` (`id_detenu`, `code`, `nom`, `prenom`, `cin_ou_nif`, `sexe`, `adresse`, `telephone`, `infraction`, `statut`, `id_prison`, `date_enregistrement`) VALUES
(34, 'DT-342024', 'Dolcine', 'Lounedala', '8388383', 'masculin', 'Savane-Longue', '45678909', 'voleur', 'En détention', 79, '2024-08-03'),
(35, 'DT-352024', 'Pierre', 'Rishy', '672728-093939', 'masculin', 'Champin', '42511090', 'Vol', 'Évadé', 79, '2024-08-03'),
(36, 'DT-362024', 'Saintilnord', 'Ancelinio', '737338383', 'masculin', 'Champin', '42511090', 'Homicide', 'En détention', 79, '2024-08-03'),
(37, 'DT-372024', 'Phismond', 'Prednel', '8383-900-0903', 'masculin', 'Ouanaminthe', '2662626', 'Fraude', 'En attente de jugement', 79, '2024-08-04'),
(38, 'DT-382024', 'Mirlanda', 'Joseph', '6262626', 'féminin', 'Madeline', '6262626', 'Autres', 'Évadé', 79, '2024-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `prisons`
--

DROP TABLE IF EXISTS `prisons`;
CREATE TABLE IF NOT EXISTS `prisons` (
  `id_prison` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_de_cellule` int NOT NULL,
  `nombre_de_place_par_cellule` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_prison`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prisons`
--

INSERT INTO `prisons` (`id_prison`, `code`, `nom`, `adresse`, `nombre_de_cellule`, `nombre_de_place_par_cellule`, `date_enregistrement`) VALUES
(107, 'PR-1072024', 'Lasnal Penitancier', 'Cap-Haitien', 200, 50, '2024-08-04 21:19:25'),
(79, '2671', 'Prison Croix des Bouquets', 'croix-des-bouquets', 700, 3, '0000-00-00 00:00:00'),
(84, '1834', 'Prison Fort-Liberte', 'Fort-liberte', 600, 2, '0000-00-00 00:00:00'),
(109, 'PR-1092024', 'Lasnal Penitancier', 'Cap-Haitien', 500, 50, '2024-08-08 18:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`nom`, `prenom`, `username`, `email`, `telephone`, `mot_de_passe`) VALUES
('Saintilnord', 'Ancelinio', 'Nuacky', 'saintilnordancelinio@gmail.com', '42511090', '$2y$10$z3JrReOxVpN0ky9YqcPJM.Qo49Kn6MKJNJQePdfSbQDD7r2XodqiG'),
('Gachard', 'Dorelien', 'Gach', 'gah@gmail.com', '46436876', '$2y$10$GidnUrSBdvPVvNVWzBy4ZexMbNqVLWrSQJSOzTT0EBIjHFs29OHmi'),
('Suze', 'Phara', 'Suze', 'suze@gmail.com', '5252525', '$2y$10$b5egnc8xlKf7ze3FmVf07Ow5WgMCfPDZWRZHgScSNWKegRVKAgOm6'),
('Gachard', 'Dorelien', 'Gach', 'suze@gmail.com', '0202020', '$2y$10$stIjc3WQWBAw5CWFwpPyVO.vUPiq6ehsUzUs9cYRE9/nOmLzoZtOq'),
('Gachard', 'Dorelien', 'root', 'suze@gmail.com', '0202020', '$2y$10$Phmmq49gGKG.fJY3KERSe.GflxaHuR2FKm2A1khSrk54EdVsLXkJm'),
('Gachard', 'Dorelien', 'Gach', 'suze@gmail.com', '0202020', '$2y$10$TR4Go9.uEPfQU4DLxPo1nOExtmx3XuFRfb61QHadV2EReHFSDNvTC'),
('Dolcine', 'Lounedala', 'junior', 'saintilnordancelinio@gmail.com', '45678909', '$2y$10$hIlFHiE9TsZqlivKN6hwauB5IlTBOMZzJ2qM2usw.vk6SvUvBmEoe'),
('Saint-preux', 'Loukervens', 'Papout', 'papout@gmail.com', '553553', '$2y$10$Y21R72zRfoLS5YDDVCRzQu9.3sA/JwDh7EbfBQd9TYP5zn4kX/Dny'),
('Saint-preux', 'Loukervens', 'Papout', 'papout@gmail.com', '553553', 'papout');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
