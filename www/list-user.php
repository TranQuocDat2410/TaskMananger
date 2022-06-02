<?php
	session_start();
	if (!isset($_SESSION['id']) || $_SESSION['id']!=1 ){
		header('Location: login.php');
	}
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
	<title>Home Page</title>
</head>
<body style="background-color: aquamarine" id="list-user">
    <div  class="container mt-5">
        <!-- <h1 class="text-center mt-5 mb-3">Danh sách nhân viên</h1> -->
        <table class="table table-striped table-hover bg-light">
            <thead>
              <tr>
                <td class="align-middle"><a href="index.php" class="btn btn-danger" >Quay lại</a></td>
                <td colspan="4"><h1 class="text-center mb-0">Danh sách nhân viên</h1></td>
              </tr>
            </thead>

            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Phòng ban</th>
                <th scope="col">Chức vụ</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

              <?php
                require 'connection.php';
                $sql = 'SELECT * FROM account';
                $stmt = $dbCon->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  ?>
                    <tr id=<?=$row['id']?>>
                      <th scope="row"><?=$row['id']?></th>
                      <td><?=$row['name']?></td>
                      <td><?=$row['phongban']?></td>
                      <td><?=$row['chucvu']?></td>
                      <td>
                        <button class="btn btn-success" onclick="btn_view_user(this)">View</button>
                        <button class="btn btn-danger" onclick="reset_password(this)" >Reset</button>
                      </td>
                    </tr>    
                  <?php
                }
              ?>
            </tbody>
          </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>
</html>
<?php ob_flush();?>