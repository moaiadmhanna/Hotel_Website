<div class="first-div">
    <nav class="navbar navbar-expand-lg bg-body-transperent">
        <div class="container-fluid">
        <a href="?hotel">
            <img src="styles/fotos/Else/upper-belvedere-vienna.png"  alt="Logo" width="50px">
        </a>
        <a class="navbar-brand mx-4 mt-2 " style="font-size: 30px;">Vienna Star Hotel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbar-dropdown">
                <li class="nav-item dropdown ms-auto">
                    <a class="nav-link dropdown-toggle" style="font-size: 22px;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Über Uns
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?news">News</a></li>
                        <li><a class="dropdown-item" href="?impressum">Impressum</a></li>
                        <li><a class="dropdown-item" href="?F_and_Q">F&Q</a></li>
                    </ul>
                </li>
                <?php
                    if (!empty($_SESSION["logged"])) {
                        echo "<li class='nav-item dropdown ms-auto'>";
                        echo "<a class='nav-link dropdown-toggle' style='font-size: 22px; color:green;' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>Welcome " . $_SESSION["username"] . "</a>";
                        echo "<ul class='dropdown-menu'>";
                        if($_SESSION["email"] == "admin@gmail.com"){
                            echo "<li><a class='dropdown-item' href='?manage_users'>Benutzern verwalten</a></li>";
                            echo "<li><a class='dropdown-item' href='?manage_reservations'>Resvierungen verwalten</a></li>";
                        }
                        else{
                            echo "<li><a class='dropdown-item' href='?rooms'>Unsere Zimmern</a></li>";
                            echo "<li><a class='dropdown-item' href='?reserved_rooms'>Resvierungen</a></li>";
                        }
                        echo "<li><a class='dropdown-item' href='?userInformation'>User Information</a></li>";
                        echo "</ul>";
                        echo "</li>";
                    }
                ?>
            <?php
                if(empty($_SESSION["logged"])){
                    echo "<li class='nav-item ms-auto'>
                            <a class='nav-link active' style='font-size: 22px;' href='?signup'>Signup</a>
                        </li>";
                    echo "<li class='nav-item ms-auto'>
                            <a class='nav-link active' style='font-size: 22px;' href='?signin'>Signin</a>
                        </li>";
                }
                else{
                    echo "<li class='nav-item ms-auto'>
                            <a class='nav-link active' style='font-size: 22px;' href='?logout'>Logout</a>
                        </li>";
                }
            ?>
            </ul>
        </div>
        </div>
    </nav>
</div>