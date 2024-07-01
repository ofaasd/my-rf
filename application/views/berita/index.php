<div class="shadow-sm p-3 mb-2">
	<h6>
		Berita
	</h6>
</div>
<?php use Carbon\Carbon; Carbon::setLocale('id');?>
<div class="card-content">
	<div class="row">
        <?php foreach ($berita as $row) { ?>
		<div class="col-md-4 mb-3">
        	<a href="<?php echo base_url('index.php/berita') ?>" class="text-decoration-none text-dark">
			<div class="shadow-sm">
				<div class="p-3 border-bottom border-right border-left">
					<h5><?= $row->judul?></h5>
				</div>
				<div class="card-content">
                    <img src="https://manajemen.ppatq-rf.id/assets/img/upload/berita/thumbnail/<?= $row->thumbnail?>" class="img-fluid mb-4" alt="gambar thumbnail <?= $row->judul ?>">
                    <p class="card-text"><?= (strip_tags(strlen($row->isi_berita)) > 100) ? strip_tags(substr($row->isi_berita,0,150)) . ' [...]': strip_tags($row->isi_berita)?></p>
					<small class="text-muted font-italic"><?= Carbon::parse($row->created_at)->diffForHumans()?></small>
					</div>
			</div>	
            </a>
    	</div>
        <?php } ?>

	</div>
	
</div>
	<br />
