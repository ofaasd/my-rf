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
                <a href="<?php echo base_url('index.php/admin/jenis/create/') ?>" class="btn btn-primary">Tambah</a><br /><br />
                <table class="table table-hover table-stripped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jenis</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $i = 1;
                        foreach($jenis as $row){
                       ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row->jenis ?></td>
                            <th>
                                <a href='<?php echo base_url('index.php/admin/jenis/edit/' . $row->id) ?>' class="btn btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                <a href='<?php echo base_url('index.php/admin/jenis/delete/' . $row->id) ?>' class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus ?');"><i class="fa fa-trash"></i></a>
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