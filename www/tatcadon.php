<?php
    ob_start();
        session_start();
        if (!isset($_SESSION['id']))
        {
            header('Location: duyet_don.php');
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
    <title>Trang chủ - Danh sách phòng ban</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body id="duyetdon">
    <h2 class="font-weight-bold text-center pt-3" >DANH SÁCH CÁC ĐƠN ĐÃ NỘP</h2>
    <div class="container pt-3">
    <div>
        <p class="pl-3 pr-3 font-weight-bold text-primary">Xin chào :<?=$name?></p>
        <p class="pb-3 pl-3 pr-3 font-weight-bold text-primary">Phòng :<?=$room?></p>
    </div>
   <table cellpadding="10" cellspacing="10" border="0" class="table-bordered table-hover m-auto bg-light">
        <tr class="header font-weight-bold text-center bg-primary text-light">
            <td>ID</td>
            <td>Họ và Tên</td>
            <td>Chức vụ</td>
            <td>Giới tính</td>
            <td>Phòng ban</td>
            <td>ID_Form</td>
            <td>Ngày Nghỉ</td>
            <td>Số ngày</td>
            <td>Lí do</td>
            <td>Trạng thái</td>
            <td>Chi tiết</td>
        </tr>
    <?php
        if($type=="Giám đốc"){
            require_once 'connection.php';
            $sql = "SELECT account.id,account.name,account.gender,account.chucvu,account.phongban,nghiphep.ID_Form,nghiphep.Date,nghiphep.End_day,nghiphep.Reason,nghiphep.Status FROM `account`,`nghiphep` WHERE nghiphep.ID=account.ID and account.chucvu=?  ORDER BY nghiphep.ID_Form DESC;";
            $stm = $dbCon->prepare($sql);
            $stm->execute(array("Trưởng phòng"));
            if ($stm->rowCount()>0){
                while ($nghiphep = $stm->fetch(PDO::FETCH_ASSOC)){
                    $id_nv=$nghiphep['id'];
                    $name_nv=$nghiphep['name'];
                    $chucvu_nv=$nghiphep['chucvu'];
                    $gioitinh_nv=$nghiphep['gender'];
                    $phongban_nv=$nghiphep['phongban'];
                    $id_form=$nghiphep['ID_Form'];
                    $reason=$nghiphep['Reason'];
                    $status=$nghiphep['Status'];
                    $date=$nghiphep['Date'];
                    $date1=date_create($nghiphep['Date']);
                    $date2=date_create($nghiphep['End_day']);
                    $total=date_diff($date1,$date2)->format('%a');
                    $_SESSION['id_form'] = $id_form;
                    echo'<tr class="item">';
                    echo'<td>'.$id_nv.'</td>';
                    echo'<td>'.$name_nv.'</td>';
                    echo'<td>'.$chucvu_nv.'</td>';
                    echo' <td>'.$gioitinh_nv.'</td>';
                    echo' <td>'.$phongban_nv.'</td>';
                    echo' <td>'. $id_form.'</td>';
                    echo' <td>'.$date.'</td>';
                    echo' <td>'.$total.'</td>';
                    echo' <td>'.$reason.'</td>';
                    echo' <td>'.$status.'</td>';
                    echo '<td><button type="button" class="btn btn-light"> <a href="chitiet_don.php?id='.$id_nv.'&id_form='.$id_form.'">Chi tiết</a></button></td>';
                    echo' </tr>';
                }
                
            }
            else{
                echo"Hiện không có lá đơn nào.";
            }
        }
        else if ($type=="Trưởng phòng"){
            require_once 'connection.php';
            $sql = "SELECT account.id,account.name,account.gender,account.chucvu,account.phongban,nghiphep.ID_Form,nghiphep.Date,nghiphep.End_day,nghiphep.Reason,nghiphep.Status FROM `account`,`nghiphep` WHERE nghiphep.ID=account.ID and account.chucvu=?  and account.phongban=? ORDER BY nghiphep.ID_Form DESC;";
            $stm = $dbCon->prepare($sql);
            $stm->execute(array("Nhân viên",$room));
            if ($stm->rowCount()>0){
                while ($nghiphep = $stm->fetch(PDO::FETCH_ASSOC)){
                    $id_nv=$nghiphep['id'];
                    $name_nv=$nghiphep['name'];
                    $chucvu_nv=$nghiphep['chucvu'];
                    $gioitinh_nv=$nghiphep['gender'];
                    $phongban_nv=$nghiphep['phongban'];
                    $id_form=$nghiphep['ID_Form'];
                    $reason=$nghiphep['Reason'];
                    $status=$nghiphep['Status'];
                    $date=$nghiphep['Date'];
                    $date1=date_create($nghiphep['Date']);
                    $date2=date_create($nghiphep['End_day']);
                    $total=date_diff($date1,$date2)->format('%a');
                    $_SESSION['id_form'] = $id_form;
                    echo'<tr class="item">';
                    echo'<td>'.$id_nv.'</td>';
                    echo'<td>'.$name_nv.'</td>';
                    echo'<td>'.$chucvu_nv.'</td>';
                    echo' <td>'.$gioitinh_nv.'</td>';
                    echo' <td>'.$phongban_nv.'</td>';
                    echo' <td>'. $id_form.'</td>';
                    echo' <td>'.$date.'</td>';
                    echo' <td>'.$total.'</td>';
                    echo' <td>'.$reason.'</td>';
                    echo' <td>'.$status.'</td>';
                    echo '<td><button type="button" class="btn btn-light"> <a href="chitiet_don.php?id='.$id_nv.'&id_form='.$id_form.'">Chi tiết</a></button></td>';
                    echo' </tr>';
                }
                
            }
            else{
                echo"Hiện không có lá đơn nào.";
            }
        }
        ob_end_flush();
    ?>
    </table>
    <div>
        <button type="button" class="btn btn-light mt-1 ml-3 float-right  "> <a href="duyet_don.php">Trở lại</a></button>
    </div>
    </div>
</body>
</html>