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
                <a href="<?php echo base_url('index.php/admin/siswa/create/') ?>" class="btn btn-primary">Tambah</a>
                
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Upload Data
                </button>
				<a href="<?php echo base_url('index.php/admin/siswa/download/') ?>" class="btn btn-primary">Download Data</a>
                <table class="table table-hover table-stripped" id="my-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kelas</th>
                            <th>No Induk</th>
                            <th>Nama</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $i = 1;
                        foreach($siswa as $row){
                       ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row->kelas ?></td>
                            <td><?= $row->no_induk ?></td>
                            <td><?= $row->nama ?></td>
                            <th>
                                <a href='<?php echo base_url('index.php/admin/siswa/edit/' . $row->id) ?>' class="btn btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                <a href='<?php echo base_url('index.php/admin/siswa/delete/' . $row->id) ?>' class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus ?');"><i class="fa fa-trash"></i></a>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?= base_url('index.php/admin/siswa/import')?>" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Data Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                            if(!empty($this->session->flashdata('error'))){
                        ?>
                            <p class="alert alert-danger {{ Session::get('alert-class', 'alert-danger') }}"><?= $this->session->flashdata('error') ?></p>
                        <?php
                            }
                        ?>
                        <p>Download Format Upload File dengan mengklik tombol di bawah ini</p> 
                        <a href="<?=base_url('assets/files/data_siswa.xlsx')?>" class="btn btn-primary">Format</a>
                        <hr />
                        <label for="siswa"><h3>Upload File Excel</h3></label>
                        <input type="file" required name="siswa" class="form-control" id="siswa"><br />
                        <textarea class="form-control" name="list_siswa" required readonly  id="xlx_json"></textarea>
						<div class="form-group">
							<label for="kelas">Kelas</label>
							<select name="kelas" class="form-control">
								<?php foreach($kode as $row){ ?>
								<option value="<?= $row->kode ?>"><?= $row->kode ?></option>
								<?php } ?>
							</select>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        document.getElementById('siswa').addEventListener('change', handleFileSelect, false);
    });
</script>