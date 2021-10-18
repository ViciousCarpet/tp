-- --------------------------------------------------------
-- Hôte:                         172.19.0.16
-- Version du serveur:           10.1.47-MariaDB-0+deb9u1 - Debian 9.13
-- SE du serveur:                debian-linux-gnu
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour boutiq
CREATE DATABASE IF NOT EXISTS `boutiq` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `boutiq`;

-- Listage de la structure de la table boutiq. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(500) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table boutiq.categorie : ~3 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`idCategorie`, `nomCategorie`) VALUES
	(1, 'Accessoires'),
	(2, 'Instruments'),
	(5, 'Montage');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table boutiq. client
CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
  `nomClient` varchar(500) NOT NULL,
  `prenomClient` varchar(500) NOT NULL,
  `emailClient` varchar(500) NOT NULL,
  `motDePasseClient` varchar(1000) NOT NULL,
  `rueClient` varchar(1000) NOT NULL,
  `cpClient` varchar(10) NOT NULL,
  `villeClient` varchar(500) NOT NULL,
  `telClient` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idClient`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table boutiq.client : ~3 rows (environ)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`idClient`, `nomClient`, `prenomClient`, `emailClient`, `motDePasseClient`, `rueClient`, `cpClient`, `villeClient`, `telClient`) VALUES
	(3, 'Lucas', 'Chevalot', 'lucas.chevalot@gmail.com', '$2y$10$qJZGoizlRObBHtcfHlNztOwjSumUsSqmJYAf.bKqIWzCq6W7VVp6C', '15 rue du gué', '55000', 'Bar le duc', '0648789090'),
	(4, 'blabla', 'bla', 'mdflsdfm@exemple.com', '$2y$10$28TnXAYin9NGjYVSmOVqtOMcoJI/nnVjbFlQBTM5TUl8jvsbSMMWu', 'msdlf;', '12345', 'zrmlg;z', ''),
	(5, 'zkfdh', 'lsjdfm', 'smdk@mail.com', '$2y$10$YFAwl/DzO8O/y/3DcyvXCeJHn3/525pAzA6bwjdz2E5wJeRhF3Ote', 'zlkdfjm', '77845', 'kqdflj', '');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Listage de la structure de la table boutiq. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `numeroCommande` int(11) NOT NULL AUTO_INCREMENT,
  `dateCommande` date NOT NULL,
  `idClient` int(11) NOT NULL,
  `devis` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`numeroCommande`),
  KEY `commande_client_FK` (`idClient`),
  CONSTRAINT `commande_client_FK` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Listage des données de la table boutiq.commande : ~1 rows (environ)
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` (`numeroCommande`, `dateCommande`, `idClient`, `devis`) VALUES
	(19, '2021-09-27', 4, 0);
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;

-- Listage de la structure de la table boutiq. commander
CREATE TABLE IF NOT EXISTS `commander` (
  `numeroCommande` int(11) NOT NULL,
  `codeProduit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prixDevis` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`numeroCommande`,`codeProduit`),
  KEY `commander_produit0_FK` (`codeProduit`),
  CONSTRAINT `commander_commande_FK` FOREIGN KEY (`numeroCommande`) REFERENCES `commande` (`numeroCommande`),
  CONSTRAINT `commander_produit0_FK` FOREIGN KEY (`codeProduit`) REFERENCES `produit` (`codeProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table boutiq.commander : ~2 rows (environ)
/*!40000 ALTER TABLE `commander` DISABLE KEYS */;
INSERT INTO `commander` (`numeroCommande`, `codeProduit`, `quantite`, `prixDevis`) VALUES
	(19, 13, 1, NULL),
	(19, 15, 1, NULL);
/*!40000 ALTER TABLE `commander` ENABLE KEYS */;

-- Listage de la structure de la table boutiq. photo
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int(11) NOT NULL AUTO_INCREMENT,
  `photos` varchar(500) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_photo`),
  KEY `FK_photo_produit` (`id_produit`),
  CONSTRAINT `FK_photo_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`codeProduit`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table boutiq.photo : ~8 rows (environ)
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` (`id_photo`, `photos`, `id_produit`) VALUES
	(1, 'produit1.jpg', 13),
	(2, 'produit2.jpg', 13),
	(3, 'produit3.jpg', 15),
	(4, 'produit4.jpg', 15),
	(5, 'produit5.jpg', 17),
	(6, 'produit6.jpg', 18),
	(7, 'produit7.jpg', 18),
	(8, 'sur_devis.jpg', 20);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;

-- Listage de la structure de la table boutiq. produit
CREATE TABLE IF NOT EXISTS `produit` (
  `codeProduit` int(11) NOT NULL AUTO_INCREMENT,
  `designationProduit` varchar(500) NOT NULL,
  `prixProduit` decimal(10,2) DEFAULT NULL,
  `stockProduit` int(11) DEFAULT NULL,
  `idCategorie` int(11) NOT NULL,
  `typeProduit` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codeProduit`),
  KEY `produit_categorie_FK` (`idCategorie`),
  CONSTRAINT `produit_categorie_FK` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Listage des données de la table boutiq.produit : ~5 rows (environ)
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` (`codeProduit`, `designationProduit`, `prixProduit`, `stockProduit`, `idCategorie`, `typeProduit`) VALUES
	(13, 'Guitare électrique', 854.68, 1, 2, 'Prix fixe'),
	(15, 'Guitare électrique deux manches', 256.87, 3, 2, 'Prix fixe'),
	(17, 'Cordes guitare 10-46', 10.00, 20, 1, 'Prix fixe'),
	(18, 'Cordes basse fluo', 50.00, 10, 1, 'Prix fixe'),
	(20, 'Montage des cordes', NULL, NULL, 5, 'Sur devis');
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
