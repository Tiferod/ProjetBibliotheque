<?php
	session_start();
	$error='';
	if (isset($_POST['submit'])) {
		if (isset($_POST['demo'])) {
			$_SESSION['demo'] = True;
			$_SESSION['pseudo'] = $_POST['pseudo'];
			$_SESSION['mdp'] = $_POST['mdp'];
			if (isset($_POST['is_admin'])) {
				$_SESSION['is_admin'] = True;
				header("location: admin_home.php");
			}
			else {
				$_SESSION['is_admin'] = False;
				header("location: home.php");
			}
		}
		else {
			$_SESSION['demo'] = False;
			if (empty($_POST['pseudo']) || empty($_POST['mdp'])) {
				$error = "Nom ou mot de passe manquant";
			}
			else {
				$pseudo = $_POST['pseudo'];
				$mdp = $_POST['mdp'];
				$db = mysqli_connect("localhost", "dev", "password", "bibli");
				mysqli_query($db, "SET NAMES 'utf8'");
				if (mysqli_connect_errno()) {
					printf("Échec de la connexion : %s\n", mysqli_connect_error());
					exit();
				}
				if (isset($_POST['is_admin'])) {
					$stmt = mysqli_prepare($db, "SELECT * FROM Admins WHERE pseudo =? AND mdp =?") or die(mysqli_error($db));
					$_SESSION['is_admin'] = True;
				}
				else {
					$stmt = mysqli_prepare($db, "SELECT * FROM Abonnés WHERE pseudo =? AND mdp =?") or die(mysqli_error($db));
					$_SESSION['is_admin'] = False;
				}
				mysqli_stmt_bind_param($stmt, "ss", $pseudo, $mdp);
				mysqli_stmt_execute($stmt);
				$res = mysqli_stmt_get_result($stmt);
				$rows = mysqli_num_rows($res);
				if ($rows == 1) {
					$_SESSION['pseudo'] = $pseudo;
					$_SESSION['mdp'] = $mdp;
					if ($_SESSION['is_admin']) {
						header("location: admin_home.php");
					}
					else {
						header("location: home.php");
					}
				}
				else {
					$error = "Nom ou mot de passe invalide";
				}
				mysqli_close($db);
			}
		}
	}
?>