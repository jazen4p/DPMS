<html><head>
   <style>
     @page { margin: 55px 50px 80px; }
     #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -155px; right: 0px; height: 150px; }
     #footer .page:after { content: counter(page); }
     /* @font-face {
        font-family: 'Elegance';
        font-weight: normal;
        font-style: normal;
        font-variant: normal;
        src: url("http://eclecticgeek.com/dompdf/fonts/Elegance.ttf") format("truetype");
      }
      body {
        font-family: Elegance, sans-serif;
      } */
   </style>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
   <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/bootstrap.min.css" />
   <script type="text/javascript">
    $(document).ready(function(){ 
        var check = $('#aktiva').val();
        // var i;
        $('#totalAktiva').html("Rp. "+check);
        // $('#volume1').val(check);
        var check2 = $('#passiva').val();
        // var i;
        $('#totalPassiva').html("Rp. "+check2);
        // $('#volume1').val(check);
    })
   </script>
</head><body>
<?php
  function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
      $temp = penyebut($nilai - 10). " Belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " Seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
  }

  function terbilang($nilai) {
    if($nilai<0) {
      $hasil = "minus ". trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    }     		
    return $hasil;
  }

  function ubahHari($hari) {
    if($hari == "Mon") {
      $hasil = "Senin";
    }elseif($hari == "Tue") {
      $hasil = "Selasa";
    }elseif($hari == "Wed") {
      $hasil = "Rabu";
    }elseif($hari == "Thu") {
      $hasil = "Kamis";
    }elseif($hari == "Fri") {
      $hasil = "Jumat";
    }elseif($hari == "Sat") {
      $hasil = "Sabtu";
    }else{
      $hasil = "Minggu";
    }
    return $hasil;
  }

  function ubahBulan($hari) {
    if($hari == "Jan") {
      $hasil = "Januari";
    }elseif($hari == "Feb") {
      $hasil = "Febuari";
    }elseif($hari == "Mar") {
      $hasil = "Maret";
    }elseif($hari == "Apr") {
      $hasil = "April";
    }elseif($hari == "May") {
      $hasil = "Mei";
    }elseif($hari == "Jun") {
      $hasil = "Juni";
    }elseif($hari == "Jul") {
      $hasil = "Juli";
    }elseif($hari == "Aug") {
      $hasil = "Agustus";
    }elseif($hari == "Sep") {
      $hasil = "September";
    }elseif($hari == "Oct") {
      $hasil = "Oktober";
    }elseif($hari == "Nov") {
      $hasil = "November";
    }else{
      $hasil = "Desember";
    }
    return $hasil;
  }
?>
   <!-- <div id="footer">
      <hr style="border-top: 1px solid">
     <p class="page"><span style="font-weight: bold"><i>Perjanjian Sementara Jual Beli</i></span> <span style="padding-left:410px"> Halaman <?php $PAGE_NUM ?> </span></p>
   </div> -->
   <div id="content">
        <div style="text-align: center">
            <span style="font-weight: bold"><?php echo $nama_perusahaan?></span><br>
            Neraca Saldo <br>
            <?php if($tglmax == ""){?>
                Per. <?php echo date('t F Y')?> <br><br>
            <?php } else {?>
                Per. <?php echo date('t F Y', strtotime($tglmax))?> <br><br>
            <?php }?>

            <table id="example2" class="table table-bordered table-striped" style="font-size: 12px;">
              <thead>
                <tr>
                    <th colspan=4></th>
                    <th>AWAL</th>
                    <th>BERJALAN</th>
                    <th>JURNAL KOREKSI</th>
                    <th>JURNAL PENYESUAIAN</th>
                    <th>AKHIR</th>
                    <!-- <th>Status</th> -->
                    <!-- <th>Jmlh Diterima</th> -->
                </tr>
              </thead>
              <tbody style="white-space: nowrap">
                    <tr style="background-color: lightblue; font-size: 16px; font-weight: bold">
                        <td colspan=8>AKTIVA</td>
                        <td><div id="totalAktiva"></div></td>
                    </tr>

                    <?php 
                    $qus = $this->db->get_where('perumahan', array('kode_perusahaan'=>$id));
                    $ttl1=0;
                    foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>""))->result() as $induk){?>
                        <?php 
                        foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$induk->id_induk))->result() as $anak){
                        $kr2=0; $db2 = 0; $krA = 0; $dbA = 0 ; $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $db2=0; $kr2=0; $ttl_awal = 0; $db=0; $kr=0;  $kr_jrl=0; $db_jrl=0; $ttl_sld=0; $kr_jrl1 = 0; $db_jrl1 = 0; $ttl_mdl_awal = 0; $db=0; $kr=0;
                        foreach($qus->result() as $res){
                        foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun, 'kode_perumahan'=>$res->kode_perumahan))->result() as $modal){?>

                        <?php 
                        
                          if($tglmin == ""){
                            $ttl_awal = $ttl_awal + $modal->nominal;

                            ?>
                            <?php
                          } else {
                            if($tglmin != ""){
                              $kr=0; $db=0;
                              foreach($this->Dashboard_model->laba_rugi_saldo_awal($modal->no_akun, $res->kode_perumahan, $tglmin)->result() as $awal){
                                if($awal->pos_akun == "kredit"){
                                  $kr = $kr + $awal->nominal;
                                } else if($awal->pos_akun == "debet"){
                                  $db = $db + $awal->nominal;
                                }
                              }
                              // $ttl_awal = 0;
                              if($modal->pos == "Kredit"){
                                $ttl_awal = $ttl_awal + $modal->nominal + $kr - $db;
                              } else if($modal->pos == "Debet"){
                                $ttl_awal = $ttl_awal + $modal->nominal + $db - $kr;
                              }

                              ?>
                              <!-- <tr>
                              <td><?php echo $modal->nominal?></td>
                              </tr> -->
                              <!-- <td><?php echo $db?></td> -->
                              <?php 
                              // $kr_jrl = 0; $db_jrl = 0; $kr_jrl1 = 0; $db_jrl1 = 0;
                              foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($modal->no_akun, $res->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                if($sld->pos_akun == "kredit"){
                                  $kr_jrl = $kr_jrl + $sld->nominal;
                                } else if($sld->pos_akun == "debet") {
                                  $db_jrl = $db_jrl + $sld->nominal;
                                }
                                // $ttl_sld = $ttl_sld + $sld->nominal;
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                              }
                              foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($modal->no_akun, $res->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                if($sld1->pos_akun == "kredit"){
                                  $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                } else if($sld1->pos_akun == "debet") {
                                  $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                }
                                // $ttl_sld = $ttl_sld + $sld->nominal;
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                              }
                              // $ttl_awal = 0;
                              if($modal->pos == "Kredit"){ 
                                // $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1;
                                $ttl_awal = $ttl_awal + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1);
                              } else if($modal->pos == "Debet") {
                                // $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1;
                                $ttl_awal = $ttl_awal + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1);
                              }
                              // $ttl_awal = $ttl_awal + $ttl_sld;
                            }
                          }?>
                          <!-- <td><?php echo $ttl_awal?></td> -->
                          <?php
                          foreach($this->Dashboard_model->perubahan_modal($modal->no_akun, $res->kode_perumahan, $tglmin, $tglmax)->result() as $prb_mdl){
                            if($prb_mdl->pos_akun == "kredit"){
                              $krA = $krA + $prb_mdl->nominal;
                            } else if($prb_mdl->pos_akun == "debet"){
                              $dbA = $dbA + $prb_mdl->nominal;
                            }
                          }
                          $ttl_mdl_awal = 0;
                          if($modal->pos == "Kredit"){
                            $ttl_mdl_awal = $ttl_mdl_awal + $krA - $dbA;
                          } else if($modal->pos == "Debet"){
                            $ttl_mdl_awal = $ttl_mdl_awal + $dbA - $krA;
                          }?>
                          <!-- <td>
                            <?php echo "Rp. ".number_format($ttl_mdl_awal);?>
                          </td> -->
                          
                          <!-- <td><?php echo $ttl_sld?></td> -->
                          <?php 
                          
                          ?>

                          <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                            if($jrnl->pos_akun == "kredit"){
                              $kr2 = $kr2 + $jrnl->nominal;
                            } else if($jrnl->pos_akun == "debet") {
                              $db2 = $db2 + $jrnl->nominal;
                            }
                          }
                          $total_jr = 0;
                          if($modal->pos == "Kredit"){ 
                            $total_jr = $total_jr + $kr2 - $db2;
                          } else if($modal->pos == "Debet") {
                            $total_jr = $total_jr + $db2 - $kr2;
                          }?>
                          <!-- <td><?php echo "Rp. ".number_format($total_jr);?></td> -->
                          
                          <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                            if($jrnl->pos_akun == "kredit"){
                              $kr1 = $kr1 + $jrnl->nominal;
                            } else if($jrnl->pos_akun == "debet") {
                              $db1 = $db1 + $jrnl->nominal;
                            }
                          }
                          $total_jr2 = 0;
                          if($modal->pos == "Kredit"){ 
                            $total_jr2 = $total_jr2 + $kr1 - $db1;
                          } else if($modal->pos == "Debet") {
                            $total_jr2 = $total_jr2 + $db1 - $kr1;
                          }
                          
                          // $ttl_a = 0; $ttl_jln = 0; $jrnl_koreksi = 0; $jrnl_penyesuaian = 0; $ttl_akhir = 0;

                          // $ttl_a = $ttl_a + $ttl_awal;
                          // $ttl_jln = $ttl_jln + $ttl_mdl_awal;
                          // array_push($array_a, $ttl_awal);
                          ?>

                          <!-- <td><?php echo "Rp. ".number_format($ttl_awal);?></td>
                          <td>
                            <?php echo "Rp. ".number_format($ttl_mdl_awal);?>
                          </td>
                          <td><?php echo "Rp. ".number_format($total_jr);?></td>
                          <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                          <td><?php echo "Rp. ".number_format($ttl_awal + $ttl_mdl_awal + $total_jr + $total_jr2);?></td>
                        </tr> -->
                          <!-- <td>
                            <?php echo "Rp. ".number_format($ttl_awal);?>
                          </td> -->
                        <?php }?>
                    <?php }?>
                      <tr style="background-color: lightblue">
                        <td><?php echo $modal->no_akun?></td>
                        <td><?php echo $modal->nama_akun?></td>
                        <td>AWAL</td>
                        <td><?php echo $modal->pos?></td>
                        <td>
                          <?php echo "Rp. ".number_format($ttl_awal);?>
                        </td>
                        <td>
                          <?php echo "Rp. ".number_format($ttl_mdl_awal);?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td><?php echo "Rp. ".number_format($ttl_awal + $ttl_mdl_awal + $total_jr + $total_jr2);?></td>
                      </tr>
                    <?php $ttl1 = $ttl1 + $ttl_awal + $ttl_mdl_awal + $total_jr + $total_jr2;}} ?>

                    <?php $ttl2=0;
                    foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"1"))->result() as $induk2){?>
                        <?php 
                        foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$induk2->id_induk))->result() as $anak2){
                        $kr2=0; $db2=0; $dbA = 0; $krA = 0; $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $db2=0; $kr2=0; $ttl_awal1 = 0; $db=0; $kr=0;  $kr_jrl=0; $db_jrl=0; $ttl_sld=0; $kr_jrl1 = 0; $db_jrl1 = 0; $ttl_mdl_awal = 0; $db=0; $kr=0;
                        foreach($qus->result() as $res1){
                        foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak2->no_akun, 'kode_perumahan'=>$res1->kode_perumahan))->result() as $modal1){?>
                        
                          <?php 
                          //$ttl_awal1 = 0; $db=0; $kr=0; $kr_jrl1 = 0; $db_jrl1 = 0; $kr_jrl=0; $db_jrl=0;
                          if($tglmin == ""){
                            $ttl_awal1 = $ttl_awal1 + $modal1->nominal;                              
                          } else {
                            if($tglmin != ""){
                              $kr = 0; $db = 0;
                              foreach($this->Dashboard_model->laba_rugi_saldo_awal($modal1->no_akun, $res1->kode_perumahan, $tglmin)->result() as $awal1){
                                if($awal1->pos_akun == "kredit"){
                                  $kr = $kr + $awal1->nominal;
                                } else if($awal1->pos_akun == "debet"){
                                  $db = $db + $awal1->nominal;
                                }
                              }
                              // $ttl_awal1 = 0;
                              if($modal1->pos == "Kredit"){
                                $ttl_awal1 = $modal1->nominal + $ttl_awal1 + $kr - $db;
                              } else if($modal1->pos == "Debet"){
                                $ttl_awal1 = $modal1->nominal + $ttl_awal1 + $db - $kr;
                              }

                              foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal1->no_akun, $res1->kode_perumahan, "", $tglmin, "koreksi")->result() as $sld){
                                if($sld->pos_akun == "kredit"){
                                  $kr_jrl = $kr_jrl + $sld->nominal;
                                } else if($sld->pos_akun == "debet") {
                                  $db_jrl = $db_jrl + $sld->nominal;
                                }
                                // $ttl_sld = $ttl_sld + $sld->nominal;
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                              }
                              foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal1->no_akun, $res1->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $sld1){
                                if($sld1->pos_akun == "kredit"){
                                  $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                } else if($sld1->pos_akun == "debet") {
                                  $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                }
                                // $ttl_sld = $ttl_sld + $sld->nominal;
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                              }
                              
                              if($modal1->pos == "Kredit"){ 
                                $ttl_awal1 = $ttl_awal1 + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1);
                              } else if($modal1->pos == "Debet") {
                                $ttl_awal1 = $ttl_awal1 + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1);
                              }
                            }
                          }?>
                          <?php
                          foreach($this->Dashboard_model->perubahan_modal($modal1->no_akun, $res1->kode_perumahan, $tglmin, $tglmax)->result() as $prb_mdl1){
                            if($prb_mdl1->pos_akun == "kredit"){
                              $krA = $krA + $prb_mdl1->nominal;
                            } else if($prb_mdl1->pos_akun == "debet"){
                              $dbA = $dbA + $prb_mdl1->nominal;
                            }
                          } 
                          $ttl_mdl_awal1 = 0;
                          if($modal1->pos == "Kredit"){
                            $ttl_mdl_awal1 = $ttl_mdl_awal1 + $krA - $dbA;
                          } else if($modal1->pos == "Debet"){
                            $ttl_mdl_awal1 = $ttl_mdl_awal1 + $dbA - $krA;
                          }?>

                          <?php 
                          // $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0;
                          // if($tglmin != ""){
                            ?>
                            <?php 
                            
                          // }
                          ?> 
                          <!-- <td><?php echo $ttl_sld?></td> -->

                          <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal1->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                            if($jrnl->pos_akun == "kredit"){
                              $kr2 = $kr2 + $jrnl->nominal;
                            } else if($jrnl->pos_akun == "debet") {
                              $db2 = $db2 + $jrnl->nominal;
                            }
                          }
                          if($modal1->pos == "Kredit"){ 
                            $total_jr = $total_jr + $kr2 - $db2;
                          } else if($modal1->pos == "Debet") {
                            $total_jr = $total_jr + $db2 - $kr2;
                          }?>
                          <!-- <td><?php echo "Rp. ".number_format($total_jr);?></td> -->
                          
                          <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal1->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                            if($jrnl->pos_akun == "kredit"){
                              $kr1 = $kr1 + $jrnl->nominal;
                            } else if($jrnl->pos_akun == "debet") {
                              $db1 = $db1 + $jrnl->nominal;
                            }
                          }
                          if($modal1->pos == "Kredit"){ 
                            $total_jr2 = $total_jr2 + $kr1 - $db1;
                          } else if($modal1->pos == "Debet") {
                            $total_jr2 = $total_jr2 + $db1 - $kr1;
                          }?>
                      <?php }?>
                    <?php }?>
                        <tr style="background-color: lightblue">
                          <td><?php echo $modal1->no_akun?></td>
                          <td><?php echo $modal1->nama_akun?></td>
                          <td>AWAL</td>
                          <td><?php echo $modal1->pos?></td>
                          <td>
                            <?php echo "Rp. ".number_format($ttl_awal1);?>
                          </td>
                          <td>
                            <?php echo "Rp. ".number_format($ttl_mdl_awal1);?>
                          </td>
                          <td><?php echo "Rp. ".number_format($total_jr);?></td>
                          <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                          <td><?php echo "Rp. ".number_format($ttl_awal1 + $ttl_mdl_awal1 + ($ttl_sld + $total_jr + $total_jr2));?></td>
                        </tr>
                  
                    <?php $ttl2 = $ttl2 + $ttl_awal1 + $ttl_mdl_awal1 + ($ttl_sld + $total_jr + $total_jr2); }}?>

                    <tr style="background-color: pink; font-size: 16px; font-weight: bold">
                        <td colspan=8>PASSIVA</td>
                        <td><div id="totalPassiva"></div></td>
                    </tr>
                    
                    <?php $ttl3 = 0; $ttl4=0; 
                    foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"21000"))->result() as $induk3){?>
                      <?php 
                      foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$induk3->id_induk))->result() as $anak3){
                      $ttl_awal2 = 0; $krA = 0; $dbA = 0; $krB = 0; $dbB = 0; $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $db2=0; $kr2=0; $ttl_awal1 = 0; $db=0; $kr=0;  $kr_jrl=0; $db_jrl=0; $ttl_sld=0; $kr_jrl1 = 0; $db_jrl1 = 0; $ttl_mdl_awal = 0; $db=0; $kr=0;
                      foreach($qus->result() as $res2){
                      foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak3->no_akun, 'kode_perumahan'=>$res2->kode_perumahan))->result() as $psv1){?>
                        <?php 
                        // foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('id_induk'=>$induk3->id_induk, 'kode_perumahan'=>$kode_perumahan))->result() as $psv1){?>
                            <?php 
                            // $ttl_awal2 = 0; $db=0; $kr=0; $kr_jrl1 = 0; $db_jrl1 = 0; $kr_jrl=0; $db_jrl=0;
                            if($tglmin == ""){
                              $ttl_awal2 = $ttl_awal2 + $psv1->nominal;
                            } else {
                              if($tglmin != ""){
                                $kr=0; $db = 0;
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal($psv1->no_akun, $res2->kode_perumahan, $tglmin)->result() as $awal2){
                                  if($awal2->pos_akun == "kredit"){
                                    $kr = $kr + $awal2->nominal;
                                  } else if($awal2->pos_akun == "debet"){
                                    $db = $db + $awal2->nominal;
                                  }
                                }
                                $ttl_awal2 = 0;
                                if($psv1->pos == "Kredit"){
                                  $ttl_awal2 = $psv1->nominal + $ttl_awal2 + $kr - $db;
                                } else if($psv1->pos == "Debet"){
                                  $ttl_awal2 = $psv1->nominal + $ttl_awal2 + $db - $kr;
                                }

                                foreach($this->Dashboard_model->laba_rugi_pos_jurnal($psv1->no_akun, $res2->kode_perumahan, "", $tglmin, "koreksi")->result() as $sld){
                                  if($sld->pos_akun == "kredit"){
                                    $kr_jrl = $kr_jrl + $sld->nominal;
                                  } else if($sld->pos_akun == "debet") {
                                    $db_jrl = $db_jrl + $sld->nominal;
                                  }
                                  // $ttl_sld = $ttl_sld + $sld->nominal;
                                  // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                foreach($this->Dashboard_model->laba_rugi_pos_jurnal($psv1->no_akun, $res2->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $sld1){
                                  if($sld1->pos_akun == "kredit"){
                                    $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                  } else if($sld1->pos_akun == "debet") {
                                    $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                  }
                                  // $ttl_sld = $ttl_sld + $sld->nominal;
                                  // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                
                                if($psv1->pos == "Kredit"){ 
                                  $ttl_awal2 = $ttl_awal2 + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1);
                                } else if($psv1->pos == "Debet") {
                                  $ttl_awal2 = $ttl_awal2 + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1);
                                }
                              }
                            }?>
                            
                            <?php 
                            // $ttl_mdl_awal2 = 0; $kr=0; $db=0;
                            foreach($this->Dashboard_model->perubahan_modal($psv1->no_akun, $res2->kode_perumahan, $tglmin, $tglmax)->result() as $prb_mdl2){
                              if($prb_mdl2->pos_akun == "kredit"){
                                $krA = $krA + $prb_mdl2->nominal;
                              } else if($prb_mdl2->pos_akun == "debet"){
                                $dbA = $dbA + $prb_mdl2->nominal;
                              }
                            }
                            $ttl_mdl_awal2=0;
                            if($psv1->pos == "Kredit"){
                              $ttl_mdl_awal2 = $ttl_mdl_awal2 + $krA - $dbA;
                            } else if($psv1->pos == "Debet"){
                              $ttl_mdl_awal2 = $ttl_mdl_awal2 + $dbA - $krA;
                            }?>

                            <?php 
                            $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0;
                          // if($tglmin != ""){
                            ?>
                            <?php 
                            
                            // }
                            ?> 
                            <!-- <td><?php echo $ttl_sld?></td> -->

                            <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($psv1->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                              if($jrnl->pos_akun == "kredit"){
                                $kr2 = $kr2 + $jrnl->nominal;
                              } else if($jrnl->pos_akun == "debet") {
                                $db2 = $db2 + $jrnl->nominal;
                              }
                            }
                            $total_jr = 0;
                            if($psv1->pos == "Kredit"){ 
                              $total_jr = $total_jr + $kr2 - $db2;
                            } else if($psv1->pos == "Debet") {
                              $total_jr = $total_jr + $db2 - $kr2;
                            }?>
                            <!-- <td><?php echo "Rp. ".number_format($total_jr);?></td> -->
                            
                            <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($psv1->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                              if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                              } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                              }
                            }
                            $total_jr2 = 0;
                            if($psv1->pos == "Kredit"){ 
                              $total_jr2 = $total_jr2 + $kr1 - $db1;
                            } else if($psv1->pos == "Debet") {
                              $total_jr2 = $total_jr2 + $db1 - $kr1;
                            }?>

                        <?php }?>
                    <?php }?>
                      <tr style="background-color: pink">
                        <td><?php echo $psv1->no_akun?></td>
                        <td><?php echo $psv1->nama_akun?></td>
                        <td>AWAL</td>
                        <td><?php echo $psv1->pos?></td>
                        <td>
                          <?php echo "Rp. ".number_format($ttl_awal2);?>
                        </td>
                        <td>
                          <?php echo "Rp. ".number_format($ttl_mdl_awal2);?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td><?php echo "Rp. ".number_format($ttl_awal2 + $ttl_mdl_awal2 + ($ttl_sld + $total_jr + $total_jr2));?></td>
                      </tr>
                    <?php $ttl3 = $ttl3 + $ttl_awal2 + $ttl_mdl_awal2 + ($ttl_sld + $total_jr + $total_jr2);}}?>
                    
                    <?php 
                    $qus = $this->db->get_where('perumahan', array('kode_perusahaan'=>$id));
                    $p1=0; $p6=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"41000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $total=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0; $db3=0; $kr2=0; $kr3=0;
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res->kode_perumahan, $tglmin)->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_sld = $kr_sld + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_sld = $db_sld + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        $ttl_sld = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                        }

                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_jrl = $kr_jrl + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_jrl = $db_jrl + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                        if($sld1->pos_akun == "kredit"){
                                            $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                        } else if($sld1->pos_akun == "debet") {
                                            $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                        if($sld2->pos_akun == "debet"){
                                            $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                        } else if($sld2->pos_akun == "kredit") {
                                            $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                        }
                                    
                                  }
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                


                                <?php
                                // print_r($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                                

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                            <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                            ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p1 = $p1 + $ttl_sld;
                            $p6 = $p6 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PENDAPATAN</td>
                      <td><?php echo "Rp. ".number_format($p1);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6);?></td>
                    </tr> -->

                    <?php $p2=0; $p7=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"61000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                                <td><?php echo $anak->no_akun?></td>
                                <td><?php echo $anak->nama_akun?></td>
                                <td><?php echo $anak->pos?></td> -->
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if($qus->num_rows() > 0){
                                foreach($qus->result() as $res1){
                                    $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res1->kode_perumahan));
                                    if($ts->num_rows() > 0){
                                    foreach($ts->result() as $akun){?>
                                        <?php
                                        if(isset($tgl_awal)){
                                        $ttl_sld = $akun->nominal;
                                        } else {
                                        if($tglmin != ""){
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res1->kode_perumahan, $tglmin)->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_sld = $kr_sld + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_sld = $db_sld + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            $ttl_sld = 0;
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                            }

                                            
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_jrl = $kr_jrl + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_jrl = $db_jrl + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                            if($sld1->pos_akun == "kredit"){
                                                $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                            } else if($sld1->pos_akun == "debet") {
                                                $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                            if($sld2->pos_akun == "debet"){
                                                $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                            } else if($sld2->pos_akun == "kredit") {
                                                $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                            }
                                        }
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res1->kode_perumahan, "", $tglmin)->result() as $pos){
                                          if($pos->pos_akun == "kredit"){
                                              $kr = $kr + $pos->nominal;
                                          } else if($pos->pos_akun == "debet") {
                                              $db = $db + $pos->nominal;
                                          }
                                        }
                                        $total = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $total = $total + $kr - $db;
                                        } else if($akun->pos == "Debet") {
                                        $total = $total + $db - $kr;
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr1 = $kr1 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db1 = $db1 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr = $total_jr + $kr1 - $db1;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr = $total_jr + $db1 - $kr1;
                                        }?>
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr2 = $kr2 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db2 = $db2 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr2=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr2 = $total_jr2 + $kr2 - $db2;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr2 = $total_jr2 + $db2 - $kr2;
                                        }?>
                                        
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr3 = $kr3 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db3 = $db3 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr1=0;
                                        
                                        if($akun->pos == "Debet"){ 
                                        $total_jr1 = $total_jr1 + $kr3;
                                        } else if($akun->pos == "Kredit") {
                                        $total_jr1 = $total_jr1 + $db3;
                                        }?>

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p2 = $p2 + $ttl_sld;
                            $p7 = $p7 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PEMBELIAN</td>
                      <td><?php echo "Rp. ".number_format($p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p7);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA KOTOR</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7);?></td>
                    </tr> -->

                    <?php $p3=0; $p8=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"52000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                              <td><?php echo $anak->no_akun?></td>
                              <td><?php echo $anak->nama_akun?></td>
                              <td><?php echo $anak->pos?></td> -->
                              <?php $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $total_jr1=0; $db1=0; $kr1=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2 = 0; $kr2=0; $db3=0; $kr3=0;
                              if($qus->num_rows() > 0){
                              foreach($qus->result() as $res2){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res2->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res2->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res2->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                // echo $db;
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p3 = $p3 + $ttl_sld;
                            $p8 = $p8 + $ttl_sld+$total+$total_jr+$total_jr2+$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr-$total_jr1+$total_jr2);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA KONSTRUKSI DAN FINISHING</td>
                      <td><?php echo "Rp. ".number_format($p3);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8);?></td> 
                    </tr> -->

                    <?php $p4=0; $p9=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"51000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res3){
                            if($ts->num_rows() > 0){ 
                            foreach($ts->result() as $akun){?>
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res3->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld=0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res3->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, "", $tglmin, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                        <?php }} else {
                        }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>

                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p4 = $p4 + $ttl_sld;
                            $p9 = $p9 + $ttl_sld+$total+$total_jr+$total_jr2+$total_jr1;
                          echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>  -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA OVERHEAD PERUSAHAAN</td>
                      <td><?php echo "Rp. ".number_format($p4);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p9);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight: bold; background-color: lightblue; ">
                      <td colspan=7 style="font-size: 16px">BIAYA BIAYA</td>
                      <td><?php echo "Rp. ".number_format($p3+$p4);?></td> 
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8+$p9);?></td>
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA SEBELUM PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4));?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9));?></td>
                    </tr> -->

                    <?php $p5=0; $p10=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"53000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res4){
                            if($ts->num_rows() > 0){
                            foreach($ts->result() as $akun){?>
                                <?php $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0;$kr2=0;$db3=0;$kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res4->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res4->kode_perumahan, "", $tglmin)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total=0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, "", $tglmin ,"koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, "", $tglmin, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1=0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?> 
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                        <td><?php 
                        $p5 = $p5 + $ttl_sld;
                        $p10 = $p10 + $ttl_sld+$total+$total_jr+$total_jr1+$total_jr2;
                        echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>   -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>
                    
                    <?php
                    $ttl_prive = 0; $kr=0; $db=0; 
                    if($tglmin != ""){?>
                    <?php 
                    foreach($qus->result() as $rep){
                        foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31003", 'kode_perumahan'=>$rep->kode_perumahan))->result() as $prive1){?>
                      <!-- <tr style="background-color: pink">
                        <td><?php echo $prive->no_akun?></td>
                        <td colspan=2><?php echo $prive->nama_akun?></td>
                        <td><?php echo $prive->pos?></td> -->
                        <?php
                        foreach($this->Dashboard_model->perubahan_modal($prive1->no_akun, $rep->kode_perumahan, "", $tglmin)->result() as $prb_prv){
                          if($prb_prv->pos_akun == "kredit"){
                            $kr = $kr + $prb_prv->nominal;
                          } else if($prb_prv->pos_akun == "debet"){
                            $db = $db + $prb_prv->nominal;
                          }
                        }
                        $ttl_prive = 0;
                        if($prive1->pos == "Kredit"){
                          $ttl_prive = $ttl_prive + $kr - $db;
                        } else if($prive1->pos == "Debet"){
                          $ttl_prive = $ttl_prive + $db - $kr;
                        }?>
                        <!-- <td>
                          <?php echo "Rp. ".number_format($ttl_prive);?>
                        </td>
                      </tr> -->
                    <?php }}}?>
                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=7>TOTAL BIAYA PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p5);?></td> 
                      <td><?php echo "Rp. ".number_format($p10);?></td>
                    </tr>

                    <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=8 style=" font-size: 16px">LABA / RUGI BERSIH SETELAH PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4)-$p5);?></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9)-$p10);?></td>
                    </tr> -->
                    <!-- <td><?php echo number_format($p4)?></td> -->

                    <?php 
                    $ttl_mdl_awal = 0; $ttl_mdl_test=0; $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_jrl1 = 0; $db_jrl1 = 0; $kr_jrl=0; $db_jrl=0;
                    foreach($qus->result() as $rep_mdl){
                    foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31001", 'kode_perumahan'=>$rep_mdl->kode_perumahan))->result() as $modal){?>
                        
                        <?php 
                        
                        if($tglmin != ""){
                          ?>
                          <?php 
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, "", $tglmin, "koreksi")->result() as $sld){
                            if($sld->pos_akun == "kredit"){
                              $kr_jrl = $kr_jrl + $sld->nominal;
                            } else if($sld->pos_akun == "debet") {
                              $db_jrl = $db_jrl + $sld->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $sld1){
                            if($sld1->pos_akun == "kredit"){
                              $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                            } else if($sld1->pos_akun == "debet") {
                              $db_jrl1 = $db_jrl1 + $sld1->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          $ttl_sld = 0;
                          if($modal->pos == "Kredit"){ 
                            $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1);
                          } else if($modal->pos == "Debet") {
                            $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1);
                          }
                        }
                        ?> 
                        <!-- <td><?php echo $ttl_sld?></td> -->

                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr = $kr + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db = $db + $jrnl->nominal;
                          }
                        }
                        $total_jr=0;
                        if($modal->pos == "Kredit"){ 
                          $total_jr = $total_jr + $kr - $db;
                        } else if($modal->pos == "Debet") {
                          $total_jr = $total_jr + $db - $kr;
                        }?>
                        <!-- <td><?php echo "Rp. ".number_format($total_jr);?></td> -->
                        
                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($modal->no_akun, $rep_mdl->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr1 = $kr1 + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db1 = $db1 + $jrnl->nominal;
                          }
                        }
                        if($modal->pos == "Kredit"){ 
                          $total_jr2 = $total_jr2 + $kr1 - $db1;
                        } else if($modal->pos == "Debet") {
                          $total_jr2 = $total_jr2 + $db1 - $kr1;
                        }?>
                          <!-- <td><?php echo "Rp. ".number_format($total_jr2);?></td> -->

                        <?php  $kr=0; $db=0;
                        foreach($this->Dashboard_model->perubahan_modal($modal->no_akun, $rep_mdl->kode_perumahan, $tglmin, $tglmax)->result() as $prb_mdl){
                          if($prb_mdl->pos_akun == "kredit"){
                            $kr = $kr + $prb_mdl->nominal;
                          } else if($prb_mdl->pos_akun == "debet"){
                            $db = $db + $prb_mdl->nominal;
                          }
                        }
                        if($modal->pos == "Kredit"){
                          $ttl_mdl_awal = $ttl_mdl_awal + $kr - $db;
                        } else if($modal->pos == "Debet"){
                          $ttl_mdl_awal = $ttl_mdl_awal + $db - $kr;
                        }?>

                        <?php
                        // $ttl_mdl_awal = $ttl_mdl_awal+(($p1-$p2-($p3+$p4)-$p5)-$ttl_prive)+$modal->nominal + ($ttl_sld + $total_jr1 + $total_jr2);
                        $ttl_mdl_test = $ttl_mdl_test + $modal->nominal + ($ttl_sld + $total_jr1 + $total_jr2);
                        ?>
                    <?php }}
                        $ttl_mdl_test = $ttl_mdl_test + (($p1-$p2-($p3+$p4)-$p5)-$ttl_prive);
                    ?>
                    <!-- <tr style="background-color: lightblue">
                        <td><?php echo $modal->no_akun?></td>
                        <td><?php echo $modal->nama_akun?></td>
                        <td>AWAL</td>
                        <td><?php echo $modal->pos?></td>

                        <td>
                        <td><?php echo number_format($p1)?></td>  
                        <?php echo "Rp. ".number_format($ttl_mdl_test);?>
                        </td>
                    </tr> -->
                    
                    <?php 
                    $total_jr=0; $db=0; $kr=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_jrl1 = 0; $db_jrl1 = 0; $kr_jrl=0; $db_jrl=0; $ttl_prive = 0; $kr=0; $db=0;
                    foreach($qus->result() as $rep_prv){
                    foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31003", 'kode_perumahan'=>$rep_prv->kode_perumahan))->result() as $prive){?>

                        <?php 
                        
                        if($tglmin != ""){
                          ?>
                          <?php 
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, "", $tglmin, "koreksi")->result() as $sld){
                            if($sld->pos_akun == "kredit"){
                              $kr_jrl = $kr_jrl + $sld->nominal;
                            } else if($sld->pos_akun == "debet") {
                              $db_jrl = $db_jrl + $sld->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, "", $tglmin, "penyesuaian")->result() as $sld1){
                            if($sld1->pos_akun == "kredit"){
                              $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                            } else if($sld1->pos_akun == "debet") {
                              $db_jrl1 = $db_jrl1 + $sld1->nominal;
                            }
                            // $ttl_sld = $ttl_sld + $sld->nominal;
                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                          }
                          
                          if($prive->pos == "Kredit"){ 
                            $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1;
                          } else if($prive->pos == "Debet") {
                            $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1;
                          }
                        }
                        ?> 
                        <!-- <td><?php echo $ttl_sld?></td> -->

                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr = $kr + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db = $db + $jrnl->nominal;
                          }
                        }
                        if($prive->pos == "Kredit"){ 
                          $total_jr = $total_jr + $kr - $db;
                        } else if($prive->pos == "Debet") {
                          $total_jr = $total_jr + $db - $kr;
                        }?>
                        <!-- <td><?php echo "Rp. ".number_format($total_jr);?></td> -->
                        
                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($prive->no_akun, $rep_prv->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                          if($jrnl->pos_akun == "kredit"){
                            $kr1 = $kr1 + $jrnl->nominal;
                          } else if($jrnl->pos_akun == "debet") {
                            $db1 = $db1 + $jrnl->nominal;
                          }
                        }
                        if($prive->pos == "Kredit"){ 
                          $total_jr2 = $total_jr2 + $kr1 - $db1;
                        } else if($prive->pos == "Debet") {
                          $total_jr2 = $total_jr2 + $db1 - $kr1;
                        }?>

                        <?php
                        foreach($this->Dashboard_model->perubahan_modal($prive->no_akun, $rep_prv->kode_perumahan, $tglmin, $tglmax)->result() as $prb_prv){
                          if($prb_prv->pos_akun == "kredit"){
                            $kr = $kr + $prb_prv->nominal;
                          } else if($prb_prv->pos_akun == "debet"){
                            $db = $db + $prb_prv->nominal;
                          }
                        }
                        $ttl_prive= 0;
                        if($prive->pos == "Kredit"){
                          $ttl_prive = $ttl_prive + $kr - $db;
                        } else if($prive->pos == "Debet"){
                          $ttl_prive = $ttl_prive + $db - $kr;
                        }
                        
                        $ttl_prive = $ttl_prive + $prive->nominal + ($ttl_sld + $total_jr1 + $total_jr2);
                        ?>
                    <?php }}?>
                      <!-- <tr style="background-color: pink">
                        <td><?php echo $prive->no_akun?></td>
                        <td colspan=2><?php echo $prive->nama_akun?></td>
                        <td><?php echo $prive->pos?></td>
                        <td>
                          <?php echo "Rp. ".number_format($ttl_prive);?>
                        </td>
                      </tr> -->

                    
                      <?php 
                    $qus = $this->db->get_where('perumahan', array('kode_perusahaan'=>$id));
                    $p1=0; $p6=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"41000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $total=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0; $db3=0; $kr2=0; $kr3=0;
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res->kode_perumahan, $tglmin)->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_sld = $kr_sld + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_sld = $db_sld + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        $ttl_sld = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                        }

                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                            $kr_jrl = $kr_jrl + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                            $db_jrl = $db_jrl + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                        if($sld1->pos_akun == "kredit"){
                                            $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                        } else if($sld1->pos_akun == "debet") {
                                            $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                        foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                        if($sld2->pos_akun == "debet"){
                                            $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                        } else if($sld2->pos_akun == "kredit") {
                                            $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                        }
                                        if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                        } else if($akun->pos == "Debet") {
                                        $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                        }
                                    
                                  }
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                


                                <?php
                                // print_r($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                                

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                            <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                            ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p1 = $p1 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p6 = $p6 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PENDAPATAN</td>
                      <td><?php echo "Rp. ".number_format($p1);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6);?></td>
                    </tr> -->

                    <?php $p2=0; $p7=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"61000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                                <td><?php echo $anak->no_akun?></td>
                                <td><?php echo $anak->nama_akun?></td>
                                <td><?php echo $anak->pos?></td> -->
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if($qus->num_rows() > 0){
                                foreach($qus->result() as $res1){
                                    $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res1->kode_perumahan));
                                    if($ts->num_rows() > 0){
                                    foreach($ts->result() as $akun){?>
                                        <?php
                                        if(isset($tgl_awal)){
                                        $ttl_sld = $akun->nominal;
                                        } else {
                                        if($tglmin != ""){
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res1->kode_perumahan, $tglmin)->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_sld = $kr_sld + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_sld = $db_sld + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            $ttl_sld = 0;
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                            }

                                            
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                            if($sld->pos_akun == "kredit"){
                                                $kr_jrl = $kr_jrl + $sld->nominal;
                                            } else if($sld->pos_akun == "debet") {
                                                $db_jrl = $db_jrl + $sld->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                            if($sld1->pos_akun == "kredit"){
                                                $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                            } else if($sld1->pos_akun == "debet") {
                                                $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                            foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                            if($sld2->pos_akun == "debet"){
                                                $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                            } else if($sld2->pos_akun == "kredit") {
                                                $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                            }
                                            // $ttl_sld = $ttl_sld + $sld->nominal;
                                            // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                            }
                                            if($akun->pos == "Kredit"){ 
                                            $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                            } else if($akun->pos == "Debet") {
                                            $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                            }
                                        }
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                          if($pos->pos_akun == "kredit"){
                                              $kr = $kr + $pos->nominal;
                                          } else if($pos->pos_akun == "debet") {
                                              $db = $db + $pos->nominal;
                                          }
                                        }
                                        $total = 0;
                                        if($akun->pos == "Kredit"){ 
                                        $total = $total + $kr - $db;
                                        } else if($akun->pos == "Debet") {
                                        $total = $total + $db - $kr;
                                        }?>
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr1 = $kr1 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db1 = $db1 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr = $total_jr + $kr1 - $db1;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr = $total_jr + $db1 - $kr1;
                                        }?>
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr2 = $kr2 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db2 = $db2 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr2=0;
                                        if($akun->pos == "Kredit"){ 
                                        $total_jr2 = $total_jr2 + $kr2 - $db2;
                                        } else if($akun->pos == "Debet") {
                                        $total_jr2 = $total_jr2 + $db2 - $kr2;
                                        }?>
                                        
                                        
                                        <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res1->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                          if($jrnl->pos_akun == "kredit"){
                                              $kr3 = $kr3 + $jrnl->nominal;
                                          } else if($jrnl->pos_akun == "debet") {
                                              $db3 = $db3 + $jrnl->nominal;
                                          }
                                        }
                                        $total_jr1=0;
                                        
                                        if($akun->pos == "Debet"){ 
                                        $total_jr1 = $total_jr1 + $kr3;
                                        } else if($akun->pos == "Kredit") {
                                        $total_jr1 = $total_jr1 + $db3;
                                        }?>

                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p2 = $p2 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p7 = $p7 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                        </tr> -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL PEMBELIAN</td>
                      <td><?php echo "Rp. ".number_format($p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p7);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA KOTOR</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7);?></td>
                    </tr> -->

                    <?php $p3=0; $p8=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"52000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                            <!-- <tr>
                              <td><?php echo $anak->no_akun?></td>
                              <td><?php echo $anak->nama_akun?></td>
                              <td><?php echo $anak->pos?></td> -->
                              <?php $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $total_jr1=0; $db1=0; $kr1=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2 = 0; $kr2=0; $db3=0; $kr3=0;
                              if($qus->num_rows() > 0){
                              foreach($qus->result() as $res2){
                              $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$res2->kode_perumahan));
                              if($ts->num_rows() > 0){
                              foreach($ts->result() as $akun){?>
                                <?php
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res2->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                // echo $db;
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0; 
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res2->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                        <td>
                        <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                        ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                            $p3 = $p3 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p8 = $p8 + $ttl_sld+$total+$total_jr+$total_jr2+$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr-$total_jr1+$total_jr2);?>
                        </td>

                        </tr> -->
                    <?php } else {
                            // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            
                            // </tr>";
                        }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA KONSTRUKSI DAN FINISHING</td>
                      <td><?php echo "Rp. ".number_format($p3);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8);?></td> 
                    </tr> -->

                    <?php $p4=0; $p9=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"51000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res3){
                            if($ts->num_rows() > 0){ 
                            foreach($ts->result() as $akun){?>
                                <?php $total_jr1=0; $db1=0; $kr1=0; $total_jr2=0; $db1=0; $kr1=0; $total_jr=0; $db1=0; $kr1=0; $total=0; $db=0; $kr=0; $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db2=0; $kr2=0; $db3=0; $kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res3->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld=0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2 = 0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res3->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1 = 0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                        <?php }} else {
                        }?>
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>

                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                        <td><?php 
                          $p4 = $p4 + $ttl_sld+$total+$total_jr+$total_jr2;
                          $p9 = $p9 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                          echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>  -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=6>TOTAL BIAYA OVERHEAD PERUSAHAAN</td>
                      <td><?php echo "Rp. ".number_format($p4);?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p9);?></td> 
                    </tr> -->

                    <!-- <tr style="font-weight: bold; background-color: lightblue; ">
                      <td colspan=7 style="font-size: 16px">BIAYA BIAYA</td>
                      <td><?php echo "Rp. ".number_format($p3+$p4);?></td> 
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p8+$p9);?></td>
                    </tr> -->

                    <!-- <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=7 style=" font-size: 16px">LABA SEBELUM PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4));?></td>
                      <td></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9));?></td>
                    </tr> -->

                    <?php $p5=0; $p10=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"53000"))->result() as $row){ ?>
                        <!-- <tr>
                            <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                            <td colspan=2></td>
                        </tr> -->
                        <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                          <!-- <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td> -->
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($qus->num_rows() > 0){
                            foreach($qus->result() as $res4){
                            if($ts->num_rows() > 0){
                            foreach($ts->result() as $akun){?>
                                <?php $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0; $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0; $db=0; $kr=0; $total_jr=0; $db1=0; $kr1=0; $db2=0;$kr2=0;$db3=0;$kr3=0;
                                if(isset($tgl_awal)){
                                  $ttl_sld = $akun->nominal;
                                } else {
                                  if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $res4->kode_perumahan, $tglmin)->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    $ttl_sld = 0;
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                      if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                      } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                      if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                      } else if($sld1->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                      if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                      } else if($sld2->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                      }
                                      // $ttl_sld = $ttl_sld + $sld->nominal;
                                      // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                      $ttl_sld = $ttl_sld + ($kr_jrl - $db_jrl) + ($kr_jrl1 - $db_jrl1) - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                      $ttl_sld = $ttl_sld + ($db_jrl - $kr_jrl) + ($db_jrl1 - $kr_jrl1) - $db_jrl2;
                                    }
                                  }
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                  if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                  } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                  }
                                }
                                $total=0;
                                if($akun->pos == "Kredit"){ 
                                  $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                  $total = $total + $db - $kr;
                                }?>
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                  }
                                }
                                $total_jr=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                  $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr2 = $kr2 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db2 = $db2 + $jrnl->nominal;
                                  }
                                }
                                $total_jr2=0;
                                if($akun->pos == "Kredit"){ 
                                  $total_jr2 = $total_jr2 + $kr2 - $db2;
                                } else if($akun->pos == "Debet") {
                                  $total_jr2 = $total_jr2 + $db2 - $kr2;
                                }?>
                                
                                <?php foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $res4->kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                  if($jrnl->pos_akun == "kredit"){
                                    $kr3 = $kr3 + $jrnl->nominal;
                                  } else if($jrnl->pos_akun == "debet") {
                                    $db3 = $db3 + $jrnl->nominal;
                                  }
                                }
                                $total_jr1=0;
                                if($akun->pos == "Debet"){ 
                                  $total_jr1 = $total_jr1 + $kr3;
                                } else if($akun->pos == "Kredit") {
                                  $total_jr1 = $total_jr1 + $db3;
                                }?>
                            <?php }} else {
                            }?> 
                    <?php }?>
                        <!-- <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                        <td><?php echo "Rp. ".number_format($total);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr);?></td>
                        <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                        <td>
                          <?php 
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                          ?>
                        </td>
                        <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                        <td><?php 
                        $p5 = $p5 + $ttl_sld+$total+$total_jr+$total_jr2;
                        $p10 = $p10 + $ttl_sld+$total+$total_jr+$total_jr1+$total_jr2;
                        echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                        </td>

                      </tr>   -->
                    <?php } else {
                        // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        
                        // </tr>"; 
                      }
                    }}?>

                    <!-- <tr style="font-weight: bold">
                      <td></td>
                      <td colspan=7>TOTAL BIAYA PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p5);?></td> 
                      <td><?php echo "Rp. ".number_format($p10);?></td>
                    </tr>

                    <tr style="font-weight:bold; background-color: lightyellow">
                      <td colspan=8 style=" font-size: 16px">LABA / RUGI BERSIH SETELAH PAJAK</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4)-$p5);?></td>
                      <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9)-$p10);?></td>
                    </tr> -->
                    <!-- <tr style="background-color: pink">
                      <td></td>
                      <td colspan=3>Laba/Rugi Bersih Tahun Berjalan</td>
                      <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4)-$p5);?></td>
                    </tr>
                    <tr style="background-color: pink">
                      <td style="background-color: pink" colspan=4></td>
                      <td style="background-color: pink"><?php echo "Rp. ".number_format(($p1-$p2-($p3+$p4)-$p5)-$ttl_prive);?></td>
                    </tr> -->

                    <?php 
                    // $ttl_mdl_skrg = 0;
                    foreach($qus->result() as $res_mdl){
                    foreach($this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>"31001", 'kode_perumahan'=>$res_mdl->kode_perumahan))->result() as $modal){?>
                      <!-- <tr style="background-color: lightblue">
                        <td><?php echo $modal->no_akun?></td>
                        <td><?php echo $modal->nama_akun?></td>
                        <td colspan=2>AKHIR</td>
                        <td><?php echo $modal->pos?></td>
                        <td>
                          <?php echo "Rp. ".number_format((($p1-$p2-($p3+$p4)-$p5)-$ttl_prive)+$ttl_mdl_awal);?>
                        </td>
                      </tr> -->
                    <?php }}?>
                      <tr style="background-color: pink">
                        <td><?php echo $modal->no_akun?></td>
                        <td><?php echo $modal->nama_akun?></td>
                        <td>AWAL</td>
                        <td><?php echo $modal->pos?></td>
                        <td><?php echo "Rp. ".number_format($ttl_mdl_test)?></td>
                        <td><?php echo "Rp. ".number_format($ttl_mdl_awal)?></td>
                        <td><?php echo "Rp. ".number_format($total_jr)?></td>
                        <td><?php echo "Rp. ".number_format($total_jr1)?></td>
                        <td>
                          <?php echo "Rp. ".number_format((($p1-$p2-($p3+$p4)-$p5)-$ttl_prive)+$ttl_mdl_test);?>
                        </td>
                      </tr>
                    
                    <?php $ttl4 = $ttl4 + (($p1-$p2-($p3+$p4)-$p5)-$ttl_prive)+$ttl_mdl_test; ?>
              </tbody>
            </table>
        </div>

        <!-- <p style="">
          <div>
            <span style="padding-left: 100px">Dibuat Oleh,</span>
            <span style="padding-left: 500px">Mengetahui,</span>
            <span style="padding-left: 70px">Disetujui Oleh,</span>
          </div>
          <br><br><br><br>
          <div style="">
            <u><span style="padding-left: 70px">Tiur Sri Rezeki Batubara</span></u>
            <u><span style="padding-left: 460px">Aras Yulita</span></u>
            <u><span style="padding-left: 90px">Edi Yanto</span></u>
          </div>
          <br>
          <div>
            <span style="padding-left: 85px">Admin Keuangan</span>
            <span style="padding-left: 465px">Manajer Keuangan</span>
            <span style="padding-left: 37px">Direktur Keuangan</span>
          </div>
        </p> -->
   </div>
</body></html>