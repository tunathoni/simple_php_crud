<?php  
	include 'connect.php';

	session_start();
	if (!empty($_SESSION['userdata'])) {
		$user_session = $_SESSION['userdata'];
	} else {
		$user_session = null;
		header('Location:login.php');
	}

	$sql = "SELECT * FROM users";
	$data = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="insert_data.php" method="POST" enctype='multipart/form-data'>
		<table>
			<tr>
				<td>Title</td>
				<td><input type="text" name="title"></td>
			</tr>
			<tr>
				<td>Picture</td>
				<td><input type="file" name="picture"></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><textarea name="desc"></textarea></td>
			</tr>
			<tr>
				<td>User</td>
				<td>
					<?=@$user_session['name']?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Submit"></td>
			</tr>
		</table>
	</form>
</body>
</html>

<?php  
	
	$param = $_POST;
	$file_data = $_FILES;

	// echo "<pre>";
	// print_r ($param);
	// print_r ($file_data);
	// echo "</pre>";exit;

	if (!empty($param['title']) && !empty($param['desc'])) {

		$waktu 		= date('Ymdhis');
		$tipe_file  = $file_data['picture']['type'];

		if ($tipe_file == 'image/png') {
			$nama_file 	= $waktu.'.png';
		}elseif ($tipe_file == 'image/jpg' || $tipe_file == 'image/jpeg'){
			$nama_file 	= $waktu.'.jpg';
		}
		
		$tmp_url	= $file_data['picture']['tmp_name'];
		$source_upload = './uploads/';


		// proses upload file
		if (move_uploaded_file($tmp_url, $source_upload.$nama_file)) {
			// insert data
			$sql = "INSERT INTO posts (title, picture, description, date_publish, id_user) VALUES('".$param['title']."', '".$nama_file."', '".$param['desc']."', now(), ".@$user_session['id_user'].")";
			// echo $sql;
			$data 	= mysqli_query($conn, $sql);
		}
		

		header('Location: article.php');
	}else{
		echo "Inputan anda tidak lengkap";
	}
?>