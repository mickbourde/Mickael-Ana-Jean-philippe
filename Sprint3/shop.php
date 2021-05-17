<?php
require 'ExecuteRequest.php';
require 'connect.php';
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	
}
if (isset($_POST["add"])) {
	$loggeduserid = $_SESSION["id"];
	$id = $_GET["id"];

	$sql = "SELECT NumItem FROM Panier_Achats WHERE NumItem='$id' and Num_Joueur='$loggeduserid'";
	$result = mysqli_query($conn,$sql);

	if(mysqli_num_rows($result) == 0)
	{
		$ajouterpanier = "INSERT INTO Panier_Achats (NumItem, Quantite_Achat, Num_Joueur)
                		VALUES (" . $id. ", 1," . $loggeduserid . ")";
		if (mysqli_query($conn, $ajouterpanier)) {
		} else {
			echo "Error: " . $ajouterpanier . "
            " . mysqli_error($conn);
		}
	}
	else
	{
		$UpdateQte = "UPDATE Panier_Achats set Quantite_Achat = Quantite_Achat+1 where NumItem='$id' and Num_Joueur='$loggeduserid'";
		if (mysqli_query($conn, $UpdateQte)) {
		} else {
			echo "Error: " . $UpdateQte . "
				" . mysqli_error($conn);
		} 
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
			
		}
	}
	echo '<script>window.location="panier.php"</script>';
}
if (isset($_GET["action"])) {
	$numItem = $_GET["id"];
	$loggeduserid = $_SESSION["id"];
	if(isset($_POST['submit'])){
		if(!empty($_POST['quantite'])) {
			$selected = $_POST['quantite'];
			if ($_GET["action"] == "modifier") {
				$UpdatePanier = "UPDATE Panier_Achats set Quantite_Achat = $selected where NumItem=$numItem and Num_Joueur=$loggeduserid";
				// $UpdatePanier = "Call UpdateQuantitePanier($selected,$loggeduserid,$numItem)";
			if (mysqli_query($conn, $UpdatePanier)) {
			} else {
				echo "Error: " . $UpdatePanier . "
					" . mysqli_error($conn);
			} 
		} else {
			echo 'Please select the value.';
		}
	}
	
    echo '<script>window.location="panier.php"</script>'; 
	}
}


//Section de la page----------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------

$viewHref = <<<HTML
<li>
<a style="cursor:pointer" onclick="openNav()">&#9776;recherche</a>
</li>
<li>
<a href="./index.php">Acceuil</a>
</li>
<li>
<a href="./inventaire.php">Mon Inventaire</a>
</li>
<li>
<a href="./profil.php">Mon Profil</a>
</li>
HTML;

$viewTitle = <<<HTML
<title>Shop</title>
HTML;

$viewContent = <<<HTML
<div class="sideNav" id="mySidenav">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<form class="bar"  method="post">
<input type="text"  name="keywordTextBox" value="">
<input type="submit"  class="submitItemSearch" value="search">
</form>
		<!-- <h>Catégories</h> -->
<label class="container"  onclick="switchOnClick(this)">Armes
<input type="checkbox" class="ArmesCheckbox" name="researchRadio" >
</label>

<label class="container" onclick="switchOnClick(this)">Armures
<input type="checkbox" class="ArmuresCheckbox" name="researchRadio" >
</label>

<label class="container" onclick="switchOnClick(this)">Potions
<input type="checkbox" class="PotionsCheckbox" name="researchRadio" >
</label>

<label class="container"  onclick="switchOnClick(this)">Ressources
<input type="checkbox" class="RessourcesCheckbox" name="researchRadio" >
</label>

<label class="container">Recherche par moyenne d'évaluations

<select name="searchÉtoiles" id="étoilesConnecter">
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
<div class="gallery">
</div>					
</div>
</div>
</div>
</div>


HTML;

include "view/master.php";
