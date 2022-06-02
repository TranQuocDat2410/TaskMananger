<?php

    function add_room($name, $desc, $leader, $number){
        require 'connection.php';
        $sql = "INSERT INTO `room` (`name`, `description`, `leader`, `num_room`) VALUES (?,?,?,?)";
        $stm = $dbCon->prepare($sql);
        try {
            $stm->execute(array($name,$desc, $leader, $number));
            return $stm->rowCount();
        }
        catch (Exception $e){
            return $e;
        }
    }

    function  add_user($username, $name, $room, $address, $birthday, $salary, $email, $avatar, $phone, $gender){
        $passwordHashed = password_hash($username,PASSWORD_DEFAULT);
        require 'connection.php';
        $sql = " INSERT INTO `account` (`username`, `password`, `name`, `chucvu`, `phongban`, `diachi`, `birthday`, `activated`, `salary`, `email`, `avatar`, `phone`,`gender`,`ngaynghi`) VALUES (?, ?, ?, ?, ?, ?, ?, b'0', ?, ?, ?,?,?,?); ";
        $stm = $dbCon->prepare($sql);
        try{
            $stm->execute(array($username,$passwordHashed,$name,"Nhân viên",$room,$address,$birthday,$salary,$email, $avatar, $phone, $gender,0));
            return $stm->rowCount();
        }
        catch(Exception $e){
            $error = $e->getMessage();
            return $error;
        }
    }

    function changeAccountRoom($name,$room){
        require 'connection.php';
        $sql = "UPDATE `account` SET `phongban` = ? WHERE `account`.`name` = ?";
        $stm = $dbCon->prepare($sql);
        try{
            $stm->execute(array($room, $name));
            return $stm->rowCount();
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    function changeLeaderRoom($room, $leader){
        require 'connection.php';
        $sql = "UPDATE `room` SET `leader` = ? WHERE `room`.`name` = ?";
        $stm = $dbCon->prepare($sql);
        try{
            $stm->execute(array($leader,$room));
            return $stm->rowCount();
        }
        catch(Exception $e){
            $error = "Lỗi";
            return $error;
        }
    }

    function changePrivilage($name, $type){
        require 'connection.php';
        $sql = "UPDATE `account` SET `chucvu` = ? WHERE `account`.`name` = ?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($type,$name));
        return $stm->rowCount();
    }

    function editRoom($name, $leader, $number, $desc, $id){
        require 'connection.php';
        $sql = "UPDATE `room` SET `name` = ?, `leader` = ?, `num_room` = ?, `description` = ? WHERE `room`.`id` = ?";
        $stm = $dbCon->prepare($sql);
        try{
            $stm->execute(array($name,$leader,$number,$desc,$id));
            return $stm->rowCount();
        }
        catch(Exception $e){
            return "Lỗi";
        }
    }

    function editUser($name, $username, $email, $phone, $address, $birthday, $salary, $type, $room, $gender, $id){
        require 'connection.php';
        $sql = "UPDATE `account` SET `name`=?, `username`=?, `email`=?, `phone`=?, `diachi`=?, `birthday`=?, `salary`=?, `chucvu`=?, `phongban`=?, `gender`=?  WHERE `account`.`id` = ?";
		$stm = $dbCon->prepare($sql);
        try{
            $stm->execute(array($name,$username,$email,$phone,$address,$birthday,$salary,$type,$room,$gender,$id));
            return $stm->rowCount();
        }
        catch(Exception $e){
            $error = "Lỗi";
            return $error;
        }
    }

    function getNameById($id){
        require 'connection.php';
        $sql = "SELECT name FROM `account` WHERE id=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['name'];
    }

    function getRoomById($id){
        require 'connection.php';
        $sql = "SELECT phongban FROM account WHERE id=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['phongban'];
    }

    function getLeaderRoom($name){
        require 'connection.php';
        $sql = "SELECT leader FROM `room` WHERE `room`.`name`=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['leader'];
    }

    function setleaderByName($name,$type){
        require 'connection.php';
        $sql = "UPDATE `account` SET `chucvu` = ? WHERE `account`.`name` = ?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($type,$name));
    }

    function getTaskList($name){
        require 'connection.php';
        $data = array();
        $sql = "SELECT id, name, status, deadline FROM `tasks` WHERE nhanvien=? AND status NOT IN (SELECT status FROM `tasks` WHERE status=? OR status=?) ";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name,"Canceled","Completed"));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        foreach($data as $row){
            ?>
                <a id="cv" style="text-decoration: none; color: black" href="detail_task.php?id=<?=$row['id']?>">
                    <div style="background-color:white;" class=" col-12 border py-3 px-5 fs-5 mb-3 task-item">
                        <div class=" row text-center">
                            <div class="col-4">
                                <p class="task-name fw-bold"><?= $row['name'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="tasks-status"><?= $row['status'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="task-deadline text-end"><?= date("d/m/Y",strtotime($row['deadline'])) ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
        }
    }

    function getAllLeaderName(){
        require 'connection.php';
        $data = array();
        $sql = "SELECT name FROM `account` WHERE chucvu=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array("Trưởng phòng"));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }

    function getDetailTask($id){
        require 'connection.php';
        $sql = "SELECT id, name, status, deadline,rating, description, rating, truongphong, nhanvien, file_description FROM `tasks` WHERE id=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        // $stm->fetch(PDO::FETCH_ASSOC);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    function getTaskHistory($id){
        require 'connection.php';
        $sql = "SELECT * FROM `task_history` WHERE id=?";
        $data = array();
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }

    function getEmployees($leader){
        require 'connection.php';
        $data = array();
        $room = getRoomById($leader);
        $sql = "SELECT * FROM `account` WHERE phongban=? AND chucvu=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($room,"Nhân viên"));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }

    function submitTask($id,$desc,$attch,$time,$sender){
        require "connection.php";
        $sql = "INSERT INTO `task_history` (`id`,`description`, `attach`, `time`, `sender`) VALUES (?,?,?,?,?)";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id,$desc,$attch,$time,$sender));
    }

    function getReviewTask($leader){
        require 'connection.php';
        $data = array();
        $sql = "SELECT * FROM `tasks` WHERE truongphong=? and status NOT IN (SELECT status FROM `tasks` WHERE status=? OR status=?) ";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($leader,"Completed","Canceled"));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        } 
        return $data;
    }

    function setStatusTask($id,$status){
        require "connection.php";
        $sql = "UPDATE `tasks` SET `status` = ? WHERE `tasks`.`id` = ?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($status,$id));
        return $stm->rowCount();
    }
    
    function renderOption($type,$status){
        switch ([$type,$status]){
            case ["leader","Waiting"]:
                ?>
                    <div class="row pb-3">
                        <div class="col-12">
                            <a href="rating_task.php?id=<?=$_GET['id']?>" class="btn btn-success ml-4 ">Complete</a>
                            <a href="detail_task.php?id=<?=$_GET['id']?>&status=reject" class="btn btn-danger ">Reject</a>
                        </div>
                    </div>
                <?php
                break;
            case ["leader","New"]:
                ?>
                    <div class="row pb-3">
                        <div class="col-6">
                            <a href="edit_task.php?id=<?=$_GET['id']?>" class="btn btn-success ml-4">Edit</a>
                            <a href="confirm_cancel_task.php?id=<?=$_GET['id']?>" class="btn btn-danger ">Cancel</a>
                        </div>
                    </div>
                <?php
                break;
            case ["employee","New"]:
                ?>
                    <div class="row pb-3">
                        <div class="col-6">
                            <a href="confirm_task.php?id=<?=$_GET['id']?>" class="btn btn-success ml-4">Start</a>
                        </div>
                    </div>
                <?php
                break;
            case ["leader","Rejected"]:
                ?>
                    <div class="row pb-3">
                        <div class="col-12">
                            <a href="detail_task.php?id=<?=$_GET['id']?>&status=complete" class="btn btn-success ml-4 ">Complete</a>
                            <a href="detail_task.php?id=<?=$_GET['id']?>&status=Reject" class="btn btn-danger ">Reject</a>
                        </div>
                    </div>
                <?php
                break;
            default:
                break;
            
        }
    }

    function getCurrentTime(){
        $tz = 'Asia/Bangkok';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); 
        $dt->setTimestamp($timestamp); 
        $time = $dt->format("Y-m-d G:i:s");
        return $time;
    }

    function setDeadlineTask($id,$deadline){
        require 'connection.php';
        $sql = "UPDATE `tasks` SET `deadline` = ? WHERE `tasks`.`id` = ?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($deadline,$id));
        return $stm->rowCount();
    }

    function setRatingTask($id,$type){
        require 'connection.php';
        $sql = "UPDATE `tasks` SET `rating` = ? WHERE `tasks`.`id` = ?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($type,$id));
        return $stm->rowCount();
    }

    function setEndTask($id){
        require 'connection.php';
        $time = getCurrentTime();
        $sql = "UPDATE `tasks` SET `end` = ? WHERE `tasks`.`id` = ?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($time,$id));
        return $stm->rowCount();
    }

    function getTaskByStatus($name,$status){
        require 'connection.php';
        $data = array();
        $sql = "SELECT * FROM `tasks` WHERE status=? AND nhanvien=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($status,$name));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        } 
        return $data;
    }

    function getTaskNameById($id){
        require 'connection.php';
        $sql = "SELECT name FROM `tasks` WHERE id=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['name'];
    }

    function renderTask($name,$status){
        $data = getTaskByStatus($name,$status);
        foreach($data as $row){
            ?>
                <a id="cv" style="text-decoration: none; color: black" href="detail_task.php?id=<?=$row['id']?>">
                    <div style="background-color:white;" class=" col-12 border py-3 px-5 fs-5 mb-3 task-item">
                        <div class=" row text-center">
                            <div class="col-4">
                                <p class="task-name fw-bold"><?= $row['name'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="tasks-status"><?= $row['status'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="task-deadline text-end"><?= date("d/m/Y",strtotime($row['deadline'])) ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
        }
    }

    function getActivate($id){
        require 'connection.php';
        $sql = "SELECT activated FROM `account` WHERE id=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        return $stm->fetch(PDO::FETCH_ASSOC)['activated'];
    }

    function getUsernameById($id) {
        require "connection.php";
        $sql = "SELECT username FROM `account` WHERE id=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($id));
        return $stm->fetch(PDO::FETCH_ASSOC)['username'];
    }

    function countNumberReviewTask($name){
        require 'connection.php';
        $sql = 'SELECT COUNT(id) as number FROM `tasks` WHERE truongphong=? and status NOT IN (SELECT status FROM `tasks` WHERE status="Canceled" OR status="Completed")';
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['number']??0;
    }

    function countNumberTask($name,$status){
        require 'connection.php';
        $sql = "SELECT COUNT(id) as num FROM `tasks` WHERE nhanvien=? AND status=?";
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name,$status));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['num'];
    }

    function countToDoList($name){
        require 'connection.php';
        $sql = 'SELECT COUNT(id) as num FROM `tasks` WHERE nhanvien=? AND status NOT IN (SELECT status FROM `tasks` WHERE status ="Canceled" OR status = "Completed")';
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['num'];
    }

    function countTaskCanceled($name){
        require 'connection.php';
        $sql = 'SELECT COUNT(*) as num FROM `tasks` WHERE (nhanvien=? OR truongphong=?) AND status="Canceled"';
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name,$name));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['num']??0;
    }

    function getTaskCompleted($name){
        require 'connection.php';
        $sql = 'SELECT * FROM `tasks` WHERE (nhanvien = ? OR truongphong = ?) AND status = "Completed"';
        $data = array();
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name,$name));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        } 
        return $data;
    }

    // print_r(getTaskCompleted("Trần Quốc Đạt"));

    function renderTaskCompleted($name){
        $data = getTaskCompleted($name);
        foreach($data as $row){
            ?>
                <a id="cv" style="text-decoration: none; color: black" href="detail_task.php?id=<?=$row['id']?>">
                    <div style="background-color:white;" class=" col-12 border py-3 px-5 fs-5 mb-3 task-item">
                        <div class=" row text-center">
                            <div class="col-4">
                                <p class="task-name fw-bold"><?= $row['name'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="tasks-status"><?= $row['status'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="task-deadline text-end"><?= date("d/m/Y",strtotime($row['deadline'])) ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
        }
    }

    function countTaskCompletd($name){
        require "connection.php";
        $sql = 'SELECT COUNT(id) as num FROM `tasks` WHERE (nhanvien = ? OR truongphong = ?) AND status = "Completed"';
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name,$name));
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        return $data['num']??0;

    }

    function getTaskCanceled($name){
        require 'connection.php';
        $sql = 'SELECT * FROM `tasks` WHERE (nhanvien = ? OR truongphong = ?) AND status = "Canceled"';
        $data = array();
        $stm = $dbCon->prepare($sql);
        $stm->execute(array($name,$name));
        while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        } 
        return $data;
    }
    function renderTaskCanceled($name){
        $data = getTaskCanceled($name);
        foreach($data as $row){
            ?>
                <a id="cv" style="text-decoration: none; color: black" href="detail_task.php?id=<?=$row['id']?>">
                    <div style="background-color:white;" class=" col-12 border py-3 px-5 fs-5 mb-3 task-item">
                        <div class=" row text-center">
                            <div class="col-4">
                                <p class="task-name fw-bold"><?= $row['name'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="tasks-status"><?= $row['status'] ?></p>
                            </div>
                            <div class="col-4">
                                <p class="task-deadline text-end"><?= date("d/m/Y",strtotime($row['deadline'])) ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
        }
    }
    // print_r(countTaskCanceled("Mai Văn Mạnh")) ;


?>