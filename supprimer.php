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
		if ($_SESSION['is_admin'])
		{
			$doc_id = $_GET['id'];
			mysqli_query($db, " DELETE FROM Documents WHERE ID = '$doc_id'") or die (mysql_error());
			mysqli_query($db, " DELETE FROM CrééPar WHERE document = '$doc_id'") or die (mysql_error());
		}
		?>
		<p>Le document a été correctement supprimé.</p>
	</body>
</html>