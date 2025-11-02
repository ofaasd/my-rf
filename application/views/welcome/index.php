<style>
.card{
    padding:0 !important;
}

.img-carousel {
    position: center;
    object-fit: contain; /* Menyesuaikan gambar tanpa merubah aspek rasionya */
    max-width: 100%; /* Agar gambar tidak melebihi lebar kontainer */
    max-height: 100%
}
/* Lapisan Latar Belakang Gelap */
#popup-overlay {
  /* Sembunyi secara default */
  display: none; 
  
  /* Tampilkan di atas segalanya */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6); /* Warna hitam transparan */
  z-index: 999;

  /* Membuat konten di tengah */
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Konten Popup (Kotaknya) */
#popup-content {
  position: relative;
  width: 90%; /* Lebar popup di layar HP */
  max-width: 500px; /* Lebar maksimal di desktop */
  background-color: #fff;
  border-radius: 10px; /* Sesuaikan dengan desain gambar */
  
  /* Efek animasi muncul */
  animation: fadeIn 0.3s ease-out;
}

/* Gambar di dalam popup */
#popup-content img {
  width: 100%;
  display: block; /* Menghilangkan spasi ekstra di bawah gambar */
  border-radius: 10px; /* Sesuaikan dengan desain gambar */
}

/* Tombol Close (Tanda 'x') */
#popup-close {
  position: absolute;
  top: -15px;
  right: -15px;
  
  width: 35px;
  height: 35px;
  background-color: #ffffff;
  color: #333;
  border: 2px solid #333;
  border-radius: 50%; /* Membuatnya bulat */
  
  font-size: 24px;
  font-weight: bold;
  line-height: 32px;
  text-align: center;
  
  cursor: pointer;
  z-index: 1001;
}

/* Animasi sederhana */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
<?php use Carbon\Carbon;  Carbon::setLocale('id');?>
    <div class="border-0 card-content">
        <div class="d-flex justify-content-center">
            <div class="col-11">
                <h6 class="text-center d-sm-none d-block mb-4">Selamat Datang di website payment <a href="https://ppatq-rf.id/" class="text-decoration-none font-italic">PPATQ-RF</a></h6>
                <div id="carouselExampleControls" class="carousel slide  mb-3 rounded" data-ride="carousel">
                        <div class="carousel-inner rounded">
                            <div class="carousel-item active">
                                <img class="d-block img-carousel" src="<?php echo base_url('assets/images/carousel-1-low.jpg') ?>"alt="First slide">
                                <div class="carousel-caption d-none d-md-block mb-5">
                                    <h5>Selamat Datang di website pembayaran <a href="https://ppatq-rf.id/" class="text-decoration-none text-white font-italic">PPATQ-RF</a></h5>
                                </div> 
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-carousel" src="<?php echo base_url('assets/images/carousel-2-low.jpg') ?>" alt="Second slide">
                                <div class="carousel-caption d-none d-md-block mb-5">
                                    <h5>Selamat Datang di website pembayaran <a href="https://ppatq-rf.id/" class="text-decoration-none text-white font-italic">PPATQ-RF</a></h5>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                </div>
            </div>
        </div>
        <div class="row mb-5 d-flex justify-content-center">
            <div class="col-md-3 col-9">
                <a href="https://payment.ppatq-rf.id/index.php/keluhan" class="text-dark text-decoration-none">
                    <div class="">
                        <div class="p-3">
                            <img src="<?= base_url('assets/images/kritikDanSaran.png') ?>" class="card-img-top btn btn-success" alt="gambar kritik dan saran" >
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Sambung Rasa Sumbang Saran</h5>
                            <small class="card-text">Dalam suasana yang inklusif dan kolaboratif, Anda diajak untuk berbagi pandangan, memberikan saran, dan mencari solusi bersama untuk berbagai permasalahan yang dihadapi.</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-9">
                <a href="https://payment.ppatq-rf.id/index.php/pembayaran" class="text-dark text-decoration-none">
                    <div class="">
                        <div class="p-3">
                            <img src="<?= base_url('assets/images/konfirmasiCard.png') ?>" class="card-img-top btn " alt="website konfirmasi pembayaran">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Konfirmasi Pembayaran</h5>
                            <small class="card-text">Konfirmasi Pembayaran untuk memastikan keabsahan transaksi dan menghindari kesalahan</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-9">
                <a href="https://www.ppatq-rf.sch.id/" class="text-dark text-decoration-none">
                    <div class="">
                        <div class="p-3">
                            <img src="<?= base_url('assets/images/logo.png') ?>" class="card-img-top btn " alt="gambar website resmi">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Website Resmi</h5>
                            <small class="card-text">website resmi PPATQ-RF</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-9">
                <a href="https://psb.ppatqrf.sch.id/" class="text-dark text-decoration-none">
                    <div class="">
                        <div class="p-3">
                            <img src="<?= base_url('assets/images/web.png') ?>" class="card-img-top btn" alt="gambar website psb">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Website PSB</h5>
                            <small class="card-text">Proses pendaftaran dan seleksi siswa baru</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
            <div class="row d-flex flex-column">
                <div class="col d-flex justify-content-center mb-4">
                    <h3 class="bg-success rounded col-md-4 text-center text-white py-1">Berita Terbaru</h3>
                </div>
            <?php foreach($berita as $row){?>
                <a href="<?php echo base_url('index.php/berita/detail/' . $row->id) ?>" class="text-decoration-none text-dark mb-2">
                <div class="col">
                    <div class=" d-flex flex-row">
                        <img src="<?= $row->thumbnail?>" class="img-fluid col-6 col-sm-4 px-0 p-2" style="height: 205px;" alt="gambar thumbnail <?= $row->judul?>">
                        
                        <div class="card-body">
                            <h5><?=$row->judul?></h5>
                            <small class="bg-info px-2 text-white rounded"><?=$row->nama_kategori?></small>
                            <p class="card-text"><?= (strip_tags(strlen($row->isi_berita)) > 100) ? strip_tags(substr($row->isi_berita,0,150)) . ' [...]':strip_tags($row->isi_berita)?></p>
                                <small class="text-muted font-italic"><?= Carbon::parse($row->created_at)->diffForHumans()?></small>
                        </div>
                    </div>
                </div>
                </a>
            <?php } ?>
        </div>
    </div>
	<br />
<div id="popup-overlay">
    <div id="popup-content">
        <span id="popup-close">&times;</span>

        <a href="https://play.google.com/store/apps/details?id=com.ppatq.walsan" target="_blank">
            <img src="assets/images/apps.png" alt="Download Aplikasi PPATQ Raudhatul Falah">
        </a>
    </div>
</div>
<script>
    window.addEventListener('load', function() {
  
  // Ambil elemen-elemen popup
  const popupOverlay = document.getElementById('popup-overlay');
  const popupClose = document.getElementById('popup-close');

  // --- OPSI 1: Tampilkan SETIAP KALI halaman di-load ---
  // Hapus tanda '//' pada baris di bawah ini untuk menggunakannya
  // popupOverlay.style.display = 'flex';

  // --- OPSI 2: Tampilkan HANYA PADA KUNJUNGAN PERTAMA ---
  // Ini adalah opsi yang lebih baik agar tidak mengganggu pengunjung
  if (!localStorage.getItem('popupPernahTampil')) {
    // Tampilkan popup
    popupOverlay.style.display = 'flex';
    
    // Simpan data di browser agar tidak tampil lagi
    localStorage.setItem('popupPernahTampil', 'true');
  }

  // Fungsi untuk menutup popup
  popupClose.addEventListener('click', function() {
    popupOverlay.style.display = 'none';
  });

  // Opsional: Tutup juga saat klik di luar area popup
  popupOverlay.addEventListener('click', function(event) {
    // Cek apakah yang diklik adalah area overlay (latar belakang)
    if (event.target === popupOverlay) {
      popupOverlay.style.display = 'none';
    }
  });
  
});
</script>