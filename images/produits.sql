-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 27 mars 2025 à 10:47
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `greenshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `detail` varchar(250) NOT NULL,
  `categorie` varchar(15) NOT NULL,
  `photo` varchar(1000) NOT NULL,
  `prix` decimal(15,0) NOT NULL,
  `remise` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `detail`, `categorie`, `photo`, `prix`, `remise`) VALUES
(1, 'Gombo frais', 'Le gombo est une plante très prisée dans la partie occidentale du continent. il est utilisé pour la ', 'légume', 'images/Gombo-frais-1.jpg', 350, 23),
(2, 'Oranges juteuse', 'Reine des agrumes, aussi juteuse que savoureuse, l\'orange est un fruit vitaminé qui fait l\'unanimité', 'fruit', 'images/orange-imported-1-kg-product-images-o590000025-p590000025-0-202410011652', 420, 17),
(3, 'Banane douce', ' Grâce aux glucides complexes qu\'elle contient, elle a un effet rassasiant qui contribue à éviter le', 'fruit', 'images/istockphoto-173242750-612x612', 320, 20),
(4, 'Tomates', 'la tomate recèle bien des vertus pour notre santé. Faiblement énergétique, riche en fibres, elle con', 'légume', 'images/image_1024.png', 500, 15),
(5, 'mangue mure', 'La mangue est un fruit riche en nutriments essentiels. Elle contient : Vitamine C, qui booste le sys', 'fruit', 'images/mangue-kent-1.jpg', 200, 14),
(6, ' Ananas frais', 'Antibactérienne, antivirale, anti-inflammatoire et immunostimulante, elle protège notre organisme co', 'fruit', 'images/UTB89hi7qhHEXKJk43Jeq6yeeXXaZ.jpg_720x720q50', 500, 10),
(7, 'Oignons violets', 'apportent des avantages similaires en raison de leur forte concentration de quercétine, un antioxyda', 'légumes', 'images/Oignon-Rouge', 400, 25),
(8, 'Piments', ' le piment a pour vertu de diminuer sensiblement la douleur due à l\'arthrite, aux rhumatismes, aux t', 'légume', 'images/piment-100-graines.jpg', 250, 19),
(9, 'Aubergines', 'Son apport vitaminique est très diversifié : vitamines B, E, C et provitamines A. L\'aubergine est la', 'légumes', 'images/Aubergine-blanche-ronde-oeuf_legume-d-ete_Jardinons-notre-sante_semences-locales', 400, 18),
(10, 'feuilles de gombo', 'Riches en fibres, les feuilles de Gombo sont un allié précieux pour la digestion. Elles jouent un rô', 'légume', 'images/1661870898lBFxUZ0O.png', 450, 17),
(11, 'Safou (Prune africaine)', 'Bonne source d’oméga-3, favorise la santé cardiaque et réduit le mauvais cholestérol.', 'fruit', 'images/safou', 740, 16),
(12, 'Corossol', 'Propriétés anti-inflammatoires, aide à réduire le stress et favorise un bon sommeil.', 'fruit', 'images/corosol', 480, 8),
(13, 'Papaye', ' Favorise la digestion grâce à la papaïne, riche en vitamines A et C.', 'fruit', 'images/Papaye_Multipage_Plante_320x245-1', 480, 0),
(14, 'Feuilles de manioc', ' Excellente source de protéines végétales et de fer, booste l’énergie.\r\n\r\n', 'légume', 'images/feuilles_manioc', 750, 26),
(15, 'Igname ', 'Source d’énergie durable, bon pour la digestion et le système immunitaire.\r\n\r\n', 'légume', 'images/1588794182----fel3275', 740, 6),
(16, 'Patate douce ', ' Antioxydant naturel, favorise la bonne santé des yeux et du cerveau.', 'légume', 'images/35919-0w470h470_Patate_Douce_Blanche_Bio', 500, 0),
(17, 'Goyave ', 'Source élevée de vitamine C, bon pour la peau et la digestion.', 'fruit', 'images/goyave', 400, 12),
(18, 'Maracuja (fruit de la passion)', 'Apaisant naturel, améliore le sommeil et bon pour le cœur.', 'fruit', 'images/maracuja-passion-fruit-40225545', 480, 10),
(19, 'Haricot Koki', 'Riche en protéines, favorise la croissance musculaire et réduit la fatigue.', 'légume', 'images/242_Fagioli_Occhio_Nero', 640, 12),
(20, 'pomme de terre', 'La pomme de terre est une source d’énergie riche en fibres, vitamines et antioxydants, bénéfique pou', 'légume', 'images/pomme_terre', 650, 8),
(21, 'la carotte', 'La carotte est riche en bêta-carotène, vitamines et antioxydants, favorisant la santé des yeux, de la peau, du système immunitaire et de la digestion, tout en étant hydratante et peu calorique. ', 'légume', 'images/carottes-ab505fc59f', 480, 5),
(22, 'Jujube ', 'Réduit l’anxiété, améliore le sommeil et riche en vitamine C.', 'fruit', 'images/Jujube-Fruit-Dried-1409706855-770x533-1_jpg', 500, 30);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
