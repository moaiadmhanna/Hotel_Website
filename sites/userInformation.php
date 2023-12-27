<style>
    .avatar {
        vertical-align: middle;
        width:12vw;
        border-radius: 50%;
    }
</style>
<?php
    $errors = [];
    if(isset($_POST['BenutzerdatenAndern'])){
        $benutzerid = get_user();
        if(isset($_POST['passwort'])){
            $sql = "SELECT passwort FROM benutzer WHERE benutzerid = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('s',$benutzerid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if(password_verify($_POST["altepasswort"],$row["passwort"])){
                $sql = "UPDATE benutzer SET passwort = ? WHERE benutzerid = ?";
                $hashedpasswort = password_hash($_POST['passwort'], PASSWORD_DEFAULT);
                $stmt = $db->prepare($sql);
                $stmt->bind_param('ss',$hashedpasswort,$benutzerid);
                $stmt->execute();
            }
            else{
                $errors['passwort'] = 'Das Passwort stimmt nicht ein';
            }
        }
        if(isset($_POST['vorname'])){
            $sql = "UPDATE benutzer SET vorname = ? WHERE benutzerid = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ss',$_POST['vorname'],$benutzerid);
            $stmt->execute();
            $_SESSION['vorname'] = $_POST['vorname'];
        }
        if(isset($_POST['nachname'])){
            $sql = "UPDATE benutzer SET nachname = ? WHERE benutzerid = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ss',$_POST['nachname'],$benutzerid);
            $stmt->execute();
            $_SESSION['nachname'] = $_POST['nachname'];
        }
        if(isset($_POST['username'])){
            $sql = "UPDATE benutzer SET username = ? WHERE benutzerid = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ss',$_POST['username'],$benutzerid);
            $stmt->execute();
            $_SESSION['username'] = $_POST['username'];
        }
        if(isset($_POST['email'])){
            $sql = "SELECT email FROM benutzer WHERE email = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('s',$_POST['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if(mysqli_num_rows($result) <= 0){
                $sql = "UPDATE benutzer SET email = ? WHERE benutzerid = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param('ss',$_POST['email'],$benutzerid);
                $stmt->execute();
                $_SESSION['email'] = $_POST['email'];
            }
            else{
                $errors['email'] = 'Die Email ist bereits benutzt';
            }
        }
    }
?>
<div class="userInformatinCard d-flex justify-content-center align-items-center" style="gap:5vw;">
    <div class="d-flex flex-column mt-5 align-items-center">
        <img src="styles\fotos\Else\360_F_353110097_nbpmfn9iHlxef4EDIhXB1tdTD0lcWhG9.jpg" alt="profil" class="avatar">
        <div class="py-4 text-center">
                <h5><?php echo "{$_SESSION['vorname']}  {$_SESSION['nachname']}"; ?></h5>
                <a href="mailto:<?php echo $_SESSION['email']?>"><p><?php echo $_SESSION['email']?></p></a>
        </div>
    </div>
    <form method="post">
        <div class="InformationCard">
            <div class="d-flex justify-content-center">
                <p class="fw-bolder fs-4 text-center">Konto Verwalten</p>
            </div>
            <div class="userInformation p-3 fs-5">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-bold">Vorname:</p>
                        <div class=" inputfield d-flex align-items-center mb-3">
                            <input type='text' class="input-group flex-nowrap" id='vorname' name='vorname' required disabled value='<?php echo $_SESSION['vorname'] ?>'>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' onclick="toggleHiddenAttribute('vorname')">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <p class="fw-bold">Nachname:</p>
                        <div class=" inputfield d-flex align-items-center mb-3">
                            <input type='text' class="input-group flex-nowrap" id='nachname' name='nachname' required disabled value='<?php echo $_SESSION['nachname'] ?>'>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' onclick="toggleHiddenAttribute('nachname')">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-bold">Username:</p>
                        <div class=" inputfield d-flex align-items-center mb-3">
                            <input type='text' class="input-group flex-nowrap" id='username' name='username'  required disabled value='<?php echo $_SESSION['username'] ?>'>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' onclick="toggleHiddenAttribute('username')">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <p class="fw-bold">Email:</p>
                        <div class=" inputfield d-flex align-items-center mb-3">
                            <input type='text' class="input-group flex-nowrap" id='email' name='email'  required disabled value='<?php echo $_SESSION['email'] ?>'>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' <?php if($_SESSION['email']!=='admin@gmail.com'){ echo "onclick=\"toggleHiddenAttribute('email')\"";}?>>
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                        </div>
                        <?php
                            if(isset($errors["email"])){
                                echo "<span class='error' style='text-align:center;'>".$errors["email"]."</span>";
                            }
                        ?>
                    </div>
                </div>
                <div>
                    <div class="d-flex mb-3">
                            <p class="fw-bold m-0" id="password">Passwort:</p>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' onclick="toggleHiddenAttribute('passwort')">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                    </div>
                    <input type='password' class="input-group flex-nowrap mb-3" id='altepasswort' name='altepasswort' hidden disabled  required value='' placeholder="Altes Passwort">
                    <input type='password' class="input-group flex-nowrap mb-3" id='passwort' name='passwort' hidden disabled required  value=''placeholder="Neues Passwort">
                    <?php
                        if(isset($errors["passwort"])){
                            echo "<span class='error' style='text-align:center;'>".$errors["passwort"]."</span>";
                        }
                    ?>
                </div>
                <button class='btn bg-dark text-white'  disabled type='submit' name='BenutzerdatenAndern' id='Submit'>Submit</button>
            </div>
        </div>
    </form>
</div>
<script>
    var editingState = {
        vorname: false,
        nachname: false,
        username: false,
        email: false,
        passwort: false
    };
    function toggleHiddenAttribute(fieldname) {
        var input = document.getElementById(fieldname);
        var oldpassword = document.getElementById('altepasswort');
        var submitButton = document.getElementById('Submit');
        if (fieldname == 'passwort') {
            input.hidden = !input.hidden;
            input.disabled = !input.disabled;
            oldpassword.hidden = !oldpassword.hidden
            oldpassword.disabled = !oldpassword.disabled;
        } else {
            input.disabled = !input.disabled;
        }
        editingState[fieldname] = !editingState[fieldname];
        var anyFieldEditing = Object.values(editingState).some(state => state);

        // Enable or disable the submit button based on whether any input field is currently being edited
        submitButton.disabled = !anyFieldEditing;
    }
</script>