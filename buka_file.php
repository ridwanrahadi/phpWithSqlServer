<?php
include_once "asset/inc.seslogin.php";
# include_once "library/inc.seslogin.php";
# KONTROL MENU PROGRAM
if($_GET) {
	// Jika mendapatkan variabel URL ?page
	switch ($_GET['page']){				
		case '' :				
			if ( $_SESSION['login']=="admin" ) {
			if(!file_exists ("halaman/home.php")) die ("Empty Main Page!"); 
			include "halaman/home.php";	
			}elseif ( $_SESSION['login']=="se" ){
			include "halaman/home-user-se.php";	
			}else{
			include "halaman/home-user.php";
			}
		
		case 'Inventory' :				
			if(!file_exists ("halaman/inventory.php")) die ("Sorry Empty Page!"); 
			include "halaman/inventory.php";	break;			

		case 'Customer' :				
			if(!file_exists ("halaman/customer.php")) die ("Sorry Empty Page!"); 
			include "halaman/customer.php"; break;
			
		case 'History_Penjualan' :
		if ( $_SESSION['login']=="se" ) {
		include "halaman/his-jual-se.php"; break;
		}else{
		include "halaman/his-jual.php"; break;
		}
		case 'History_Pembelian':
			if (!file_exists("halaman/his-beli.php")) die("Sorry Empty Page!");
				include "halaman/his-beli.php";break;	
		case 'Logout' :				
			if(!file_exists ("halaman/login_out.php")) die ("Sorry Empty Page!"); 
			include "halaman/login_out.php"; break;

		case 'Sales Order' :				
			if(!file_exists ("halaman/salesorder.php")) die ("Sorry Empty Page!"); 
			include "halaman/salesorder.php"; break;	
		case 'Data_SalesOrder' :				
			if(!file_exists ("halaman/his-so.php")) die ("Sorry Empty Page!"); 
			include "halaman/his-so.php"; break;	
							
		default:
			if ( $_SESSION['login']=="admin" ) {
			if(!file_exists ("halaman/home.php")) die ("Empty Main Page!"); 
			include "halaman/home.php";	
			}elseif ( $_SESSION['login']=="se" ){
			include "halaman/home-user-se.php";	
			}else{
			include "halaman/home-user.php";
			}			
		break;
	}
}
else {
	// Jika tidak mendapatkan variabel URL : ?page
			if ( $_SESSION['login']=="admin" ) {
			if(!file_exists ("halaman/home.php")) die ("Empty Main Page!"); 
			include "halaman/home.php";	
			}elseif ( $_SESSION['login']=="se" ){
			include "halaman/home-user-se.php";	
			}else{
			include "halaman/home-user.php";
			}
	
}
?>