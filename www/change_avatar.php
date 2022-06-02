<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Change avatar</title>
</head>

<body style="background-color: aquamarine">
<?php
    $avatar = isset($_FILES['avatar'])? $_FILES['avatar']:"";
    if(isset($_FILES['avatar'])){
        
        $id = isset($_GET['id'])? $_GET['id'] : "";
        $errors= '';
        $file_name = $_FILES['avatar']['name'];
        $file_size =$_FILES['avatar']['size'];
        $file_tmp =$_FILES['avatar']['tmp_name'];
        $file_type=$_FILES['avatar']['type'];
    

        $tmp = explode('.', $_FILES['avatar']['name']);
        $file_ext = end($tmp);

        $extensions= array("jpeg","jpg","png","JPEG","JPG");
        if(in_array($file_ext,$extensions)=== false){
            $errors ="extension not allowed, please choose a JPEG or PNG file.";
        }
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"images/".$file_name);
            require_once 'connection.php';
            $sql = "UPDATE `account` SET `avatar` = ? WHERE `account`.`id` = ?";
            $stm = $dbCon->prepare($sql);
            try{
                
                $stm->execute(array($file_name,$id));
                header("Location: notification.php");

            }
            catch(Exception $e){
                $error = "Lỗi";
            }
         }else{

         }
    }
    
?>
    <div class="container">
        <div class="row justify-content-center">
            <div style="background-color: white" class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3">
                <a href="index.php" class="btn btn-danger mr-auto">Quay lại</a>
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Đổi Avatar</h3>
                <form method="post" novalidate enctype="multipart/form-data">
            
                    <div class="form-group mb-3 custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="avatar">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                   
                    <div class="form-group">
                        <?php
                            if (!empty($errors)) {
                                echo "<div class='alert alert-danger'>$errors</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-primary px-5 mr-2">Đổi</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>
</html>
<?php ob_flush(); ?>

