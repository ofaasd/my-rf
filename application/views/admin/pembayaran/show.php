<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <a href="<?=base_url('index.php/admin/pembayaran')?>" class="btn btn-primary">Kembali</a><br /><br />
                <table class="table table-hover">
                    <tr>
                        <td>Nama Santri</td>
                        <td><?=$siswa[$pembayaran->nama_santri]?></td}}>
                    </tr>
                    <tr>
                        <td>Murroby</td>
                        <td><?=$kode_murroby?> (Ust. <?=$nama_murroby?>)</td}}>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>Rp. <?=number_format($pembayaran->jumlah,0,",",".")?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Bayar</td>
                        <td><?=$pembayaran->tanggal_bayar?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td><?=$pembayaran->periode?></td>
                    </tr>
                    <tr>
                        <td>Bank Pengirim</td>
                        <td><?=$bank[$pembayaran->bank_pengirim]?></td>
                    </tr>
                    <tr>
                        <td>Atas Nama</td>
                        <td><?=$pembayaran->atas_nama ?></td>
                    </tr>
                    <tr>
                        <td>Bukti Bayar</td>
                        <td><img src='<?php echo base_url('assets') ?>/upload/<?=$pembayaran->bukti ?>'></td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td><?=$pembayaran->catatan?></td>
                    </tr>
                    <tr>
                        <td>No. WA</td>
                        <td><?=$pembayaran->no_wa?></td>
                    </tr>
                    <tr>
                        <td colspan=2 align="center"><h3>Detail Pembayaran</h3></td>
                    </tr>
					<tr>
						<td>Tunggakan</td>
						<td>Rp. <?= number_format($pembayaran->jumlah_tunggakan,0,",",".") ?></td>
					</tr>
                    <?php
                        $jumlah = 0;
						$jumlah += $pembayaran->jumlah_tunggakan;
                        foreach($detail as $row){
                    ?>
                        <tr>
                            <td><?=$jenis[$row->id_jenis_pembayaran]?></td>
                            <td>Rp. <?=number_format($row->nominal,0,",",".")?></td>
                        </tr>
                    <?php
                        $jumlah += $row->nominal;
                        }
						
                    ?>
                    <tr>
                        <td><b>Total</b></td>
                        <td><b>Rp. <?=number_format($jumlah,0,",",".")?></b></td>
                    </tr>
                    <tr>
                        <td>Validasi</td>
                        <td>
                            <?php
                                if($pembayaran->validasi == 0){
                                    echo "<p class='text text-danger'>Belum Valid</p>";
                                    echo "<a href='" . base_url('index.php/admin/pembayaran/new_validasi/' . $pembayaran->id. '/1') . " ' class='btn btn-primary''>Validasi Sekarang</a>";
									echo "&nbsp; &nbsp; &nbsp; <a href='" . base_url('index.php/admin/pembayaran/new_validasi/' . $pembayaran->id. '/2') . " ' class='btn btn-danger' style='background:#c0392b'>Tolak Validasi</a>";
                                }elseif($pembayaran->validasi == 2){
									echo "<p class='text text-danger'>Validasi Ditolak</p>";
									echo "<a href='" . base_url('index.php/admin/pembayaran/new_validasi/' . $pembayaran->id. '/1') . " ' class='btn btn-primary''>Validasi Sekarang</a>";
									echo "&nbsp; &nbsp; &nbsp; <a href='" . base_url('index.php/admin/pembayaran/new_validasi/' . $pembayaran->id. '/0') . " ' class='btn btn-danger''>Batalkan Validasi</a>";
								}else{
                                    echo "<p class='text text-success'>Valid</p>";
                                    echo "<a href='" . base_url('index.php/admin/pembayaran/new_validasi/' . $pembayaran->id. '/0') . " ' class='btn btn-danger''>Batalkan Validasi</a>";
									echo "&nbsp; &nbsp; &nbsp; <a href='" . base_url('index.php/admin/pembayaran/new_validasi/' . $pembayaran->id. '/2') . " ' class='btn btn-danger' style='background:#c0392b'>Tolak Validasi</a>";
                                }
								
                                    
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tipe Pembayaran</td>
                        <td>
                            <?php
                               
                                echo "<p class='text text-primary '>" . $pembayaran->tipe . "</p>";
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
