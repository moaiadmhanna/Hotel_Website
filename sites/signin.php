
<?php
    $errors=[];
    $email="";
    $passwort="";
    if(isset($_POST["login"])){
        $email=isset($_POST["email"])?$_POST["email"]:"";
        $passwort=isset($_POST["passwort"])?$_POST["passwort"]:"";
        if(empty($email)){
            $errors["email"]="Kein Email wurde eingegeben";
        }
    
        if(empty($passwort)){
            $errors["passwort"]="Kein passwort wurde eingegeben";
        }
    }
?>
<body class="sign-body">
<form method="post">
    <div class="sign-outter">
        <div>
            <div class="sign-logo">
                <a href="?hotel">
                  <img src="styles/fotos/Else/upper-belvedere-vienna.png"  alt="Logo" width="65px">
                </a>
                <p class="sign-logo-p">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar">
                <div class="signup-and-home">
                    <p>Sign In</p>
                </div>
                <div>
                    <?php
                        if(isset($_POST["login"])){
                            if(!isset($_SESSION["logged"])&&!isset($errors["email"])&&!isset($errors["passwort"])){
                                echo "<p class='error' style='text-align:center;'>Email oder passwort ist falsch</p>";
                            }
                        }
                    ?>
                </div>
                <input type="email" id="email" name="email" value="<?php echo $email?>"placeholder="Email:">
                <?php
                    if(isset($errors["email"])){
                        echo "<span class='error' style='text-align:center;'>".$errors["email"]."</span>";
                    }
                ?>
                <input type="password" id="passwort" name="passwort"  value="<?php echo $passwort?>" placeholder="Passwort:">
                <?php
                    if(isset($errors["passwort"])){
                        echo "<span class='error' style='text-align:center;'>".$errors["passwort"]."</span>";
                    }
                ?>
                <div class="sign-buttons">
                    <p>Haben Sie sich regestiert? <a href="?signup">Zur Registerung</a></p>
                    <div class="d-flex justify-content-between">
                        <button class="btn bg-dark text-white" type="submit" name="login" id="submit">Submit</button>
                        <a href="?hotel"><img src="styles/fotos/Else/house-solid.svg" alt="home" width="30px" title="Back to Home"></a>
                    </div>
                </div>
            </div>
    </div>
</form>
</body>