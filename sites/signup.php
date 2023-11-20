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
    $password="";
    $confirmpassword="";
    if (isset($_POST["signup"])){
        $vorname = isset($_POST["vorname"])? $_POST["vorname"]:"";
        $nachname = isset($_POST["nachname"])? $_POST["nachname"]:"";
        $username = isset($_POST["username"])? $_POST["username"]:"";
        $email = isset($_POST["email"])? $_POST["email"]:"";
        $password = isset($_POST["password"])? $_POST["password"]:"";
        $confirmpassword = isset($_POST["confirmpassword"])? $_POST["confirmpassword"]:"";
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

        if(empty($password)){
            $errors["password"]="password wurde nicht eingegeben";
        }
        if(empty($confirmpassword)){
            $errors["confirmpassword"]="confirmpassword wurde nicht eingegeben";
        }
    }
?>
<body class="sign-body">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="sign-outter">
            <div class="sign-logo">
                <img src="./styles/fotos/upper-belvedere-vienna.png" class="sign-logo-img" alt="Logo" width="80px">
                <p class="sign-logo-p mt-4" style="font-size: 30px;">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar">
                <div class="signup-and-home">
                    <p>Sign Up</p>
                </div>
                <select class="sign-buttons" id="Anrede" name="Anrede" width="">
                    <option value="Herr.">Herr.</option>
                    <option value="Frau.">Frau.</option>
                </select>
                <input type="text" id="vorname" name="vorname" placeholder="Vorname" value="<?php echo $vorname ?>"  size="12">
                <?php
                    if(isset($errors['vorname'])){
                        echo "<span class='error''>".$errors['vorname']."</span>";
                    }
                ?>
                <input type="text" id="nachname" name="nachname" placeholder="Nachname" value="<?php echo $nachname ?>"  size="12">
                <?php
                    if(isset($errors['nachname'])){
                        echo "<span class='error'>".$errors['nachname']."</span>";
                    }
                ?>
                <input type="text" id="username" name="username" value="<?php echo $username ?>"  placeholder="UserName">
                <?php
                    if(isset($errors['username'])){
                        echo "<span class='error'>".$errors['username']."</span>";
                    }
                ?>
                <input type="email" id="email" name="email" value="<?php echo $email ?>"  placeholder="Email">
                <?php
                    if(isset($errors['email'])){
                        echo "<span class='error'>".$errors['email']."</span>";
                    }
                ?>
                <input type="password" id="password" name="password" value="<?php echo $password ?>" placeholder="Password">
                <?php
                    if(isset($errors['password'])){
                        echo "<span class='error'>".$errors['password']."</span>";
                    }
                ?>
                <input type="password" id="confirmPassword" name="confirmpassword" value="<?php echo $confirmpassword ?>"  placeholder="Password wiederholen">
                <?php
                    if(isset($errors['confirmpassword'])){
                        echo "<span class='error'>".$errors['confirmpassword']."</span>";
                    }
                    if($password !== $confirmpassword){
                        echo "<span class='error' style='font-weight:bold;'>Passwords sind nicht identisch</span>";
                    }
                ?>
                <div class="sign-buttons d-flex justify-content-between">
                    <button class="btn bg-dark text-white" type="submit" name="signup" id="Submit">Submit</button>
                    <a href="?hotel"><img src="./styles/fotos/house-solid.svg" alt="home" width="30px" title="Back to Home"></a> 
                </div>    
            </div>
        </div>
    </form>
</body>
</html>