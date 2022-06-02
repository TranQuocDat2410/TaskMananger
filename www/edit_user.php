<?php
		ob_start();
		session_start();
		if (!isset($_SESSION['id']) || $_SESSION['id']!=1 ){
			header('Location: login.php');
		}
		$id = $_GET['id'];
		$sql = 'SELECT `username`, `avatar`, `name`, `chucvu`, `phongban`, `diachi`, `birthday`, `salary`, `email`, `phone`, `gender` FROM `account` WHERE id=?';
		require_once 'connection.php';
		$stm = $dbCon->prepare($sql);
		$stm->execute(array($id));
		$selectedUser = $stm->fetch(PDO::FETCH_ASSOC);

		$name = '';
		$username = '';
		$email = '';
		$address = '';
		$birthday = '';
		$gender = '';
		$room = '';
		$salary = '';
		$error = '';
		$phone ='';
		$type = '';

		if (isset($_POST["submit"])){
			require "function.php";
			print_r($_POST);
			$name = $_POST['name'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$address = $_POST['address'];
			$birthday = $_POST['birthday'];
			$salary = $_POST['salary'];
			$type = $_POST['type'];
			$room = $_POST['room'];
			$gender = $_POST['gender'];

			if ($selectedUser['chucvu'] == "Trưởng phòng" && $type == "Nhân viên"){
				changeLeaderRoom($selectedUser["phongban"], NULL);
			}
			if ($selectedUser['chucvu'] == "Nhân viên" && $type == "Trưởng phòng"){
				echo $selectedUser['chucvu'];
				echo $type;
				$manager = getLeaderRoom($selectedUser['phongban']);
				echo changePrivilage($manager,"Nhân viên");
				echo changeLeaderRoom($selectedUser['phongban'], $selectedUser['name']);
			}
			if (editUser($name, $username, $email, $phone, $address, $birthday, $salary, $type, $room, $gender, $id)==1){
				header("Location:  notification.php?type=edit_user_success");
			}
			else{
				$error = editUser($name, $username, $email, $phone, $address, $birthday, $salary, $type, $room, $gender, $id);
			}
		}

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Edit user</title>
</head>

<body>
    <div class="container">
		<div class="main-body mt-4">
			<div class="row">
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
							<div class="d-flex flex-column align-items-center text-center">
								<img src="images/<?=$selectedUser['avatar']?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
								<div class="mt-3">
									<h4><?= $selectedUser['name'] ?></h4>
									<p class="text-secondary mb-1"><?= $selectedUser['chucvu'] ?></p>
									<p class="text-muted font-size-sm"><?= $selectedUser['phongban'] ?></p>
								</div>
							</div>

							
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<form action="" method="POST">
						<div class="card">
							<div class="card-body">
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Họ tên</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input name="name" type="text" class="form-control" value="<?= $selectedUser['name'] ?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Username</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input name="username" type="text" class="form-control" value="<?= $selectedUser['username'] ?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Email</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input name="email" type="text" class="form-control" value="<?= $selectedUser['email'] ?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Phone</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input name="phone" type="text" class="form-control" value="<?=$selectedUser['phone']?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Địa chỉ</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input name="address" type="text" class="form-control" value="<?=$selectedUser['diachi']?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Ngày sinh</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input name="birthday" type="date" class="form-control" value="<?=$selectedUser['birthday']?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Giới tính</h6>
									</div>
									<div class="col-sm-9">
										<input type="radio" name="gender" id="male" value="Nam" class="mr-1" <?php echo ($selectedUser['gender'] == "Nam") ? 'checked="checked"' : ''; ?> >Nam
										<input type="radio" name="gender" id="female" value="Nữ" class="ml-2 mr-1" <?php echo ($selectedUser['gender'] == "Nữ") ? 'checked="checked"' : ''; ?> >Nữ
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Lương</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input name="salary" type="number" class="form-control" value="<?=$selectedUser['salary']?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Chức vụ</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<select class="custom-select" name="type">
											<option value="<?= $selectedUser['chucvu']?>"><?= $selectedUser['chucvu']?></option>
											<option value="<?php echo $selectedUser['chucvu']=="Nhân viên"? "Trưởng phòng": "Nhân viên" ?>"><?php echo $selectedUser['chucvu']=="Nhân viên"? "Trưởng phòng" : "Nhân viên" ?></option>
										</select>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Phòng ban</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input readonly name="room" type="text" class="form-control" value="<?=$selectedUser['phongban']?>">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3">
                                        
                                    </div>
									<div class="col-sm-9 text-secondary d-flex justify-content-center">
										<input name="submit" type="submit" class="btn btn-primary px-4 d-block " value="Save">
                                        <a href="index.php" class="btn btn-danger d-block ml-auto">Quay lại</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>
