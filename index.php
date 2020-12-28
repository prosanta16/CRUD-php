<?php

    session_start();

    //insert database

    $host = 'localhost';
    $db = "crud_php";
    $user = "root";
    $password = "";

    $conn = mysqli_connect($host,$user,$password,$db);



    if(isset($_REQUEST['createUser'])){

        $name = mysqli_real_escape_string($conn,$_REQUEST['name']);
        $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
        $phone = mysqli_real_escape_string($conn,$_REQUEST['phone']);


        // image file
        $imageName = $_FILES['image']['tmp_name'];

        // image upload
        $uploadDir = 'userImages/';
        $targetFile = $uploadDir.$_FILES['image']['name'];

        move_uploaded_file($imageName,$targetFile);


        $createQuery = "INSERT INTO user(`name`,`email`,`phone`,`image`) VALUES ('$name','$email','$phone','$targetFile')";
        mysqli_query($conn,$createQuery);
        $_SESSION['msg']="Saved it";
    }
    //retrive from database
    

?>
<?php 
$query ="SELECT * FROM user";
$results=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- style -->
        
        <title>PHP CRUD</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
        <body>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="msg">
                    <?php 
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif ?>
                <table style="padding:10px;width: 50%;margin: 30px auto;border-collapse: collapse;text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid #cbcbcb;">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Image</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($results)) { ?>

                            <tr style="border-bottom: 1px solid #cbcbcb;">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><img src="<?php echo "userImages/".$row['image'];?>" width="100px" alt="Image"></td>
                                <td>
                                    <a href="#" class="btn btn-info">Edit</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                    </tbody>
                    
                    
                </table>

            <form

            <!-- users table section start -->
            <section class="user-table" style="padding:20px;">
                <table border="1">

                </table>
        </section>
        <!-- users table section End -->

        <!-- create user section start -->

        <section class="create-user" style="border:2px solid blue;width:20%;padding:50px;background:#669999;">
            <form action="<?= $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name">
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>

                <div class="input-group">
                    <label for="phone">Phone No.</label>
                    <input type="text" name="phone" id="phone">
                </div>

                <div class="input-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image">
                </div>
                <input type="submit" name="createUser" value="Create">
            </form>
        </section>
        <!-- create user section end -->

        <!-- edit user section start -->
        <section class="create-user">

        </section>
        <!-- edit user section end -->

        </body>
</html>
