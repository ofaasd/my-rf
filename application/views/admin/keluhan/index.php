<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content" style="overflow-x:scroll; padding:20px;">
            <div class="col-md-12">
                <!--<a href="<?=base_url('/admin/keluhan/create')?>" class="btn btn-primary">Tambah</a><br /><br />-->
                <table class="table table-hover table-stripped" id="my-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama Pelapor</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Nama Santri</th>
                            <!--<th>Nama Wali Santri</th>-->
                            <th>Masukan</th>
                            <th>Saran</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach($keluhan as $row){
                       ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=date('d-m-Y', strtotime($row->created_at))?></td>
                            <td><?=$row->nama_pelapor?></td>
                            <td><?=$row->email?></td>
                            <td><?=$row->no_hp?></td>
                            <td><?=$row->id_santri?></td>
                            <!--<td><?=$row->nama_wali_santri?></td>-->
                            <td><?= (strlen($row->masukan) > 100) ? substr($row->masukan,0,100) . ' [...]':$row->masukan?></td>
                            <td><?= (strlen($row->saran) > 100) ? substr($row->saran,0,100) . ' [...]':$row->saran?></td>
                            <th>
								<div class="btn-group btn-group-xs">
									<a href='<?=base_url('index.php/admin/keluhan/show/' . $row->id )?>' class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
									<a href='<?=base_url('index.php/admin/keluhan/delete/' . $row->id )?>' class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus ?');"><i class="fa fa-trash"></i></a>
								</div>
                            </th>
                        </tr>
                        <?php
                            $i++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>