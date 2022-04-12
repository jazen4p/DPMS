<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <?php include "include/title.php"?>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<!-- body -->
<?php include "include/fixedtop.php"?>
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: white">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div> -->
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Perhatian!</strong> Demi kelancaran penggunaan, harap gunakan Google Chrome atau Mozzila Firefox! Terima kasih.
        </div>
        <div style="text-align: center">
          <b style="font-size: 30px">Selamat Datang</b><br> 
          <b style="font-size: 22px"><?php echo $this->session->userdata('nama');?></b>
        </div>
      <hr>
    <?php 
    if($this->session->userdata('role') == "manager keuangan" || $this->session->userdata('role') == "superadmin" || $this->session->userdata('role') == "manager produksi" || $this->session->userdata('role') == "kepala admin" || $this->session->userdata('role') == "staff admin" || $this->session->userdata('role') == "staff admin penagihan") {?>
      
      <form action="<?php echo base_url()?>Dashboard/filter_perumahan_dashboard" method="POST">
        <div class="row">
          <select name="perumahan" class="form-control col-sm-3">
            <option value="">Semua</option>
            <?php foreach($this->db->get('perumahan')->result() as $prm){
              echo "<option ";
              if(isset($kode_prmh)){
                if($kode_prmh == $prm->kode_perumahan){
                  echo "selected";
                }
              }
              echo " value='$prm->kode_perumahan'>$prm->nama_perumahan</option>";
            }?>
          </select> 

          <input type="submit" class="btn btn-flat btn-sm btn-default" value="OK">
        </div>
      </form> 
      <hr>
      
      <?php $no=1; foreach($perumahan->result() as $row) {
        $data['ppjb_dp'] = $this->db->get_where('ppjb-dp', array('kode_perumahan'=>$row->kode_perumahan, 'status'=>"belum lunas", 'cara_bayar <>'=>"KPR"))->result();
        // print_r($data['ppjb_dp']);
        $today = date('Y-m-d');
        $mendekati=0;
        $hari_ini=0;
        $melewati=0;

        foreach($data['ppjb_dp'] as $row2){
          if($row2->status=="belum lunas"){
            $tanggal_masuk = $row2->tanggal_dana;
            $no_ppjb = $row2->no_psjb;
            $id_ppjb = $row2->id_psjb;

            $interval = strtotime($tanggal_masuk) - strtotime($today);
            $day = floor($interval / 86400); // 1 day
            if($day >= 1 && $day <= 7) {
              $mendekati++;
              // foreach($this->db->get('ppjb')->result() as $ppjb){
              //   $test1 = $this->Dashboard_model->bulletin_dashboard_mendekati($row2->no_psjb, $row2->kode_perumahan)->result();
              //   echo $mendekati = count($test1);
              // }
            } elseif($day < 0) {
              $melewati++;
              // foreach($this->db->get('ppjb')->result() as $ppjb){
              //   $test2 = $this->Dashboard_model->bulletin_dashboard_melewati($row2->no_psjb, $row2->kode_perumahan)->result();
              // }
            } elseif($day == 0) {
              $hari_ini++;
              // foreach($this->db->get('ppjb')->result() as $ppjb){
              //   $test3 = $this->Dashboard_model->bulletin_dashboard_hariini($row2->no_psjb, $row2->kode_perumahan)->result();
              // }
            }
          }
        }
        ?>
          <!-- Info boxes -->

          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url()?>Dashboard/filter_keuangan_dashboard?id=a&kode=<?php echo $row->kode_perumahan?>" class="info-box" style="background-color: navy; color: white">
                <span class="info-box-icon elevation-1" style="background-color: grey;"><?php echo $mendekati;?></span>

                <div class="info-box-content">
                  <span class="info-box-text" style="font-size: 20px">Jatuh Tempo</span>
                  <span class="info-box-number" style="font-size: 25px">
                    MENDEKATI
                  </span>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url()?>Dashboard/filter_keuangan_dashboard?id=b&kode=<?php echo $row->kode_perumahan?>" class="info-box mb-3" style="background-color: aqua; color: black">
                <span class="info-box-icon elevation-1" style="background-color: grey; color: white"><?php echo $hari_ini?></span>

                <div class="info-box-content">
                  <span class="info-box-text" style="font-size: 20px">Jatuh Tempo</span>
                  <span class="info-box-number" style="font-size: 25px">HARI INI</span>
                </div>
              </a>
            </div>
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url()?>Dashboard/filter_keuangan_dashboard?id=c&kode=<?php echo $row->kode_perumahan?>" class="info-box mb-3" style="background-color: navy; color: white">
                <span class="info-box-icon elevation-1" style="background-color: grey;"><?php echo $melewati?></span>

                <div class="info-box-content">
                  <span class="info-box-text" style="font-size: 20px">Jatuh Tempo</span>
                  <span class="info-box-number" style="font-size: 25px">MELEWATI</span>
                </div>
              </a>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <?php 
                $query = $this->db->get_where('perusahaan', array('nama_perusahaan'=>$row->nama_perusahaan));
                foreach($query->result() as $foto){ ?>
                <img src="<?php echo base_url()?>gambar/<?php echo $foto->file_name?>" style="width: 150px; height: 80px">
              <?php }?>
            </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <hr style="">
            <div class="row">
              <div class="col-md-6" style="padding-left: 30px; font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
                <b><?php echo $row->nama_perusahaan?></b>
              </div>
              <div class="col-md-6" style="text-align: right; padding-right: 30px; font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
                <b>Perumahan <?php echo $row->nama_perumahan?></b>
              </div>
            </div>
          <hr style="">
          <br>
            <div style="background-color: aqua; padding-left: 20px; padding-top: 20px; padding-bottom: 20px; font-size: 20px">
              <b>Kinerja Operasional</b>
            </div>
            <div class="row">
              <div class="col-sm-12" style="text-align: left">
                <form action="<?php echo base_url()?>Dashboard/filter_tahun" method="POST">
                  <div class="row">
                    <select name="year" class="form-control col-1">
                      <?php for($i = 1900; $i <= $year_now+10; $i++){
                      echo "<option ";
                      if($i == $year){
                        echo "selected";
                      }
                      echo " >$i</option>";
                      }?>
                    </select>

                    <input type="submit" class="btn btn-sm btn-default" value="OK">
                  </div>
                </form>
              </div>
              <div class="col-sm-6 card" style="text-align: center;">
                <label>Total Penjualan Unit (<?php echo $year?>)</label>
                <canvas id="myChart<?php echo $no?>"></canvas>
              </div>
              <div class="col-sm-6 card" style="text-align: center;">
                <label>Total Penjualan Kavling (<?php echo $year?>)</label>
                <canvas id="myChartKav<?php echo $no?>"></canvas>
              </div>
              <div class="col-sm-6 card" style="text-align: center">
                <label>Total Piutang Terbayar</label>
                <canvas id="myCharts<?php echo $no?>"></canvas>
              </div>
              <div class="col-sm-6 card" style="text-align: center">
                <label>Total Hutang</label>
                <canvas id="myChartUtang<?php echo $no?>"></canvas>
              </div>
            </div>
          <br>
          <hr>
        </div>
      <!-- /.content -->
      </section>
      <?php 
        $arr = array();
        $v_prev = 0; $v_prev1 = 0; $vars = 0;
        foreach($this->Dashboard_model->graph_ppjb($row->kode_perumahan)->result() as $ppjb){
          // print_r($this->Dashboard_model->graph_piutang($ppjb->no_psjb, $row->kode_perumahan, $year)->result());
          foreach($this->Dashboard_model->graph_piutang($ppjb->no_psjb, $row->kode_perumahan, $year)->result() as $prev){
            $v_prev = $v_prev + $prev->dana_masuk;

            foreach($this->Dashboard_model->graph_piutang_byr($row->kode_perumahan, $prev->id_psjb, $year)->result() as $prev1){
              $v_prev1 = $v_prev1 + $prev1->pembayaran;
            }
            
          }
        }
        // print_r($v_prev1);
        $vars = $vars + ($v_prev - $v_prev1);

        for($i = 1; $i <= 12; $i++){
          // echo $year."-".sprintf('%02d', $i);
          $var1 = 0;
          $unit = $this->db->get_where('ppjb', array('kode_perumahan'=>$row->kode_perumahan, 'status <>'=>"batal", 'tipe_produk'=>"rumah"));
          foreach($unit->result() as $gr_unit){
            if(date('Y-m', strtotime($gr_unit->tgl_psjb)) == $year."-".sprintf('%02d', $i)){
              $var1 = $var1 + 1;

              foreach($this->db->get_where('rumah', array('no_psjb'=>$gr_unit->psjb, 'kode_perumahan'=>$gr_unit->kode_perumahan, 'tipe_produk'=>$gr_unit->tipe_produk))->result() as $rmh){
                $var1 = $var1 + 1;
              }

              // echo $noarray[];
            }
          }
          $noarray[$i] = $var1;
          $str = implode (", ", $noarray);
          ?>
            <input type="hidden" id="unit<?php echo $no?>bln<?php echo $i?>" value="<?php echo $var1?>">
          <?php 

          $varZ = 0;
          $unit1 = $this->db->get_where('ppjb', array('kode_perumahan'=>$row->kode_perumahan, 'status <>'=>"batal", 'tipe_produk'=>"kavling"));
          foreach($unit1->result() as $gr_unit1){
            if(date('Y-m', strtotime($gr_unit1->tgl_psjb)) == $year."-".sprintf('%02d', $i)){
              $varZ = $varZ + 1;

              foreach($this->db->get_where('rumah', array('no_psjb'=>$gr_unit1->psjb, 'kode_perumahan'=>$gr_unit1->kode_perumahan, 'tipe_produk'=>$gr_unit1->tipe_produk))->result() as $rmh1){
                $varZ = $varZ + 1;
              }

              // echo $noarray[];
            }
          }
          $noarray1[$i] = $varZ;
          $str = implode (", ", $noarray1);
          ?>
            <input type="hidden" id="unitZ<?php echo $no?>bln<?php echo $i?>" value="<?php echo $varZ?>">
          <?php 

          $var2=0; $var3=0; $var4 = 0; $var5 = 0;
          foreach($this->db->get_where('ppjb', array('kode_perumahan'=>$row->kode_perumahan, 'status'=>"dom"))->result() as $ppjbs){
            // $unit2 = $this->db->get_where('ppjb-dp', array('no_ppjb'=>$ppjbs->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'cara_bayar <>'=>"Uang Tanda Jadi", 'cara_bayar <>'=>"KPR"));
            $unit2 = $this->Dashboard_model->graph1($ppjbs->no_psjb, $row->kode_perumahan);
            // foreach($this->Dashboard_model->graph_piutang($row->kode_perumahan, $year."-".sprintf('%02d', $i))->result() as $uang){
            foreach($unit2->result() as $uang){
              if(date('Y-m', strtotime($uang->tanggal_dana)) == $year."-".sprintf('%02d', $i)){
                $var2 = $var2 + $uang->dana_masuk;

                // $var3 = $var3 + $uang->dana_bayar;
                // echo $noarray1[$i];
              }

              foreach($this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$uang->id_psjb,'kode_perumahan'=>$row->kode_perumahan))->result() as $kaskpr){
                if(date('Y-m', strtotime($kaskpr->tanggal_bayar)) == $year."-".sprintf('%02d', $i)){
                  $var3 = $var3 + $kaskpr->pembayaran;
                }
              }
            }
          }

          $noarray1[$i] = $var2;
          // echo $noarray1[$i];
          $noarray2[$i] = $var3;
          $str = implode (", ", $noarray1);

          $a = $i - 1;
          // echo date("Y-m", strtotime($year."-".sprintf('%02d', $a)));
          // foreach($this->Dashboard_model->graph_piutang($row->kode_perumahan, $year."-".sprintf('%02d', $a))->result() as $uang2){
          // foreach($unit2->result() as $uang2){
          //   $dt = date('Y-m', strtotime('-1 months', strtotime($uang2->tanggal_dana)));
          //   if($dt == $year."-".sprintf('%02d', $a)){
          //     // echo $year."-".sprintf('%02d', $a);
          //     $var4 = $var4 + $uang2->dana_masuk;

          //     $var5 = $var5 + $uang2->dana_bayar;

          //     // $vars = $vars + ($var4 - $var5);
          //   }
          // }
          
          if(isset($noarray[$i - 1])){
            $vars = $vars + ($noarray1[$i-1] - $noarray2[$i-1]);
          }
          // $vars = $var2 - $var3;
          // echo $vars;

          // print_r($previousValue);
          ?>
            <input type="hidden" id="unitA<?php echo $no?>blnA<?php echo $i?>" value="<?php echo $var2?>">
            <input type="hidden" id="unitQ<?php echo $no?>blnQ<?php echo $i?>" value="<?php echo $var2 + $vars?>">
            <input type="hidden" id="unitW<?php echo $no?>blnW<?php echo $i?>" value="<?php echo $var3?>">
          <?php 

          $var6 = 0; $var7 = 0;
          $utang_bahan = $this->Dashboard_model->dashboard_group_utang_bahan($year."-".sprintf('%02d', $i), $row->kode_perumahan);
          $utang_usaha = $this->Dashboard_model->dashboard_group_utang($year."-".sprintf('%02d', $i), $row->kode_perumahan);
          // print_r($utang_bahan->result());

          foreach($utang_usaha->result() as $utgush){
            $query_utg_usaha = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$utgush->no_pengeluaran));
            // $nominal_sementara = 0;
            $var6 = $var6 + $utgush->nominal;

            foreach($query_utg_usaha->result() as $uang){
              $var7 = $var7 + $uang->nominal;
            }
            if($query->num_rows() == 0){?>
            
            <?php } else {
            }
          }

          // $ttl_utgbhn = 0;
          foreach($utang_bahan->result() as $pr){
            // foreach($this->db->get_where('produksi_transaksi', array('nama_toko'=>$pr->nama_toko, 'tgl_deadline'=>$pr->tgl_deadline))->result() as $tl1){
              $query = $this->db->get_where('produksi_pengajuan', array('id_pengajuan'=>$pr->id_pengajuan));

              $var6 = $var6 + ($pr->qty * $pr->harga_satuan);

              $total_byr=0; foreach($this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>$pr->no_faktur))->result() as $byr){
                $var7 = $var7 + $byr->nominal;
              }

              // $ttl_utgbhn = $ttl_utgbhn + ($tl1->qty * $tl1->harga_satuan);
            // }
            // echo "Rp. ".number_format($ttl_utgbhn);
          }
          ?>
            <input type="hidden" id="utang<?php echo $no?>bln<?php echo $i?>" value="<?php echo $var6?>">
            <input type="hidden" id="utangByr<?php echo $no?>bln<?php echo $i?>" value="<?php echo $var7?>">
          <?php 
        }
        // print_r($noarray); 
      ?>
      <!-- <input type="text" name="var1[]" id="fact<?php echo $no?>" value="<?php echo $str?>"> -->

      <?php 
      ?>
    <?php $no++;} ?>
      <input type="hidden" value="<?php echo $no-1?>" id="check">
    <?php } else if($this->session->userdata('role')=="manager marketing"){?>
      
      <form action="<?php echo base_url()?>Dashboard/filter_perumahan_dashboard" method="POST">
        <div class="row">
          <select name="perumahan" class="form-control col-sm-3">
            <option value="">Semua</option>
            <?php foreach($this->db->get('perumahan')->result() as $prm){
              echo "<option ";
              if(isset($kode_prmh)){
                if($kode_prmh == $prm->kode_perumahan){
                  echo "selected";
                }
              }
              echo " value='$prm->kode_perumahan'>$prm->nama_perumahan</option>";
            }?>
          </select> 

          <input type="submit" class="btn btn-flat btn-sm btn-default" value="OK">
        </div>
      </form> 
      <hr>
      
      <?php $no=1; foreach($perumahan->result() as $row) {
        $data['ppjb_dp'] = $this->db->get_where('ppjb-dp', array('kode_perumahan'=>$row->kode_perumahan, 'status'=>"belum lunas", 'cara_bayar <>'=>"KPR"))->result();
        // print_r($data['ppjb_dp']);
        $today = date('Y-m-d');
        $mendekati=0;
        $hari_ini=0;
        $melewati=0;

        foreach($data['ppjb_dp'] as $row2){
          if($row2->status=="belum lunas"){
            $tanggal_masuk = $row2->tanggal_dana;
            $no_ppjb = $row2->no_psjb;
            $id_ppjb = $row2->id_psjb;

            $interval = strtotime($tanggal_masuk) - strtotime($today);
            $day = floor($interval / 86400); // 1 day
            if($day >= 1 && $day <= 7) {
              $mendekati++;
              // foreach($this->db->get('ppjb')->result() as $ppjb){
              //   $test1 = $this->Dashboard_model->bulletin_dashboard_mendekati($row2->no_psjb, $row2->kode_perumahan)->result();
              //   echo $mendekati = count($test1);
              // }
            } elseif($day < 0) {
              $melewati++;
              // foreach($this->db->get('ppjb')->result() as $ppjb){
              //   $test2 = $this->Dashboard_model->bulletin_dashboard_melewati($row2->no_psjb, $row2->kode_perumahan)->result();
              // }
            } elseif($day == 0) {
              $hari_ini++;
              // foreach($this->db->get('ppjb')->result() as $ppjb){
              //   $test3 = $this->Dashboard_model->bulletin_dashboard_hariini($row2->no_psjb, $row2->kode_perumahan)->result();
              // }
            }
          }
        }
        ?>
          <!-- Info boxes -->

          <div class="row">
            <!-- <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url()?>Dashboard/filter_keuangan_dashboard?id=a&kode=<?php echo $row->kode_perumahan?>" class="info-box" style="background-color: navy; color: white">
                <span class="info-box-icon elevation-1" style="background-color: grey;"><?php echo $mendekati;?></span>

                <div class="info-box-content">
                  <span class="info-box-text" style="font-size: 20px">Jatuh Tempo</span>
                  <span class="info-box-number" style="font-size: 25px">
                    MENDEKATI
                  </span>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url()?>Dashboard/filter_keuangan_dashboard?id=b&kode=<?php echo $row->kode_perumahan?>" class="info-box mb-3" style="background-color: aqua; color: black">
                <span class="info-box-icon elevation-1" style="background-color: grey; color: white"><?php echo $hari_ini?></span>

                <div class="info-box-content">
                  <span class="info-box-text" style="font-size: 20px">Jatuh Tempo</span>
                  <span class="info-box-number" style="font-size: 25px">HARI INI</span>
                </div>
              </a>
            </div>

            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url()?>Dashboard/filter_keuangan_dashboard?id=c&kode=<?php echo $row->kode_perumahan?>" class="info-box mb-3" style="background-color: navy; color: white">
                <span class="info-box-icon elevation-1" style="background-color: grey;"><?php echo $melewati?></span>

                <div class="info-box-content">
                  <span class="info-box-text" style="font-size: 20px">Jatuh Tempo</span>
                  <span class="info-box-number" style="font-size: 25px">MELEWATI</span>
                </div>
              </a>
            </div> -->

            <div class="col-12 col-sm-6 col-md-3" style="text-align: center">
              <?php 
                $query = $this->db->get_where('perusahaan', array('nama_perusahaan'=>$row->nama_perusahaan));
                foreach($query->result() as $foto){ ?>
                <img src="<?php echo base_url()?>gambar/<?php echo $foto->file_name?>" style="width: 150px; height: 80px">
              <?php }?>
            </div>
          
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <hr style="">
            <div class="row">
              <div class="col-md-6" style="padding-left: 30px; font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
                <b><?php echo $row->nama_perusahaan?></b>
              </div>
              <div class="col-md-6" style="text-align: right; padding-right: 30px; font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
                <b>Perumahan <?php echo $row->nama_perumahan?></b>
              </div>
            </div>
          <hr style="">
          <br>
            <div style="background-color: aqua; padding-left: 20px; padding-top: 20px; padding-bottom: 20px; font-size: 20px">
              <b>Kinerja Operasional</b>
            </div>
            <div class="row">
              <div class="col-sm-12" style="text-align: left">
                <form action="<?php echo base_url()?>Dashboard/filter_tahun" method="POST">
                  <div class="row">
                    <select name="year" class="form-control col-1">
                      <?php for($i = 1900; $i <= $year_now+10; $i++){
                      echo "<option ";
                      if($i == $year){
                        echo "selected";
                      }
                      echo " >$i</option>";
                      }?>
                    </select>

                    <input type="submit" class="btn btn-sm btn-default" value="OK">
                  </div>
                </form>
              </div>
              <div class="col-sm-6 card" style="text-align: center;">
                <label>Total Penjualan Unit (<?php echo $year?>)</label>
                <canvas id="myChartMarket<?php echo $no?>"></canvas>
              </div>
              <!-- <div class="col-sm-6 card" style="text-align: center">
                <label>Total Piutang Terbayar</label>
                <canvas id="myCharts<?php echo $no?>"></canvas>
              </div>
              <div class="col-sm-6 card" style="text-align: center">
                <label>Total Hutang</label>
                <canvas id="myChartUtang<?php echo $no?>"></canvas>
              </div> -->
            </div>
          <br>
          <hr>
        </div>
      <!-- /.content -->
      </section>
      <?php 
        $arr = array();
        $v_prev = 0; $v_prev1 = 0; $vars = 0;
        foreach($this->Dashboard_model->graph_ppjb($row->kode_perumahan)->result() as $ppjb){
          // print_r($this->Dashboard_model->graph_piutang($ppjb->no_psjb, $row->kode_perumahan, $year)->result());
          foreach($this->Dashboard_model->graph_piutang($ppjb->no_psjb, $row->kode_perumahan, $year)->result() as $prev){
            $v_prev = $v_prev + $prev->dana_masuk;

            foreach($this->Dashboard_model->graph_piutang_byr($row->kode_perumahan, $prev->id_psjb, $year)->result() as $prev1){
              $v_prev1 = $v_prev1 + $prev1->pembayaran;
            }
            
          }
        }
        // print_r($v_prev1);
        $vars = $vars + ($v_prev - $v_prev1);

        for($i = 1; $i <= 12; $i++){
          // echo $year."-".sprintf('%02d', $i);
          $var1 = 0;
          $unit = $this->db->get_where('ppjb', array('kode_perumahan'=>$row->kode_perumahan, 'status <>'=>"batal"));
          foreach($unit->result() as $gr_unit){
            if(date('Y-m', strtotime($gr_unit->tgl_psjb)) == $year."-".sprintf('%02d', $i)){
              $var1 = $var1 + 1;

              foreach($this->db->get_where('rumah', array('no_psjb'=>$gr_unit->psjb, 'kode_perumahan'=>$gr_unit->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rmh){
                $var1 = $var1 + 1;
              }

              // echo $noarray[];
            }
          }
          $noarray[$i] = $var1;
          $str = implode (", ", $noarray);
          ?>
            <input type="hidden" id="unit1<?php echo $no?>bln1<?php echo $i?>" value="<?php echo $var1?>">
          <?php 

        }
        // print_r($noarray); 
      ?>
      <!-- <input type="text" name="var1[]" id="fact<?php echo $no?>" value="<?php echo $str?>"> -->

      <?php 
      ?>
    <?php $no++;} ?>
      <input type="hidden" value="<?php echo $no-1?>" id="check1">
    <?php } else {?>
      </div>
    </section>
    <?php }?>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
  <?php include "include/footer.php"?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url()?>asset/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url()?>asset/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>asset/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/pages/dashboard2.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  $(function () {
      var check = $('#check').val();
      // alert(check);

      for (var x = 1; x <= check; x++) {
      (function (x) {
        var kode = $('#kode'+x).val();
        var a = 1;
        // alert(kode);
        // var str = $('#fact'+x).val()
        var array = [];
        for(var v = 1; v <= 12; v++){
          var coda = $('#unit'+x+'bln'+v).val();
          // alert(coda);
          array.push(coda);
        }
        // alert(array[10]);

        var ctx = document.getElementById('myChart'+x).getContext('2d');
        var chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [
              'Jan <?php echo $year?>',
              'Feb <?php echo $year?>',
              'Mar <?php echo $year?>',
              'Apr <?php echo $year?>',
              'Mei <?php echo $year?>',
              'Jun <?php echo $year?>',
              'Jul <?php echo $year?>',
              'Agu <?php echo $year?>',
              'Sep <?php echo $year?>',
              'Okt <?php echo $year?>',
              'Nov <?php echo $year?>',
              'Des <?php echo $year?>',
            ],
            datasets: [{
                label: 'Unit',
                backgroundColor: '#ADD8E6',
                borderColor: '##93C3D2',
                data: [
                  array[0], array[1], array[2], array[3], array[4], array[5], array[6], array[7], array[8], array[9], array[10] , array[11]         
                ]
            }]
          },
          options: {
              responsive: true,
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
        });

        var arrayz = [];
        for(var v = 1; v <= 12; v++){
          var codaz = $('#unitZ'+x+'bln'+v).val();
          // alert(coda);
          arrayz.push(codaz);
        }
        // alert(array[10]);

        var ctxz = document.getElementById('myChartKav'+x).getContext('2d');
        var chartz = new Chart(ctxz, {
          type: 'line',
          data: {
            labels: [
              'Jan <?php echo $year?>',
              'Feb <?php echo $year?>',
              'Mar <?php echo $year?>',
              'Apr <?php echo $year?>',
              'Mei <?php echo $year?>',
              'Jun <?php echo $year?>',
              'Jul <?php echo $year?>',
              'Agu <?php echo $year?>',
              'Sep <?php echo $year?>',
              'Okt <?php echo $year?>',
              'Nov <?php echo $year?>',
              'Des <?php echo $year?>',
            ],
            datasets: [{
                label: 'Unit',
                backgroundColor: '#ADD8E6',
                borderColor: '##93C3D2',
                data: [
                  arrayz[0], arrayz[1], arrayz[2], arrayz[3], arrayz[4], arrayz[5], arrayz[6], arrayz[7], arrayz[8], arrayz[9], arrayz[10] , arrayz[11]         
                ]
            }]
          },
          options: {
              responsive: true,
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
        });

        var array2 = [];
        for(var vs = 1; vs <= 12; vs++){
          var coda2 = $('#unitQ'+x+'blnQ'+vs).val();
          // alert(coda);
          array2.push(coda2);
        }
        var array3 = [];
        for(var va = 1; va <= 12; va++){
          var coda3 = $('#unitW'+x+'blnW'+va).val();
          // alert(coda);
          array3.push(coda3);
        }
        var array4 = [];
        for(var vw = 1; vw <= 12; vw++){
          var coda4 = $('#unitA'+x+'blnA'+vw).val();
          // alert(coda);
          array4.push(coda4);
        }

        var ctx = document.getElementById('myCharts'+x).getContext('2d');
        var chart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: [
              'Jan <?php echo $year?>',
              'Feb <?php echo $year?>',
              'Mar <?php echo $year?>',
              'Apr <?php echo $year?>',
              'Mei <?php echo $year?>',
              'Jun <?php echo $year?>',
              'Jul <?php echo $year?>',
              'Agu <?php echo $year?>',
              'Sep <?php echo $year?>',
              'Okt <?php echo $year?>',
              'Nov <?php echo $year?>',
              'Des <?php echo $year?>',
            ],
            datasets: [
              {
                label: "Piutang",
                backgroundColor: 'red',
                borderColor: 'red',
                data: [
                  array4[0], array4[1], array4[2], array4[3], array4[4], array4[5], array4[6], array4[7], array4[8], array4[9], array4[10] , array4[11]  
                ]
              },
              {
                label: "Ak. Piutang",
                backgroundColor: 'lightblue',
                borderColor: 'lightblue',
                data: [
                  array2[0], array2[1], array2[2], array2[3], array2[4], array2[5], array2[6], array2[7], array2[8], array2[9], array2[10] , array2[11]  
                ]
              },
              {
                label: "Pembayaran",
                backgroundColor: '#32E511',
                borderColor: '##2CEE0A',
                data: [
                  array3[0], array3[1], array3[2], array3[3], array3[4], array3[5], array3[6], array3[7], array3[8], array3[9], array3[10] , array3[11]  
                ]
              }
            ]
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, data) {
                  var dataLabel = data.labels[tooltipItem.index];
                  var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString();

                  // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
                  if (Chart.helpers.isArray(dataLabel)) {
                    // show value on first line of multiline label
                    // need to clone because we are changing the value
                    dataLabel = dataLabel.slice();
                    dataLabel[0] += value;
                  } else {
                    dataLabel += value;
                  }

                  // return the text to display on the tooltipif(parseInt(value) >= 1000){
                  if(parseInt(value) >= 1000){
                    return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  } else {
                    return 'Rp. ' + value;
                  }
                  // return value;
                }
              } // end callbacks:
            },
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                      beginAtZero: true,
                      callback: function(value, index, values) {
                        if(parseInt(value) >= 1000){
                          return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                          return 'Rp. ' + value;
                        }
                      }
                    }
                }]
            },
          }
        });


        var array5 = [];
        for(var vs = 1; vs <= 12; vs++){
          var coda5 = $('#utang'+x+'bln'+vs).val();
          // alert(coda);
          array5.push(coda5);
        }
        var array6 = [];
        for(var va = 1; va <= 12; va++){
          var coda6 = $('#utangByr'+x+'bln'+va).val();
          // alert(coda);
          array6.push(coda6);
        }

        var ctx = document.getElementById('myChartUtang'+x).getContext('2d');
        var chart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: [
              'Jan <?php echo $year?>',
              'Feb <?php echo $year?>',
              'Mar <?php echo $year?>',
              'Apr <?php echo $year?>',
              'Mei <?php echo $year?>',
              'Jun <?php echo $year?>',
              'Jul <?php echo $year?>',
              'Agu <?php echo $year?>',
              'Sep <?php echo $year?>',
              'Okt <?php echo $year?>',
              'Nov <?php echo $year?>',
              'Des <?php echo $year?>',
            ],
            datasets: [
              {
                label: "Hutang",
                backgroundColor: 'red',
                borderColor: 'red',
                data: [
                  array5[0], array5[1], array5[2], array5[3], array5[4], array5[5], array5[6], array5[7], array5[8], array5[9], array5[10] , array5[11]  
                ]
              },
              {
                label: "Pembayaran",
                backgroundColor: '#32E511',
                borderColor: '##2CEE0A',
                data: [
                  array6[0], array6[1], array6[2], array6[3], array6[4], array6[5], array6[6], array6[7], array6[8], array6[9], array6[10] , array6[11]  
                ]
              }
            ]
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, data) {
                  var dataLabel = data.labels[tooltipItem.index];
                  var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString();

                  // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
                  if (Chart.helpers.isArray(dataLabel)) {
                    // show value on first line of multiline label
                    // need to clone because we are changing the value
                    dataLabel = dataLabel.slice();
                    dataLabel[0] += value;
                  } else {
                    dataLabel += value;
                  }

                  // return the text to display on the tooltipif(parseInt(value) >= 1000){
                  if(parseInt(value) >= 1000){
                    return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  } else {
                    return 'Rp. ' + value;
                  }
                  // return value;
                }
              } // end callbacks:
            },
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                      beginAtZero: true,
                      callback: function(value, index, values) {
                        if(parseInt(value) >= 1000){
                          return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                          return 'Rp. ' + value;
                        }
                      }
                    }
                }]
            },
          }
        });
      })(x);
      }
  });
})

$(document).ready(function() {
  $(function () {
      var check = $('#check1').val();
      // alert(check);

      for (var x = 1; x <= check; x++) {
      (function (x) {
        var kode = $('#kode1'+x).val();
        var a = 1;
        // alert(kode);
        // var str = $('#fact'+x).val()
        var array = [];
        for(var v = 1; v <= 12; v++){
          var coda = $('#unit1'+x+'bln1'+v).val();
          // alert(coda);
          array.push(coda);
        }
        // alert(array[10]);

        var ctx = document.getElementById('myChartMarket'+x).getContext('2d');
        var chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [
              'Jan <?php echo $year?>',
              'Feb <?php echo $year?>',
              'Mar <?php echo $year?>',
              'Apr <?php echo $year?>',
              'Mei <?php echo $year?>',
              'Jun <?php echo $year?>',
              'Jul <?php echo $year?>',
              'Agu <?php echo $year?>',
              'Sep <?php echo $year?>',
              'Okt <?php echo $year?>',
              'Nov <?php echo $year?>',
              'Des <?php echo $year?>',
            ],
            datasets: [{
                label: 'Unit',
                backgroundColor: '#ADD8E6',
                borderColor: '##93C3D2',
                data: [
                  array[0], array[1], array[2], array[3], array[4], array[5], array[6], array[7], array[8], array[9], array[10] , array[11]         
                ]
            }]
          },
          options: {
              responsive: true,
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
        });
      })(x);
      }
  });
})
    // var ctx = document.getElementById('myChart').getContext('2d');
    // var chart = new Chart(ctx, {
    //   type: 'line',
    //   data: {
    //     labels: [
    //       'Jan <?php echo date('Y')?>',
    //       'Feb <?php echo date('Y')?>',
    //       'Mar <?php echo date('Y')?>',
    //       'Apr <?php echo date('Y')?>',
    //       'Mei <?php echo date('Y')?>',
    //       'Jun <?php echo date('Y')?>',
    //       'Jul <?php echo date('Y')?>',
    //       'Agu <?php echo date('Y')?>',
    //       'Sep <?php echo date('Y')?>',
    //       'Okt <?php echo date('Y')?>',
    //       'Nov <?php echo date('Y')?>',
    //       'Des <?php echo date('Y')?>',
    //     ],
    //     datasets: [{
    //         label: 'Unit',
    //         backgroundColor: '#ADD8E6',
    //         borderColor: '##93C3D2',
    //         data: [
    //           <?php 

    //           ?>
    //         ]
    //     }]
    //   },
    // });
 

  </script>
</body>
</html>
