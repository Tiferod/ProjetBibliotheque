<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Page d'accueil</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div>Bienvenue, <?php echo $prenom . " " . $nom; ?>.</div>
		<div><a href="logout.php">Se déconnecter</a></div>
	</body>
</html>