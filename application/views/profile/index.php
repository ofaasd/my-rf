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
        
        
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" enctype='multipart/form-data' action="<?= base_url('index.php/profile/simpan') ?>">
                        <input type="hidden" name="no_induk" value="<?= $siswa->no_induk ?>">
                    
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <img src="<?php echo $photo; ?>" class="rounded" alt="Foto Santri" width="150">
                                </div>
                            </div>
                            <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label">Foto Santri</label><br />
                                <input type="file" name="photo" class="form-control col-md-6">
                            </div>
                        </div>
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
                </div>
                <div class="col-md-6">
                    <div class="alert alert-warning">
                        <h3>Berkas Pendukung</h3>
                        <form id="form_berkas_pendukung" action="javascript:void(0)" enctype="MULTIPART/FORM-DATA">
							<?php if(!empty($this->session->flashdata('message'))){?>
								<div class="alert alert-danger">
									<?php print_r($this->session->flashdata('message'));?>
								</div>
							<?php } ?>
                            <div class="form-group">
                                <label class="form-label">File KK</label><br />
                                <input type="file" name="file_kk" value="" class="form-control">
								<div id="alert">
									<?php if(empty($berkas->file_kk)) { ?>
                                		<div class="alert alert-danger mt-3"><i class="fa-solid fa-triangle-exclamation"></i> KK Belum Di Upload</div>
									<?php }else{ ?>
										<div class="alert alert-success mt-3"><i class="fa-solid fa-check"></i> KK Sudah Di Upload</div>
									<?php
									}
									?>
								</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">File Akta Kelahiran</label><br />
                                <input type="file" name="file_akta" value="" class="form-control">
								<div id="alert">
									<?php if(empty($berkas->file_akta)) { ?>
                                		<div class="alert alert-danger mt-3"><i class="fa-solid fa-triangle-exclamation"></i> Akta Kelahiran Belum Di Upload</div>
									<?php }else{ ?>
										<div class="alert alert-success mt-3"><i class="fa-solid fa-check"></i> Akta Kelahiran Sudah Di Upload</div>
									<?php
									}
									?>
                                	
								</div>
                            </div>
							<div class="form-group">
								<input type="submit" id="btn_simpan" value="Simpan" class="btn btn-primary">
							</div>
                        </form>
                    </div>
                </div>
            </div>
			
			
            
        
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
		$("#form_berkas_pendukung").submit(function(e){
			$("#btn_simpan").attr('disabled',true);
			e.preventDefault();
			let data = new FormData(this);
			$.ajax({
				method : 'POST',
				url : "<?= base_url('index.php/profile/simpan_berkas') ?>",
				processData: false,
                contentType: false,
                data : data,
				success : function(data){
					location.reload();	
				}
			});
		});
		
	});
</script>
