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
	<title>Home Page</title>
</head>
<body>
    <?php


        require 'function.php';
        require 'connection.php';
        if (isset($_GET['submit'])){
            $id = $_GET['id'];
            $username = getUsernameById($id);
            $passwordHash = password_hash($username,PASSWORD_DEFAULT);

            $sql = "UPDATE `account` SET `password` = ?, `activated` = b'0' WHERE `account`.`id` = ?";
            $stm = $dbCon->prepare($sql);
            $stm->execute(array($passwordHash,$id));
            header("Location: notification.php?type=21");
            // echo $stm->rowCount();

        }
        
    ?>
    <div class="container">
        <div class="row">
            <div class="bg-white col-md-6 mt-5 mx-auto p-3 border rounded">
                <h4 class="mb-5">Bạn có chắc muốn đổi mật khẩu nhân viên <?=getNameById($_GET['id'])?>?</h4>
                <a href="resetpassword.php?id=<?=$_GET['id']?>&submit" class="btn btn-danger mr-3">Có</a>
                <a href="list-user.php" class="btn btn-success">Quay lại</a>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->

</body>
</html>