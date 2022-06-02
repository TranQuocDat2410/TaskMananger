<?php
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
	<title>Đánh giá công việc</title>
</head>

<body>
    <?php
        // $id = $_GET['id'];
        require 'function.php';

        $currentTime = getCurrentTime();
        $deadline = getDetailTask($_GET['id'])['deadline'];
        
        if (isset($_POST['type'])){
            $id = $_GET['id'];
            $type = $_POST['type'];
            setRatingTask($id,$type);
            setStatusTask($id,"Completed");
            setEndTask($id);
            header("Location: index.php");
        }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-white">
                <h4>Đánh giá công việc</h4>
                <form method="post" action="">
                    <?php
                        if (strtotime($currentTime) <= strtotime($deadline)){
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="good"
                                        value="Good">
                                    <label class="form-check-label" for="good">Good</label>
                                </div>        
                            <?php
                        }
                    ?>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="ok"
                            value="OK">
                        <label class="form-check-label" for="ok">OK</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="bad"
                            value="Bad">
                        <label class="form-check-label" for="bad">Bad</label>
                    </div>
                     
                    <button name="submit" type="submit" class="btn btn-danger my-2" >Đánh giá</button>
                    <div class="form-group">
                        <?php
                            if ( isset($_POST['submit']) && !isset($_POST['type']) ) {
                                echo "<div class='alert alert-danger'>Nhập đánh giá</div>";
                            }
                        ?>
                    </div> 
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>
<?php ob_flush(); ?>