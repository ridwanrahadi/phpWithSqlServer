<?php 
session_start();
session_destroy();
setcookie('level',"",time() -604800); 
setcookie('login',"",time() -604800); 
setcookie('akses','',time() -604800);
setcookie('username','',time() -604800);
header("location:index.php");
?>