<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Monitoring</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
		?>
		<h1>Outils de monitoring</h1>

		<h2>Retards en cours</h2>
		<?php
			$result = mysqli_query($db, "SELECT document, titre, prénom, nom, date_retour_prevue FROM Emprunts, Documents, Abonnés WHERE document = Documents.ID AND abonné = Abonnés.ID AND NOW() > date_retour_prevue");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt > 0) {
				echo '<div>Il y a ' . $row_cpt . ' document(s) actuellement en retard.</div>';
				echo '<table><tr id="header"><td>ID</td><td>Titre</td><td>Emprunteur</td><td>Retour prévu</td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].' '.$row[3].'</td><td>'.$row[4].'</td></tr>';
				}
				echo '</table>';
			}
			else {
				echo '<div>Aucun retard en cours.</div>';
			}
		?>

		<h2>Retards impayés</h2>
		<?php
			$result = mysqli_query($db, "SELECT pseudo, nom, prénom, SUM(amende) FROM Retards, Abonnés WHERE abonné = Abonnés.ID AND payé = 0 GROUP BY pseudo");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt > 0) {
				echo '<div>Il y a ' . $row_cpt . ' amende(s) impayée(s).</div>';
				echo '<table><tr id="header"><td>Nom d\'utilisateur</td><td>Prénom</td><td>Nom</td><td>Montant de l\'amende</td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].' €</td></tr>';
				}
				echo '</table>';
			}
			else {
				echo '<div>Aucune amende impayée.</div>';
			}
		?>

		<h2>Exclusions en cours</h2>
		<?php
			$result = mysqli_query($db, "SELECT pseudo, nom, prénom, date_fin FROM Exclusions, Abonnés WHERE abonné = Abonnés.ID AND NOW() < date_fin ORDER BY date_fin DESC");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt > 0) {
				echo '<div>Il y a ' . $row_cpt . ' exclusion(s) en cours.</div>';
				echo '<table><tr id="header"><td>Nom d\'utilisateur</td><td>Prénom</td><td>Nom</td><td>Exclus jusqu\'au</td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td></tr>';
				}
				echo '</table>';
			}
			else {
				echo '<div>Personne n\'est actuellement excluse.</div>';
			}
		?>
	</body>
</html>