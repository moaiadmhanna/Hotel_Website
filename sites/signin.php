<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in </title>
</head>
<?php
    $errors=[];
    $email="";
    $password="";
    if(isset($_POST["login"])){
        $email=isset($_POST["email"])?$_POST["email"]:"";
        $password=isset($_POST["password"])?$_POST["password"]:"";
        if(empty($email)){
            $errors["email"]="Kein Email wurde eingegeben";
        }
    
        if(empty($password)){
            $errors["password"]="Kein password wurde eingegeben";
        }
    }
?>
<body class="sign-body">
<form method="post">
    <div class="sign-outter">
        <div>
            <div class="sign-logo">
                <img src="./styles/fotos/upper-belvedere-vienna.png" alt="Logo" width="60px">
                <p class="sign-logo-p">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar">
                <div class="signup-and-home">
                    <p>Sign In</p>
                </div>
                <input type="email" id="email" name="email" value="<?php echo $email?>"placeholder="Email:">
                <?php
                    if(isset($errors["email"]) && $signInFalse==false){
                        echo "<span class='error'>".$errors["email"]."</span>";
                    }
                ?>
                <input type="password" id="password" name="password"  value="<?php echo $password?>" placeholder="Password:">
                <?php
                    if(isset($errors["password"]) && $signInFalse==false){
                        echo "<span class='error'>".$errors["password"]."</span>";
                    }
                ?>
                <div class="sign-buttons d-flex justify-content-between">
                    <button class="btn bg-dark text-white" type="submit" name="login" id="submit">Submit</button>
                    <a href="?hotel"><img src="./styles/fotos/house-solid.svg" alt="home" width="30px" title="Back to Home"></a>
                </div>
            </div>
    </div>
</form>
</body>
</html>