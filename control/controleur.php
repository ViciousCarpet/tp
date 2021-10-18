<?php
class controleur {
	
	public function accueil() {
		$lesCategories = (new categorie)->getAll();
		(new vue)->accueil($lesCategories);
	}
	
	public function erreur404() {
		$lesCategories = (new categorie)->getAll();
		(new vue)->erreur404($lesCategories);
	}

	public function connexion($message = null) {
		if(isset($_POST["ok"])) {
			$leClient = (new client);

			if($leClient->connexion($_POST['email'], $_POST['motdepasse']))
			{	
				$lesCategories = (new categorie)->getAll();
				(new vue)->accueil($lesCategories);
			}
			else
			{
				$lesCategories = (new categorie)->getAll();
				(new vue)->connexion($lesCategories, "Login ou Mot de passe incorrect");
			}
			
		}
		else {
			$lesCategories = (new categorie)->getAll();
			(new vue)->connexion($lesCategories);
		}
	}

	public function devis(){

		$lesCategories = (new categorie)->getAll();
		$leArticle= $_GET["id"];
		$infosArticle = (new produit)->getInfosProduit($_GET["id"]);

		(new vue)->devis($infosArticle);
	}

	public function inscription($message = null) {
		if(isset($_POST["ok"])) {
			$leClient = (new client);

			if($leClient->estDejaInscrit($_POST['email']))
			{
				$lesCategories = (new categorie)->getAll();
				(new vue)->inscription($lesCategories, "Email déjà utilisé");
			}
			else
			{
				if($_POST["motdepasse"] == $_POST["motdepasse2"])
				{
				$leClient->inscriptionClient($_POST['nom'], $_POST['prenom'], $_POST['email'], password_hash($_POST['motdepasse'], PASSWORD_DEFAULT), $_POST['adresse'], $_POST['cp'], $_POST['ville'], $_POST['tel']);

				$lesCategories = (new categorie)->getAll();
				(new vue)->accueil($lesCategories);
				}
				else
				{
					$lesCategories = (new categorie)->getAll();
					(new vue)->inscription($lesCategories, "Mots de passe non correspondants");
				}
			}			
		}
		else
		{
			$lesCategories = (new categorie)->getAll();
			(new vue)->inscription($lesCategories);
		}
	}

	public function produit() {
		if(isset($_GET["id"])) {
			$lesCategories = (new categorie)->getAll();
			$infosArticle = (new produit)->getInfosProduit($_GET["id"]);

			if(count($infosArticle) > 0) {
				$message = null;

				// Action du bouton ajouter au panier sur la page du produit
				if(isset($_POST["ajoutPanier"]) && isset($_POST["quantite"])) {
					if((new produit)->estDispoEnStock($_POST["quantite"], $_GET["id"])) {
						if(!(isset($_SESSION["panier"]))) {
							$_SESSION["panier"] = array();
						}
						for($i = 0; $i < $_POST["quantite"]; $i++) {
							array_push($_SESSION["panier"], $_GET["id"]);
						}

						// Message de succès à retourner à la vue
						$message = "Article ajouté au panier !";
					}
					else {
						// Message d'erreur à retourner à la vue
						$message = "Erreur, votre article n'a pas été ajouté au panier";
					}
				}

				(new vue)->produit($lesCategories, $infosArticle, $message);
			}
			else {
				(new vue)->erreur404($lesCategories);
			}
		}
		else {
			$lesCategories = (new categorie)->getAll();
			(new vue)->erreur404($lesCategories);
		}
	}

	public function panier($message = null) {
		$lesCategories = (new categorie)->getAll();
		$lesArticles = array(); // Toutes les infos des produits du panier seront dans cette variable

		// Récupérer toutes les infos des produits dans le panier
		if(isset($_SESSION['panier']))
		{
			$lesQuantites = array_count_values($_SESSION['panier']);

			foreach($lesQuantites as $key => $value)
			{
				$article = (new produit)->getInfosProduit($key);
				$article["quantite"] = $value;
				array_push($lesArticles, $article);
			}
		}
		
		(new vue)->panier($lesCategories, $lesArticles, $message);
	}

	public function commander() {
		if(isset($_POST["supprimer"])) {
			// Action de suppression d'un produit dans le panier (on mettra le code produit en value du $_POST["supprimer"])
			
			unset($_SESSION['panier'][array_search($_POST['supprimer'], $_SESSION['panier'])]);

			$this->panier();
		}

		if(isset($_POST["valider"])) {
			$lesCategories = (new categorie)->getAll();
			// Validation du panier

			/*
				On doit vérifier si l'utilisateur est connecté, si ce n'est pas le cas alors il faut l'inviter à se connecter.
				Si l'utilisateur est connecté alors il faut vérifier que la quantité commandée de chaque produit du panier soit disponbile en stock.
				Si tout est ok alors on créé sa commande dans la base et l'utilisateur doit être averti que sa commande est validée et le panier doit être vidé
				Sinon il faut revenir à la page du panier et avertir l'utilisateur quel produit (préciser sa désignation) pose problème.
			*/

			if(isset($_SESSION["connexion"]))
			{
				$dispo = true;
				$produitHS = array();
				$lesQuantites = array_count_values($_SESSION['panier']);

				foreach($lesQuantites as $key => $value)
				{
					$enStock = (new produit)->estDispoEnStock($value, $key);

					if(!$enStock)
					{
						$dispo = false;
						$produitHS[] = (new produit)->getInfosProduit($key);
					}
				}
				if($dispo)
				{
					$lesArticles = array();

					foreach($lesQuantites as $key => $value)
					{
						$article = (new produit)->getInfosProduit($key);
						$article['quantite'] = $value;
						$lesArticles[] = $article;
					}

					unset($_SESSION['panier']);

					(new commande)->validerCommande($_SESSION['connexion'], $lesArticles);
					(new vue)->commandeValidee($lesCategories);
				}
				else
				{
					$this->panier($produitHS);
				}
			}
			else
			{
				(new vue)->connexion($lesCategories);
			}
		}
	}

	public function admin_devis(){
		$lesCategories = (new categorie)->getAll();
		(new vue)->affichageDevis($lesCategories);
	}
	public function detailsDevis(){
		$lesCategories = (new categorie)->getAll();
		(new vue)->detailsDevis($lesCategories,$_GET["numdevis"]);
	}
	public function reponseDevis(){
		$lesCategories = (new categorie)->getAll();
		(new vue)->reponseDevis($lesCategories,$_GET["numdevis"]);
	}
	public function cliReponseDevis(){
		$lesCategories=(new categorie)->getAll();
		(new vue)->cliReponseDevis($lesCategories);
	}

	public function categorie() {
		$lesCategories = (new categorie)->getAll();

		$lesArticles = (new categorie)->getProduits($_GET["id"]);
		$nomCategorie = (new categorie)->getNomCategorie($_GET["id"]);

		(new vue)->categorie($lesCategories, $lesArticles, $nomCategorie);
	}

	public function deconnexion() {
		if(isset($_SESSION["connexion"])) {
			unset($_SESSION["connexion"]);
		}

		$this->accueil();
	}
}