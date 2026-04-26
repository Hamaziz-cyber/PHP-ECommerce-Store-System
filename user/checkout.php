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

    $userID = (int)($_SESSION['user_id'] ?? 0);
    if (!$userID){
        header('Location: ../accounts/login.php');
        exit();
    }

    $sql = "SELECT cart_id FROM cart
            WHERE user_id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
        
    $cartID = (int)$stmt->fetchColumn();

    if(!$cartID){
        header("Location: category.php");
        exit();
    }

    $sql = "SELECT SUM(p.price * ci.quantity) AS the_total
            FROM cart_item ci
            JOIN products p ON p.product_id = ci.product_id
            WHERE ci.cart_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cartID]);
        $total = (float)$stmt->fetchColumn();

    try{
        $pdo->beginTransaction();

        $sql = "INSERT INTO orders (user_id, total)
                VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID, $total]);

        $orderID = (int)$pdo->lastInsertId();

        // copy cart items into order_items
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                    SELECT ?, ci.product_id, ci.quantity, p.price
                    FROM cart_item ci
                    JOIN products p ON p.product_id = ci.product_id
                    WHERE ci.cart_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$orderID, $cartID]);

        $sql = "DELETE FROM cart
                WHERE cart_id = ?";
        $delet_cart = $pdo->prepare($sql);
        $delet_cart->execute([$cartID]);

        $pdo->commit();

        header("Location: order.php?order_id=" . $orderID);
        exit();
    }
    catch(Throwable $e){
        $pdo->rollBack();
        echo "Checkout Failed: " . htmlspecialchars($e->getMessage());
    }
?>