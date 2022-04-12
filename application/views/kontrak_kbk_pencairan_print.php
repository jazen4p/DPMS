<html><head>
   <style>
     @page { margin: 180px 50px 150px; }
     #header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -205px; right: 0px; height: 150px; }
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
  <?php if(isset($check_all)){
    foreach($check_all as $row){
      if($st == "borongan"){
      foreach($this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$row->id_kontrak))->result() as $row1){?>
   <div id="header">
      <?php 
        $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));
        foreach($query->result() as $perumahan){
            foreach($this->db->get_where('perusahaan', array('nama_perusahaan'=>$perumahan->nama_perusahaan))->result() as $perusahaan)?>
                <img src="./gambar/<?php echo $perusahaan->file_name?>" style="height: 100px; width: 225px">
                <div style="position: fixed; left: 300px; top: -140px; right: 0px; font-size: large; font-weight: bold"><?php echo $perusahaan->nama_perusahaan?></div>
      <?php }?>
      <p>
        MSGroup Business Center<br/>
        Jl. Perdana No. 168 - Pontianak<br/>
        HP: 0813.2793.5678 
      </p>
    <!-- <hr> -->
   </div>
   <div id="footer">
      <hr style="border-top: 1px solid">
     <p class="page">
        <span style="font-weight: bold"><i>Dicetak oleh sistem, pada tanggal <?php echo date("d F Y")?></i></span> 
    </p>
   </div>
   <div id="content">
     <p>
        <table>
          <tr>
            <td style="text-align: center; width: 900px"></td><td><?php echo $perumahan->nama_perumahan?></td>
          </tr>
          <tr>
            <td style="text-align: center; width: 900px">TANDA TERIMA</td><td style="background-color: lightgrey; text-align: center">No. <?php echo $row->no_pencairan?></td>
          </tr>
        </table>
        <hr style="border-top: 1px solid">

        <table style="padding-left: 30px">
          <tr>
            <td>Nama</td>
            <td style="padding-left: 50px">:</td>
            <td><?php echo $row1->nama_tukang?></td>
          </tr>
          <tr>
            <td>Keterangan</td>
            <td style="padding-left: 50px">:</td>
            <td><?php echo $row->keterangan_utama?></td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 50px"></td>
            <td>Perincian: <?php echo $row->keterangan?></td>
          </tr>
          <tr>
            <td>Nominal</td>
            <td style="padding-left: 50px">:</td>
            <td style="font-weight: bold;">
              <span style="background-color: lightgrey; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-bottom: 10px;"><?php echo "Rp. ".number_format($row->nominal)?></span>
            </td>
          </tr>
        </table>
          <br>
        <table style="padding-left: 30px; width: 100%; table-layout: fixed">
          <tr>
            <td></td><td style="text-align: center">Pontianak, <?php echo date('d F Y', strtotime($row->tgl_pencairan))?></td>
          </tr>
          <tr>
            <td>Diterima oleh,</td><td style="text-align: center">Diserahkan oleh,</td>
          </tr>
          <tr>
            <td></td>
            <td style="text-align: center"><img src="./gambar/qr_code/<?php echo $row->qr_code?>" style="width: 120px; height: 120px"></td>
          </tr>
          <tr>
            <td><?php echo $row1->nama_tukang?></td><td style="text-align: center">Hendra Hartady</td>
          </tr>
        </table>
          
     </p>
   </div>
  <?php }} else {?>
    <div id="header">
      <?php 
        $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));
        foreach($query->result() as $perumahan){
            foreach($this->db->get_where('perusahaan', array('nama_perusahaan'=>$perumahan->nama_perusahaan))->result() as $perusahaan)?>
                <img src="./gambar/<?php echo $perusahaan->file_name?>" style="height: 100px; width: 225px">
                <div style="position: fixed; left: 300px; top: -140px; right: 0px; font-size: large; font-weight: bold"><?php echo $perusahaan->nama_perusahaan?></div>
      <?php }?>
      <p>
        MSGroup Business Center<br/>
        Jl. Perdana No. 168 - Pontianak<br/>
        HP: 0813.2793.5678 
      </p>
    <!-- <hr> -->
   </div>
   <div id="footer">
      <hr style="border-top: 1px solid">
     <p class="page">
        <span style="font-weight: bold"><i>Dicetak oleh sistem, pada tanggal <?php echo date("d F Y")?></i></span> 
    </p>
   </div>
   <div id="content">
     <p>
        <table>
          <tr>
            <td style="text-align: center; width: 900px"></td><td><?php echo $perumahan->nama_perumahan?></td>
          </tr>
          <tr>
            <td style="text-align: center; width: 900px">TANDA TERIMA</td><td style="background-color: lightgrey; text-align: center">No. <?php echo $row->no_pencairan?></td>
          </tr>
        </table>
        <hr style="border-top: 1px solid">

        <table style="padding-left: 30px">
          <tr>
            <td>Nama</td>
            <td style="padding-left: 50px">:</td>
            <td><?php echo $row->nama_tukang?></td>
          </tr>
          <tr>
            <td>Keterangan</td>
            <td style="padding-left: 50px">:</td>
            <td><?php echo $row->keterangan_utama?></td>
          </tr>
          <!-- <tr>
            <td></td>
            <td style="padding-left: 50px"></td>
            <td>Perincian: <?php echo $row->keterangan?></td>
          </tr> -->
          <tr>
            <td>Nominal</td>
            <td style="padding-left: 50px">:</td>
            <td style="font-weight: bold;">
              <span style="background-color: lightgrey; padding-left: 10px; padding-right: 10px; margin-top: 10px; margin-bottom: 10px;"><?php echo "Rp. ".number_format($row->total)?></span>
            </td>
          </tr>
        </table>
          <br>
        <table style="padding-left: 30px; width: 100%; table-layout: fixed">
          <tr>
            <td></td><td style="text-align: center">Pontianak, <?php echo date('d F Y', strtotime($row->tgl_pencairan))?></td>
          </tr>
          <tr>
            <td>Diterima oleh,</td><td style="text-align: center">Diserahkan oleh,</td>
          </tr>
          <tr>
            <td><img src="./gambar/signature/pencairan/<?php echo $row->tukang_sign?>" style="width: 120px; height: 120px" /></td>
            <td style="text-align: center"><img src="./gambar/qr_code/<?php echo $row->qr_code?>" style="width: 120px; height: 120px"></td>
          </tr>
          <tr>
            <td><?php echo $row->nama_tukang?></td><td style="text-align: center">Hendra Hartady</td>
          </tr>
        </table>
          
     </p>
   </div>
  <?php }}}?>
</body></html>