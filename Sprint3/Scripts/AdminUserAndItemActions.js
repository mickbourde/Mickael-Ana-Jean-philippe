//Ce script serts à changer le nombre d'écus d'un joueur.
//Auteur: Jean-Philippe Brosseau

let divIsDisplayed=false;
function changeMoneyAmount(numJoueur)
{
    let ancienMontant=$('.EcuInvisible'+numJoueur).val();
    let nouveauMontant=Number.parseInt($('.ecuInput'+numJoueur).val());
    
    
    if(isNaN(nouveauMontant)!=true&&nouveauMontant>0)
    {
  
     let adminDemand="ChangeMoneyAmount";
    $.ajax({
        url:'ExecuteRequest.php',
        type: 'POST',
        data:{adminDemand,nouveauMontant,numJoueur},
        success: function(){
            $('.EcuInvisible'+numJoueur).val(nouveauMontant);
           alert("Montant changé.");
        },
        error: function(){
            console.log("Une erreur s'est produite. veuillez contacter l'administrateur.");
        } 
    })
}
else{
    $('.ecuInput'+numJoueur).val($('.EcuInvisible'+numJoueur).val());
}
}

function TryParseInt(str,defaultValue) {
    var retValue = defaultValue;
    if(str !== null) {
        if(str.length > 0) {
            if (!isNaN(str)) {
                retValue = parseInt(str);
            }
        }
    }
    return retValue;
}

function displayDiv()
{
console.log(divIsDisplayed);
    if(!divIsDisplayed)
    {
    console.log("Changing display props");
    $('.addItemForm').css({"display":"block"});
    divIsDisplayed=true;
    }
    else
    {
        $('.addItemForm').css({"display":"none"});
        divIsDisplayed=false;
    }
}

function DrawExtraFields()
{
    var selectBox=$('.ItemTypeSelect').find(":selected").val();

    
    var htmlString;

    switch(selectBox)
    {
        case 'A':
            htmlString= '<label for="Efficacity"> Efficacitée de l\'arme </label>'+
            '</br>'+
            '<input required type="number" name="Efficacity" ></input>'+
            '</br>'+
            '<label for="Gender"> Genre de l\'arme </label>'+
            '</br>'+
            '<input required type="text" name="Gender"></input>'+
            '</br>'+
            '<label for="Description"> Description de l\'arme </label>'+
            '</br>'+
            '<textarea required style="width:90%;" cols=4 name="Description"> </textarea>';
            break;
        case 'AR':
            htmlString='<label for="Material"> Matériel de l\'armure </label>'+
            '</br>'+
            '<input required type="text" name="Material" ></input>'+
            '</br>'+
            '<label for="Weight"> Poid de l\'armure </label>'+
            '</br>'+
            '<input required min=0 type="number" name="Weight"></input>'+
            '</br>'+
            '<label for="Size"> Taille de l\'armure </label>'+
            '</br>'+
            '<input required type="text" name="Size"></input>';
            break;
        case 'P':
            htmlString='<label for="Effect"> Effet de la potion</label>'+
            '</br>'+
            '<input required type="text" name="Effect" ></input>'+
            '</br>'+
            '<label for="EffectTime"> Durée de l\'effet </label>'+
            '</br>'+
            '<input required min=1 type="time" name="EffectTime"></input>';
            break;
        case 'R':
            htmlString='<label for="Description"> Description de la ressource </label>'+
            '</br>'+
            '<textarea required style="width:90%;" cols=4 name="Description"> </textarea>';
            break;
    }
    
    $('.ExtraInputField').html(htmlString);

}