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

    $userId = (int)($_SESSION['user_id'] ?? 0);
    if (!$userId){
        header('Location: ../accounts/login.php');
        exit();
    }

    $cartId = (int)($_POST['cart_id'] ?? 0);
    if ($cartId <= 0){
        header('Location: cart.php');
        exit();
    }

    // verify ownership
    $sql = "SELECT 1 FROM cart
            WHERE cart_id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cartId, $userId]);

    if(!$stmt->fetch()){
        header('Location: cart.php');
        exit();
    }

    // remove one?
    if(isset($_POST['remove'])){
        $product_id = (int)$_POST['remove'];

        $sql = "DELETE FROM cart_item
                WHERE cart_id = ? AND product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cartId, $product_id]);
        header('Location: cart.php');
        exit;
    }

    // update quantities
    $quantity = $_POST['quann'] ?? [];

    foreach($quantity as $product_id => $q){
        $product_id = (int)$product_id;
        $quan = max(1,(int)$quan);

        $sql = "UPDATE cart_item SET quantity = ? 
                WHERE cart_id = ? AND product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$q, $cartId, $product_id]);
    }

    header('Location: cart.php');
    exit;
?>