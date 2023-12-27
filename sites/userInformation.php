<style>
    .avatar {
        vertical-align: middle;
        width:12vw;
        border-radius: 50%;
    }
</style>
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
                            <input type='text' class="input-group flex-nowrap" id='vorname' name='vorname' disabled value='<?php echo $_SESSION['vorname'] ?>'>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' onclick="toggleHiddenAttribute('vorname')">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <p class="fw-bold">nachname:</p>
                        <div class=" inputfield d-flex align-items-center mb-3">
                            <input type='text' class="input-group flex-nowrap" id='nachname' name='nachname' disabled value='<?php echo $_SESSION['nachname'] ?>'>
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
                        <p class="fw-bold">username:</p>
                        <div class=" inputfield d-flex align-items-center mb-3">
                            <input type='text' class="input-group flex-nowrap" id='username' name='username' disabled value='<?php echo $_SESSION['username'] ?>'>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' onclick="toggleHiddenAttribute('username')">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <p class="fw-bold">email:</p>
                        <div class=" inputfield d-flex align-items-center mb-3">
                            <input type='text' class="input-group flex-nowrap" id='email' name='email' disabled value='<?php echo $_SESSION['email'] ?>'>
                            <button type='button' class='btn btn-primary' style='background: none; border: none;' onclick="toggleHiddenAttribute('email')">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M 19.171875 2 C 18.448125 2 17.724375 2.275625 17.171875 2.828125 L 16 4 L 20 8 L 21.171875 6.828125 C 22.275875 5.724125 22.275875 3.933125 21.171875 2.828125 C 20.619375 2.275625 19.895625 2 19.171875 2 z M 14.5 5.5 L 3 17 L 3 21 L 7 21 L 18.5 9.5 L 14.5 5.5 z"></path>
                            </svg>
                            </button>
                        </div>
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
                    <input type='altepasswort' class="input-group flex-nowrap mb-3" id='altepasswort' name='passwort' hidden value=''>
                    <input type='passwort' class="input-group flex-nowrap mb-3" id='passwort' name='passwort' hidden value=''>
                </div>
                <button class='btn bg-dark text-white'  disabled type='submit' name='changeInformation' id='Submit'>Submit</button>
            </div>
        </div>
    </form>
</div>
<script>
    function toggleHiddenAttribute(fieldname) {
        var input = document.getElementById(fieldname);
        var submitButton = document.getElementById('Submit');

        submitButton.disabled = !submitButton.disabled;

        if (fieldname == 'passwort') {
            input.hidden = !input.hidden;
        } else {
            input.disabled = !input.disabled;
        }
    }
</script>