<?php  
session_start();

if (isset($_SESSION['level'])) {
	if ($_SESSION['level']!="") {
		header("location:../dashboard");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Resto Asa</title>
	
	<!-- Prevent caching -->
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	
	<!-- Prevent back button after logout -->
	<script type="text/javascript">
		window.history.forward();
		function noBack() {
			window.history.forward();
		}
	</script>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	
	<style>
		body {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.login-container {
			background: rgba(255, 255, 255, 0.95);
			border-radius: 20px;
			box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
			padding: 40px;
			width: 100%;
			max-width: 450px;
			margin: 20px;
		}
		.logo-container {
			text-align: center;
			margin-bottom: 30px;
		}
		.logo-container img {
			max-width: 200px;
			height: auto;
			margin-bottom: 20px;
		}
		.form-floating {
			margin-bottom: 20px;
		}
		.login-btn {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			border: none;
			padding: 12px;
			font-weight: 600;
			width: 100%;
			margin-top: 20px;
			border-radius: 10px;
			transition: all 0.3s ease;
		}
		.login-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
		}
		.alert {
			border-radius: 10px;
			margin-bottom: 20px;
		}
		.form-control:focus {
			border-color: #764ba2;
			box-shadow: 0 0 0 0.25rem rgba(118, 75, 162, 0.25);
		}
	</style>
</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();">
	<div class="login-container">
		<div class="logo-container">
			<img src="../dashboard/assets/image/logo1.png" alt="Logo">
			<h2 class="text-center mb-4">Resto Asa</h2>
		</div>

		<?php
		if(isset($_GET['pesan'])) {
			if($_GET['pesan']=="gagal") {
				echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
						<i class='fas fa-exclamation-circle me-2'></i>Username atau Password tidak sesuai
						<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
					  </div>";
			} elseif ($_GET['pesan']=="tabrak") {
				echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
						<i class='fas fa-exclamation-triangle me-2'></i>Anda harus <strong>Login</strong> terlebih dahulu!
						<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
					  </div>";
			} elseif ($_GET['pesan']=="logout") {
				echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
						<i class='fas fa-check-circle me-2'></i>Anda berhasil logout
						<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
					  </div>";
			}
		}
		?>

		<form action="cek_login.php" method="post">
			<div class="form-floating">
				<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
				<label for="username"><i class="fas fa-user me-2"></i>Username</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
				<label for="password"><i class="fas fa-lock me-2"></i>Password</label>
			</div>
			<button type="submit" name="login" class="btn btn-primary login-btn">
				<i class="fas fa-sign-in-alt me-2"></i>Login
			</button>
		</form>
	</div>

	<!-- Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>