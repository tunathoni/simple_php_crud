<?php  
	include 'connect.php';
	$sql 	= "SELECT siswa.*, kelas.nama_kelas
				from siswa, kelas  
			   WHERE 
			   	siswa.id_kelas = kelas.id_kelas
			  ";
	$data 	= mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<a href="">Data Siswa</a>
	<a href="">Data kelas</a>
	<a href="">Data Mata Pelajaran</a>
	<a href="">Data Nilai</a>
	<table border="1">
		<tr>
			<td>ID</td>
			<td>NAMA</td>
			<td>KELAS</td>
		</tr>
		<?php 
			while($row = mysqli_fetch_array($data)) {
		?>
		
		<tr>
			<td><?php echo $row['id_siswa']; ?></td>
			<td><?php echo $row['nama_siswa']; ?></td>
			<td><?php echo $row['nama_kelas']; ?></td>
		</tr>
		        
		<?php
		    }
		?>
	</table>
</body>
</html>