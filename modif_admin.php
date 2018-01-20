<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modifier les informations d'un administrateur</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
		?>
		<h1>Modifier les informations d'un administrateur</h1>
		<?php
			$id = $_GET['id'];
			$result = mysqli_query($db, "SELECT pseudo, mdp, nom, prénom, mail FROM Admins WHERE ID = '$id'");
			$row = mysqli_fetch_row($result);
		?>
		<form action="admin_home.php" method="post">
			<input name="id" type="hidden" value="<?php echo $id ?>" />
			<div><label>Nom d'utilisateur :</label>
			<input name="pseudo" type="text" value="<?php echo $row[0] ?>" /></div>
			<div><label>Mot de passe :</label>
			<input name="mdp" type="password" value="<?php echo $row[1] ?>" /></div>
			<div><label>Nom :</label>
			<input name="nom" type="text" value="<?php echo $row[2] ?>" /></div>
			<div><label>Prénom :</label>
			<input name="prénom" type="text" value="<?php echo $row[3] ?>" /></div>
			<div><label>Adresse mail :</label>
			<input name="mail" type="text" value="<?php echo $row[4] ?>" /></div>
			<div><input name="update" type="submit" value="Modifier" /></div>
		</form>
	</body>
</html>