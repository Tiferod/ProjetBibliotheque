<div class="menu">
	<a href=admin_home.php>Accueil administrateur</a>
	<a href=admin_abonnes.php>Gestion abonnés</a>
	<a href=admin_documents.php>Gestion documents</a>
	<a href=admin_emprunts.php>Enregistrer un emprunt</a>
	<a href=admin_retours.php>Enregistrer un retour</a>
	<a href=admin_mod.php>Outils de monitoring</a>
</div>
<div>Vous êtes connecté en tant que <?php echo $prenom . " " . $nom; ?>.</div>
<div><a href="logout.php">Se déconnecter</a></div>
<?php
	if (!$_SESSION['is_admin']) {
		header("location: home.php");
	}
?>