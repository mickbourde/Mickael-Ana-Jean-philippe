<?php
session_start();
if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == true) {
} else {
    echo "Vous n'avez pas les autorisations pour acceder a cette page";
    header("location: connexion.php");
}

$viewTitle = <<<HTML
<title>Page d'administration</title>
HTML;

$viewHref=<<<HTML
<li>
<a onclick="displayDiv()">Rajout d'item</a>
</li>

HTML;
$viewContent = <<<HTML
<div class="addItemForm">
<h3>Ajouter un item</h3>
<form name="ItemAddForm" method="post" class="addItemFormBody" action="ExecuteRequest.php">
<label for="Name"> Nom </label>
<br>
<input type="text" required name="Name">
<br>
<label min=1 for="Name"> Quantité en stock </label>
<br>
<input type="number" required name="quantity">
<br>
<label for="Name"> Type de l'object </label>
<br>
<select onchange="DrawExtraFields()" required class="ItemTypeSelect" type="select" name="Type">
<option hidden selected>Sélectionner un type...</option>
<option value="A">Armes</option>
<option value="AR">Armure</option>
<option value="P">Potions</option>
<option value="R">Ressource</option>
</select>
<br>
<label min=1 for="Name"> Prix </label>
<br>
<input required type="number" name="Price">
<br>
<label for="text"> Url de la photo </label>
<br>
<input required type="text" name="PhotoUrl">
<div class="ExtraInputField">
</div>
<br>
<input onclick="displayDiv()" name="backButton" value="Retour" type="button">
<input name="submitButton" value="Ajouter l'item" type="submit">
        
</form>
</div>
		
<div class="rechercheGauche">
		<!-- <h>Catégories</h> -->
<label class="container">Liste Des Usagers
<input type="radio" class="ListeJoueursRadio" name="adminRadio" checked="checked">
<span class="checkmark"></span>
</label>
<label class="container">Liste des items
<input type="radio" class="ListeItemsRadio" name="adminRadio">
<span class="checkmark"></span>
</label>
		
</div>
<div class="rechercheAdmin">
<div class="element">
<div class="adminView">
   
</div>
					
</div>
</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
       let cart= document.querySelector(".icon")
        cart.className="disableCartForAdmin";
       console.log(cart);
        
     
});
</script>
HTML;

include "view/master.php";
?>