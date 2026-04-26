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
            $isActive = "home";
            include("../includes/mainHeader.php"); 
        ?>
    </header>

    <main class="products">
        <?php
            $sql = "SELECT product_id, category_id, name, price, image 
                    FROM products 
                    ORDER BY RAND() 
                    LIMIT 10";
            $stmt = $pdo->query($sql);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($products as $p): ?>
            
            <div class="product">
                <a href="product.php?cat=<?php echo (int)$p['category_id'] ?>">

                    <img src="../product photos/<?php echo htmlspecialchars($p['image']) ?>" 
                        alt="<?php echo htmlspecialchars($p['name']) ?>">

                    <p><?php echo htmlspecialchars($p['name']) ?></p>

                    <p class="price">
                        $<?php echo number_format($p['price'], 2) ?>
                    </p>

                </a>
            </div>

        <?php endforeach; ?>
    </main>

<?php
    include("../includes/footer.php");
?>

</body>
</html>
