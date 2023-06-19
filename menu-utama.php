<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
include 'controller/inc.connection.php';
// mengaktifkan session
session_start();
$username_login = $_SESSION['username'];
$sql = "SELECT * from tblpengguna where username='" . $username_login . "'";
$stmt  = sqlsrv_query($conn, $sql) or die(print_r(sqlsrv_errors(), true));
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $DivisiLogin = $row['Divisi'];
    $LevelLogin = $row['Level'];
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="DataTables/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <title>PT. Masuya Graha Trikencana</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div class="container">
        <div id="header">
            <br>
            <img src="asset/masuya.png" alt="" class="img-circle">
        </div>

    </div>
    </div>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Masuya Bandung</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="menu-utama.php?page=home" target="_self">Home <span
                                    class="sr-only">(current)</span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Inventory<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="menu-utama.php?page=Inventory"
                                        target="_self">Item</a></li>
                                <li><a class="dropdown-item" href="menu-utama.php?page=InventoryExpired"
                                        target="_self">Expired</a></li>
                            </ul>
                        </li>
                        <li><a href="menu-utama.php?page=Customer" target="_self">Customer</a></li>
                        <li><a href="menu-utama.php?page=ListInv" target="_self">Invoice List</a></li>
                        <li><a href="menu-utama.php?page=History_Penjualan" target="_self">History Penjualan</a></li>
                        <li><a href="menu-utama.php?page=Data_SalesOrder" target="_self">Data SO</a></li>
                        <?php //<li><a href="menu-utama.php?page=pengiriman" target="_self">Pengiriman</a></li>
                        ?>

                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                        <li><a href="http://masuya.ddnsfree.com:8080/end" target="_self">SALES ORDER</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>

    <div class="table-responsive">
        <?php include "buka_file.php"; ?>
    </div>
    <script>
    $(document).ready(function() {

        $(document).ready(function() {
            $('#example').DataTable({
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                columnDefs: [{
                    className: 'dtr-control',
                    orderable: false,
                    targets: 0
                }],
                order: [2, 'desc']
            });
        });
        $(document).ready(function() {
            $('#tabelSO').DataTable({
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                columnDefs: [{
                    className: 'dtr-control',
                    orderable: false,
                    targets: 0
                }]

            });
        });
        $(document).ready(function() {
            $('#tabelinventory').DataTable({
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                columnDefs: [{
                    className: 'dtr-control',
                    orderable: false,
                    targets: 0
                }]

            });
        });



        $('#example3').DataTable({
            "scrollY": 400,
            "scrollX": true,
            "order": [
                [0, "desc"]
            ]
        });
        $('#tabelinventory2').DataTable({
            "scrollY": 400,
            "scrollX": true,
            "order": [
                [0, "asc"]
            ]
        });

        $("#txtkodebrg").select2({
            ajax: {
                url: "controller/proses_isibarang.php",
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
        $("#txtcari2").select2({
            ajax: {
                url: "controller/proses_isicust.php",
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
    });

    function reset_customer_select2() {
        $('#txtcari2').val(null).trigger('change');
        $('#txtcari1').val(null).trigger('change');
    }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->



</body>

</html>