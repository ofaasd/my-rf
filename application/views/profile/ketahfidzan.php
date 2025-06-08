<div class="card-header">
    Ketahfidzan <span class="font-weight-bold"><?= $detailSantri->nama; ?></span>
</div>
<div class="card-content">
	<table>
	<?php
	$uniqueData = [];

	foreach ($ketahfidzan as $tahun => $bulanData) { 
		foreach ($bulanData as $bulan => $entries) {
			foreach ($entries as $row) {
				$uniqueData[$row->kode] = $row->nmJuz; // Simpan pasangan kode => nmJuz
			}
		}
	}

	// Urutkan berdasarkan kode (ascending)
	ksort($uniqueData);
	?>

	<table class="mb-2">
		<?php foreach ($uniqueData as $kode => $nmJuz) : ?>
			<tr>
				<td>
					<small class="fw-italic"><?= $kode; ?> = <?= $nmJuz; ?></small>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	</table>
	<div class="row mb-5">
		<div class="col-12">
			<p class="alert alert-info text-center">Grafik Ketahfidzan <?= date('Y')-1 ?></p>
			<div>
				<canvas id="lineChart"></canvas>
			</div>
		</div>
	</div>
	<div class="row">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Surah</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($ketahfidzan as $tahun => $bulanData) : ?>
					<tr style="background-color:#2dcc70; color: whitesmoke;">
						<td colspan="2" class="text-center"><strong><?= $tahun ?></strong></td>
					</tr>
					<?php foreach ($bulanData as $bulan => $entries) : ?>
						<?php foreach ($entries as $row) : ?>
							<tr>
								<td><?= date('d', strtotime($row->tanggal)) . " " . $bulan . " " . $tahun; ?></td>
								<td><?= $row->nmJuz ?? "Data tidak ada"; ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endforeach; ?> 
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	// Ambil elemen canvas dan context-nya
	const ctx = document.getElementById('lineChart').getContext('2d');

	console.log([<?php 
				foreach ($ketahfidzan as $tahun => $bulanData) : 
					if ($tahun == date('Y')-1) {
						foreach ($bulanData as $bulan => $entries) :
							echo "'" . $tahun . "',";
						endforeach;
					}
				endforeach;
				?>]);

	// Data untuk grafik
	const data = {
		labels: [<?php 
					$bulanArray = [];

					foreach ($ketahfidzan as $tahun => $bulanData) {
						if ($tahun == date('Y')-1) {
							foreach ($bulanData as $bulan => $entries) {
								$bulanArray[] = $bulan;
							}
						}
					}
					
					// Mengurutkan array bulan dalam urutan naik (1, 2, 3, ..., 12)
					sort($bulanArray);
					
					// Menampilkan hasil dalam format JavaScript array
					echo implode(",", array_map(fn($b) => "'$b'", $bulanArray));
				?>],
		datasets: [{
			label: '<?= $detailSantri->nama; ?>',
			data: [<?php 
					$kodeArray = [];

					// Mengumpulkan semua kode dalam array
					foreach ($ketahfidzan as $tahun => $bulanData) {
						if ($tahun == date('Y')-1) {
							foreach ($bulanData as $bulan => $entries) {
								foreach ($entries as $row) {
									$kodeArray[] = $row->kode;
								}
							}
						}
					}
					
					// Mengurutkan array berdasarkan nilai kode (dari kecil ke besar)
					sort($kodeArray);
					
					// Menampilkan hasil dalam format JavaScript array
					echo implode(",", array_map(fn($kode) => "'$kode'", $kodeArray));
				?>], // Data
			fill: true,
			borderColor: 'rgb(75, 192, 192)', // Warna garis
			tension: 0.1 // Memberikan efek lengkung pada garis
		}]
	};

	// Konfigurasi grafik
	const config = {
		type: 'line',
		data: data
	};

	// Inisialisasi Chart.js
	new Chart(ctx, config);
</script>
