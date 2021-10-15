-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour ecommerce
CREATE DATABASE IF NOT EXISTS `ecommerce` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ecommerce`;

-- Listage de la structure de la table ecommerce. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table ecommerce.categorie : ~3 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`idCategorie`, `nomCategorie`) VALUES
	(1, 'Accessoires'),
	(2, 'Instruments'),
	(5, 'Montage');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table ecommerce. client
CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
  `nomClient` varchar(50) DEFAULT NULL,
  `prenomClient` varchar(50) DEFAULT NULL,
  `emailClient` varchar(50) DEFAULT NULL,
  `motDePasseClient` varchar(500) DEFAULT NULL,
  `rueClient` varchar(50) DEFAULT NULL,
  `cpClient` varchar(5) DEFAULT NULL,
  `villeClient` varchar(50) DEFAULT NULL,
  `telClient` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idClient`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table ecommerce.client : ~4 rows (environ)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`idClient`, `nomClient`, `prenomClient`, `emailClient`, `motDePasseClient`, `rueClient`, `cpClient`, `villeClient`, `telClient`) VALUES
	(3, 'Lucas', 'Chevalot', 'lucas.chevalot@gmail.com', '$2y$10$qJZGoizlRObBHtcfHlNztOwjSumUsSqmJYAf.bKqIWzCq6W7VVp6C', '15 rue du gué', '55000', 'Bar le duc', '0648789090'),
	(4, 'blabla', 'bla', 'mdflsdfm@exemple.com', '$2y$10$28TnXAYin9NGjYVSmOVqtOMcoJI/nnVjbFlQBTM5TUl8jvsbSMMWu', 'msdlf;', '12345', 'zrmlg;z', ''),
	(5, 'knsd', 'lsdnfm', 'lskfdlq@lsmdf.com', '$2y$10$rAuGNSyumCGRbh5SODG9Neeli4uYs2UWpIVhfD/26mMSTNpeoWPUq', 'klfdj', '45678', 'kfeajln', ''),
	(6, 'sksl', 'lsfdk', 'soudierkilian@gmail.com', '$2y$10$9d8kquzMvaHJ1xMYIX5GjeLF4U/vlczYzO/z9kpRqJ7iRkKWSY6wK', 'zdklfj', '79954', 'lsdpfkm', '');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Listage de la structure de la table ecommerce. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `numeroCommande` int(11) NOT NULL AUTO_INCREMENT,
  `dateCommande` date DEFAULT NULL,
  `idClient` int(11) DEFAULT NULL,
  `devis` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`numeroCommande`),
  KEY `FK_commande_client` (`idClient`),
  CONSTRAINT `FK_commande_client` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Listage des données de la table ecommerce.commande : ~0 rows (environ)
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` (`numeroCommande`, `dateCommande`, `idClient`, `devis`) VALUES
	(19, '2021-09-27', 4, 0),
	(20, '2021-10-15', 6, 1);
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;

-- Listage de la structure de la table ecommerce. commander
CREATE TABLE IF NOT EXISTS `commander` (
  `numeroCommande` int(11) NOT NULL DEFAULT '0',
  `codeProduit` int(11) NOT NULL DEFAULT '0',
  `quantite` int(11) NOT NULL DEFAULT '0',
  KEY `FK_commander_commande` (`numeroCommande`),
  KEY `FK_commander_produit` (`codeProduit`),
  CONSTRAINT `FK_commander_commande` FOREIGN KEY (`numeroCommande`) REFERENCES `commande` (`numeroCommande`),
  CONSTRAINT `FK_commander_produit` FOREIGN KEY (`codeProduit`) REFERENCES `produit` (`codeProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table ecommerce.commander : ~2 rows (environ)
/*!40000 ALTER TABLE `commander` DISABLE KEYS */;
INSERT INTO `commander` (`numeroCommande`, `codeProduit`, `quantite`) VALUES
	(19, 13, 1),
	(19, 15, 1);
/*!40000 ALTER TABLE `commander` ENABLE KEYS */;

-- Listage de la structure de la table ecommerce. photo
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int(11) NOT NULL AUTO_INCREMENT,
  `photos` varchar(50) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_photo`),
  KEY `FK_photo_produit` (`id_produit`),
  CONSTRAINT `FK_photo_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`codeProduit`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table ecommerce.photo : ~8 rows (environ)
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

-- Listage de la structure de la table ecommerce. produit
CREATE TABLE IF NOT EXISTS `produit` (
  `codeProduit` int(11) NOT NULL AUTO_INCREMENT,
  `designationProduit` varchar(50) NOT NULL DEFAULT '0',
  `prixProduit` double(10,2) NOT NULL DEFAULT '0.00',
  `stockProduit` int(11) NOT NULL DEFAULT '0',
  `idCategorie` int(11) NOT NULL DEFAULT '0',
  `typeProduit` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codeProduit`),
  KEY `FK_produit_categorie` (`idCategorie`),
  CONSTRAINT `FK_produit_categorie` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Listage des données de la table ecommerce.produit : ~5 rows (environ)
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` (`codeProduit`, `designationProduit`, `prixProduit`, `stockProduit`, `idCategorie`, `typeProduit`) VALUES
	(13, 'Guitare électrique', 854.68, 1, 2, 'Prix fixe'),
	(15, 'Guitare électrique deux manches', 256.87, 3, 2, 'Prix fixe'),
	(17, 'Cordes guitare 10-46', 10.00, 20, 1, 'Prix fixe'),
	(18, 'Cordes basse fluo', 50.00, 10, 1, 'Prix fixe'),
	(20, 'Montage des cordes', 0.00, 0, 5, 'Sur devis');
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
