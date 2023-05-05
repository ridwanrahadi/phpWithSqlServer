<?php $bulan = date('m');

$tahun = date('Y');
$user = $_SESSION['username'];
$sql = "SELECT * from tblSalesPerson where KDSALES='$user'";
$stmt = sqlsrv_query($conn, $sql) or die("Query salah:" . sqlsrv_error());
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $NamaSales = $row['NMSALES'];
}


?>


<script src="js/Chart.js"></script>



<h2 align="center">USER AKTIF DENGAN KODE SALES = <?php echo $user . " - " . $NamaSales; ?></h2>
<div class="container">
    <div class="jumbotron">
        <canvas id="barchart" style="height: 300px; width: 100%;"></canvas>

        <?php
        $sql1 = "SELECT MONTH(Tgl) AS Bulan, SUM(SubTotal-JmlDisc1) AS Total
  FROM TblFak
  WHERE (KdSales = '$user') AND (YEAR(Tgl) = $tahun)
  GROUP BY MONTH(Tgl) ORDER BY MONTH(Tgl) ASC ";
        $stmtBulan  = sqlsrv_query($conn, $sql1) or die("Query  salah:" . sqlsrv_error());
        $sql2 = "SELECT MONTH(Tgl) AS Bulan, SUM(SubTotal-JmlDisc1) AS Total
  FROM TblFak
  WHERE (KdSales = '$user') AND (YEAR(Tgl) = $tahun)
  GROUP BY MONTH(Tgl) ORDER BY MONTH(Tgl) ASC ";
        $stmtTotal  = sqlsrv_query($conn, $sql2) or die("Query  salah:" . sqlsrv_error());
        ?>
        <script type="text/javascript">
        var ctx = document.getElementById("barchart").getContext("2d");
        var data = {
            labels: [<?php while ($p = sqlsrv_fetch_array($stmtBulan, SQLSRV_FETCH_ASSOC)) {
                                echo '"' . $p['Bulan'] . '",';
                            } ?>],
            datasets: [

                {
                    label: "Total Penjualan",
                    data: [<?php while ($p = sqlsrv_fetch_array($stmtTotal, SQLSRV_FETCH_ASSOC)) {
                                    echo '"' . $p['Total'] . '",';
                                } ?>],
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
                    xAxes: {
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
                    display: true
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

        <h3>PENCAPAIAN BULANAN INC PPN :</h3>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>BULAN</th>
                    <th>TOTAL INC PPN</th>
                </tr>

            </thead>
            <tbody>
                <?php
                $sql = "SELECT MONTH(Tgl) AS Bulan, SUM(SubTotal-JmlDisc1) AS Total
  FROM TblFak
  WHERE (KdSales = '$user') AND (YEAR(Tgl) = $tahun)
  GROUP BY MONTH(Tgl) ORDER BY MONTH(Tgl) ASC ";
                $stmt  = sqlsrv_query($conn, $sql) or die("Query  salah:" . sqlsrv_error());
                while ($kolomData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
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