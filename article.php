<?php  
	
	include 'connect.php';
	session_start();
	
	if (!empty($_SESSION['userdata'])) {
		$user_session = $_SESSION['userdata'];
	} else {
		$user_session = null;
		header('Location:login.php');
	}
	
	$limit = 2;

	if (!empty($_GET['page'])) {
		if ($_GET['page'] == 1) {
			$page = 0;
		}else {
			$page = ($_GET['page'] - 1) * $limit;	
		}
		
	}else{
		$page = 0;
	}

	$sql = "SELECT posts.*, users.name from posts, users 
			WHERE posts.id_user = users.id_user
			order by posts.id_blog

			limit $page,$limit ";

	$data 	= mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<a href="insert_data.php">Add Post</a>
	<input type="text" name="search">
	<input type="submit" value="Search">
	<label>Selamat datang, <?=@$user_session['name']?></label>
	<a href="logout.php">Logout</a>
	<table border="1">
		<tr>
			<td>ID</td>
			<td>Date Publish</td>
			<td>Title</td>
			<td>Picture</td>
			<td>Desc</td>
			<td>Creator</td>		
			<td>Action</td>
		</tr>
		<?php  
			while($row = mysqli_fetch_array($data)) {
		?>
			<tr>
				<td><?=$row['id_blog']?></td>
				<td><?=$row['date_publish']?></td>
				<td><?=$row['title']?></td>
				<td><img src="./uploads/<?=$row['picture']?>" width="40px"></td>
				<td><?=$row['description']?></td>
				<td><?=$row['name']?></td>
				<td>
					<a href="form_edit.php?id=<?=$row['id_blog']?>">Edit</a>
					<a href="remove.php?id=<?=$row['id_blog']?>">Delete</a>
				</td>
			</tr>
		<?php 
			} 
		?>
	</table>
	<?php  

	$cekQuery = mysqli_query($conn, "SELECT * FROM posts");
	$jumlahData = mysqli_num_rows($cekQuery);
	if ($jumlahData > $limit) {
		echo '<br/><center><div style="font-size:10pt;">Page : ';
		$a = explode(".", $jumlahData / $limit);
		$b = $a[0];
		
		if (@$a[1] > 0) {
			$c = $b + 1;
		} else {
			$c = $b;
		}
		
		for ($i = 1; $i <= $c; $i++) {
			echo '<a style="text-decoration:none;';
			if ($_GET['page'] == $i) {
				echo 'color:red';
			}
			echo '" href="?page=' . $i . '">' . $i . '</a>, ';
		}
		echo '</div></center>';
	}

	?>
</body>
</html>