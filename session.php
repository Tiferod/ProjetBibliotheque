<?php
	session_start();
	$db = mysqli_connect("localhost", $_SESSION['pseudo'], $_SESSION['mdp'], "bibli");
	mysqli_query($db, "SET NAMES 'utf8'");
	if (mysqli_connect_errno()) {
		printf("Échec de la connexion : %s\n", mysqli_connect_error());
		exit();
	}
	if ($_SESSION['demo']) {
		if ($_SESSION['is_admin']) {
			$query = mysqli_query($db, "SELECT * FROM Admins");
		}
		else {
			$query = mysqli_query($db, "SELECT * FROM `Abonnés`") or die(mysqli_error($db));
		}
		$row = mysqli_fetch_assoc($query);
		$user_id = $row['ID'];
		$nom = "(compte choisi arbitrairement : ".$row['prénom']." ".$row['nom'].")";
		$prenom = "testeur";
		$pseudo = $row['pseudo'];
		
	}
	else {
		$verif = $_SESSION['pseudo'];
		if ($_SESSION['is_admin']) {
			$query = mysqli_query($db, "SELECT * FROM Admins WHERE pseudo = '$verif'");
		}
		else {
			$query = mysqli_query($db, "SELECT * FROM Abonnés WHERE pseudo = '$verif'");
		}
		$row = mysqli_fetch_assoc($query);
		$user_id = $row['ID'];
		$nom = $row['nom'];
		$prenom = $row['prénom'];
		$pseudo = $row['pseudo'];
	}
	if(!isset($pseudo)) {
		mysqli_close($db);
		//header('Location: index.php');
	}
?>