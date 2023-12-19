<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<?php
    $errors=[];
    $vorname="";
    $nachname="";
    $username="";
    $email="";
    $passwort="";
    $confirmpasswort="";
    if (isset($_POST["signup"])){
        $vorname = isset($_POST["vorname"])? $_POST["vorname"]:"";
        $nachname = isset($_POST["nachname"])? $_POST["nachname"]:"";
        $username = isset($_POST["username"])? $_POST["username"]:"";
        $email = isset($_POST["email"])? $_POST["email"]:"";
        $passwort = isset($_POST["passwort"])? $_POST["passwort"]:"";
        $confirmpasswort = isset($_POST["confirmpasswort"])? $_POST["confirmpasswort"]:"";
        if(empty($vorname)){
            $errors["vorname"]="vorname wurde nicht eingegeben";
        }

        if(empty($nachname)){
            $errors["nachname"]="nachname wurde nicht eingegeben";
        }

        if(empty($username)){
            $errors["username"]="username wurde nicht eingegeben";
        }

        if(empty($email)){
            $errors["email"]="email wurde nicht eingegeben";
        }

        if(empty($passwort)){
            $errors["passwort"]="passwort wurde nicht eingegeben";
        }
        if(empty($confirmpasswort)){
            $errors["confirmpasswort"]="confirmpasswort wurde nicht eingegeben";
        }
    }
?>
<body>
    <div class="sign-body">
    <form method="post">
        <div class="sign-outter">
            <div class="sign-logo">
                <a href="?hotel">
                  <img src="./styles/fotos/upper-belvedere-vienna.png"  alt="Logo" width="65px">
                </a>
                <p class="sign-logo-p" style="font-size: 30px;">Vienna Stars Hotel</p>
            </div>
            <div class="signup-and-home">
                <p>Sign Up</p>
            </div>
            <div class="sign-bar">
                <div>
                    <?php
                        if($emailexist){
                            echo "<p class='error' style='text-align:center;'>Email existiert schon</p>";
                        }
                    ?>
                </div>
                <select class="sign-buttons" id="anrede" name="anrede" width="">
                    <option value="M" selected >Herr.</option>
                    <option value="F">Frau.</option>
                </select>
                    <input type="text" id="vorname" name="vorname" placeholder="Vorname" value="<?php echo $vorname ?>">
                    <?php
                        if(isset($errors['vorname'])){
                            echo "<p class='error' style='text-align:center;'>".$errors['vorname']."</p>";
                        }
                    ?>
                    <input type="text" id="nachname" name="nachname" placeholder="Nachname" value="<?php echo $nachname ?>">
                    <?php
                        if(isset($errors['nachname'])){
                            echo "<p class='error' style='text-align:center;'>".$errors['nachname']."</p>";
                        }
                    ?>
                    <input type="text" id="username" name="username" value="<?php echo $username ?>"  placeholder="Username">
                    <?php
                        if(isset($errors['username'])){
                            echo "<p class='error' style='text-align:center;'>".$errors['username']."</p>";
                        }
                    ?>
                    <input type="email" id="email" name="email" value="<?php echo $email ?>"  placeholder="Email">
                    <?php
                        if(isset($errors['email'])){
                            echo "<p class='error' style='text-align:center;'>".$errors['email']."</p>";
                        }
                    ?>
                    <input type="password" id="passwort" name="passwort" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" value="<?php echo $passwort ?>" placeholder="Passwort">
                    <?php
                        if(isset($errors['passwort'])){
                            echo "<p class='error' style='text-align:center;'>".$errors['passwort']."</p>";
                        }
                    ?>
                    <input type="password" id="confirmpasswort"  title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="confirmpasswort" value="<?php echo $confirmpasswort ?>"  placeholder="passwort wiederholen">
                    <?php
                        if(isset($errors['confirmpasswort'])){
                            echo "<p class='error' style='text-align:center;'>".$errors['confirmpasswort']."</p>";
                        }
                        if($passwort !== $confirmpasswort){
                            echo "<p class='error' style='font-weight:bold; text-align:center;'>passworts sind nicht identisch</p>";
                        }
                    ?>
                <div class="sign-buttons">
                    <p>Haben Sie sich schon regestiert? <a href="?signin">Zur Anmeldung</a></p> 
                    <div class="d-flex justify-content-between">
                        <button class="btn bg-dark text-white" type="submit" name="signup" id="Submit">Submit</button>
                        <a href="?hotel"><img src="./styles/fotos/house-solid.svg" alt="home" width="30px" title="Back to Home"></a> 
                    </div>
                </div>  
            </div>
        </div>
    </form>
    </div>
</body>
</html>