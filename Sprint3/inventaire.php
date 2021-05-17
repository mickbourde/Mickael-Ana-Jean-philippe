<?php
include "connect.php";
session_start();
if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == true) {
    $loggeduserid=$_GET["Id"];
    $_SESSION["loggedin"] = true;
} else {
    $loggeduserid = $_SESSION["id"];
}

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: connexion.php");
    exit;
}
?>

<?php
$viewTitle = <<<HTML
<title>Inventaire</title>
HTML;
?>

<?php
if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == true) {
    $viewHref = <<<HTML
<li>
<a href="./admin.php">Retour</a>
</li>
HTML;
} else {
$viewHref = <<<HTML
<li>
<a href="./shop.php">Retour</a>
</li>
HTML;
}
?>

<?php
$viewContent=<<<HTML
<div class="inventaireShow">
<div class="inventaire">
<div style="clear: both">
<h3 class="title2">Votre Inventaire </h3>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
    <th width="10%">Image</th>
    <th width="30%">Nom De L'Item</th>
    <th width="10%">Quantite</th>
    
</tr>
HTML;
$InventaireJoueur = "CALL AfficherInventaireJoueur($loggeduserid)"; 
$result = mysqli_query($conn,$InventaireJoueur);
while($row = mysqli_fetch_array($result)) {
    $Image = $row["Photo"];
    $NumItem = $row["NumItem"];
    $Nom = $row["Nom_Item"];
    $Qte = $row["Quantite_Inventaire"];
    if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == true){
$viewContent.=<<<HTML
<tr>
<td><img src="$Image" style="width:100px"/></a></td>
<td width="30%">$Nom</td>
<td width="10%">$Qte</td>
</tr>
HTML;
    }
    else{
$viewContent.=<<<HTML
<tr>
<td><a href="./evaluation.php?id=$NumItem"><img src="$Image" style="width:100px"/></a></td>
<td width="30%">$Nom</td>
<td width="10%">$Qte</td>
</tr>
HTML;
    }


}

?>
</tr>
</table>
</div>
</div>
</div>
<?php
include "view/master.php";
include "connect.php";
?>