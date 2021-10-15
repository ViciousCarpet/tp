<?php

    class Photo {
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

    public function getPhotoProduit($refprod){
		$sql="SELECT photos FROM photo WHERE id_produit = :id";

		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $refprod, PDO::PARAM_INT);
		$req->execute();
		
		return $req->fetchAll();
	}
    }