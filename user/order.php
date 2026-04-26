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

    $userId  = (int)($_SESSION['user_id'] ?? 0);
    $orderId = (int)($_GET['order_id'] ?? 0);
    if (!$userId || !$orderId){
        header('Location: categories.php');
        exit;
    }

    $sql = "SELECT total, order_date 
            FROM orders 
            WHERE order_id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$orderId, $userId]);
    $order = $stmt->fetch();

?>
<?php
    include("../includes/head.php");
?>

<body class="orderContainer">

    <header>
        <?php
            $isActive = "";
            include("../includes/mainHeader.php"); 
        ?>
    </header>

    <main class="order_container">
        <?php if (!$order): ?>
        <h2>Order not found.</h2>
        <a href="categories.php"><button type="submit" class="btn btn-dark">Back to shop</button></a>
        <?php else: ?>

        <h3 class='alert alert-success'>Thanks! Your order has been placed.</h3>

        <p>Date: <?php echo htmlspecialchars($order['order_date']); ?></p>

        <p>Total paid: $<?php echo number_format((float)$order['total'], 2); ?></p>

        <a href="category.php"><button type="submit" class="btn btn-dark">Continue shopping</button></a>

        <?php endif; ?>
        <hr>
    </main>
    
<?php
    include("../includes/footer.php");
?>

</body>
</html>