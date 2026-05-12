-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 11 mai 2026 à 13:54
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetproduit`
--

-- --------------------------------------------------------

--
-- Structure de la table `produit_variantes`
--

CREATE TABLE `produit_variantes` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `taille` varchar(50) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit_variantes`
--

INSERT INTO `produit_variantes` (`id`, `produit_id`, `taille`, `couleur`, `stock`) VALUES
(2, 2, '37', 'Noir', 3),
(3, 2, '40', 'Blanc', 5),
(4, 3, '36', 'Noir', 1),
(5, 3, '37', 'Blanc', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `produit_variantes`
--
ALTER TABLE `produit_variantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `produit_variantes`
--
ALTER TABLE `produit_variantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produit_variantes`
--
ALTER TABLE `produit_variantes`
  ADD CONSTRAINT `produit_variantes_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
