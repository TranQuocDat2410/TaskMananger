<?php
    if ($type == "Giám đốc"){
        ?>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                    Chức năng
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class=" add-user-function dropdown-item" href="add-user-form.php" >Thêm nhân viên</a>
                    <a class="dropdown-item" href="list-user.php">Xem danh sách nhân viên</a>
                    <a class="dropdown-item" href="add_room.php?id=<?=$_SESSION['id']?>">Thêm phòng ban</a>
                    <a class="dropdown-item" href="room.php?id=<?=$_SESSION['id']?>">Xem danh sách phòng ban</a>
                    <a class="dropdown-item" href="add_task.php?id=<?=$_SESSION['id']?>">Giao công việc</a>
                    <a class="dropdown-item" href="set_password.php?id=<?=$_SESSION['id']?>">Đổi mật khẩu</a>
                    <a class="dropdown-item" href="change_avatar.php?id=<?=$_SESSION['id']?>">Đổi avatar</a>
                    <a class="dropdown-item" href="duyet_don.php?id=<?=$_SESSION['id']?>">Duyệt đơn nghỉ phép</a>
                </div>
            </div>        
        <?php 
    }
    else if($type == "Trưởng phòng"){
        ?>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                    Chức năng
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="change_avatar.php?id=<?=$_SESSION['id']?>">Đổi avatar</a>
                    <a class="dropdown-item" href="set_password.php?id=<?=$_SESSION['id']?>">Đổi mật khẩu</a>
                    <a class="dropdown-item" href="add_task.php?id=<?=$_SESSION['id']?>">Giao công việc</a>
                    <a class="dropdown-item" href="duyet_don.php?id=<?=$_SESSION['id']?>">Duyệt đơn nghỉ phép</a>
                    <a class="dropdown-item" href="ngay_nghi.php?id=<?=$_SESSION['id']?>">Nộp đơn nghỉ phép</a>
                </div>
            </div>        
        <?php
    }
    else{
        ?>  
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                    Chức năng
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="set_password.php?id=<?=$_SESSION['id']?>">Đổi mật khẩu</a>
                    <a class="dropdown-item" href="change_avatar.php?id=<?=$_SESSION['id']?>">Đổi avatar</a>
                    <a class="dropdown-item" href="ngay_nghi.php?id=<?=$_SESSION['id']?>">Nộp đơn nghỉ phép</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>            
        <?php
    }
?>