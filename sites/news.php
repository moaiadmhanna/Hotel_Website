<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>news</title>
</head>
<body>
<?php
        include_once "navbar.php";
?>
<img src="./styles/fotos/parisi-udvar-hotel-budapest-exterior-night-2.webp" class="d-block w-100" style="height:70vh;" alt="Unser Hotel">
<p class="newsP mt-5" style="text-align:center; font-family: 'Courier New', Courier, monospace; font-size: 30px; font-weight:bolder;">Unser News</p>
<div class="container mt-5 pb-5">
    <div class='row justify-content-around'>
            <?php
                foreach($newsData as $news){
                    $newsHeader=$news["newsHeader"];
                    $newsBody=$news["newsBody"];
                    $picture=$news["picture"];
                    echo "
                    <div class='card col-4' style='width: 27rem;'>
                        <img src='$picture' class='card-img' style='height:27rem;' alt='...'>
                        <div class='card-body' style='border:1px solid gray;'>
                            <h5 style='text-align:center;'>$newsHeader<h5>
                            <p class='pt-5 pr-2'>$newsBody</p>
                        </div>
                    </div>
                    ";
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>