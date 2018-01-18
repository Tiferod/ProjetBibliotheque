<?php
	include('login.php');
	if(isset($_SESSION['pseudo'])) {
		header("location: home.php");
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
				<label>Nom d'utilisateur :</label>
				<input name="pseudo" placeholder="Nom d'utilisateur" type="text" />
				<label>Mot de passe :</label>
				<input name="mdp" placeholder="****" type="password" />
				<input name="submit" type="submit" value="Se connecter" />
				<span><?php echo $error; ?></span>
			</form>
		</div>
	</body>
</html>