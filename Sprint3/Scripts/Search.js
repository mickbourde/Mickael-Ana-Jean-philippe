$(window).load(function() {

    
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
//Section de l'administration////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////       

//Pour la section d'administration, on auras deux événements à surveiller: 

//Quand on appuie sur le contrôle pour voir tout les joueurs

//Quand on appuie sur le contrôle pour voir tout les items

//Quand on appuie sur le contrôle pour supprimer un item

$(document).ready(ExecuteAdminRequest("GetAllPlayers"));

$('.ListeJoueursRadio').bind('click',function () {
    ExecuteAdminRequest("GetAllPlayers");
});

$('.ListeItemsRadio').bind('click',function () {
    ExecuteAdminRequest("GetAllItems");
});



//Le boutton de delete appele la fonction deleteItem. Voir plus bas.



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
//Section de la recherche d'items////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    //NOTA:
    //Nous avons 3 situations ou nous devons lancer une recherche: Quand on load la page, quand on coche un checkbox et quand on appuie sur le bouton de recherche de keyword.
    $(document).ready(ExecuteRequest({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")}));

    
    //Quand on check
    $('.ArmesCheckbox').bind('click', function() {
        ResetStarSelect(true)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);
           
        }
        ExecuteRequest({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });

    $('.ArmuresCheckbox').bind('click', function() {
        ResetStarSelect(true)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);

        }
        ExecuteRequest({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });

    $('.PotionsCheckbox').bind('click', function() {
        ResetStarSelect(true)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);
           
        }
        ExecuteRequest ({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });
    $('.RessourcesCheckbox').bind('click', function() {
        ResetStarSelect(true)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);
            
        }
        ExecuteRequest({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });

    

    //Et quand on fait submit sur le bouton de recherche par keyword
   $('.bar').bind('submit',function(){
    ResetStarSelect()
    ExecuteRequest({"Keywords":$('input[type=text][name=keywordTextBox]').val()})
       return false;
   })

   $('.barNoConnect').bind('submit',function(){
    ResetStarSelect()
    ExecuteRequestNonConnecter({"Keywords":$('input[type=text][name=keywordTextBox]').val()})
       return false;
   })

   $(document).ready(ExecuteRequestNonConnecter({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")}));

    
    //Quand on check
    $('.ArmesCheckbox').bind('click', function() {
        ResetStarSelect(false)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);
           
        }
        ExecuteRequestNonConnecter({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });

    $('.ArmuresCheckbox').bind('click', function() {
        ResetStarSelect(false)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);

        }
        ExecuteRequestNonConnecter({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });

    $('.PotionsCheckbox').bind('click', function() {
        ResetStarSelect(false)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);
           
        }
        ExecuteRequestNonConnecter ({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });
    $('.RessourcesCheckbox').bind('click', function() {
        ResetStarSelect(false)
        if(!CheckCheckbox())
        {
        $('.submitItemSearch').attr("disabled",true); 
        }
        else{
            $('.submitItemSearch').attr("disabled",false);
            
        }
        ExecuteRequestNonConnecter({"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
    });

    

    //Et quand on fait submit sur le bouton de recherche par keyword
   $('.bar').bind('submit',function(){
    ResetStarSelect()
    ExecuteRequest({"Keywords":$('input[type=text][name=keywordTextBox]').val()})
       return false;
   })

   $('#étoilesConnecter').bind('change',function(){
       
        
            ExecuteRequest({"RechercheEtoile":$('#étoilesConnecter').children("option:selected").val(),"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
        
   })

   $('#étoilesUsager').bind('change',function(){

       ExecuteRequestNonConnecter({"RechercheEtoile":$('#étoilesUsager').children("option:selected").val(),"armes":$('.ArmesCheckbox').is(":checked"),"armures":$('.ArmuresCheckbox').is(":checked"),"potions":$('.PotionsCheckbox').is(":checked"),"ressources":$('.RessourcesCheckbox').is(":checked")})
     
})


});

//Cette fonction permet de clearer le select de nb d'étoiles des évaluations quand on choisit une autre catégorie dans la recherche. 
//En effet, on veut pouvoir choisir la catégorie et ENSUITE choisir une note moyenne
function ResetStarSelect(connected)
{
    if(connected)
    {
    $('#étoilesConnecter').val("0");
    }
    else
    {
        $('#étoilesUsager').val("0");
    }
}

function CheckCheckbox()
   {
       if($('.ArmesCheckbox').is(":checked")||$('.ArmuresCheckbox').is(":checked")||$('.PotionsCheckbox').is(":checked")||$('.RessourcesCheckbox').is(":checked"))
       {
           return false;
       }
       else return true;
   }
//La fonction ExecuteRequest serts à envoyer les booléens qui représentent l'état des checkbox à la page ExecuteRequest.php, qui elle renvoit la liste des items demandé.
function ExecuteRequest(demand){
    $.ajax({
    
        url:'ExecuteRequest.php',
        type: 'POST',
        data:{demand},
        success: function(result){
           DrawGallery(result);
        },
        error: function(){
            DrawGallery({'Erreur':"Une erreur s'est produite. Veuillez recharger la page."})
        } 
    })

}
function ExecuteRequestNonConnecter(demand){
    $.ajax({
    
        url:'ExecuteRequest.php',
        type: 'POST',
        data:{demand},
        success: function(result){
           DrawGalleryNonConnecter(result);
        },
        error: function(){
            DrawGalleryNonConnecter({'Erreur':"Une erreur s'est produite. Veuillez recharger la page."})
        } 
    })

}


function ExecuteAdminRequest(adminDemand,itemNum=null){
    if(adminDemand=="GetAllItems")
    {
    $.ajax({
        url:'ExecuteRequest.php',
        type: 'POST',
        data:{adminDemand},
        success: function(result){
            DrawAdminGallery(result,adminDemand=="GetAllItems"? true:false)
        },
        error: function(){
            DrawAdminGallery({'Erreur':"Une erreur s'est produite. Veuillez recharger la page."},false)
        } 
    })
    }
    if(adminDemand=="GetAllPlayers")
    {
        $.ajax({
            url:'ExecuteRequest.php',
            type: 'POST',
            data:{adminDemand},
            success: function(result){
                DrawAdminGallery(result,adminDemand=="GetAllItems"? true:false)
            },
            error: function(){
                DrawAdminGallery({'Erreur':"Une erreur s'est produite. Veuillez recharger la page."},false)
            } 
        })
    }
    if(adminDemand=="DeleteItem"&&itemNum!=null)
    {
        
        $.ajax({
            url:'ExecuteRequest.php',
            type: 'POST',
            data:{adminDemand,itemNum},
            success: function(result){
                DrawAdminGallery(result,true)
            },
            error: function(){
                DrawAdminGallery({'Erreur':"Une erreur s'est produite. Veuillez recharger la page."},false)
            } 
        })
    }
}

function deleteItem(numItem)
{
    ExecuteAdminRequest("DeleteItem",numItem);
}

//La fonction DrawGallery serts à dessiner la gallery tels que vu dans la page shop.php. Elle est appellé lorsque ExecuteRequest as recu le résultat des procédures stockées de ExecuteRequest.php.
function DrawGallery(receivedData){
    
    $('.gallery').html("");

   if(receivedData)
   {
       
var obj=JSON.parse(receivedData); 
var htmlString=" ";


  Object.values(obj).forEach(key => {
    
    htmlString+=
    "<a href=./detail.php?id="+key["NumItem"]+"> <img src="+key["Photo"]+" /></a>"+
    "<div class=\"desc\">"+
    key["Nom_Item"]+" "+key["Prix"]+"$"+
    "<form action=\"shop.php?action=add&id="+key["NumItem"]+"\" method=\"post\">"+
    "<input type=\"submit\" name=\"add\" style=\"margin-top: 5px;\" class=\"submitItemSearch\" value=\"Add to Cart\">"+
    "</form>  </div> "; 
     
});
   }
    htmlString+="</div>";
   
   $('.gallery').html(htmlString);
   
}

function DrawGalleryNonConnecter(receivedData){
    
    $('.galleryUsager').html("");

   if(receivedData)
   {
    var obj=JSON.parse(receivedData); 
    var htmlString=" ";


  Object.values(obj).forEach(key => {
    
htmlString+=
    "<a href=./detail.php?id="+key["NumItem"]+"> <img src="+key["Photo"]+" /></a>"+
    "<div class=\"desc\">"+
    key["Nom_Item"]+" "+key["Prix"]+"$"+
    "<form action=\"connexion.php\">"+
    "<input type=\"submit\" name=\"add\" style=\"margin-top: 5px;\" class=\"submitItemSearch\" value=\"Login\">"+
    "</form>  </div> ";   
     
    });
   }
    htmlString+="</div>";
   
    $('.galleryUsager').html(htmlString);
   
}


function DrawAdminGallery(receivedData,isListItemRequest){

    $('.adminView').html("");
    
    if(receivedData)
    {
        if(isListItemRequest)
        {
            var obj=JSON.parse(receivedData);
            var htmlString="<ul class=\"itemList\">";

            Object.values(obj).forEach(key=>{
                htmlString+=
                "<li class=\"adminViewItem\"> <img class=\"adminViewItemImg\" src=\""+key["Photo"]+"\"/>"+ 
                "<div class=\"adminViewItemStats\">"+
                "<h3 class=\"ItemText\">"+key["Nom_Item"]+"</h3>"+
                "<h5 class=\"ItemText\">Quantitée en Stock: </h5><p>"+key["Quantite_Stock"]+"</p>"+
                "<h5 class=\"ItemText\">Type: </h5><p>"+checkType(key["Type"])+"</p>"+
                "<h5 class=\"ItemText\">Prix: </h5> <p>"+key["Prix"]+"$"+"<p>"+
                "<h5 class=\"ItemText\">Disponibilitée: </h5><p>"+checkDisponibility(key["Disponible"])+"</p>"+
                "<img onclick=\"deleteItem("+key["NumItem"]+","+key["Disponible"]+")\" type=\"image\" class=\"DeleteButton\" value="+key["NumItem"]+" src=\"./img/supprimer.png\" data-tip=\"Supprimer\"> ";
                htmlString+="</div> <span title=\"ToolTip\" class=\"TooltipText"+key["NumItem"]+"\">Supprimer "+key["Nom_Item"]+"</span> </li> ";
            });
            htmlString+="</ul>";
        }
        else
        {
            var obj=JSON.parse(receivedData);
            var htmlString="<ul class=\"PlayerList\">";

            Object.values(obj).forEach(key=>{
                htmlString+=
               
                "<li>"+
                "<div class=\"NameContainer\">"
                +key["Alias"]+
                "</div>"+
                "<div class=\"userInfoContainer\">"+
                "<h3 class=\"ItemText\">Nom: </h3>" +key["Nom"]+
                "<h3 class=\"ItemText\">Prénom: </h3>"+key["Prenom"]+
                "</div>"+
                "<div class=\"userActionContainer\">"+
                "<a href=\"inventaire.php?Id="+key["Num_Joueur"]+"\">Inventaire du joueur</a>"+
                "</br>"+
                "<a href=\"comments.php?Id="+key["Num_Joueur"]+"\">Commentaires du joueur</a>"+
                "</br>"+
                "</br>"+
                "<label for=\"inputEcus\"> Modifier le montant d'écus </label>"+
                "<input type=\"hidden\" class=\"EcuInvisible"+key["Num_Joueur"]+"\" value="+key["Montant_Ecus"]+"></input>"+
                "<input class=\"ecuInput"+key["Num_Joueur"]+"\" type=\"number\" name=\"inputEcus\" value="+key["Montant_Ecus"]+"></input>"+
                "<input type=\"button\" value=\"Modifier\" onclick=\"changeMoneyAmount("+key["Num_Joueur"]+")\"></input>"+
                "</div>"+
                "</li>"+
                "<hr/>";
            });
            htmlString+="</ul>";
        }
        $('.adminView').html(htmlString);
    }

    function checkType(Char){

        switch(Char)
        {
            case "A":
                return "Arme";
            case "AR":
                return "Armure";
            case "P":
                return "Potion";
            case "R":
                return "Ressource";
                
        }
    }
    function checkDisponibility(num)
    {
        
        if(num==true)
        {
            return "Disponible";
        }
        else return "Non-disponible";
    }
}

function switchOnClick(elem)
{
console.log("entering");
    if(elem.style.color=='grey')
    {

        console.log("Switching to green");

        elem.style.color='green';

    }
    else if(elem.style.color=="green")
    {

        console.log("Switching to grey");

        elem.style.color='grey';

    }

}



