<?php
    require("../database/database.php");

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $useremail = strtolower(trim(filter_input(INPUT_POST, "useremail", FILTER_VALIDATE_EMAIL)));
        $password = $_POST["password"];

        if(empty($_POST["useremail"])){
            $message = "<h3 class='alert alert-danger'>please enter an email</h3>";
        }
        elseif(empty($useremail)){
            $message = "<h3 class='alert alert-danger'>ivalid email!</h3>";
        }
        elseif(empty($password)){
            $message = "<h3 class='alert alert-danger'>please enter a password</h3>";
        }
        else{
            
            $sql = "SELECT  username, user_id, email, password, status FROM users
                    WHERE email = ? ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$useremail]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($row && password_verify($password, $row["password"])){
                    
                    if($row['status'] == 'admin'){
                        $_SESSION['email'] = $useremail;
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['status'] = $row['status'];
                        header("Location: ../admin/dashboard.php");
                        exit();
                    }
                    else{
                        $_SESSION['email'] = $useremail;
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['status'] = $row['status'];
                        header("Location: ../user/index.php");
                        exit();
                    }
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
            $isActive = "log_in";
            include("../includes/loginHeader.php"); 
        ?>
    </header>

    <main>
        <form action="" method="post" class="EmailForm">
            <div class="login-box">
                <p class="login-p">Log in</p>

                <div class="input-box">
                    <input type="email" class="input-field" name="useremail" placeholder="Email" autocomplete="off" requierd>
                </div>

                <div class="input-box">
                    <input type="password" class="input-field" name="password" placeholder="Password" autocomplete="off" minlength="8" maxlength="15" requierd>
                </div>

                <?php if(!empty($message)): ?>
                    <div class="error-message">
                        <?php echo $message ?>    
                    </div>
                <?php endif; ?>

                <div class="forget">
                    <a href="reset.php">reset password</a>
                </div>

                <div>
                    <input type="submit"  class="input-button" name="button" value="Sign In">
                </div>

                <div class="sign-up-link">
                    <p>Don't have account? <a href="SignUp.php">Sign up</a></p>
                </div>
            </div>
        </form>
    </main>

<footer>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
        <p class="navbar-nav" id="footer_text">© 2025 My Website. All rights are reservesd.</p>
    </nav>
</footer>

</body>
</html>