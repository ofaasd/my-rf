<section class="col-lg-12 connectedSortable">
    <div class="card">
		<div class="card-header">
			<h2>Download Data Siswa</h2>
			<a href="<?php echo base_url('index.php/admin/siswa/index/') ?>" class="btn btn-primary">Kembali</a>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
				Filter Data
			</button>
		</div>
        <div class="card-content">
            <div class="col-md-12" id="tabel_siswa">
                <table class="table table-hover table-stripped" id="my-table2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Anak Ke</th>
                            <th>Nama Wali Santri</th>
                            <th>HP</th>
                            <th>Alamat</th>
                            <th>Kab/Kota</th>
                            <th>Provinsi</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $i = 1;
                        foreach($siswa as $row){
                       ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row->no_induk ?></td>
                            <td><?= $row->nisn ?></td>
                            <td><?= strtoupper($row->nama) ?></td>
                            <td><?= strtoupper($row->kelas) ?></td>
							<td><?= $row->anak_ke ?></td>
                            <td><?= $row->nama_lengkap_ayah ?>/<?=$row->nama_lengkap_ibu?></td>
                            <td><?= $row->no_hp ?></td>
                            <td><?= $row->alamat ?>, <?= $row->kelurahan?>, <?= $row->kecamatan?></td>
							<td><?= $list_kota[$row->kabkota]?></td>
							<td><?= $list_provinsi[$row->provinsi]?></td>
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
                <form method="POST" action="<?= base_url('index.php/admin/siswa/download')?>" enctype="multipart/form-data">
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
			url:"<?= base_url('index.php/admin/siswa/get_table_siswa') ?>",
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
