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

    function uploadSecureImage($fileArray) {
        if ($fileArray['error'] !== UPLOAD_ERR_OK) {
            return ["status" => false, "msg" => "Error occurred during upload."];
        }

        $tmpPath = $fileArray['tmp_name'];
        $fileName = $fileArray['name'];
        $fileSize = $fileArray['size'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpPath);
        finfo_close($finfo);

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mimeType, $allowedMimeTypes)) {
            return ["status" => false, "msg" => "The uploaded file is not a valid image!"];
        }

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fileExtension, $allowedExtensions)) {
             return ["status" => false, "msg" => "Image extension is not allowed."];
        }

        if ($fileSize > (2 * 1024 * 1024)) {
            return ["status" => false, "msg" => "Image size must not exceed 2MB."];
        }

        $newFileName = uniqid('img_', true) . '.' . $fileExtension;
        
        $uploadDir = '../product photos/'; 
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpPath, $destPath)) {
            return ["status" => true, "filename" => $newFileName];
        } else {
            return ["status" => false, "msg" => "Failed to save the image on the server."];
        }
    }
?>

<?php
    include("../includes/head.php");
?>

<body>
    <header>
        <?php
            $isActive = "products";
            include("../includes/admin_mainHeader.php");
        ?>
    </header>

<main>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="edit_product_container">

            <h3>Add Product</h3>

            product name :
            <input type="text" name="pr_name" required><br>

            category name:
            <input type="text" name="cat_name" required><br>

            description:
            <textarea name="description"></textarea><br>

            price:
            <input type="text" name="price" required><br>

            image:
            <input class="btn btn" type="file" name="image_name" accept="image/*" required><br>

            <button class='btn btn-success' name="add_btn">Add</button>

        </div>
    </form>

    <div class="table2">

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST["add_btn"])){

                    $product_name = strtolower($_POST["pr_name"]);
                    $category_name = strtolower($_POST["cat_name"]);
                    $description = $_POST["description"];
                    $price = $_POST["price"];

                    $sql = "SELECT name FROM products WHERE name = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$product_name]);

                    if(empty($product_name)){
                        echo "<h3 class='alert alert-danger'>Enter Name of the Product</h3>";
                    }
                    elseif(empty($category_name)){
                        echo "<h3 class='alert alert-danger'>Enter Name of the Category</h3>";
                    }
                    elseif(empty($price)){
                        echo "<h3 class='alert alert-danger'>Enter the Price</h3>";
                    }
                    elseif(empty($_FILES["image_name"]["name"])){
                        echo "<h3 class='alert alert-danger'>Upload an image</h3>";
                    }
                    elseif($stmt->rowCount() == 1){
                        echo "<h3 class='alert alert-danger'>Product is Already exist</h3>";
                    }
                    else{
                        $sql = "SELECT * FROM categories WHERE name = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$category_name]);
                        $rows = $stmt->fetchAll();

                        $category_id = null;
                        foreach($rows as $row){
                            if($category_name == $row["name"]){
                                $category_id = $row["category_id"];
                                break;
                            }
                        }

                        if(!$category_id){
                            echo "<h3 class='alert alert-danger'>There is no category named {$_POST['cat_name']}</h3>";
                        }
                        else{
                            $uploadResult = uploadSecureImage($_FILES["image_name"]);
                            
                            if ($uploadResult['status'] == false) {
                                echo "<h3 class='alert alert-danger'>{$uploadResult['msg']}</h3>";
                            } else {
                                $image_secure_name = $uploadResult['filename'];

                                $sql = "INSERT INTO products (category_id, name, description, price, image) 
                                        VALUES (?, ?, ?, ?, ?)";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$category_id, $product_name, $description, $price, $image_secure_name]);

                                if($stmt->rowCount() == 1)
                                    echo "<h3 class='alert alert-success'>Added Successfully</h3>";
                                else
                                    echo "<h3 class='alert alert-danger'>Not Added</h3>";
                            }
                        }
                    }
                }
            }

            if(isset($_GET['action'],$_GET['id']) and intval($_GET['id']) > 0 ){

                $id = $_GET['id'];

                if($_GET['action']=='Active'){
                    $sql = "UPDATE products SET Active = 'Active' WHERE product_id = ?";
                    $stmt= $pdo->prepare($sql);
                    $stmt->execute([$id]);
                } 
                elseif($_GET['action'] == 'inActive'){
                    $sql = "UPDATE products SET Active = 'inActive' WHERE product_id = ?";
                    $stmt= $pdo->prepare($sql);
                    $stmt->execute([$id]);
                }
                elseif($_GET['action']=='delete'){
                    $sql = "DELETE FROM products WHERE product_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$id]);
                }
                elseif($_GET['action']=='edit'){
                    $sql = "SELECT * FROM products WHERE product_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$id]);
                    $pr = $stmt->fetch();
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="edit_product_container">
                <hr>
                <h3>Edit Product</h3>

                <?php if($pr): ?>
                    <input type="hidden" name="id" value="<?= $pr['product_id'] ?>">

                    product name :
                    <input type="text" name="pr_name" value="<?= htmlspecialchars($pr['name']) ?>" required><br>

                    description:
                    <textarea name="description"><?= htmlspecialchars($pr['description']) ?></textarea><br>

                    price:
                    <input type="text" name="price" value="<?= htmlspecialchars($pr['price']) ?>" required><br>

                    image:
                    <input type="file" name="image_name" accept="image/*"><br>

                    <button class='btn btn-success' type="submit" name="update">Update</button>
                <?php endif; ?>
            </div>
        </form>

        <?php
                }
            }

            if (isset($_POST['update'])) {
                $id = (int)$_POST['id'];
                $name = trim($_POST['pr_name']);
                $description = trim($_POST['description']);
                $price = trim($_POST['price']);

                if (!empty($_FILES['image_name']['name'])) {
                    
                    $uploadResult = uploadSecureImage($_FILES['image_name']);
                    
                    if ($uploadResult['status'] == true) {
                        $image_secure_name = $uploadResult['filename'];
                        
                        $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE product_id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$name, $description, $price, $image_secure_name, $id]);
                    } else {
                        die("<h3 class='alert alert-danger'>{$uploadResult['msg']}</h3><a href='edit_product.php'>Go Back</a>");
                    }

                } else {
                    $sql = "UPDATE products SET name = ?, description = ?, price = ? WHERE product_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$name, $description, $price, $id]);
                }

                header("Location: edit_product.php");
                exit();
            }
        ?>

        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $sql = "SELECT p.product_id, c.name as category_name, 
                            p.name, p.description, p.price, p.image, p.Active
                            FROM products p 
                            JOIN categories c ON p.category_id = c.category_id
                            ORDER BY product_id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    foreach($stmt->fetchAll() as $row){
                        $id = $row["product_id"];

                        echo "<tr>";
                        echo "<td>{$row['product_id']}</td>";
                        echo "<td>".strtoupper(htmlspecialchars($row['category_name']))."</td>";
                        echo "<td>".strtoupper(htmlspecialchars($row['name']))."</td>";
                        echo "<td>".htmlspecialchars($row['description'])."</td>";
                        echo "<td>$".htmlspecialchars($row['price'])."</td>";
                        
                        echo "<td>";
                        if(!empty($row['image'])){
                            echo "<img src='../product photos/{$row['image']}' alt='Product Image' style='width:50px; height:50px; object-fit:cover;'>";
                        } else {
                            echo "No Image";
                        }
                        echo "</td>";
                        
                        echo "<td>{$row['Active']}</td>";

                        echo "<td>";
                        echo "<a href='?action=edit&id=$id' class='btn btn-success'>Edit</a> ";
                        echo "<a href='?action=delete&id=$id' class='btn btn-danger'>Delete</a> ";

                        if($row['Active'] == 'Active')
                            echo "<a href='?action=inActive&id=$id' class='btn btn-warning'>InActive</a>";
                        else
                            echo "<a href='?action=Active&id=$id' class='btn btn-primary'>Active</a>";

                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

    </div>

</main>

<?php
    include("../includes/admin_footer.php");
?>

</body>
</html>