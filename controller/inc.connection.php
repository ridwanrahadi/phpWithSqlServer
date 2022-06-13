<?php
// Variabel koneksi
$serverName = "localhost";
$connectionInfo = array( "Database"=>"MGTBDG2020", "UID"=>"sa", "PWD"=>"");
$conn = sqlsrv_connect( $serverName, $connectionInfo );
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}
?>