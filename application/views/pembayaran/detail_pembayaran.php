<link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/css/materialDateTimePicker.css">

<div class="card-header">
        Form Laporan Pembayaran
    </div>
    <div class="card-content">
        <?php if(!empty($this->session->flashdata('message'))){ ?>
            <p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
        <?php } ?>
        <?php if(!empty($this->session->flashdata('error'))){ ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
        <?php } ?>

        <p class="alert alert-primary">Siapkan file bukti bayar PDF/PNG/JPG/BMP</p>

        <br />		
		<form method="POST" enctype='multipart/form-data' action="<?= base_url('index.php/pembayaran/simpan') ?>">
			<input type="hidden" id="nama_santri2" name="nama_santri" value="<?= $nama_santri ?>">
			<input type="hidden" name="kode" value="<?= $kode ?>">
			<div class="row">
				<?php if(!empty($pembayaran)){?>
				<div class="col-md-12">
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
					  Lihat Riwayat Pembayaran
					</button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Riwayat Pembayaran - <?php echo $siswa->nama ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<table class="table table-stripped table-responsive dataTable">
								<thead>
									<tr>
										<th></th>
										<th>Tanggal</th>
										<th>Periode</th>
										<?php foreach($jenis_pembayaran as $row){ ?>
										<th><?= $row->jenis ?></th>
										<?php } ?>
										<th>Status</th>
										
									</tr>
								</thead>
								<tbody>
									<?php
									foreach($pembayaran as $pem){
									?>
									<tr>
										<td><a href='<?=base_url('index.php/pembayaran/print_bukti/' . $pem->id )?>' class="btn btn-success btn-sm"><i class="fa fa-print"></i></a></td>
										<td><?= $pem->tanggal_bayar ?></td>
										<td><?= $bulan[$pem->periode] ?></td>
										<?php foreach($jenis_pembayaran as $jenis){ ?>
										<td><?= number_format($detail_pembayaran[$pem->id][$jenis->id],0,",",".") ?></td>
										<?php } ?>
										<td>
											<?php
												switch($pem->validasi){
													case 0:
														echo "Belum di Validasi";
														break;
													case 1:
														echo "Sudah di Validasi " . $bulan[$pem->periode] . "  klik tombol cetak ijo";
														break;
													case 2:
														echo "Validasi Ditolak";
														break;
													default :
														echo "";
												}
											?>
										</td>
										
									</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						  </div>
						</div>
					  </div>
					</div>
					
				</div>
				<?php } ?>
				<div class="col-md-6">
					<table class="table table-stripped">
						<tr>
							<td>Nama</td>
							<td><?= $siswa->nama ?></td>
						</tr>
						<tr>
							<td>Kode Kelas</td>
							<td><?= $kode ?></td>
						</tr>
						<tr>
							<td>Wali Kelas</td>
							<td><?= $wali_kelas->nama ?></td>
						</tr>
					</table>
					<div class="form-group">
						<label class="form-label">Pembayaran Sebesar (Rp)</label>
						<input class="form-control col-md-12" type="text" onkeyup="splitInDots(this)" name="jumlah" >
					</div>
					<div class="form-group">
						<label class="form-label">Tanggal</label>
						<input class="form-control col-md-12" id="date" value="<?= date('Y-m-d')?>" type="text" name="tanggal_bayar" >
					</div>
					<div class="form-group">
						<label class="form-label">Periode Bayar</label>
						<select name="periode_view" class="form-control col-md-12" id="bulan" disabled>
							<?php foreach($bulan as $key=>$value){ ?>
							<option value="<?=$key?>" <?=($key == (int)date('m'))?"selected":""?>><?=$value?></option>
							<?php } ?>
						</select>
						<input type="hidden" name="periode" value='<?php echo $periode?>'>
					</div>
					<input type="hidden" name="tahun" value="<?= date('Y')?>">
					<div class="form-group">
						<label class="form-label">Bank Pengirim</label>
						<select name="bank_pengirim" class="form-control col-md-12">
							<?php foreach($bank_pengirim as $bank){ ?>
								<option value="<?=$bank->id?>"><?=$bank->nama?></option>
							<?php } ?>
						</select>
					</div>
					
					<div class="form-group">
						<label class="form-label">Pengirim Atas Nama</label>
						<input class="form-control col-md-12" type="text" name="atas_nama">
					</div>
					<div class="form-group">
						<label class="form-label">Pembayaran</label>
						<div class="row">
							<div class="col-md-5">Tunggakan</div>
							<div class="col-md-5"><input type="text" onkeyup="splitInDots(this)" placeholder="0" name="tunggakan" class="form-control" value="<?=($jumlah_tunggakan == 0)?"0":number_format($jumlah_tunggakan,0,",",".")?>" <?=($jumlah_tunggakan == 0)?"readonly":""?>></div>
							<div class="col-md-2 text-center">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tunggakanModal">
									Lihat
								</button>
							</div>
						</div>
							<?php foreach($jenis_pembayaran as $row) { ?>
								<div class="row" style="margin:10px auto">
									<div class="col-md-4"><?=$row->jenis?><input type="hidden" name="id_jenis_pembayaran[]" value='<?= $row->id ?>'></div>
									<div class="col-md-8"><input type="text" onkeyup="splitInDots(this)" placeholder="0" name="jenis_pembayaran[]" class="form-control"></div>
								</div>
							<?php } ?>
						</table>    
					</div>
					<div class="form-group">
						<label class="form-label">Catatan</label>
						<textarea class="form-control col-md-12" name="catatan" ></textarea>
					</div>
					<div class="form-group">
						<label for="bukti" class="form-label" style="margin:0">Upload Bukti Bayar</label>
						<small id="passwordHelp" class="form-text text-muted">* Harap sertakan bukti bayar. <br />Jika tidak ada bukti bayar kami mohon maaf bila nanti tidak terkonversi / dianggap <br /> belum bayar, karena bukti bayar tidak ditemukan</small>
						<input type="file" id="bukti" class="form-control col-md-12" name="bukti" required >
						
					</div>

					<div class="form-group">
						<label class="form-label">No. Wa / Telp Konfirmasi</label>
						<input class="form-control col-md-12" type="text" name="no_wa">
					</div>
					
					<div class="form-group">
						<input type="submit" class="form-control col-md-12 btn btn-primary" value="Kirim">
					</div>
				</div>
				
			</div>
			
        </form>
    </div>
</div>
<div class="modal fade" id="tunggakanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lihat Detail Tunggakan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-stripped">
					<thead>
						<tr>
							<th>Jenis Pembayaran</th>
							<th>Tunggakan</th>
							<th>Pembayaran</th>
							<th>Status</th>
						</tr>
					</thead>	
					<tbody>
				<?php 
					foreach($tunggakan as $row){
				?>
				
						<tr>
							<td><?= $row->jenis?></td>
							<td>Rp. <?= number_format($row->kekurangan,0,",",".")?></td>
							<td>Rp. <?= number_format($row->pembayaran,0,",",".")?></td>
							<td><?= ($row->status == 0)?"Belum Lunas":"Lunas"?></td>
						</tr>
					
				<?php
					}
				?>
				</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {

		$('#date').bootstrapMaterialDatePicker({
			time: false,
			clearButton: true
		});
        $('#nama_santri').select2({
            minimumInputLength: 3,
        });
		$(".dataTable").DataTable();;
		// $("#bulan").change(function(){
		// 	$.ajax({
		// 		method:"POST",
		// 		url:"<?= base_url('index.php/pembayaran/get_riwayat') ?>",
		// 		data:{
		// 				bulan:$(this).val(),
		// 				nama_santri:$("#nama_santri2").val(),
		// 			},
		// 		success:function (data){
		// 			$("#tbl_riwayat_pem").html(data);
		// 		}
		// 	});
		// });
        
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
