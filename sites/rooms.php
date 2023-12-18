<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation</title>
</head>
<body>
    <?php
        include_once "navbar.php";
    ?>
</body>
<div class="container my-5" style="gap:20px;">
    <div class="row d-flex justify-content-center">
<?php
    $sql = "SELECT * FROM zimmer";
    $result = $db->query($sql);
        while($row=$result->fetch_assoc()){
            if($row["verfuegber"]>0){
                $zimmerId = $row['zimmerid'];
                echo"
                <div class='col-12 col-md-6 col-lg-4'>
                <div class='card text-white'>
                    <img src='./styles/fotos/rooms/".$row['name'].".jpg' class='card-img' alt='...' style='height: 32rem;'>
                    <div class='card-img-overlay d-flex flex-column justify-content-end align-items-center' style='gap:10px;'>
                        <div>
                            <div class='collapse-verticale collapse' id='collapseWidthExample_$zimmerId' style='overflow: auto; max-height: 425px;'>
                                <div class='card card-body' id='collapsediv'>
                                    <h5>".$row['name']."</h5>
                                    <p>".$row['beschreibung']."</p>
                                    <h6>Größe: ".$row['groesse']." m2</h6>
                                    <h6>Preis: ".$row['preis']." Euro pro Nacht</h6>
                                    <h6>
                                        <a href='?new_reservation=".$row["name"]."' style='font-size:15px;'>Zur Reservierung</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <p>
                            <a class='btn' type='button' data-bs-toggle='collapse' data-bs-target='#collapseWidthExample_$zimmerId' aria-expanded='false' aria-controls='collapseWidthExample_$zimmerId'>
                                Mehr Erfahren
                            </a>
                        </p>
                    </div>
                </div>
            </div>
                ";
            }
        }
?>
    </div>
</div>
</html>