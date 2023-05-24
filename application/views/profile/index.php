<div class="card-header">
        Form Edit Profile
    </div>
    <div class="card-content">
		<?php if(!empty($this->session->flashdata('message'))){ ?>
            <p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
        <?php } ?>
        <?php if(!empty($this->session->flashdata('error'))){ ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
        <?php } ?>
        <br />
        <form method="POST" enctype='multipart/form-data' action="<?= base_url('index.php/profile/simpan') ?>">
			<input type="hidden" name="no_induk" value="<?= $siswa->no_induk ?>">
            <div class="form-group">
                <label class="form-label">Nama Santri</label><br />
                <input type="text" name="nama" value="<?= $siswa->nama; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">NISN</label><br />
                <input type="text" name="nisn" value="<?= $siswa->nisn; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">NIK</label><br />
                <input type="text" name="nik" value="<?= $siswa->nik; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Anak Ke</label><br />
                <input type="number" name="anak_ke" value="<?= $siswa->anak_ke; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Tempat Lahir</label><br />
                <input type="text" name="tempat_lahir" value="<?= $siswa->tempat_lahir; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Lahir</label><br />
                <input type="date" name="tanggal_lahir" value="<?= $siswa->tanggal_lahir; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Usia</label><br />
                <input type="number" name="usia" value="<?= $siswa->usia; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Jenis Kelamin</label><br />
                <input type="radio" name="jenis_kelamin" value="L" id='L' <?=($siswa->jenis_kelamin == 'L')?"checked":""?>><label for='L' class="form-label"> Laki-Laki</label>
                <input type="radio" name="jenis_kelamin" value="P"id='P' <?=($siswa->jenis_kelamin == 'P')?"checked":""?>><label for='P' class="form-label"> Perempuan</label>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label><br />
                <textarea name="alamat" class="form-control"><?= $siswa->alamat; ?></textarea>
            </div>
			<div class="form-group">
                <label class="form-label">Provinsi</label><br />
                <select name="provinsi" class="form-control" id="provinsi">
					<option value="<?= $prov_curr->prov_id?>"><?=$prov_curr->prov_name?></option>
					<?php foreach($provinsi as $prov) {
						echo "<option value='" . $prov->prov_id . "'>" . $prov->prov_name . "</option>";
					}?>
				</select>
            </div>
			<div class="form-group">
                <label class="form-label">Kab/Kota</label><br />
                <select name="kabkota" class="form-control" id="kota">
					<option value="<?= $kota_curr->city_id?>"><?=$kota_curr->city_name?></option>
					<?php foreach($kota as $kot) {
						echo "<option value='" . $kot->city_id . "'>" . $kot->city_name . "</option>";
					}?>
				</select>
            </div>
			<div class="form-group">
                <label class="form-label">Kelurahan</label><br />
                <input type="text" name="kelurahan" value="<?= $siswa->kelurahan; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Kecamatan</label><br />
                <input type="text" name="kecamatan" value="<?= $siswa->kecamatan; ?>" class="form-control">
            </div>
			
			<div class="form-group">
                <label class="form-label">Kode Pos</label><br />
                <input type="text" name="kode_pos" value="<?= $siswa->kode_pos; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">NIK KK</label><br />
                <input type="text" name="nik_kk" value="<?= $siswa->nik_kk; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Nama Lengkap Ayah</label><br />
                <input type="text" name="nama_lengkap_ayah" value="<?= $siswa->nama_lengkap_ayah; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Pendidikan Ayah</label><br />
                <input type="text" name="pendidikan_ayah" value="<?= $siswa->pendidikan_ayah; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Pekerjaan Ayah</label><br />
                <input type="text" name="pekerjaan_ayah" value="<?= $siswa->pekerjaan_ayah; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Nama Lengkap Ibu</label><br />
                <input type="text" name="nama_lengkap_ibu" value="<?= $siswa->nama_lengkap_ibu; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Pendidikan Ibu</label><br />
                <input type="text" name="pendidikan_ibu" value="<?= $siswa->pendidikan_ibu; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">Pekerjaan Ibu</label><br />
                <input type="text" name="pekerjaan_ibu" value="<?= $siswa->pekerjaan_ibu; ?>" class="form-control">
            </div>
			<div class="form-group">
                <label class="form-label">No. HP</label><br />
                <input type="text" name="no_hp" value="<?= $siswa->no_hp; ?>" class="form-control">
            </div>
			
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Konfirmasi">
            </div>
        </form>
		<br />
    </div>
</div>

<script>
	$(document).ready(function(){
		$("#provinsi").on("change",function(){
			//alert($(this).val());
			$.ajax({
				method:"POST",
				url:"<?= base_url('index.php/profile/get_kota') ?>",
				data:{
						prov_id:$(this).val(),
					},
				success:function (data){
					$("#kota").html(data);
				}
			});
		});
	});
</script>