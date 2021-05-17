<?php
require 'ExecuteRequest.php';
require 'connect.php';
session_start();

if (isset($_POST["add"])) {
	$loggeduserid = $_SESSION["id"];
	$ajouterpanier = "INSERT INTO Panier_Achats (NumItem, Quantite_Achat, Num_Joueur)
                VALUES (" . $_GET["id"] . ", 1," . $loggeduserid . ")";
	if (mysqli_query($conn, $ajouterpanier)) {
	} else {
		echo "Error: " . $ajouterpanier . "
            " . mysqli_error($conn);
	}
	echo '<script>window.location="panier.php"</script>';
}

if (isset($_GET["action"])) {
	if ($_GET["action"] == "delete") {
		$sql = "DELETE FROM Panier_Achats WHERE NumItem=" . $_GET["id"];
		if (mysqli_query($conn, $sql)) {
		} else {
			echo "Error: " . $sql . "
            " . mysqli_error($conn);
			echo '<script>window.location="panier.php"</script>';
		}
	}
}

$viewHref = <<<HTML
<li>
<a style="cursor:pointer" onclick="openNav()">&#9776;recherche</a>
</li>
<li>
<a href="./index.php">Acceuil</a>
</li>
<li>
<a href="">À Propos</a>
</li>
HTML;

$viewTitle = <<<HTML
<title>Shop</title>
HTML;

$viewContent = <<<HTML
<div class="sideNav" id="mySidenav">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<form class="barNoConnect"  method="post">
<input type="text"  name="keywordTextBox" value="">
<input type="submit"  class="submitItemSearch" value="search">
</form>


		<!-- <h>Catégories</h> -->
	

<label class="container"  onclick="switchOnClick(this)">Armes
<input type="checkbox" class="ArmesCheckbox" name="researchRadio">

</label>

<label class="container" onclick="switchOnClick(this)">Armures
<input type="checkbox" class="ArmuresCheckbox" name="researchRadio">

</label>
<label class="container" onclick="switchOnClick(this)">Potions
<input type="checkbox" class="PotionsCheckbox" name="researchRadio" >

</label>
<label class="container"  onclick="switchOnClick(this)">Ressources
<input type="checkbox" class="RessourcesCheckbox" name="researchRadio" >

</label>

<label class="container">Recherche par moyenne d'évaluations</label>
</br>
<select name="searchÉtoiles" id="étoilesUsager">
<option hidden selected value="0">Sélectionner un nombre d'étoiles...</option>
<option value="1">1 étoile</option>
<option value="2">2 étoiles</option>
<option value="3">3 étoiles</option>
<option value="4">4 étoiles</option>
<option value="5">5 étoiles</option>
 </select>

</div>
<div id="main">
<div class="rechercheShop">
<div class="element">
<div class="galleryUsager">
</div>					
</div>
</div>
</div>
</div>
HTML;

include "view/master.php";
