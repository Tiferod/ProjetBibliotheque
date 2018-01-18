<?php
	session_start();
	$db = mysqli_connect("localhost", $_SESSION['pseudo'], $_SESSION['mdp'], "bibli");
	if (mysqli_connect_errno()) {
		printf("Échec de la connexion : %s\n", mysqli_connect_error());
		exit();
	}
	$verif = $_SESSION['pseudo'];
	if ($_SESSION['is_admin']) {
		$query = mysqli_query($db, "SELECT * FROM Admins WHERE pseudo = '$verif'");
	}
	else {
		$query = mysqli_query($db, "SELECT * FROM Abonnés WHERE pseudo = '$verif'");
	}
	$row = mysqli_fetch_assoc($query);
	$nom = $row['nom'];
	$prenom = $row['prénom'];
	$pseudo = $row['pseudo'];
	if(!isset($pseudo)) {
		mysqli_close($connection);
		header('Location: index.php');
	}
?>