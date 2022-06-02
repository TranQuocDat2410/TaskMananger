<?php
    session_start();
	if (!isset($_SESSION['id'])){
		header('Location: login.php');
	}
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
	<title>Details task</title>
</head>

<body>
    <?php
        require 'function.php';
        $sender = getNameById($_SESSION['id']);
        $submit_task_error = "";

        if (isset($_POST['submit-task'])){
            if (isset($_FILES['file'])){
                $file_name = !empty($_FILES['file']['name'])? $_FILES['file']['name'] : "";
                $file_size = !empty($_FILES['file']['size'])? $_FILES['file']['size'] : "";
                $file_tmp = !empty($_FILES['file']['tmp_name'])? $_FILES['file']['tmp_name'] : "";
                $file_type= !empty($_FILES['file']['type'])? $_FILES['file']['type'] : "";   
            }
            if (!empty($file_name)){
                move_uploaded_file($file_tmp,"task/".$file_name);
            }
            $desc = !empty($_POST['desc'])? $_POST['desc'] : "";
            
            if(empty($desc)){
                $submit_task_error="Nhập ghi chú";
            }
            else{
                $time = getCurrentTime();
                submitTask($_GET['id'],$desc,$file_name,$time,$sender);
                setStatusTask($_GET['id'],"Waiting");
            }
        }

        if (isset($_POST['reject-task'])){
            $reject_desc = (empty($_POST['desc']))? "Nhập lý do" : "";
            if (empty($reject_desc)){
                //success
                setStatusTask($_GET['id'],"Reject");
                if (isset($_FILES['file'])){
                    $file_name = !empty($_FILES['file']['name'])? $_FILES['file']['name'] : "";
                    $file_size = !empty($_FILES['file']['size'])? $_FILES['file']['size'] : "";
                    $file_tmp = !empty($_FILES['file']['tmp_name'])? $_FILES['file']['tmp_name'] : "";
                    $file_type= !empty($_FILES['file']['type'])? $_FILES['file']['type'] : "";   
                }
                if (!empty($file_name)){
                    move_uploaded_file($file_tmp,"task/".$file_name);
                }
                $time = getCurrentTime();
                submitTask($_GET['id'],$_POST['desc'],$file_name,$time,$sender);
                setDeadlineTask($_GET['id'],$_POST['deadline']);
                header("Location: notification.php");
            }
        }

        $currentUser = getNameById($_SESSION['id']) ;


    ?>
    <div class="container mt-3">
        <div class="main-body">
            <div class="row">
                <div class="col-md-5 mb-3 px-3">
                    <div class="container bg-white">
                        <div class="d-flex justify-content-center pt-3">
                            <img src="images/pattern.png" width="100" height="100" class="" alt="">
                        </div>
                        <h3 class="text-center py-2">Chi tiết công việc</h3>
                        <?php
                    
                            $task = getDetailTask($_GET['id']);
                        ?>
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold ">Tên công việc</div>
                            <div class="col-6"><?= $task['name'] ?></div>
                        </div>
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold">Người giao</div>
                            <div class="col-6"><?= $task['truongphong'] ?></div>
                        </div>
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold">Nhân viên</div>
                            <div class="col-6"><?= $task['nhanvien'] ?></div>
                        </div>
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold">Deadline</div>
                            <div class="col-6"><?= date("d/m/Y",strtotime($task['deadline'])) ?></div>
                        </div>
                       
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold">Mô tả</div>
                            <div class="col-6 w-100" style="word-break: break-word"><?= $task['description']?></div>
                        </div>
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold">Trạng thái</div>
                            <div class="col-6"><?= $task['status'] ?></div>
                        </div>
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold">Đánh giá</div>
                            <div class="col-6"><?= $task['rating'] ?></div>
                        </div>
                        <div class="row pb-3">
                            <div class="pl-5 text-left col-6 font-weight-bold">File đính kèm</div>
                            <div class="col-6"> <a href="task/<?=$task['file_description']?>" download >  <?= $task['file_description'] ?></a></div>
                        </div>
                        <?php
                            $type = $currentUser==$task['truongphong']? "leader":"employee" ;
                            renderOption($type,$task['status']);  
                        ?>
                        

                    </div>
                    
                </div>

                <div class="col-md-7">
                    <?php
                        if ($task['status']!="New" && $task['status']!="Completed" && $task['status']!="Canceled" && $currentUser==$task['nhanvien']){
                            ?>
                                <div class="row bg-white mb-3 justify-content-center px-3 ">
                                    <div class="col-12 text-center py-3 font-weight-bold h3">Nộp kết quả</div>
                                    <form method="post" action="" class="w-100 pb-3" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <textarea name="desc" id="desc" rows="3" class="form-control" placeholder="Nhập ghi chú"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input name="file" type="file" class="custom-file-input" id="customFile" accept="image/gif, image/jpeg, image/png, image/bmp">
                                                <label class="custom-file-label" for="customFile">File đính kèm</label>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <?php
                                                if (!empty($submit_task_error)) {
                                                    echo "<div class='alert alert-danger'>$submit_task_error</div>";
                                                }
                                            ?>
                                        </div>
                                        <button name="submit-task" type="submit" class="btn btn-success">Nộp</button>
                                    </form>
                                </div>
                            <?php
                        }
                        // echo $task['status'];
                        if (isset($_GET['status'])){
                            if ($_GET['status']=="reject"){
                                ?>
                                    <div class="row bg-white mb-3 justify-content-center px-3 ">
                                        <div class="col-12 text-center py-3 font-weight-bold h3">Lý do từ chối</div>
                                        <form method="post" action="" class="w-100 pb-3" enctype="multipart/form-data">
                                            
                                            <div class="form-group">
                                                <textarea name="desc" id="desc" rows="3" class="form-control" placeholder="Nhập lý do"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input name="file" type="file" class="custom-file-input" id="customFile" accept="image/gif, image/jpeg, image/png, image/bmp">
                                                    <label class="custom-file-label" for="customFile">File đính kèm</label>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="deadline">Gia hạn deadline</label>
                                                <input value="<?=$task['deadline']?>" name="deadline" class="form-control" type="date" placeholder="" id="deadline">
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    if (!empty($reject_desc)) {
                                                        echo "<div class='alert alert-danger'>$reject_desc</div>";
                                                    }
                                                ?>
                                            </div>
                                            <button name="reject-task" type="submit" class="btn btn-success">Nộp</button>
                                        </form>
                                    </div>
                                <?php
                            }

                            

                            if ($_GET['status']=="cancel"){
                                header("Location: notification.php?type=warning-cacel-task");
                            }
                        }
                        
                    ?>
                    

                    <div class=" bg-white pb-1 row text-center border-bottom">
                        <div class="col-md-12 font-weight-bold mb-3 pt-2 h3">Lịch sử công việc</div>
                        <div class="font-weight-bold col-md-3">From</div>
                        <div class="font-weight-bold col-md-3">Ghi chú</div>
                        <div class="font-weight-bold col-md-3">File đính kèm</div>
                        <div class="font-weight-bold col-md-3">Cập nhật vào</div>
                    </div>
                    <?php
                        $taskHistory = getTaskHistory($_GET['id']);
                        foreach ($taskHistory as $task){
                            ?>
                                <div class=" py-2 bg-white row text-center border-bottom">
                                    <div class="col-md-3"><?=$task['sender']?></div>
                                    <div class="col-md-3"style="word-break: break-word"><?=$task['description']?></div>
                                    <div class="col-md-3"> <a href="task/<?=$task['attach']?>" download><?=$task['attach']?></a></div>
                                    <div class="col-md-3"><?php echo date("H:i d/m/Y",strtotime($task['time']))?></div>
                                </div>        
                            <?php
                        }
                    ?>
                    
                    <div class="row justify-content-star bg-white px-3 py-3">
                        <a href="index.php" class="btn btn-danger">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->

</body>

</html>
<?php ob_flush();?>