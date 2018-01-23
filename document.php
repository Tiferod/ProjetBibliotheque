<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<?php
		$doc_id = $_GET['id'];
		$result = mysqli_query($db, " SELECT * FROM Documents WHERE Documents.ID = '$doc_id'") or die (mysql_error());
		$doc = mysqli_fetch_row($result);
		$resultAuteur = mysqli_query($db, "SELECT Auteurs.nom FROM CrééPar, Auteurs WHERE CrééPar.document = '$doc_id' AND CrééPar.auteur = Auteurs.ID");
		$nbrAuteur = mysqli_num_rows($resultAuteur);
	?>
	<head>
		<title><?php echo $doc[1]; ?></title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<p>
			<?php
				include('header.php');
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
	</body>
</html>
