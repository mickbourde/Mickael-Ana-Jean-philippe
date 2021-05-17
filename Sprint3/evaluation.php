<?php
include "connect.php";
session_start();
if (isset($_GET["action"])) {
	if ($_GET["action"] == "delete") {
		$sql = "DELETE FROM Ratings WHERE IdRating=" . $_GET["id"];
		if (mysqli_query($conn, $sql)) {
		} else {
			echo "Error: " . $sql . "
            " . mysqli_error($conn);
			
		}
	}
	echo '<script>window.location="inventaire.php"</script>';
}
    $loggeduserid = $_SESSION["id"];
$idItem = $_GET['id'];

$viewTitle = <<<HTML
<title>Ratings</title>
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
<a href="./inventaire.php">Retour</a>
</li>
HTML;
 $viewContent = <<<HTML
<h>Mon Evaluation</h>
<div class="displayRatings">
       
HTML;

?>

<?php
    
    
    
    
// get average
$myquery = "SELECT ROUND(AVG(Nb_etoiles),1) as averageRating FROM Ratings WHERE NumItem=".$idItem;
$avgresult = mysqli_query($conn,$myquery);
if (!$avgresult) {
    printf("Error: %s\n", mysqli_error($conn));
}
$fetchAverage = mysqli_fetch_array($avgresult);
$averageRating = $fetchAverage['averageRating'];
if($averageRating <= 0){
    $averageRating = "No rating yet.";
}

//Affichage de l'item et Rating Average
$ItemAEvaluer = "SELECT * FROM Items WHERE NumItem = $idItem"; 
$result = mysqli_query($conn,$ItemAEvaluer);
while ($row = mysqli_fetch_array($result)) {
$image = $row["Photo"];
$viewContent .= <<<HTML
<div class="displayRatingInfo">
<table class="tabImageRating">
<tr>
<td><img src="$image" style="width:200px;height:200px;border-radius:3px;" class="imageRating"/></td>
</tr>
<tr>
<td class="displayAverage" > <i class="glyphicon glyphicon-star"><i>$averageRating </td>
</tr>
</table>
HTML;
}

//formulaire pour ajouter un rating
$viewContent .= <<<HTML
<form id="addRating" class="newReviewFor" method=post action="#">
<input type="hidden" name="userid" value=" <?php $loggeduserid?>" >
<input type="hidden" name="idItem" value="<?php $idItem?>">
            
<label for="rating" class="labelRating">Rate This</label>
<input id="rating" name="rating" class="rating rating-loading" data-max="5" data-step="1" required>
<br>
<textarea   type="text"     
id="comment"     
name="comment"
class=""
rows="4" cols="40"
placeholder="Commentaires sur l'item..." required></textarea>
<br>
<input type="submit" name="SubmitButton" value="enregistrer"/>
</form>
</div>
<div id="allRatingsEval"  >
HTML;
//all ratings for the item
$query = "SELECT IdRating, Nb_etoiles, Commentaires FROM Ratings WHERE NumItem = $idItem"; 
$result = mysqli_query($conn,$query);
while($row = mysqli_fetch_array($result)){
    $rating_id = $row['IdRating'];
    $commentaire = $row['Commentaires'];
    $nbEtoiles = $row['Nb_etoiles'];
    
$viewContent .= <<<HTML
<table class="reviews" style="font-size: 20px; width:35%; margin:auto; justify-content:center">
<tr>
<td class="displayAverage">  <i class="glyphicon glyphicon-star"><i>$nbEtoiles</td>
</tr>
<tr>
<td> $commentaire </td>
</tr>
<tr>
<td><a href="evaluation.php?action=delete&id=$rating_id">Supprimer</a></td>
</tr>
</table>
<div>
</div>
HTML;

}

//Statistiques des Ratings
$grandTotal = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $idItem";
$total = mysqli_query($conn,$grandTotal);
while($row = mysqli_fetch_array($total)){
    $totalEvaluations = $row['TotalRatings'];
}
//5 stars
$totalEval5 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $idItem AND Nb_etoiles = 5";
$total5 = mysqli_query($conn,$totalEval5);
while($row = mysqli_fetch_array($total5)){
    $Evaluation5 = $row['TotalRatings'];
}
if($Evaluation5 > 0)
    $stats5 =  ($Evaluation5 * 100)/$totalEvaluations;
else 
    $stats5 =  0.5;

//4 stars
$totalEval4 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $idItem AND Nb_etoiles = 4";
$total4 = mysqli_query($conn,$totalEval4);
while($row = mysqli_fetch_array($total4)){
    $Evaluation4 = $row['TotalRatings'];
}
if($Evaluation4 > 0)
    $stats4 =  ($Evaluation4 * 100)/$totalEvaluations;
else 
    $stats4 =  0.5;
//3 stars
$totalEval3 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $idItem AND Nb_etoiles = 3";
$total3 = mysqli_query($conn,$totalEval3);
while($row = mysqli_fetch_array($total3)){
    $Evaluation3 = $row['TotalRatings'];
}
if($Evaluation3 > 0)
    $stats3 =  ($Evaluation3 * 100)/$totalEvaluations;
else 
    $stats3 =  0.5;
//2 stars
$totalEval2 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $idItem AND Nb_etoiles = 2";
$total2 = mysqli_query($conn,$totalEval2);
while($row = mysqli_fetch_array($total2)){
    $Evaluation2 = $row['TotalRatings'];
}
if($Evaluation2 > 0)
    $stats2 =  ($Evaluation2 * 100)/$totalEvaluations;
else 
    $stats2 =  0.5;

//1 star
$totalEval1 = "SELECT COUNT(IdRating) AS TotalRatings  FROM Ratings WHERE NumItem = $idItem AND Nb_etoiles = 1";
$total1 = mysqli_query($conn,$totalEval1);
while($row = mysqli_fetch_array($total1)){
    $Evaluation1 = $row['TotalRatings'];
}
if($Evaluation1 > 0)
    $stats1 =  ($Evaluation1 * 100)/$totalEvaluations;
else 
    $stats1 = 0.5;



// get average
$getAvg = "SELECT ROUND(AVG(Nb_etoiles),1) as averageRating FROM Ratings WHERE NumItem=".$idItem;
$avg = mysqli_query($conn,$getAvg);
$fetchAverageStats = mysqli_fetch_array($avg);
$avgRating = $fetchAverageStats['averageRating'];
if($avgRating <= 0){
    $avgRating = 0;
}

$viewContent .= <<<HTML
</div>
</div>
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
    
if(isset($_POST["rating"])){
$rating = $_POST['rating'];
$commentaire = $_POST['comment'];
$numJoueur = $loggeduserid;
$numItem = $idItem;
     
$insertquery = "INSERT INTO Ratings(NumItem,Num_Joueur,Nb_etoiles,Commentaires) VALUES (".$numItem.",".$numJoueur.",".$rating.",'".$commentaire."')";
    
if (mysqli_query($conn, $insertquery)) {
} else {
     echo "Error: " . $insertquery . "
    " . mysqli_error($conn);
}
    echo '<script>window.location="inventaire.php"</script>';
}
include "view/master.php";
include "connect.php";
?>