<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/dashboard') ?>" class="nav-link <?= ($this->uri->segment(2)=="dashboard")?"active":""?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard 
              </p>
            </a>
          </li>
          <li class="nav-item  <?= ($this->uri->segment(2)=="jenis" || $this->uri->segment(2)=="kategori" || $this->uri->segment(2)=="siswa" || $this->uri->segment(2)=="user"|| $this->uri->segment(2)=="keringanan")?"menu-open":""?>">
            <a href="#" class="nav-link <?= ($this->uri->segment(2)=="jenis" || $this->uri->segment(2)=="kategori" ||$this->uri->segment(2)=="siswa")?"active":""?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('index.php/admin/jenis') ?>" class="nav-link <?= ($this->uri->segment(2)=="jenis")?"active":""?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Pembayaran</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url('index.php/admin/keringanan') ?>" class="nav-link <?= ($this->uri->segment(2)=="keringanan")?"active":""?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Keringanan Pembayaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('index.php/admin/kategori') ?>" class="nav-link <?= ($this->uri->segment(2)=="kategori")?"active":""?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('index.php/admin/siswa') ?>" class="nav-link <?= ($this->uri->segment(2)=="siswa")?"active":""?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Siswa</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url('index.php/admin/user') ?>" class="nav-link <?= ($this->uri->segment(2)=="user")?"active":""?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengguna</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/keluhan') ?>" class="nav-link <?= ($this->uri->segment(2)=="keluhan" && $this->uri->segment(3)!="laporan")?"active":""?>">
              <i class="nav-icon fas fa-life-ring"></i>
              <p>
                Daftar Keluhan / Aduan
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/bukatutup') ?>" class="nav-link <?= ($this->uri->segment(2)=="bukatutup")?"active":""?>">
              <i class="nav-icon fas fa-life-ring"></i>
              <p>
                Buka / Tutup Pelaporan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/pembayaran') ?>" class="nav-link <?= ($this->uri->segment(2)=="pembayaran" && empty($this->uri->segment(3)))?"active":""?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Daftar Pembayaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/pembayaran/belum_lapor') ?>" class="nav-link <?= ($this->uri->segment(2)=="pembayaran" && $this->uri->segment(3) == "belum_lapor") ?"active":""?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Daftar Belum Lapor Pembayaran
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/tunggakan') ?>" class="nav-link <?= ($this->uri->segment(2)=="tunggakan" && empty($this->uri->segment(3)))?"active":""?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Daftar Tunggakan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/pembayaran/laporan') ?>" class="nav-link  <?= ($this->uri->segment(2)=="pembayaran" && $this->uri->segment(3)=="laporan")?"active":""?>">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Laporan Pembayaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/keluhan/laporan') ?>" class="nav-link  <?= ($this->uri->segment(2)=="keluhan" && $this->uri->segment(3)=="laporan")?"active":""?>">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Laporan Keluhan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/admin/whatsapp') ?>" class="nav-link  <?= ($this->uri->segment(2)=="whatsapp" || $this->uri->segment(3)=="whatsapp")?"active":""?>">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Log Whatsapp
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('/') ?>" class="nav-link">
              <i class="nav-icon fas fa-long-arrow-alt-left"></i>
              <p>
                Kembali ke Website
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="<?php echo base_url('/index.php/auth/logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
