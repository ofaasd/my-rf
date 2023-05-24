<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-6">
				<div class="small-box bg-info">
					<div class="inner">
						<h3><?=$siswa ?></h3>
						<p>Santri</p>
					</div>
					<div class="icon">
						<i class="ion ion-person"></i>
					</div>
					<a href="<?=base_url('index.php/admin/siswa')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-warning">
					<div class="inner">
						<h3><?=$keluhan?></h3>
						<p>Keluhan / Aduan</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?=base_url('index.php/admin/keluhan')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-danger">
					<div class="inner">
						<h3><?=$cash?></h3>
						<p>Pembayaran Cash</p>
					</div>
					<div class="icon">
						<i class="ion ion-cash"></i>
					</div>
					<a href="<?=base_url('index.php/admin/pembayaran')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-success">
					<div class="inner">
						<h3><?=$bank?></h3>
						<p>Pembayaran bank Transfer</p>
					</div>
					<div class="icon">
						<i class="ion ion-cash"></i>
					</div>
					<a href="<?=base_url('index.php/admin/pembayaran')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-md-12">
				<div class="card card-success">
				  <div class="card-header">
					<h3 class="card-title">Keluhan</h3>

					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					  </button>
					  <button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					  </button>
					</div>
				  </div>
				  <div class="card-body">
					<div class="form-group row">
						<select name="bulan" id="bulan_keluhan" class="form-control col-md-6" onchange="show_jumlah_keluhan()">
							<?php foreach($bulan as $key=>$value){?>
								<option value="<?=$key?>" <?=(date('m') == $key)?"selected":""?>><?=$value?></option>
							<?php } ?>
						</select>
						<select name="tahun" id="tahun_keluhan" class="form-control col-md-6" onchange="show_jumlah_keluhan()">
							<?php for($i=date('Y');$i>=(date('Y') - 5);$i--){?>
								<option value="<?=$i?>" <?=(date('Y') == $i)?"selected":""?>><?=$i?></option>
							<?php } ?>
						</select>
						
					</div>
					<div class="chart">
					  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
				  </div>
				  <!-- /.card-body -->
				</div>
			</div>
		</div>
	</div>
</div>
<div id="target"></div>
<script>
	
	$(document).ready(function(){
		
		show_jumlah_keluhan();
		
	});
	function show_jumlah_keluhan(){
		var bulan_keluhan = $("#bulan_keluhan").val();
		var tahun_keluhan = $("#tahun_keluhan").val();
		
		$.ajax({
			method:"POST",
			url:"<?=base_url('index.php/operator/dashboard/jumlah_keluhan')?>",
			data:"bulan="+bulan_keluhan+"&tahun="+tahun_keluhan,
			success:function(data){
				$("#target").html(data);
			}
		});
	}
</script>