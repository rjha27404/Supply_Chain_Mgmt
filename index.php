<?php
include('includes/config.php');
$reqErr = $loginErr = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!empty($_POST['txtUsername']) && !empty($_POST['txtPassword']) && isset($_POST['login_type'])) {
		session_start();
		$username = $_POST['txtUsername'];
		$password = $_POST['txtPassword'];
		$_SESSION['sessLogin_type'] = $_POST['login_type'];
		if ($_SESSION['sessLogin_type'] == "retailer") {
			//if selected type is retailer than check for valid retailer.
			$query_selectRetailer = "SELECT retailer_id,username,password FROM retailer WHERE username='$username' AND password='$password'";
			$result = mysqli_query($con, $query_selectRetailer);
			$row = mysqli_fetch_array($result);
			if ($row) {
				$_SESSION['retailer_id'] = $row['retailer_id'];
				$_SESSION['sessUsername'] = $_POST['txtUsername'];
				$_SESSION['sessPassword'] = $_POST['txtPassword'];
				$_SESSION['retailer_login'] = true;
				header('Location:retailer/index.php');
			} else {
				$loginErr = "* Username or Password is incorrect.";
			}
		} else if ($_SESSION['sessLogin_type'] == "manufacturer") {
			//if selected type is manufacturer than check for valid manufacturer.
			$query_selectManufacturer = "SELECT man_id,username,password FROM manufacturer WHERE username='$username' AND password='$password'";
			$result = mysqli_query($con, $query_selectManufacturer);
			$row = mysqli_fetch_array($result);
			if ($row) {
				$_SESSION['manufacturer_id'] = $row['man_id'];
				$_SESSION['sessUsername'] = $_POST['txtUsername'];
				$_SESSION['sessPassword'] = $_POST['txtPassword'];
				$_SESSION['manufacturer_login'] = true;
				header('Location:manufacturer/index.php');
			} else {
				$loginErr = "* Username or Password is incorrect.";
			}
		} else if ($_SESSION['sessLogin_type'] == "admin") {
			$query_selectAdmin = "SELECT username,password FROM admin WHERE username='$username' AND password='$password'";
			$result = mysqli_query($con, $query_selectAdmin);
			$row = mysqli_fetch_array($result);
			if ($row) {
				$_SESSION['admin_login'] = true;
				$_SESSION['sessUsername'] = $_POST['txtUsername'];
				$_SESSION['sessPassword'] = $_POST['txtPassword'];
				header('Location:admin/index.php');
			} else {
				$loginErr = "* Username or Password is incorrect.";
			}
		}
	} else {
		$reqErr = "* All fields are required.";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title> Login </title>
	<link rel="stylesheet" href="includes/main_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://use.fontawesome.com/f59bcd8580.js"></script>
	<style>
		body {
			background: #c9ccd1;
			border: none;
		}

		.form-style input {
			border: 0;
			height: 50px;
			border-radius: 0;
			border-bottom: 1px solid #ebebeb;
		}

		.form-style input:focus {
			border-bottom: 1px solid #007bff;
			box-shadow: none;
			outline: 0;
			background-color: #ebebeb;
		}

		.sideline {
			display: flex;
			width: 100%;
			justify-content: center;
			align-items: center;
			text-align: center;
			color: #ccc;
		}

		button {
			height: 50px;
		}

		/* img{
			height: 50%;
			width: 100%;
		} */
		.sideline:before,
		.sideline:after {
			content: '';
			border-top: 1px solid #ebebeb;
			margin: 0 20px 0 0;
			flex: 1 0 20px;
		}

		.sideline:after {
			margin: 0 0 0 20px;
		}
	</style>
</head>

<body>

	<!-- <h1>LOGIN</h1>
	<form action="" method="POST" class="login-form">
	<ul class="form-list">
	<li>
		<div class="label-block"> <label for="login:username">Username</label> </div>
		<div class="input-box"> <input type="text" id="login:username" name="txtUsername" placeholder="Username" /> </div>
	</li>
	<li>
		<div class="label-block"> <label for="login:password">Password</label> </div>
		<div class="input-box"> <input type="password" id="login:password" name="txtPassword" placeholder="Password" /> </div>
	</li>
	<li>
		<div class="label-block"> <label for="login:type">Login Type</label> </div>
		<div class="input-box">
		<select name="login_type" id="login:type">
		<option value="" disabled selected>-- Select Type --</option>
		<option value="retailer">Distributor</option>
		<option value="manufacturer">Supplier</option>
		<option value="admin">Admin</option>
		</select>
		</div>
	</li>
	<li>
		<input type="submit" value="Login" class="submit_button" /> <span class="error_message"> <?php echo $loginErr;
		echo $reqErr; ?> </span>
	</li>
	</ul>
	</form> -->
	
	<center>
	
		<div class="container" style="margin-left:200px;margin-top:100px;position:fixed;">
		<h1>Supply Chain Management</h1>
				<div class="row m-5 no-gutters">
					<div class="col-md-6 d-none d-md-block">
						<img src="https://images.unsplash.com/photo-1566888596782-c7f41cc184c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=2134&q=80"
							class="img-fluid" style="height: 60%;
			width: 100%;" />
					</div>
					<div class="col-md-6 bg-white p-5" style="height: 50%;
			width: 100%;">
						<h3 class="pb-3">Login Form</h3>
						<div class="form-style">
							<form action="" method="POST" class="login-form">
								<div class="form-group pb-3">
									<input type="text" id="login:username" name="txtUsername" placeholder="Username"
										class="form-control" aria-describedby="emailHelp">
								</div>
								<div class="form-group pb-3">
									<input type="password" id="login:password" name="txtPassword" placeholder="Password"
										class="form-control">
								</div>
								<div class="form-group pb-3">
									<select name="login_type" id="login:type" class="form-control">
										<option value="" disabled selected>-- Select Type --</option>
										<option value="retailer">Distributor</option>
										<option value="manufacturer">Supplier</option>
										<option value="admin">Admin</option>
									</select>
								</div>
								<div class="pb-2">
									<input class="btn btn-dark w-100 font-weight-bold mt-2" type="submit" value="Login"
										class="submit_button" /> <span class="error_message">
										<?php echo $loginErr;
										echo $reqErr; ?>
									</span>
								</div>
							</form>

						</div>

					</div>
				</div>
		</div>
	</center>
</body>

</html>