<?php
include "connect.php";
session_start();
$loggeduserid = $_SESSION["id"];


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: connexion.php");
    exit;
}
$username = "";
$username_err = "";
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if (empty(trim($_POST["username"]))) {
        $username_err = "Entrer un alias si vous voulez le changer";
    } else {
        $sql = "SELECT Num_Joueur FROM dbchevalersk3.Joueurs WHERE Alias = ?";

        if ($stmts = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmts, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmts)) {
                mysqli_stmt_store_result($stmts);

                if (mysqli_stmt_num_rows($stmts) == 1) {
                    $username_err = "Alias deja utilise ";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Un problème est survenu. Veuillez réessayer plus tard.";
            }

            mysqli_stmt_close($stmts);
        }
    }
    if(empty($username_err) ){
        $sql = "UPDATE Joueurs SET Alias = ? WHERE Num_Joueur = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_username, $param_id);
            
            $param_username = $username;
            $param_id = $_SESSION["id"];
            
            if(mysqli_stmt_execute($stmt)){
                header("location: shop.php");
                exit();
            } else{
                echo "Oops! Un problème est survenu. Veuillez réessayer plus tard.";
            }
            mysqli_stmt_close($stmt);
        }
    }
 
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Entrer le nouveau mot de passe";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Le mot de passe doit avoir au moins 6 caracteres";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirmer le mot de passe";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Le mot de passe ne correspond pas.";
        }
    }
        
    if(empty($new_password_err) && empty($confirm_password_err)){
        $sql = "UPDATE Joueurs SET Mot_De_Passe = ? WHERE Num_Joueur = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            $param_password = $new_password;
            $param_id = $_SESSION["id"];
            
            if(mysqli_stmt_execute($stmt)){
                header("location: shop.php");
                exit();
            } else{
                echo "Oops! Un problème est survenu. Veuillez réessayer plus tard.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; background-color: #4B362E; }
        .wrapper{ 
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .wrapper>div {
        background-color:#BDAD91;
        padding: 1em;
        border-radius: 10px;
        }
        .button{
            width:10em;
            align-self: right;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div>
        <h2 style="text-align : center">Profil</h2>
        <p>Remplir le formulaire pour modifier votre profil</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Alias</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Nouveau Mot De Passe</label>
                <input type="password" name="new_password" class="form-control" >
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmer Mot De Passe</label>
                <input type="password" name="confirm_password" class="form-control" >
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group"style="text-align:center">
                <input type="submit" class="btn btn-primary" value="Modifier">
            </div>
            <hr>
            <div style="text-align:center">
                Vous ne voulez pas modifier votre profil?  <br>
                <a href="shop.php"><button class="button" type="button">Cliquez Ici</button></a>
                <br><br>
            </div>
        </form>
        </div>
    </div>    
</body>
</html>