<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['id']))
    {
        header('Location: index.php');
        die();
    }
    else
    {
        $id = $_SESSION['id'];
        require_once 'connection.php';
        $sql = "SELECT * FROM `account` WHERE id=? ";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        if ($stm->rowCount()==1){
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $type = $row['chucvu'];
            
        }
        if($type=="Nhân viên"||$type=="Trưởng phòng"){
            header('Location: index.php');
             die();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thêm thông tin phòng mới</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
     $error = '';
     $name = '';
     $number = '';
     $leader = '';
     $desc = '';
 
     if (isset($_POST['tenphong']) && isset($_POST['leader']) && isset($_POST['sophong'])&& isset($_POST['mota']))
     {
         // print_r($_POST);
         $name = $_POST['tenphong'];
         $leader = $_POST['leader'];
         $number = $_POST['sophong'];
         $desc = $_POST['mota'];
 
         if (empty($name)) {
             $error = 'Hãy nhập tên phòng';
         }
         else if (empty($leader)) {
             $error = 'Hãy nhập tên Trường Phòng';
         }
         else if (empty($number)) {
             $error = 'Hãy nhập số phòng';
         }
         else if (empty($desc)) {
             $error = 'Hãy nhập mô tả của phòng';
         }
         else {
             require 'function.php';
             if (add_room($name, $desc, $leader, $number) == 1 ){
                 echo "<script type='text/javascript'>
                 $(document).ready(function(){
                 $('#exampleModal').modal('show');
                 });
                 </script>";
                 changePrivilage($leader,"Trưởng phòng");
                 changeAccountRoom($leader,$name);
             }
             else{
                 $error = add_room($name, $desc, $leader, $number);
             }
         }
     }
    ?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm phòng ban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Thêm phòng thành công.
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-light"> <a href="room.php">Quay lại</a></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container ">
        <div class="row justify-content-center ">
            <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3 bg-light">
                <button  class="btn text-primary " onclick="history.back()">Trở lại</button>
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Thêm thông tin phòng mới</h3>
                <form method="post" action="" novalidate enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="name">Tên phòng</label>
                        <input value="<?= $name?>" name="tenphong" required class="form-control" type="text"
                            placeholder="Tên phòng" id="name">
                    </div>
                    <div class="form-group">
                        <label for="leader">Trưởng phòng</label>
                        <select class="form-control" name="leader" id="leader">
                            <?php
                                require_once 'connection.php';
                                $sql = 'SELECT name FROM `account` WHERE chucvu ="Nhân viên"';
                                $stm = $dbCon->prepare($sql);
                                $stm->execute();
                                while ($row = $stm->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                            <option><?= $row['name'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Số phòng</label>
                        <input value="<?= $number?>" name="sophong" required class="form-control" type="number"
                            placeholder="Số phòng" id="price">
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả</label>
                        <textarea id="desc" name="mota" rows="4" class="form-control"
                            placeholder="Mô tả"><?= $desc ?></textarea>
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            } 
                            ob_end_flush();

                        ?>
                        <button type="submit" class="btn btn-primary px-5 mr-2">Thêm</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>

</html>