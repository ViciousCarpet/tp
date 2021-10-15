<?php

class commande {
	
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
	
	// Récupérer toutes les commandes d'un client passé en paramètre
	public function getCommandesClient($client) {
		$sql = "SELECT * FROM commande WHERE idClient = :id";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $client, PDO::PARAM_INT);
		$req->execute();
		
		return $req->fetchAll();
	}
	
	// Permet de créer la commande du client passé en paramètre avec l'ensemble des articles qu'il a commandé en paramètre
	public function validerCommande($client, $lesArticles,$devis) {
		$sql = "INSERT INTO commande (dateCommande, idClient, devis) VALUES (CURRENT_DATE, :id, $devis)";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $client, PDO::PARAM_INT);
		$req->execute();


		$sql = "SELECT * FROM commande WHERE dateCommande = :dateC AND idClient = :id ORDER BY numeroCommande DESC LIMIT 1";

		$req = $this->pdo->prepare($sql);
		$laDate = date('Y-m-d');
		$req->bindParam(':dateC', $laDate, PDO::PARAM_STR);
		$req->bindParam(':id', $client, PDO::PARAM_INT);
		$req->execute();

		$numCommande = $req->fetchAll()[0]['numeroCommande'];

		foreach($lesArticles as $article)
		{
			$sql = "INSERT INTO commander (numeroCommande, codeProduit, quantite) VALUES (:numC, :codeP, :quant)";

			$req = $this->pdo->prepare($sql);
			$req->bindParam(':numC', $numCommande, PDO::PARAM_INT);
			$req->bindParam(':codeP', $article['codeProduit'], PDO::PARAM_INT);
			$req->bindParam(':quant', $article['quantite'], PDO::PARAM_INT);
			$req->execute();

			$sql = "UPDATE produit SET stockProduit = (SELECT stockProduit WHERE codeProduit = :codeP) - :quant WHERE codeProduit = :codeP";

			$req = $this->pdo->prepare($sql);
			$req->bindParam(':codeP', $article['codeProduit'], PDO::PARAM_INT);
			$req->bindParam(':quant', $article['quantite'], PDO::PARAM_INT);
			$req->execute();
		}
	}
	public function faireUnDevis($produit){
		try{
			$sql="INSERT INTO commande (dateCommande, idClient, devis) VALUES ('".date("20y-m-d")."',".$_SESSION["connexion"].", 1)";
			$req=$this->pdo->prepare($sql);
			$req->execute();

			$sql2="SELECT numeroCommande FROM commande WHERE dateCommande='".date("20y-m-d")."' AND idClient=:id AND devis=1 ORDER BY numeroCommande DESC";
			$req2 = $this->pdo->prepare($sql2);
			$req2->bindParam(':id', $_SESSION["connexion"], PDO::PARAM_INT);
			$req2->execute();
			$numC = $req2->fetchAll();
			$sql3="INSERT INTO commander (numeroCommande, codeProduit, quantite) VALUES (".$numC[0]["numeroCommande"].", ".$_GET["id"].", ".$_POST["qt"].")";
			$req3=$this->pdo->prepare($sql3);
			$req3->execute();
			echo "La demande de devis à bien été soumise au vendeur.";
			return true;
		}
		catch(PDOException $e){
			echo "<script>alert('La demande de devis a échouée veuillez recommencer !');</script>";
			return false;
		}
	}
}