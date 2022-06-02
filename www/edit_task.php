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

		$currentTask = getDetailTask($_GET['id']);
        if (isset($_POST['submit'])){
            $name = $_POST['name'];
            $deadline = $_POST['deadline'];
            $desc = $_POST['description'];
            $star = date('y-m-d');
            $employee = $_POST['employee'];
			$id = $_POST['id'];
			print_r($file_name);
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
                $sql = "UPDATE `tasks` SET `name` = ?, `deadline` = ?, `nhanvien`=?, `description`=?, `file_description`=? WHERE `tasks`.`id` = ?";
                $stm = $dbCon->prepare($sql);
                $stm->execute(array($name, $deadline, $employee, $desc, $file_name,$id));
                if ($stm->rowCount()==1){
                    header("Location: notification.php?type=2");
                }    
				else{
					$error = "Không có gì để cập nhật";
				}        
            }
        }
    ?>

	<div class="container">
        <div class="row justify-content-center">
            <div style="background-color: white" class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4">
                <h3 class="text-secondary text-center mt-2 mb-3">Cập nhật công việc</h3>
                <form action="" method="post" novalidate enctype="multipart/form-data">
					<div class="form-group">
                        <label for="id">ID</label>
                        <input readonly value="<?=$currentTask['id']?>" name="id" required class="form-control" type="text" id="id">
                    </div>
                    <div class="form-group">
                        <label for="name">Tên công việc</label>
                        <input value="<?=$currentTask['name']?>" name="name" required class="form-control" type="text" id="name">
                    </div>
                    <div class="form-group">
                        <label for="employee">Nhân viên</label>
                        <select class="form-control" name="employee" id="employee">
                            <?php

								$employees = getEmployees($_SESSION['id']);
								foreach($employees as $row){
									?>
                                        <option value="<?=$row['name']?>"><?=$row['name']?></option>        
                                    <?php
								}
								
                                if ($_SESSION['id']==1){
									?>
										<option value="<?=$currentTask['nhanvien']?>"><?=$currentTask['nhanvien']?></option>
									<?php
                                    $leaders = getAllLeaderName();
                                    foreach($leaders as $leader){
										if ($leader['name']!=$currentTask['nhanvien']){
											?>
												<option value="<?=$leader['name']?>"><?=$leader['name']?></option>        
											<?php
										}
                                        
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input value="<?=$currentTask['deadline']?>" name="deadline" required class="form-control" type="date" placeholder="Deadline" id="deadline">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea name="description" id="description" cols="30" rows="8" class="form-control"><?= $currentTask['description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="file" value="" accept="">
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
                        <button name="submit" type="submit" class="btn btn-primary px-3 ml-auto">Cập nhật</button>
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