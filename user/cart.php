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

    $userID = (int)$_SESSION["user_id"];
    if(!$userID){
        header("Location: ../accounts/login.php");
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

    $cartID = 0;

    $sql = "SELECT cart_id FROM cart
            WHERE user_id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);

    $cartID = (int)$stmt->fetchColumn();

    if(!$cartID){
        $sql = "INSERT INTO cart (user_id)
                VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID]);
        $cartID = (int)$pdo->lastInsertId();
    }

    $sql = "SELECT ci.product_id, p.name, ci.quantity, p.price, (p.price*ci.quantity) AS Total
            FROM cart_item ci JOIN products p ON ci.product_id = p.product_id
            WHERE cart_id = ?
            ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cartID]);

    $items = $stmt->fetchAll();

    $total = 0;
    foreach($items as $item){
        $total += (float)$item['Total'];
    }
?>

<?php
    include("../includes/head.php");
?>

<body>

    <header>
        <?php
            $isActive = "cart";
            include("../includes/mainHeader.php"); 
        ?>
    </header>

    <main class="cartContainer">
        <h2>Your Cart</h2>
        <hr>
        <?php
            if(!$items):
        ?>
        <p><a href="category.php"><button type="submit" class="btn btn-dark">Continue shopping</button></a> </p>

        <?php
            else:
        ?>
        <form action="update_cart.php" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $cartID ?>">

        <?php
            foreach($items as $item):
                $product_id = (int)$item["product_id"];
        ?>
            <div class="cartDetails">
                <b>
                    <?php
                        echo htmlspecialchars($item["name"]);
                    ?>
                </b>
                - $<?php echo number_format($item["price"],2); ?>

                * <input type="number" name="quann[<?php echo $product_id; ?>]" min="1" value="<?php echo (int)$item["quantity"]; ?>">
            
                = $<?php echo number_format($item["Total"],2); ?>

                <button class="btn btn-dark" type="submit" name="remove"  value="<?php echo $product_id; ?>">Remove</button>
            </div>
        <?php
            endforeach;
        ?>

        <h3>
            Total: $<?php echo number_format($total,2); ?>
        </h3>

            <button class="btn btn-dark" type="submit" name="update" value="1">Update quantities</button><br><br>
        </form>

        <form action="checkout.php" method="post">
            <button class="btn btn-dark" type="submit" name="checkout" value="1">Checkout</button><br><br>
        </form>
            
        <a href="category.php"><button class="btn btn-dark">Continue Shopping</button></a>
        
        <?php
            endif;
        ?>
        <hr>
    </main>
    
<?php
    include("../includes/footer.php");
?>

</body>
</html>