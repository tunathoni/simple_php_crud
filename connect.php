<?php  
	date_default_timezone_set("Asia/Jakarta");
	$servername = '127.0.0.1'; //127.0.0.1
	$username	= 'root';
	$password	= '';
	$database	= 'blog';

	$conn = mysqli_connect($servername, $username, $password, $database);

	// check connection
	if (!$conn) {
		echo "Koneksi gagal = " . $conn->connect_error;
	}
?>