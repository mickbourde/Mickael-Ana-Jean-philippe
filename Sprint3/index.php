
<?php
session_start();
function Connecter(){
	
	if(isset($_SESSION["loggedin"])&&$_SESSION["loggedin"]==true)
	{
		return "./shop.php";
	}
	else
	{
		return "./shopUsager.php";
	}
}
$shop = Connecter();
$viewHref = <<<HTML
<li>
	<a href=$shop>Shop</a>
</li>
<li>
</li>
HTML;


$viewTitle = <<<HTML
<title>Accueil</title>
HTML;



$viewContent = <<<HTML
<img  src="./img/Fond.jpg" />
<div class="text">
<h1>Acheter des items feront de vous le meilleur !</h1>
</div> 
HTML;


include "view/master.php";
?>