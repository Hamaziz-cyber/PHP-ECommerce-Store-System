<?php
    require("../database/database.php");

    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: login.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include("../includes/logout.php");
            
    }

    $user = $_SESSION['email'];

    $sql = "SELECT * FROM users WHERE email = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php
    include("../includes/head.php");
?>

<body class="profile_container">

    <header>
        <?php
            $isActive = "admin_profile";
            include("../includes/admin_mainHeader.php"); 
        ?>
    </header>


    <main>
        <div class="details_profile_container">
            <p>name: <?php echo $row['username'] ?></p>
            <p>email: <?php echo $row['email'] ?></p>
            <p>password: ********</p>
            <p><a href="../accounts/reset.php"><button class="btn btn-dark">Change Password</button></a></p>
        </div>
    </main>

<?php
    include("../includes/admin_footer.php");
?>

</body>
</html>