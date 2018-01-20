<?php
	include('session.php');
?>
<?php
	$display='';
	if (isset($_POST['submit'])) {
		if (empty($_POST['pseudo']) || empty($_POST['mdp']) || empty($_POST['nom']) || empty($_POST['prénom']) || empty($_POST['mail'])) {
			$display = "Merci de remplir tous les champs";
		}
		else {
			$pseudo = $_POST['pseudo'];
			$mdp = $_POST['mdp'];
			mysqli_query($db, "CREATE USER '$pseudo'@'localhost' IDENTIFIED BY '$mdp';");
			mysqli_query($db, "GRANT ALL PRIVILEGES ON `bibli`.* TO '$pseudo'@'localhost' WITH GRANT OPTION;");
			$stmt = mysqli_prepare($db, "INSERT INTO Admins(pseudo, mdp, nom, prénom, mail) VALUES (?,?,?,?,?)");
			mysqli_stmt_bind_param($stmt, "sssss", $pseudo, $mdp, $_POST['nom'], $_POST['prénom'], $_POST['mail']);
			mysqli_stmt_execute($stmt);
			if (mysqli_affected_rows($db) == 1) {
				$display = "Création du compte réussie";
			}
			else {
				$display = "Échec de la création du compte";
			}
		}
	}
	if (isset($_POST['delete'])) {
		$id = $_POST['id'];
		mysqli_query($db, "DELETE FROM Admins WHERE ID = '$id'");
		if (mysqli_affected_rows($db) == 1) {
			$display = "Suppression du compte réussie";
		}
		else {
			$display = "Échec de la suppression du compte";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Page d'administrateur</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
		?>
		<h1>Page d'administrateur</h1>
		<h2>Liste des administrateurs</h2>
		<?php
			$result = mysqli_query($db, "SELECT ID, pseudo, nom, prénom, mail FROM Admins");
			echo '<table><tr><td>Pseudo</td><td>Nom</td><td>Prénom</td><td>Adresse mail</td><td>Modifier</td><td></td></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td>' . $row[3] . '</td><td></td>' .
					'<td><form action="" method="post"><input type="hidden" name="id" value=' . $row[0] . ' /><input name="delete" type="submit" value="Supprimer" /></form></td></tr>';
			}
			echo '</table>';
		?>
		<h2>Ajouter un administrateur</h2>
		<form action="" method="post">
			<label>Nom d'utilisateur :</label>
			<input name="pseudo" placeholder="Nom d'utilisateur" type="text" />
			<label>Mot de passe :</label>
			<input name="mdp" placeholder="****" type="password" />
			<label>Nom :</label>
			<input name="nom" type="text" />
			<label>Prénom :</label>
			<input name="prénom" type="text" />
			<label>Adresse mail :</label>
			<input name="mail" type="text" />
			<input name="submit" type="submit" value="Ajouter" />
		</form>
		<div><?php echo $display; ?></div>
	</body>
</html>