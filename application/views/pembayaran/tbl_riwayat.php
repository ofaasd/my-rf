<table class="table table-stripped table-responsive">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Periode</th>
			<?php foreach($jenis_pembayaran as $row){ ?>
			<th><?= $row->jenis ?></th>
			<?php } ?>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($pembayaran as $pem){
		?>
		<tr>
			<td><?= $pem->tanggal_bayar ?></td>
			<td><?= $bulan[$pem->periode] ?></td>
			<?php foreach($jenis_pembayaran as $jenis){ ?>
			<td><?= number_format($detail_pembayaran[$pem->id][$jenis->id],0,",",".") ?></td>
			<?php } ?>
			<td>
				<?php
					switch($pem->validasi){
						case 0:
							echo "Belum di Validasi";
							break;
						case 1:
							echo "Sudah di Validasi " . $bulan[$pem->periode] . "  klik tombol cetak ijo";
							break;
						case 2:
							echo "Validasi Ditolak";
							break;
						default :
							echo "";
					}
				?>
			</td>
			<td><a href='<?=base_url('index.php/pembayaran/print_bukti/' . $pem->id )?>' class="btn btn-success btn-sm"><i class="fa fa-print"></i></a></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>