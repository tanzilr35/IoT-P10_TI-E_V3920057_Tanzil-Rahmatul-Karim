<?php
session_start();
// db config -------------------------------------------------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abc_database";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ( isset($_POST['login'])){
  $username = $_POST['username'];
	$password = md5( $_POST['password']);

  	$sql_query = "SELECT name, email, username, id FROM users 
                  WHERE username='$username' AND password='$password'
                  LIMIT 1"; //sql query
   
	$result = $conn->query($sql_query);
	
	if ($result->num_rows > 0) {
    // jika data valid
    while($row = $result->fetch_assoc()) {
        	$_SESSION['name'] = $row["name"];
			
			$conn->close();
			header('location:main_pages/index.php'); // maka akan diarahkan ke main page
			exit();
		}
	} else { // jika data invalid
		// maka akan muncul alert untuk dikembalikan ke login page
		echo "<script language=\"javascript\">alert(\"Invalid username atau password\");
		document.location.href='index.php?error_login';</script>";
		exit();
	}
  
} else {
    header('location:index.php');
    exit();
}
?>