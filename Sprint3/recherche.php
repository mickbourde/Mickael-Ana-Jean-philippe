<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: connexion.php");
	exit;
}

if (isset($_GET['submit'])) {
	$text = $_GET['text'];
	$sqlRecherche = "SELECT * FROM dbchevalersk3.Items WHERE Nom_Item LIKE %$text%";
	$cmd = mysqli_query($conn, $sqlRecherche) or die("Fail");

	if (mysqli_num_rows($cmd) > 0) {
		$count = 0;
		while ($row = mysqli_fetch_assoc($cmd)) {
			$count++;
		}
?>
		<!DOCTYPE html>
		<html>

		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">

			<title>Accueil</title>

			<link rel="stylesheet" href="css/demo.css">
			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@1,300&display=swap" rel="stylesheet">

		</head>

		<body>
			<div class="box1">
				<ul>
					<li><a href="./deconnexion.php">Deconnexion</a></li>
				</ul>
			</div>
			<div class="box2">
				<ol>
					<li><a href="./shop.php">Retour</a></li>
				</ol>
				<div class="icon">
					<a href=""><img class="cart" src="./img/cart.png" /></a>

					<h2>Chevaleresk</h2>
				</div>
			</div>
			<div class="cover">
				<img src="./img/Fond.jpg" />
				<table cellpadding="10px">
					<tr>
						<th>Id</th>
						<th width="300">Nom</th>
						<th width="400">Prix</th>
					</tr>
					<tr>
						<td>
							<?php echo $count; ?>
						</td>
						<td>
							<?php echo $row['Nom_Item']; ?>
						</td>
						<td>
							<?php echo $row['Prix']; ?>
						</td>
					</tr>
				</table>
			</div>

		</body>

		</html>
<?php }
} ?>