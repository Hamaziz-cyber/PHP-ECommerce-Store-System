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
    elseif(!isset($_SESSION['user_id'])){
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

    $userID = $_SESSION['user_id'];

    $message = "";
    $success = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST["button"])){
            $username = ucfirst(strtolower($_POST["username"]));
            $useremail = strtolower(trim(filter_input(INPUT_POST, "useremail", FILTER_VALIDATE_EMAIL)));
            $feedback = $_POST["feedback"];        

            if(empty($username)){
                $message = "<h3 class='alert alert-danger'>Enter a name</h3>";
            }
            elseif(empty($_POST["useremail"])){
                $message = "<h3 class='alert alert-danger'>Enter an eamil</h3>";
            }
            elseif(empty($useremail)){
                $message = "<h3 class='alert alert-danger'>Invalid email</h3>";
            }
            elseif(empty($feedback)){
                $message = "<h3 class='alert alert-danger'>Write a feedback</h3>";
            }
            else{
                $sql = "INSERT INTO feedback (user_id, name, Email, feedback_desc)
                        VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$userID, $username, $useremail, $feedback]);

                $success = "<h3 class='alert alert-success'>Thanks for contact us</h3>";
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
            $isActive = "contact";
            include("../includes/mainHeader.php"); 
        ?>
    </header>

    <main>
         <form action="" method="post" class="EmailForm">
            <div class="feedback-box">

                <div class="input-box">
                    <input type="text" class="input-field" name="username" placeholder="Name" autocomplete="off" requierd>
                </div>

                <div class="input-box">
                    <input type="email" class="input-field" name="useremail" placeholder="Email" autocomplete="off" requierd>
                </div>

                <div class="input-box">
                    <textarea name="feedback" class="input-field" id="textarea" placeholder="Write Your Feedback"></textarea>
                </div>

                <div class="feedback_message">
                    <?php
                        if($message == "" && $success != ""):
                            echo $success;
                    ?>
                    <?php
                        elseif($message != "" && $success == ""):
                            echo $message;
                    endif;
                    ?>
                </div>

                <div>
                    <input type="submit"  class="input-button" name="button" value="confirm">
                </div>

                <div class="feedback">
                    <a href="category.php"><button type="button" class="btn btn-dark">Continue Shopping</button></a>
                </div>
        </form>
        
    </main>

<?php
    include("../includes/footer.php");
?>

</body>
</html>