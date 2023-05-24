<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action="<?= (empty($keringanan))?base_url('index.php/admin/keringanan/insert'):base_url('index.php/admin/keringanan/update') ?>">
                    <input type="hidden" name='id' value='<?= (empty($keringanan))?"":$keringanan->id ?>'>
                    <div class="form-group">
						<label class="form-label">Nama Santri</label><br />
						<select id="nama_santri" name="id_siswa" class="form-control col-md-6">
							<option value=<?= (empty($keringanan))?0:$keringanan->id_siswa; ?>><?= (empty($keringanan))?"Masukan Nama Santri":$keringanan->nama . " - " . $keringanan->kode ?></option>
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
                        <label for="kode">Jenis Pembayaran</label>
                        <select id="jenis_pembayaran" name="id_jenis" class="form-control col-md-6">
							<option value=<?= (empty($keringanan))?0:$keringanan->id_jenis_pembayaran; ?>><?= (empty($keringanan))?"--Jenis Pembayaran--":$keringanan->jenis?></option>
							<?php
								foreach($jenis as $row){
							?>
								<option value="<?= $row->id ?>"><?= $row->jenis ?></option>
							<?php
								}
							?>
						</select>
                    </div>
                    <div class="form-group">
						<label class="form-label">Jumlah (Rp)</label>
						<input class="form-control col-md-6" type="text" onkeyup="splitInDots(this)" name="harga" value="<?= (empty($keringanan))?"":number_format($keringanan->harga,0,",",".")?>">
					</div>
                    <div class="form-group">
                        <input type="submit" value="simpan" class="btn btn-primary"> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
	$(document).ready(function(){
		$('#nama_santri').select2();
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