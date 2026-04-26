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

    if(empty($_POST["products"])){
        header("Location: product.php");
        exit();
    }

    //find or creat a cart

    $sql = "SELECT cart_id FROM cart
            WHERE user_id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);

    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $cartID = (int)$row["cart_id"];
    }
    else{
        $sql = "INSERT INTO cart (user_id)
                VALUES (?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID]);

        $sql = "SELECT cart_id FROM cart
            WHERE user_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $cartID = (int)$row["cart_id"];
    }

    //add products
    $products = array_map('intval', $_POST["products"]);

    $quantity = $_POST["quan"] ?? [];

    foreach($products as $product_id){
        $quan = max(1, (int)($quantity[$product_id] ?? 1));
    

        $sql = "INSERT INTO cart_item (cart_id, product_id, quantity)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cartID, $product_id, $quan]);
    }

    header("Location: category.php");
    
?>