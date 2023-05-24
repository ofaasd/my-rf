<table class="table table-stripped table-responsive">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Periode</th>
			<?php foreach($jenis_pembayaran as $row){ ?>
			<th><?= $row->jenis ?></th>
			<?php } ?>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($pembayaran as $pem){
		$total = 0;
		?>
		<tr>
			<td><?= $pem->tanggal_bayar ?></td>
			<td><?= $bulan[$pem->periode] ?></td>
			<?php foreach($jenis_pembayaran as $jenis){
				$bayar = $detail_pembayaran[$pem->id][$jenis->id];
				$total += $bayar;
			?>
			<td><?=  number_format($bayar,0,",",".") ?></td>
			<?php } ?>
			<td><?=number_format($total,0,",",".")?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>