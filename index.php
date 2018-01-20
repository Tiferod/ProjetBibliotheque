<?php
	include('login.php');
	if (isset($_SESSION['pseudo'])) {
		if ($_SESSION['is_admin']) {
			header("location: admin_home.php");
		}
		else {
			header("location: home.php");
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Page de connexion</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div>
			<h1>Connexion</h1>
			<form action="" method="post">
				<div><label>Nom d'utilisateur :</label>
				<input name="pseudo" placeholder="Nom d'utilisateur" type="text" /></div>
				<div><label>Mot de passe :</label>
				<input name="mdp" placeholder="****" type="password" /></div>
				<div><input name="is_admin" type="checkbox"> Administrateur ?</div>
				<div><input name="submit" type="submit" value="Se connecter" /></div>
				<span id="info"><?php echo $error; ?></span>
			</form>
		</div>
	</body>
</html>