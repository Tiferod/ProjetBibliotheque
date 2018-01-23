<?php
	include('session.php');
?>
<?php
	if (isset($_POST['report'])) {
		$empr_id = $_POST['id'];
		mysqli_query($db, "UPDATE Emprunts SET date_retour_prevue = DATE_ADD(date_retour_prevue, INTERVAL 30 DAY) WHERE ID = '$empr_id'");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Gestion des emprunts</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
			$id = $_GET['id'];
			$current = mysqli_fetch_row(mysqli_query($db, "SELECT prénom, nom FROM Abonnés WHERE ID = '$id'"));
		?>
		<h1>Emprunts de <?php echo $current[0]." ".$current[1]; ?></h1>
		<?php
			$result = mysqli_query($db, "SELECT ID, document, date_emprunt, date_retour_prevue FROM Emprunts WHERE abonné = '$id' ORDER BY date_emprunt");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt == 0) {
				echo "<div>Aucun emprunt en cours.</div>";
			}
			else {
				echo '<div>' . $row_cpt . ' emprunt(s) en cours.</div>';
				echo '<table><tr id="header"><td>Type</td><td>Titre</td><td>Auteur(s)</td><td>Éditeur</td><td>Collection</td><td>Numéro</td><td>Date de publication</td><td>Emprunté le</td><td>À rendre avant le</td><td></td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					$doc_id = $row[1];
					$result_doc = mysqli_query($db, "SELECT * FROM Documents WHERE ID = '$doc_id'");
					$doc = mysqli_fetch_row($result_doc);
					$result_auteurs = mysqli_query($db, "SELECT nom FROM CrééPar, Auteurs WHERE document = '$doc_id' AND auteur = ID");
					$first_auteur = True;
					$auteurs = "";
					while ($auteur = mysqli_fetch_row($result_auteurs)) {
						if ($first_auteur) {
							$auteurs = $auteur[0];
							$first_auteur = False;
						}
						else {
							$auteurs = $auteurs . ", " . $auteur[0];
						}
					}
					echo '<tr><td>' . $doc[2] . '</td><td>' . $doc[1] . '</td><td>' . $auteurs . '</td><td>' . $doc[3]
						. '</td><td>' . $doc[4] . '</td><td>' . $doc[5] . '</td><td>' . date("d/m/Y", strtotime($doc[6]))
						. '</td><td>' . date("d/m/Y", strtotime($row[2])) . '</td><td>' . date("d/m/Y", strtotime($row[3])) . '</td>';

					echo '<td><form action="" method="post">
						<input type="hidden" name="id" value='.$row[0].' />
						<input name="report" type="submit" value="Reporter d\'un mois" /></form></td></tr>';
				}
				echo '</table>';
			}
		?>
	</body>
</html>