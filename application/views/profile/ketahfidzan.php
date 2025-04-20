<div class="card-header">
    Ketahfidzan <span class="font-weight-bold"><?= $detailSantri->nama; ?></span>
</div>
<div class="card-content">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Surah</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($ketahfidzan as $tahun => $bulanData) : ?>
				<tr style="background-color:#2dcc70; color: whitesmoke;">
					<td colspan="2" class="text-center"><strong><?= $tahun ?></strong></td>
				</tr>
				<?php foreach ($bulanData as $bulan => $entries) : ?>
					<?php foreach ($entries as $row) : ?>
						<?php if($row->nmJuz){ ?>
							<tr>
								<td><?= date('d', strtotime($row->tanggal)) . " " . $bulan . " " . $tahun; ?></td>
								<td><?= $row->nmJuz ?? "Data tidak ada"; ?></td>
							</tr>
						<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
