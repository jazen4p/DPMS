<aside class="main-sidebar sidebar-light-primary elevation-4" style="font-size: 15px">
    <!-- Brand Logo -->
    <a class="brand-link">
      <img src="<?php echo base_url()?>gambar/MSGLOGO.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">DPMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if($this->session->userdata('file_name')==""){?>
            <img src="<?php echo base_url()?>asset/dist/img/default-150x150.png" class="img-circle elevation-2" alt="User Image">
          <?php } else {?>
            <img src="<?php echo base_url()?>gambar/<?php echo $this->session->userdata('file_name');?>" class="img-circle elevation-2" alt="User Image">
          <?php }?>
        </div>
        <div class="info">
          <a href="<?php echo base_url()?>Dashboard/edit_view_user?id=<?php echo $this->session->userdata('u_id')?>" class="d-block"><?php echo $nama?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if($this->session->userdata('role')=="staff kasir"){?>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/view_add_maintenance" class="nav-link">
              <i class="nav-icon fas fa-toolbox"></i>
              <p>
                Keamanan & Maintenance
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/air_management" class="nav-link">
              <i class="nav-icon fas fa-tint"></i>
              <p>
                Air
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/data_unit_rumah" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Data Unit Rumah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/data_surat_pemberitahuan" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Surat Pemberitahuan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/data_slip_tagihan" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Slip Tagihan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/cicilan_pembayaran" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Cicilan Pembayaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/riwayat_pembayaran" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Riwayat Pembayaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/rekap_laporan_pembayaran" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Rekap Laporan Pembayaran
              </p>
            </a>
          </li>
          <?php } else if($this->session->userdata('role')=="staff checker"){?>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Kasir/check_air" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <?php }?>
          <!-- Sidebar hanya superadmin -->

          <li class="nav-item">
            <a href="<?php echo base_url()?>Dashboard/help" class="nav-link">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>
                Help
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url()?>Login/logout" class="nav-link">
              <i class="nav-icon fas fa-share"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>