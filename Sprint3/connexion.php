<?php
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
/* if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: accueil.php");
    exit;
} */
 
require_once "connect.php";
$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["username"] == "admin" && $_POST["password"] == "123456")
    {
        $_SESSION["isadmin"] = true;
        header("location: admin.php");
    }
    else
    {
        $_SESSION["isadmin"] = false;
    if(empty(trim($_POST["username"]))){
        $username_err = "Entrer votre alias";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Entrer votre mot de passe";
    } else{
        $password = trim($_POST["password"]);
    }
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT Num_Joueur, Alias, Mot_De_Passe FROM dbchevalersk3.Joueurs WHERE Alias = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $password);
                    if(mysqli_stmt_fetch($stmt)){
                        if($_POST["password"] ==$password){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: index.php");
                        } else{
                            $password_err = "Mot de passe invalide";
                        }
                    }
                } else{
                    $username_err = "Aucun compte avec cet alias";
                }
            } else{
                echo "Erreur";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
    
    mysqli_close($conn);
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
        <h2 style="text-align : center">Connexion</h2>
        <p>Remplir le formulaire pour vous connecter</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Alias</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Mot De Passe </label>
                <input type="password" name="password" class="form-control" >
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group"style="text-align:center">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <hr>
            <div style="text-align:center">
                Vous n'avez pas de compte?  <br>
                <a href="Inscire.php"><button class="button" type="button">Inscrivez-vous</button></a>
                <br><br>
                <p>ou</p>
                Accedez au site sans compte? <br>
                <a href="index.php"><button class="button" type="button" >Cliquez Ici</button></a>
            </div>
        </form>
        </div>
    </div>    
</body>
</html>