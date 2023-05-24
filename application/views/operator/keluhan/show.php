<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <a href="<?=base_url('index.php/operator/keluhan')?>" class="btn btn-primary">Kembali</a><br /><br />
                <table class="table table-hover">
                    <tr>
                        <td>Jenis</td>
                        <td><?=$keluhan->jenis?></td}}>
                    </tr>
                    <tr>
                        <td>Nama Pelapor</td>
                        <td><?=$keluhan->nama_pelapor?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?=$keluhan->email?></td>
                    </tr>
                    <tr>
                        <td>No. HP</td>
                        <td><?=$keluhan->no_hp?></td>
                    </tr>
                    <tr>
                        <td>Nama Santri</td>
                        <td><?=$keluhan->id_santri?></td>
                    </tr>
                    <tr>
                        <td>Nama Wali Santri</td>
                        <td><?=$keluhan->nama_wali_santri?></td>
                    </tr>
                    <tr>
                        <td>Masukan</td>
                        <td><?=$keluhan->masukan?></td>
                    </tr>
                    <tr>
                        <td>Saran</td>
                        <td><?=$keluhan->saran?></td>
                    </tr>
                    <tr>
                        <td>Gambar</td>
                        <td><?=$keluhan->gambar?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?=$keluhan->status?></td>
                    </tr>
                    <tr>
                        <td>Rating</td>
                        <td><?=$keluhan->rating?></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td><?=$keluhan->created_at?></td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>
</section>