<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <?php
                    if(!empty($this->session->flashdata('message'))){
                ?>
                    <p class="alert alert-primary {{ Session::get('alert-class', 'alert-info') }}"><?= $this->session->flashdata('message') ?></p>
                <?php
                    }
                ?>
				<p class="alert alert-primary">Klik Tombol di bawah untuk membuka / menutup laporan pembayaran</p>
				<?php if($bukatutup->status == 0) { ?>
                <a href="<?php echo base_url('index.php/admin/bukatutup/insert/') ?>" class="btn btn-success">Buka Pelaporan</a><br /><br />
				<?php
				}else{
				?>
				<a href="<?php echo base_url('index.php/admin/bukatutup/insert/') ?>" class="btn btn-danger">Tutup Pelaporan</a><br /><br />
				<?php
				}
				?>
				<small><i>Terakhir Dilakukan perubahan pada tanggal <?php echo date('d-m-Y H:i:s', strtotime($bukatutup->tanggal_buat))?></i></small>
				<br /><br />
            </div>
        </div>
    </div>
</section>