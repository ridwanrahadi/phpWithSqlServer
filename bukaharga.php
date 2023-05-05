<?php
include 'inc.connection.php';
error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="DataTables/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <title>Buka Harga</title>
</head>

<body>
    <br>
    <form class="inner-login" method="post">
        <div class="container">
            <div class="panel panel-primary">
                <div align="center" class="panel-heading">Form Buka Harga</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Barang</label>
                        <select name="item" style='width: 250px;' id="item">
                            <option value='0'>- Search item -</option>
                        </select>
                    </div>
                    <button type="submit" name="btnopen" class="btn btn-primary">Open</button>
                    <button type="submit" name="btnclose" class="btn btn-default">Close</button>
                </div>
            </div>
        </div>
    </form>
    <?php
    $kdbrg = $_POST['item'];
    if ($kdbrg != "0") {
        if (isset($_POST['btnopen'])) {
            $queryopen = "update tblIvmst set NonInventory=1 where Kdbrg='" . $kdbrg . "'";
            sqlsrv_query($conn, $queryopen) or die(print_r(sqlsrv_errors(), true));
            echo "<meta http-equiv='refresh' content='0; url='>";
            echo "<script>alert('Bypass berhasil! kode barang : {$kdbrg}');</script>";
        }
        if (isset($_POST['btnclose'])) {
            $queryopen = "update tblIvmst set NonInventory=0 where Kdbrg='" . $kdbrg . "'";
            sqlsrv_query($conn, $queryopen) or die(print_r(sqlsrv_errors(), true));
            echo "<meta http-equiv='refresh' content='0; url='>";
            echo "<script>alert('Tutup Bypass berhasil! kode barang : {$kdbrg}');</script>";
        }
    }
    ?>
    <?= $result; ?>

    <div class="container">

        <table id="tabel" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT Kdbrg,NmBrg from TblivMst where NonInventory=1";
                $getdataInventory = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
                while ($kolomData = sqlsrv_fetch_array($getdataInventory, SQLSRV_FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $kolomData['Kdbrg']; ?></td>
                    <td><?= $kolomData['NmBrg']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script>
    $("#item").select2({
        ajax: {
            url: "proses_isibarang.php",
            type: "post",
            cache: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    $('#tabel').DataTable({
        "scrollY": 400,
        "scrollX": true,
        "order": [
            [0, "asc"]
        ]
    });
    </script>
</body>

</html>