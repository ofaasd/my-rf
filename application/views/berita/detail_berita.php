<div class="shadow-sm p-3 mb-2">
	<h6>
		<?= $berita->judul?>
	</h6>
</div>
<?php use Carbon\Carbon; Carbon::setLocale('id');?>
<div class="card-content">
	<div class="row">
		<div class="col-md-12 col mb-3">
			<div class="shadow-sm">
				<div class="card-content d-flex flex-column justify-content-center">
                    <img src="<?= $berita->thumbnail ?>" class="img-fluid mb-4 w-50" alt="gambar thumbnail <?= $berita->judul ?>">

                    <small class="text-muted font-italic"><i class="bi bi-calendar-day-fill mr-2"></i><?= Carbon::parse($berita->created_at)->format('d M Y') ?></small>
					
                    <p class="card-text"><?= $berita->isi_berita ?></p>
				</div>
			</div>	
    	</div>
	</div>
	
</div>
<br />
