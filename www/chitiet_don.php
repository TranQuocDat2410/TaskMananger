<?php 
    ob_start();
     session_start();
     if (!isset($_SESSION['id']) || !isset($_SESSION['id_form']))
     {
         header('Location: ngay_nghi.php');
         die();
     }
     else
     {
        $id = (isset($_GET['id']))? $_GET['id'] : "";
         require_once 'connection.php';
         $sql = "SELECT * FROM `account` WHERE id=? ";
         $stm = $dbCon->prepare($sql);
         $stm->execute(array($id));
         if ($stm->rowCount()==1){
             $row = $stm->fetch(PDO::FETCH_ASSOC);
             $name = $row['name'];
             $type = $row['chucvu'];
             $room=$row['phongban'];
         }
         $id_form = (isset($_GET['id_form']))? $_GET['id_form'] : "";
         
         $sql = "SELECT * FROM `nghiphep` WHERE ID_Form=? ";
         $stm = $dbCon->prepare($sql);
         $stm->execute(array($id_form));
         if ($stm->rowCount()==1){
              $nghiphep = $stm->fetch(PDO::FETCH_ASSOC);
              $status=$nghiphep['Status'];
              $reason=$nghiphep['Reason'];
              $date=$nghiphep['Date'];
              $date1=date_create($nghiphep['Date']);
              $date2=date_create($nghiphep['End_day']);
              $total=date_diff($date1,$date2)->format('%a');
              
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
                        <input type="date-local" readonly value="<?= $date?>" id="begin_day" name="begin_day">
                    </div>
                    <div class="form-group">
                        <label for="total_day">Số ngày nghỉ</label>
                        <input  name="total_day" required  readonly value="<?= $total?>"class="form-control" type="number" placeholder="Số ngày nghỉ" id="total_day"  min="1" max="<?= $total?>">
                    </div>
                    <div class="form-group">
                        <label for="desc">Lí do</label>
                        <textarea id="desc" name="lido" rows="4"  readonly  class="form-control" placeholder="Lí do"><?= $reason?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="room"> Trạng thái</label>
                        <input  readonly value="<?= $status?>" name="status" required class="form-control" type="text" placeholder="Trạng thái" id="status">
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
<?php
ob_end_flush();
?>