
               <?php $hari=date('d/M/y'); 
                    $bulan=date('m'); 
                    $tahun=date('Y'); 
                    $username_login=$_SESSION['username'];
                    $sql = "SELECT * from tblpengguna where username='".$username_login."'" ;
                    $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                      $DivisiLogin = $row['Divisi'];
                      }
                                   
                     ?>
                     <script src="js/Chart.js"></script>

                
                <div class="container" >
                    <div class="main-content">
                           
                            <div class="jumbotron jumbotron-fluid">
                              <canvas id="barchart" style="height: 300px; width: 100%;"></canvas>
                            </div>
                            <h3>PENJUALAN BULAN <?php echo $bulan; ?> TAHUN <?php echo $tahun; ?></h3>
                            <div class="jumbotron">
                              <canvas id="piechart2" style="height: 300px; width: 100%;"></canvas>
    
 <?php 
 if ($DivisiLogin == 'admin') {
   # code...
  $sql1="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total
                                    FROM TblFak
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl)
                                    HAVING (YEAR(TblFak.Tgl) = '".$tahun."')
                                    ORDER BY MONTH(TblFak.Tgl) ASC";
  $stmtBulan = sqlsrv_query($conn,$sql1) or die ("Query  salah:".sqlsrv_error());
  $sql2="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total
                                    FROM TblFak
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl)
                                    HAVING (YEAR(TblFak.Tgl) = '".$tahun."')
                                    ORDER BY MONTH(TblFak.Tgl) ASC";
  $stmtTotal = sqlsrv_query($conn,$sql2) or die ("Query  salah:".sqlsrv_error());
 }else{

  $sql1="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total,tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl),tblSalesPerson.DIVISI
                                    HAVING (YEAR(TblFak.Tgl) = '".$tahun."') AND (tblSalesPerson.DIVISI = '".$DivisiLogin."')
                                    ORDER BY MONTH(TblFak.Tgl) ASC";
  $stmtBulan = sqlsrv_query($conn,$sql1) or die ("Query  salah:".sqlsrv_error());
  $sql2="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total,tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl),tblSalesPerson.DIVISI
                                    HAVING (YEAR(TblFak.Tgl) = '".$tahun."') AND (tblSalesPerson.DIVISI = '".$DivisiLogin."')
                                    ORDER BY MONTH(TblFak.Tgl) ASC";
  $stmtTotal = sqlsrv_query($conn,$sql2) or die ("Query  salah:".sqlsrv_error());



 }
  
   ?>
 <script  type="text/javascript">
   var ctx = document.getElementById("barchart").getContext("2d");
  var data = {
            labels: [<?php while ($p = sqlsrv_fetch_array( $stmtBulan, SQLSRV_FETCH_ASSOC) ) { echo '"' . $p['Bulan'] . '",';}?>],
            datasets: [
          
            {
              label: "Total Penjualan",
              data: [<?php while ($p = sqlsrv_fetch_array( $stmtTotal, SQLSRV_FETCH_ASSOC) ) { echo '"' . $p['Total'] . '",';}?>],
               backgroundColor: [
                '#29B0D0',
                '#2A516E',
                '#F07124',
                '#CBE0E3',
                '#979193',
                '#AB9133',
                '#879114',
                '#28A193',
                '#E1D82A',
                '#F65937',
                '#F637BC',
                '#5EDD5E'
                
               ], 
             
            }
            ]
            };

  var myDoughnutChart = new Chart(ctx, {
                  type: 'bar',
                  data: data,
                  options: {
                  responsive: true,
                  legend: {
                    display: false,
                  },
                  title: {
                    display: true,
                    text: 'Penjualan Per Tahun <?php echo $tahun ?>',
                    fontFamily: "calibri",
                    fontWeight: "normal"
                  },
                  animation: {
                    animateScale: true,
                    animateRotate: true
        },
      }
              });
</script>
<?php 
  if ($DivisiLogin == 'admin') {
  # code...
   $mySql="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total, tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), tblSalesPerson.DIVISI
                                    HAVING (MONTH(TblFak.Tgl) = '".$bulan."') AND (YEAR(TblFak.Tgl) = '".$tahun."')";
  $DIVISI = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
  $mySql2="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total, tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), tblSalesPerson.DIVISI
                                    HAVING (MONTH(TblFak.Tgl) = '".$bulan."') AND (YEAR(TblFak.Tgl) = '".$tahun."')";
  $Total = sqlsrv_query($conn,$mySql2) or die ("Query  salah:".sqlsrv_error());
}else{
  $mySql="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total, tblSalesPerson.DIVISI,tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), tblSalesPerson.DIVISI,tblSalesPerson.DIVISI
                                    HAVING (MONTH(TblFak.Tgl) = '".$bulan."') AND (YEAR(TblFak.Tgl) = '".$tahun."') AND (tblSalesPerson.DIVISI = '".$DivisiLogin."')";
  $DIVISI = sqlsrv_query($conn,$mySql) or die ("Query  salah:".sqlsrv_error());
  $mySql2="SELECT MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total, tblSalesPerson.DIVISI,tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), tblSalesPerson.DIVISI,tblSalesPerson.DIVISI
                                    HAVING (MONTH(TblFak.Tgl) = '".$bulan."') AND (YEAR(TblFak.Tgl) = '".$tahun."') AND (tblSalesPerson.DIVISI = '".$DivisiLogin."')";
  $Total = sqlsrv_query($conn,$mySql2) or die ("Query  salah:".sqlsrv_error());
   
}
?>
 <script  type="text/javascript">
   var ctx = document.getElementById("piechart2").getContext("2d");
  var data2 = {
            labels: [<?php while ($p = sqlsrv_fetch_array( $DIVISI, SQLSRV_FETCH_ASSOC) ) { echo '"' . $p['DIVISI'] . '",';}?>],
            datasets: [
          
            {
              label: "Total Penjualan",
              data: [<?php while ($p = sqlsrv_fetch_array( $Total, SQLSRV_FETCH_ASSOC) ) { echo '"' . $p['Total'] . '",';}?>],
               backgroundColor: [
               '#FF5733',
                '#C5E1A5',
                '#80DEEA',
                '#FFFF99',
                '#51BE18'
               ], 
             
            }
            ]
            };

  var myDoughnutChart = new Chart(ctx, {
                  type: 'doughnut',
                  data: data2,
                  options: {
                  responsive: true,
                  legend: {
                    position: 'top',
                  },
                  title: {
                    display: true,
                    text: 'Penjualan per DIVISI Sales',
                    fontFamily: "calibri",
                    fontWeight: "normal"
                  },
                  animation: {
                    animateScale: true,
                    animateRotate: true
        },
      }
              });
</script>
</div>
                      <table  class="table table-striped">
                          <thead>
                            <th ><strong>NO</strong></th>
                            <th ><strong>KODE SALES</strong></th>
                            <th ><strong>NAMA SALES</strong></th>
                            <th ><strong>DIVISI</strong></th>
                            <th ><strong>TOTAL PENJUALAN EXC PPN</strong></th>      
                          </thead>
                              <tbody>
                                   <?php
                                    

                                    if ($DivisiLogin == 'admin') {
                                      # code...
                                      $nomor = 1;
                                      $sql  = "SELECT TblFak.KdSales, MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total, tblSalesPerson.NMSALES,tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY TblFak.KdSales, MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), tblSalesPerson.NMSALES,tblSalesPerson.DIVISI
                                    HAVING (MONTH(Tgl) = '".$bulan."') AND (YEAR(Tgl) = '".$tahun."') ORDER BY Total DESC";
                                     $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                                    while ($kolomData = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                    ?>
                                    <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td style="text-align:center;"><?php echo $kolomData['KdSales'];?></td>
                                    <td><?php echo $kolomData['NMSALES'];?></td>
                                    <td><?php echo $kolomData['DIVISI'];?></td>
                                    <td align="right"><?php echo number_format($kolomData['Total']);?></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                    <th colspan="4">JUMLAH</th>
                                    <th style="text-align:right"><?php 
                                    $sql = "SELECT SUM(TblFak.SubTotal - TblFak.Discount) AS Jml_total, YEAR(TblFak.Tgl) AS Tahun, MONTH(TblFak.Tgl) AS bulan
                                    FROM TblFak
                                    GROUP BY YEAR(TblFak.Tgl), MONTH(TblFak.Tgl)
                                    HAVING (YEAR(TblFak.Tgl) = '".$tahun."') AND (MONTH(TblFak.Tgl) = '".$bulan."')" ;
                                    $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                                    $data = sqlsrv_fetch_array($stmt);
                                    echo "<b>" . number_format($data['Jml_total']) . " </b>";
                                    }else{
                                    
                                       $nomor = 1;
                                      $sql  = "SELECT TblFak.KdSales, MONTH(TblFak.Tgl) AS Bulan, YEAR(TblFak.Tgl) AS Tahun, SUM(TblFak.SubTotal-TblFak.Discount) AS Total, tblSalesPerson.NMSALES,tblSalesPerson.DIVISI,tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY TblFak.KdSales, MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), tblSalesPerson.NMSALES,tblSalesPerson.DIVISI,tblSalesPerson.DIVISI
                                    HAVING (MONTH(Tgl) = '".$bulan."') AND (YEAR(Tgl) = '".$tahun."') AND (tblSalesPerson.DIVISI = '".$DivisiLogin."') ORDER BY Total DESC";
                                    $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                                    while ($kolomData = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                    ?>
                                    <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td style="text-align:center;"><?php echo $kolomData['KdSales'];?></td>
                                    <td><?php echo $kolomData['NMSALES'];?></td>
                                    <td><?php echo $kolomData['DIVISI'];?></td>
                                    <td align="right"><?php echo number_format($kolomData['Total']);?></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                    <th colspan="4">JUMLAH</th>
                                    <th style="text-align:right"><?php 
                                    $sql = "SELECT SUM(TblFak.SubTotal - TblFak.Discount) AS Jml_total, YEAR(TblFak.Tgl) AS Tahun, MONTH(TblFak.Tgl) AS bulan,tblSalesPerson.DIVISI
                                    FROM TblFak INNER JOIN
                                    tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                    GROUP BY YEAR(TblFak.Tgl), MONTH(TblFak.Tgl),tblSalesPerson.DIVISI
                                    HAVING      (YEAR(TblFak.Tgl) = '".$tahun."') AND (MONTH(TblFak.Tgl) = '".$bulan."') AND (tblSalesPerson.DIVISI = '".$DivisiLogin."')" ;
                                    $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                                    $data = sqlsrv_fetch_array($stmt);
                                    echo "<b>" . number_format($data['Jml_total']) . " </b>";
                                    }
                                   
                                    ?> </th>
                                    </tr>
                              </tbody>
                      </table>
                    </div>
                </div>
              
             <div class="container" >
                    <div class="main-content">
                            <h2>PER TYPE PRODUK</h2>
                      <table  class="table table-striped">
                          <thead>
                               <th ><strong>NO</strong></th>
                               <th ><strong>TYPE BARANG</strong></th>
                               <th ><strong>TOTAL</strong></th> 
                          </thead>
                              <tbody>
                                  <?php
                                  if ($DivisiLogin == 'admin') {
                                    # code...
                                        $nomor = 1;
                                        $sql  = "SELECT TblIvType.NmType, MONTH(TblFak.Tgl) AS bulan, YEAR(TblFak.Tgl) AS tahun, SUM(CAST(dbo.TblFakDtl.Jumlah * (1 - dbo.TblFak.PrsDisc1 / 100) AS DECIMAL(14, 2))) AS Total
                                        FROM TblFak INNER JOIN
                                        TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti INNER JOIN
                                        tblIvMst ON TblFakDtl.KdBrg = tblIvMst.KdBrg INNER JOIN
                                        TblIvType ON tblIvMst.Type = TblIvType.KdType
                                        GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), TblIvType.NmType
                                        HAVING (MONTH(TblFak.Tgl) = '".$bulan."') AND (YEAR(TblFak.Tgl) = '".$tahun."') ORDER BY Total DESC";
                                         $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                                        while ($kolomData = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                              
                            
                            ?>
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td><?php echo $kolomData['NmType'];?></td>
                                <td align="right"><?php echo number_format($kolomData['Total']);?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th colspan="2">JUMLAH</th>
                                <th style="text-align:right"><?php 
                            $sql = "SELECT     SUM(SubTotal-Discount) AS Jml_total, MONTH(Tgl) AS Bulan, YEAR(Tgl) AS Tahun
                                        FROM TblFak
                                        GROUP BY MONTH(Tgl), YEAR(Tgl)
                                        HAVING  (MONTH(Tgl) = '".$bulan."') AND (YEAR(Tgl) = '".$tahun."') " ;
                            $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                            $data = sqlsrv_fetch_array($stmt);
                            echo "<b>" . number_format($data['Jml_total']) . " </b>";
                            }else{
                                 $nomor = 1;
                                        $sql  = "SELECT TblIvType.NmType, MONTH(TblFak.Tgl) AS bulan, YEAR(TblFak.Tgl) AS tahun, SUM(CAST(dbo.TblFakDtl.Jumlah * (1 - dbo.TblFak.PrsDisc1 / 100) AS DECIMAL(14, 2))) AS Total,tblSalesPerson.divisi,tblSalesPerson.DIVISI
                                        FROM TblFak INNER JOIN
                                        TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti INNER JOIN
                                        tblIvMst ON TblFakDtl.KdBrg = tblIvMst.KdBrg INNER JOIN
                                        TblIvType ON tblIvMst.Type = TblIvType.KdType INNER JOIN
                                        tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                        GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl), TblIvType.NmType,tblSalesPerson.divisi,tblSalesPerson.DIVISI
                                        HAVING (MONTH(TblFak.Tgl) = '".$bulan."') AND (YEAR(TblFak.Tgl) = '".$tahun."') AND (tblSalesPerson.DIVISI='".$DivisiLogin."')ORDER BY Total DESC";
                                        $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                                        while ($kolomData = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                              
                            
                            ?>
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td><?php echo $kolomData['NmType'];?></td>
                                <td align="right"><?php echo number_format($kolomData['Total']);?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th colspan="2">JUMLAH</th>
                                <th style="text-align:right"><?php 
                                         $sql = "SELECT MONTH(TblFak.Tgl) AS bulan, YEAR(TblFak.Tgl) AS tahun, SUM(CAST(dbo.TblFakDtl.Jumlah * (1 - dbo.TblFak.PrsDisc1 / 100) AS DECIMAL(14, 2))) AS Jml_total,tblSalesPerson.DIVISI
                                        FROM TblFak INNER JOIN
                                        TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti INNER JOIN
                                        tblIvMst ON TblFakDtl.KdBrg = tblIvMst.KdBrg INNER JOIN
                                        TblIvType ON tblIvMst.Type = TblIvType.KdType INNER JOIN
                                        tblSalesPerson ON TblFak.KdSales = tblSalesPerson.KDSALES
                                        GROUP BY MONTH(TblFak.Tgl), YEAR(TblFak.Tgl),tblSalesPerson.DIVISI
                                        HAVING (MONTH(TblFak.Tgl) = '".$bulan."') AND (YEAR(TblFak.Tgl) = '".$tahun."') AND (tblSalesPerson.DIVISI='".$DivisiLogin."')";
                            $stmt  = sqlsrv_query($conn,$sql) or die ("Query  salah:".sqlsrv_error());
                            $data = sqlsrv_fetch_array($stmt);
                            echo "<b>" . number_format($data['Jml_total']) . " </b>";


                            }

                            ?> </th>
                                </tr>
                              </tbody>
                      </table>
                    </div>
                </div>
           
        