<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/operator/dashboard') ?>" class="nav-link <?= ($this->uri->segment(2)=="dashboard")?"active":""?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/operator/keluhan') ?>" class="nav-link <?= ($this->uri->segment(2)=="keluhan")?"active":""?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Sambung Rasa 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('index.php/operator/siswa/download') ?>" class="nav-link <?= ($this->uri->segment(2)=="siswa")?"active":""?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Siswa
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