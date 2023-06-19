<?php include "../controller/inc.connection.php";  ?>

<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<?php
$mySql = "SELECT * from tblCustomer Where KdCust ='" . $_POST['idx'] . "'";
$params = array();
$options =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$myQry  = sqlsrv_query($conn, $mySql, $params, $options) or die(print_r(sqlsrv_errors(), true));
$cek = sqlsrv_num_rows($myQry);
$kolomData = sqlsrv_fetch_array($myQry);


?>

<div class="form-group">
    <label>Kode Customer :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['KdCust']; ?>" readonly="">
</div>
<div class="form-group">
    <label>Customer :</label>
    <input type="form-text" class="form-control" value="<?php echo $kolomData['NmCust']; ?>" readonly="">
</div>
<div class="form-group">
    <label>Kredit Limit :</label>
    <input type="form-text" class="form-control" value="<?php echo number_format($kolomData['KreditLimit'], 2); ?>"
        readonly="">
</div>
<div class="form-group">
    <label>Saldo :</label>
    <input type="form-text" class="form-control" value="<?php echo number_format($kolomData['Saldo'], 2); ?>"
        readonly="">
</div>
<label>Set KreditLimit :</label>
<input type="form-text" value="<?php echo number_format($kolomData['KreditLimit'], 2); ?>" class=" form-control"
    name="kredit" placeholder="Input nominal kredit limit">
<div class="text-right">
    <input type="checkbox" name="whitelist" <?php if ($kolomData['Whitelist'] == 1) {
                                                echo "checked";
                                            }  ?> /> White list
    <input type="checkbox" name="proteklimit" <?php if ($kolomData['ProtekLimit'] == 1) {
                                                    echo "checked";
                                                }  ?> /> Black list
</div>


<div class="modal-footer">
    <input type="hidden" name="id_cust" value="<?php echo $_POST['idx']; ?>">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-default btn-success" type="submit" name="btnupdate" value="Submit">Update</button>
</div>