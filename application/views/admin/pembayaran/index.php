<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12" style="overflow-y:scroll;">
			<a href="<?=base_url('index.php/admin/pembayaran/create')?>" class="btn btn-primary" style="margin:10px;">Tambah Pembayaran</a> <br /><br />
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
				<?php if(!empty($pembayaran)){ ?>
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
                            <th>Jumlah (Rp.)</th>
                            <th>Tanggal Bayar</th>
                            <th>Bulan</th>
                            <th>Bank Pengirim</th>
                            <th>Atas Nama</th>
                            <th>Note</th>
                            <th>Validasi</th>
                            <th width="40%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach($pembayaran as $row){
                       ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$siswa[$row->nama_santri]?></td>
                            <td><?=$kelas[$row->nama_santri]?></td>
                            <td><?=number_format($row->jumlah,0,',','.')?></td>
                            <td><?=$row->tanggal_bayar?></td>
                            <td><?=$bulan[$row->periode]?></td>
                            <td><?=$bank[$row->bank_pengirim]?></td>
                            <td><?=$row->atas_nama?></td>
                            <td><?=$row->catatan?></td>
                            <td>
                                <?php
                                    if($row->validasi == 0){
                                        echo "<p class='text text-warning'>Belum Valid</p>";
                                    }elseif($row->validasi == 2){
                                        echo "<p class='text text-danger'>Ditolak</p>";
                                    }else{
                                        echo "<p class='text text-success'>Valid</p>";
                                    }
                                ?>
                            </td>
                            <th>
								<div class="btn-group btn-group-xs">
									<a href='<?=base_url('index.php/admin/pembayaran/edit/' . $row->id )?>' class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
									<a target="_blank" href='<?=base_url('index.php/admin/pembayaran/print_bukti/' . $row->id )?>' class="btn btn-success btn-sm"><i class="fa fa-print"></i></a>
									<a href='<?=base_url('index.php/admin/pembayaran/show/' . $row->id )?>' class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
									<!--<a href='javascript:void(0)' data-toggle="modal" onclick="get_wa_form(<?= $row->id ?>)" data-target="#modal_wa" class="btn btn-success btn-sm"><i class="fab fa-whatsapp"></i></a>-->
									<a href='<?=base_url('index.php/admin/pembayaran/delete/' . $row->id )?>' class="btn btn-danger  btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus ?');"><i class="fa fa-trash"></i></a>
								  </div>
                            </th> 
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

<div class="modal fade" id="modal_wa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="javascript:void(0)" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Kirim Pesan WhatsApp</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="send_wa">
					
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" onclick="send_wa()" class="btn btn-primary" >Kirim Pesan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function get_wa_form(id){
		$.ajax({
			url : "<?=base_url('index.php/admin/pembayaran/get_wa_form' )?>",
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
				"number_key": "vqD6atiieyOOx7CI",
				"phone_no": no_wa,
				"message": pesan
			  }),
			};
			$.ajax({
				url : "<?=base_url('index.php/admin/pembayaran/send_wa' )?>",
				data:{
					no_wa : no_wa,
					pesan : pesan,
					id_pembayaran : id_pembayaran,
					nama : nama,
					},
				method:"POST",
				success : function (data){
					$.ajax(settings).done(function (response) {
						if(response.status != 200){
							$(".alert").html('<div class="alert alert-danger" role="alert"> Pesan Gagal Terkirim (kode : '+response.status+') </div>')
						}else{
							$.ajax({
								url : "<?=base_url('index.php/admin/pembayaran/update_status_wa' )?>",
								data:{
									status : 1,
									id : data,
								},
								method:"POST",
								success: function(){
									$(".alert").html('<div class="alert alert-success" role="alert"> Pesan Berhasil Terkirim </div>')
								}
							});
						}
					  	console.log(response);
					 	$('#modal_wa').modal('hide');
					  	$(".preloader").children().hide();
						$(".preloader").css('height', 0);
					});
				}
			});
			
		} 
		
	}
	$(document).ready(function(){
		$('#my-table2').DataTable({
			order: [[9, 'asc']],
		});
	})
</script>
