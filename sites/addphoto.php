<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>news administartion</title>
</head>
<?php
    $errors=[];
    $uploadok=0;
    if (isset($_POST["changeFoto"])){
        $beitrag = isset($_POST["beitrag"])?$_POST["beitrag"]:null;
        if(empty($_FILES["foto"]["name"])){
            $errors["foto"]="Kein foto wurde gewählt";
        }
        if(empty($_POST["ueberschrift"])){
            $errors["ueberschrift"]="Kein überschrift wurde gewählt";
        }
        if(empty($_POST["beitrag"])){
            $errors["beitrag"]="Kein beitrag wurde gewählt";
        }
        if(empty($errors)){
            $info = pathinfo($_FILES["foto"]["name"]);
            //echo "Mime-Type: " . mime_content_type($_FILES["foto"]["tmp_name"]);
            if (mime_content_type($_FILES["foto"]["tmp_name"]) !== "image/jpeg") {
                $errors["imageType"]= "Nur jpeg Fotos sind erlaubt";
            }
            else{
                $filename = "./styles/fotos/news/" . uniqid() . "_img." . $info["extension"];
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $filename) === false) {
                    $errors["uploadError"]="Fehler aufgetreten";
                }
                else{
                }
            }
        }
    }
?>  
<body class="d-flex justify-content-center align-items-center">
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
                <?php
                    if(isset($errors["uploadError"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['uploadError'].'</div>';
                    }
                    if($uploadok==1){
                        echo '<div style="color:green; text-align:center;">Das Foto wurde geändert</div>';
                    }
                ?>
                <input type="text" id="ueberschrift" name="ueberschrift" placeholder="Bitte geben Sie Ihre Überschrift">
                <?php
                    if(isset($errors["ueberschrift"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['ueberschrift'].'</div>';
                    }
                ?>
                <input type="text" id="beitrag" name="beitrag" placeholder="Bitte geben Sie Ihre Beitrag">
                <?php
                    if(isset($errors["beitrag"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['beitrag'].'</div>';
                    }
                ?>
                <input type="file" name="foto" accept="image/jpeg,image/png">
                <?php
                    if(isset($errors["foto"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['foto'].'</div>';
                    }
                    if(isset($errors["imageType"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['imageType'].'</div>';
                    }
                ?>
                <button type="submit" class="btn bg-black text-white" name="changeFoto">Hochladen</button>
            </div>
        </div>
    </form>
</body>
</html>