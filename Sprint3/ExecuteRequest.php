<?php
require 'connect.php';

//À titre de test. Pour voir si ca fonctionne, j'ai mis ca poure qu'on puisse voir les enregistrements
//$result=ListAllItems($conn);


if (isset($_POST["demand"])) {
   
   $request = $_POST["demand"];
   
   $queries = [];
   $disponible=false;



   if (array_key_exists("Keywords", $request)) {
      
      $keyword = $request["Keywords"];
      $queries[] = "CALL SearchItemsByName('$keyword')";
   } else {
     
      if(array_key_exists("RechercheEtoile",$request))
      {
         
         $nbÉtoiles=$request["RechercheEtoile"];
         if ($request["armes"] == "true") {
            $queries[] = "SELECT NumItem,Nom_Item,Prix,Photo, Disponible from Items where Type = 'A' and Disponible=true and avgRating=$nbÉtoiles;";
         }
         if ($request["armures"] == "true") {
            $queries[] = "SELECT NumItem,Nom_Item,Prix,Photo, Disponible from Items where Type = 'AR' and Disponible=true and avgRating=$nbÉtoiles;";
         }
         if ($request["potions"] == "true") {
            $queries[] = "SELECT NumItem,Nom_Item,Prix,Photo, Disponible from Items where Type = 'P' and Disponible=true and avgRating=$nbÉtoiles;";
         }
         if ($request["ressources"] == "true") {
            $queries[] = "SELECT NumItem,Nom_Item,Prix,Photo, Disponible from Items where Type = 'R' and Disponible=true and avgRating=$nbÉtoiles;";
         }
         if (($request["armes"] == "false" && $request["armures"] == "false" && $request["potions"] == "false" && $request["ressources"] == "false")) {
            
            $queries[] = "SELECT NumItem,Nom_Item,Prix,Photo, Disponible from Items where Disponible=true and avgRating=$nbÉtoiles;";
         }
        
      }
      else
      {
         
      if ($request["armes"] == "true") {
         $queries[] = "CALL SearchItemsArmes();";
      }
      if ($request["armures"] == "true") {
         $queries[] = "CALL SearchItemsArmures();";
      }
      if ($request["potions"] == "true") {
         $queries[] = "CALL SearchItemsPotions();";
      }
      if ($request["ressources"] == "true") {
         $queries[] = "CALL SearchItemsRessources();";
      }
      if (($request["armes"] == "false" && $request["armures"] == "false" && $request["potions"] == "false" && $request["ressources"] == "false")) {
         $queries[] = "CALL AfficherToutLesItemsJoueur()";
      }
   }
   }
   

   echo json_encode(executeSearch($conn, $queries));

}

if(isset($_POST["adminDemand"])){
   $request=$_POST["adminDemand"];
   $queries=[];
   $disponible=true;

   if($request=="ChangeMoneyAmount")
   {
      $nouveauMontant=$_POST["nouveauMontant"];
      $numjoueur=$_POST["numJoueur"];

      executeChangeMoneyRequest($conn,$numjoueur,$nouveauMontant);

      //$queries[]="CALL ChangerMontantÉcus($nouveauMontant,$numjoueur)";
   }
   if($request=="DeleteItem")
   {
      $itemNum=$_POST["itemNum"];
      
      executeDeleteRequest($conn,$itemNum);
   
      $queries[]="CALL AfficherToutLesItemsAdmin()";
   }

   if($request=="GetAllItems")
   {
      $queries[]="CALL AfficherToutLesItemsAdmin()";
   }
   else if($request=="GetAllPlayers")
   {
      $queries[]="CALL AfficherTousLesJoueurs()";
   }

   echo json_encode(executeSearch($conn, $queries));
   
}

if(isset($_POST["submitButton"]))
{
   $name= mysqli_real_escape_string($conn,$_POST["Name"]);

   $quantity=$_POST["quantity"];
   
   $type= mysqli_real_escape_string($conn,$_POST["Type"]);
   
   $price=$_POST["Price"];
   
   $photoUrl= mysqli_real_escape_string($conn,$_POST["PhotoUrl"]);
   

    switch($type){
       case 'A':
         $efficacity=$_POST["Efficacity"];
         $genre= mysqli_real_escape_string($conn,$_POST["Gender"]);
         $description= mysqli_real_escape_string($conn,$_POST["Description"]);
         
            $conn->query("INSERT INTO dbchevalersk3.Items (Nom_Item,Quantite_Stock,Type,Prix,Photo, Disponible) VALUES ('$name','$quantity','$type','$price','$photoUrl','1'); ");
            $lastId=(int)($conn->insert_id);
            echo($lastId);
            $result=$conn->query("INSERT INTO dbchevalersk3.Armes (NumItem,Efficacite,Genre,Description_Arme) VALUES ('$lastId','$efficacity','$genre','$description'); ") or die(mysqli_error($conn));
            echo($result);
          break;
      case 'AR':
         $material= mysqli_real_escape_string($conn,$_POST["Material"]);
         $weight=$_POST["Weight"];
         $size= mysqli_real_escape_string($conn,$_POST["Size"]);

         $conn->query("INSERT INTO dbchevalersk3.Items (Nom_Item,Quantite_Stock,Type,Prix,Photo, Disponible) VALUES ('$name','$quantity','$type','$price','$photoUrl','1'); ");
         $lastId=(int)($conn->insert_id);
         $result=$conn->query("INSERT INTO dbchevalersk3.Armures (NumItem,Matiere,Poids,Taille) VALUES ('$lastId','$material','$weight','$size'); ") or die(mysqli_error($conn));

         echo($_POST["Metarial"]);
         echo($_POST["Weight"]);
         echo($_POST["Size"]);
         break;
      case 'P':
         $effect= mysqli_real_escape_string($conn,$_POST["Effect"]);
         $effectTime=$_POST["EffectTime"];

         $conn->query("INSERT INTO dbchevalersk3.Items (Nom_Item,Quantite_Stock,Type,Prix,Photo, Disponible) VALUES ('$name','$quantity','$type','$price','$photoUrl','1'); ");
         $lastId=(int)($conn->insert_id);
         echo($lastId);
         $result=$conn->query("INSERT INTO dbchevalersk3.Potions (NumItem,Effet,Duree) VALUES ('$lastId','$effect','$effectTime'); ") or die(mysqli_error($conn));
         echo($_POST["Effect"]);
         echo($_POST["EffectTime"]);
         break;
      case 'R':
         $description= mysqli_real_escape_string($conn,$_POST["Description"]);
         $conn->query("INSERT INTO dbchevalersk3.Items (Nom_Item,Quantite_Stock,Type,Prix,Photo, Disponible) VALUES ('$name','$quantity','$type','$price','$photoUrl','1'); ");
         $lastId=(int)($conn->insert_id);
         $result=$conn->query("INSERT INTO dbchevalersk3.Ressources (NumItem,Description_Ressource) VALUES ('$lastId','$description'); ") or die(mysqli_error($conn));
         echo($_POST["Description"]);
         break;
    }

    echo '<script>window.location="admin.php"</script>';
   
}

   

function executeSearch($conn, $queries)
{
   $rows = [];
   
   foreach ($queries as $query) {
      $result = $conn->query($query);
      while ($row = mysqli_fetch_assoc($result)) {
         $rows[] = $row;
      }

      if(mysqli_more_results($conn))
      {
      mysqli_next_result($conn);
      }
   }
  
   
   return $rows;
}

function executeDeleteRequest($conn,$itemNum)
{
  $result= $conn ->query("CALL SupprimerItem($itemNum)");
}

function executeChangeMoneyRequest($conn,$numjoueur,$nouveauMontant)
{
   $result=$conn->query("CALL ChangerMontantÉcus($nouveauMontant,$numjoueur)");
   echo $result;
}


function debug_to_console($data)
{
   $output = $data;
   if (is_array($output))
      $output = implode(',', $output);

   echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>