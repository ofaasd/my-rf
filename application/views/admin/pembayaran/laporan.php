<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action=''>
                    <div class="form-group">
                        <label for="periode">Periode</label>
                        <select name="periode" id="periode" class='form-control col-md-4'>
                            <option value="0">Semua</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="periode">Tahun</label>
                        <input type="number" name='tahun' class='form-control col-md-2' value='<?= date('Y')?>'>
                    </div> 
                    <input type="submit" value='kirim' class='btn btn-primary'>
                </form><br />
                <?php
                    if(!empty($santri)){
                ?>
                    <h2 style='text-align:center'>Syahriyah <?=$bulan[$periode]?> <?= $tahun ?></h2>
                        <table class="" id="table-laporan">
                            <thead>
                                <tr>
                                    <td>No.</td>
                                    <td>Kode Kelas</td>
									<td>Kode Murroby</td>
									<td>No. no_induk</td>
                                    <td>Nama Santri</td>
                                    <?php 
                                        foreach($jenis_pembayaran as $row){
                                    ?>
                                        <td><?= $row->jenis ?></td>
                                    <?php
                                        }
                                    ?>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1; 
                                    foreach($siswa as $s){
                                    $total = 0;
                                ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$s->kelas?></td>
                                        <td><?=$s->kamar_id?> (<?= $nama_murroby[$s->kamar_id] ?>)</td>
                                        <td><?=$s->no_induk?></td>
                                        <td><?=$s->nama?></td>
                                        <?php 
                                            foreach($jenis_pembayaran as $row){
                                        ?>
                                            <td>Rp. <?= number_format($santri[$s->no_induk][$row->id],0,',','.')?></td>
                                        <?php
                                            $total += $santri[$s->no_induk][$row->id];
                                            }
                                        ?>
                                        <td>Rp. <?= number_format($total,0,',','.') ?></td>
                                    </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready( function () {
        $('#table-laporan').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pageLength','copy', 'csv',  
				{
					extend: 'excelHtml5',
					title: 'Admin Page PPATQ Raudlatul Falah  Syahriyah <?=$bulan[$periode]?> <?= $tahun ?> | <?=date('Ymd His')?>'
				}, 'pdf', 'print'
            ],
        });
    } );
</script>
