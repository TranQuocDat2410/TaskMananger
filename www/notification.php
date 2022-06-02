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

<body>
  <?php
    $type = isset($_GET['type']) ? $_GET['type'] : "";
    switch ($type){
      case "add_user_success":
        ?>
          <div class="container">
            <div class="row">
              <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-white">
                <h4>Thêm nhân viên thành công</h4>
                <p class="text-success">Congratulations! Your account has been activated.</p>
                <p>Click <a href="login.php">here</a> to login and manage your account information.</p>
                <a class="btn btn-success px-5" href="index.php">Quay lại</a>
              </div>
            </div>
          </div>
        <?php
        break;
      case "edit_room_success":
        ?>
          <div class="container">
            <div class="row">
              <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-light">
                <h4>Cập nhật thông tin phòng thành công</h4>
                <p class="text-success">Congratulations! Your account has been activated.</p>
                <p>Click <a href="login.php">here</a> to login and manage your account information.</p>
                <a class="btn btn-success px-5" href="index.php">Quay lại</a>
              </div>
            </div>
          </div>
        <?php
        break;

      case "update_room_success":
        ?>
          <div class="container">
            <div class="row">
              <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-light">
                <h4>Cập nhật phòng thành công</h4>
                <p class="text-success">Congratulations! Your account has been activated.</p>
                <p>Click <a href="login.php">here</a> to login and manage your account information.</p>
                <a class="btn btn-success px-5" href="index.php">Quay lại</a>
              </div>
            </div>
          </div>
        <?php
        break;
      case "edit_user_success":
        ?>
          <div class="container">
            <div class="row">
              <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-light">
                <h4>Cập nhật nhân viên thành công</h4>
                <p class="text-success">Congratulations! Your account has been activated.</p>
                <p>Click <a href="login.php">here</a> to login and manage your account information.</p>
                <a class="btn btn-success px-5" href="index.php">Quay lại</a>
              </div>
            </div>
          </div>
        <?php
        break;
        case "1":
          ?>
            <div class="container">
              <div class="row">
                <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-white">
                  <h4 class="text-success">Giao việc thành công</h4>
                  <p class="text-success"></p>
                  <!-- <p>Click <a href="login.php">here</a> to login and manage your account information.</p> -->
                  <a class="btn btn-success px-5" href="index.php">Quay lại</a>
                </div>
              </div>
            </div>
          <?php
          break;
        case "2":
          ?>
            <div class="container">
              <div class="row">
                <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-white">
                  <h4 class="text-success">Cập nhật công việc thành công</h4>
                  <p class="text-success"></p>
                  <!-- <p>Click <a href="login.php">here</a> to login and manage your account information.</p> -->
                  <a class="btn btn-success px-5" href="index.php">Quay lại</a>
                </div>
              </div>
            </div>
          <?php
          break;

        case "20":
          ?>
              <div class="container">
                <div class="row">
                  <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-white">
                    <h4>Cập nhật trạng thái thành công</h4>
                    <p class="text-success">Trạng thái công việc của bạn đã được cập nhật</p>
                    <p>Click <a href="index.php">vào đây </a>để quay lại trang chủ</p>
                    <a class="btn btn-success px-5" href="index.php">Quay lại</a>
                  </div>
                </div>
              </div>
          <?php
        break; 

        case "21":
          ?>
          <div class="container">
            <div class="row">
              <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-white">
                <h4>Cập nhật mật khẩu thành công</h4>
                <p class="text-success">Mật khẩu đã được cập nhật</p>
                    <p>Click <a href="index.php">vào đây </a>để quay lại trang chủ</p>
                    <a class="btn btn-success px-5" href="index.php">Quay lại</a>
              </div>
            </div>
          </div>
        <?php
        break;
      default:
        ?>
          <div class="container">
            <div class="row">
              <div class="col-md-6 mt-5 mx-auto p-3 border rounded bg-white">
                <h4>Cập nhật trạng thái thành công</h4>
                <p class="text-success">Trạng thái của bạn đã được cập nhật</p>
                <p>Click <a href="index.php">vào đây</a> dể quay lại trang chủ</p>
                <a class="btn btn-success px-5" href="index.php">Quay lại</a>
              </div>
            </div>
          </div>
        <?php
        break;

    }
    
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->

</body>

</html>