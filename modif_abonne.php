<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modifier les informations d'un abonné</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
		?>
		<h1>Modifier les informations d'un abonné</h1>
		<?php
			$id = $_GET['id'];
			$result = mysqli_query($db, "SELECT * FROM Abonnés WHERE ID = '$id'");
			$row = mysqli_fetch_row($result);
		?>
		<form action="admin_abonnes.php" method="post">
			<input name="id" type="hidden" value="<?php echo $id ?>" />
			<label>Nom d'utilisateur :</label>
			<input name="pseudo" type="text" value="<?php echo $row[1] ?>" />
			<label>Mot de passe :</label>
			<input name="mdp" type="password" value="<?php echo $row[2] ?>" />
			<label>Nom :</label>
			<input name="nom" type="text" value="<?php echo $row[3] ?>" />
			<label>Prénom :</label>
			<input name="prenom" type="text" value="<?php echo $row[4] ?>" />
			<label>Date de naissance :</label>
			<input name="naissance" type="text" value="<?php echo $row[8] ?>" />
			<label>Adresse :</label>
			<input name="adresse" type="text" value="<?php echo $row[5] ?>" />
			<label>Numéro de téléphone :</label>
			<input name="tel" type="text" value="<?php echo $row[6] ?>" />
			<label>Adresse mail :</label>
			<input name="mail" type="text" value="<?php echo $row[7] ?>" />
			<input name="update" type="submit" value="Modifier" />
		</form>
	</body>
</html>