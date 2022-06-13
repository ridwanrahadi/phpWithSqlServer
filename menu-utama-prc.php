<?php 
include 'controller/inc.connection.php';
// mengaktifkan session
session_start();
 $username_login=$_SESSION['username'];
                    $Qry = "SELECT * from tblpengguna where username='".$username_login."'" ;
                                    $hasil  = mssql_query($Qry,$koneksidb) or die ("Query  salah:".mysql_error());
                                    $data = mssql_fetch_array($hasil);
                                    $DivisiLogin = $data['Divisi'];
?>
<!doctype html>
<html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <!-- Latest compiled and minified CSS -->
       <style>
.blink {
  animation: blink-animation 1s steps(5, start) infinite;
  -webkit-animation: blink-animation 1s steps(5, start) infinite;
}
@keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
@-webkit-keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
</style>
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
      <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

        <title>PT. Masuya Graha Trikencana</title>
        <link rel="stylesheet" type="text/css" href="style.css">
      </head>
      <body>
        <div class="container">
            <div id="header">
              <br>
                 <img src="asset/masuya.png" alt="" class="img-circle">
            </div>
            
        </div>
        </div>
        <div class="container">
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Masuya Bandung</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                      <li><a href="menu-utama-prc.php?page=home" target="_self">Home <span class="sr-only">(current)</span></a></li>
                      <li><a href="menu-utama-prc.php?page=Inventory" target="_self">Inventory</a></li>
                      <li><a href="menu-utama-prc.php?page=Customer" target="_self">Customer</a></li>
                      <li><a href="menu-utama-prc.php?page=History_Penjualan" target="_self">History Penjualan</a></li>
                      <li><a href="menu-utama-prc.php?page=History_Pembelian" target="_self">History Pembelian</a></li>
                      <li><a href="menu-utama-prc.php?page=Data_SalesOrder" target="_self">Data SO</a></li>

                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                  	 
                     <li><a href="menu-utama.php?page=Sales Order" target="_self">SALES ORDER</a></li>
                    <li><a href="logout.php">Logout</a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>          
        </div>
           
        <div class="table-responsive"> 
           <?php include "buka_file.php";?>
        </div>
         
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script type="text/javascript" src="controller/jQuery.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
        
      </body>
</html>