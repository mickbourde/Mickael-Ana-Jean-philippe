<?php
require_once "connect.php";

$username = $prenom = $nom = $password = $confirm_password = "";
$username_err = $prenom_err = $nom_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $sql = "SELECT Num_Joueur FROM dbchevalersk3.Joueurs WHERE Alias = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    if (empty(trim($_POST["prenom"]))) {
        $prenom_err = "Veuiller entrer un prenom";
    } else {
        $sql = "SELECT Num_Joueur FROM dbchevalersk3.Joueurs WHERE Prenom = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_prenom);

            $param_prenom = trim($_POST["prenom"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);


                $prenom = trim($_POST["prenom"]);
            } else {
                echo "Essayer plus tard";
            }

            mysqli_stmt_close($stmt);
        }
    }
    if (empty(trim($_POST["nom"]))) {
        $nom_err = "Veuiller entrer un nom";
    } else {
        $sql = "SELECT Num_Joueur FROM dbchevalersk3.Joueurs WHERE Nom = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_nom);

            $param_nom = trim($_POST["nom"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                $nom = trim($_POST["nom"]);
            } else {
                echo "Essayer plus tard";
            }

            mysqli_stmt_close($stmt);
        }
    }


    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty($username_err) && empty($prenom_err) && empty($nom_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = "INSERT INTO dbchevalersk3.Joueurs (Alias,Prenom,Nom, Mot_De_Passe) VALUES (?,?,?,?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_prenom, $param_nom, $param_password);

            $param_username = $username;
            $param_prenom = $prenom;
            $param_nom = $nom;
            $param_password = $password;

            if (mysqli_stmt_execute($stmt)) {
                header("location: connexion.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>S'incscire</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            background-color: #4B362E; 
        }
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
    </style>
</head>

<body>
    <div class="wrapper">
        <div>
        <h2 <h2 style="text-align : center">Connexion</h2>>S'inscrire</h2>
        <p>Remplicer ce formulaire pour vous inscrire</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Alias</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($prenom_err)) ? 'has-error' : ''; ?>">
                <label>Prenom</label>
                <input type="text" name="prenom" class="form-control" value="<?php echo $prenom; ?>">
                <span class="help-block"><?php echo $prenom_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($nom_err)) ? 'has-error' : ''; ?>">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?php echo $nom; ?>">
                <span class="help-block"><?php echo $nom_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Mot De Passe</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Valider Le Mot De Passe</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Entrer">
                <input type="reset" class="btn btn-default" value="Réinitialiser">
            </div>
            <hr>
            <div style="text-align:center">
                Vous avez déjà un compte? <br>
                <a href="connexion.php"><button class="button" type="button" >Connectez-vous ici</button></a>
            </div>
        </form>
        </div>
    </div>
</body>

</html>