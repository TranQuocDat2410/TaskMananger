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
	<title>Xác nhận hủy công việc</title>
</head>

<body>
    <?php
        require 'function.php';
        if(isset($_GET['true'])){
            setStatusTask($_GET['id'],"Canceled");
            header("Location: index.php");
        }
    ?>
    <div class="container">
        <div class="row">
            <div class="bg-light col-md-6 mt-5 mx-auto p-3 border rounded">
                <h4 class="mb-5">Bạn có chắc muốn hủy công việc <?= getTaskNameById($_GET['id']) ?>?</h4>
                <a href="confirm_cancel_task.php?id=<?=$_GET['id']?>&true" class="btn btn-danger mr-3">Có</a>
                <a href="index.php" class="btn btn-success">Không</a>
            </div>
        </div>
    </div>
</body>

</html>
<?php ob_flush();?>