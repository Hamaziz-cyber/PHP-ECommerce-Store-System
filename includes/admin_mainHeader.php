<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <img src="../photos/Logo.png" alt="logo" id="logo">

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav align-items-center">

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "dashboard") echo 'active';?>" 
                   href="<?php if($isActive == "dashboard") echo '#'; else echo 'dashboard.php';?>">
                   Statistics
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "category") echo 'active';?>" 
                   href="<?php if($isActive == "category") echo '#'; else echo 'edit_category.php';?>">
                   categories
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "products") echo 'active';?>" 
                   href="<?php if($isActive == "products") echo '#'; else echo 'edit_product.php';?>">
                   Products
                </a>
            </li>

            <li class="nav-item">
                <form action="" method="post">
                    <button type="submit" class="btn btn-link nav-link" name="logout">Logout</button>
                </form>
            </li>

            <li class="nav-item">
                <a href="admin_profile.php">
                    <img id="profile" src="../photos/profile.png" alt="profile">
                </a>
            </li>

        </ul>

        <h2 id="name"><?php echo $_SESSION["username"] ?></h2>
    </div>
</nav>