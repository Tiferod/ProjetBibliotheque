<?php
	include('session.php');
?>
<!DOCTYPE html>
<html>
	<?php
		$id = $_GET['id'];
		$doc = mysqli_query($db, " SELECT * FROM Documents WHERE Documents.ID = '$id'") or die (mysql_error());
		$row = mysqli_fetch_row($doc);
	?>
	<head>
		<title><?php echo $row[1]; ?></title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<p>
			<?php
				include('header.php');
			?>
			<h1><?php echo $row[1]; ?></h1>
		</p>
	</body>
</html>
