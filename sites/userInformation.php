<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UserInformation</title>
    </head>
    <body>
        <?php
          include_once "navbar.php";
        ?>
        <form method='post'>
            <div class="p-4">
                <h5 style="padding-left:6vw; padding-bottom:3vh;">User Information:</h5>
                <div class="row_information d-flex justify-content-around p-2">
                    <div class="card">
                        <div class="card-body" style="width:30vw;">
                            <h5 class="card-title">Email:</h5>
                            <p class="card-text"><?php echo $_SESSION["email"]?></p>
                            <?php
                                if($changeInformation == true){
                                    echo
                                    "<input type='email' id='email' name='email' class='form-control'>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" style="width:30vw;">
                            <h5 class="card-title">Vorname:</h5>
                            <p class="card-text"><?php echo $_SESSION["vorname"]?></p>
                            <?php
                                if($changeInformation == true){
                                    echo
                                    "<input type='vorname' id='vorname' name='vorname' class='form-control'>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row_information d-flex justify-content-around p-2">
                    <div class="card">
                        <div class="card-body" style="width:30vw;">
                            <h5 class="card-title">Nachname:</h5>
                            <p class="card-text"><?php echo $_SESSION["nachname"]?></p>
                            <?php
                                if($changeInformation == true){
                                    echo
                                    "<input type='nachname' id='nachname' name='nachname' class='form-control'>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" style="width:30vw;">
                            <h5 class="card-title">Username:</h5>
                            <p class="card-text"><?php echo $_SESSION["username"]?></p>
                            <?php
                                if($changeInformation == true){
                                    echo
                                    "<input type='username' id='username' name='username' class='form-control'>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                if($changeInformation == true){
                    echo "
                    <div class='row_information d-flex justify-content-around p-2'>
                        <div class='card'>
                            <div class='card-body' style='width:30vw'>
                                <h5 class='card-title'>Password:</h5>
                                <input type='password' id='password' name='password' class='form-control'>
                            </div>
                        </div>
                    </div>
                    ";
                }
                ?>
                <?php
                    if($changeInformation==false){
                        echo  "<button class='btn bg-dark text-white' style='margin-left:6vw;'><a href='?changeInformation' style='color:white;'>Information ändern</a></button>";
                    }
                    else{
                        echo "<button class='btn bg-dark text-white' type='submit' style='margin-left:6vw;' name='changeInformation' id='Submit'>Submit</button>";
                    }
                ?>
            </div>
        </form>
    </body>
</html>