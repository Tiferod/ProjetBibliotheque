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
			<input name="id" type="hidden" value="<?php echo $id ?>" /></div>
			<div><label>Nom d'utilisateur :</label>
			<input name="pseudo" type="text" value="<?php echo $row[1] ?>" /></div>
			<div><label>Mot de passe :</label>
			<input name="mdp" type="password" value="<?php echo $row[2] ?>" /></div>
			<div><label>Nom :</label>
			<input name="nom" type="text" value="<?php echo $row[3] ?>" /></div>
			<div><label>Prénom :</label>
			<input name="prenom" type="text" value="<?php echo $row[4] ?>" /></div>
			<div><label>Date de naissance :</label>
			<input name="naissance" type="text" value="<?php echo $row[8] ?>" /></div>
			<div><label>Adresse :</label>
			<input name="adresse" type="text" value="<?php echo $row[5] ?>" /></div>
			<div><label>Numéro de téléphone :</label>
			<input name="tel" type="text" value="<?php echo $row[6] ?>" /></div>
			<div><label>Adresse mail :</label>
			<input name="mail" type="text" value="<?php echo $row[7] ?>" /></div>
			<div><input name="update" type="submit" value="Modifier" /></div>
		</form>
	</body>
</html>