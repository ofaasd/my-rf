<div class="shadow-sm p-3 mb-2">
        <h6>Form Laporan Pembayaran</h6>
    </div>
    <div class="card-content">
		<?php if(!empty($this->session->flashdata('message'))){ ?>
            <p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
        <?php } ?>
        <?php if(!empty($this->session->flashdata('error'))){ ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
        <?php } ?>
        <p class="alert alert-warning">Harap pastikan data kelas yang dimasukan adalah data kelas yang baru (setelah kenaikan kelas) </p>
        <br />
		<?php if($bukatutup->status == 0){ ?>
			<p class="alert alert-danger">Pelaporan Pembayaran Pada Bulan ini ditutup sementara</p>
		<?php }else{ ?>
			<p class="alert alert-warning">Mohon Tunggu Beberapa saat data kelas 1 sedang dalam proses penginputan</p>
        <br />
        <form method="POST" enctype='multipart/form-data' action="<?= base_url('index.php/pembayaran/detail_pembayaran') ?>">
            <div class="form-group">
                <label class="form-label">Nama Santri</label><br />
                <select id="nama_santri" name="nama_santri" class="form-control col-md-6">
                    <option value=0>Masukan Nama Santri</option>
                    <?php
                        foreach($siswa as $row){
                    ?>
                        <option value="<?= $row->no_induk ?>"><?= $row->nama ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Kode Kelas / Kode Murobbi</label>
                <select name="kode" class="form-control col-md-3">
                    <?php
                        foreach($kode as $row){
                    ?>
                        <option value="<?= $row->kelas ?>"><?= $row->kelas ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
			<div class="form-group">
				<label class="form-label">Periode Bayar</label>
				<select name="periodes" class="form-control col-md-6" disabled>
					<?php foreach($bulan as $key=>$value){ ?>
					<option value="<?=$key?>" <?= (date('m') == $key)?"selected":""?>><?=$value?></option>
					<?php } ?>
				</select>
                <input type="hidden" name="periode" value='<?=date('m')?>'>
			</div>
			
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Konfirmasi">
				<a href="<?= base_url('index.php/infografis') ?>" class="btn btn-secondary">Infografis</a>
            </div>
        </form>
		<?php } ?>
		<br />
    </div>
</div>
	<br />
<script>
    $(document).ready(function() {
        $('#nama_santri').select2({
            minimumInputLength: 3,
        });
        
    });
</script>
