<?php

    require("../database/database.php");

    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: ../accounts/login.php");
    }
    elseif($_SESSION['status'] == 'admin'){
        header("Location: ../admin/dashboard.php");
        exit();
    }
    
    $message = $_SESSION['username'];

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
?>

<?php
    include("../includes/head.php");
?>

<body>
    <header>
        <?php
            $isActive = "category";
            include("../includes/mainHeader.php"); 
        ?>
    </header>

    <main>
    <ul class="categories">

        <?php 
            $sql = "SELECT category_id, name FROM categories ORDER BY category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)):?>

            <li>
                <a href="product.php?cat=<?php echo $row["category_id"]; ?>">
                    <?php echo strtoupper($row["name"]).'s'?>
                </a>
            </li>

        <?php endwhile; ?>

    </ul>
</main>

<?php
    include("../includes/footer.php");
    
?>
</body>
</html>