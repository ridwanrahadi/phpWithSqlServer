<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
include "inc.connection.php";
?>

  	<?php 
            $barang = $_POST['barang'];
            $customer = $_POST['customer'];
						$query3  = "SELECT TOP 1 TblFak.NoBukti,TblFak.JnsTrans,TblFak.KdCust, TblFakDtl.KdBrg, TblFakDtl.Hrg,TblFakDtl.PrsDisc,TblFakDtl.PrsDisc2,TblFakDtl.PrsDisc3
	  			 	 FROM TblFak INNER JOIN TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti WHERE KdBrg = '$barang' AND JnsTrans='JL' AND KdCust='$customer' ORDER BY TblFak.NoBukti DESC";
						$hasil3  = sqlsrv_query($conn,$query3) or die ("Query  salah:".sqlsrv_error());
						$jual = sqlsrv_fetch_array($hasil3);
						echo number_format($jual['Hrg']);
  	?>
  	
 			
 		 

 