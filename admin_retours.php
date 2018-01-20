<?php
	include('session.php');
?>
<?php
	$display='';
	if (isset($_POST['retour'])) {
		$id = $_POST['emprunt'];
		mysqli_query($db, "DELETE FROM Emprunts WHERE ID = '$id'");
		if (mysqli_affected_rows($db) > 0) {
			$display = "Le retour a bien été enregistré.";
		}
		else {
			$display = "Veuillez choisir un document parmi la liste.";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Enregistrer un retour</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
		?>
		<h1>Enregistrer un retour</h1>
		<?php
			echo '<h2>Sélectionner un document</h2>';
			$results = mysqli_query($db, "SELECT Emprunts.ID, document, titre FROM Emprunts, Documents WHERE document = Documents.ID");
			echo '<form action="" method="post">';
			echo '<div><select name="emprunt">';
			echo '<option value="">Choisir un document emprunté</option>';
			while ($row = mysqli_fetch_row($results)) {
				echo '<option value="'.$row[0].'">'.$row[1].' : '.$row[2].'</option>';
			}
			echo '</select></div>';
			echo '<h2>Valider</h2>';
			echo '<div><input name="retour" type="submit" value="Retourner le document" /></div>';
			echo '</form>';
			echo '<div id="info">'.$display.'</div>';
		?>
	</body>
</html>