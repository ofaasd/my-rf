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
				<small><?= date('d-m-Y H:i:s', strtotime($agenda->tanggal_mulai)) ?> - <?= date('d-m-Y H:i:s', strtotime($agenda->tanggal_selesai)) ?></small>
				<div class="isi" style="display:none">
					<p><?= $agenda->isi ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$(".text-justify").append($(".ql-editor").val());
	});
</script>
