<section class="col-lg-12 connectedSortable">
    <div class="card">
        <div class="card-content">
            <div class="col-md-12">
                <form method="POST" action=''>
                    <div class="form-group">
                        <label for="periode">Periode</label>
						<div class="row justify-content-center">
							<input type='date' name="date_start" class='form-control col-md-4' value='<?php echo (empty($date_start))?date('Y-m-d'):$date_start?>'>
							<div class="col-md-2 text-center">-</div>  
							<input type='date' name="date_end" class='form-control col-md-4' value='<?php echo (empty($date_end))?date('Y-m-d'):$date_end?>'>
						</div>
                    </div> 
                    <div class="row justify-content-center">
						<div class='col-md-9 text-center'>
							<input type="submit" value='Lihat Data' class='btn btn-primary col-md-3'>
						</div>
					</div>
                </form><br />
                <?php
                    if(!empty($keluhan)){
                ?>
                    <h2 style='text-align:center'>Keluhan <?=date('d-m-Y', strtotime($date_start))?> - <?=date('d-m-Y', strtotime($date_end))?></h2>
                        <table class="" id="table-laporan">
                            <thead>
                                <tr>
                                    <td>No.</td>
                                    <td>Masukan</td>
                                    <td>Saran</td>
									<td>Tanggal</td>
									<td>Nama Santri</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1; 
                                    foreach($keluhan as $row){
                                    $total = 0;
                                ?>
                                    <tr>
                                        <td valign="top"><?=$i?></td>
										<td valign="top"><?=$row->masukan?></td>
										<td valign="top"><?=$row->saran?></td>
										<td valign="top"><?=date('d-m-Y', strtotime($row->created_at))?></td>
										<td valign="top"><?=$row->id_santri . " - " . $list_siswa[$row->id_santri]?></td>
                                    </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                <?php
                    }else{
						echo "Data Tidak Ditemukan";
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
					title: 'Admin Page PPATQ Raudlatul Falah  Syahriyah Januari 2023 | <?=date('Ymd His')?>'
				}, 'pdf', 'print'
            ],
        });
    } );
</script>
