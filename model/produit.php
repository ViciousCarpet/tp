<?php

class produit {
	
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
	
	// Récupère toutes les infos d'un produit
	public function getInfosProduit($produit) {
		$sql = "SELECT * FROM produit WHERE codeProduit = :code";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':code', $produit, PDO::PARAM_INT);
		$req->execute();
		
		return $req->fetch();
	}
	
	// Vérifie si la quantité désirée d'un produit est disponible en stock, retourne true si dispo, false si pas dispo
	public function estDispoEnStock($quantiteDesiree, $produit) {
		$sql = "SELECT COUNT(*) FROM produit WHERE codeProduit = :code AND stockProduit >= :quantite;";

		$req = $this->pdo->prepare($sql);
		$req->bindParam(':code', $produit, PDO::PARAM_INT);
		$req->bindParam(':quantite', $quantiteDesiree, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch();

		$verif = false;

		if($res["COUNT(*)"] > 0)
		{
			$verif = true;
		}

		return $verif;
	}
}