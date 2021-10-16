<?php
session_start();
?><form method="post"><button name="deco">Déconnexion</button></form>
<?php
if(isset($_POST["deco"])){
session_destroy();
}
// Test de connexion à la base
$config = parse_ini_file("config.ini");
try {
	$pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
} catch(Exception $e) {
	echo "<h1>Erreur de connexion à la base de données :</h1>";
	echo $e->getMessage();
	exit;
}

// Chargement des fichiers MVC
require("control/controleur.php");
require("view/vue.php");
require("model/categorie.php");
require("model/client.php");
require("model/commande.php");
require("model/commander.php");
require("model/produit.php");
require("model/photo.php");

// Routes
if(isset($_GET["action"])) {
	switch($_GET["action"]) {
		case "accueil":
			(new controleur)->accueil();
			break;

		case "connexion":
			(new controleur)->connexion();
			break;

		case "inscription":
			(new controleur)->inscription();
			break;

		case "produit":
			(new controleur)->produit();
			break;

		case "panier":
			(new controleur)->panier();
			break;
		
		case "categorie":
			(new controleur)->categorie();
			break;

		case "commander":
			(new controleur)->commander();
			break;

		case "deconnexion":
			(new controleur)->deconnexion();
			break;
			
		case "devis":
			(new controleur)->devis();
			break;
		case "admin_devis":
			(new controleur)->admin_devis();
			break;
		
		// Route par défaut : erreur 404
		default:
			(new controleur)->erreur404();
			break;
	}
}
else {
	// Pas d'action précisée = afficher l'accueil
	(new controleur)->accueil();
}