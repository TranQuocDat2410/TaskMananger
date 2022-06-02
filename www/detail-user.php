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
	<title>Chi tiết nhân viên</title>
</head>

<body id="detail-user">
    <?php
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if (!empty($id)){
            require_once 'connection.php';
            $sql = "SELECT * FROM `account` WHERE `id` = ?";
            $stm = $dbCon->prepare($sql);
            try{
                $stm->execute(array($id));
                $row = $stm->fetch(PDO::FETCH_ASSOC);

            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
    ?>
    <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="images/<?=$row['avatar']?>" alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4><?= $row['name'] ?></h4>
                                    <p class="text-secondary mb-1"><?=$row['chucvu']?></p>
                                    <p class="text-muted font-size-sm"><?= $row['phongban'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">ID</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= $row['id'] ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= $row['email'] ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?=$row['phone']?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Địa chỉ</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= $row['diachi'] ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Ngày sinh</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= date("d/m/Y",strtotime($row['birthday'])) ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row ">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Lương</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= $row['salary'] ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-center">
                                <a class="btn btn-danger text-right mr-auto d-block ml-3 " target=""
                                    href="index.php">Quay lại</a>
                                <?php
                                     if ($_SESSION['id'] == 1){
                                         ?>
                                            <a class="btn btn-info text-right ml-auto mr-3 " target=""
                                            href="edit_user.php?id=<?=$id?>">Edit</a>         
                                         <?php
                                     }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php ob_flush();?>