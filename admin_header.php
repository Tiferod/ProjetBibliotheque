<div>
	<a href=admin_home.php>Accueil administrateur</a>
	<a href=admin_abonnes.php>Gestion abonnés</a>
	<a href=admin_documents.php>Gestion documents</a>
	<a href=admin_emprunts.php>Enregistrer un emprunt</a>
	<a href=admin_retours.php>Enregistrer un retour</a>
	<a href=admin_mod.php>Outils de modération</a>
</div>
<div>Vous êtes connecté en tant que <?php echo $prenom . " " . $nom; ?>.</div>
<div><a href="logout.php">Se déconnecter</a></div>
<?php
	if (!$_SESSION['is_admin']) {
		echo "<h2>Cette page est réservée aux administrateurs. Vous n'avez pas le droit d'effectuer des modifications sur la base de données.</h2>";
	}