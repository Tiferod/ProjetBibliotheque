<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Chercher un document</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('header.php');
		?>
		<h1>WIP</h1>
		<?php
		if(isset($_POST['requete']) && $_POST['requete'] != NULL)

		{

		$requete = htmlspecialchars($_POST['requete']);

		$result = mysqli_query($db, "SELECT * FROM documents WHERE titre LIKE '%$requete%' ORDER BY id DESC") or die (mysql_error());

		$nb_resultats = mysqli_num_rows($result);

		if($nb_resultats != 0)

		{

		?>

		<h3>Résultats de votre recherche.</h3>

		<p>Nous avons trouvé <?php echo $nb_resultats;

		if($nb_resultats > 1) { echo ' résultats dans notre base de données. Voici les documents que nous avons trouvés :'; } else { echo ' résultat dans notre base de données. Voici le document que nous avons trouvés :'; }
		?>

		<br/>

		<br/>

		<?php

		echo '<table><tr id="header"><td>Type</td><td>Titre</td><td>Auteur(s)</td><td>Éditeur</td><td>Collection</td><td>Numéro</td><td>Date de publication</td><td> Disponible</td>';
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
				. '</td><td>' . $doc[4] . '</td><td>' . $doc[5] . '</td><td>' . $doc[6]. '</td>';
			if($doc[7]) {echo '<td>Oui</td>';} else {echo '<td>Non</td>';}
		}
		echo '</table>';

		?><br/>

		<br/>

		<a href="recherche.php">Faire une nouvelle recherche</a></p>

		<?php

		}

		else

		{

		?>

		<h3>Pas de résultats</h3>

		<p>Nous n'avons trouvé aucun résultat pour votre requête "<? echo $_POST['requete']; ?>". <a href="recherche.php">Réessayez</a> avec autre chose.</p>

		<?php

		}

		}

		else

		{

		?>

		<p>Vous allez faire une recherche de documents. Tapez un titre pour réaliser une recherche.</p>

		 <form action="recherche.php" method="Post">

		<input type="text" name="requete" size="10">

		<input type="submit" value="Ok">

		</form>

		<?php

		}
		?>
	</body>
</html>