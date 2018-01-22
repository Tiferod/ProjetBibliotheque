<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Page d'accueil</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('header.php');
		?>
		<h1>Tableau de bord</h1>
		<?php
			$result = mysqli_query($db, "SELECT date_fin FROM Exclusions WHERE abonné = '$user_id' AND NOW() < date_fin ORDER BY date_fin DESC");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt > 0) {
				echo "<h2>Vous êtes exclus jusqu'au " . mysqli_fetch_row($result)[0] . '.</h2>';
			}
		?>
		<?php
			$result = mysqli_query($db, "SELECT SUM(amende) FROM Retards WHERE abonné = '$user_id' AND payé = 0");
			$row_tot = mysqli_fetch_row($result)[0];
			if ($row_tot > 0) {
				echo "<h2>Vous devez payer une amende de " . $row_tot . '€ à cause de documents rendus en retard précédemment.</h2>';
			}
		?>
		<h2>Statut</h2>
		<?php
			$result = mysqli_query($db, "SELECT statut, date_fin FROM Cotise WHERE abonné = '$user_id' AND NOW() < date_fin ORDER BY date_fin DESC");
			$row = mysqli_fetch_row($result);
			if (isset($row)) {
				echo '<div>Vous avez cotisé comme ' . $row[0] . '.</div>';
				echo '<div>Votre cotisation expire le ' . $row[1] . '.</div>';
			}
			else {
				echo '<div>Votre cotisation a expiré.</div>';
				echo '<div>Contactez un administrateur !</div>';
			}
		?>
		<h2>Retards</h2>
		<?php
			$result = mysqli_query($db, "SELECT document, date_retour FROM Retards WHERE abonné = '$user_id' AND DATEDIFF(NOW(), date_retour) <= 365");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt == 0) {
				echo "<div>Bravo ! Vous n'avez rendu aucun document en retard cette dernière année.</div>";
			}
			else {
				echo '<div>Vous avez ' . $row_cpt . ' retard(s) à votre actif.</div>';
				echo '<table><tr id="header"><td>Document</td><td>Rendu le</td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					$doc = mysqli_query($db, "SELECT titre FROM Documents WHERE ID = '$row[0]'");
					echo '<tr><td>' . mysqli_fetch_row($doc)[0] . '</td><td>' . $row[1] . '</td></tr>';
				}
				echo '</table>';
			}
		?>
		<h2>Emprunts</h2>
		<?php
			$result = mysqli_query($db, "SELECT document, date_emprunt, date_retour_prevue FROM Emprunts WHERE abonné = '$user_id'");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt == 0) {
				echo "<div>Vous n'avez aucun emprunt en cours.</div>";
			}
			else {
				echo '<div>Vous avez ' . $row_cpt . ' emprunt(s) en cours.</div>';
				echo '<table><tr><td>Document</td><td>Emprunté le</td><td>À rendre avant le</td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					$doc = mysqli_query($db, "SELECT titre FROM Documents WHERE ID = '$row[0]'");
					echo '<tr><td>' . mysqli_fetch_row($doc)[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td></tr>';
				}
				echo '</table>';
			}
		?>
		<?php
			$result = mysqli_query($db, "SELECT * FROM Emprunts WHERE abonné = '$user_id' AND NOW() > date_retour_prevue");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt > 0) {
				echo "<h2>Attention ! Vous avez " . $row_cpt . ' document(s) en retard !</h2>';
			}
		?>
	</body>
</html>