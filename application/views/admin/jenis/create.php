<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action="<?= (empty($jenis))?base_url('index.php/admin/jenis/insert'):base_url('index.php/admin/jenis/update') ?>">
                    <input type="hidden" name='id' value='<?= (empty($jenis))?"":$jenis->id ?>'>
                    <div class="form-group">
                        <label for="jenis">Jenis</label>
                        <input type="text" name="jenis" id="jenis" value="<?= (empty($jenis))?"":$jenis->jenis ?>" class="form-control col-md-6">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="simpan" class="btn btn-primary"> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>