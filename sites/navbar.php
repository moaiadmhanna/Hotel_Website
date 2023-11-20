<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>navbar</title>
    </head>
    <body>
        <div class="first-div">
            <nav class="navbar navbar-expand-lg bg-body-transperent">
                <div class="container-fluid">
                <a href="?hotel">
                  <img src="./styles/fotos/upper-belvedere-vienna.png"  alt="Logo" width="50px">
                </a>
                <a class="navbar-brand mx-4 mt-2 " style="font-family: serif; font-size: 30px;">Vienna Star Hotel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbar-dropdown">
                        <li class="nav-item dropdown ms-auto">
                            <a class="nav-link dropdown-toggle" style="font-family: serif; font-size: 22px;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                    if(!empty($_SESSION["logged"])){
                                        echo 
                                        "
                                        <li><a class='dropdown-item' href='?new_reservation'>Neue Reservierung</a></li>
                                        <li><a class='dropdown-item' href='?reserved_rooms'>Resvierungen</a></li>
                                        ";
                                    }
                                ?>
                                <li><a class="dropdown-item" href="?impressum">Impressum</a></li>
                                <li><a class="dropdown-item" href="?F_and_Q">F&Q</a></li>
                            </ul>
                        </li>
                    <?php
                        if(empty($_SESSION["logged"])){
                            echo "<li class='nav-item ms-auto'>
                                    <a class='nav-link active' style='font-family: serif; font-size: 22px;'' href='?signup'>Signup</a>
                                </li>";
                            echo "<li class='nav-item ms-auto'>
                                    <a class='nav-link active' style='font-family: serif; font-size: 22px;'' href='?signin'>Signin</a>
                                </li>";
                        }
                        else{
                            echo "<p class='nav-p ms-auto mt-2 mx-1' style='color:green;'>Welcome: ".$_SESSION["username"]."</p>";
                            echo "<li class='nav-item ms-auto'>
                                    <a class='nav-link active' style='font-family: serif; font-size: 22px;'' href='?userInformation'>User Information</a>
                                </li>";
                            echo "<li class='nav-item ms-auto'>
                                    <a class='nav-link active' style='font-family: serif; font-size: 22px;'' href='?logout'>Logout</a>
                                </li>";
                        }
                    ?>
                    </ul>
                </div>
                </div>
            </nav>
        </div>
    </body>
</html>