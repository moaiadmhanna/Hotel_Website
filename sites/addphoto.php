<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>news administartion</title>
</head>
<?php
    $errors=[];
    $foto;
    if (isset($_POST["addFoto"])){
        $foto = isset($_POST["foto"])?$_POST["foto"]:null;
        if(empty($_POST["foto"])){
            $errors["foto"]="Kein foto wurde gewählt";
        }
    }
?>  
<body class="d-flex justify-content-center align-items-center">
    <form method="post">
    <form enctype="multipart/form-data" method="post">
        <div class="sign-outter">
            <div class="sign-logo">
                <a href="?hotel" class="d-flex align-items-center">
                    <img src="./styles/fotos/upper-belvedere-vienna.png" class="sign-logo-img" width="65px" alt="Logo">
                </a>
                <p class="sign-logo-p mt-4" style="font-size: 30px;">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar" style="gap:5px;">
                <h5 style="text-align:center;">Foto Hochladen</h5>
                <input type="file" name="picture" accept="image/jpeg,image/png" name="foto">
                <?php
                    if(isset($errors["beitrag"])){
                        echo '<div style="color:red;">'.$errors['beitrag'].'</div>';
                    }
                ?>
                <button type="submit" class="btn bg-black text-white" name="addFoto">Hochladen</button>
            </div>
        </div>
    </form>
</body>
</html>