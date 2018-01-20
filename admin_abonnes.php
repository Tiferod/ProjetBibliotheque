<?php
	include('session.php');
?>
<?php
	$display='';
	if (isset($_POST['cotiz'])) {
		$id = $_POST['id'];
		$statut = $_POST['statut'];
		mysqli_query($db, "INSERT INTO Cotise(abonné, statut, date_fin) VALUES ('$id', '$statut', DATE_ADD(NOW(), INTERVAL 1 YEAR))");
		$display = "Nouvelle cotisation enregistrée";
	}
	if (isset($_POST['payer_retard'])) {
		$id = $_POST['retard'];
		mysqli_query($db, "UPDATE Retards SET payé = 1 WHERE ID = '$id'");
		$display = "Amende payée";
	}
	if (isset($_POST['insert'])) {
		if (empty($_POST['pseudo']) || empty($_POST['mdp']) || empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['adresse']) || empty($_POST['mail']) || empty($_POST['naissance'])) {
			$display = "Merci de remplir tous les champs obligatoires";
		}
		else {
			$pseudo = mysqli_real_escape_string($db, $_POST['pseudo']);
			$mdp = mysqli_real_escape_string($db, $_POST['mdp']);
			mysqli_query($db, "CREATE USER '$pseudo'@'localhost' IDENTIFIED BY '$mdp';");
			mysqli_query($db, "GRANT SELECT ON `bibli`.* TO '$pseudo'@'localhost';");
			$stmt = mysqli_prepare($db, "INSERT INTO Abonnés(pseudo, mdp, nom, prénom, adresse, téléphone, mail, date_de_naissance) VALUES (?,?,?,?,?,?,?,?)");
			mysqli_stmt_bind_param($stmt, "ssssssss", $pseudo, $mdp, $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['tel'], $_POST['mail'], $_POST['naissance']);
			mysqli_stmt_execute($stmt);
			$id = mysqli_insert_id($db);
			if (mysqli_affected_rows($db) == 1) {
				$statut = $_POST['statut'];
				mysqli_query($db, "INSERT INTO Cotise(abonné, statut, date_fin) VALUES ('$id', '$statut', DATE_ADD(NOW(), INTERVAL 1 YEAR))");
				$display = "Création du compte réussie";
			}
			else {
				$display = "Échec de la création du compte";
			}
		}
	}
	if (isset($_POST['update'])) {
		if (empty($_POST['pseudo']) || empty($_POST['mdp']) || empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['naissance']) || empty($_POST['adresse']) || empty($_POST['mail'])) {
			$display = "Échec de la mise à jour, merci de remplir tous les champs";
		}
		else {
			$id = $_POST['id'];
			$stmt = mysqli_prepare($db, "UPDATE Abonnés SET pseudo=?, mdp=?, nom=?, prénom=?, date_de_naissance=?, adresse=?, téléphone=?, mail=? WHERE ID = '$id'");
			mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['pseudo'], $_POST['mdp'], $_POST['nom'], $_POST['prenom'], $_POST['naissance'], $_POST['adresse'], $_POST['tel'], $_POST['mail']);
			mysqli_stmt_execute($stmt);
			if (mysqli_affected_rows($db) == 1) {
				$display = "Modification du compte réussie";
			}
			else {
				$display = "Échec de la modification du compte";
			}
		}
	}
	if (isset($_POST['delete'])) {
		$id = $_POST['id'];
		$pseudo = $_POST['pseudo'];
		mysqli_query($db, "DROP USER '$pseudo'@'localhost';");
		mysqli_query($db, "DELETE FROM Abonnés WHERE ID = '$id'");
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
		<title>Gestion des abonnés</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
		?>
		<h1>Gestion des abonnés</h1>
		<h2>Liste des abonnés</h2>
		<?php
			$result = mysqli_query($db, "SELECT * FROM Abonnés");
			echo "<table><tr><td>Pseudo</td><td>Nom</td><td>Prénom</td><td>Date de naissance</td><td>Adresse</td><td>Numéro de téléphone</td><td>Adresse mail</td>
				<td>Statut</td><td>Expiration de la cotisation</td><td></td>
				<td>Retards</td><td></td><td></td></tr>";
			while ($row = mysqli_fetch_row($result)) {
				$id = $row[0];
				echo '<tr><td>' . $row[1] . '</td><td>' . $row[3] . '</td><td>' . $row[4] . '</td><td>' . $row[8] . '</td><td>' . $row[5] . '</td><td>' . $row[6] . '</td><td>' . $row[7] . '</td>';

				$query_statut = mysqli_query($db, "SELECT statut FROM Cotise WHERE abonné = '$id' ORDER BY date_fin DESC");
				$statut = mysqli_fetch_row($query_statut)[0];
				echo '<td>'. $statut .'</td>';

				$query_cotisation = mysqli_query($db, "SELECT date_fin FROM Cotise WHERE abonné = '$id' AND NOW() < date_fin ORDER BY date_fin DESC");
				$row_cotisation = mysqli_fetch_row($query_cotisation);
				if (isset($row_cotisation)) {
					echo '<td>' . $row_cotisation[0] . '</td>';
				}
				else {
					echo '<td>Cotisation expirée !</td>';
				}

				echo '<td><form action="" method="post">';
				echo '<input type="hidden" name="id" value='.$id.' />';
				$cotisations = mysqli_query($db, "SELECT * FROM Cotisations");
				echo '<select name="statut">';
				while ($row_cotiz = mysqli_fetch_row($cotisations)) {
					echo '<option value="'.$row_cotiz[0].'">'.$row_cotiz[0].' ('.$row_cotiz[1].' €)</option>';
				}
				echo '</select>';
				echo '<input name="cotiz" type="submit" value="Nouvelle cotisation" />';
				echo '</form></td>';

				$query_retards = mysqli_query($db, "SELECT Retards.ID, titre, date_retour, amende FROM Retards, Documents WHERE abonné = '$id' AND payé = 0 AND Retards.document = Documents.ID");
				if (mysqli_num_rows($query_retards) > 0) {
					echo '<td><form action="" method="post">';
					echo '<select name="retard">';
					while ($row_retard = mysqli_fetch_row($query_retards)) {
						echo '<option value="'.$row_retard[0].'">'.$row_retard[3].' € : '.$row_retard[1].' (rendu le '.$row_retard[2].')</option>';
					}
					echo '</select>';
					echo '<input name="payer_retard" type="submit" value="Payé" />';
					echo '</form></td>';
				}
				else {
					echo '<td>Aucune amende à payer</td>';
				}

				echo '<td><form action="emprunts_abonne.php?id='.$id.'" method="post">
					<input name="update" type="submit" value="Voir emprunts" /></form></td>';

				echo '<td><form action="modif_abonne.php?id='.$id.'" method="post">
					<input name="update" type="submit" value="Modifier" /></form></td>';

				echo '<td><form action="" method="post">
					<input type="hidden" name="id" value='.$id.' />
					<input type="hidden" name="pseudo" value='.$row[1].' />
					<input name="delete" type="submit" value="Supprimer" /></form></td>';
				echo '</tr>';
			}
			echo '</table>';
		?>
		<h2>Créer un compte</h2>
		<form action="" method="post">
			<label>Nom d'utilisateur* :</label>
			<input name="pseudo" type="text" />
			<label>Mot de passe* :</label>
			<input name="mdp" type="password" />
			<label>Nom* :</label>
			<input name="nom" type="text" />
			<label>Prénom* :</label>
			<input name="prenom" type="text" />
			<label>Date de naissance* :</label>
			<input name="naissance" type="text" />
			<label>Adresse* :</label>
			<input name="adresse" type="text" />
			<label>Numéro de téléphone :</label>
			<input name="tel" type="text" />
			<label>Adresse mail* :</label>
			<input name="mail" type="text" />
			<label>Statut* :</label>
			<?php
				$cotisations = mysqli_query($db, "SELECT * FROM Cotisations");
				echo '<select name="statut">';
				while ($row = mysqli_fetch_row($cotisations)) {
					echo '<option value="'.$row[0].'">'.$row[0].' ('.$row[1].' €)</option>';
				}
				echo '</select>';
			?>
			<input name="insert" type="submit" value="Ajouter" />
		</form>
		<div>* champ obligatoire</div>
		<div><?php echo $display; ?></div>
	</body>
</html>