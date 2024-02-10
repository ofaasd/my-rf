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
				foreach($data['riwayat_sakit'] as $row){
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
