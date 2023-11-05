<?php if($pembayaran->validasi == 1) { ?>
<input type="hidden" name="id" id="id_pembayaran" value="<?= $pembayaran->id ?>">
<div class="form-group">
	<label for="nama">Nama</label>
	<input type="text" name="nama" id="nama" class="form-control" value="<?= $nama_santri->nama?>">
	
	<label for="number">No Wa</label>
	<input type="text" name="no_wa" id="no_wa" class="form-control" value="<?= $pembayaran->no_wa?>">
	
	<label for="pesan">Pesan</label>
	<textarea name="message" class="form-control" rows="15" id="message">
*Pesan ini otomatis dikirim dari sistem*
Yth. (Bp/Ibu) <?=$pembayaran->atas_nama?>, Alhamdulillah melalui petugas kami Bp. Muhadi, bulan  ini kami telah menerima : 

<?php foreach($detail_pembayaran as $detail){?>
	• <?=$jenis_pembayaran[$detail->id_jenis_pembayaran]?> sebesar Rp. <?=number_format($detail->nominal,0,",",".");?>&#13;
<?php } ?>

Kami mengucapkan banyak terima kasih (Bp/Ibu) <?=$pembayaran->atas_nama?> Yang tetap istiqomah menyisihkan sebagian hartanya untuk kewajiban pembayaran bulanan di PPATQ RF.

Semoga pekerjaan dan usahanya diberi kelancaran dan keberkahan menghasilkan Rizqi yang banyak dan berkah, aamiin. 
Notifikasi ini bertujuan untuk menjaga amanah Bp/Ibu kepada kami. Bila ada yang perlu diklarifikasi mohon bisa menghubungi kami via WA atau telepon kami di nomor +62897-9194-645. Atau melalui https://saran.ppatq-rf.id
	</textarea>
</div>





<?php 
}else if($pembayaran->validasi == 2) {
?>	
	<input type="hidden" name="id" id="id_pembayaran" value="<?= $pembayaran->id ?>">
<div class="form-group">
	<label for="nama">Nama</label>
	<input type="text" name="nama" id="nama" class="form-control" value="<?= $nama_santri->nama?>">
	
	<label for="number">No Wa</label>
	<input type="text" name="no_wa" id="no_wa" class="form-control" value="<?= $pembayaran->no_wa?>">
	
	<label for="pesan">Pesan</label>
	<textarea name="message" class="form-control" rows="15" id="message">
*Pesan ini otomatis dikirim dari sistem*
Yth. (Bp/Ibu) <?=$pembayaran->atas_nama?>, 
Berdasarkan dari laporan pembayaran yang telah dikirimkan dengan rincian sbg berikut :  

<?php foreach($detail_pembayaran as $detail){?>
	• <?=$jenis_pembayaran[$detail->id_jenis_pembayaran]?> sebesar Rp. <?=number_format($detail->nominal,0,",",".");?>&#13;
<?php } ?>

mohon diulang kembali
	</textarea>
</div>
<?php 
}else{
?>
<input type="hidden" name="id" id="id_pembayaran" value="<?= $pembayaran->id ?>">
<div class="form-group">
	<label for="nama">Nama</label>
	<input type="text" name="nama" id="nama" class="form-control" value="<?= $nama_santri->nama?>">
	
	<label for="number">No Wa</label>
	<input type="text" name="no_wa" id="no_wa" class="form-control" value="<?= $pembayaran->no_wa?>">
	
	<label for="pesan">Pesan</label>
	<textarea name="message" class="form-control" rows="15" id="message">
*Pesan ini otomatis dikirim dari sistem*
Yth. (Bp/Ibu) <?=$pembayaran->atas_nama?>, telah melakukan melaporkan pembayaran bulan November sebesar <?=number_format($pembayaran->jumlah,0,",",".")?> 

dengan rincian sbb :

<?php foreach($detail_pembayaran as $detail){?>
	• <?=$jenis_pembayaran[$detail->id_jenis_pembayaran]?> sebesar Rp. <?=number_format($detail->nominal,0,",",".");?>&#13;
<?php } ?>

Kami mengucapkan banyak terima kasih (Bp/Ibu) <?=$pembayaran->atas_nama?> Yang telah melaporkan kepada kami.
Tunggu beberapa waktu, kami akan melakukan pencatatan.
Kami akan segera memberikan informasi apabila pembayaran tsb diatas telah sesuai.


Semoga pekerjaan dan usahanya diberi kelancaran dan keberkahan menghasilkan Rizqi yang banyak dan berkah, aamiin. 

Notifikasi ini bertujuan untuk menjaga amanah Bp/Ibu kepada kami. Bila ada yang perlu diklarifikasi mohon bisa menghubungi kami via WA atau telepon kami di nomor +62897-9194-645. Atau melalui https://saran.ppatq-rf.id
	</textarea>
</div>
<?php
} ?>
