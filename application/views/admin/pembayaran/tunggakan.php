<table class="table table-stripped">
	<thead>
		<tr>
			<th>Jenis Pembayaran</th>
			<th>Tunggakan</th>
			<th>Pembayaran</th>
			<th>Status</th>
		</tr>
	</thead>	
	<tbody>
<?php 
	foreach($tunggakan as $row){
?>

		<tr>
			<td><?= $row->jenis?></td>
			<td>Rp. <?= number_format($row->kekurangan,0,",",".")?></td>
			<td>Rp. <?= number_format($row->pembayaran,0,",",".")?></td>
			<td><?= ($row->status == 0)?"Belum Lunas":"Lunas"?></td>
		</tr>
	
<?php
	}
?>
</tbody>
</table>