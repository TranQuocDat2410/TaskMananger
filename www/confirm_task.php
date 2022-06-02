<?php
    require 'function.php';
    $id = $_GET['id'];
    setStatusTask($id,"In progress");
    header("Location: notification.php?type=20");
?>