<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action="<?= (empty($wa))?base_url('index.php/admin/whatsapp/insert'):base_url('index.php/admin/whatsapp/update') ?>">
                    <input type="hidden" name='id' value='<?= (empty($wa))?"":$wa->id ?>'>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" value="<?= (empty($wa))?"":$wa->nama ?>" class="form-control col-md-6">
                    </div>
                    <div class="form-group">
                        <label for="nama">No. WA</label>
                        <input type="text" name="no_wa" id="no_wa" value="<?= (empty($wa))?"":$wa->no_wa ?>" class="form-control col-md-6">
                    </div>
                    <div class="form-group">
                        <label for="nama">Pesan</label>
                        <textarea name="pesan" class="form-control"><?= (empty($wa))?"":$wa->pesan ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="simpan" class="btn btn-primary"> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>