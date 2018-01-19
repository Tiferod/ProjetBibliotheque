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
		<div>Bienvenue, <?php echo $prenom . " " . $nom; ?>.</div>
		<div><a href="logout.php">Se déconnecter</a></div>
		<h1>Tableau de bord</h1>
		<h2>Retards</h2>
		<?php
			$result = mysqli_query($db, "SELECT document, date_retour FROM Retards WHERE abonné = '$user_id' AND DATEDIFF(NOW(), date_retour) <= 365");
			$row_cpt = mysqli_num_rows($result);
			if ($row_cpt == 0) {
				echo "<div>Bravo ! Vous n'avez rendu aucun document en retard cette dernière année.</div>";
			}
			else {
				echo '<div>Vous avez ' . $row_cpt . ' retard(s) à votre actif.</div>';
				echo '<table><tr><td>Document</td><td>Rendu le</td></tr>';
				while ($row = mysqli_fetch_row($result)) {
					$doc = mysqli_query($db, "SELECT titre FROM Documents WHERE ID = '$row[0]'");
					echo '<tr><td>' . mysqli_fetch_row($doc)[0] . '</td><td>' . $row[1] . '</td></tr>';
				}
				echo '</table>';
			}
		?>
	</body>
</html>