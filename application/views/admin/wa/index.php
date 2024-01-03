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
                <?php
                    if(!empty($this->session->flashdata('error'))){
                ?>
                    <p class="alert alert-danger {{ Session::get('alert-class', 'alert-danger') }}"><?= $this->session->flashdata('error') ?></p>
                <?php
                    }
                ?>
                <a href="<?php echo base_url('index.php/admin/whatsapp/create/') ?>" class="btn btn-primary">Tambah</a><a href="<?php echo base_url('index.php/admin/whatsapp/create_kelas/') ?>" class="btn btn-primary">Tambah Kelas</a><br /><br />
                <table class="table table-hover table-stripped" id="my-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>No. WA</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                            <th>Tanggal Kirim</th>
                            <th>Periode Pembayaran</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $i = 1;
                        foreach($wa as $row){
                       ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row->nama ?></td>
                            <td><?= $row->no_wa ?></td>
                            <td><?= $row->pesan ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($row->created_at)) ?></td>
                            <td><?= $row->tanggal_kirim ?></td>
                            <td><?= $bulan[$row->periode] ?></td>
                            <td><?= ($row->status == 0)?"Tidak Terkirim":"Terkirim" ?></td>
                            <td>
								<div class="btn-group btn-group-xs">
                                    <a href='<?php echo base_url('index.php/admin/whatsapp/edit/' . $row->id) ?>' class="btn btn-primary"><i class="fa fa-pencil-alt"></i></a>   
                                    <a href='<?php echo base_url('index.php/admin/whatsapp/resend/' . $row->id) ?>' class="btn btn-success"><i class="fa fa-share"></i></a>   
                                    <a href='<?php echo base_url('index.php/admin/whatsapp/delete/' . $row->id) ?>' class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus ?');"><i class="fa fa-trash"></i></a>
								</div>
                            </td>
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
