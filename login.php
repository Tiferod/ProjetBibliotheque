<?php
	session_start();
	$error='';
	if (isset($_POST['submit'])) {
		if (empty($_POST['pseudo']) || empty($_POST['mdp'])) {
			$error = "Nom ou mot de passe manquant";
		}
		else {
			$pseudo = $_POST['pseudo'];
			$mdp = $_POST['mdp'];
			$db = mysqli_connect("localhost", "dev", "password", "bibli");
			if (mysqli_connect_errno()) {
				printf("Échec de la connexion : %s\n", mysqli_connect_error());
				exit();
			}
			//$pseudo = stripslashes($pseudo);
			//$mdp = stripslashes($mdp);
			//$pseudo = mysqli_real_escape_string($pseudo);
			//$mdp = mysqli_real_escape_string($mdp);
			//$query = mysqli_query($db, "SELECT * FROM Abonnés WHERE mdp = '$mdp' AND pseudo = '$pseudo'");
			$stmt = mysqli_prepare($db, "SELECT * FROM Abonnés WHERE pseudo =? AND mdp =?");
			mysqli_stmt_bind_param($stmt, "ss", $pseudo, $mdp);
			mysqli_stmt_execute($stmt);
			//mysqli_stmt_bind_result($stmt, $res);
			//mysqli_stmt_fetch($stmt);
			$res = mysqli_stmt_get_result($stmt);
			$rows = mysqli_num_rows($res);
			if ($rows == 1) {
				$_SESSION['pseudo'] = $pseudo;
				$_SESSION['mdp'] = $mdp;
				header("location: home.php");
			} else {
				$error = "Nom ou mot de passe invalide";
			}
			mysqli_close($db);
		}
	}
?>