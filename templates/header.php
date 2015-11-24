<?php
session_start();

if(empty($_SESSION['id'])){
    ?>

    <div class = "landing">
        <form class = "loginBox">
            <h2>Login</h2>
            <div class = "loginInputBox">
                <input class = "loginInput userInputField form-control" id = "username" name = "username">
            </div>
            <div class = "loginInputBox">
                <input class = "loginInput userInputField form-control" type = "password" id = "password" name = "password">
            </div>
            <button class = "btn loginBtn">Login</button>

            <p>Don't have an account yet?</p>
            <button class = "btn registerOpen">Register Here</button>
        </form>

        <form class = "registerBox">
            <h2>Register</h2>
            <div class = "registerInputBox">
                <input class = "registerInput userInputField form-control" id = "firstName" name = "firstName">
            </div>
            <div class = "registerInputBox">
                <input class = "registerInput userInputField form-control" id = "lastName" name = "lastName">
            </div>
            <div class = "registerInputBox">
                <input class = "registerInput userInputField form-control" id = "regEmail" name = "regEmail">
            </div>
            <div class = "registerInputBox">
                <input class = "registerInput userInputField form-control" id = "regUsername" name = "regUsername">
            </div>
            <div class = "registerInputBox">
                <input class = "registerInput userInputField form-control" type = "password" id = "regPassword" name = "regPassword">
            </div>
            <div class = "registerInputBox">
                <input type = "checkbox" id="worker">Worker Bee
            </div>
            <div class = "registerInputBox">
                <input class = "registerInput userInputField form-control" id = "regCity" name = "regCity">
            </div>
            <button class = "btn cancelRegister">Cancel</button>
            <button class = "btn register">Proceed</button>
        </form>

    </div>

    <?php
} else {
    ?>

    <!-- Insert existing session content here -->
    <header class = "header">
        <div class = "logo col-xs-4 col-md-2">
            <!--<img class = "menuLogo" src="./iconFiles/logo.png">-->
        </div>
        <div class = "navBar hidden-xs hidden-sm col-md-10 col-lg-9">
            <ul class = "mainMenu regularMenu text-center col-xs-12">
                <li data-toggle="tooltip" data-placement = "bottom" title="Search with address or city/state/zip" class = "navItem" page-link = "shop.php">SHOP</li>
                <?php
                if($_SESSION['worker'] == 1) {
                    ?>
                    <li data-toggle="tooltip" data-placement="bottom"
                        title="Revisit your last search result, if available" class="navItem" page-link="work.php">WORK
                    </li>
                    <?php
                }
                ?>
                <li data-toggle="tooltip" data-placement = "bottom" title="Your profile shows your watchlist and owned properties if you added any" class = "navItem" page-link = "profile.php">YOUR PROFILE</li>
                <li id="logout">LOGOUT</li>
            </ul>
        </div>
        <div class = "mobileNav dropdown col-xs-12 hidden-md hidden-lg">
            <div class = "logo mobileLogo col-xs-7"></div>
            <div id = "dropdown1" class = "btn btn-default dropdown-toggle glyphicon glyphicon-menu-hamburger" type = "button" data-toggle = "dropdown" aria-haspopup = "true"
                 aria-expanded = "false"></div>
            <ul class = "mainMenu mobileMenu dropdown-menu col-xs-12" aria-labelledby="dropdown1">
                <li class = "navItem mobileNavItem text-center" page-link = "shop.php">SHOP</li>
                <?php
                if($_SESSION['worker'] == 1) {
                    ?>
                    <li class="navItem mobileNavItem text-center" page-link="work.php">WORK</li>
                    <?php
                }
                ?>
                <li class = "navItem mobileNavItem text-center" page-link = "profile.php">YOUR PROFILE</li>
                <li class = "navItem mobileNavItem text-center" id="logoutMobile">LOGOUT</li>
            </ul>
        </div>
    </header>

    <?php
}
    ?>



