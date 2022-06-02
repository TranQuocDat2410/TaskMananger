<?php
    session_start();
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

        $name="";
        $employee= "";
        $deadline = "";
        $desc = "";
        $file_name="";
        $error = "";

        if (isset($_FILES['file'])){
            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            move_uploaded_file($file_tmp,"task/".$file_name);

        }

        if (isset($_POST['submit'])){
            $leader = getNameById($_GET['id']);
            $name = $_POST['name'];
            $status = "New";
            $deadline = $_POST['deadline'];
            $desc = $_POST['description'];
            $star = date('y-m-d');
            $employee = $_POST['employee'];
            if(empty($name)){
                $error = "Nhập tên công việc";
            }
            else if (empty($deadline)){
                $error = "Nhập deadline";
            }
            else if (empty($desc)){
                $error = "Nhập mô tả";
            }
            else if ( strtotime($deadline) < strtotime($star) ){
                $error = "Deadline không hợp lệ";
            }  
            else{
                require 'connection.php';
                $sql = "INSERT INTO `tasks` (`name`, `status`, `deadline`, `start`, `truongphong`, `nhanvien`, `rating`, `description`, `file_description`) VALUES (?,?,?,?,?,?,?,?,?)";
                $stm = $dbCon->prepare($sql);
                $stm->execute(array($name, $status, $deadline, $star, $leader, $employee, "Chưa hoàn thành", $desc, $file_name));
                if ($stm->rowCount()==1){
                    header("Location: notification.php?type=1");
                }            
            }
        }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div style="background-color: white" class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4">
                <h3 class="text-secondary text-center mt-2 mb-3">Tạo Công Việc Mới</h3>
                <form action="" method="post" novalidate enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Tên công việc</label>
                        <input value="" name="name" required class="form-control" type="text" placeholder="Tên công việc" id="name">
                    </div>
                    <div class="form-group">
                        <label for="employee">Nhân viên</label>
                        <select class="form-control" name="employee" id="employee">
                            <?php
                                require 'connection.php';
                                $room = getRoomById($_GET['id']);
                                $sql = "SELECT * FROM `account` WHERE phongban=? AND chucvu=?" ;
                                $stm = $dbCon->prepare($sql);
                                $stm->execute(array($room,"Nhân viên"));
                                while($row = $stm->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                        <option value="<?=$row['name']?>"><?=$row['name']?></option>        
                                    <?php
                                }
                                if ($_GET['id']==1){
                                    $leaders = getAllLeaderName();
                                    foreach($leaders as $leader){
                                        ?>
                                            <option value="<?=$leader['name']?>"><?=$leader['name']?></option>        
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input value="" name="deadline" required class="form-control" type="date" placeholder="Deadline" id="deadline">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea name="description" id="description" cols="30" rows="8" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="file" accept="">
                            <label class="custom-file-label" for="file">Tệp đính kèm</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="index.php" class="btn btn-danger mr-auto">Quay lại</a>
                        <button name="submit" type="submit" class="btn btn-primary px-3 ml-auto">Thêm</button>
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
<?php
    ob_flush();
?>