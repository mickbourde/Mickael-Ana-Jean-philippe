<?php
include "connect.php";
	
?>

<?php
$viewTitle = <<<HTML
<title>Details</title>
<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/demo.css">
<!-- Script -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/js/star-rating.min.js" type="text/javascript"></script>
<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>
HTML;


$viewHref = <<<HTML
<li>
<a href="./shop.php">Retour</a>
</li>
HTML;
?>

<?php

$id = $_GET['id'];

//Statistiques des Ratings
$grandTotal = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $id";
$total = mysqli_query($conn,$grandTotal);
while($row = mysqli_fetch_array($total)){
    $totalEvaluations = $row['TotalRatings'];
}
//5 stars
$totalEval5 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $id AND Nb_etoiles = 5";
$total5 = mysqli_query($conn,$totalEval5);
while($row = mysqli_fetch_array($total5)){
    $Evaluation5 = $row['TotalRatings'];
}
if($Evaluation5 > 0)
    $stats5 =  ($Evaluation5 * 100)/$totalEvaluations;
else 
    $stats5 =  0.5;

//4 stars
$totalEval4 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $id AND Nb_etoiles = 4";
$total4 = mysqli_query($conn,$totalEval4);
while($row = mysqli_fetch_array($total4)){
    $Evaluation4 = $row['TotalRatings'];
}
if($Evaluation4 > 0)
    $stats4 =  ($Evaluation4 * 100)/$totalEvaluations;
else 
    $stats4 =  0.5;
//3 stars
$totalEval3 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $id AND Nb_etoiles = 3";
$total3 = mysqli_query($conn,$totalEval3);
while($row = mysqli_fetch_array($total3)){
    $Evaluation3 = $row['TotalRatings'];
}
if($Evaluation3 > 0)
    $stats3 =  ($Evaluation3 * 100)/$totalEvaluations;
else 
    $stats3 =  0.5;
//2 stars
$totalEval2 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $id AND Nb_etoiles = 2";
$total2 = mysqli_query($conn,$totalEval2);
while($row = mysqli_fetch_array($total2)){
    $Evaluation2 = $row['TotalRatings'];
}
if($Evaluation2 > 0)
    $stats2 =  ($Evaluation2 * 100)/$totalEvaluations;
else 
    $stats2 =  0.5;

//1 star
$totalEval1 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $id AND Nb_etoiles = 1";
$total1 = mysqli_query($conn,$totalEval1);
while($row = mysqli_fetch_array($total1)){
    $Evaluation1 = $row['TotalRatings'];
}
if($Evaluation1 > 0)
    $stats1 =  ($Evaluation1 * 100)/$totalEvaluations;
else 
    $stats1 = 0.5;



// get average
$getAvg = "SELECT ROUND(AVG(Nb_etoiles),1) as averageRating FROM Ratings WHERE NumItem=".$id;
$avg = mysqli_query($conn,$getAvg);
$fetchAverageStats = mysqli_fetch_array($avg);
$avgRating = $fetchAverageStats['averageRating'];
if($avgRating <= 0){
    $avgRating = 0;
}


$sqlRating = "SELECT * from Ratings inner join Joueurs on Ratings.Num_Joueur = Joueurs.Num_Joueur where NumItem = $id";
$resultatRatings = mysqli_query($conn, $sqlRating);



$TrouverTypeDitem = "SELECT Type FROM dbchevalersk3.Items where NumItem = $id";
$result = mysqli_query($conn, $TrouverTypeDitem) or die("Error: " . mysqli_error($conn));
while ($row = mysqli_fetch_array($result)) {

    // DETAIL DES RESSOURCES
    if ($row["Type"] = 'R') {
        $sqlcmd = "SELECT * FROM dbchevalersk3.Items INNER JOIN 
        dbchevalersk3.Ressources on dbchevalersk3.Items.NumItem = dbchevalersk3.Ressources.NumItem where Ressources.NumItem = $id";
        $result = mysqli_query($conn, $sqlcmd) or die("Error: " . mysqli_error($conn));

        while ($row = mysqli_fetch_array($result)) {
            $description = $row["Description_Ressource"];
            $image = $row["Photo"];
            
//Affichage pour les ressources
$viewContent = <<<HTML
<div style="clear: both; display:flex; justify-content:left !important; flex-direction:row;padding: 2em;">
<div>
<h3 class="title2" style="text-align:center">Details</h3>
<br>
<div class="table-responsive"> 
<table>
<tr>
<th>Image</th>
<th>Description</th>
</tr>
<tr>
<td><img src="$image" style="width:200px;height:200px;border-radius:3px;"/></td>
<td class="tdDescription">$description</td>
</tr>
</table>
</div>
<div style="clear: both">
<div class="table-responsive">
<h3 class="title2">Evaluations</h3>
<table >
<tr>
<th>Alias</th>
<th>Ratings </th>
<th>Commentaires</th>
</tr>
HTML;

while ($value = mysqli_fetch_array($resultatRatings)) {
    $AliasRating = $value["Alias"];
    $CommentairesRating = $value["Commentaires"];
    $CommentairesRating = $value["Commentaires"];
    $EtoilesRating = $value["Nb_etoiles"];

$viewContent .= <<<HTML

<td>$AliasRating</td>
<td class="displayAverage">  <i class="glyphicon glyphicon-star"><i>$EtoilesRating</td>
<td>$CommentairesRating</td>
</tr>
HTML;
}
$viewContent .= <<<HTML
</table>
</div>
</div>
</div>
</div>
HTML;

$viewContent .= <<<HTML
<div class="stats">
<span>
<h1>moyenne des evaluations :</h1> <br/>
<input id="rating" name="rating" class="rating rating-loading" data-max="5" data-step="1" value= $avgRating readOnly> 
</span>

<div class="row">
<div class="side">
<div>5 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-5" style="width: $stats5%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation5</div>
</div>
<div class="side">
<div>4 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-4" style="width: $stats4%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation4</div>
</div>
<div class="side">
<div>3 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-3" style="width: $stats3%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation3</div>
</div>
<div class="side">
<div>2 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-2" style="width: $stats2%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation2</div>
</div>
<div class="side">
<div>1 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-1" style="width: $stats1%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation1</div>
</div>
</div>
</div>
HTML;

        }
    }

    // DETAIL DES ARMES
    if ($row["Type"] = 'A') {
        $sqlcmd = "SELECT * FROM dbchevalersk3.Items INNER JOIN 
dbchevalersk3.Armes on dbchevalersk3.Items.NumItem = dbchevalersk3.Armes.NumItem where Armes.NumItem = $id";
        $result = mysqli_query($conn, $sqlcmd) or die("Error: " . mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
            $efficacite = $row["Efficacite"];
            $genre = $row["Genre"];
            $description = $row["Description_Arme"];
            $image = $row["Photo"];

$viewContent = <<<HTML
<div style="clear: both; display:flex; justify-content:left !important; flex-direction:row;padding: 2em;">
<div>
<h3 class="title2" style="text-align:center">Details</h3>
<br>
<div class="table-responsive" >
<table>
<tr>
<th>Image</th>
<th>Efficatite</th>
<th>Genre</th>
<th>Description</th>
</tr>
<tr>
<td><img src="$image"style="width:200px;height:200px;border-radius:3px;"/></td>
<td>$efficacite</td>
<td>$genre</td>
<td class="tdDescription">$description</td>
</tr>
</table>
</div>
<div style="clear: both"></div>
<div class="table-responsive" >
<h3 class="title2">Evaluations</h3>
<table>
<tr>
<th>Alias</th>
<th>Ratings </th>
<th>Commentaires</th>
</tr>
HTML;

while ($value = mysqli_fetch_array($resultatRatings)) {
    $AliasRating = $value["Alias"];
    $CommentairesRating = $value["Commentaires"];
    $CommentairesRating = $value["Commentaires"];
    $EtoilesRating = $value["Nb_etoiles"];

$viewContent .= <<<HTML

<td>$AliasRating</td>
<td class="displayAverage">  <i class="glyphicon glyphicon-star"><i>$EtoilesRating</td>
<td>$CommentairesRating</td>
</tr>
 
HTML;
}
$viewContent .= <<<HTML
</table>
</div>
</div>
</div>
HTML;

$viewContent .= <<<HTML
<div class="stats">
<span>
<h1>moyenne des evaluations :</h1> <br/>
<input id="rating" name="rating" class="rating rating-loading" data-max="5" data-step="1" value= $avgRating readOnly> 
</span>

<div class="row">
<div class="side">
<div>5 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-5" style="width: $stats5%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation5</div>
</div>
<div class="side">
<div>4 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-4" style="width: $stats4%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation4</div>
</div>
<div class="side">
<div>3 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-3" style="width: $stats3%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation3</div>
</div>
<div class="side">
<div>2 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-2" style="width: $stats2%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation2</div>
</div>
<div class="side">
<div>1 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-1" style="width: $stats1%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation1</div>
</div>
</div>
</div>
HTML;

        }
    }

    // DETAIL DES ARMURES
    if ($row["Type"] = 'AR') {
        $sqlcmd = "SELECT * FROM dbchevalersk3.Items INNER JOIN 
dbchevalersk3.Armures on dbchevalersk3.Items.NumItem = dbchevalersk3.Armures.NumItem where Armures.NumItem = $id";
        $result = mysqli_query($conn, $sqlcmd) or die("Error: " . mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
            $matiere = $row["Matiere"];
            $poid = $row["Poids"];
            $taille = $row["Taille"];
            $image = $row["Photo"];

$viewContent = <<<HTML
<div style="clear: both; display:flex; justify-content:left !important; flex-direction:row;padding: 2em;">
<div>
<h3 class="title2" style="text-align:center">Details</h3>
<br>
<div class="reviews">
<table>
<tr>
<th>Image</th>
<th>Matiere</th>
<th>Poids</th>
<th>Taille</th>
</tr>
<tr>
<td><img src="$image"style="width:200px;height:200px;border-radius:3px;"/></td>
<td>$matiere</td>
<td>$poid</td>
<td>$taille</td>
</tr>
</table>
</div>
<div style="clear: both"></div>
<div class="table-responsive" >
<h3 class="title2">Evaluations</h3>
<table>
<tr>
<th>Alias</th>
<th>Ratings </th>
<th>Commentaires</th>
</tr>
HTML;

while ($value = mysqli_fetch_array($resultatRatings)) {
    $AliasRating = $value["Alias"];
    $CommentairesRating = $value["Commentaires"];
    $CommentairesRating = $value["Commentaires"];
    $EtoilesRating = $value["Nb_etoiles"];

$viewContent .= <<<HTML

<td>$AliasRating</td>
<td class="displayAverage">  <i class="glyphicon glyphicon-star"><i>$EtoilesRating</td>
<td>$CommentairesRating</td>
</tr>
 
HTML;
}
$viewContent .= <<<HTML
</table>
</div>
</div>
</div>
HTML;

$viewContent .= <<<HTML
<div class="stats">
<span>
<h1>moyenne des evaluations :</h1> <br/>
<input id="rating" name="rating" class="rating rating-loading" data-max="5" data-step="1" value= $avgRating readOnly> 
</span>

<div class="row">
<div class="side">
<div>5 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-5" style="width: $stats5%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation5</div>
</div>
<div class="side">
<div>4 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-4" style="width: $stats4%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation4</div>
</div>
<div class="side">
<div>3 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-3" style="width: $stats3%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation3</div>
</div>
<div class="side">
<div>2 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-2" style="width: $stats2%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation2</div>
</div>
<div class="side">
<div>1 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-1" style="width: $stats1%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation1</div>
</div>
</div>
</div>
HTML;

        }
    }

    // DETAIL DES POTIONS
    if ($row["Type"] = 'P') {
        $sqlcmd = "SELECT * FROM dbchevalersk3.Items INNER JOIN 
dbchevalersk3.Potions on dbchevalersk3.Items.NumItem = dbchevalersk3.Potions.NumItem where Potions.NumItem = $id";
        $result = mysqli_query($conn, $sqlcmd) or die("Error: " . mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
            $effet = $row["Effet"];
            $duree = $row["Duree"];
            $image = $row["Photo"];

$viewContent = <<<HTML
<div style="clear: both; display:flex; justify-content:left !important; flex-direction:row;padding: 2em;">
<div>
<h3 class="title2" style="text-align:center">Details</h3>
<br>
<div class="reviews">
<table>
<tr>
<th>Image</th>
<th>Effet</th>
<th>Duree</th>
</tr>
<tr>
<td><img src="$image" style="width:200px;height:200px;border-radius:3px;"/></td>
<td>$effet</td>
<td>$duree</td>
</tr>
</table>
</div>
<table>
<div style="clear: both"></div>
<div class="table-responsive" >
<h3 class="title2">Evaluations</h3>
<table>
<tr>
<th>Alias</th>
<th>Ratings </th>
<th>Commentaires</th>
</tr>
HTML;

while ($value = mysqli_fetch_array($resultatRatings)) {
    $AliasRating = $value["Alias"];
    $CommentairesRating = $value["Commentaires"];
    $CommentairesRating = $value["Commentaires"];
    $EtoilesRating = $value["Nb_etoiles"];

$viewContent .= <<<HTML

<td>$AliasRating</td>
<td class="displayAverage">  <i class="glyphicon glyphicon-star"><i>$EtoilesRating</td>
<td>$CommentairesRating</td>
</tr>
 
HTML;
}
$viewContent .= <<<HTML
</table>
</div>
</div>
HTML;

$viewContent .= <<<HTML
<div class="stats">
<span>
<h1>moyenne des evaluations :</h1> <br/>
<input id="rating" name="rating" class="rating rating-loading" data-max="5" data-step="1" value= $avgRating readOnly> 
</span>

<div class="row">
<div class="side">
<div>5 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-5" style="width: $stats5%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation5</div>
</div>
<div class="side">
<div>4 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-4" style="width: $stats4%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation4</div>
</div>
<div class="side">
<div>3 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-3" style="width: $stats3%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation3</div>
</div>
<div class="side">
<div>2 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-2" style="width: $stats2%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation2</div>
</div>
<div class="side">
<div>1 star</div>
</div>
<div class="middle">
<div class="bar-container">
<div class="bar-1" style="width: $stats1%"></div>
</div>
</div>
<div class="side right">
<div>$Evaluation1</div>
</div>
</div>
</div>
HTML;


        }
    }
}
?>

<?php
include "view/master.php";
include "connect.php";
?>