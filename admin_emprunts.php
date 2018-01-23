<?php
	include('session.php');
?>
<?php
	$display='';
	if (isset($_POST['emprunt'])) {
		$id_abo = $_POST['abonne'];

		$query_exclusions = mysqli_query($db, "SELECT date_fin FROM Exclusions WHERE abonné = '$id_abo' AND NOW() < date_fin");
		$row_cpt = mysqli_num_rows($query_exclusions);
		if ($row_cpt > 0) {
			$display = "Emprunt refusé : L'abonné est exclus jusqu'au " . date("d/m/Y", strtotime(mysqli_fetch_row($query_exclusions)[0])) . ".";
		}
		else {
			$query_retards = mysqli_query($db, "SELECT SUM(amende) FROM Retards WHERE abonné = '$id_abo' AND payé = 0");
			$amende = mysqli_fetch_row($query_retards)[0];
			if ($amende > 0) {
				$display = "Emprunt refusé : L'abonné doit encore payer une amende de " . $amende . " €.";
			}
			else {
				$id_doc = $_POST['document'];
				$query_doc = mysqli_query($db, "SELECT type FROM Emprunts, Documents WHERE abonné = '$id_abo' AND document = Documents.ID AND type =
					(SELECT type FROM Documents WHERE ID = '$id_doc')");
				$doc_cpt = mysqli_num_rows($query_doc);
				$doc_type = mysqli_fetch_row($query_doc)[0];
				if ($doc_cpt >= 3 && $doc_type == "livre") {
					$display = "Emprunt refusé : pas plus de 3 livres simultanés.";
				}
				else if ($doc_cpt >= 2 && $doc_type != "livre") {
					$display = "Emprunt refusé : pas plus de 2 documents du même type (hors livres) simultanés.";
				}
				else {
					mysqli_query($db, "INSERT INTO Emprunts(abonné, document, date_emprunt, date_retour_prevue) VALUES ('$id_abo', '$id_doc', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY))");
					if (mysqli_affected_rows($db) > 0) {
						$display = "L'emprunt a bien été enregistré.";
					}
					else {
						$display = "Échec de l'enregistrement.";
					}
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Enregistrer un emprunt</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
		?>
		<h1>Enregistrer un emprunt</h1>
		<?php
			echo '<form action="" method="post">';

			echo '<h2>Sélectionner un abonné</h2>';
			$results_abo = mysqli_query($db, "SELECT ID, pseudo, prénom, nom FROM Abonnés");
			echo '<div><select name="abonne">';
			echo '<option value="">Choisir un abonné</option>';
			while ($row = mysqli_fetch_row($results_abo)) {
				echo '<option value="'.$row[0].'">'.$row[1].' : '.$row[2].' '.$row[3].'</option>';
			}
			echo '</select></div>';

			echo '<h2>Sélectionner un document</h2>';
			$results_doc = mysqli_query($db, "SELECT ID, titre FROM Documents WHERE disponible = 1");
			echo '<div><select name="document">';
			echo '<option value="">Choisir un document à emprunter</option>';
			while ($row = mysqli_fetch_row($results_doc)) {
				echo '<option value="'.$row[0].'">'.$row[0].' : '.$row[1].'</option>';
			}
			echo '</select></div>';

			echo '<h2>Valider</h2>';
			echo '<div><input name="emprunt" type="submit" value="Emprunter le document" /></div>';
			echo '</form>';
			echo '<div id="info">'.$display.'</div>';
		?>
	</body>
</html>