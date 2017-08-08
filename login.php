<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="" method="POST">
		<table>
			<tr>
				<td>username</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>password</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Login"></td>
			</tr>
		</table>
	</form>
</body>
</html>

<?php  
	include 'connect.php';
	
	session_start();

	if (!empty($_SESSION['userdata'])) {
		header('Location:article.php');
	}

	$param = $_POST;

	if (!empty($param)) {
		$username = $param['username'];
		$password = $param['password'];

		$sql = "SELECT * FROM users 
				where 
				username = '$username' AND 
				password = '$password'
				limit 1
				";
		$query = mysqli_query($conn, $sql);
		$data = mysqli_fetch_array($query);

		if (count($data) > 0) {
			$_SESSION["userdata"] = $data;

			header('Location:article.php');
		}
		
		echo "<pre>";
		print_r ($data);
		echo "</pre>";
		
	} else {
		echo "Isi username dan password terlebih dahulu.";
	}
	
?>