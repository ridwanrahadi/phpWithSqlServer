<?php 
include 'controller/inc.connection.php';
 
$username = $_POST['username'];
$password = $_POST['password'];
 
$sql = "select * from tblpengguna where username='$username' and password='$password'";
$stmt = sqlsrv_query($conn,$sql);
if ($stmt === false) {
	# code...
	die(print_r(sqlsrv_errors(),true));
}
session_start();
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	
	$_SESSION['username'] = $username;
	$_SESSION['status'] = 'login';
	$Level = $row['Level']; 
	setcookie('username',$username,time() +172800);
	setcookie('level',$Level,time() +172800); 
	setcookie('login','true',time() +172800); 
}

sqlsrv_free_stmt( $stmt);
	
if($Level == 'admin'){
	header("location:menu-utama.php");
	$_SESSION['login'] = 'admin';
	setcookie('akses','admin',time() +172800);
	}elseif ($Level == 'user'){
	header("location:menu-utama.php");
	$_SESSION['login'] = 'user';
	setcookie('akses','user',time() +172800);
	}elseif ($Level =='prc') {
	header("location:menu-utama-prc.php");
	setcookie('akses','prc',time() +172800);
	}elseif ($Level =='expedisi') {
		header("location:menu-utama-expedisi.php");
		$_SESSION['login'] = 'user';
		setcookie('akses','expedisi',time() +172800);
		}else{
	header("location:index.php");
	}