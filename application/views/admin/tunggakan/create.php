<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
            <a href="<?=base_url('index.php/admin/pembayaran')?>" class="btn btn-primary">Kembali</a><br /><br />
            <?php if(!empty($this->session->flashdata('message'))){ ?>
                <p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
            <?php } ?>
            <?php if(!empty($this->session->flashdata('error'))){ ?>
                <p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
            <?php } ?>
            <br />
            <form method="POST" enctype='multipart/form-data' action="<?= base_url('index.php/admin/tunggakan/insert') ?>">
				<div class="form-group">
					<label for="Bulan">
						Bulan Tunggakan
					</label>
					<select name="bulan" id="periode" class='form-control col-md-4' readonly>
						<?php foreach($bulan as $key=>$bul){ 
							echo '<option value="' . $key . '" ';
							echo (!empty($curr_bulan) && $curr_bulan == $key)?"selected":"";
							echo '>' . $bul , '</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="Tahun">
						Tahun Tunggakan
					</label> 
					<input type="number" name="tahun" value="<?=date('Y')?>" class="form-control col-md-4">
				</div>
				<table class="table table-hover table-stripped" id="my-table2">
					<thead>
						<tr>
							<th rowspan="2">No.</th>
							<th rowspan="2">Nama Santri</th>
							<th rowspan="2">Kelas</th>
							<th colspan="2">Tagihan</th>
							<th colspan="2">Pembayaran</th>
							<th colspan="2">Kekurangan</th>
							<th rowspan="2">Status</th>
						</tr>
						<tr>
							<?php
								for($i = 0;$i<3;$i++){
								foreach($jenis_pembayaran as $row){
									echo "<th>" . $row->jenis . "</th>";
								}
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; foreach($siswa as $sis) {
							echo "<tr>";
							echo "<td>" . $i . "</td>";
							echo "<td>" . $sis->nama . "</td>";
							echo "<td>" . $sis->kode . "</td>";
							$jumlah_tagihan = 0;
							$jumlah_bayar = 0;
							foreach($jenis_pembayaran as $jenis){
								echo "<td>Rp. " . number_format($tagihan[$sis->id][$jenis->id],0,",",".") . "</td>";
								$jumlah_tagihan += $tagihan[$sis->id][$jenis->id];
							}
							foreach($jenis_pembayaran as $jenis){
								echo "<td>Rp. " . number_format($list_bayar[$sis->id][$jenis->id],0,",",".") . "</td>";
								$jumlah_bayar += $list_bayar[$sis->id][$jenis->id];
							}
							$kekurangan = array();
							foreach($jenis_pembayaran as $jenis){
								echo "<td>Rp. " . number_format(($tagihan[$sis->id][$jenis->id] - $list_bayar[$sis->id][$jenis->id]),0,",",".") . "</td>";
								$kekurangan[$jenis->id] = $tagihan[$sis->id][$jenis->id] - $list_bayar[$sis->id][$jenis->id];
							}
							$hasil = $jumlah_tagihan - $jumlah_bayar;
							echo "<td>";
							if ($hasil > 0) {
								
								
								echo "Ada Tunggakan";
							}else{
								echo "Lunas";
							}
							
							echo "</td>";
							echo "</tr>";
							$i++;
							
							
						}?>
					</tbody>
				</table>
				<?php 
					if($hasil > 0){
						$i = 1;
						foreach($siswa as $sis) {		
							foreach($jenis_pembayaran as $jenis){
								$kekurangan = $tagihan[$sis->id][$jenis->id] - $list_bayar[$sis->id][$jenis->id];
								if($kekurangan > 0){
									echo "<div class='row'>";
									
									echo "<div class='col-md-4'><input type='hidden' name='id_siswa[" . $i . "]' value='" . $sis->id . "'></div>";
									echo "<div class='col-md-4'><input type='hidden' name='id_jenis[" . $i . "]' value='" . $jenis->id . "'></div>";
									echo "<div class='col-md-4'><input type='hidden' name='kekurangan[" . $i . "]' value='" . $kekurangan . "'></div>";
									$i++;
									echo "</div>";
								}
							}
						}
					}
				?>
				<div class="form-group">
					<div class="alert alert-warning text-center">Sebelum Membuat Tunggakan pastikan data diatas sudah benar. Jika sudah klik tombol di bawah</div>
					<input type="submit" value="Buat Tunggakan" class="btn btn-primary col-md-12">
				</div>
			</form>
			</div>
		</div>
	</div>

<script>
	$(document).ready(function(){
		$('#my-table2').DataTable();
	})
</script>