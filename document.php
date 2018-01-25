<?php
	include('session.php');
	$display = "";
	if (isset($_POST['insert'])) {
		if (empty($_POST['titre']) || empty($_POST['auteurs']) || empty($_POST['type']) || empty($_POST['éditeur']) || empty($_POST['date_publication'])) {
			$display = "Échec de la création du document, merci de remplir tous les champs";
			$doc_id = "error";
		}
		else {
			$stmt = mysqli_prepare($db, "INSERT INTO Documents(titre, type, éditeur, collection, numéro, date_publication) VALUES (?,?,?,?,?,?)");
			$coll = empty($_POST['collection'])?NULL:$_POST['collection'];
			$num = empty($_POST['numéro'])?NULL:$_POST['numéro'];
			mysqli_stmt_bind_param($stmt, "ssssss", $_POST['titre'], $_POST['type'], $_POST['éditeur'], $coll, $num, $_POST['date_publication']);
			mysqli_stmt_execute($stmt);
			$doc_id = mysqli_insert_id($db);
			if (mysqli_affected_rows($db) == 1) {
				$display = "Création du document réussie";
			}
			else {
				$display = "Échec de la création du document";
			}
			$auteurS = explode(",", $_POST['auteurs']);
			foreach($auteurS as $auteur)
			{
				$result = mysqli_query($db, "SELECT ID FROM Auteurs WHERE nom = '$auteur'");
				if(mysqli_num_rows($result) == 0)
				{
					mysqli_query($db, "INSERT INTO Auteurs(nom) VALUES ('$auteur')");
					$idAuteur = mysqli_insert_id($db);
				}
				else
				{
					$idAuteur = mysqli_fetch_row($result)[0];
				}
				mysqli_query($db, "INSERT INTO CrééPar VALUES ('$idAuteur', '$doc_id')");
			}
		}
	}
	else {
		$doc_id = $_GET['id'];
	}
	if (isset($_POST['update'])) {
		if (empty($_POST['titre']) || empty($_POST['auteurs']) || empty($_POST['type']) || empty($_POST['éditeur']) || empty($_POST['date_publication'])) {
			$display = "Échec de la mise à jour, merci de remplir tous les champs";
		}
		else {
			$auteurS = explode(",", $_POST['auteurs']);
			mysqli_query($db, " DELETE FROM CrééPar WHERE document = '$doc_id'");
			$change_auteur = False;
			foreach($auteurS as $auteur)
			{
				$result = mysqli_query($db, "SELECT ID FROM Auteurs WHERE nom = '$auteur'");
				if(mysqli_num_rows($result) == 0)
				{
					mysqli_query($db, "INSERT INTO Auteurs(nom) VALUES ('$auteur')");
					$idAuteur = mysqli_insert_id($db);
				}
				else
				{
					$idAuteur = mysqli_fetch_row($result)[0];
				}
				mysqli_query($db, "INSERT INTO CrééPar VALUES ('$idAuteur', '$doc_id')");
				if (mysqli_affected_rows($db) > 0) {
					$change_auteur = True;
				}
			}
			$stmt = mysqli_prepare($db, "UPDATE Documents SET titre=?, type=?, éditeur=?, collection=?, numéro=?, date_publication=? WHERE ID = '$doc_id'");
			$coll = empty($_POST['collection'])?NULL:$_POST['collection'];
			$num = empty($_POST['numéro'])?NULL:$_POST['numéro'];
			mysqli_stmt_bind_param($stmt, "ssssss", $_POST['titre'], $_POST['type'], $_POST['éditeur'], $coll, $num, $_POST['date_publication']);
			mysqli_stmt_execute($stmt);
			if (mysqli_affected_rows($db) > 0 || $change_auteur) {
				$display = "Modification du document réussie";
			}
			else {
				$display = "Échec de la modification du document";
			}
		}
	}
	if ($doc_id == "error") {?>
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
		<p id="info"><?php echo $display; ?></p>
	</body>
</html>
<?php	}
	else {
	$result = mysqli_query($db, " SELECT * FROM Documents WHERE Documents.ID = '$doc_id'") or die (mysqli_error());
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
					echo '.';
					if (!empty($doc[5])) {
						echo ' Elle est la ' . $doc[5];
						if ($doc[5] == 1) {echo 'ère';} else {echo 'ème';}
						echo ' de la série ' . $doc[4] . '.';
					}
				break;
				default:
					echo 'Parue le ' . date("d/m/Y", strtotime($doc[6])) . ' et éditée par ' . $doc[3] . ', ' . $doc[1] . ' est une œuvre écrite par ';
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
				<h2>Modifier le document</h2>
				<form action="<?php echo 'document.php?id=' . $doc_id; ?>" method="post">
					<div><label>Titre* :</label>
					<input name="titre" type="text" value="<?php echo $doc[1];?>" /></div>
					<div><label>Auteur(s)* (séparé(e)s par des virgules) :</label>
					<input name="auteurs" type="text" size ="50" value="<?php mysqli_data_seek($resultAuteur, 0); $nbr_aut = mysqli_num_rows($resultAuteur); while ($auteur = mysqli_fetch_row($resultAuteur)) {echo $auteur[0]; if ($nbr_aut > 1){echo ','; $nbr_aut--;}}?>" /></div>
					<div><label>Type* :</label>
					<input name="type" type="text" value="<?php echo $doc[2]; ?>" /></div>
					<div><label>Éditeur* :</label>
					<input name="éditeur" type="text" value="<?php echo $doc[3]; ?>" /></div>
					<div><label>Collection :</label>
					<input name="collection" type="text" value="<?php echo $doc[4]; ?>" /></div>
					<div><label>Numéro :</label>
					<input name="numéro" type="text" value="<?php echo $doc[5]; ?>" /></div>
					<div><label>Date de Publication* :</label>
					<input name="date_publication" type="text" value="<?php echo $doc[6]; ?>" /></div>
					<div><input name="update" type="submit" value="Modifier ce document" /></div>
				</form>
				</br>
				<a href="supprimer.php?id=<?php echo $doc_id; ?>">Supprimer ce document de la base de données</a>
				<?php
				}
			?>
		</p>
		<p id="info"><?php echo $display; ?></p>
	</body>
</html><?php }?>
