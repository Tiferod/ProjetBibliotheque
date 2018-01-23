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
		<?php
		if(isset($_POST['requete']) && $_POST['requete'] != NULL && isset($_POST['requete']) && $_POST['requete'] != NULL)

		{

		$requete = htmlspecialchars($_POST['requete']);

		$categorie = htmlspecialchars($_POST['categorie']);

		if ($categorie == "auteur")
		{
			$result = mysqli_query($db, "SELECT * FROM Documents, CrééPar, Auteurs WHERE (Auteurs.nom LIKE '%$requete%') AND Documents.ID = CrééPar.document AND CrééPar.auteur = Auteurs.ID");
		}
		else
		{
			$result = mysqli_query($db, " SELECT * FROM Documents WHERE `$categorie` LIKE '%$requete%' ORDER BY id DESC") or die (mysql_error());
		}

		

		$nb_resultats = mysqli_num_rows($result);

		if($nb_resultats != 0)

		{

		?>

		<h3>Résultats de votre recherche.</h3>

		<p>Nous avons trouvé <?php echo $nb_resultats;

		if($nb_resultats > 1) { echo ' résultats dans notre base de données :'; } else { echo ' résultat dans notre base de données :'; }
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
			echo '<tr><td>' . $doc[2] . '</td><td><a href="document.php?id=' . $doc[0] . '">' . $doc[1] . '</a></td><td>' . $auteurs . '</td><td>' . $doc[3]
				. '</td><td>' . $doc[4] . '</td><td>' . $doc[5] . '</td><td>' . date("d/m/Y", strtotime($doc[6])). '</td>';
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

		<p>Nous n'avons trouvé aucun résultat pour votre requête "<?php echo $_POST['requete']; ?>". <a href="recherche.php">Réessayez</a> avec autre chose.</p>

		<?php

		}

		}

		else

		{

		?>

		<p>Vous allez faire une recherche de documents. Sélectionnez un champ et tapez votre recherche.</p>

		<div>

		<form action="recherche.php" method="Post">

			<input type="text" name="requete" size="20">

			<select name="categorie">
				<option value="titre" selected = "selected">Titre</option>
				<option value="auteur">Auteur</option>
				<option value="éditeur">Éditeur</option>
				<option value="collection">Collection</option>
			</select>

			<input type="submit" value="Ok">
		</form>

		</div>
		<?php

		}
		?>
	</body>
</html>