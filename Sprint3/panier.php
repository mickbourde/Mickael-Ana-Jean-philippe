<?php
require 'ExecuteRequest.php';
require 'connect.php';
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: connexion.php");
    exit;
}
$loggeduserid = $_SESSION["id"];
if (isset($_GET["action"])) {
    if ($_GET["action"] == "pay") {
        $sqlcmd = "SELECT * FROM dbchevalersk3.Panier_Achats INNER JOIN dbchevalersk3.Items on dbchevalersk3.Panier_Achats.NumItem = dbchevalersk3.Items.NumItem WHERE Num_Joueur = $loggeduserid";
        $result = mysqli_query($conn, $sqlcmd);
        $followingdata = $result->fetch_assoc();
        $total = 0;
            $total = $total + ($followingdata["Quantite_Achat"] * $followingdata["Prix"]);
            $sql = "DELETE FROM Panier_Achats WHERE Num_Joueur=$loggeduserid";
            $soldeDuJoueur = "SELECT * FROM Joueurs WHERE Num_Joueur = $loggeduserid";
            $resultat = mysqli_query($conn, $soldeDuJoueur);
            $value = mysqli_fetch_assoc($resultat);

            if ($value["Montant_Ecus"] >= $total ) {
                if (mysqli_query($conn, $sql)) {
                } else {
                    echo "Error: " . $sql . "
                " . mysqli_error($conn);
                }
                $sqlGet = "SELECT NumItem FROM Inventaire_Joueurs WHERE NumItem=". $followingdata["NumItem"] . " and Num_Joueur='$loggeduserid'";
	            $result = mysqli_query($conn,$sqlGet);

	            if(mysqli_num_rows($result) == 0 && $followingdata["Quantite_Stock"] >= $followingdata["Quantite_Achat"]){
                $PayerPanier = "Call PayerPanier(" . $followingdata["Quantite_Achat"] . "," . $followingdata["NumItem"] . "," . $loggeduserid . ",". $followingdata["Quantite_Stock"] . ",".$total.")";


                if (mysqli_query($conn, $PayerPanier)) {
                } else {
                    echo "Error: " . $PayerPanier . "
                " . mysqli_error($conn);
                }

                $UpdateQtestockPayer = "UPDATE Items set Quantite_Stock = ". $followingdata["Quantite_Stock"] . " - ".$followingdata["Quantite_Achat"]." where NumItem =". $followingdata["NumItem"];
                    
                    if (mysqli_query($conn, $UpdateQtestockPayer)) {
		            } else {
			            echo "Error: " . $UpdateQtestockPayer . "
				        " . mysqli_error($conn);
		            } 
                }
                else{
                    $UpdateQte = "Call PayerPanierSiItemDejaInventaire(" . $followingdata["Quantite_Achat"] . "," . $followingdata["NumItem"] . "," . $loggeduserid . ",". $followingdata["Quantite_Stock"] . ",".$total.")";
		            if (mysqli_query($conn, $UpdateQte)) {
		            } else {
			            echo "Error: " . $UpdateQte . "
				        " . mysqli_error($conn);
		            } 

                    $UpdateQtestock = "UPDATE Items set Quantite_Stock = ". $followingdata["Quantite_Stock"] . " - ".$followingdata["Quantite_Achat"]." where NumItem =". $followingdata["NumItem"];
                    
                    if (mysqli_query($conn, $UpdateQtestock)) {
		            } else {
			            echo "Error: " . $UpdateQtestock . "
				        " . mysqli_error($conn);
		            } 

                }

            } else {
                echo 'Pas assez dargent';
                echo '<script>window.location="panier.php"</script>';
            }
    }
    echo '<script>window.location="panier.php"</script>';
}




$viewTitle = <<<HTML
<title>Panier</title>
HTML;

$viewHref = <<<HTML
<li>
<a href="./index.php">Acceuil</a>
</li>
<li>
<a href="./shop.php">Shop</a>
</li>
HTML;



$viewContent = <<<HTML
<div class="inventaireShow">
<div class="inventaire">
<div style="clear: both"></div>
<h3 class="title2">Votre Panier </h3>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th width="10%"></th>
<th width="30%">Nom De L'Item</th>
<th width="10%">Quantite</th>
<th width="13%">Prix de l'item</th>
<th width="10%">Prix total</th>
<th width="17%">Supprimer l'item</th>
</tr>
HTML;



require 'connect.php';
$loggeduserid = $_SESSION["id"];
$total = 0;
$sqlcmd = "SELECT * FROM dbchevalersk3.Panier_Achats INNER JOIN dbchevalersk3.Items on dbchevalersk3.Panier_Achats.NumItem = dbchevalersk3.Items.NumItem WHERE Num_Joueur = $loggeduserid";
$result = mysqli_query($conn, $sqlcmd);
while ($row = mysqli_fetch_array($result)) {
    $test = $row['NumItem'];
    $img = $row["Photo"];
    
$viewContent .= <<<HTML
<tr>
<td>
<img src="$img" style="width:200px;height:200px;border-radius:3px;"/>
</td>
<td>
HTML;
     $viewContent .= $row["Nom_Item"]; 
    
    $viewContent .= <<<HTML
</td>
<td>
HTML;
    
    
    $qteStock = $row["Quantite_Stock"];
    $qteAchat = $row["Quantite_Achat"];
    
$viewContent .= <<<HTML
<form action="shop.php?action=modifier&id=$test" method="post">
<select name="quantite" >
<option> Quantite: $qteAchat</option>
<option> -- Modifier --</option>
HTML;
    $cmpt = 0;
    while ($cmpt < $qteStock) {
        $cmpt++;
$viewContent .= <<<HTML
<option value="$cmpt">$cmpt</option>
HTML;
    }

$viewContent .= <<<HTML
</select>
<input type="submit" name="submit" value="Modifier Quantite">
</form>
</td>
<td>$ 
HTML;

$viewContent .= $row["Prix"]; 
$viewContent .= <<<HTML
</td>
<td>
$ 
HTML;
    
     $viewContent .= number_format($row["Quantite_Achat"] * $row["Prix"], 2); 
     $viewContent .= <<<HTML
</td>
<td>
HTML;
    
$viewContent .= <<<HTML
<a href="shop.php?action=delete&id=$test">
<span class="text-danger">Remove Item</span>
</a>
</td>
HTML;
    
$viewContent .= <<<HTML
</tr>
HTML;

    $total = $total + ($row["Quantite_Achat"] * $row["Prix"]);
}
if(isset($_POST['submit'])){
    if(!empty($_POST['quantite'])) {
        $selected = $_POST['quantite'];
        $_SESSION["qte"]=$selected;
        echo $selected;
    } else {
        echo 'Please select the value.';
    }
    }

$viewContent .= <<<HTML
<tr>
<td colspan="3" align="right">Votre Solde</td>
<th align="right">$ 
HTML;


$sqlcmd = "SELECT * FROM dbchevalersk3.Joueurs WHERE Num_Joueur = $loggeduserid";
$result = mysqli_query($conn, $sqlcmd);
while ($qte = $result->fetch_assoc())
$viewContent .= $qte["Montant_Ecus"]; 




$viewContent .= <<<HTML
</tr>
<tr>
<td colspan="3" align="right">Total</td>
<th align="right">$ 
HTML;

 $viewContent .= number_format($total, 2); 

$viewContent .= <<<HTML
<a href="panier.php?action=pay">Pay</a></th>
</tr>
</table>
</div>
</div>
</div>  
</div> 
HTML;






include "view/master.php";
?>