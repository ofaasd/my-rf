<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
				<a href="<?=base_url('index.php/admin/tunggakan')?>" class="btn btn-primary">Kembali</a><br /><br />
				<?php if(!empty($this->session->flashdata('message'))){ ?>
					<p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
				<?php } ?>
				<?php if(!empty($this->session->flashdata('error'))){ ?>
					<p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
				<?php } ?>
				<!--<p class="alert alert-warning">Harap Berhati-hati dalam mengedit Tunggakan karena data yang ada merupakan generate dari sistem</p>-->
				<br />
				<form method="POST" enctype='multipart/form-data' action="<?= (empty($tunggakan))?base_url('index.php/admin/tunggakan/insert2'):base_url('index.php/admin/tunggakan/update') ?>">
					<input type="hidden" name="id" value="<?= (empty($tunggakan))?"":$tunggakan->id ?>">
					<input type="hidden" name="id_siswa" value="<?= (empty($tunggakan))?"":$tunggakan->id_siswa ?>">
					<input type="hidden" name="id_jenis" value="<?= (empty($tunggakan))?"":$tunggakan->id_jenis_pembayaran ?>">
					<div class="form-group">
                        <label for="nama">Nama Santri</label><br />
                        <select id="nama_santri" name="nama_santri" class="form-control col-md-6">
							<option value="<?= (empty($tunggakan))?"0":$tunggakan->id_siswa ?>"><?= (empty($tunggakan))?"Masukan nama Santri":$tunggakan->nama ?></option>
							<?php
								foreach($siswa as $row){
							?>
								<option value="<?= $row->id ?>"><?= $row->nama ?> - <?= $row->kode ?></option>
							<?php
								}
							?>
						</select>
                    </div>
					<div class="form-group">
                        <label for="nama">Jenis Pembayaran</label>
						<select name="jenis" class="form-control col-md-6">
							<option value="<?= (empty($tunggakan))?"0":$tunggakan->id_jenis_pembayaran ?>"><?= (empty($tunggakan))?"Jenis Pembayaran Pembayaran":$tunggakan->jenis ?></option>
							<?php foreach($jenis as $row){ ?>
								<option value="<?= $row->id ?>"><?= $row->jenis ?></option>
							<?php } ?>
						</select>
                    </div>
					<div class="form-group">
						<label for="Bulan">
							Bulan Tunggakan
						</label>
						<select name="bulan" id="periode" class='form-control col-md-4'>
							<?php foreach($bulan as $key=>$bul){ 
								echo '<option value="' . $key . '" ';
								echo (!empty($tunggakan) && $tunggakan->bulan == $key)?"selected":"";
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
					<div class="form-group">
						<label for="Tahun">
							Jumlah Tunggakan
						</label> 
						<input type="text" name="kekurangan" onkeyup="splitInDots(this)" value="<?=(empty($tunggakan))?"":number_format($tunggakan->kekurangan,0,",",".")?>" class="form-control col-md-4">
					</div>
					<div class="form-group">
						<label for="Tahun">
							Jumlah Pembayaran
						</label> 
						<input type="text" name="pembayaran" onkeyup="splitInDots(this)" value="<?=(empty($tunggakan))?"0":number_format($tunggakan->pembayaran,0,",",".")?>" class="form-control col-md-4">
					</div>
					<div class="form-group">
						<label for="Tahun">
							Status
						</label> 
						<select name="status" class="form-control col-md-6">
							<option value="0" <?= (!empty($tunggakan) && $tunggakan->status == 0)?"selected":"" ?>>Belum Lunas</option>
							<option value="1"  <?= (!empty($tunggakan) && $tunggakan->status == 1)?"selected":"" ?>>Lunas</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" value="Simpan" class="btn btn-primary">
					</div>
					
				</form>
			</div>	
		</div>
	</div>
</section>
<script>
	$(document).ready(function(){
		$('#nama_santri').select2({
			minimumInputLength: 3,
		});
	});
	
	function reverseNumber(input) {
        return [].map.call(input, function(x) {
            return x;
        }).reverse().join(''); 
    }
    
    function plainNumber(number) {
        return number.split('.').join('');
    }
    
    function splitInDots(input) {
    
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        
        console.log(plain,reversed, reversedWithDots, normal);
        input.value = normal;
    }
    
    function oneDot(input) {
        var value = input.value,
            value = plainNumber(value);
        
        if (value.length > 3) {
            value = value.substring(0, value.length - 3) + '.' + value.substring(value.length - 3, value.length);
        }
        console.log(value);
        input.value = value;
    }
</script>