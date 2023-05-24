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
                <a href="<?php echo base_url('index.php/admin/user/create/') ?>" class="btn btn-primary">Tambah</a>
                <table class="table table-hover table-stripped" id="my-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $i = 1;
                        foreach($user as $row){
                       ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row->name ?></td>
                            <td><?= $row->username ?></td>
                            <td><?= $row->email ?></td>
                            <td><?= $row->roles ?></td>
                            <th>
                                <a data-toggle = "tooltip" title = "Edit Pengguna <?=$row->name?>" href='<?php echo base_url('index.php/admin/user/edit/' . $row->id) ?>' class="btn btn-primary"><i class="fa fa-pencil-alt"></i></a>
								<a data-toggle = "tooltip" title = "Ganti Password Pengguna <?=$row->name?>" href='<?php echo base_url('index.php/admin/user/edit_password/' . $row->id) ?>' class="btn btn-success"><i class="fa fa-key"></i></a>
                                <a data-toggle = "tooltip" title = "Hapus Pengguna <?=$row->name?>" href='<?php echo base_url('index.php/admin/user/delete/' . $row->id) ?>' class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus ?');"><i class="fa fa-trash"></i></a>
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
<script>
    $(document).ready(function(){
        document.getElementById('user').addEventListener('change', handleFileSelect, false);
    });
</script>