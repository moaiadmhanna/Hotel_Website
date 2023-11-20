<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
<style>
    /* Add custom styles for the scrollable content */
    .accordion-body {
        overflow-y: scroll; /* Enable vertical scrolling */
    }
</style>
</head>
<body>
    <?php
        include_once "navbar.php";
    ?>
    <?php
        $numberOfReservations=$_SESSION["reservationNumber"];
        for($i = 1; $i < $numberOfReservations; $i++){
            $zimmer = $_SESSION["reservation".$i]["zimmer"];
            $anreiseDatum = $_SESSION["reservation".$i]["anreiseDatum"];
            $abreiseDatum = $_SESSION["reservation".$i]["abreiseDatum"];
            $fruehstueck = $_SESSION["reservation".$i]["fruehstueck"];
            $parkplatz = $_SESSION["reservation".$i]["parkplatz"];
            $haustier = $_SESSION["reservation".$i]["haustier"];
            echo "
            <div class='accordion mt-5 m-2' id='accordionExample'>
                <div class='accordion-item'>
                <h2 class='accordion-header'>
                    <button class='accordion-button collapsed bg-dark text-white' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$i' aria-expanded='true' aria-controls='collapse$i'>
                        Reservation$i
                    </button>
                </h2>
                <div id='collapse$i' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                    <div class='accordion-body'>
                        <p>Zimmer : $zimmer</p>
                        <p>Anreisedatum : $anreiseDatum</p>
                        <p>Abreisedatum : $abreiseDatum</p>
                        <p>Frühstück : $fruehstueck</p>
                        <p>Parkplatz : $parkplatz</p>
                        <p>Haustier : $haustier</p>
                    </div>
                </div>
                </div>
            </div>
            ";
        }
        if($numberOfReservations==1){      
            echo "
            <div class='d-flex flex-column  align-items-center'>
                <p style='color:red;'>Sie haben kein Zimmer Reserviert</p>
                <button class='btn bg-black text-white'><a href='?new_reservation' style='color:white;'> Zur Reservierung</a></button>
            </div>
            ";
        }
    ?>
</body>
</html>