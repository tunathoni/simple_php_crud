<?php  
	
	include 'connect.php';

	session_start();
	if (!empty($_SESSION['userdata'])) {
		$user_session = $_SESSION['userdata'];
	} else {
		$user_session = null;
		header('Location:login.php');
	}

	$param = $_GET;
	$sql = "select * from posts where id_blog = " . $param['id'];

	$data = mysqli_query($conn, $sql);

	$row = mysqli_fetch_array($data);

	// untuk mengambil data users untuk ditampilkan di combobox

	$sql_user = "select * from users ";
	$data_user = mysqli_query($conn, $sql_user);

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="form_edit.php?id=<?=$row['id_blog']?>" method="POST" enctype='multipart/form-data'>
		<table>
			<tr>
				<td>ID</td>
				<td>
					<input type="text" name="id" value="<?=$row['id_blog']?>" readonly>
				</td>
			</tr>
			<tr>
				<td>Picture</td>
				<td>
					<input type="text" name="picture" value="<?=$row['picture']?>" readonly>
				</td>
			</tr>
			<tr>
				<td>Judul</td>
				<td>
					<input type="text" name="title" value="<?=$row['title']?>">
				</td>
			</tr>
			<tr>
				<td>Picture</td>
				<td><input type="file" name="picture"></td>
			</tr>
			<tr>
				<td>Description</td>
				<td>
					<textarea name="description"><?=$row['description']?></textarea>
				</td>
			</tr>
			<tr>
				<td>User</td>
				<td>
					<?=@$user_session['name']?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="Edit">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

<?php  

	$param 		= $_POST;
	$file_data 	= $_FILES;

	if (!empty($param['title']) && !empty($param['description'])) {

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

			// delete file lama
			unlink('./uploads/'.$param['picture']);

			// update data
			$title = $param['title'];
			$description = $param['description'];
			$id = $param['id'];
			$id_user = $user_session['id_user'];

			$sql_update = "UPDATE posts
							SET title = '$title',
								picture = '$nama_file',
								description = '$description',
								id_user = $id_user
							WHERE 
								id_blog = $id
							";

			mysqli_query($conn, $sql_update);
		}

		header('Location:article.php');
	}
	

?>