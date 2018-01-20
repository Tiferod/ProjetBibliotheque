<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Historique des emprunts</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('header.php');
		?>
		<h1>Historique des emprunts</h1>
		<?php
			$result = mysqli_query($db, "SELECT document, date_emprunt, date_retour FROM EmpruntsRendus WHERE abonné = '$user_id' ORDER BY date_emprunt");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt == 0) {
				echo "<div>Vous n'avez encore emprunté aucun document.</div>";
			}
			else {
				echo '<div>Vous avez emprunté et rendu ' . $row_cpt . ' document(s).</div>';
				echo '<table><tr id="header"><td>Type</td><td>Titre</td><td>Auteur(s)</td><td>Éditeur</td><td>Collection</td><td>Numéro</td><td>Date de publication</td><td>Emprunté le</td><td>Rendu le</td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					$doc_id = $row[0];
					$result_doc = mysqli_query($db, "SELECT * FROM Documents WHERE ID = '$doc_id'");
					$doc = mysqli_fetch_row($result_doc);
					$result_auteurs = mysqli_query($db, "SELECT nom FROM CrééPar, Auteurs WHERE document = '$doc_id' AND auteur = ID");
					$first_auteur = True;
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
						. '</td><td>' . $doc[4] . '</td><td>' . $doc[5] . '</td><td>' . $doc[6]
						. '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td></tr>';
				}
				echo '</table>';
			}
		?>
	</body>
</html>