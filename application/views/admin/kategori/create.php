<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action="<?= (empty($kategori))?base_url('index.php/admin/kategori/insert'):base_url('index.php/admin/kategori/update') ?>">
                    <input type="hidden" name='id' value='<?= (empty($kategori))?"":$kategori->id ?>'>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="kategori" value="<?= (empty($kategori))?"":$kategori->nama ?>" class="form-control col-md-6">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="simpan" class="btn btn-primary"> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>