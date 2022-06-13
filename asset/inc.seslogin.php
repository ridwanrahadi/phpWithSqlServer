<?php
 session_start();
 if(isset($_COOKIE['login'])){
  if ($_COOKIE['login']=='true') {
   $_SESSION['username'] = $_COOKIE['username'];
   $_SESSION['login'] = $_COOKIE['akses'];
  }
 }else{
 	echo "<center>";
	echo "<br> <br> <b>Silahkan melakukan login!</b> <br>
		  Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
    echo "<p><strong><a href='logout.php';>Login</a></strong></p>";
	echo "</center>";
	exit;
 }

?>