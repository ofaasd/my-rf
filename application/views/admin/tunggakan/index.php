<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12" style="overflow-y:scroll;">
			<a href="<?=base_url('index.php/admin/tunggakan/create')?>" class="btn btn-primary" style="margin:10px;">Tambah Data Tunggakan</a> <br /><br />
				<form method="POST" action=''>
                    <div class="form-group">
                        <label for="periode">Bulan</label>
                        <select name="periode" id="periode" class='form-control col-md-4'>
                            <option value="0">Semua</option>
                            <?php foreach($bulan as $key=>$bul){ 
								echo '<option value="' . $key . '" ';
								echo (!empty($curr_bulan) && $curr_bulan == $key)?"selected":"";
								echo '>' . $bul , '</option>';
							}
							?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" name='tahun' class='form-control col-md-2' value='<?= (!empty($curr_tahun))?$curr_tahun:date('Y')?>'>
                    </div> 
                    <input type="submit" value='Lihat Data' class='btn btn-primary'>
                </form><br />
				<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Upload Data
                </button>-->
				<?php if(!empty($tunggakan)){ ?>
				
				<div class="alert">
				
				</div>
				<?php if(!empty($this->session->flashdata('message'))){ ?>
					<p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
				<?php } ?>
				<?php if(!empty($this->session->flashdata('error'))){ ?>
					<p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
				<?php } ?>
                
                <table class="table table-hover table-stripped" id="my-table2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Santri</th>
                            <th>Kode Kelas</th>
                            <th>Jenis Pembayaran</th>
                            <th>Kekurangan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach($tunggakan as $row){
                       ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$siswa[$row->id_siswa]?></td>
                            <td><?=$kelas[$row->id_siswa]?></td>
                            <td><?=$jenis[$row->id_jenis_pembayaran]?></td>
                            <td>Rp. <?= number_format($row->kekurangan,0,",",".")?></td>
                            <td><?= ($row->status == 0)?"Belum Lunas":"Lunas"?></td>
                            <td>
								<div class="btn-group btn-group-xs">
									<a href='<?=base_url('index.php/admin/tunggakan/edit/' . $row->id )?>' class="btn btn-primary btn-sm" alt="edit"><i class="fa fa-pencil-alt"></i></a>
									<!--<a href='<?=base_url('index.php/admin/tunggakan/show/' . $row->id )?>' class="btn btn-info btn-sm" alt="lihat riwayat bayar"><i class="fa fa-eye"></i></a>-->
									<a href='<?=base_url('index.php/admin/tunggakan/delete/' . $row->id )?>' class="btn btn-danger  btn-sm" alt="Hapus" onclick="return confirm('Hati-hati dalam menghapus data Tunggakan. Pastikan bahwa data pembayaran sudah masuk ?');"><i class="fa fa-trash"></i></a>
								</div>
                            </td> 
                        </tr>
						
                        <?php 
                            $i++;
                            }
                        ?>
                    </tbody>
                </table>
				<?php
				}
				?>
            </div>
        </div>
    </div>
</section>

<script>
	function get_wa_form(id){
		$.ajax({
			url : "<?=base_url('index.php/admin/tunggakan/get_wa_form' )?>",
			data:{id : id},
			method:"POST",
			success : function (data){
				$("#send_wa").html(data);
			}
		});
	}
	function send_wa(){
		$(".preloader").children().show();
		$(".preloader").css('height', "100%");
		const no_wa = document.getElementById('no_wa').value;
		const pesan = document.getElementById('message').value;
		const id_pembayaran = document.getElementById('id_pembayaran').value;
		const nama = document.getElementById('nama').value;
		if(!no_wa || !pesan){
			alert("No Wa atau Pesan Kosong");
		}else{
			var settings = {
			  "url": "https://api.watzap.id/v1/send_message",
			  "method": "POST",
			  "timeout": 0,
			  "headers": {
				"Content-Type": "application/json"
			  },
			  "data": JSON.stringify({
				"api_key": "X2Y7UZOZT0WVQVTG",
				"number_key": "9084EfQqVypAOEhu",
				"phone_no": no_wa,
				"message": pesan
			  }),
			};
			$.ajax({
				url : "<?=base_url('index.php/admin/tunggakan/send_wa' )?>",
				data:{
					no_wa : no_wa,
					pesan : pesan,
					id_pembayaran : id_pembayaran,
					nama : nama,
					},
				method:"POST",
				success : function (data){
					$.ajax(settings).done(function (response) {
					  console.log(response);
					  $('#modal_wa').modal('hide');
					  $(".alert").append('<div class="alert alert-success" role="alert"> Pesan Berhasil Terkirim </div>')
					  $(".preloader").children().hide();
						$(".preloader").css('height', 0);
					});
				}
			});
			
		} 
		
	}
	$(document).ready(function(){
		$('#my-table2').DataTable();
	})
</script>