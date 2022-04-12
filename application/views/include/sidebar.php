<aside class="main-sidebar sidebar-light-primary elevation-4" style="font-size: 15px">
    <!-- Brand Logo -->
    <a href="<?php echo base_url()?>Dashboard" class="brand-link">
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
          <?php if($this->session->userdata('role') == "staff kasir"){?>
            <li class="nav-item">
              <a href="<?php echo base_url()?>Kasir" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Home
                </p>
              </a>
            </li>
          <?php } else if($this->session->userdata('role') == "staff checker"){?>
            <li class="nav-item">
              <a href="<?php echo base_url()?>kasir/check_air" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Home
                </p>
              </a>
            </li>
          <?php } else {?>
            <li class="nav-item">
              <a href="<?php echo base_url()?>Dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
          <?php }?>
          <!-- Sidebar hanya superadmin -->
          <?php if($this->session->userdata('role') == "superadmin"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-database"></i>
                <p>
                  Master Data
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/user_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/bank_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bank</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/perusahaan_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Perusahaan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/perumahan_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Perumahan</p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/kavling_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kavling</p>
                  </a>
                </li> -->
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/rumah_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kavling</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/siteplan_view" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Siteplan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/kawasan_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kawasan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/notaris_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Notaris</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/sub_kon_management" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sub Kontraktor</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/akun_neraca_saldo" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Neraca Saldo Awal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/kode_pengeluaran" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kontrol Budget</p>
                  </a>
                </li>
              </ul>
            </li>
          <!-- akhir dari superadmin yg berhak-->
          <?php }?>

          <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager keuangan" || $this->session->userdata('role') == "kepala admin"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Administrasi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Perumahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>PSJB<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>PPJB<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/ppjb_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/ppjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kavling
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>Surat Perjanjian<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/kavling_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/kavling" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <!-- <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>Daftar Balik Nama<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/daftar_balik_nama_kavling" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/list_pph_kavling" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List PPh Konsumen</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul> -->
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-bars nav-icon"></i>
                    <p>Daftar Balik Nama<i class="fas fa-angle-left right"></i></p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/daftar_balik_nama" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Informasi</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/list_pph" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List PPh Konsumen</p>
                      </a>
                    </li>
                    <!-- <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/ppjb" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create</p>
                      </a>
                    </li> -->
                  </ul>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "staff admin"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Administrasi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Perumahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>PSJB<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>PPJB<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/ppjb_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/ppjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kavling
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>Surat Perjanjian<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>Daftar Balik Nama<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/daftar_balik_nama" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/list_pph" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List PPh Konsumen</p>
                          </a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/ppjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          <?php }?>

          <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  Operasional
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Penerimaan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/keuangan_transaksi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pembayaran Konsumen</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Ground Tank</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_tambahan_bangunan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Tambahan Bangunan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_lain" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Penerimaan Lain-Lain</p>
                      </a>
                    </li>
                  </ul>
                </li> 
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Pengeluaran
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <!-- <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/kode_pengeluaran" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kode Pengeluaran</p>
                      </a>
                    </li> -->
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transaksi Pengeluaran</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <!-- <a href="<?php echo base_url()?>Dashboard/transaksi_utang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transaksi Utang</p>
                      </a> -->
                    </li>
                  </ul>
                  <!-- <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/kontrol_piutang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kontrol Piutang Kas/KPR</p>
                      </a>
                    </li>
                  </ul> -->
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kontrol Piutang
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/daftar_penagihan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Penagihan</p>
                      </a>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/kontrol_piutang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Tagihan Piutang</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/laporan_rekap_kas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rincian Piutang Kas</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kontrol Hutang
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran_hutang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Hutang</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/daftar_kwitansi_bfee" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kwitansi Booking Fee</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role')=="kepala admin"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  Operasional
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Penerimaan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/keuangan_transaksi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pembayaran Konsumen</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Ground Tank</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_tambahan_bangunan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Tambahan Bangunan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_lain" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Penerimaan Lain-Lain</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kontrol Piutang
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/daftar_penagihan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Penagihan</p>
                      </a>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/kontrol_piutang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Tagihan Piutang</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/laporan_rekap_kas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rincian Piutang Kas</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/daftar_kwitansi_bfee" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kwitansi Booking Fee</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "staff admin"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  Operasional
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Penerimaan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/keuangan_transaksi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pembayaran Konsumen</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Ground Tank</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_tambahan_bangunan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Tambahan Bangunan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_lain" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Penerimaan Lain-Lain</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kontrol Piutang
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/daftar_penagihan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Penagihan</p>
                      </a>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/laporan_rekap_kas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rincian Piutang Kas</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/daftar_kwitansi_bfee" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kwitansi Booking Fee</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "staff admin penagihan"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  Operasional
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Penerimaan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/keuangan_transaksi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pembayaran Konsumen</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_ground_tank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Ground Tank</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_tambahan_bangunan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pend. Tambahan Bangunan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/penerimaan_lain" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Penerimaan Lain-Lain</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kontrol Piutang
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/daftar_penagihan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Penagihan</p>
                      </a>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/kontrol_piutang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Tagihan Piutang</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/laporan_rekap_kas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rincian Piutang Kas</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/daftar_kwitansi_bfee" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kwitansi Booking Fee</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "accounting" ){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  Operasional
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Pengeluaran
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transaksi Pengeluaran</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Kontrol Hutang
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran_hutang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Hutang</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/daftar_kwitansi_bfee" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kwitansi Booking Fee</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php }?>

          <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan" || $this->session->userdata('role') == "accounting"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calculator"></i>
                <p>
                  Accounting
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Penerimaan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/laporan_penerimaan_akuntansi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Informasi Penerimaan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Pengeluaran
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/laporan_pengeluaran_akuntansi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Informasi Pengeluaran</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul><ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Jurnal
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/informasi_jurnal_akuntansi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Informasi</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/add_jurnal_akuntansi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "manager produksi" ){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  Operasional
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/keuangan_transaksi" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pembayaran Konsumen</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "kepala admin" || $this->session->userdata('role') == "staff admin"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calculator"></i>
                <p>
                  Accounting
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Penerimaan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/laporan_penerimaan_akuntansi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Informasi Penerimaan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          <?php }?>

          <?php if($this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager keuangan" || $this->session->userdata('role') == "manager produksi"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Produksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Master Data
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_barang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Barang</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_toko" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Toko</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_satuan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Satuan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Pembelian Bahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/management_pembelian_bahan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Informasi Pembelian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/pembelian_bahan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah Pembelian</p>
                      </a>
                    </li>
                    <!-- <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/pembayaran_pembelian_bahan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah Pembelian</p>
                      </a>
                    </li> -->
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Pembayaran Bahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/pembayaran_pembelian_bahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Buat Pengajuan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/informasi_pengajuan_pembayaran" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Informasi Pengajuan</p>
                      </a>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview">
                      <a href="<?php echo base_url()?>Dashboard/kontrol_pembayaran_pembelian_perumahan" class="nav-link">
                        <i class="nav-icon far fa-tasks"></i>
                        <p>
                          Kontrol Nota dan Pembayaran
                          <!-- <i class="fas fa-angle-left right"></i> -->
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Laporan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/rincian_pembelian_perumahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Rincian Pembelian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/rekap_rincian_pembelian_perumahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Rekap Rincian Pembelian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/rincian_jatuh_tempo_perumahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Rincian Jatuh Tempo</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Logistik
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                          Arus Stok
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/stok_masuk" class="nav-link">
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Masuk</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/stok_keluar" class="nav-link">
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Keluar</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/view_rekap_arus_stok" class="nav-link">
                            <!-- <i class="far fa-tasks nav-icon"></i> -->
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Rekap Arus Stok</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_stok" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stok</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_rekap_pemakaian_bahan" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Pemakaian Bahan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Progress
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_spk_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>SPK</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_kbk_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>KBK</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_qc_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>QC</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/tambahan_bangunan_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Tambahan Bangunan</p>
                      </a>
                    </li>
                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Kontrak Kerja Borongan
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/kontrak_management" class="nav-link">
                            <!-- <i class="far fa-tasks nav-icon"></i> -->
                            <!-- <i class="far fa-circle nav-icon"></i> -->
                            <p style="padding-left: 30px">Daftar Kontrak</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/kontrak_form" class="nav-link">
                            <!-- <i class="far fa-tasks nav-icon"></i> -->
                            <!-- <i class="far fa-circle nav-icon"></i> -->
                            <p style="padding-left: 30px">Tambah Kontrak</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          BAST
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/bast_sub_dev_management_perumahan" class="nav-link">
                            <!-- <i class="far fa-tasks nav-icon"></i> -->
                            <i class="far fa-circle nav-icon"></i>
                            <p>SubKon - Developer</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/bast_dev_kon_management_perumahan" class="nav-link">
                            <!-- <i class="far fa-tasks nav-icon"></i> -->
                            <i class="far fa-circle nav-icon"></i>
                            <p>Developer - Konsumen</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Lap. Progress
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_kbk_pencairan_dana_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Upah KBK</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/kbk_pencairan_dana_borongan_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Upah Borongan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/kbk_pencairan_dana_harian_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Upah Harian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/progress_unit_marketing" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Progress Unit</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "admin inventory"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Produksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Master Data
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_barang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Barang</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_toko" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Toko</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_satuan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Satuan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Logistik
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                          Arus Stok
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/stok_masuk" class="nav-link">
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Masuk</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/stok_keluar" class="nav-link">
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Keluar</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/view_rekap_arus_stok" class="nav-link">
                            <!-- <i class="far fa-tasks nav-icon"></i> -->
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Rekap Arus Stok</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_stok" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stok</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_rekap_pemakaian_bahan" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Pemakaian Bahan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role')=="qc"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Produksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Progress
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_qc_management" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>QC</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "staff purchasing"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Produksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Master Data
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_barang" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Barang</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_toko" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Toko</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/produksi_daftar_satuan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Satuan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Pembelian Bahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/management_pembelian_bahan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Informasi Pembelian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/pembelian_bahan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah Pembelian</p>
                      </a>
                    </li>
                    <!-- <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/pembayaran_pembelian_bahan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah Pembelian</p>
                      </a>
                    </li> -->
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Pembayaran Bahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/pembayaran_pembelian_bahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Buat Pengajuan</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/informasi_pengajuan_pembayaran" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Informasi Pengajuan</p>
                      </a>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview">
                      <a href="<?php echo base_url()?>Dashboard/kontrol_pembayaran_pembelian_perumahan" class="nav-link">
                        <i class="nav-icon far fa-tasks"></i>
                        <p>
                          Kontrol Nota dan Pembayaran
                          <!-- <i class="fas fa-angle-left right"></i> -->
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Laporan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/rincian_pembelian_perumahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Rincian Pembelian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/rekap_rincian_pembelian_perumahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Rekap Rincian Pembelian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/rincian_jatuh_tempo_perumahan" class="nav-link">
                        <i class="far fa-tasks nav-icon"></i>
                        <p>Rincian Jatuh Tempo</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/progress_unit_marketing" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Progress Unit</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Logistik
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                          Arus Stok
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <!-- <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/stok_masuk" class="nav-link">
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Masuk</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/stok_keluar" class="nav-link">
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Keluar</p>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/view_rekap_arus_stok" class="nav-link">
                            <!-- <i class="far fa-tasks nav-icon"></i> -->
                            <i class="far fa-tasks nav-icon"></i>
                            <p>Rekap Arus Stok</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_stok" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stok</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/view_rekap_pemakaian_bahan" class="nav-link">
                        <!-- <i class="far fa-tasks nav-icon"></i> -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rekap Pemakaian Bahan</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          <?php }?>

          <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager marketing"){?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-mail-bulk"></i>
                <p>
                  Marketing
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Perumahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>PSJB<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Laporan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo base_url()?>Dashboard/marketing_rekap_penjualan" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>Rekap Penjualan</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/progress_unit_marketing" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Progress Unit</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url()?>Dashboard/daftar_kwitansi_bfee" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kwitansi Booking Fee</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } else if($this->session->userdata('role') == "staff marketing") {?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-mail-bulk"></i>
                <p>
                  Marketing
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      Perumahan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-file nav-icon"></i>
                        <p>PSJB<i class="fas fa-angle-left right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb_management" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Informasi</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url()?>Dashboard/psjb" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/progress_unit_marketing" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Progress Unit</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/daftar_kwitansi_bfee" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Kwitansi Booking Fee</p>
                    </a>
                  </li>
                </li>
              </ul>
            </li>
          <?php }?>

          <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan"){?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Keuangan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                    Master Data
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/akun_neraca_saldo" class="nav-link">
                      <i class="far fa- nav-icon"></i>
                      <p>Neraca Saldo Awal</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/kode_pengeluaran" class="nav-link">
                      <i class="far fa- nav-icon"></i>
                      <p>Kontrol Budget</p>
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/laporan_penerimaan_lain" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Penerimaan Lain-Lain</p>
                    </a>
                  </li> -->
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()?>Dashboard/view_jurnal_umum" class="nav-link">
                  <i class="far fa-cc nav-icon"></i>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jurnal Umum</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()?>Dashboard/view_buku_besar" class="nav-link">
                  <i class="far fa-cc nav-icon"></i>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku Besar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()?>Dashboard/view_laba_rugi" class="nav-link">
                  <i class="far fa-cc nav-icon"></i>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laba Rugi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()?>Dashboard/view_perubahan_modal" class="nav-link">
                  <i class="far fa-cc nav-icon"></i>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perubahan Modal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()?>Dashboard/view_neraca" class="nav-link">
                  <i class="far fa-cc nav-icon"></i>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Neraca</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                    Rekonsiliasi
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/view_jurnal_umum_rekonsiliasi" class="nav-link">
                      <i class="far fa-cc nav-icon"></i>
                      <i class="far fa-circle nav-icon"></i>
                      <p>Jurnal Umum</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/view_buku_besar_rekonsiliasi" class="nav-link">
                      <i class="far fa-cc nav-icon"></i>
                      <i class="far fa-circle nav-icon"></i>
                      <p>Buku Besar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/view_laba_rugi_rekonsiliasi" class="nav-link">
                      <i class="far fa-cc nav-icon"></i>
                      <i class="far fa-circle nav-icon"></i>
                      <p>Laba Rugi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/view_perubahan_modal_rekonsiliasi" class="nav-link">
                      <i class="far fa-cc nav-icon"></i>
                      <i class="far fa-circle nav-icon"></i>
                      <p>Perubahan Modal</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>Dashboard/view_neraca_rekonsiliasi" class="nav-link">
                      <i class="far fa-cc nav-icon"></i>
                      <i class="far fa-circle nav-icon"></i>
                      <p>Neraca</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <?php }?>

          <?php if($this->session->userdata('role')=="superadmin"){?>
            <li class="nav-item">
              <a href="<?php echo base_url()?>Dashboard/air_maintenance_report_perumahan" class="nav-link">
                <i class="nav-icon fas fa-tint"></i>
                <p>
                  Air & Maintenance
                </p>
              </a>
            </li>
          <?php }?>
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