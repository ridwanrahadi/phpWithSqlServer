<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<?php include_once "controler.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sales Order</title>
	<!-- ... -->
	

	 <script>

   $(document).ready(function(){
        $('#modal-cek').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
             $.ajax({
                type : 'post',
                url : 'controller/proses_hargaterakhir.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });


  $(document).ready(function()
  {
   
$("#txtkodebrg").change(function()
    {
      var txtkodebrg = $("#txtkodebrg").val();
      $.ajax({
        url:"controller/proses_stok.php",
        data:"txtkodebrg=" + txtkodebrg,
        success:function(data)
        {
          $("#stok").html(data);
        }
      });
    });
$("#txtkodebrg").change(function()
    {
      var txtkodebrg = $("#txtkodebrg").val();
      $.ajax({
        url:"controller/proses_satuan.php",
        data:"txtkodebrg=" + txtkodebrg,
        success:function(data)
        {
          $("#cmbSatuan").html(data);
        }
      });
    });
$("#txtkodebrg").change(function()
    {
      var txtkodebrg = $("#txtkodebrg").val();
      $.ajax({
        url:"controller/proses_harga.php",
        data:"txtkodebrg=" + txtkodebrg,
        success:function(data)
        {
          $("#harga").html(data);
        }
      });
    });
	$("#txtkodebrg").change(function()
    {
      var txtkodebrg = $("#txtkodebrg").val();
      $.ajax({
        url:"controller/proses_statusppn.php",
        data:"txtkodebrg=" + txtkodebrg,
        success:function(data)
        {
          $("#statusppn").html(data);
        }
      });
    });
$("#txtkodebrg").change(function()
    {
      var txtkodebrg = $("#txtkodebrg").val();
      var txtKdCust = $("#txtKdCust").val();
      $.ajax({
        method: "post",
        url:"controller/proses_hargaterakhir.php",
        data: {barang:txtkodebrg, customer:txtKdCust}
      })
        .done(function(data){
        	 $("#harga2").html(data);
        	});
      
    });
  });
  </script>
	
	
	<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
	<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h3 align="center">Sales Order</h3>
			<form action="" method="post" class="order">

				<!-- DATA ORDER -->

				<div class="panel panel-default">

					<div align="left" class="panel-heading">DATA ORDER</div>
					<div class="panel-body">
						<div class="form-group">
							<input type="hidden"  class="form-control" name="txtNomor" value="<?php echo "-AUTO-"; ?>" readonly="">
						</div>

						<div class="form-group">
							
							<input type="hidden" class="datepicker" name="tanggal" id="date" value="<?php echo $tglTransaksi; ?>" readonly="">      
						</div>

						<div class="input-group">
  				
							<input type="form-text" class="form-control" name="txtKdCust" style="text-transform:uppercase" id="txtKdCust" value="<?php echo $KodeCust = $_SESSION['customer']; ?>" placeholder="Input Kode Customer" required="required" autofocus="autofocus">
							<span class="input-group-btn">
								<button name="btnCek" class="btn btn-default" type="submit">Go!</button>
							</span>
						</div>
						<?php
						$query1  = "SELECT  * FROM tblCustomer 
						Where KdCust = '".$kdcust."'";
						$hasil1  = sqlsrv_query($conn, $query1) or die("Query  salah:" . sqlsrv_error());
						$datacustomer = sqlsrv_fetch_array($hasil1);
						?>
						<br>
						<?php if ($kdcust=="WALKIN" || $kdcust=="walkin" || $kdcust=="Walkin" || $kdcust=="BLIOL" || $kdcust=="bliol" || $kdcust=="Bliol") {
							# code...
							$readonly="";
						}else{
							$readonly="readonly";
						} ?>
						<div class="form-group">
							<label >Nama Customer</label>
							<input <?php echo $readonly; ?> type="form-text" class="form-control" name="txtnmcust" value="<?php if($kdcust=="WALKIN" || $kdcust=="walkin" || $kdcust=="Walkin" || $kdcust=="BLIOL" || $kdcust=="bliol" || $kdcust=="Bliol"){echo $Nmcust;}else{echo $datacustomer['NmCust'];}  ?>">
						</div>

						<div class="form-group">
							<label >Keterangan</label>
							<input type="form-text" class="form-control" name="txtKeterangan" value="<?php echo $Keterangan= $_SESSION['Keterangan']; ?>" placeholder="Keterangan">
						</div>
						<div class="form-group">
							<input type="<?php if($kdcust=="WALKIN" || $kdcust=="walkin" || $kdcust=="Walkin" || $kdcust=="BLIOL" || $kdcust=="bliol" || $kdcust=="Bliol"){echo "form-text";}else{echo "hidden";} ?>" class="form-control" name="txtNoKTP" value="<?php echo $KTP; ?>" placeholder="Nomor KTP">
						</div>
						<div class="form-group">
							<input type="<?php if($kdcust=="WALKIN" || $kdcust=="walkin" || $kdcust=="Walkin" || $kdcust=="BLIOL" || $kdcust=="bliol" || $kdcust=="Bliol"){echo "form-text";}else{echo "hidden";} ?>" class="form-control" name="txtAlamatkirim" value="<?php echo $Alamatkirim; ?>" placeholder="Alamat Kirim">
						</div>
						<div class="form-group">
							<label >Nomor PO</label>
							<input type="form-text" autocomplete="off" class="form-control" name="txtnoPO" value="<?php echo $NoPO = $_SESSION['NoPO']; ?>" placeholder="Nomor PO">
						</div>
						<div class="form-group">
							<label>Tanggal PO</label>
							<input type="form-text" class="datepicker" name="tanggalpo" id="date2" value="<?php echo $tglpo = $_SESSION['Tanggalpo']; ?>" readonly="" >      
						</div>

					</div>
				</div>


				<!-- ITEM ORDER -->
				<div class="panel panel-default">
					<div align="left" class="panel-heading">ITEM ORDER</div>
					<div class="panel-body">
					
						
						<br>
						<div class="input-group">
							<label >Item Barang : (input nama/kode barang yang mendekati)</label><br>
								<select name="txtkodebrg" style='width: 250px;' id="txtkodebrg">
										<option value='0'>- Search item -</option>
								</select>
								<br>
								<br>
								<label>Status PPN :</label>	
								<br>
								<select name="statusppn" style='width: 90px' id="statusppn" class="form-control">
								<option value="BLANK"></option>
								</select>							
						</div>
						<br>	
							<label>Stock :<i name="stok" id="stok"></i></label>
							<br>
							<label>Pricelist :<i name="harga" id="harga"></i></label>
							<br>
							<label>Harga terakhir :<i name="harga2" id="harga2"></i></label>
							<br></br>
						<table>
							<tr>
								<td>
									<label>Harga Sebelum PPN</label>
									<input type="form-text" class="form-control" name="txtHarga" value="<?php echo $dataHarga; ?>" placeholder="Input Harga">      
								</td>
								<td>

									<label>QTY</label>
									<input type="form-text"  style='width: 80px' class="form-control" name="txtJumlah" value="1" 
									onblur="if (value == '') {value = '1'}" 
									onfocus="if (value == '1') {value =''}">                                   
								</td>
								
							</tr>
							<tr>
								<td>
									<label>Satuan</label>
									<select name="cmbSatuan" style='width: 90px' id="cmbSatuan" class="form-control">
										<option value="BLANK">Satuan</option>
									</select>

								</td>
							</tr>

						</table>
						<br>
						<table>

							<label>Diskon</label>
							<tr>
								<td>
									1 <input type="form-text" class="form-control" name="txtdisk1"  value="0" 
									onblur="if (value == '') {value = '0'}" 
									onfocus="if (value == '0') {value =''}"/>
								</td>
								<td>
									2 <input type="form-text" class="form-control" name="txtdisk2"  value="0" 
									onblur="if (value == '') {value = '0'}" 
									onfocus="if (value == '0') {value =''}"/>
								</td>
								<td>
									3 <input type="form-text" class="form-control" name="txtdisk3"  value="0" 
									onblur="if (value == '') {value = '0'}" 
									onfocus="if (value == '0') {value =''}"/>
								</td>
							</tr>
						</table>
						<br>
						<br> 
						<!-- BUTTON ADD ITEM -->
						<button type="submit" name="btnPilih" class="btn btn-primary">Submit</button>

					</div>

				</div>
				<!-- BUTTON SIMPAN SALES ORDER -->     
				<div class="btn-group btn-group-justified" role="group" aria-label="...">

					<div class="btn-group" role="group">
						<button type="submit" name="btnSave" class="btn btn-success">Simpan Sales Order</button>

					</div>

				</div> 

			</div>
		</div>
		<!-- TABEL DAFTAR ITEM -->    
		<table id="example" class="display nowrap" style="width:100%">

			<thead>
			<?php 
					$query5  = "SELECT TOP 1  * FROM tmp_so 
					Where kd_user = '".$_SESSION['username']."'";
					$myQry  = sqlsrv_query($conn, $query5) or die("Query  salah:" . sqlsrv_error());
					while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
						$StatusPajak = $kolomData['status_ppn'];
					}
				?>
				<tr align="center"><h2>DAFTAR ITEM <?php echo $StatusPajak;?></h2></tr>
				<tr>
					<td ><b>No</b></td>
					<td ><b>Kode Barang </b></td>
					<td ><b>Nama Barang </b></td>
					<td ><b>Harga (Rp.) </b></td>
					<td ><b>Disk1</b></td>
					<td ><b>Disk2</b></td>
					<td ><b>Disk3</b></td>
					<td ><b>Qty</b></td>
					<td ><b>Satuan</b></td>
					<td ><b>Subtotal (Rp.) </b></td>
					<td ><b>Delete</b></td>
				</tr>
			</thead>

			<tbody>

				<?php
//  tabel menu 
				$tmpSql ="SELECT tmp_so.id, tmp_so.kd_user, tmp_so.item_barang, tblIvMst.NmBrg, tmp_so.harga, tmp_so.disk1, tmp_so.disk2, tmp_so.disk3, tmp_so.jumlah,tmp_so.satuan
				FROM tmp_so INNER JOIN
				tblIvMst ON tmp_so.item_barang = tblIvMst.KdBrg
				WHERE  kd_user='".$_SESSION['username']."'
				ORDER BY id";
				$tmpQry = sqlsrv_query($conn, $tmpSql) or die("Query  salah:" . sqlsrv_error());
				$total = 0; $qtyItem = 0; $nomor=0;
				while($tmpRow = sqlsrv_fetch_array($tmpQry, SQLSRV_FETCH_ASSOC)) {
					$id       = $tmpRow['id'];
					$qtyItem= $qtyItem + $tmpRow['jumlah'];
					$nomor++;
					$disk1 = ($tmpRow['jumlah']*$tmpRow['harga'])*($tmpRow['disk1'])/100;
					$disk2 = ($tmpRow['jumlah']*$tmpRow['harga']-$disk1)*($tmpRow['disk2'])/100;
					$disk3 = ($tmpRow['jumlah']*$tmpRow['harga']-$disk1-$disk2)*($tmpRow['disk3'])/100;
					$subTotal = ($tmpRow['jumlah'] * $tmpRow['harga']) - $disk1 - $disk2 - $disk3;
					$total    = $total + $subTotal;
					?>
					<tr>
						<td align="center"><?php echo $nomor; ?></td>
						<td><b><?php echo $tmpRow['item_barang']; ?></b></td>
						<td><b><?php echo $tmpRow['NmBrg']; ?></b></td>
						<td align="right"><?php echo number_format($tmpRow['harga'],2); ?></td>
						<td align="center"><?php echo $tmpRow['disk1']; ?></td>
						<td align="center"><?php echo $tmpRow['disk2']; ?></td>
						<td align="center"><?php echo $tmpRow['disk3']; ?></td>
						<td align="center"><?php echo $tmpRow['jumlah']; ?></td>
						<td align="center"><?php echo $tmpRow['satuan']; ?></td>
						<td align="right"><?php echo number_format($subTotal,2); ?></td>
						<td align="center" bgcolor="#FFFFCC"><a href="?page=Sales Order&Act=Delete&id=<?php echo $id; ?>" target="_self"><img src="image/hapus.gif"/></a></td>
					</tr>
					<?php 
				}?>
			</tbody>
			<tr>
				<td colspan="9" align="right"><b>Grand Total SO : </b></td>
				<td align="right"><b><?php echo number_format($total,2); ?></b></td>
				<td align="center">&nbsp;</td>
			</tr>
			<input name="GrandTotal" value="<?php echo (double) $total; ?>" size="12" maxlength="12" style="opacity: 0;"/>
		</form>


	</table>
	<script>
		$('#date').datepicker({
			format: 'mm-dd-yyyy',
			autoclose: true,
			todayHighlight: true, 
		});
	</script>
	<script>
		$('#date2').datepicker({
			format: 'mm-dd-yyyy',
			autoclose: true,
			todayHighlight: true, 
		});
	</script>
	
</body>
<div id="modal-cek" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cek Harga Terakhir</h4>
      </div>
      <div class="modal-body">
                <div class="hasil-data"></div>

        </div>
     </div>

  </div>
</div>
</html>




