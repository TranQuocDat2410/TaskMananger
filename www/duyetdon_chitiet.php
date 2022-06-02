<?php
 $id =(isset($_GET['id']))? $_GET['id'] : "";
 require_once 'connection.php';
     $sql = "SELECT * FROM `account` WHERE id=? ";
     $stm = $dbCon->prepare($sql);
     $stm->execute(array($id));
     if ($stm->rowCount()==1){
         $row = $stm->fetch(PDO::FETCH_ASSOC);
         $name = $row['name'];
         $type = $row['chucvu'];
         $room=$row['phongban'];
         $total=$row['ngaynghi'];
     }
     if($type=="Nhân viên"||$type=="Trưởng phòng"){
         header('Location: index.php');
          die();
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
        function sum($radio,$total,$total_day){
            if ($radio=="Approved"){
                return $total_day+$total;
            }
            else{
                return $total_day;
            }
        }    
         $id =(isset($_GET['idnv']))? $_GET['idnv'] : "";
         require_once 'connection.php';
         $sql = "SELECT * FROM `account` WHERE id=? ";
         $stm = $dbCon->prepare($sql);
         $stm->execute(array($id));
         if ($stm->rowCount()==1){
             $row = $stm->fetch(PDO::FETCH_ASSOC);
             $name = $row['name'];
             $type = $row['chucvu'];
             $room=$row['phongban'];
             $day_before=$row['ngaynghi'];;
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
         ////////////////////
         if (isset($_POST['radio'])&&isset($_POST['confirm']))
         {
             $radio=$_POST['radio'];

             $sum=sum($radio,$total,$day_before);
             echo $radio.', '.$sum;
             require 'connection.php';
             $sql = "UPDATE `nghiphep`,`account` SET nghiphep.Status=?, account.ngaynghi=? WHERE nghiphep.ID=account.id and account.id=? and nghiphep.ID_Form=?;";
             $stm = $dbCon->prepare($sql);
             $stm->execute(array($radio,$sum,$id,$id_form));
             if($stm->rowCount()>0){
                echo "<script type='text/javascript'>
                $(document).ready(function(){
                $('#ConfirmModal').modal('show');
                });
                </script>";
                
            } 
         }
         else if (isset($_POST['radio'])&&!isset($_POST['confirm'])){
            $error = 'Vui lòng xác thực trước khi cập nhật.';
         }
         else if (!isset($_POST['radio'])&&isset($_POST['confirm'])){
            $error = 'Vui lòng chọn trạng thái mới của đơn.';
         }
         //////////////
?>
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
                        <label for="ID_Form">ID_Form</label>
                        <input  readonly value="<?= $id_form?>" name="ID_Form" required class="form-control" type="text" placeholder="ID_Form" id="ID_Form">
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
                    <div class="form ">
                        <label class=" h5 font-weight-bolder "> Duyệt đơn</label>
                    </div>
                    <div class="form-group">

                        <input type="radio" name="radio" value="Approved" >Approved

                        <input type="radio" name="radio" value="Refused">Refused

                    </div>
                    <div class="form-group">

                    <input type="checkbox" name="confirm" value="Confirm" >Tôi xác nhận .

                    </div>
                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-primary px-5 mr-2 update">Cập Nhật</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<!-- Succed Confirm Modal -->
<div id="ConfirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <hp class="modal-title">ĐƠN NGHỈ PHÉP</hp>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="delete_room.php" method="POST">
                    <div class="modal-body">
                        <p>Đã cập nhật đơn của <?php echo $name ;?> trạng thái <?php echo $radio;?>.</p>
                        <p>Trân trọng ./.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"> <a href="duyet_don.php">Quay lại</a></button>
                    </div>
                </form>
                

            </div>

        </div>
    </div>
 
</body>

</html>