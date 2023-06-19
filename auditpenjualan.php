<?php
include 'inc.connection.php';
error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap5/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    
    <title>Audit Penjualan</title>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <form class="inner-login" method="post">
                    <div class="container">
                        <div class="card shadow-sm bg-light my-3">
                            <div align="center" class="card-header small">Form pencarian by nomor bukti</div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control small" placeholder="Nomor JL" aria-label="Nomor JL" required="true" name="Nobukti" aria-describedby="button-addon2">
                                    <button class="btn btn-secondary small" type="submit" name="search">Search</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <!-- Content here -->
            <div align="center" class="col-lg-4">
                <img src="asset/masuya.png" class="mx-auto my-3" height="80">
            </div>
        </div>
        <div align="center">
            <p class="fs-4">Data Audit Penjualan</p>
        </div>
        <div></div>
        <table id="tabel" class="display nowrap small" width="100%">
            <thead>
                <tr>
                    <th>Nomor Bukti</th>
                    <th>Tgl</th>
                    <th>Kode Cust</th>
                    <th>Total</th>
                    <th>Kirim</th>
                    <th>Cetak</th>
                    <th>Kembali</th>
                    <th>CreateBy</th>
                    <th>CreateTime</th>
                    <th>UpdateBy</th>
                    <th>UpdateTime</th>
                    <th>StampPBBS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $NoBukti = $_POST['Nobukti'];
                if ($NoBukti != "") {
                    if (isset($_POST['search'])) {
                        $query = "select * from Audit_TblFak_2023 where NoBukti='" . $NoBukti . "'";
                        $getdataJL = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
                    }
                }
                if ($getdataJL) {
                    # code...
                    while ($kolomData = sqlsrv_fetch_array($getdataJL, SQLSRV_FETCH_ASSOC)) {
                ?>
                        <tr>
                            <td><?= $kolomData['NoBukti']; ?></td>
                            <td><?= $Date = $kolomData['Tgl']->format('d-m-Y'); ?></td>
                            <td><?= $kolomData['KdCust']; ?></td>
                            <td><?= number_format($kolomData['Total'], 2) ?></td>
                            <td><?= $kolomData['Kirim']; ?></td>
                            <td><?= $kolomData['Cetak']; ?></td>
                            <td><?= $kolomData['Kembali']; ?></td>
                            <td><?= $kolomData['CreateBy']; ?></td>
                            <td><?= $Date = $kolomData['CreateTime']->format('d-m-Y H:i:s'); ?></td>
                            <td><?= $kolomData['UpdateBy']; ?></td>
                            <td><?php if ($kolomData['UpdateTime'] == null) {
                                echo "";
                            } else {
                                # code...
                                echo $Date = $kolomData['UpdateTime']->format('d-m-Y H:i:s');
                            }
                             ?></td>
                            <td><?= $kolomData['StampPBBS']; ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>

    </div>
    <script src="bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#tabel').DataTable({
            "scrollY": 400,
            "scrollX": true,
            "order": [
                [8, "asc"]
            ]
        });
    </script>


</body>

</html>