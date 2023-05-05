<?php
// Variabel koneksi
$serverName = "192.168.254.1";
$connectionInfo = array( "Database"=>"MGT2019", "UID"=>"sa", "PWD"=>"Shield@1945");
$conn = sqlsrv_connect( $serverName, $connectionInfo );
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}
?>