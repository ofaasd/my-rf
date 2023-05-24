<table class="table table-hover table-stripped" id="my-table2">
	<thead>
		<tr>
			<th>No.</th>
			<th>NIS</th>
			<th>Nama</th>
			<th>Kelas</th>
			<th>Nama Wali Santri</th>
			<th>HP</th>
			<th>Alamat</th>
			<th>Kab/Kota</th>
			<th>Provinsi</th>
		</tr>
	</thead>
	<tbody>
	   <?php
		$i = 1;
		foreach($siswa as $row){
	   ?>
		<tr>
			<td><?= $i ?></td>
			<td><?= $row->no_induk ?></td>
			<td><?= strtoupper($row->nama) ?></td>
			<td><?= strtoupper($row->kelas) ?></td>
			<td><?= $row->nama_lengkap_ayah ?>/<?=$row->nama_lengkap_ibu?></td>
			<td><?= $row->no_hp ?></td>
			<td><?= $row->alamat ?>, <?= $row->kelurahan?>, <?= $row->kecamatan?></td>
			<td><?= $list_kota[$row->kabkota]?></td>
			<td><?= $list_provinsi[$row->provinsi]?></td>
		</tr>
		<?php
		$i++;
		}
		?>
	</tbody>
</table>

<script>
	$('#my-table2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
</script>