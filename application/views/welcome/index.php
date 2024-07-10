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
</style>
<?php use Carbon\Carbon;  Carbon::setLocale('id');?>
    <div class="border-0 card-content ">
        <div class="d-flex justify-content-center">
            <div class="col-11">
                <h6 class="text-center d-sm-none d-block mb-4">Selamat Datang di website payment <a href="https://ppatq-rf.id/" class="text-decoration-none font-italic">PPATQ-RF</a></h6>
                <div id="carouselExampleControls" class="carousel slide shadow-sm mb-3 rounded" data-ride="carousel">
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
                    <div class="shadow-sm">
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
                    <div class="shadow-sm">
                        <div class="p-3">
                            <img src="<?= base_url('assets/images/konfirmasiCard.png') ?>" class="card-img-top btn shadow-sm" alt="website konfirmasi pembayaran">
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
                    <div class="shadow-sm">
                        <div class="p-3">
                            <img src="<?= base_url('assets/images/logo.png') ?>" class="card-img-top btn shadow-sm" alt="gambar website resmi">
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
                    <div class="shadow-sm">
                        <div class="p-3">
                            <img src="<?= base_url('assets/images/web.png') ?>" class="card-img-top btn shadow-sm" alt="gambar website psb">
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
                    <div class="shadow-sm d-flex flex-row">
                        <img src="https://manajemen.ppatq-rf.id/assets/img/upload/berita/thumbnail/<?= $row->thumbnail?>" class="img-fluid col-4 px-0 p-2" style="height: 205px;" alt="gambar thumbnail <?= $row->judul?>">
                        
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
