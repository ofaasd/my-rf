<html>
<head>
	<title>Bukti Pembayaran</title>
	<style>
		body{
			font-size:9pt;
		}
	</style>
</head>
<body>
	<table width="100%">
		<tr>
			<td><img src="<?php echo base_url('assets/images/logo.png') ?>" width="60"/></td>
			<td>
				<p><b>PPATQ RAUDLATUL FALAH - PATI </b></p>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:left"><b>Periode Bulan </td><td>: <?php echo $bulan[$pembayaran->periode]?></b></td>
		</tr>
		<tr>
			<td>Nama Santri</td>
			<td>: <?php echo $santri->nama ?></td>
		</tr>
		
		<tr>
			<td>Kelas</td>
			<td>: <?php echo strtoupper($santri->kode) ?></td>
		</tr>
		<tr>
			<td>Nama Wali Santri</td>
			<td>: <?php echo $pembayaran->atas_nama ?></td>
		</tr>
		<tr>
			<td>Tanggal Laporan</td>
			<td>: <?php echo date('d-m-Y', strtotime($pembayaran->tanggal_bayar)) ?></td>
		</tr>
		<tr>
			<td colspan=2 style="text-align:left"><b>Rincian</b></td>
		</tr>
		<?php
			$total = 0;
			foreach($jenis_pembayaran as $jenis) { 
			if($detail_pembayaran[$jenis->id] != 0){
				$total += $detail_pembayaran[$jenis->id];
				echo "<tr><td>" . $jenis->jenis . "</td><td>: Rp. " . number_format($detail_pembayaran[$jenis->id],0,",",".") . "</td></tr>";
			}
		} ?>
		<tr>
			<td><b>Total</b></td><td>: <b>Rp. <?php echo number_format($total,0,",",".") ?> </b></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Jenis Pembayaran</td>
			<td>: <?php echo $pembayaran->tipe; ?></td>
		</tr>
			<?php if($pembayaran->tipe == "Bank"){ 
			echo "<tr><td>Nama Bank</td><td>: " . $bank_pengirim->nama . "</td></tr>";
			echo "<tr><td>Atas Nama</td><td>: " . $pembayaran->atas_nama . "</td></tr>";
			$tanggal_validasi = ($pembayaran->tanggal_validasi == "0000-00-00" || empty($pembayaran->tanggal_validasi))?date('d-m-Y',strtotime($pembayaran->updated_at)):date('d-m-Y',strtotime($pembayaran->tanggal_validasi));
			} ?>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Status Validasi</td>
			<td><b>: <?php echo ($pembayaran->validasi == 1)?"Sudah di Validasi oleh admin pada tanggal " . $tanggal_validasi:"Belum Di Validasi"; ?></b></td>
		</tr>
		<tr>
			<td>Catatan</td>
			<td><b>: <?= $pembayaran->note_validasi ?></b></td>
		</tr>
	</table>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>
</html>
