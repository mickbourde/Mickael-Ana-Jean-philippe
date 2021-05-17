<?php
require 'connect.php';
session_start();

if(isset($_POST['deleteComment']))
{
  $playerId=$_POST['playerId'];

  $itemId=$_POST['Id'];


  $query="DELETE FROM Ratings WHERE IdRating=$itemId";

  
  $conn->query($query);

  
}
if(isset($_GET['Id']))
{
$playerId=$_GET['Id'];
}
if (isset($_SESSION['isadmin']) && $_SESSION['isadmin']==true) {
    
    $query= "SELECT IdRating,Commentaires,Nom_Item,Photo from Ratings R inner join Items I on R.NumItem=I.NumItem where R.Num_Joueur=$playerId";
    $result=mysqli_query($conn,$query);

    if(mysqli_num_rows($result)==0)
    {
      header("location:admin.php");
    }

} else {
    echo "Vous n'avez pas les autorisations pour acceder a cette page";
    header("location: connexion.php");
}

$viewHref = <<<HTML
<li>
<a href="./admin.php">Retour</a>
</li>

HTML;

$viewTitle = <<<HTML
<title>Page d'administration</title>
HTML;

$viewContent=<<<HTML
<div class="adminCommentListContainer"> Voici mon div
<table class="commentEntryTable">
<th class="tableHeader">Photo</th>
<th class="tableHeader">Nom de l'item</th>
<th class="tableHeader">Commentaire</th>
<th></th>

HTML;
$entries=mysqli_fetch_assoc($result);

foreach($result as $entry)
{


$photo=$entry['Photo'];

$commentaire=$entry['Commentaires'];

$nomItem=$entry['Nom_Item'];

$id=$entry["IdRating"];


$viewContent.=<<<HTML
<tr>
<td id="commentTablePhoto">
<img src="$photo"/>
</td>
<td id="commentTableName">
<p>$nomItem</p>
</td>
<td id="commentTableComment">
$commentaire
</td>
<td>
<form action="" method="post">
<input type="submit" name="deleteComment" value="Supprimer le commentaire"/>
<input type="hidden" name="Id" value="$id"/>
<input type="hidden" name="deleteMessage" value="Le commentaire as été supprimé avec succès." />
<input type="hidden" name="playerId" value=$playerId />
</form>
</td>
</tr>
HTML;
}
$viewContent.=<<<HTML
</table>
</div>
HTML;
include 'view/master.php';

?>