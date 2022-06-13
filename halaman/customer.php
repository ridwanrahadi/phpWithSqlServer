<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<?php
$user=$_SESSION['username'];
$txtcari   = isset($_POST['txtcari']) ? $_POST['txtcari'] : '';
$txtcari1   = isset($_POST['txtcari1']) ? $_POST['txtcari1'] : '';
$txtcari2    = isset($_POST['txtcari2']) ? $_POST['txtcari2'] : '';
?>
<h3 align="center">CUSTOMER</h3>
<div class="container">
<div class="jumbotron">
  <form action="" method="post" onSubmit="return validasi()">
  
  <div class="form-group">
    <?php if ($LevelLogin == "admin") {
     # code...
    $data=$txtcari2;
   }else{
    $data=$user;
   } ?>
    <label>Kode Customer :</label>
    <input type="form-text" class="form-control" name="txtcari" id="txtcari" value="<?php echo $txtcari; ?>" placeholder="Kode Customer">
    <label>Nama Customer :</label>
    <input type="form-text" class="form-control" name="txtcari1" id="txtcari" value="<?php echo $txtcari1; ?>" placeholder="Nama Customer">
    <label>Kode Sales :</label>
    <input type="hidden" class="form-control" name="txtcari2" id="txtcari" value="" placeholder="Kode Sales">
    <small class="form-text text-muted">Input data dengan benar.</small>
  </div>
  <button type="submit" name="cari" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
                <div class="container">
                <table id="example" class="display nowrap" style="width:100%">
                  <thead>
                    <th >No</th> 
                    <th >Kode Cust</th>
                    <th >Nama Cust</th>
                     <th >Kode Sales</th>
                    <th >Alamat</th>
                    <th >Saldo Piutang</th>
                    <th >Koordinat</th>        
                  </thead>
                  <tbody>
                    <?php
                   
                      $nomor = 1;
                      $txtcari = $_POST['txtcari'];
                      $txtcari1 = $_POST['txtcari1'];
                      $txtcari2 = $_POST['txtcari2'];
                      if ($txtcari !='' && $txtcari2 !='') {
                      $mySql  = "SELECT  * 
                    FROM tblCustomer 
                    Where KdCust like '%".$txtcari."%' and KdSales = '".$txtcari2."' Order By KdCust ASC";
                   
                      $myQry  = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
                      }elseif ($txtcari1 !='' && $txtcari2 !='') {
                        $mySql  = "SELECT  * 
                    FROM tblCustomer 
                     Where NmCust like '%".$txtcari1."%' and KdSales = '".$txtcari2."' Order By KdCust ASC";
                      $myQry  = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
                      }elseif ($txtcari !='') {
                        $mySql  = "SELECT  * 
                    FROM tblCustomer 
                    Where KdCust like '%".$txtcari."%' Order By KdCust ASC";
                      $myQry  = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
                      }elseif ($txtcari1 !='') {
                        $mySql  = "SELECT  * 
                    FROM tblCustomer 
                    Where NmCust like '%".$txtcari1."%' Order By NmCust ASC";
                    $myQry  = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
                      }elseif ($txtcari2 !='') {
                    $mySql  = "SELECT  * 
                    FROM tblCustomer 
                    Where KdSales='".$txtcari2."' Order By KdCust ASC";
                  $myQry  = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
                      }else{
                      $mySql  = "SELECT TOP 10 * 
                      FROM tblCustomer where KdSales='$user' order By KdCust ASC";
                      
                      $myQry  = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());  
                      }

                
                      while ($kolomData = sqlsrv_fetch_array( $myQry, SQLSRV_FETCH_ASSOC) ) {

                    

                
                ?>
                
                <tr>
                  <td><?php echo $nomor++; ?></td>
                  <td><?php echo $kolomData['KdCust']; ?> </td>
                  <td><?php echo $kolomData['NmCust']; ?> </td>
                 <td><?php echo $kolomData['KdSales']; ?> </td>
                  <td><?php echo $kolomData['Alm1']; ?> </td>
                  <td style="text-align:right;"><?php echo number_format($kolomData['Saldo']); ?></td>
                  <td style="text-align:right;"><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $kolomData['Koordinat']; ?>"><?php echo $kolomData['Koordinat']; ?></a></td>
                </tr>
                <?php } ?>
                </tbody> 
              </table>
            </div>
                  </tbody>
                </table>

