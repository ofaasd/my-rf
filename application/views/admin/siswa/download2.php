<section class="col-lg-12 connectedSortable">
    <div class="card" >
		<div class="card-header">
			<h2>Download Data Siswa</h2>
			<a href="<?php echo base_url('index.php/admin/siswa/index/') ?>" class="btn btn-primary">Kembali</a>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
				Filter Data
			</button>
		</div>
        <div class="card-content" style='overflow-y:scroll'>
            <div class="col-md-12" id="tabel_siswa">
                <table class="table table-hover table-stripped" id="my-table2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No Tes</th>
                            <th>No. Induk</th>
                            <th>Nama</th>
                            <th>NISN</th>
                            <th>NIK</th>
                            <th>Anak Ke</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Usia</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Desa/Kelurahan</th>
                            <th>Kecamatan</th>
                            <th>Kab./Kota</th>
                            <th>Provinsi</th>
                            <th>Kode Pos</th>
                            <th>NIK KK</th>
                            <th>Nama Ayah</th>
                            <th>Pendidikan Ayah</th>
                            <th>Pekerjaan Ayah</th>
                            <th>Nama Ibu</th>
                            <th>Pendidikan Ibu</th>
                            <th>Pekerjaan Ibu</th>
                            <th>No. Hp</th>
                            <th>Kelas</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $i = 1;
                        foreach($siswa as $row){
                       ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row->no_tes ?></td>
                            <td><?= $row->no_induk ?></td>
                            <td><?= strtoupper($row->nama) ?></td>
                            <td><?= $row->nisn ?></td>
                            <td><?= $row->nik ?></td>
                            <td><?= $row->anak_ke ?></td>
                            <td><?= $row->tempat_lahir ?></td>
                            <td><?= $row->tanggal_lahir ?></td>
                            <td><?= $row->usia ?></td>
                            <td><?= $row->jenis_kelamin ?></td>
                            <td><?= $row->alamat ?></td>
                            <td><?= $row->kelurahan ?></td>
                            <td><?= $row->kecamatan ?></td>
                            <td><?= $list_kota[$row->kabkota]?></td>
                            <td><?= $list_provinsi[$row->provinsi]?></td>
                            <td><?= $row->kode_pos ?></td>
                            <td><?= $row->nik_kk ?></td>
                            <td><?= $row->nama_lengkap_ayah ?></td>
                            <td><?= $row->pendidikan_ayah ?></td>
                            <td><?= $row->pekerjaan_ayah ?></td>
                            <td><?= $row->nama_lengkap_ibu ?></td>
                            <td><?= $row->pendidikan_ibu ?></td>
                            <td><?= $row->pekerjaan_ibu ?></td>
                            <td><?= $row->no_hp ?></td>
                            <td><?= strtoupper($row->kelas) ?></td>
                        </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?= base_url('index.php/admin/siswa/download2')?>" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filter Data SIswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
						<div class="form-group">
							<label for="kelas">Kelas</label>
							<select name="kelas" class="form-control" id="kelas">
								<option value="0">---Semua---</option>
								<?php foreach($kelas as $row){
									echo '<option value="' . $row->kelas .'" ';
									if($row->kelas == $this->input->post('kelas')){
										echo "selected";
									}
									echo '>' . $row->kelas . '</option>';
								}?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="kelas">Provinsi</label>
							<select name="provinsi" class="form-control" id="provinsi">
								<option value="0">---Semua---</option>
							</select>
						</div>
						<div class="form-group">
							<label for="kelas">kabkota</label>
							<select name="kota" class="form-control" id="kota">
								<option value="0">---Semua---</option>
							</select>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="filter" class="btn btn-primary" data-dismiss="modal">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
   $(document).ready(function() {
    $('#my-table2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
	$("#kelas").on("change",function(){
		//alert($(this).val());
		$.ajax({
			method:"POST",
			url:"<?= base_url('index.php/admin/siswa/get_provinsi') ?>",
			data:{kelas:$(this).val()},
			success:function (data){
				$("#provinsi").html(data);
			}
		});
	});
	$("#provinsi").on("change",function(){
		//alert($(this).val());
		$.ajax({
			method:"POST",
			url:"<?= base_url('index.php/admin/siswa/get_kota') ?>",
			data:{
					prov_id:$(this).val(),
					kelas:$("#kelas").val(),
				},
			success:function (data){
				$("#kota").html(data);
			}
		});
	});
	$("#filter").click(function(){
		$.ajax({
			method:"POST",
			url:"<?= base_url('index.php/admin/siswa/get_table_siswa2') ?>",
			data:{
					provinsi:$("#provinsi").val(),
					kelas:$("#kelas").val(),
					kota:$("#kota").val(),
				},
			success:function (data){
				$("#tabel_siswa").html(data);
			}
		});
	});
} );
</script>