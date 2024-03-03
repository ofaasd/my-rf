<div class="card-header">
	<?= $agenda->judul ?>
</div>
<div class="card-content">
	<div class="row">
		<div class="col-md-12">
			<div class="text-center">
				<?php if(!empty($agenda->gambar)){?>
				<img src="https://manajemen.ppatq-rf.id/assets/img/upload/foto_agenda/<?= $agenda->gambar ?>" alt="">	
				<?php } ?>
			</div>
			<br />
			<div class="text-justify">
				<small><?= date('d-m-Y H:i:s', strtotime($row->tanggal_mulai)) ?> - <?= date('d-m-Y H:i:s', strtotime($row->tanggal_selesai)) ?></small>
				<p><?= $agenda->isi ?></p>
			</div>
		</div>
	</div>
</div>
