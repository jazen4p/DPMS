<html><head>
   <style>
     @page { margin: 40px 40px 410px }
     body {border: 3px solid; }
     #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; font-family: "Times New Roman", times, serif;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 200px; top: -115px; right: 0px; text-align: center; font-size: 25px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -225px; right: 0px; height: 150px; }
     #content img { position: fixed; left: 50px; top: 20px; right: 0px; height: 25px; text-align: center}
     /* #footer .page:after { content: counter(page); } */
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
  <?php foreach($check_all as $row){?>
   <div id="content" style="font-family: Times New Roman, times, serif; border: 1px solid; margin-left: 10px; margin-right: 10px; margin-top: 10px; margin-bottom: 10px">
    
     <p style="">
        <p style="text-align: center; font-size: 15px;">
          <?php foreach($notaris as $not){?>
            <span>NOTARIS DAN PEJABAT PEMBUAT AKTA TANAH (P.P.A.T)</span>
            <!-- <span style="display: block; margin-bottom: 1em"></span> -->
            <span style="font-weight: bold; font-size: 24px; margin-top: 10px; display: block"><?php echo strtoupper($not->nama_notaris)?></span>
            <span style=""><?php echo $not->alamat_notaris?></span><br>
            <span style="">Telp. <?php echo $not->telp_notaris?>, Fax. <?php echo $not->fax_notaris?>, Hp. <?php echo $not->hp_notaris?></span><br>
            <span style="margin-bottom: 10px">Email : <?php echo $not->email_notaris?></span><br>
          <?php }?>
            <span style="font-weight: bold; font-size: 22px; margin-top: 10px; margin-bottom: 20px; display: block">TANDA - TERIMA SERTIPIKAT</span><br>
        </p>
        <table style="padding-left: 10px; font-size: 16px">
            <?php foreach($this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling,'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $row1){?>
            <tr>
                <td style="height: 35px">Sertipikat SHM</td>
                <td style="padding-left: 100px"></td>
                <td><?php 
                    echo $row1->no_shm;
                    $query = $this->db->get_where('rumah', array('no_psjb'=>$row->psjb,'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                    foreach($query->result() as $rumah){
                        echo ", ".$rumah->no_shm;
                    }
                ?> / Sungai Durian</td>
            </tr>
            <tr>
                <td style="height: 35px">Luas</td>
                <td style="padding-left: 100px"></td>
                <td><?php
                  echo $row1->luas_tanah."m<sup>2</sup>";
                  $query1 = $this->db->get_where('rumah', array('no_psjb'=>$row->psjb,'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                  foreach($query1->result() as $rumah1) {
                    echo ", ".$rumah1->luas_tanah."m<sup>2</sup>";
                  }
                ?></td>
            </tr>
            <tr>
                <td style="height: 35px">Perbuatan Hukum</td><td style="padding-left: 100px"></td><td><?php echo "Jual Beli"?></td>
            </tr>
            <tr>
                <td style="height: 35px">Pihak Pertama</td><td style="padding-left: 100px"></td><td><b><?php echo "Tn. Harry Afandy"?></b></td>
            </tr>
            <tr>
                <td style="height: 35px">Pihak Kedua</td><td style="padding-left: 100px"></td><td><?php echo $row->nama_pemesan?></td>
            </tr>
            <!-- <tr>
                <td style="height: 35px">NO. PBB</td><td style="padding-left: 100px">:</td><td><?php echo $row1->no_pbb?></td>
            </tr> -->
            <?php }?>
            <tr>
              <td style="height: 35px" rowspan="4">
                Keterangan <br>
                <span style="font-size: 12px; color: red">
                  <?php echo $row->no_kavling;
                  $query1 = $this->db->get_where('rumah', array('no_psjb'=>$row->psjb,'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk));
                  foreach($query1->result() as $rumah1) {
                    echo " & ".$rumah1->kode_rumah;
                  }
                  foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $perumahan){
                    echo " - ".$perumahan->nama_perumahan; 
                  }?>
                </span>
              </td>
              <td style="padding-left: 100px"></td>
            </tr>
              <tr>
                <td></td>
                <?php 
                  $valid = 0;
                  $valid = $valid + $row->nilai_validasi;
                  foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $vld){
                    $valid = $valid + $vld->nilai_validasi;
                  }
                ?>
                <td style="padding-left: 15px"><li>Nilai Jual <?php echo "Rp. ".number_format($valid)?></li></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left: 15px"><li>TTD Sendiri</li></td>
              </tr>
            
        </table>
        <br>
        <div style="text-align: right; padding-right: 120px; font-size: 16px">
            Sungai Raya, <?php 
              echo date('d', strtotime($row->notaris_masukdata))." ".date('F', strtotime($row->notaris_masukdata))." ".date('Y', strtotime($row->notaris_masukdata))
            ?>
        </div>
        <div style="text-align: right; padding-right: 150px; font-size: 16px; font-weight: bold">
            NOTARIS / P.P.A.T
        </div>
        <br><br><br><br><br>
        <div style="text-align: right; padding-right: 140px; font-size: 16px">
            ( HENDRY BONG, SH. )
        </div>
     </p>
     <?php }?>
   </div>
</body></html>