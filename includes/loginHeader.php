<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <img src="../photos/Logo.png" alt="logo" id="logo">

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav align-items-center">

            <li class="nav-item">
                <a class="nav-link" href="../user/index.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../user/category.php">categories</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "log_in") echo 'active';?>" 
                   href="<?php if($isActive == "log_in") echo '#'; else echo 'login.php';?>">
                   Log in
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "sign_up") echo 'active';?>" 
                   href="<?php if($isActive == "sign_up") echo '#'; else echo 'SignUp.php';?>">
                   Sign Up
                </a>
            </li>

        </ul>
    </div>
</nav>