<?php
include 'inc.connection.php';

if(!isset($_POST['searchTerm'])){ 
  $query = "SELECT TOP 5 KdBrg,NmBrg FROM tblIvMst";
  $hasil  = sqlsrv_query($conn,$query) or die ("Query  salah:".sqlsrv_error());					
}else{ 
  $search = $_POST['searchTerm'];   
  $query = "SELECT  TOP 10 KdBrg,NmBrg FROM tblIvMst where NmBrg like '%".$search."%' OR KdBrg like '%".$search."%' and NonAktif='0' ORDER BY NmBrg ASC";
  $hasil  = sqlsrv_query($conn,$query) or die ("Query  salah:".sqlsrv_error());
} 

$data = array();
while ($row = sqlsrv_fetch_array($hasil)) {    
  $data[] = array("id"=>$row['KdBrg'], "text"=>$row['NmBrg']);
}
echo json_encode($data);