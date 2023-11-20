<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Vienna Star Hotel</title>
    </head>
    <body>
        <?php
          include_once "navbar.php";
        ?>

        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="./styles/fotos/parisi-udvar-hotel-budapest-exterior-night-2.webp" class="d-block w-100" alt="Unser Hotel">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Unser Hotel</h5>
                  <p>Inmitten der Stadt erhebt sich ein modernes Hotel mit beeindruckender Architektur und exzellenter Lage für Gäste, die den urbanen Flair genießen möchten. </p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="./styles/fotos/wp11009775.jpg" class="d-block w-100" alt="Unser Lobby">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Unsere Lobby</h5>
                  <p>Die Lobby des Hotels begrüßt die Gäste mit einem einladenden und eleganten Ambiente.
                    Bequeme Sitzbereiche laden zum Entspannen und Verweilen ein, während die kunstvollen Dekorationen und das freundliche Personal eine angenehme Atmosphäre schaffen. </p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="./styles/fotos/hotel_room_2-wallpaper-1920x1080.jpg" class="d-block w-100" alt="Unsere Zimmer">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Unser Zimmer</h5>
                  <p>Die Hotelzimmer sind stilvoll und komfortabel ausgestattet, bieten modernen Komfort und sind der ideale Rückzugsort für Gäste. Einige Zimmer bieten zudem beeindruckende Ausblicke auf die Umgebung.</p>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
        </div>
        <?php
          if(empty($_SESSION["logged"])){
            echo "<div class='container my-4'>
            <div class='row'>
              <div class='col-md-4 mb-4'>
                <div class='card bg-secondary text-white'>
                  <img src='./styles/fotos/dad-hotel-h_8i38IHqEI-unsplash.jpg' class='card-img' alt='...' style='height: 32rem;'>
                  <div class='card-img-overlay d-flex justify-content-center align-items-end'>
                    <a href='?signup' class='btn bg-white text-muted'style='width: 30%;'>Sign Up</a>
                  </div>
                </div>
              </div>
              <div class='col-md-4 mb-4'>
                <div class='card text-dark'>
                  <img src='./styles/fotos/tobi-w38wBWIliw4-unsplash.jpg' class='card-img' alt='...' style='height: 32rem;'>
                  <div class='card-img-overlay d-flex justify-content-center align-items-end'>
                    <a href='?signin' class='btn bg-white text-muted' style='width: 30%;'>Sign In</a>
                  </div>
                </div>
              </div>";
          }
          else{
            echo "<div class='container my-4'>
            <div class='row'>
              <div class='col-md-4 mb-4'>
                <div class='card bg-secondary text-white'>
                  <img src='./styles/fotos/alev-takil-lw3Lqe2K7xc-unsplash.jpg' class='card-img' alt='...' style='height: 32rem;'>
                  <div class='card-img-overlay d-flex justify-content-center align-items-end'>
                    <a href='?new_reservation' class='btn bg-white text-muted'style='width: 35%;'>Neue Resvierung</a>
                  </div>
                </div>
              </div>
              <div class='col-md-4 mb-4'>
                <div class='card text-dark'>
                  <img src='./styles/fotos/behnam-norouzi-XWTrHfOoMqw-unsplash.jpg' class='card-img' alt='...' style='height: 32rem;'>
                  <div class='card-img-overlay d-flex justify-content-center align-items-end'>
                    <a href='?reserved_rooms' class='btn bg-white text-muted' style='width: 35%;'>Resvierungen</a>
                  </div>
                </div>
              </div>";
          }
        ?>
            <div class="col-md-4 mb-4">
              <div class="card bg-secondary text-white">
                <img src="./styles/fotos/jaredd-craig-HH4WBGNyltc-unsplash.jpg" class="card-img" alt="..." style="height: 32rem;">
                <div class="card-img-overlay d-flex justify-content-center align-items-end">
                  <a href="?impressum" class="btn bg-white text-muted">Impressum</a>
                </div>
              </div>
            </div>
          </div>
        </div>        
        </div>
    </body>
</html>