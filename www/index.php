<?php
	session_start();
	if (!isset($_SESSION['id'])){
		header('Location: login.php');
	}
	else{
		$id = $_SESSION['id'];
		require_once 'connection.php';
		$sql = "SELECT * FROM `account` WHERE id=? ";
		$stm = $dbCon->prepare($sql);
		$stm->execute(array($id));
		if ($stm->rowCount()==1){
			$row = $stm->fetch(PDO::FETCH_ASSOC);
			$name = $row['name'];
			$type = $row['chucvu'];
			$avatar = $row['avatar']; 
		}
	}
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
	?>

	<div class=" container media bg-success">
		<div class="media-left mr-3 py-3">
			<img src="./images/<?=$avatar?>" class="media-object"
				style="width:150px; height: 170px; border-radius: 10px">
		</div>
		<div class="media-body py-3">
			<h3><a id="namenv" style=" text-decoration: none " href="detail-user.php?id=<?=$id?>"
					class="media-heading"><?=$name?></a></h3>
			<h5 id="type"><?=$type?></h5>
			<a href="logout.php" class="me-auto btn-logout btn btn-danger">Log Out</a>
			<?php require_once 'privilage.php';?>
		</div>
	</div>

	<div class="container mt-3 p-0">
        <div class="row">
            <div class="col-12 col-md-3">
                <ul class=" list-group status-task">
					<?php
						if ($type == "Trưởng phòng" || $type == "Giám đốc"){
							?>
								<a class="task-list" href="index.php?review_task">
									<li  class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Duyệt công việc  
										<span style="color:white" class="bg-danger badge bg-primary rounded-pill"><?= countNumberReviewTask($name)!=0?countNumberReviewTask($name):"" ?></span>
									</li>
								</a>		
							<?php
						}
						if ($type == "Giám đốc"){
							?>
								<a href="index.php?filter=completed"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Completed
										<span style="color:white" class="bg-success badge rounded-pill"><?=countTaskCompletd($name)!=0?countTaskCompletd($name):""?></span>
									</li>
								</a>
								<a href="index.php?filter=cancled"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Cancled
										<span style="color:white" class="bg-danger badge bg-primary rounded-pill"><?=countTaskCanceled($name)!=0?countTaskCanceled($name):""?></span>
									</li>
								</a>
							<?php
						}
						else{
							?>
								<a class="task-list" href="index.php?filter">
									<li  class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Tasks  
										<span style="color:white" class="bg-danger badge bg-primary rounded-pill"><?=countToDoList($name)!=0?countToDoList($name):""?></span>
									</li>
								</a>
								<a href="index.php?filter=new"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">New
										<span style="color:white" class="bg-danger badge bg-primary rounded-pill"><?=countNumberTask($name,"New")!=0?countNumberTask($name,"New"):""?></span>
									</li>	
								</a>
								<a href="index.php?filter=progress"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">In
										progress
										<span style="color:white" class="bg-danger badge bg-primary rounded-pill"><?=countNumberTask($name,"In progress")!=0?countNumberTask($name,"In progress"):""?></span>
									</li>	
								</a>
								<a href="index.php?filter=cancled"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Cancled
										<span style="color:white" class="bg-danger badge bg-primary rounded-pill"><?=countTaskCanceled($name)!=0?countTaskCanceled($name):""?></span>
									</li>
								</a>
								<a href="index.php?filter=waiting"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Waiting
										<span style="color:white" class="bg-warning badge bg-primary rounded-pill"><?=countNumberTask($name,"Waiting")!=0?countNumberTask($name,"Waiting"):""?></span>
									</li>
								</a>
								<a href="index.php?filter=reject"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Rejected
										<span style="color:white" class="bg-danger badge bg-primary rounded-pill"><?=countNumberTask($name,"Reject")!=0?countNumberTask($name,"Reject"):""?></span>
									</li>
								</a>
								<a href="index.php?filter=completed"class="task-list">
									<li class="st mb-1 border list-group-item d-flex justify-content-between align-items-center ">Completed
										<span style="color:white" class="bg-success badge rounded-pill"><?=countTaskCompletd($name)!=0?countTaskCompletd($name):""?></span>
									</li>
								</a>
							<?php
						}
					?>


					    
                </ul>
            </div>

            
            <div  class="col-12 col-md-9 tasks-list">
                <?php
                    if (isset($_GET['review_task'])){
						$reviewtask = getReviewTask($name);
                        foreach ($reviewtask as $row){
                            ?>
                                <a id="cv" style="text-decoration:none; color: black" href="detail_task.php?id=<?=$row['id']?>" class="">
                                    <div style="background-color: white;" class="col-12 border py-3 px-5 fs-5 mb-3 task-item">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <p class="fw-bold"><?= $row['name'] ?></p>
                                            </div>
                                            <div class="col-4">
                                                <p class=""><?= $row['status'] ?></p>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-end"><?= date("d/m/Y",strtotime($row['deadline'])) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php
                        }
					}
					else{
                        $taskfilter = (isset($_GET['filter']))? $_GET['filter'] : "";
                        switch ($taskfilter){
                            case "new":
                                renderTask($name,"New");
                                break;
                            case "progress":
                                renderTask($name,"In progress");
                                break;
                            case "cancled":
                                renderTaskCanceled($name);
                                break;
                            case "waiting":
                                renderTask($name,"Waiting");
                                break;
                            case "reject":
                                renderTask($name,"Reject");
                                break;
                            case "completed":
								renderTaskCompleted($name);
                                break;
                            default:
                                getTaskList($name);
                                break;    
                        }
                    }  
                       
                ?>
                               
            </div>
        </div>
    </div>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>