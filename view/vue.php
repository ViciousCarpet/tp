<?php
//********************************************* ADMIN : $_SESSION["connexion"] = 0 ************************** */
class vue {
	
	private function entete($lesCategories) {
		echo "
			<!DOCTYPE html>
			<html>
				<head>
					<meta charset='UTF-8'>
					<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

					<link rel=\"stylesheet\" href=\"css/bootstrap.min.css\">
					<link rel=\"stylesheet\" href=\"css/style.css\">

					<title>BOUTIQ</title>
				</head>
				<body>
				<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark\">
					<a class=\"navbar-brand\" href=\"index.php?action=accueil\">BOUTIQ</a>
					<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
						<span class=\"navbar-toggler-icon\"></span>
					</button><div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
						<ul class=\"navbar-nav mr-auto\">
							<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=accueil\">
									Accueil
								</a>
							</li>";
							if(isset($_SESSION["connexion"])&&$_SESSION["connexion"]==0){
								echo "<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
								<ul class=\"navbar-nav mr-auto\">
									<li class=\"nav-item\">
										<a class=\"nav-link\" href=\"index.php?action=admin_devis\">
											Demandes devis
										</a>
									</li>
									";
							}
							echo"<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=cliReponseDevis\">
									Réponses devis
								</a>
							</li>
							<li class=\"nav-item dropdown\">
								<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
									Catégories
								</a>
								<div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
			";
			foreach($lesCategories as $uneCategorie) {
				echo "<a class=\"dropdown-item\" href=\"index.php?action=categorie&id=".$uneCategorie["idCategorie"]."\">".$uneCategorie["nomCategorie"]."</a>";
			}			

			echo "
								</div>
							</li>
			";

			if(isset($_SESSION["connexion"])) {"
							<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=deconnexion\">Déconnexion</a>
							</li>
				";
			}
			else {
				echo "
							<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=connexion\">Connexion</a>
							</li>
							<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=inscription\">Inscription</a>
							</li>
				";
			}
			
		echo "
							
						</ul>
						<ul class=\"my-2 my-lg-0 navbar-nav\">
							<li class=\"nav-item\" style=\"margin-left:20px;\">
								<a class=\"nav-link active\" href=\"index.php?action=panier\">
									Panier 
			";

		if(isset($_SESSION["panier"])) {
			echo "(".count($_SESSION["panier"]).")";
		}
		else {
			echo "(0)";
		}

		echo "
								</a>
							</li>
						</form>
					</div>
				</nav>
				<div id=\"content\">
		";
	}
	
	private function fin() {
		echo "
					</div>
					<script src=\"js/jquery-3.5.1.min.js\"></script>
					<script src=\"js/bootstrap.min.js\"></script>
				</body>
			</html>
		";
	}

	public function accueil($lesCategories) {
		$this->entete($lesCategories);

		echo "
			<h1>Bienvenue dans BOUTIQ !</h1>
		";

		$this->fin();
	}

	public function connexion($lesCategories, $message = null) {
		$this->entete($lesCategories);

		echo "
			<form method='POST' action='index.php?action=connexion'>
				<h1>Se connecter :</h1>
				<br/>";

				if(isset($message))
				{
					echo "
				<div class=\"alert alert-primary\" role=\"alert\">
					".$message."
				</div>
				<br/>";
				}

		echo	"<div class=\"form-group\">
					<label for=\"email\">Adresse email</label>
					<input type=\"email\" name=\"email\" class=\"form-control\" id=\"email\" placeholder=\"name@example.com\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"motdepasse\">Mot de passe</label>
					<input type=\"password\" name=\"motdepasse\" class=\"form-control\" id=\"motdepasse\" placeholder=\"●●●●●●\" required>
				</div>
				<br/>
				<a href=\"index.php?action=inscription\">Vous n'êtes pas encore client ? Inscrivez-vous !</a>
				<br/>
				<br/>
				<br/>
				<button type=\"submit\" class=\"btn btn-primary\" name=\"ok\">Connexion</button>
			</form>
		";

		$this->fin();
	}

	public function inscription($lesCategories, $message = null) {
		$this->entete($lesCategories);

		echo "
			<form method='POST' action='index.php?action=inscription'>
				<h1>S'inscrire :</h1>
				<br/>";
				
				if(isset($message))
				{
					echo "
					<div class=\"alert alert-primary\" role=\"alert\">
						".$message."
					</div>
					<br/>";
				}

				
		echo	"<div class=\"form-group\">
					<label for=\"nom\">Votre nom</label>
					<input type=\"text\" name=\"nom\" class=\"form-control\" id=\"nom\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"prenom\">Votre prénom</label>
					<input type=\"text\" name=\"prenom\" class=\"form-control\" id=\"prenom\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"email\">Adresse email</label>
					<input type=\"email\" name=\"email\" class=\"form-control\" id=\"email\" placeholder=\"name@example.com\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"motdepasse\">Mot de passe</label>
					<input type=\"password\" name=\"motdepasse\" class=\"form-control\" id=\"motdepasse\" placeholder=\"●●●●●●\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"motdepasse2\">Confirmer le mot de passe</label>
					<input type=\"password\" name=\"motdepasse2\" class=\"form-control\" id=\"motdepasse2\" placeholder=\"●●●●●●\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"adresse\">Votre adresse</label>
					<input type=\"text\" name=\"adresse\" class=\"form-control\" id=\"adresse\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"cp\">Votre code postal</label>
					<input type=\"text\" name=\"cp\" class=\"form-control\" id=\"cp\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"ville\">Votre ville</label>
					<input type=\"text\" name=\"ville\" class=\"form-control\" id=\"ville\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"tel\">Votre numéro de téléphone (facultatif)</label>
					<input type=\"tel\" name=\"tel\" class=\"form-control\" id=\"tel\">
				</div>
				<br/>
				<a href=\"index.php?action=connexion\">Vous êtes déjà client ? Connectez-vous !</a>
				<br/>
				<br/>
				<br/>
				<button type=\"submit\" class=\"btn btn-primary\" name=\"ok\">Inscription</button>
			</form>
		";

		$this->fin();
	}

	public function produit($lesCategories, $infoArticle, $message) {
		$this->entete($lesCategories);

		// Fiche du produit à construire
		echo "<h2>".$infoArticle['designationProduit']."</h2>

		<div class=\"container\">
		<div class=\"row\">";
		$phot=new Photo();
		$res=$phot->getPhotoProduit($_GET["id"]);
		foreach($res as $value){
			echo "<div class=\"col\"><img  src='./images/".$value[0]."' width='200'>";
			
		if(isset($_GET["action"])&&$_GET["action"]=="devis"){
			echo"<div class=\"col\">
			<br />
			<br />";
			// $this->devis($_GET["id"]);
		}
		else{
			echo"<div class=\"col\">
			<br />";
			if(is_null($infoArticle["prixProduit"])){
				echo"<form action='' method='POST' name='ajoutArticle'>
				<input type='submit' name='ajoutPanier' value='Demander un devis'/>";
				if(isset($_POST["ajoutPanier"])){
					header('Location: ./index.php?action=devis&id='.$_GET["id"]);
				}		
			}
			else{
				echo"<p><b>".$infoArticle['prixProduit']."€</b></p>";
				echo"<form action='' method='POST' name='ajoutArticle'>
				<select name='quantite'>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select>
				<input type='submit' name='ajoutPanier' value='Ajouter au panier'/>";
			}	
			echo"</form><br />";
		}
		if(isset($message)){
			echo "<div class=\"alert alert-primary\" role=\"alert\">".$message."</div>";
		}
		echo "</div>
		</div>";
		$this->fin();	
	}
	}
	public function devis($leProduit){//********************************************************************************* */
		$lesCategories = (new categorie)->getAll();
		$mes=null;
		$this->produit($lesCategories,$leProduit, $mes);
		if(isset($_SESSION["connexion"])){
			?>
				<form method="post">
					<br /><br />
					<table>
					<tr><td><label for="qt">Quantité : </label></td><td><input type="number" name="qt" placeholder="Quantité"></td></tr>
					<tr><td><input type='submit' name="Valider"></td></tr>
					</table>
				</form>
			<?php
			if(isset($_POST["Valider"])){
				$co=new commande;
				if($co->faireUnDevis($_GET["id"])){
					$message="La demande de devis à bien été soumise au vendeur";
				}
				else if(!$co->faireUnDevis($_GET["id"])){
					$message="Une erreur est survenue";
				}

			}
		}
	}

	public function panier($lesCategories, $lesArticles, $message) {
		$this->entete($lesCategories);

		echo "
			<h1>Panier :</h1>
			<form method='POST' action='index.php?action=commander'>
				<table class=\"table table-striped\">
					<tr>
						<th>Désignation des articles</th>
						<th>Prix unitaire</th>
						<th>Quantité</th>
						<th>TOTAL</th>
						<th>Supprimer</th>
					</tr>
		";

		// Créer un ligne du tableau pour chaque article du panier. Mettre un bouton supprimer dans la dernière colonne pour supprimer l'article du panier
		
		foreach($lesArticles as $ligne)
		{
			echo "
				<tr>
					<td>".$ligne['designationProduit']."</td>
					<td>".$ligne['prixProduit']."</td>
					<td>".$ligne['quantite']."</td>";
					
					if(is_null($ligne["prixProduit"]) && is_null($ligne["quantite"]))
					echo '<script>alert("Le prix se fait par devis");</script>';
					else
					echo"<td>".$ligne['prixProduit']*$ligne['quantite']."€</td>";
					
					echo"<td><button type='submit' class=\"btn btn-secondary btn-sm\" name='supprimer' value='".$ligne['codeProduit']."'>Supprimer</button></td>
				</tr>
			";
		}

		echo "
				</table>

				<button type='submit' class=\"btn btn-primary\" name='valider'>Valider le panier</button>
			</form>
			<br/>
		";

		if(isset($message))
		{
			foreach($message as $prodHS)
			echo "<div class=\"alert alert-primary\" role=\"alert\">Un produit que vous désirez acheter est hors-stock : <b>".$prodHS['designationProduit']."</b></div><br/>";
		}

		$this->fin();
	}

	public function categorie($lesCategories, $lesArticles, $nomCategorie) {
		$this->entete($lesCategories);

		echo "
			<h1>".$nomCategorie[0]."</h1>

			<div class=\"container\">
				<div class=\"row row-cols-3\" id=\"grilleProduit\">
		";

		// Afficher les articles de la catégorie sous forme de grille (https://getbootstrap.com/docs/4.5/layout/grid/#row-columns) avec pour chaque article, à afficher : photo, désignation
		// (avec lien pour aller sur la page du produit), prix
		foreach($lesArticles as $leProduit)
		{
			echo "
			<div class=\"col\"><a href='index.php?action=produit&id=".$leProduit['codeProduit']."'><p>".$leProduit['designationProduit']."</p>";
			$phot=new Photo();
			$photo = $phot->getPhotoProduit($leProduit["codeProduit"]);
			echo"<img src='./images/".$photo[0][0]."' width='150'></a>";

			if(is_null($leProduit['prixProduit'])){
				echo "Prix par devis";
			}
			else{
				echo"<p>".$leProduit['prixProduit']."€</p></div>";
			}
			
		
		}

		echo "
				</div>
			</div>
		";

		$this->fin();
	}

	public function commandeValidee($lesCategories) {
		$this->entete($lesCategories);

		echo "
			<h1>Commande effectuée !</h1>
			<p>
				Votre commande a été validée avec succès !
			</p>
		";

		$this->fin();
	}

	public function affichageDevis($lesCategories){
		$this->entete($lesCategories);
		if(isset($_SESSION["connexion"])&&$_SESSION["connexion"]==0){
			$lesDemandesDevis=(new commande)->getLesDemandesDevis();
			echo "<form method='post'><table class=\"table table-striped\">
					<thead>
					<th scope='col'>#</th><th scope='col'>Numéro de demande</th><th scope='col'>Date de la demande</th><th scope='col'>Client</th><th scope='col'>Traiter le devis</th>
					</thead><tbody>";
			foreach($lesDemandesDevis as $index=>$param){
				$idx=$index+1;
				
					echo"<tr><th scope='row'> $idx </th>
					<td>".$param["numeroCommande"]."</td><td>".$param["dateCommande"]."</td><td>".$param["idClient"]."</td><td><button class='btn btn-dark' name='traiter' value='".$param["numeroCommande"]."'>Traiter la demande</button></td></tr>
					";

			}
			echo "</table></form>";
			if(isset($_POST['traiter'])){
				header("Location: ./index.php?action=admin_devis&numdevis=".$_POST["traiter"] );
			}
		
		}
		else{
			header("Location: ./index.php?action=accueil");
			exit();
		}
		
	}

	public function detailsDevis($lesCategories,$ledevis){
		$this->entete($lesCategories);
		$mondevis=(new commande)->getLesDetailsDevis($ledevis);
		$monproduit=(new produit)->getInfosProduit($mondevis[0]["codeProduit"]);
		// var_dump($monproduit);
		// var_dump($mondevis);
		echo'<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
		<div class="card-header">Devis n°'.$mondevis[0]["numeroCommande"].'</div>
		<div class="card-body">
			<h5 class="card-title">'.$monproduit["designationProduit"].'</h5>
			<p class="card-text">Produit :'.$mondevis[0]["codeProduit"].'<br />
			Quantité : '.$mondevis[0]["quantite"].'
			<form method=post><button class="btn btn-outline-light" name="prix">Donner un devis</button></form></p>
		</div>
		</div>';
		if(isset($_POST["prix"])){
			header("Location: ./index.php?action=reponseDevis&numdevis=".$_GET["numdevis"]);
		}
	}
	
	public function reponseDevis($lesCategories,$ledevis){
		$this->entete($lesCategories);
		echo "<form method='post'>
		<label for='prix'>Prix énoncé : </label><input type='number' name='prix' min='0' step='0.01' max='99999999,99' placeholder='Prix en €'>
		<input type='submit' name='Valider'>
		</form>";
		if(isset($_POST["Valider"])){
			try{
				(new commander)->repondreDevis($_POST["prix"],$_GET["numdevis"]);
				echo "La réponse du devis à bien été envoyée.";
				header("Refresh:3; url=index.php?action=admin_devis");
			}
			catch(PDOException $e){
				echo "<script>alert('La réponse s\'est mal passée !');</script>";
			}
		}
	}
	public function cliReponseDevis($lesCategories){
		$this->entete($lesCategories);
		$lesDevis=(new commander)->GetAllcommander($_SESSION["connexion"]);
		// var_dump($lesDevis);
		$valider=null;
		foreach($lesDevis as $index=>$param){

			$leProduit=(new produit)->getInfosProduit($lesDevis[$index]["codeProduit"]);
// var_dump($leProduit);
			echo'<form method="post"><div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
				<div class="card-header">Devis n°'.$lesDevis[$index]["numeroCommande"].'</div>
					<div class="card-body">
						<p class="card-text">Produit :'.$leProduit["designationProduit"].'<br />
							Quantite : '.$lesDevis[$index]["quantite"].' <br />
							Prix du devis : '.$lesDevis[$index]["prixDevis"].' <br />
							<br /> <button class="btn btn-outline-light" value="'.$lesDevis[$index]["numeroCommande"].'" name="accepter">Accepter</button>
							<br /> <button class="btn btn-outline-light" value="'.$lesDevis[$index]["numeroCommande"].'" name="refuser">Refuser</button>
						</form></p>
					</div>
				</div>';
		}
		if(isset($_POST["accepter"])){
			$valider=(new commande)->validerDevis($_POST["accepter"]);
			header("Refresh: 0; url=index.php?action=cliReponseDevis");
		}
		if(isset($_POST["refuser"])){
			$refuser=(new commande)->refuserDevis($_POST["refuser"]);
			header("Refresh: 0; url=index.php?action=cliReponseDevis");
		}
	}

	public function erreur404($lesCategories) {
		http_response_code(404);
		
		$this->entete($lesCategories);

		echo "
			<h1>Erreur 404 : page introuvable !</h1>
			<br/>
			<p>
				Cette page n'existe pas ou a été supprimée !
			</p>
		";

		$this->fin();
	}
}