<?php
    require("../database/database.php");
    
    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: login.php");
    }
    elseif($_SESSION['status'] != 'admin'){
        header("Location: ../user/index.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){    
        include("../includes/logout.php");
    }

?>
<?php
    include("../includes/head.php");
?>

<body>
    <header>
        <?php
            $isActive = "dashboard";
            include("../includes/admin_mainHeader.php");
        ?>
    </header>

    <main>
        <div class="Boxcontainer">

            <div class="box1">
                <h3>Users</h3>
                <p>
                    <?php 
                        $sql = "SELECT user_id FROM users WHERE status <> 'admin'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        echo $stmt->rowCount();
                    ?>
                </p>
            </div>

            <div class="box2">
                <h3>Categories</h3>
                <p>
                    <?php 
                        $sql = "SELECT category_id FROM categories";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        echo $stmt->rowCount();
                    ?>
                </p>
            </div>

            <div class="box3">
                <h3>Products</h3>
                <p>
                    <?php 
                        $sql = "SELECT product_id FROM products";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        echo $stmt->rowCount();
                    ?>
                </p>
            </div>

        </div>
    </main>

<?php
    include("../includes/admin_footer.php");
?>
</body>
</html>