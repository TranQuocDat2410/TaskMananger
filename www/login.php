<?php
	session_start();
	ob_start();
	if(isset($_SESSION['id'])){
		header("Location: index.php");
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
	<title>Login</title>
</head>
<body id="lg">

	<?php
		$user = "";
		$pass = "";
		$error = "";
		if (isset($_POST['user']) && isset($_POST['pass'])){
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			if (empty($user)){
				$error = "Input your username";
			}
			else if (empty($pass)){
				$error = "Input your password";
			}
			else{
				require_once 'connection.php';
				$sql = "SELECT * FROM `account` WHERE username = ?";
				$stm = $dbCon->prepare($sql);
				$stm->execute(array($user));
				if ($stm->rowCount()==0){
					$error = "User not in database";
				}
				else{
					$dataUser = $stm->fetch(PDO::FETCH_ASSOC);
					$id = $dataUser['id'];
					
					if (password_verify($pass,$dataUser['password']) ){
						if ($dataUser['activated'] == 0){
							header("Location: set_password.php?id=$id");
						}
						else{
							$_SESSION['id'] = $dataUser['id'];
							header("Location: index.php");
						}
					}
					else {
						$error = "Password not correct";
					}	
				}
			}
		}
	?>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 col-lg-5">
				<h1 class="text-center mt-5 mb-3">TDT Company</h1>
				<form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
					<div class="form-group">
						<label for="username">Username</label>
						<input value="<?= $user ?>" name="user" id="user" type="text" class="form-control"
							placeholder="Username">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control"
							placeholder="Password">
					</div>
					<div class="form-group custom-control custom-checkbox">
						<input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox"
							class="custom-control-input" id="remember">
						<label class="custom-control-label" for="remember">Remember login</label>
					</div>
					<div class="form-group">
						<?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
						<button class="btn btn-success px-5">Login</button>
					</div>
					<div class="form-group">
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
<?php ob_flush();?>