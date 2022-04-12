<html><head>
   <style>
     @page { margin: 50px 50px 50px }
     body {border: 1px solid; }
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
   <div id="content" style="font-family: Times New Roman, times, serif;">
      <?php 
        $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));
        foreach($query->result() as $perumahan){
            foreach($this->db->get_where('perusahaan', array('nama_perusahaan'=>$perumahan->nama_perusahaan))->result() as $perusahaan)?>
              <img src="./assets/img/logo2.png" style="height: 100px; width: 225px">
              <p style="padding-left: 200px; padding-top: 40px; right: 0px; text-align: center; font-size: 25px; font-weight: bold">
                  TANDA TERIMA SERTIPIKAT & SLIP PBB<br><br>
                  <?php echo $perumahan->nama_perumahan?> RESIDENCE
              </p>
      <?php }?>
      <?php if($row->kode_perumahan == "MSK"){?>
        <!-- <img src="./assets/img/logo2.png" style="height: 100px; width: 225px">
        <p style="padding-left: 200px; padding-top: 40px; right: 0px; text-align: center; font-size: 25px; font-weight: bold">
            TANDA TERIMA SERTIPIKAT & SLIP PBB<br><br>
            MS KENCANA RESIDENCE
        </p> -->
      <?php } else if($row->kode_perumahan == "MSG") {?>
        <!-- <img src="./assets/img/logo.jpg" style="height: 100px; width: 150px">
        <p style="padding-left: 200px; padding-top: 40px; right: 0px; text-align: center; font-size: 25px; font-weight: bold">
            TANDA TERIMA SERTIPIKAT & SLIP PBB<br><br>
            MS GARDENIA RESIDENCE
        </p> -->
      <?php } else {?>

      <?php }?>
    <hr style="border: 1px solid; margin-top: 40px">
       <br>
     <p style="">
        <table style="padding-left: 100px; font-size: 18px">
            <tr>
                <td style="height: 45px">NAMA PENERIMA</td><td style="padding-left: 100px">:</td><td><b><?php echo $row->terima_oleh_sertif?></b></td>
            </tr>
            <tr>
                <td style="height: 45px">TANGGAL TERIMA</td><td style="padding-left: 100px">:</td><td><?php echo date('d', strtotime($row->tgl_terima_sertif))." ".date('F', strtotime($row->tgl_terima_sertif))." ".date('Y', strtotime($row->tgl_terima_sertif))?></td>
            </tr>
            <tr>
                <td style="height: 45px">BLOK</td><td style="padding-left: 100px">:</td><td><?php echo $row->no_kavling?></td>
            </tr>
            <?php foreach($this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling,'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $row1){?>
            <tr>
                <td style="height: 45px">NO. SHM</td><td style="padding-left: 100px">:</td><td><b><?php echo $row1->no_shm?></b></td>
            </tr>
            <tr>
                <td style="height: 45px">NO. SU</td><td style="padding-left: 100px">:</td><td><?php echo $row->no_su?></td>
            </tr>
            <tr>
                <td style="height: 45px">NO. PBB</td><td style="padding-left: 100px">:</td><td><?php echo $row1->no_pbb?></td>
            </tr>
            <?php }?>
            <tr>
                <td style="height: 45px">KET</td><td style="padding-left: 100px">:</td><td><b>1 BUKU SERTIPIKAT ASLI & PBB</b></td>
            </tr>
        </table>
        <br>
        <div style="text-align: right; padding-right: 150px; font-size: 18px">
            TANDA TANGAN
        </div>
        <br><br><br><br><br>
        <div style="text-align: right; padding-right: 140px; font-size: 18px">
            ...................................
        </div>
     </p>
     <?php }?>
   </div>
</body></html>