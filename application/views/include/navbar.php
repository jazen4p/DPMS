<nav class="main-header navbar navbar-expand navbar-yellow navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url()?>Dashboard" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url()?>Login/logout" class="nav-link">Logout</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <?php 
        $utang = 0;
        $query = $this->db->get_where('keuangan_pengeluaran_hutang', array('status'=>"belum lunas"));
        $utang = $query->num_rows();

        $psjb = 0;
        $query2 = $this->Dashboard_model->get_psjb_melewati();
        $psjb = $query2->num_rows();

        $ppjb_owner_sign = 0;
        $query3 = $this->db->get_where('ppjb', array('marketing_sign <>'=>"", 'konsumen_sign <>'=>"", 'owner_sign'=>""));
        // print_r($query3->num_rows());
        $ppjb_owner_sign = $query3->num_rows();

        $psjb_app = 0;
        $query4 = $this->db->get_where('psjb', array('status'=>"tutup"));
        $psjb_app = $query4->num_rows();

        $psjb_rev = 0;
        $query_rev = $this->db->get_where('psjb', array('status'=>"revisi"));
        $psjb_rev = $query_rev->num_rows();

        $ppjb_app = 0;
        $query5 = $this->db->get_where('ppjb', array('status'=>"tutup"));
        $ppjb_app = $query5->num_rows();

        $ppjb_rev = 0;
        $query_rev1 = $this->db->get_where('ppjb', array('status'=>"revisi"));
        $ppjb_rev = $query_rev1->num_rows();

        $acc_penerimaan = 0;
        $query6 = $this->db->get_where('keuangan_akuntansi', array('status'=>"", 'nominal_bayar >'=>0));
        $acc_penerimaan = $query6->num_rows();

        $acc_pengeluaran = 0;
        $query_pgl = $this->db->get_where('keuangan_pengeluaran', array('status'=>"", 'nominal >'=>0));
        $acc_pengeluaran = $query_pgl->num_rows();

        $acc_pnr_rev = 0;
        $query_pnr_rev = $this->db->get_where('keuangan_akuntansi', array('status'=>"revisi"));
        $acc_pnr_rev = $query_pnr_rev->num_rows();

        $acc_pgl_rev = 0;
        $query_pgl_rev = $this->db->get_where('keuangan_pengeluaran', array('status'=>"revisi"));
        $acc_pgl_rev = $query_pgl_rev->num_rows();

        $pencairan = 0;
        $pencairan_k = 0;
        $pencairan_h = 0;
        $q_pencairan = $this->db->get_where('kbk_pencairan', array('status'=>"menunggu"));
        $q_pencairan_kontrak = $this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"borongan", 'status'=>"menunggu"));
        $q_pencairan_harian = $this->db->get_where('kbk_pencairan_kontrak', array('jenis_kontrak'=>"harian", 'status'=>"menunggu"));
        $pencairan = $q_pencairan->num_rows();
        $pencairan_k = $q_pencairan_kontrak->num_rows();
        $pencairan_h = $q_pencairan_harian->num_rows();

        $staff_sign = 0;
        $query_spk_sign = $this->db->get_where('spk', array('staff_sign'=>""));
        $staff_sign = $query_spk_sign->num_rows();

        $psjbtoppjb = 0;
        $q_psjbtoppjb = $this->db->get_where('psjb', array('status'=>"dom"));
        $psjbtoppjb = $q_psjbtoppjb->num_rows();

        $pengajuan_app = 0;
        $q_pengajuan_app = $this->db->get_where('produksi_pengajuan', array('status'=>"menunggu"));        
        $pengajuan_app = $q_pengajuan_app->num_rows();

        $pengajuan_byr = 0;
        $q_pengajuan_byr = $this->db->get_where('produksi_pengajuan', array('status'=>"disetujui"));        
        $pengajuan_byr = $q_pengajuan_byr->num_rows();

        $pengajuan_manager_sign = 0;
        $q_pengajuan_manager_sign = $this->db->get_where('produksi_pengajuan', array('status'=>"disetujui", 'manager_sign_by'=>""));        
        $pengajuan_manager_sign = $q_pengajuan_manager_sign->num_rows();

        $pengajuan_owner_sign = 0;
        $q_pengajuan_owner_sign = $this->db->get_where('produksi_pengajuan', array('status'=>"disetujui", 'owner_sign_by'=>""));        
        $pengajuan_owner_sign = $q_pengajuan_owner_sign->num_rows();

        $kbk_app = 0;
        $q_kbk_app = $this->db->get_where('kbk', array('status'=>"menunggu"));
        $kbk_app = $q_kbk_app->num_rows();

        $kontrak_app = 0;
        $q_kontrak_app = $this->db->get_where('kbk_kontrak_kerja', array('status'=>"menunggu"));
        $kontrak_app = $q_kontrak_app->num_rows();

        $spk_ttd = 0;
        $q_spk_ttd = $this->db->get_where('spk', array('staff_sign'=>""));
        $spk_ttd = $q_spk_ttd->num_rows();

        $spk_kbk = 0;
        $q_spk_a = $this->db->get('spk');
        foreach($q_spk_a->result() as $spk_s){
          $q_spk_kbk = $this->db->get_where('kbk', array('id_spk'=>$spk_s->id_spk));
          if($q_spk_kbk->num_rows() == 0){
            $spk_kbk = $spk_kbk + 1;
          }
        }

        // $psjb_owner_sign = 0;
        // $query7 = $this->db->get_where('psjb', array('marketing_sign <>'=>"", 'konsumen_sign <>'=>"", 'status <>'=>"tutup"));
        // print_r($query3->num_rows());
        // $psjb_owner_sign = $query7->num_rows();

        $print_psjb = 0;
        $query8 = $this->Dashboard_model->psjb_sign();
        foreach($query8->result() as $row){
          if($row->date_sign > date('Y-m-d', strtotime('-3 days'))){
            $print_psjb = $print_psjb + 1;
          }
        }
        // $print_psjb = $query8->num_rows();
        // echo $print_psjb;

        if($this->session->userdata('role') == "superadmin"){
          $total = $utang + $psjb_app + $ppjb_app + $psjb_rev + $ppjb_rev + $acc_penerimaan + $acc_pengeluaran + $acc_pnr_rev + $acc_pgl_rev + $pencairan + $pencairan_k + $pencairan_h + $psjbtoppjb + $pengajuan_app + $pengajuan_byr + $pengajuan_owner_sign + $pengajuan_manager_sign + $kbk_app + $kontrak_app;
        }  else if($this->session->userdata('role') == "manager keuangan" || $this->session->userdata('role') == "kepala admin"){
          $total = $utang + $psjb + $acc_penerimaan;
        } else if($this->session->userdata('role')=="manager produksi") {
          $total = $spk_ttd + $spk_kbk;
        } else {
          $total = 0;
        }
      ?>
      <li>
          <a class="nav-link" id="time"></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge"><?php echo $total?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?php echo $total?> Notifications</span>
          <!-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a> -->

          <?php if($this->session->userdata('role') == "superadmin"){?>
            <div class="dropdown-divider"></div>
              <?php if($psjb_app > 0){?>
              <a href="<?php echo base_url()?>Dashboard/app_psjb_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $psjb_app?> PSJB Sedang Menunggu Approval
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
              <?php if($ppjb_app > 0){?>
              <a href="<?php echo base_url()?>Dashboard/app_ppjb_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $ppjb_app?> PPJB Sedang Menunggu Approval
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
              <?php if($psjb_rev > 0){?>
              <a href="<?php echo base_url()?>Dashboard/psjb_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $psjb_rev?> PSJB Sedang Menunggu Revisi
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
              <?php if($ppjb_rev > 0){?>
              <a href="<?php echo base_url()?>Dashboard/ppjb_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $ppjb_rev?> PPJB Sedang Menunggu Revisi
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
              <?php if($psjbtoppjb > 0){?>
              <a href="<?php echo base_url()?>Dashboard/ppjb" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $psjbtoppjb?> PPJB Sedang menunggu didaftarkan
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
              <?php if($utang > 0){?>
              <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran_hutang_notif" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $utang?> Utang Belum Lunas
                <span class="float-right text-muted text-sm">2 days</span>
              </a>
            <?php }?>

            <!-- <div class="dropdown-divider"></div>
            <?php if($ppjb_owner_sign > 0){?>
              <a href="<?php echo base_url()?>Dashboard/f_ppjb_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $ppjb_owner_sign?> PPJB perlu di tanda tangan
                <span class="float-right text-muted text-sm">2 days</span>
              </a>
            <?php }?> -->

            <!-- <div class="dropdown-divider"></div>
            <?php if($print_psjb > 0){?>
              <a href="<?php echo base_url()?>Dashboard/psjb_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $print_psjb?> PSJB dapat dicetak
                <span class="float-right text-muted text-sm">2 days</span>
              </a>
            <?php }?> -->

            <div class="dropdown-divider"></div>
            <?php if($acc_penerimaan > 0){?>
              <a href="<?php echo base_url()?>Dashboard/laporan_penerimaan_akuntansi" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $acc_penerimaan?> Posting penerimaan perlu ditinjau
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($acc_pengeluaran > 0){?>
              <a href="<?php echo base_url()?>Dashboard/laporan_pengeluaran_akuntansi" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $acc_pengeluaran?> Posting pengeluaran perlu ditinjau
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($acc_pnr_rev > 0){?>
              <a href="<?php echo base_url()?>Dashboard/laporan_pengeluaran_akuntansi" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $acc_pnr_rev?> Posting penerimaan perlu direvisi
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($acc_pgl_rev > 0){?>
              <a href="<?php echo base_url()?>Dashboard/laporan_pengeluaran_akuntansi" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $acc_pgl_rev?> Posting penerimaan perlu direvisi
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($pengajuan_app > 0){?>
              <a href="<?php echo base_url()?>Dashboard/app_informasi_pengajuan_pembayaran" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $pengajuan_app?> Pengajuan butuh approval
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($pengajuan_byr > 0){?>
              <a href="<?php echo base_url()?>Dashboard/byr_informasi_pengajuan_pembayaran" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $pengajuan_byr?> Pengajuan butuh pembayaran
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($pengajuan_manager_sign > 0){?>
              <a href="<?php echo base_url()?>Dashboard/byr_informasi_pengajuan_pembayaran" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $pengajuan_manager_sign?> Pengajuan butuh TTD manager
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($pengajuan_manager_sign > 0){?>
              <a href="<?php echo base_url()?>Dashboard/byr_informasi_pengajuan_pembayaran" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $pengajuan_manager_sign?> Pengajuan butuh TTD owner
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($kbk_app > 0){?>
              <a href="<?php echo base_url()?>Dashboard/f_kbk_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $kbk_app?> KBK Perlu approval
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($kontrak_app > 0){?>
              <a href="<?php echo base_url()?>Dashboard/f_kontrak_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $kontrak_app?> Kontrak Kerja perlu approval
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($pencairan > 0){?>
              <a href="<?php echo base_url()?>Dashboard/f_kbk_pencairan_dana_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $pencairan?> Pencairan Upah KBK perlu ditinjau
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>
            <div class="dropdown-divider"></div>
            <?php if($pencairan_k > 0){?>
              <a href="<?php echo base_url()?>Dashboard/f_kbk_pencairan_dana_borongan_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $pencairan_k?> Pencairan Upah Kontrak TB perlu ditinjau
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>
            <div class="dropdown-divider"></div>
            <?php if($pencairan_h > 0){?>
              <a href="<?php echo base_url()?>Dashboard/f_kbk_pencairan_dana_harian_management" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $pencairan_h?> Pencairan Upah Harian perlu ditinjau
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>

          <!-- START OF ROLE MANAGER KEUANGAN -->
          <?php } else if($this->session->userdata('role') == "manager keuangan" || $this->session->userdata('role') == "kepala admin"){?>
            <div class="dropdown-divider"></div>
              <?php if($utang > 0){?>
                <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran_hutang_notif" class="dropdown-item">
                  <i class="fas fa-file mr-2"></i> <?php echo $utang?> Utang Belum Lunas
                  <!-- <span class="float-right text-muted text-sm">2 days</span> -->
                </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($acc_penerimaan > 0){?>
              <a href="<?php echo base_url()?>Dashboard/laporan_penerimaan_akuntansi" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo $acc_penerimaan?> Posting perlu ditinjau
                <!-- <span class="float-right text-muted text-sm">2 days</span> -->
              </a>
            <?php }?>
            
            <div class="dropdown-divider"></div>
            <?php if($psjbtoppjb > 0){?>
              <a href="<?php echo base_url()?>Dashboard/ppjb" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> <?php echo $psjbtoppjb?> PSJB Menunggu Untuk Daftar PPJB
                <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
              </a>
            <?php }?>

          <!-- START OF ROLE MANAGER PRODUKSI -->
          <?php } else if($this->session->userdata('role')=="manager produksi"){?>
            <div class="dropdown-divider"></div>
            <?php if($spk_ttd > 0){?>
              <a href="<?php echo base_url()?>Dashboard/sign_spk_management" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> <?php echo $spk_ttd?> SPK menunggu untuk di tandatangan
                <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
              </a>
            <?php }?>

            <div class="dropdown-divider"></div>
            <?php if($spk_kbk > 0){?>
              <a href="<?php echo base_url()?>Dashboard/f_view_add_kbk_management" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> <?php echo $spk_kbk?> SPK menunggu mendaftar KBK
                <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
              </a>
            <?php }?>
          <?php }?>
          <!-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
        </div>
      </li>
    </ul>
  </nav>
  
  <script>
        var timeDisplay = document.getElementById("time");
    
        function refreshTime() {
          var dateString = new Date().toLocaleString("en-GB", {timeZone: "Asia/Jakarta"});
          var formattedString = dateString.replace(", ", " - ");
          timeDisplay.innerHTML = formattedString;
        }
        
        setInterval(refreshTime, 1000);
    </script>