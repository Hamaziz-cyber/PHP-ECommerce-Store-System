<?php
    require("../database/database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){


        $useremail = strtolower(trim(filter_input(INPUT_POST, "useremail", FILTER_VALIDATE_EMAIL)));
        $old_pass = $_POST["old_password"];
        $new_pass = $_POST["new_password"];

        if(empty($_POST["useremail"])){
            $message = "<h3 class='alert alert-danger'>please enter an email</h3>";
        }
        elseif(empty($useremail)){
            $message = "<h3 class='alert alert-danger'>ivalid email!</h3>";
        }
        elseif(empty($old_pass)){
            $message = "<h3 class='alert alert-danger'>please enter the old password</h3>";
        }
        elseif(empty($new_pass)){
            $message = "<h3 class='alert alert-danger'>please enter the new password</h3>";
        }
        else{
            
            $sql = "SELECT  user_id, email, password FROM users
                    WHERE email = ? ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$useremail]);

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($row && password_verify($old_pass, $row["password"])){

                    $hash = password_hash($new_pass, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET password = ?
                            WHERE email = ? ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$hash, $useremail]);
                    header("Location: login.php");
                    exit();
                }
                else{
                    $message = "<h3 class='alert alert-danger'>wrong email/password</h3>";
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
            $isActive = "";
            include("../includes/loginHeader.php"); 
        ?>
    </header>

    <form action="" method="post" class="EmailForm">
            <div class="login-box">
                <p class="login-p">Reset Pssword</p>

                <div class="input-box">
                    <input type="email" class="input-field" name="useremail" placeholder="Email" autocomplete="off" requierd>
                </div>

                <div class="input-box">
                    <input type="password" class="input-field" name="old_password" placeholder="Old Password" autocomplete="off" minlength="8" maxlength="15" requierd>
                </div>

                <div class="input-box">
                    <input type="password" class="input-field" name="new_password" placeholder="New Password" autocomplete="off" minlength="8" maxlength="15" requierd>
                </div>

                <?php if(!empty($message)): ?>
                    <div class="error-message">
                    <?php echo $message ?>    
                    </div>
                <?php endif; ?>

                <div>
                    <input type="submit"  class="input-button" name="button" value="confirm">
                </div>
            </div>
        </form>

<footer>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
        <p class="navbar-nav" id="footer_text">© 2025 My Website. All rights are reservesd.</p>
    </nav>
</footer>

</body>
</html>