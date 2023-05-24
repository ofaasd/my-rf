<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
            <a href="<?=base_url('index.php/admin/pembayaran')?>" class="btn btn-primary">Kembali</a><br /><br />
            <?php if(!empty($this->session->flashdata('message'))){ ?>
                <p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
            <?php } ?>
            <?php if(!empty($this->session->flashdata('error'))){ ?>
                <p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
            <?php } ?>
            <br />
            <form method="POST" enctype='multipart/form-data' action="<?= base_url('index.php/admin/pembayaran/simpan') ?>">
                <div class="form-group">
                    <label class="form-label">Jenis Pembayaran</label><br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" required type="radio" checked name="tipe" id="bank_transfer" value="Bank">
                        <label class="form-check-label" for="bank_transfer">Bank Transfer</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipe" id="cash" value="Cash">
                        <label class="form-check-label" for="cash">Cash</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Santri</label><br />
                    <select id="nama_santri" name="nama_santri" class="form-control col-md-6" onchange="update_riwayat()">
                        <option value=0>Masukan Nama Santri</option>
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
					
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
					  Lihat Riwayat Pembayaran
					</button>
					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Riwayat Pembayaran</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body" id="riwayat">
							<div class="alert alert-primary">
								Belum ada riwayat pembayaran
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						  </div>
						</div>
					  </div>
					</div>
				
				</div>
                <div class="form-group">
                    <label class="form-label">Pembayaran Sebesar (Rp)</label>
                    <input class="form-control col-md-6" type="text" onkeyup="splitInDots(this)" name="jumlah" >
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Bayar</label>
                    <input class="form-control col-md-6" type="date" name="tanggal_bayar">
                </div>
                <div class="form-group">
                    <label class="form-label">Periode Bayar</label>
                    <select name="periode" class="form-control col-md-6" id="periode" onchange="update_riwayat()">
						<?php foreach($bulan as $key=>$row){ ?>
                        <option value="<?= $key ?>" <?= ($key == date('m'))?"selected":""?>><?= $row ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" name="tahun" value="<?= date('Y')?>">
                <div class="form-group" id="bank_pengirim">
                    <label class="form-label">Bank Pengirim</label>
                    <select name="bank_pengirim"  class="form-control col-md-6">
                        <?php foreach($bank_pengirim as $bank){ ?>
                            <option value="<?=$bank->id?>"><?=$bank->nama?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group" id="atas_nama">
                    <label class="form-label">Pengirim Atas Nama</label>
                    <input class="form-control col-md-6" type="text" name="atas_nama" >
                </div>
                <div class="form-group">
                    <label class="form-label">Pembayaran</label>
                    <table class="table col-md-6">
						<tr>
							<td>Tunggakan</td>
							<td><input type="text" id="tunggakan_value" onkeyup="splitInDots(this)" placeholder="0" name="tunggakan" class="form-control" value="0" ></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tunggakanModal">
									Lihat
								</button>
							</td>
						</tr>
                        <?php foreach($jenis_pembayaran as $jenis_pembayaran) { ?>
                            <tr>
                                <td><?=$jenis_pembayaran->jenis?><input type="hidden" name="id_jenis_pembayaran[]" value='<?= $jenis_pembayaran->id ?>'></td>
                                <td><input type="text" onkeyup="splitInDots(this)" placeholder="0" name="jenis_pembayaran[]" class="form-control"></td>
                            </tr>
                        <?php } ?>
                    </table>    
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-control col-md-12" name="catatan" ></textarea>
                </div>
                <div class="form-group" id="bukti_bayar">
                    <label class="form-label">Upload Bukti Bayar</label>
                    <input type="file" class="form-control col-md-6" name="bukti">
                </div>

                <div class="form-group">
                    <label class="form-label">No. Wa / Telp Konfirmasi</label>
                    <input class="form-control col-md-6" type="text" name="no_wa">
                </div>
                <div class="form-group">
                    <label class="form-label">Validasi</label><br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" required type="radio" checked name="validasi" id="inlineRadioJenis1" value="1">
                        <label class="form-check-label" for="inlineRadioJenis1">Valid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="validasi" id="inlineRadioJenis2" value="0">
                        <label class="form-check-label" for="inlineRadioJenis2">Tidak Valid</label>
                    </div>
					<div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="validasi" id="inlineRadioJenis2" value="2">
                        <label class="form-check-label" for="inlineRadioJenis2">Ditolak</label>
                    </div>
                </div>
				<div class="form-group">
					<label class="form-label">Catatan Validasi</label>
					<textarea name="note_validasi" class="form-control col-md-6"></textarea>
				</div>
                
                <div class="form-group">
                    <input type="submit" class="form-control col-md-12 btn btn-primary" value="Kirim">
                </div>
            </form>
            </div>
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
				<div class="modal-body" id="target_tunggakan">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
    $(document).ready(function() {
        $('#nama_santri').select2({
            minimumInputLength: 3,
        });
		
		
        $("#cash").on("change",function(){
            $("#bukti_bayar").hide();
            $("#bank_pengirim").hide();
            $("#atas_nama").hide();
        });
        $("#bank_transfer").on("change",function(){
            $("#bukti_bayar").show();
            $("#bank_pengirim").show();
            $("#atas_nama").show();
        });
    });
	function update_riwayat(){
		//alert("asdasdasd");
		$.ajax({
			url:'<?= base_url('index.php/admin/pembayaran/get_riwayat') ?>',
			data:'nama_santri='+$('#nama_santri').val()+'&periode='+$("#periode").val(),
			method:'POST',
			success: function(data){
				$("#riwayat").html(data);
			}
		});
		
		$.ajax({
			url:'<?= base_url('index.php/admin/pembayaran/get_jumlah_tunggakan') ?>',
			data:'nama_santri='+$('#nama_santri').val(),
			method:'POST',
			success: function(data){
				$("#tunggakan_value").val(data);
			}
		});
		$.ajax({
			url:'<?= base_url('index.php/admin/pembayaran/get_tunggakan') ?>',
			data:'nama_santri='+$('#nama_santri').val(),
			method:'POST',
			success: function(data){
				$("#target_tunggakan").html(data);
			}
		});
	
	}
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