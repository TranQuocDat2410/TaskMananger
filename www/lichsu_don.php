<?php
    ob_start();
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
                $total=$row['ngaynghi'];
            }
       }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nộp đơn nghĩ phép</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body id="duyetdon">
    <!-- style="text-align: center; font-weight: bold; font-size: 30px" -->
    <h2 class="font-weight-bold text-center pt-3" >DANH SÁCH CÁC ĐƠN ĐÃ NỘP</h2>
    <div class="container pt-3">
        <div>
            <p class="pl-3 pr-3 font-weight-bold text-primary" >Xin chào :<?=$name?></p>
            <p class="pb-3 pl-3 pr-3 font-weight-bold text-primary">Phòng :<?=$room?></p>
        </div>
    <table cellpadding="10" cellspacing="10" border="0" class="table-bordered table-hover m-auto bg-light" >
            <tr class="header font-weight-bold text-center bg-primary text-light">
                <td>ID</td>
                <td>Họ và Tên</td>
                <td>Chức vụ</td>
                <td>Phòng bạn</td>
                <td>Ngày Nghỉ</td>
                <td>Lí do</td>
                <td>Trạng thái</td>
                <td>Chi tiết</td>
        </thead>
        <?php
            require_once 'connection.php';
            $sql = "SELECT * FROM `nghiphep` WHERE ID=? ORDER BY Date DESC ";
            $stm = $dbCon->prepare($sql);
            $stm->execute(array($id));
            if ($stm->rowCount()>0){
                while ($nghiphep = $stm->fetch(PDO::FETCH_ASSOC)){
                    $id_form=$nghiphep['ID_Form'];
                    $status=$nghiphep['Status'];
                    $reason=$nghiphep['Reason'];
                    $date=$nghiphep['Date'];
                    $_SESSION['id_form'] = $id_form;
                    echo'<tr class="item">';
                    echo'<td>'.$id.'</td>';
                    echo'<td>'.$name.'</td>';
                    echo'<td>'.$type.'</td>';
                    echo' <td>'.$room.'</td>';
                    echo' <td>'.$date.'</td>';
                    echo' <td>'.$reason.'</td>';
                    echo' <td>'.$status.'</td>';
                    echo '<td><button type="button" class="btn btn-light"> <a href="chitiet_don.php?id='.$id.'&id_form='.$id_form.'">Chi tiết</a></button></td>';
                    echo' </tr>';
                }
                
            }
            else{
                echo" Bạn chưa có đơn nào trong lịch sử.";
            }
            ob_end_flush();
        ?>
       
        </table>
        
        <div>
            <button type="button" class="btn btn-light mt-1 ml-3 float-right "> <a href="ngay_nghi.php">Trở lại</a></button>
        </div>
    
     </div>
  
    
</body>
</html>