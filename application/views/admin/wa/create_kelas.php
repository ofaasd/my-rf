<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action="<?= (empty($wa))?base_url('index.php/admin/whatsapp/insert_kelas'):base_url('index.php/admin/whatsapp/update') ?>">
                    <input type="hidden" name='id' value='<?= (empty($wa))?"":$wa->id ?>'>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" class="form-control" id="kelas">
							<?php foreach($kelas as $row){
								echo "<option value=" . $row->kelas . ">" . $row->kelas . "</option>";
							}?>
						</select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Pesan</label>
                        <textarea name="pesan" class="form-control" rows='20'><?= $template_pesan->teks; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">URL Gambar</label>
                        <input type="text" name="file_gambar" id="file_gambar" class="form-control" value='<?= $template_pesan->file_gambar; ?>'>
                    </div>

                    <div class="form-group">
						<a href="#" class="btn btn-primary" id="review">Preview Penerima</a>
                        <input type="submit" value="Kirim" class="btn btn-primary"> 
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="card">
		<div class="card-header">
			Review Penerima
		</div>
		<div class="card-content">
			<div id="penerima"></div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function(){
		$("#review").click(function(){
			$.ajax({
				url : '<?=base_url('index.php/admin/whatsapp/get_review')?>',
				method : 'POST',
				data : {
					kelas : $('#kelas').val(),
				},
				success : function(data){
					$("#penerima").html(data);
				}
			});
		});
	});
</script>
