-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 22 jan. 2023 à 20:24
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
-- Base de données : `testslash`
--

-- --------------------------------------------------------

--
-- Structure de la table `chrono`
--

DROP TABLE IF EXISTS `chrono`;
CREATE TABLE IF NOT EXISTS `chrono` (
  `chrono_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `debut` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fin` datetime DEFAULT NULL,
  `tache_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`chrono_id`),
  KEY `chrono_taches` (`tache_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `evenement_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_evenement` varchar(255) NOT NULL,
  `nom_client` varchar(155) NOT NULL,
  `duree` varchar(20) DEFAULT NULL,
  `commentaire` text,
  `id_utilisateur` int UNSIGNED NOT NULL,
  `id_metier` int UNSIGNED NOT NULL,
  PRIMARY KEY (`evenement_id`),
  KEY `id-metier` (`id_metier`),
  KEY `evenements_utilisateurs` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`evenement_id`, `nom_evenement`, `nom_client`, `duree`, `commentaire`, `id_utilisateur`, `id_metier`) VALUES
(5, 'Dessin Cours', 'Khalid', NULL, 'Nouveau cours', 3, 16),
(6, 'Cours de yoga', 'Sofiane', NULL, 'Cours 1', 2, 17),
(7, 'Mind mapping', 'Alexis', NULL, 'Projet', 3, 16),
(8, 'Yoga', 'Alex', NULL, 'Cours', 3, 16),
(9, 'Creation Slash', 'Esther', NULL, 'Test', 3, 16),
(10, 'Jouer', 'Alexis', NULL, 'Jeux-vidéos', 3, 18),
(11, 'Organiser Voyage Suède', 'Stephane et Blandine', NULL, '', 6, 20),
(12, 'Organiser Voyage Finlande', 'Khalid', NULL, '', 6, 20),
(13, 'Entretien', 'Amine', NULL, '', 6, 21),
(14, 'Mind mapping', 'Esther', NULL, '', 2, 22);

-- --------------------------------------------------------

--
-- Structure de la table `metiers`
--

DROP TABLE IF EXISTS `metiers`;
CREATE TABLE IF NOT EXISTS `metiers` (
  `id_metier` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(120) NOT NULL,
  `couleur` varchar(120) NOT NULL,
  `icone` varchar(120) NOT NULL,
  `id_utilisateur` int UNSIGNED NOT NULL,
  `id_sphere` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id_metier`),
  KEY `metiers_utilisateurs` (`id_utilisateur`),
  KEY `metiers_spheres` (`id_sphere`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `metiers`
--

INSERT INTO `metiers` (`id_metier`, `nom`, `couleur`, `icone`, `id_utilisateur`, `id_sphere`) VALUES
(16, 'Coaching', '#C0E3F4', 'uploads/unnamed.png', 3, 1),
(17, 'Professeur', '#C0E3F4', 'uploads/unnamed.png', 2, 1),
(18, 'Jeux vidéos', '#B0DBCF', 'uploads/index.png', 3, 2),
(19, 'Développeur web', '#848484', '', 3, 1),
(20, 'Organisatrice de voyage', '#CDA680', '', 6, 1),
(21, 'Paysagiste', '#C0E3F4', '', 6, 1),
(22, 'Illustration', '#C0E3F4', '', 2, 1),
(23, 'Paddle', '#FB2CF4', '', 2, 2),
(24, 'Codeur', '#2D2D2D', '', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_recover`
--

DROP TABLE IF EXISTS `password_recover`;
CREATE TABLE IF NOT EXISTS `password_recover` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token_user` varchar(130) NOT NULL,
  `token` varchar(130) NOT NULL,
  `date_recover` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `password_recover`
--

INSERT INTO `password_recover` (`id`, `token_user`, `token`, `date_recover`) VALUES
(2, '9a6dbddf2ecdc1d761bfe4e8715663db375dacc56d9e75aa', 'c281dcb40a0acca7508084859d6c3aaeb7cf31b401bc0ee0', '2022-11-04 16:07:26');

-- --------------------------------------------------------

--
-- Structure de la table `recette_depense`
--

DROP TABLE IF EXISTS `recette_depense`;
CREATE TABLE IF NOT EXISTS `recette_depense` (
  `id_recette` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `recette` float NOT NULL,
  `depense` float NOT NULL,
  `evenement_id` int UNSIGNED NOT NULL,
  `id_utilisateur` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id_recette`),
  KEY `recettes_depenses_evenements` (`evenement_id`),
  KEY `recettes_depenses_utilisateurs` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `recette_depense`
--

INSERT INTO `recette_depense` (`id_recette`, `recette`, `depense`, `evenement_id`, `id_utilisateur`) VALUES
(18, 150, 20, 8, 3),
(19, 500, 200, 9, 3),
(20, 200, 100, 8, 3),
(21, 60, 150, 9, 3),
(22, 0, 400, 10, 3),
(23, 150, 200, 14, 2),
(24, 80, 10, 14, 2);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`role_id`, `label`) VALUES
(1, 'admin'),
(2, 'utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `spheres`
--

DROP TABLE IF EXISTS `spheres`;
CREATE TABLE IF NOT EXISTS `spheres` (
  `sphere_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sphere_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `spheres`
--

INSERT INTO `spheres` (`sphere_id`, `label`) VALUES
(1, 'Pro'),
(2, 'Perso');

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

DROP TABLE IF EXISTS `taches`;
CREATE TABLE IF NOT EXISTS `taches` (
  `tache_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `date_debut` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL,
  `etat` int NOT NULL DEFAULT '0',
  `id_utilisateur` int UNSIGNED NOT NULL,
  `evenement_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`tache_id`),
  KEY `taches_evenements` (`evenement_id`),
  KEY `taches_utilisateurs` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `taches`
--

INSERT INTO `taches` (`tache_id`, `label`, `date_debut`, `image`, `etat`, `id_utilisateur`, `evenement_id`) VALUES
(6, 'Cours Jeudi', '2022-12-01 15:34:54', 'tacheimg/ITV_2.png', 0, 3, 5),
(7, 'Appeler l\'agence', '2022-12-05 21:54:32', '', 0, 6, 11),
(8, 'Jardin d\'Amine', '2022-12-05 21:56:51', 'tacheimg/1635499819841.jpg', 0, 6, 13),
(9, 'Préparation', '2022-12-07 02:36:31', '', 0, 2, 14),
(10, 'Reunion', '2022-12-07 09:55:40', 'tacheimg/21-e1427148373713.jpg', 0, 3, 9);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(130) DEFAULT NULL,
  `role_id` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateurs_roles` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `email`, `password`, `avatar`, `date_inscription`, `token`, `role_id`) VALUES
(2, 'Esther', 'esther@gmail.com', '$2y$12$BalWT5v4ki4qjx/6WDpqhepBB0wTOp/BsdW1psZezoMej.Xb4zU9S', '2.jpg', '2022-09-16 10:15:55', NULL, 1),
(3, 'Alex', 'alexisdev@gmail.com', '$2y$12$bV7MPofR/Ikf7nUa0l5q3eiWrzeJKq1KlN1KFKXGaqqeuUwtH8yEK', '3.gif', '2022-09-30 09:46:43', NULL, NULL),
(5, 'toto', 'toto@gmail.com', '$2y$12$/woYMoXuYJqfkSK7KGChoe5tcNyRYeKrb9CHgUgFg9K1xIXaOdaNi', NULL, '2022-11-24 10:20:43', '9afb86f27d894c6621490d00f5142378925e7ed1b6dffe4d', NULL),
(6, 'Blandine', 'blandine@gmail.com', '$2y$12$/mPn73Sk41qTNtcc0BCUMesV0tpwRfoAczWFvrwTVYjWcE8OGdYuG', '6.png', '2022-12-05 21:47:24', '5b99f0345cfba64e97d3b1a9afcc89d68ac42286f230b3de', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chrono`
--
ALTER TABLE `chrono`
  ADD CONSTRAINT `chrono_taches` FOREIGN KEY (`tache_id`) REFERENCES `taches` (`tache_id`);

--
-- Contraintes pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD CONSTRAINT `evenements_utilisateurs` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `id-metier` FOREIGN KEY (`id_metier`) REFERENCES `metiers` (`id_metier`);

--
-- Contraintes pour la table `metiers`
--
ALTER TABLE `metiers`
  ADD CONSTRAINT `metiers_spheres` FOREIGN KEY (`id_sphere`) REFERENCES `spheres` (`sphere_id`),
  ADD CONSTRAINT `metiers_utilisateurs` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `recette_depense`
--
ALTER TABLE `recette_depense`
  ADD CONSTRAINT `recettes_depenses_evenements` FOREIGN KEY (`evenement_id`) REFERENCES `evenements` (`evenement_id`),
  ADD CONSTRAINT `recettes_depenses_utilisateurs` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `taches`
--
ALTER TABLE `taches`
  ADD CONSTRAINT `taches_evenements` FOREIGN KEY (`evenement_id`) REFERENCES `evenements` (`evenement_id`),
  ADD CONSTRAINT `taches_utilisateurs` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
