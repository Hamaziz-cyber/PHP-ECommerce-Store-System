<?php
    require("../database/database.php");

    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: ../accounts/login.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include("../includes/logout.php");

        if(isset($_POST["searchButton"])){
            $search = strtolower($_POST["searchBox"]);

            $sql = "SELECT * FROM categories
                    WHERE name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$search]);

            if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                header('Location: product.php?cat='.$row["category_id"].'');
            }
            else{
                echo "<h3 class='alert alert-danger'>Not Found</h3>";
            }
        }
            
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
            $isActive = "profile";
            include("../includes/mainHeader.php"); 
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
    include("../includes/footer.php");
?>

</body>
</html>