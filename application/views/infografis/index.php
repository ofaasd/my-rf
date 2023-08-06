<div class="card-header">
        Form Laporan Pembayaran
    </div>
    <div class="card-content">
		<?php if(!empty($this->session->flashdata('message'))){ ?>
            <p class="alert alert-primary"><?= $this->session->flashdata('message') ?></p>
        <?php } ?>
        <?php if(!empty($this->session->flashdata('error'))){ ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p>
        <?php } ?>
        <br />
		<div class="row">
			<div class="col-md-6">
				<p class="alert alert-primary text-center">Grafik Ustadz</p>
				<div>
					<canvas	canvas id="myChart0"></canvas>
				</div>
			</div>
			<div class="col-md-6">
				<p class="alert alert-primary text-center">Grafik Ustadzah</p>	
				<div>
					<canvas	canvas id="myChart1"></canvas>
				</div>
			</div>
			<div class="col-md-6">
				<p class="alert alert-primary text-center">Grafik Santri</p>
				<div>
					<canvas	canvas id="myChart2"></canvas>
				</div>
			</div>
			<div class="col-md-6">
				<p class="alert alert-primary text-center">Grafik Santriwati</p>	
				<div>
					<canvas	canvas id="myChart3"></canvas>
				</div>
			</div>

		</div>
    </div>
</div>
	<br />
<script>
    $(document).ready(function() {
        $('#nama_santri').select2({
            minimumInputLength: 3,
        });
        
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php foreach($jenis_kelamin as $key=>$value){ ?>
  const ctx<?php echo $key; ?> = document.getElementById('myChart<?php echo $key; ?>');
  new Chart(ctx<?php echo $key; ?>, {
    type: 'pie',
    data: {
      labels: [<?php foreach($jabatan as $my_jabatan){ echo "'" . $my_jabatan->jabatan_new . "',"; }?>],
      datasets: [{
        label: '# of person',
        data: [<?php foreach($jabatan as $my_jabatan){ echo $jenis[$value][$my_jabatan->jabatan_new] . ","; }?>],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  <?php } ?>
</script>
