<div class="shadow-sm p-3 mb-2">
        <h6>
            Form Sumbang Saran
        </h6>
    </div>
    <div class="card-content">
        <?php if(!empty($this->session->flashdata('message'))){ ?>
            <p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
        <?php } ?>
        <?php if(!empty($this->session->flashdata('error'))){ ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
        <?php } ?>
        <br />
        <form method="POST" action="<?php echo base_url('index.php/keluhan/insert') ?>">
            <div class="form-group">
                <label class="form-label">Jenis Laporan</label><br />
                <div class="form-check form-check-inline">
                    <input class="form-check-input" required type="radio" checked name="jenis" id="inlineRadioJenis1" value="Aduan">
                    <label class="form-check-label" for="inlineRadioJenis1">Aduan</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis" id="inlineRadioJenis2" value="Keluhan">
                    <label class="form-check-label" for="inlineRadioJenis2">Keluhan</label>
                </div>
            </div>  
            <div class="form-group">
                <label class="form-label">Nama Pelapor</label>
                <input class="form-control col-md-6" type="text" name="nama_pelapor" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input class="form-control col-md-6" type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input class="form-control col-md-6" type="email" name="email" >
                <small id="passwordHelp" class="form-text text-muted">* Email Tidak Wajib Diisi</small>
            </div>
            <div class="form-group">
                <label class="form-label">No. HP</label>
                <input class="form-control col-md-6" type="text" name="no_hp" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Santri</label><br />
                <select id="nama_santri"  name="nama_santri" class="form-control col-md-6" required>
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
                <select name="kode" class="form-control col-md-3" required>
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
                <label class="form-label">Nama Wali Santri</label>
                <input class="form-control col-md-6" type="text" name="nama_wali_santri" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control col-md-6" required>
                    <?php
                        foreach($kategori as $row){
                    ?>
                        <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Keluhan / Aduan</label>
                <textarea class="form-control col-md-12" name="masukan" required ></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Masukan / Saran / Kesan</label>
                <textarea class="form-control col-md-12" name="saran" required ></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Berikan rating kepuasan layanan, skala 1~10</label><br />
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value="1" required>
                    <label class="form-check-label" for="inlineRadio1">1</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">2</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio3" value="3">
                    <label class="form-check-label" for="inlineRadio3">3</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio4" value="4">
                    <label class="form-check-label" for="inlineRadio4">4</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio5" value="5">
                    <label class="form-check-label" for="inlineRadio5">5</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio6" value="4">
                    <label class="form-check-label" for="inlineRadio6">6</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio7" value="4">
                    <label class="form-check-label" for="inlineRadio7">7</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio8" value="4">
                    <label class="form-check-label" for="inlineRadio8">8</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio9" value="4">
                    <label class="form-check-label" for="inlineRadio9">9</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="inlineRadio10" value="4">
                    <label class="form-check-label" for="inlineRadio10">10</label>
                </div>
                <br /><br />
                <input type="submit" class="form-control col-md-12 btn btn-primary" value="Kirim">
            </div>
        </form>
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