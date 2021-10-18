<?php

class commander {
	
	// Objet PDO servant à la connexion à la base
	private $pdo;

	// Connexion à la base de données
	public function __construct() {
		$config = parse_ini_file("config.ini");
		
		try {
			$this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	// Récupère la liste des produits commandés d'une commande
	public function getProduitsCommande($commande) {
		$sql = "SELECT codeProduit, quantite FROM commander WHERE numeroCommande = :numero";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':numero', $commande, PDO::PARAM_INT);
		$req->execute();
		
		return $req->fetchAll();
	}
	public function repondreDevis($leprix,$ledevis){
		$sql ="UPDATE commander SET prixDevis=".$leprix." WHERE numeroCommande=".$ledevis;
		$req = $this->pdo->prepare($sql);
		$req->execute();
		return true;
	}

	public function getAllCommander($leclient){
		$sql="SELECT * FROM commander WHERE numeroCommande IN(SELECT numeroCommande FROM commande WHERE idClient=".$leclient." AND devis=1 AND prixDevis IS NOT NULL)";
		$req=$this->pdo->prepare($sql);
		$req->execute();
		return $req->fetchAll();
	}

	public function setProduitDevis($produit,$commande,$quantite){
		$sql="INSERT INTO commander(numeroCommande, codeProduit, quantite) VALUES (':comm',':produit',:quantite)";

		$req = $this->pdo->prepare($sql);
		$req->bindParam(':comm', $commande, PDO::PARAM_INT);
		$req->bindParam(':produit', $produit, PDO::PARAM_INT);
		$req->bindParam(':quantite', $quantite, PDO::PARAM_INT);
		$req->execute();
	}
}