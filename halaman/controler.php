<?php
if ($_GET) {
	# HAPUS DAFTAR barang DI TMP
	if (isset($_GET['Act'])) {
		if (trim($_GET['Act']) == "Delete") {
			# Hapus Tmp jika datanya sudah dipindah
			$msSql = "DELETE FROM tmp_so WHERE id='" . $_GET['id'] . "' AND kd_user='" . $_SESSION['username'] . "'";
			$stmt = sqlsrv_query($conn, $msSql) or die(print_r(sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?page=Sales Order'>";
		echo "<script>alert('Delete item berhasil!');</script>";
	}


	// =========================================================================
	# TOMBOL CEK CUSTOMER DIKLIK
	if (isset($_POST['btnCek'])) {
		$pesanError = array();
		session_start();
		# Baca variabel
		$kdcust	= $_POST['txtKdCust'];
		$_SESSION['customer'] = $kdcust;
		# Pencarian data
		$query  = "SELECT  * FROM tblCustomer 
		Where KdCust = '" . $kdcust . "'";
		$params = array();
		$options =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		$hasil  = sqlsrv_query($conn, $query, $params, $options) or die(print_r(sqlsrv_errors(), true));
		$rows = sqlsrv_num_rows($hasil);

		if ($rows > 0) {
			// $datacustomer = sqlsrv_fetch_array($hasil);
		} else {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Kode customer tersebut tidak ditemukan !!!
						</div></div>';
		}

		# CEK BLOKIT DAN BLACKLIST
		$query2  = "SELECT  * FROM tblCustomer 
		Where KdCust = '" . $kdcust . "'";
		$myQry  = sqlsrv_query($conn, $query2) or die(print_r(sqlsrv_errors(), true));
		while ($kolomData = sqlsrv_fetch_array($myQry)) {
			if ($kolomData['ProtekLimit'] == '1') {
				$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Customer ini di BLACKLIST, hubungi akunting !!!
						</div></div>';
			}
			# CEK CUSTOMER HANDLE non aktif sementara
			if ($kolomData['Idcust'] == 'UMUM') {
			} elseif (strcasecmp($kolomData['KdSales'], $_SESSION['username'])) {
				$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
			 		  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			 		  <span class="sr-only">Error:</span>
			 		  Customer ini bukan kode sales anda !!!
			 			</div></div>';
			}


			#elseif ($kolomData['Whitelist']=='0' && $kolomData['Saldo']>0) {
			#	$pesanError[] = '<div class="alert alert-danger" role="alert">
			#			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			#			  <span class="sr-only">Error:</span>
			#			  CUSTOMER ini blockir transaksi, hubungi akunting !!!
			#				</div>';
			#}

		}

		# JIKA ADA PESAN ERROR DARI VALIDASI
		if (count($pesanError) >= 1) {
			$noPesan = 0;
			foreach ($pesanError as $indeks => $pesan_tampil) {
				$noPesan++;
				echo "$pesan_tampil";
			}
			echo "</div>";
		}
		// Refresh form
		//echo "<meta http-equiv='refresh' content='0; url=?page=Transaksi-Pembelian'>";
	}
	#
	# TOMBOL TAMBAH ITEM BARANG DIKLIK
	if (isset($_POST['btnPilih'])) {
		$kdcust	= $_POST['txtKdCust'];
		$Keterangan = $_POST['txtKeterangan'];
		$NoPO = $_POST['txtnoPO'];
		$TanggalPO = $_POST['tanggalpo'];
		$PrsDisc = $_POST['txtprsdisc'];
		$_SESSION['customer'] = $kdcust;
		$_SESSION['Keterangan'] = $Keterangan;
		$_SESSION['NoPO'] = $NoPO;
		$_SESSION['Tanggalpo'] = $TanggalPO;
		$_SESSION['PrsDisc'] = $PrsDisc;
		$pesanError = array();
		if (trim($_POST['txtkodebrg']) == "") {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Data barang belum diisi .!
						</div></div>';
		}
		if (trim($_POST['cmbSatuan']) == "BLANK") {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Item Barang belum dipilih .!
						</div></div>';
		}
		if (trim($_POST['txtHarga']) == "" or !is_numeric(trim($_POST['txtHarga']))) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Data harga harus input angka / belum diisi .!
						</div></div>';
		}
		if (trim($_POST['txtdisk3']) == "" or !is_numeric(trim($_POST['txtdisk3']))) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Data discount harus input angka / belum diisi .!
						</div></div>';
		}
		if (trim($_POST['txtdisk1']) == "" or !is_numeric(trim($_POST['txtdisk1']))) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Data discount harus input angka / belum diisi .!
						</div></div>';
		}
		if (trim($_POST['txtdisk2']) == "" or !is_numeric(trim($_POST['txtdisk2']))) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Data discount harus input angka / belum diisi .!
						</div></div>';
		}
		if (trim($_POST['txtJumlah']) == "" or !is_numeric(trim($_POST['txtJumlah']))) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Data Qty harus input angka / belum diisi .!
						</div></div>';
		}
		# CEK KETERSEDIAAN STOK
		//$txtkodebrg	= $_POST['txtkodebrg'];
		//$txtJumlah	= $_POST['txtJumlah'];
		//	$cekstok = "SELECT tblIvMst.KdBrg, tblIvMst.NmBrg, SUM(tblIvGstk.Qty) AS Qty, tblIvMst.Satuan
		//	FROM tblIvGstk RIGHT OUTER JOIN
		//	tblIvMst ON tblIvGstk.KdBrg = tblIvMst.KdBrg
		// 	WHERE (tblIvGstk.KdGd IN ('A', 'SP'))
		//	GROUP BY tblIvMst.KdBrg, tblIvMst.NmBrg, tblIvMst.Satuan
		//	HAVING (tblIvMst.KdBrg = '".$txtkodebrg."')";
		//	$myQry  = mssql_query($cekstok,$koneksidb) or die ("Query  salah:".mysql_error());
		//	while ($data = mssql_fetch_array($myQry)) {
		//	if ($data['Qty'] < $txtJumlah) {
		//	$pesanError[] = '<div class="alert alert-danger" role="alert">
		//				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		//				  <span class="sr-only">Error:</span>
		//				  Stock tidak mencukupi, hubungi gudang !!!
		//					</div>';
		//	}
		//	}
		# CEK BLOKIT DAN BLACKLIST
		$query2  = "SELECT  * FROM tblCustomer 
		Where KdCust = '" . $kdcust . "'";
		$myQry  = sqlsrv_query($conn, $query2) or die(print_r(sqlsrv_errors(), true));
		while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
			if ($kolomData['ProtekLimit'] == '1') {
				$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Customer ini di BLACKLIST, hubungi akunting !!!
						</div></div>';
			} #elseif ($kolomData['Whitelist']=='0' && $kolomData['Saldo']>0) {
			#	$pesanError[] = '<div class="alert alert-danger" role="alert">
			#			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			#			  <span class="sr-only">Error:</span>
			#			  CUSTOMER ini blockir transaksi, hubungi akunting !!!
			#				</div>';
			#}

		}
		# CEK ITEM DOUBLE
		$txtkodebrg	= $_POST['txtkodebrg'];
		$query3  = "SELECT  * FROM tmp_so 
		Where kd_user = '" . $_SESSION['username'] . "' AND item_barang='" . $txtkodebrg . "'";
		$params = array();
		$options =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		$hasil  = sqlsrv_query($conn, $query3, $params, $options) or die(print_r(sqlsrv_errors(), true));
		$rows = sqlsrv_num_rows($hasil);

		if ($rows > 0) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Item ini sudah diinput !!!
						</div></div>';
		}
		# CEK STATUS PAJAK
		# CEK ITEM SUDAH ADA DI tlb temporary
		$txtkodebrg	= $_POST['txtkodebrg'];
		$statusppn = $_POST['statusppn'];
		$query4  = "SELECT  * FROM tmp_so 
		Where kd_user = '" . $_SESSION['username'] . "'";
		$params = array();
		$options =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		$hasil  = sqlsrv_query($conn, $query4, $params, $options) or die(print_r(sqlsrv_errors(), true));
		$rows = sqlsrv_num_rows($hasil);
		# JIKA ADA CEK STATUS PPN BARANG
		if ($rows > 0) {
			$query5  = "SELECT TOP 1  * FROM tmp_so 
		Where kd_user = '" . $_SESSION['username'] . "'";
			$myQry  = sqlsrv_query($conn, $query5) or die(print_r(sqlsrv_errors(), true));
			while ($kolomData = sqlsrv_fetch_array($myQry, SQLSRV_FETCH_ASSOC)) {
				if ($kolomData['status_ppn'] != $statusppn) {
					$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Status Pajak Barang Tidak Sesuai !!!
						</div></div>';
				}
			}
		}
		# Baca variabel
		$txtkodebrg	= $_POST['txtkodebrg'];
		if (trim($_POST['txtHarga']) == "" or !is_numeric(trim($_POST['txtHarga']))) {
			$txtHarga = 0;
		} else {
			$txtHarga	= $_POST['txtHarga'];
		}
		$txtdisk1	= $_POST['txtdisk1'];
		$txtdisk2	= $_POST['txtdisk2'];
		$txtdisk3	= $_POST['txtdisk3'];
		$cmbSatuan	= $_POST['cmbSatuan'];
		$txtJumlah	= $_POST['txtJumlah'];
		$disk1 = ($txtJumlah * $txtHarga) * ($txtdisk1) / 100;
		$disk2 = ($txtJumlah * $txtHarga - $disk1) * ($txtdisk2) / 100;
		$disk3 = ($txtJumlah * $txtHarga - $disk1 - $disk2) * ($txtdisk3) / 100;
		$subTotal1 = ($txtJumlah * $txtHarga) - $disk1 - $disk2 - $disk3;
		$statusppn = $_POST['statusppn'];
		# JIKA ADA PESAN ERROR DARI VALIDASI
		if (count($pesanError) >= 1) {
			$noPesan = 0;
			foreach ($pesanError as $indeks => $pesan_tampil) {
				$noPesan++;
				echo "$pesan_tampil";
			}
			echo "</div>";
		} else {


			$tmpSql = "INSERT INTO tmp_so values ('" . $_SESSION['username'] . "','$txtkodebrg','$txtHarga','$txtdisk1','$txtdisk2','$txtdisk3','$txtJumlah','$subTotal1','$cmbSatuan','$statusppn')";
			sqlsrv_query($conn, $tmpSql) or die(print_r(sqlsrv_errors(), true));
		}
	}
	// ============================================================================
	//membaca kode barang terbesar
	$sql = "SELECT max(no_so) FROM salesorder";
	$query = sqlsrv_query($conn, $sql) or die(print_r(sqlsrv_errors(), true));

	$kode_faktur = sqlsrv_fetch_array($query);

	if ($kode_faktur) {
		$nilai = substr($kode_faktur[0], 6);
		$kode = (int) $nilai;

		//tambahkan sebanyak + 1
		// UNTUK TAHUN 2023 STRING DI TAMBAH JADI 6 KARAKTER
		$kode = $kode + 1;
		$auto_kode = "SO23-" . str_pad($kode, 6, "0",  STR_PAD_LEFT);
	} else {
		$auto_kode = "SO23-000001";
	}
	# JIKA TOMBOL SIMPAN DIKLIK
	if (isset($_POST['btnSave'])) {
		$kdcust	= $_POST['txtKdCust'];
		$pesanError = array();
		if (trim($_POST['txtnmcust']) == "") {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			Data <b> Nama Customer</b> belum diisi, harap diisi !.
			  </div></div>';
		}
		if (trim($_POST['tanggal']) == "") {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			Data <b>Tanggal Transaksi</b> belum diisi, pilih pada Tanggal !.
			  </div></div>';
		}
		if (trim($_POST['txtprsdisc']) == "" or !is_numeric(trim($_POST['txtprsdisc']))) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Discount Global harga harus input angka .!
						</div></div>';
		}

		// Validasi jika belum ada satupun data item yang dimasukkan
		$tmpSql = "SELECT COUNT(*) As qty FROM tmp_so WHERE kd_user='" . $_SESSION['username'] . "'";
		$tmpQry = sqlsrv_query($conn, $tmpSql) or die(print_r(sqlsrv_errors(), true));
		$tmpRow = sqlsrv_fetch_array($tmpQry);
		if ($tmpRow['qty'] < 1) {
			$pesanError[] = '<div class="container"><div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  Item barang belum ada yang terinput, minimal 1.
						</div></div>';
		}

		# Baca variabel
		$txtKdCust	= $_POST['txtKdCust'];
		$txtNmCust	= $_POST['txtnmcust'];
		$txtAlamat	= $_POST['txtAlamatkirim'];
		$txtKTP	= $_POST['txtNoKTP'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$tglTransaksi 	= $_POST['tanggal'];
		$txtnoPO	= $_POST['txtnoPO'];
		$txttglPO	= $_POST['tanggalpo'];
		$SubTotal = $_POST['SubTotal'];
		$PrsDisc = $_POST['txtprsdisc'];
		$totaldisc = $SubTotal * ($PrsDisc / 100);
		$GrandTotal	= $SubTotal - $totaldisc;
		$now = date_create();
		$jam = date_format($now, 'H:i:s');

		# JIKA ADA PESAN ERROR DARI VALIDASI
		if (count($pesanError) >= 1) {

			$noPesan = 0;
			foreach ($pesanError as $indeks => $pesan_tampil) {
				$noPesan++;
				echo "$pesan_tampil";
			}
			echo "</div>";
		} else {
			# Jika jumlah error pesanError tidak ada
			# Cek Kredit limit
			$query  = "SELECT tblCustomer.Saldo,tblCustomer.KreditLimit
	  			  		FROM tblCustomer WHERE KdCust = '$kdcust'";
			$hasil  = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
			$data = sqlsrv_fetch_array($hasil);
			$Saldo = ($data['Saldo']);
			$Kredit = ($data['KreditLimit']);
			$KreditLimit = ($Kredit - $Saldo);
			if ($KreditLimit < $GrandTotal) {
				# code...
				$Keterangan2 = "Kredit Limit Sisa : Rp." . number_format($KreditLimit);
			}
			#Simpan Sales ORDER			
			$mySql	= "INSERT INTO salesorder values ('$auto_kode','$tglTransaksi','$jam', '$txtKdCust','$txtNmCust','$txtAlamat','$txtKTP', '$txtnoPO','$txttglPO','$GrandTotal','$txtKeterangan','" . $_SESSION['username'] . "','','$Keterangan2','','','','','','','','','$PrsDisc','$totaldisc','$SubTotal')";
			$myQry = sqlsrv_query($conn, $mySql) or die(print_r(sqlsrv_errors(), true));
			if ($myQry) {
				# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
				$tmpSql = "SELECT * FROM tmp_so WHERE kd_user='" . $_SESSION['username'] . "'";
				$tmpQry = sqlsrv_query($conn, $tmpSql) or die(print_r(sqlsrv_errors(), true));
				while ($tmpRow = sqlsrv_fetch_array($tmpQry, SQLSRV_FETCH_ASSOC)) {
					$dataKode =	$tmpRow['item_barang'];
					$dataHarga =	$tmpRow['harga'];
					$dataDisc = $tmpRow['disk1'];
					$dataDisc2 = $tmpRow['disk2'];
					$dataDisc3 = $tmpRow['disk3'];
					$dataJumlah = $tmpRow['jumlah'];
					$dataSubtotal = $tmpRow['subtotal'];
					$dataSatuan = $tmpRow['satuan'];


					// Masukkan semua barang yang udah diisi ke tabel pembelian detail
					$itemSql = "INSERT INTO salesorder_item values ('$auto_kode','$dataKode', '$dataHarga','$dataDisc','$dataDisc2','$dataDisc3','$dataJumlah','$dataSubtotal','$dataSatuan')";
					sqlsrv_query($conn, $itemSql) or die(print_r(sqlsrv_errors(), true));
				}

				# Kosongkan Tmp jika datanya sudah dipindah
				$hapusSql = "DELETE FROM tmp_so WHERE kd_user='" . $_SESSION['username'] . "'";
				sqlsrv_query($conn, $hapusSql) or die(print_r(sqlsrv_errors(), true));

				// Refresh form


				echo "<meta http-equiv='refresh' content='0; url=?page=Sales Order'>";
				echo "<script>alert('Penyimpanan berhasil! {$Keterangan2}');</script>";
				unset($_SESSION["customer"]);
				unset($_SESSION["Keterangan"]);
				unset($_SESSION["NoPO"]);
				unset($_SESSION["TanggalPO"]);
				unset($_SESSION["PrsDisc"]);
			} else {
				$pesanError[] = "Gagal penyimpanan ke database";
			}
		}
	}

	// ============================================================================
} // Penutup GET

# TAMPILKAN DATA KE FORM

$tglTransaksi 	= isset($_POST['tanggal']) ? $_POST['tanggal'] : date('m-d-Y');
$tglpo 	= isset($_POST['tanggalpo']) ? $_POST['tanggalpo'] : date('m-d-Y');
$kodecust		= isset($_POST['txtKdCust']) ? $_POST['txtKdCust'] : '';
$Nmcust		= isset($_POST['txtnmcust']) ? $_POST['txtnmcust'] : '';
$Alamatkirim		= isset($_POST['txtAlamatkirim']) ? $_POST['txtAlamatkirim'] : '';
$KTP		= isset($_POST['txtNoKTP']) ? $_POST['txtNoKTP'] : '';
$Keterangan 	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$NoPO 			= isset($_POST['txtnoPO']) ? $_POST['txtnoPO'] : '';
$PrsDisc 			= isset($_POST['txtprsdisc']) ? $_POST['txtprsdisc'] : '';
