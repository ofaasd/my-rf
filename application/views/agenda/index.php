<div class="card-header">
	Agenda
</div>
<div class="card-content">
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					Agenda Akan Datang
				</div>
				<div class="card-content">
					<table class="table table-stripped">
						<tbody>
							<?php foreach($agenda_akan_datang as $row) {
								echo "<tr>
									<td><a href='" . base_url('index.php/agenda/show/' . $row->id) . "'>" . $row->judul . "</a>  <br /> <small> " . date('d-m-Y H:i:s', strtotime($row->tanggal_mulai)) . " - " . date('d-m-Y H:i:s', strtotime($row->tanggal_selesai)) . "</small></td>
									
								</tr>";
							}?>
						</tbody>
					</table>
				</div>
			</div>	
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					Agenda Sekarang
				</div>
				<div class="card-content">
					<table class="table table-stripped">
						<tbody>
							<?php foreach($agenda_sekarang as $row) {
								echo "<tr>
									<td><a href='" . base_url('index.php/agenda/show/' . $row->id) . "'>" . $row->judul . "</a> <br /> <small> " . date('d-m-Y H:i:s', strtotime($row->tanggal_mulai)) . " - " . date('d-m-Y H:i:s', strtotime($row->tanggal_selesai)) . "</small></td>
									
								</tr>";
							}?>
						</tbody>
					</table>			
				</div>
			</div>	
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					Agenda Lalu
				</div>
				<div class="card-content">
					<table class="table table-stripped">
						<tbody>
							<?php foreach($agenda_lalu as $row) {
								echo "<tr>
									<td><a href='" . base_url('index.php/agenda/show/' . $row->id) . "'>" . $row->judul . "</a>  <br /> <small>" . date('d-m-Y H:i:s', strtotime($row->tanggal_mulai)) . " - " . date('d-m-Y H:i:s', strtotime($row->tanggal_selesai)) . "</small></td>									
								</tr>";
							}?>
						</tbody>
					</table>
				</div>
			</div>	
		</div>
	</div>
	
</div>
	<br />
