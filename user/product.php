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

    $category_id = (int)($_GET["cat"] ?? 0);
    if($category_id <= 0){
        header("Location: category.php");
    }

    $sql = "SELECT name FROM categories
            WHERE category_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id]);

    $row_name = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT product_id, name, description, price, image
            FROM products
            WHERE category_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id]);

?>
<?php
    include("../includes/head.php");
?>

<body>

    <header>
        <?php
            $isActive = "";
            include("../includes/mainHeader.php"); 
        ?>
    </header>

    <h2>
        <?php 
            echo htmlspecialchars(strtoupper($row_name["name"]))."s<br>";
        ?>
        <hr>
    </h2>

    <form action="add_t_cart.php" method="post">

    <div class="products">

    <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            $product_id = (int)($row["product_id"]);
    ?>

        <div class="product">

            <img src="../product photos/<?php echo $row["image"];?>" alt="img">

            <h3><?php echo $row["name"]; ?></h3>

            <p><?php echo $row["description"]; ?></p>

            <p class="price">$<?php echo $row["price"]; ?></p>

            <input type="number" name="quan[<?php echo $product_id; ?>]" value="1" min="1">

            <input type="checkbox" name="products[]" value="<?php echo $product_id ?>">

        </div>

    <?php endwhile; ?>

    </div>

    <br>

    <button type="submit" class="btn btn-primary">Add to cart</button>

    </form>

    <hr>
<?php
    include("../includes/footer.php");
?>

</body>
</html>