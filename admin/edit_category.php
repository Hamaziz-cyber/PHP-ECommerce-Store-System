<?php
    require("../database/database.php");
    
    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: login.php");
    }
    elseif($_SESSION['status'] != 'admin'){
        header("Location: ../user/index.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){    
        include("../includes/logout.php");
    }

?>

<?php
    include("../includes/head.php");
?>

<body>
    <header>
        <?php
            $isActive = "category";
            include("../includes/admin_mainHeader.php");
        ?>
    </header>

    <main class="table1">

        <h2>Add Category:</h2>
        <form action="" method="post">
            <input type="text" name="add_cat">

            <button class='btn btn-success' name="add_btn">Add</button><hr>
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST["add_btn"])){

                    $sql = "SELECT name FROM categories
                            WHERE name = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$_POST["add_cat"]]);

                    if(empty($_POST["add_cat"])){
                        echo "<h3 class='alert alert-danger'>Enter Name of Category</h3>";
                    }
                    elseif($stmt->rowCount() == 1){
                        echo "<h3 class='alert alert-danger'>Category is Already exist</h3>";
                    }
                    else{
                        $sql = "INSERT INTO categories (name) 
                                VALUES (?)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$_POST["add_cat"]]);

                        if($stmt->rowCount() == 1)
                            echo "<h3 class='alert alert-success'>Added</h3>";
                        else
                            echo "<h3 class='alert alert-danger'>Not Added</h3>";
                    }
                }
            }
            if(isset($_GET['action'] , $_GET['id']) and intval($_GET['id']) > 0 ){
                if($_GET['action']=='delete'){

                    $sql = "DELETE FROM categories
                    WHERE category_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$_GET['id']]);
                }
                elseif($_GET['action']=='edit'){
                    $cat = null;

                    $sql = "SELECT category_id, name FROM categories
                            WHERE category_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$_GET['id']]);

                    $cat = $stmt->fetch();
                    ?>
                <form action="" method="post">
                    <div class="edit_product_container">
                        <hr>
                        <p>Edit</p>
                        <?php if($cat): ?>
                            <input type="hidden" name="id" value="<?= $cat['category_id'] ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>" required>
                            <button class='btn btn-success' type="submit" name="update">Update</button>
                        <?php endif; ?>
                    </div>
                </form>
        <?php
                }
            }

            if (isset($_POST['update'])) {
                $id   = (int)$_POST['id'];
                $name = trim($_POST['name']);

                $sql = "UPDATE categories SET
                        name = ? WHERE category_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $id]);
                header("Location: edit_category.php");
                exit();
            }
        ?>

        

        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Category_Id</th>
                    <th>Category_name</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $sql = "SELECT * FROM categories ORDER BY category_id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    if($stmt->rowCount() > 0){
                        $rows = $stmt->fetchAll();
                        foreach($rows as $row){
                            $id = $row["category_id"];
                            $name = strtoupper($row["name"]);
                            
                            echo "<tr>";
                                echo "<td>$id</td>";
                                echo "<td>$name</td>";

                                echo "<td>";
                                    echo "<a href='?action=edit&id=$id'  class='btn btn-success'><h3>Edit</h3></a> ";
                                    echo "<a href='?action=delete&id=$id' class='btn btn-danger'><h3>Delete</h3></a> ";
                                echo "</td>";

                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </main>

<?php
    include("../includes/admin_footer.php");
?>

</body>
</html>