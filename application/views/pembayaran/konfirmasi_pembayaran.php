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

        <br />
		<p class="alert alert-primary">Silahkan Lihat Riwayat untuk melihat status terbaru validasi yang dilakukan oleh admin</p>
        <p>Silahkan klik tombol dibawah untuk mengunduh bukti bayar</p>
		<div style="text-align:center"><a href='<?=base_url('index.php/pembayaran/print_bukti/' . $id )?>' class="btn btn-success btn-sm">Download</a></div>
		
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