<div class="card-header">
        Kesehatan Santri
</div>
<div class="card-content">
	<table class="table table-striped">
		<thead>
			<tr>
				<td>Tanggal Sakit</td>
				<td>Jenis Sakit</td>
				<td>Keterangan</td>
				<td>Tanggal Sembuh</td>
				<td>Keterangan</td>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($riwayat_sakit as $row){
					echo "<tr>";
					echo "<td>" . date('d-m-Y', $row->tanggal_sakit) . "</td>";
					echo "<td>" . $row->sakit . "</td>";
					echo "<td>" . $row->keterangan_sakit . "</td>";
					echo "<td>" . date('d-m-Y', $row->tanggal_sembuh) . "</td>";
					echo "<td>" . $row->keterangan_sembuh . "</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
</div>
<div class="card">
<div class="card-header">
    Laporan Pemeriksaan
</div>
<div class="card-content">
	<table class="table table-striped">
		<thead>
			<tr>
				<td>Tanggal Periksa</td>
				<td>Tinggi Badan</td>
				<td>Berat Badan</td>
				<td>Lingkar Pinggul</td>
				<td>Lingkar Dada</td>
				<td>Kondisi Gigi</td>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($pemeriksaan as $row){
					echo "<tr>";
					echo "<td>" . date('d-m-Y', $row->tanggal_pemeriksaan) . "</td>";
					echo "<td>" . $row->tinggi_badan . " CM</td>";
					echo "<td>" . $row->berat_badan . " KG</td>";
					echo "<td>" . $row->lingkar_pinggul . " CM</td>";
					echo "<td>" . $row->lingkar_dada . " CM</td>";
					echo "<td>" . $row->kondisi_gigi . "</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>

<div class="card">
<div class="card-header">
    Rawat Inap
</div>
<div class="card-content">
	<table class="table table-striped">
		<thead>
			<tr>
				<td>Tanggal Masuk</td>
				<td>Keluhan</td>
				<td>Terapi</td>
				<td>Tanggal Keluar</td>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($rawat_inap as $row){
					echo "<tr>";
					echo "<td>" . date('d-m-Y', $row->tanggal_masuk) . "</td>";
					echo "<td>" . $row->keluhan . "</td>";
					echo "<td>" . $row->terapi . "</td>";
					echo "<td>" . date('d-m-Y', $row->tanggal_keluar) . "</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
