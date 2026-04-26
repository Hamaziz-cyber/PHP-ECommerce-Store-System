<?php
    require("../database/database.php");


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = ucfirst(strtolower($_POST["username"]));
        $useremail = strtolower(trim(filter_input(INPUT_POST, "useremail", FILTER_VALIDATE_EMAIL)));
        $password = $_POST["password"];

        $message = "";

        if(empty($username)){
            $message = "<h3 class='alert alert-danger'>please enter a name</h3>";
        }
        elseif(empty($_POST["useremail"])){
            $message = "<h3 class='alert alert-danger'>please enter an email</h3>";
        }
        elseif(empty($useremail)){
            $message = "<h3 class='alert alert-danger'>ivalid email!</h3>";
        }
        elseif(empty($password)){
            $message = "<h3 class='alert alert-danger'>please enter a password</h3>";
        }
        else{

            $sql = "SELECT COUNT(*) FROM users WHERE email = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$useremail]);
            
            $exists = (bool)$stmt->fetchColumn();
            if($exists){
                 $message = "<h3 class='alert alert-danger'>This email is taken</h3>";
                exit();
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, email, password)
                     VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $useremail, $hash]);
            $message = "<h3 class='alert alert-success'>Email is created</h3>";
        }
    }
?>

<?php
    include("../includes/head.php");
?>

<body>
    <header>
        <?php
            $isActive = "sign_up";
            include("../includes/loginHeader.php"); 
        ?>
    </header>

    <main>
        <form action="" method="post" class="EmailForm">
            <div class="login-box">
                <p class="login-p">Sign Up</p>

                <div class="input-box">
                    <input type="text" class="input-field" name="username" placeholder="username" autocomplete="off" minlength="3" maxlength="15" requierd>
                </div>

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

                <div>
                    <input type="submit"  class="input-button" name="button" value="Sign Up">
                </div>

                <div class="sign-up-link">
                    <p>Already have an account? <a href="login.php">log in</a></p>
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