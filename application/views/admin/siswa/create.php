<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action="<?= (empty($siswa))?base_url('index.php/admin/siswa/insert'):base_url('index.php/admin/siswa/update') ?>">
                    <input type="hidden" name='id' value='<?= (empty($siswa))?"":$siswa->id ?>'>
                    <div class="form-group">
                        <label for="kode">Kode Kelas</label>
                        <input type="text" name="kode" id="kode" value="<?= (empty($siswa))?"":$siswa->kode ?>" class="form-control col-md-6">
                    </div>
					<div class="form-group">
                        <label for="kode">Kode Murroby</label>
                        <input type="text" name="kode_murroby" id="kode_murroby" value="<?= (empty($siswa))?"":$siswa->kode_murroby ?>" class="form-control col-md-6">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="siswa" value="<?= (empty($siswa))?"":$siswa->nama ?>" class="form-control col-md-6">
                    </div>
                    <div class="form-group">
                        <label for="nama">Status</label>
						<select name='status' class="form-control col-md-6">
							<?php 
								$a = array(0=>'aktif',1=>'lulus/alumni',2=>'boyong/keluar',3=>'meninggal');
								foreach($a as $key=>$value){
									echo '<option value="' . $key . '" ';
									echo (!empty($siswa) && $siswa->status == $key)?"selected":"";
									echo '>' . $value . '</option>';
								}
							?>
						</select>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="simpan" class="btn btn-primary"> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
