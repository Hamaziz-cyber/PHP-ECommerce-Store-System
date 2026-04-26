<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <img src="../photos/Logo.png" alt="logo" id="logo">

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav align-items-center">

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "home") echo 'active';?>" 
                   href="<?php if($isActive == "home") echo '#'; else echo 'index.php';?>">
                   Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "category") echo 'active';?>" 
                   href="<?php if($isActive == "category") echo '#'; else echo 'category.php';?>">
                   categories
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "cart") echo 'active';?>" 
                   href="<?php if($isActive == "cart") echo '#'; else echo 'cart.php';?>">
                   cart
                </a>
            </li>

            <li class="nav-item">
                <form action="" method="post">
                    <button type="submit" class="btn btn-link nav-link" name="logout">Logout</button>
                </form>
            </li>

            <li class="nav-item">
                <a class="<?php if ($isActive == "profile") echo 'active';?>" 
                   href="<?php if($isActive == "profile") echo '#'; else echo 'profile.php';?>">
                    <img id="profile" src="../photos/profile.png" alt="profile">
                </a>
            </li>

        </ul>

        <h2 id="name"><?php echo $_SESSION["username"] ?></h2>
    </div>

    <form class="form-inline" action="" method="post">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" name="searchBox">
        <button class="btn btn-outline-light" type="submit" name="searchButton">Search</button>
    </form>
</nav>