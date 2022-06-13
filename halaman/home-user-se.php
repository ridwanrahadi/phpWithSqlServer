<?php $MONTH=date('m'); 
$tahun=date('Y');  
$user=$_SESSION['username'];
$Query = mssql_query ("SELECT * from tblSalesPerson where KDSALES='$user'");
$data = mssql_fetch_array($Query);
$NamaSales =$data['NMSALES'];
?>


<script src="js/Chart.js"></script>
  

                
<h2 align="center">DAIRY CHAMP DASHBOARD</h2>
 <div class="container">
<div class="jumbotron">
        <canvas id="barchart" style="height: 300px; width: 100%;"></canvas>
    
 <?php 
  $mySql="SELECT SUM(TblFak.Total) AS Total, TblFak.KdSales
  FROM TblFak INNER JOIN
  TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti INNER JOIN
  tblIvMst ON TblFakDtl.KdBrg = tblIvMst.KdBrg
  WHERE (YEAR(TblFak.Tgl) = $tahun) AND (tblIvMst.Type = 'd4') AND (MONTH(TblFak.Tgl) = $MONTH)
  GROUP BY tblIvMst.Type, TblFak.KdSales";
  $sales = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  $mySql2="SELECT SUM(TblFak.Total) AS Total, TblFak.KdSales
  FROM TblFak INNER JOIN
  TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti INNER JOIN
  tblIvMst ON TblFakDtl.KdBrg = tblIvMst.KdBrg
  WHERE (YEAR(TblFak.Tgl) = $tahun) AND (tblIvMst.Type = 'd4') AND (MONTH(TblFak.Tgl) = $MONTH)
  GROUP BY tblIvMst.Type, TblFak.KdSales";
  $Total = mssql_query($mySql2, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
   ?>
 <script  type="text/javascript">
   var ctx = document.getElementById("barchart").getContext("2d");
  var data = {
            labels:  [<?php while ($p = mssql_fetch_array($sales)) { echo '"' . $p['KdSales'] . '",';}?>],
            datasets: [
          
            {
              label: "Total Penjualan",
              data: [<?php while ($p = mssql_fetch_array($Total)) { echo '"' . $p['Total'] . '",';}?>],
               backgroundColor: [
               '#29B0D0',
                '#2A516E',
                '#F07124',
                '#29B0D0',
                '#2A516E',
                '#F07124',
                '#29B0D0',
                '#2A516E',
                '#F07124',
                '#29B0D0',
                '#2A516E',
                '#F07124',
                '#29B0D0',
                '#2A516E',
                '#F07124',
                '#29B0D0',
                '#2A516E',
                '#CBE0E3'
               ], 
              xAxes:{
   valueFormatString: 'decimal'
 }
             
            

            }
            ]
            };

  var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
            legend: {
              display: false
            },
            barValueSpacing: 15,
            scales: {
              yAxes: [{
                         
                         ticks: {
                         min: 0,
                  }
              }],
              xAxes: [{
                          
                          gridLines: {
                              color: "rgba(0, 0, 0, 0)",
                              
                          }

                      }]
              }
 
          }
        });
</script>

</div>
</div>

<div class="container">
<div class="jumbotron">
 
  <h3>PENCAPAIAN BULAN : <?php echo $MONTH; ?></h3>
  
  <table class="table table-striped">
    <thead >
      <tr >
        <th >KODE SALES</th>
        <th >TOTAL INC PPN</th>
      </tr>
      
    </thead>
    <tbody>
      <?php 
  $mySql="SELECT SUM(TblFak.Total) AS Total, TblFak.KdSales
FROM   TblFak INNER JOIN TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti INNER JOIN tblIvMst ON TblFakDtl.KdBrg = tblIvMst.KdBrg
WHERE (YEAR(TblFak.Tgl) = 2020) AND (tblIvMst.Type = 'd4') AND (MONTH(TblFak.Tgl) = 5)
GROUP BY tblIvMst.Type, TblFak.KdSales";
  $myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  while ($kolomData = mssql_fetch_array($myQry)) {
  ?>
  <tr>
    <td><?php echo $kolomData['KdSales']; ?></td>
    <td align="right"><?php echo number_format($kolomData['Total']); ?></td>
  </tr>
<?php } ?>

    </tbody>
  </table>
  

</div>
</div>

<div class="container">
<div class="jumbotron">
 
  <h3>PENCAPAIAN BULANAN INC PPN :</h3>
  
  <table class="table table-striped">
    <thead >
      <tr >
        <th >BULAN</th>
        <th >TOTAL INC PPN</th>
      </tr>
      
    </thead>
    <tbody>
      <?php 
  $mySql="SELECT SUM(TblFak.Total) AS Total, MONTH(tgl) as Bulan
FROM   TblFak INNER JOIN TblFakDtl ON TblFak.NoBukti = TblFakDtl.NoBukti INNER JOIN tblIvMst ON TblFakDtl.KdBrg = tblIvMst.KdBrg
WHERE (YEAR(TblFak.Tgl) = 2020) AND (tblIvMst.Type = 'd4')
GROUP BY MONTH(TblFak.Tgl)
ORDER BY MONTH(TblFak.Tgl)";
  $myQry = mssql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  while ($kolomData = mssql_fetch_array($myQry)) {
  ?>
  <tr>
    <td><?php echo $kolomData['Bulan']; ?></td>
    <td align="right"><?php echo number_format($kolomData['Total']); ?></td>
  </tr>
<?php } ?>

    </tbody>
  </table>
   
  <h3 align="center">SELAMAT BEKERJA &#129297</h3>

</div>
</div>
              
             
           
        