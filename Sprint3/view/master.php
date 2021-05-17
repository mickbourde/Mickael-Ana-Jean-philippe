<?php
include 'scriptsBundle.php';

function Connect(){
if(isset($_SESSION["loggedin"]) == true)
	{
		return "Deconnexion";
	}
	else
	{
		return "Connexion";
	}
}
function IconCart(){
	if(isset($_SESSION["loggedin"]) == true)
		{
			return "";
		}
		else
		{
			return "hidden";
		}
	}
$connect = Connect();
$cartIcon = IconCart();
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	$viewTitle
	$scriptsBundle
</head>

<body style="background-color: #4B362E">
	<div class="box1">
	<ul>
		<li><a href="./Deconnexion.php"> $connect</a></li>
	</ul>
	</div>
	<div class="box2">
		<script>
			function openNav() {
			document.getElementById("mySidenav").style.width = "auto";
			document.getElementById("main").style.marginLeft = "250px";
			}

			/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
			function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
			document.getElementById("main").style.marginLeft = "0";
			} 
		</script>
		<ol>
			$viewHref
		</ol>
		<div class="icon">
		<a $cartIcon href="./panier.php"><img class="cart" src="./img/cart.png" /></a>
		
		<h2>Chevaleresk</h2>
		</div>
	</div>
	<div class="cover">
   $viewContent
		</div>
	</div>
	
</body>

</html>	
HTML;
?>