<?php
include 'inc.connection.php';

if (!isset($_POST['searchTerm'])) {
  $query = "SELECT TOP 5 KdCust,NmCust FROM tblCustomer";
  $hasil  = sqlsrv_query($conn, $query) or die("Query  salah:" . sqlsrv_error());
} else {
  $search = $_POST['searchTerm'];
  $query = "SELECT  TOP 20 KdCust,NmCust FROM tblCustomer where KdCust like '%" . $search . "%' OR NmCust like '%" . $search . "%' ORDER BY NmCust ASC";
  $hasil  = sqlsrv_query($conn, $query) or die("Query  salah:" . sqlsrv_error());
}

$data = array();
while ($row = sqlsrv_fetch_array($hasil)) {
  $data[] = array("id" => $row['KdCust'], "text" => $row['KdCust'] . " - " . $row['NmCust']);
}
echo json_encode($data);