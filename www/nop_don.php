<?php 
    ob_start();
    function get_day($type){
        if($type=="Nhân viên"){
            return 12;
        }
        else if($type=="Trưởng phòng"){
            return 15;
        }
    }
     session_start();
     if (!isset($_SESSION['id']))
     {
         header('Location: ngay_nghi.php');
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
             $name = $row['name'];
             $type = $row['chucvu'];
             $room=$row['phongban'];
             $total=get_day($type)-$row['ngaynghi'];
             
             
         }
       
     }
     
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nộp đơn nghĩ phép</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if (isset($_POST['id']) && isset($_POST['hoten']) && isset($_POST['chucvu'])&& isset($_POST['room']) && isset($_POST['begin_day'])&& isset($_POST['total_day'])&& isset($_POST['lido']))
    {
        $id = $_POST['id'];
        $name = $_POST['hoten'];
        $type=$_POST['chucvu'];
        $room=$_POST['room'];
        $begin_day=$_POST['begin_day'];
        $total_day=$_POST['total_day'];
        $end_day=date('Y-m-d', strtotime($begin_day. ' + '.$total_day.' days'));
        $reason=$_POST['lido'];
        $status='Waiting';

        if (empty($begin_day)) {
            $error = 'Hãy nhập ngày bắt đầu nghỉ';
        }
        else if ($begin_day<=date("Y-m-d")) {
            $error = 'Hãy chọn ngày nghỉ sau ngày hiện tại.';
        }
        else if ($total_day==0) {
            $error = 'Hãy nhập số ngày nghỉ';
        }
        else if ($total_day>$total) {
            $error = 'Bạn đã nghỉ quá số ngày quy định';
        }
        else if (empty($reason)) {
            $error = 'Hãy nhập lí do nghỉ phép';
        }
        else {
            require 'connection.php';
            $sql = "INSERT INTO `nghiphep` (`ID`, `Date`, `End_day`, `Reason`, `Status`) VALUES (?, ?, ?, ?, ?);";
            $stm = $dbCon->prepare($sql);
            $stm->execute(array($id,$begin_day, $end_day,$reason,$status));
            if ($stm->rowCount()==1){
                echo "<script type='text/javascript'>
                $(document).ready(function(){
                $('#succesModal').modal('show');
                });
                </script>";
            }
            else{
                $error="lỗi";
            }
            
        }
    }
    ?>
  <!-- Modal -->
  <div class="modal fade" id="succesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Đơn được gửi thành công</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Đơn nghỉ phép đã chuyển tới ban quan lý, vui lòng đợi phản hồi.
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-light"> <a href="ngay_nghi.php">Quay lại</a></button>
                </div>
            </div>
        </div>
    </div>
 <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3 bg-light">
                <button  class="btn text-primary " onclick="history.back()">Trở lại</button>
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Đơn xin nghỉ phép</h3>
                <form method="post" action="" novalidate enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="id">ID </label>
                        <input  readonly value="<?= $id?>" name="id" required class="form-control" type="number" placeholder="ID" id="id">
                    </div>
                    <div class="form-group">
                        <label for="name">Họ và Tên</label>
                        <input  readonly value="<?= $name?>" name="hoten" required class="form-control" type="text" placeholder="Họ và Tên" id="name">
                    </div>
                    <div class="form-group">
                        <label for="chucvu">Chức vụ</label>
                        <input  readonly value="<?= $type?>" name="chucvu" required class="form-control" type="text" placeholder="Chức vụ" id="chucvu">

                    </div>
                    <div class="form-group">
                        <label for="room">Phòng ban</label>
                        <input  readonly value="<?= $room?>" name="room" required class="form-control" type="text" placeholder="Phòng ban" id="room">
                    </div>
                    <div class="form-group">
                        <label for="begin_day">Nghỉ từ ngày</label>
                        <input type="date" id="begin_day" name="begin_day">
                    </div>
                    <div class="form-group">
                        <label for="total_day">Số ngày nghỉ</label>
                        <input  name="total_day" required class="form-control" type="number" placeholder="Số ngày nghỉ" id="total_day"  min="1" max="<?= $total?>">
                    </div>
                    <div class="form-group">
                        <label for="desc">Lí do</label>
                        <textarea id="desc" name="lido" rows="4" class="form-control" placeholder="Lí do"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            ob_end_flush();
                        ?>
                        <input type="submit" class="btn btn-primary px-5 mr-2">
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>