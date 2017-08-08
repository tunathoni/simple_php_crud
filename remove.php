<?php  

	include 'connect.php';

	$param 	= $_GET;
	$id 	= $param['id'];

	$sql 	= "DELETE FROM posts WHERE id_blog = " . $id;

	mysqli_query($conn, $sql);

	header('Location:article.php');

?>