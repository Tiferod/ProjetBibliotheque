<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Suppression des documents</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include('admin_header.php');
			$doc_id = $_GET['id'];
			mysqli_query($db, " DELETE FROM Documents WHERE ID = '$doc_id'") or die (mysqli_error());
			mysqli_query($db, " DELETE FROM CrééPar WHERE document = '$doc_id'") or die (mysqli_error());
			if (mysqli_affected_rows($db) > 0) {
				echo '<p id="info">Le document a été correctement supprimé.</p>';
			}
			else {
				echo '<p id="info">Erreur lors de la suppression du document.</p>';
			}
		?>
	</body>
</html>