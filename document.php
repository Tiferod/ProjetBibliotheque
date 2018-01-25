<?php
	include('session.php');
	$doc_id = $_GET['id'];
	if (isset($_POST['insert'])) {
		if (empty($_POST['titre']) || empty($_POST['auteurs']) || empty($_POST['type']) || empty($_POST['éditeur']) || empty($_POST['date_publication'])) {
			$display = "Échec de la création du document, merci de remplir tous les champs";
		}
		else {
			$auteurS = explode(",", $_POST['auteurs']);
			foreach($auteurS as $auteur)
			{
				$result = mysqli_query($db, "SELECT ID FROM Auteurs WHERE nom = '$auteur'");
				if(!$result)
				{
					mysqli_query($db, "INSERT INTO Auteurs VALUES $auteur");
					$idAuteur = mysqli_fetch_row(mysqli_query($db, "SELECT ID FROM Auteurs WHERE nom = '$auteur'"));
				}
				else
				{
					$idAuteur = mysqli_fetch_row($result);
				}
				mysqli_query($db, "INSERT INTO CrééPar VALUES ('$idAuteur[0]', '$doc_id')");
			}
			$stmt = mysqli_prepare($db, "INSERT INTO Documents SET titre=?, type=?, éditeur=?, collection=?, numéro=?, date_publication=? WHERE ID = '$doc_id'");
			mysqli_stmt_bind_param($stmt, "ssssss", $_POST['titre'], $_POST['type'], $_POST['éditeur'], $_POST['collection'], $_POST['numéro'], $_POST['date_publication']);
			mysqli_stmt_execute($stmt);
			if (mysqli_affected_rows($db) == 1) {
				$display = "Création du document réussie";
			}
			else {
				$display = "Échec de la création du document";
			}
		}
	}
	if (isset($_POST['update'])) {
		if (empty($_POST['titre']) || empty($_POST['auteurs']) || empty($_POST['type']) || empty($_POST['éditeur']) || empty($_POST['date_publication'])) {
			$display = "Échec de la mise à jour, merci de remplir tous les champs";
		}
		else {
			$auteurS = explode(",", $_POST['auteurs']);
			mysqli_query($db, " DELETE FROM CrééPar WHERE document = '$doc_id'");
			foreach($auteurS as $auteur)
			{
				$result = mysqli_query($db, "SELECT ID FROM Auteurs WHERE nom = '$auteur'");
				if(!$result)
				{
					mysqli_query($db, "INSERT INTO Auteurs VALUES $auteur");
					$idAuteur = mysqli_fetch_row(mysqli_query($db, "SELECT ID FROM Auteurs WHERE nom = '$auteur'"));
				}
				else
				{
					$idAuteur = mysqli_fetch_row($result);
				}
				mysqli_query($db, "INSERT INTO CrééPar VALUES ('$idAuteur[0]', '$doc_id')");
			}
			$stmt = mysqli_prepare($db, "UPDATE Documents SET titre=?, type=?, éditeur=?, collection=?, numéro=?, date_publication=? WHERE ID = '$doc_id'");
			mysqli_stmt_bind_param($stmt, "ssssss", $_POST['titre'], $_POST['type'], $_POST['éditeur'], $_POST['collection'], $_POST['numéro'], $_POST['date_publication']);
			mysqli_stmt_execute($stmt);
			if (mysqli_affected_rows($db) == 1) {
				$display = "Modification du document réussi";
			}
			else {
				$display = "Échec de la modification du document";
			}
		}
	}
	$result = mysqli_query($db, " SELECT * FROM Documents WHERE Documents.ID = '$doc_id'") or die (mysql_error());
	$doc = mysqli_fetch_row($result);
	$resultAuteur = mysqli_query($db, "SELECT Auteurs.nom FROM CrééPar, Auteurs WHERE CrééPar.document = '$doc_id' AND CrééPar.auteur = Auteurs.ID");
	$nbrAuteur = mysqli_num_rows($resultAuteur);
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $doc[1]; ?></title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
		if ($_SESSION['is_admin'])
		{
			include('admin_header.php');
		}
		else
		{
			include('header.php');
		}
		?>
		<h1><?php echo $doc[1]; ?></h1>
		<p>
			<?php
			switch ($doc[2]) {
				case "livre":
					$auteur = mysqli_fetch_row($resultAuteur);
					echo 'Paru le ' . date("d/m/Y", strtotime($doc[6])) . ' et édité par ' . $doc[3] . ', ' . $doc[1] . ' est un livre écrit par ' . $auteur[0] . '.';
				break;
				case "BD":
					echo 'Parue le ' . date("d/m/Y", strtotime($doc[6])) . ' et éditée par ' . $doc[3] . ', ' . $doc[1] . ' est une BD réalisée par ';
					while ($auteur = mysqli_fetch_row($resultAuteur)) {
					 	echo $auteur[0];
					 	if ($nbrAuteur > 2) {echo ', ';}
					 	if ($nbrAuteur  == 2) {echo ' et ';}
					 	$nbrAuteur--;
					 }
					echo '. Elle est la ' . $doc[5];
					if ($doc[5] == 1) {echo 'ère';} else {echo 'ème';}
					echo ' de la série ' . $doc[4] . '.';
				break;
				default:
					echo 'Parue le ' . date("d/m/Y", strtotime($doc[6])) . ' et éditée par ' . $doc[3] . ', ' . $doc[1] . ' est une oeuvre écrite par ';
					for ($i=$nbrAuteur-1; $i >= 0 ; $i--) { 
					 	echo $auteur[$i];
					 	if ($i > 1) {echo ', ';}
					 	if ($i == 1) {echo ' et ';}
					 	if ($i == 0) {echo '.';}
					 }
				break;
			}
			?>
		</p>
		<p>
			</br>
			</br>
			<?php
				if($doc[7])
				{
					echo 'Ce document est actuellement disponible à l\'emprunt.';
				}
				else
				{
					$resultDate = mysqli_query($db, "SELECT date_retour_prevue FROM Emprunts WHERE document = '$doc_id'");
					$date = mysqli_fetch_row($resultDate);
					echo 'Ce document n\'est actuellement pas disponible à l\'emprunt. Il devrait être retourné avant le ' . date("d/m/Y", strtotime($date[0])) . '.';
				}
				if ($_SESSION['is_admin'])
				{
				?>
				<form action="<?php echo 'document.php?id=' . $doc_id; ?>" method="post">
					<div><label>Titre* :</label>
					<input name="titre" type="text" value="<?php mysqli_data_seek($resultAuteur, 0);echo $doc[1]; $nbrAuteur = mysqli_num_rows($resultAuteur);?>" /></div>
					<div><label>Auteur(s)* (séparé(e)s par des virgules):</label>
					<input name="auteurs" type="text" size ="50" value="<?php $nbrAuteur = mysqli_num_rows($resultAuteur); while ($auteur = mysqli_fetch_row($resultAuteur)) {echo $auteur[0]; if ($nbrAuteur >= 2){echo ',';}}?>" /></div>
					<div><label>type* :</label>
					<input name="type" type="text" value="<?php echo $doc[2]; ?>" /></div>
					<div><label>Éditeur* :</label>
					<input name="éditeur" type="text" value="<?php echo $doc[3]; ?>" /></div>
					<div><label>Collection :</label>
					<input name="collection" type="text" value="<?php echo $doc[4]; ?>" /></div>
					<div><label>Numéro :</label>
					<input name="numéro" type="text" value="<?php echo $doc[5]; ?>" /></div>
					<div><label>Date de Publication* :</label>
					<input name="date_publication" type="text" value="<?php echo date("d/m/Y", strtotime($doc[6])); ?>" /></div>
					<div><input name="update" type="submit" value="Modifier ce document" /></div>
				</form>
				</br>
				<a href="supprimer.php?id=<?php echo $doc_id; ?>">Supprimer ce document de la base de données</a>
				<?php
				}
			?>
		</p>
	</body>
</html>
