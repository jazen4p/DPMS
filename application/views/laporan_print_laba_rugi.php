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
   <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/bootstrap.min.css" />
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
            <span style="font-weight: bold"><?php echo $nama_perumahan?> Residence</span><br>
            Laporan Laba Rugi <br>
            <?php if($tglmax == ""){?>
                Per. <?php echo date('t F Y')?> <br><br>
            <?php } else {?>
                Per. <?php echo date('t F Y', strtotime($tglmax))?> <br><br>
            <?php }?>

            <table id="example2" class="table table-bordered table-striped" style="font-size: 12px; width: 100%">
                <thead>
                <tr>
                    <th colspan=3></th>
                    <th>AWAL</th>
                    <th>BERJALAN</th>
                    <th>JURNAL KOREKSI</th>
                    <th>JURNAL PENYESUAIAN</th>
                    <th>SETELAH PENYESUAIAN</th>
                    <th>JURNAL PENUTUP</th>
                    <th>AKHIR</th>
                    <!-- <th>Status</th> -->
                    <!-- <th>Jmlh Diterima</th> -->
                </tr>
                </thead>
                <tbody style="white-space: nowrap">
                <?php $p1=0; $p6=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"41000"))->result() as $row){ ?>
                    <tr>
                        <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                        <!-- <td colspan=2></td> -->
                    </tr>
                    <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                        <tr>
                        <td><?php echo $anak->no_akun?></td>
                        <td><?php echo $anak->nama_akun?></td>
                        <td><?php echo $anak->pos?></td>
                        <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($ts->num_rows() > 0){
                            foreach($ts->result() as $akun){?>
                            <?php $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0;
                            if(isset($tgl_awal)){
                                $ttl_sld = $akun->nominal;
                            } else {
                                if($tglmin != ""){
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_sld = $kr_sld + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_sld = $db_sld + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                }

                                $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0;
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_jrl = $kr_jrl + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl = $db_jrl + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                    if($sld1->pos_akun == "kredit"){
                                    $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                    if($sld2->pos_akun == "debet"){
                                    $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                    } else if($sld->pos_akun == "kredit") {
                                    $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1 - $kr_jrl2;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1 - $db_jrl2;
                                }
                                }
                            }?>
                            <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                            <?php $total=0; $db=0; $kr=0; foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                $kr = $kr + $pos->nominal;
                                } else if($pos->pos_akun == "debet") {
                                $db = $db + $pos->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total = $total + $kr - $db;
                            } else if($akun->pos == "Debet") {
                                $total = $total + $db - $kr;
                            }?>
                            <td><?php echo "Rp. ".number_format($total);?></td>
                            <?php $total_jr=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr = $total_jr + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr = $total_jr + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr);?></td>
                            
                            <?php $total_jr2=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr2 = $total_jr2 + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr2 = $total_jr2 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                            <td>
                                <?php 
                                echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                                ?>
                            </td>

                            <?php
                            // print_r($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result());
                            $total_jr1=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Debet"){ 
                                $total_jr1 = $total_jr1 + $kr1 - $db1;
                            } else if($akun->pos == "Kredit") {
                                $total_jr1 = $total_jr1 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                            <td><?php 
                            $p1 = $p1 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p6 = $p6 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?>
                            </td>
                        <?php }} else {
                        echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
                        }?>
                        </tr>
                <?php }}?>

                <tr style="font-weight: bold">
                    <td></td>
                    <td colspan=6>TOTAL PENDAPATAN</td>
                    <td><?php echo "Rp. ".number_format($p1);?></td>
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p6);?></td>
                </tr>

                <?php $p2=0; $p7=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"61000"))->result() as $row){ ?>
                    <tr>
                        <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                        <!-- <td></td> -->
                    </tr>
                    <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                        <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td>
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($ts->num_rows() > 0){
                            foreach($ts->result() as $akun){?>
                                <?php $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0;
                                if(isset($tgl_awal)){
                                    $ttl_sld = $akun->nominal;
                                } else {
                                    if($tglmin != ""){
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                        $kr_sld = $kr_sld + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                        $db_sld = $db_sld + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                    } else if($akun->pos == "Debet") {
                                        $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                    }

                                    $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0;
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                        if($sld->pos_akun == "kredit"){
                                        $kr_jrl = $kr_jrl + $sld->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                        $db_jrl = $db_jrl + $sld->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                        if($sld1->pos_akun == "kredit"){
                                        $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                        } else if($sld->pos_akun == "debet") {
                                        $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                    foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                        if($sld2->pos_akun == "debet"){
                                        $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                        } else if($sld->pos_akun == "kredit") {
                                        $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                        }
                                        // $ttl_sld = $ttl_sld + $sld->nominal;
                                        // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                    }
                                    if($akun->pos == "Kredit"){ 
                                        $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1 - $kr_jrl2;
                                    } else if($akun->pos == "Debet") {
                                        $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1 - $db_jrl2;
                                    }
                                    }
                                }?>
                                <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                                <?php $total=0; $db=0; $kr=0; foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                    if($pos->pos_akun == "kredit"){
                                    $kr = $kr + $pos->nominal;
                                    } else if($pos->pos_akun == "debet") {
                                    $db = $db + $pos->nominal;
                                    }
                                }
                                if($akun->pos == "Kredit"){ 
                                    $total = $total + $kr - $db;
                                } else if($akun->pos == "Debet") {
                                    $total = $total + $db - $kr;
                                }?>
                                <td><?php echo "Rp. ".number_format($total);?></td>
                                <?php $total_jr=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                    if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                    } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                    }
                                }
                                if($akun->pos == "Kredit"){ 
                                    $total_jr = $total_jr + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                    $total_jr = $total_jr + $db1 - $kr1;
                                }?>
                                <td><?php echo "Rp. ".number_format($total_jr);?></td>
                                
                                <?php $total_jr2=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                    if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                    } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                    }
                                }
                                if($akun->pos == "Kredit"){ 
                                    $total_jr2 = $total_jr2 + $kr1 - $db1;
                                } else if($akun->pos == "Debet") {
                                    $total_jr2 = $total_jr2 + $db1 - $kr1;
                                }?>
                                <td><?php echo "Rp. ".number_format($total_jr2);?></td>
                                
                                <td>
                                    <?php 
                                    echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                                    ?>
                                </td>
                                
                                <?php $total_jr1=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                    if($jrnl->pos_akun == "kredit"){
                                    $kr1 = $kr1 + $jrnl->nominal;
                                    } else if($jrnl->pos_akun == "debet") {
                                    $db1 = $db1 + $jrnl->nominal;
                                    }
                                }
                                
                                if($akun->pos == "Debet"){ 
                                    $total_jr1 = $total_jr1 + $kr1 - $db1;
                                } else if($akun->pos == "Kredit") {
                                    $total_jr1 = $total_jr1 + $db1 - $kr1;
                                }?>
                                <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                                <td><?php 
                                $p2 = $p2 + $ttl_sld+$total+$total_jr+$total_jr2;
                                $p7 = $p7 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                                echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?></td>
                        <?php }} else {
                            echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>"; 
                        }?>
                    </tr>
                <?php }}?>

                <tr style="font-weight: bold">
                    <td></td>
                    <td colspan=6>TOTAL PEMBELIAN</td>
                    <td><?php echo "Rp. ".number_format($p2);?></td>
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p7);?></td> 
                </tr>

                <tr style="font-weight:bold; background-color: lightyellow">
                    <td colspan=7 style=" font-size: 16px">LABA KOTOR</td>
                    <td><?php echo "Rp. ".number_format($p1-$p2);?></td>
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p6-$p7);?></td>
                </tr>

                <?php $p3=0; $p8=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"52000"))->result() as $row){ ?>
                    <tr>
                        <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                        <!-- <td colspan=2></td> -->
                    </tr>
                    <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                        <tr>
                            <td><?php echo $anak->no_akun?></td>
                            <td><?php echo $anak->nama_akun?></td>
                            <td><?php echo $anak->pos?></td>
                            <?php 
                            $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                            if($ts->num_rows() > 0){
                            foreach($ts->result() as $akun){?>
                            <?php $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0;
                            if(isset($tgl_awal)){
                                $ttl_sld = $akun->nominal;
                            } else {
                                if($tglmin != ""){
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_sld = $kr_sld + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_sld = $db_sld + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                }

                                $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0;
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_jrl = $kr_jrl + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl = $db_jrl + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                    if($sld1->pos_akun == "kredit"){
                                    $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                    if($sld2->pos_akun == "debet"){
                                    $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                    } else if($sld->pos_akun == "kredit") {
                                    $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1 - $kr_jrl2;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1 - $db_jrl2;
                                }
                                }
                            }?>
                            <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                            <?php $total=0; $db=0; $kr=0; foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                $kr = $kr + $pos->nominal;
                                } else if($pos->pos_akun == "debet") {
                                $db = $db + $pos->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total = $total + $kr - $db;
                            } else if($akun->pos == "Debet") {
                                $total = $total + $db - $kr;
                            }?>
                            <td><?php echo "Rp. ".number_format($total);?></td>
                            <?php $total_jr=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr = $total_jr + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr = $total_jr + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr);?></td>
                            
                            <?php $total_jr2=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr2 = $total_jr2 + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr2 = $total_jr2 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                            <td>
                                <?php 
                                echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                                ?>
                            </td>
                            
                            <?php $total_jr1=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Debet"){ 
                                $total_jr1 = $total_jr1 + $kr1 - $db1;
                            } else if($akun->pos == "Kredit") {
                                $total_jr1 = $total_jr1 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr1);?></td>
                            <td><?php 
                            $p3 = $p3 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p8 = $p8 + $ttl_sld+$total+$total_jr+$total_jr2+$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr-$total_jr1+$total_jr2);?></td>
                        <?php }} else {
                            echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
                        }?>
                    </tr>
                <?php }}?>

                <tr style="font-weight: bold">
                    <td></td>
                    <td colspan=6>TOTAL BIAYA KONSTRUKSI DAN FINISHING</td>
                    <td><?php echo "Rp. ".number_format($p3);?></td>
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p8);?></td> 
                </tr>

                <?php $p4=0; $p9=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"51000"))->result() as $row){ ?>
                    <tr>
                        <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                        <!-- <td colspan=2></td> -->
                    </tr>
                    <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                        <tr>
                        <td><?php echo $anak->no_akun?></td>
                        <td><?php echo $anak->nama_akun?></td>
                        <td><?php echo $anak->pos?></td>
                        <?php 
                        $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                        if($ts->num_rows() > 0){ 
                        foreach($ts->result() as $akun){?>
                            <?php $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0;
                            if(isset($tgl_awal)){
                                $ttl_sld = $akun->nominal;
                            } else {
                                if($tglmin != ""){
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_sld = $kr_sld + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_sld = $db_sld + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                }

                                $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0;
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_jrl = $kr_jrl + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl = $db_jrl + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                    if($sld1->pos_akun == "kredit"){
                                    $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                    if($sld2->pos_akun == "debet"){
                                    $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                    } else if($sld->pos_akun == "kredit") {
                                    $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1 - $kr_jrl2;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1 - $db_jrl2;
                                }
                                }
                            }?>
                            <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                            <?php $total=0; $db=0; $kr=0; foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                $kr = $kr + $pos->nominal;
                                } else if($pos->pos_akun == "debet") {
                                $db = $db + $pos->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total = $total + $kr - $db;
                            } else if($akun->pos == "Debet") {
                                $total = $total + $db - $kr;
                            }?>
                            <td><?php echo "Rp. ".number_format($total);?></td>
                            <?php $total_jr=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr = $total_jr + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr = $total_jr + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr);?></td>
                            
                            <?php $total_jr2=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr2 = $total_jr2 + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr2 = $total_jr2 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                            <td>
                                <?php 
                                echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                                ?>
                            </td>
                            
                            <?php $total_jr1=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Debet"){ 
                                $total_jr1 = $total_jr1 + $kr1 - $db1;
                            } else if($akun->pos == "Kredit") {
                                $total_jr1 = $total_jr1 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                            <td><?php 
                            $p4 = $p4 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p9 = $p9 + $ttl_sld+$total+$total_jr+$total_jr2-$total_jr1;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?></td>
                    <?php }} else {
                        echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>"; 
                    }?>
                    </tr>
                <?php }}?>

                <tr style="font-weight: bold">
                    <td></td>
                    <td colspan=6>TOTAL BIAYA OVERHEAD PERUSAHAAN</td>
                    <td><?php echo "Rp. ".number_format($p4);?></td>
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p9);?></td> 
                </tr>

                <tr style="font-weight: bold; background-color: lightblue; ">
                    <td colspan=7 style="font-size: 16px">BIAYA BIAYA</td>
                    <td><?php echo "Rp. ".number_format($p8+$p9);?></td> 
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p3+$p4);?></td>
                </tr>

                <tr style="font-weight:bold; background-color: lightyellow">
                    <td colspan=7 style=" font-size: 16px">LABA SEBELUM PAJAK</td>
                    <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4));?></td>
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9));?></td>
                </tr>

                <?php $p5=0; $p10=0; foreach($this->db->get_where('akuntansi_induk_akun', array('no_induk'=>"53000"))->result() as $row){ ?>
                    <tr>
                        <td colspan=10 style="font-weight:bold; font-size: 16px"><?php echo $row->nama_induk?></td>
                        <!-- <td colspan=2></td> -->
                    </tr>
                    <?php foreach($this->db->get_where('akuntansi_anak_akun', array('id_induk'=>$row->id_induk))->result() as $anak){?>
                        <tr>
                        <td><?php echo $anak->no_akun?></td>
                        <td><?php echo $anak->nama_akun?></td>
                        <td><?php echo $anak->pos?></td>
                        <?php 
                        $ts = $this->db->get_where('keuangan_neraca_saldo_awal', array('no_akun'=>$anak->no_akun,'kode_perumahan'=>$kode_perumahan));
                        if($ts->num_rows() > 0){
                        foreach($ts->result() as $akun){?>
                            <?php $ttl_sld=0; $kr_sld=0; $db_sld=0; $kr_jrl=0; $db_jrl=0;
                            if(isset($tgl_awal)){
                                $ttl_sld = $akun->nominal;
                            } else {
                                if($tglmin != ""){
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal($akun->no_akun, $kode_perumahan, $tglmin)->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_sld = $kr_sld + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_sld = $db_sld + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $akun->nominal + $ttl_sld + $kr_sld - $db_sld;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $akun->nominal + $ttl_sld + $db_sld - $kr_sld;
                                }

                                $kr_jrl1=0; $db_jrl1=0; $kr_jrl2=0; $db_jrl2=0;
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "koreksi")->result() as $sld){
                                    if($sld->pos_akun == "kredit"){
                                    $kr_jrl = $kr_jrl + $sld->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl = $db_jrl + $sld->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penyesuaian")->result() as $sld1){
                                    if($sld1->pos_akun == "kredit"){
                                    $kr_jrl1 = $kr_jrl1 + $sld1->nominal;
                                    } else if($sld->pos_akun == "debet") {
                                    $db_jrl1 = $db_jrl1 + $sld1->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                // print_r($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result());
                                foreach($this->Dashboard_model->laba_rugi_saldo_awal_jurnal($akun->no_akun, $kode_perumahan, $tglmin, "penutup")->result() as $sld2){
                                    if($sld2->pos_akun == "debet"){
                                    $kr_jrl2 = $kr_jrl2 + $sld2->nominal;
                                    } else if($sld->pos_akun == "kredit") {
                                    $db_jrl2 = $db_jrl2 + $sld2->nominal;
                                    }
                                    // $ttl_sld = $ttl_sld + $sld->nominal;
                                    // print_r($this->Dashboard_model->laba_rugi_saldo_awal)
                                }
                                if($akun->pos == "Kredit"){ 
                                    $ttl_sld = $ttl_sld + $kr_jrl + $kr_jrl1 - $kr_jrl2;
                                } else if($akun->pos == "Debet") {
                                    $ttl_sld = $ttl_sld + $db_jrl + $db_jrl1 - $db_jrl2;
                                }
                                }
                            }?>
                            <td><?php echo "Rp. ".number_format($ttl_sld)?></td>
                            <?php $total=0; $db=0; $kr=0; foreach($this->Dashboard_model->laba_rugi_pos($akun->no_akun, $kode_perumahan, $tglmin, $tglmax)->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                $kr = $kr + $pos->nominal;
                                } else if($pos->pos_akun == "debet") {
                                $db = $db + $pos->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total = $total + $kr - $db;
                            } else if($akun->pos == "Debet") {
                                $total = $total + $db - $kr;
                            }?>
                            <td><?php echo "Rp. ".number_format($total);?></td>
                            <?php $total_jr=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "koreksi")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr = $total_jr + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr = $total_jr + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr);?></td>
                            
                            <?php $total_jr2=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penyesuaian")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Kredit"){ 
                                $total_jr2 = $total_jr2 + $kr1 - $db1;
                            } else if($akun->pos == "Debet") {
                                $total_jr2 = $total_jr2 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr2);?></td>

                            <td>
                                <?php 
                                echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2);
                                ?>
                            </td>
                            
                            <?php $total_jr1=0; $db1=0; $kr1=0; foreach($this->Dashboard_model->laba_rugi_pos_jurnal($akun->no_akun, $kode_perumahan, $tglmin, $tglmax, "penutup")->result() as $jrnl){
                                if($jrnl->pos_akun == "kredit"){
                                $kr1 = $kr1 + $jrnl->nominal;
                                } else if($jrnl->pos_akun == "debet") {
                                $db1 = $db1 + $jrnl->nominal;
                                }
                            }
                            if($akun->pos == "Debet"){ 
                                $total_jr1 = $total_jr1 + $kr1 - $db1;
                            } else if($akun->pos == "Kredit") {
                                $total_jr1 = $total_jr1 + $db1 - $kr1;
                            }?>
                            <td><?php echo "Rp. ".number_format($total_jr1);?></td>

                            <td><?php 
                            $p5 = $p5 + $ttl_sld+$total+$total_jr+$total_jr2;
                            $p10 = $p10 + $ttl_sld+$total+$total_jr+$total_jr1+$total_jr2;
                            echo "Rp. ".number_format($ttl_sld+$total+$total_jr+$total_jr2-$total_jr1);?></td>
                        <?php }} else {
                            echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>"; 
                        }?> 
                    </tr>  
                <?php }}?>

                <tr style="font-weight: bold">
                    <td></td>
                    <td colspan=6>TOTAL BIAYA PAJAK</td>
                    <td><?php echo "Rp. ".number_format($p5);?></td> 
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p10);?></td>
                </tr>

                <tr style="font-weight:bold; background-color: lightyellow">
                    <td colspan=7 style=" font-size: 16px">LABA / RUGI BERSIH SETELAH PAJAK</td>
                    <td><?php echo "Rp. ".number_format($p1-$p2-($p3+$p4)-$p5);?></td>
                    <td></td>
                    <td><?php echo "Rp. ".number_format($p6-$p7-($p8+$p9)-$p10);?></td>
                </tr>
                </tfoot>
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