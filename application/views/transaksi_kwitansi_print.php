<html><head>
   <style>
     @page { margin: 180px 50px 150px; }
     #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px;}
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
  <?php if(isset($check_all)){foreach($check_all as $row){?>
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
        HP: 0813.2793.5678 <span style="text-align: right; padding-left: 450px; color: red">NO.KW.<?php echo $row->kode_perumahan."1".substr("000{$row->no_kwitansi}", -3)?></span><br/>
      </p>
    <hr>
   </div>
   <div id="footer">
      <hr style="border-top: 1px solid">
    <p class="page">
         <!-- <span style="font-weight: bold"><i><?php echo date("Y-m-d")?></i></span>  -->
         <span style="padding-left:50px"><b><i>Dicetak oleh sistem, pada <?php echo date("Y-m-d H:i:sa")?></i></b></span>
    </p>
   </div>
   <div id="content">
     <p>
         <div style="width: 870px; border: 1px solid; padding: 30px; margin: 20px; margin-left: 40px">
             <table style="padding-left: 40px">
                 <tbody>
                        <?php foreach($ppjb as $row2){?>
                            <tr>
                                <th style="white-space: nowrap;">Sudah diterima dari</th>
                                <th style="padding-left: 20px">:</th>
                                <th><?php echo $row2->nama_pemesan?></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"><?php echo " "?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"><?php echo " "?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;">Banyaknya uang</th>
                                <th style="padding-left: 20px">:</th>
                                <th><?php echo terbilang($row->dana_masuk)?> Rupiah</th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"><?php echo " "?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;">Untuk pembayaran</th>
                                <th style="padding-left: 20px">:</th>
                                <?php $temp=1; foreach($this->db->get_where('rumah', array('kode_perumahan'=>$row->kode_perumahan, 'no_psjb'=>$row->no_psjb, 'tipe_produk'=>$row->tipe_produk))->result() as $row4){
                                    if($row4->no_psjb==$row->no_psjb){ $temp = $temp + 1;}?>
                                <?php } foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $row5){ }?>
                                <th><?php echo $row->cara_bayar?> Perumahan <?php echo $row5->nama_perumahan." ".$temp?> Unit Type <?php echo $row2->tipe_rumah?> Blok <?php echo $row2->no_kavling;?> <br>Jl. Desa Durian Kec. Sungai Ambawang Kubu Raya</th>
                            </tr>
                        <?php }?>
                 </tbody>
             </table>
         </div>
     </p>
     <p>
        <table style="width: 100%; table-layout: fixed">
          <tr>
            <td>
              <span style="width: 120px; border: 1px solid; padding: 5px; margin: 20px; margin-left: 40px; font-size: 18px; font-weight: bold">Rp. <?php echo number_format($row->dana_masuk)?></span>                
            </td>
            <td style="text-align: center">
              <?php 
              $this->db->order_by('id_keuangan', 'DESC');
              $query = $this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb),1)->result();
              foreach($query as $row3){?>
              Pontianak, <?php echo date('d', strtotime($row3->tanggal_bayar))." ".ubahBulan(date('M', strtotime($row3->tanggal_bayar)))." ".date('Y', strtotime($row3->tanggal_bayar))?>
              <?php }?>
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="text-align: center">
              <img src="./gambar/qr_code/<?php echo $row->qr_code?>" style="width: 120px; height: 120px">
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="text-align: center">
              <u>
                <?php if(isset($out)){
                  echo "Suciati Eva Yuda";
                } else {
                  echo $this->session->userdata('nama'); 
                }?>
              </u>
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="text-align: center">
              Admin
            </td>
          </tr>
        </table>
        <!-- <span style="width: 120px; border: 1px solid; padding: 5px; margin: 20px; margin-left: 40px; font-size: 18px; font-weight: bold">Rp. <?php echo number_format($row->dana_masuk)?></span>
         <span style="padding-left: 550px">
             <?php 
             $this->db->order_by('id_keuangan', 'DESC');
             $query = $this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb),1)->result();
             foreach($query as $row3){?>
             Pontianak, <?php echo date('d', strtotime($row3->tanggal_bayar))." ".ubahBulan(date('M', strtotime($row3->tanggal_bayar)))." ".date('Y', strtotime($row3->tanggal_bayar))?>
             <?php }?>
        </span><br><br>
        <br><br><br><br><br>
        <span style=" text-align: center"><img src="./gambar/qr_code/<?php echo $row->qr_code?>" style="width: 120px; padding-left: 780px; height: 120px"></span> <br>
        <span style="padding-left: 785px; text-align: center">
             <u><?php echo $this->session->userdata('nama')?></u>
        </span>
        <span style="padding-left: 815px; text-align: center">
             Admin
        </span> <br><br><br> -->
     </p>
   </div>
  <?php }} else if(isset($penerimaan_lain)) {
    foreach($penerimaan_lain as $row){?>
      <div id="header">
      <?php if($row->kode_perumahan == "MSK"){?>
        <img src="./assets/img/logo2.png" style="height: 100px; width: 225px">
        <div style="position: fixed; left: 300px; top: -140px; right: 0px; font-size: large; font-weight: bold">PT. Mitra Sejahtera Propertiland</div>
      <?php } else if($row->kode_perumahan == "MSG") {?>
        <img src="./assets/img/logo.jpg" style="height: 100px; width: 150px">
        <div style="position: fixed; left: 300px; top: -140px; right: 0px; font-size: large; font-weight: bold">PT. Profesional Properti Agensi</div>
      <?php } else {?>

      <?php }?>
      <p>
        MSGroup Business Center<br/>
        Jl. Perdana No. 168 - Pontianak<br/>
        HP: 0813.2793.5678 <span style="text-align: right; padding-left: 450px; color: red">NO.KW.<?php echo $row->kode_perumahan."1".substr("000{$row->no_kwitansi}", -3)?></span><br/>
      </p>
    <hr>
   </div>
   <!-- <div id="footer">
      <hr style="border-top: 1px solid">
     <p class="page">
         <span style="font-weight: bold"><i><?php echo date("Y-m-d")?></i></span> 
         <span style="padding-left:650px">Dicetak oleh: <?php echo $nama?> </span>
    </p>
   </div> -->
   <div id="content">
     <p>
         <div style="width: 870px; border: 1px solid; padding: 30px; margin: 20px; margin-left: 40px">
             <table style="padding-left: 40px">
                 <tbody>
                        <?php foreach($this->db->get_where('ppjb', array('no_psjb'=>$row->no_ppjb))->result() as $row2){?>
                            <tr>
                                <th style="white-space: nowrap;">Sudah diterima dari</th>
                                <th>:</th>
                                <th><?php echo $row2->nama_pemesan?></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"><?php echo " "?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"><?php echo " "?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;">Banyaknya uang</th>
                                <th>:</th>
                                <th><?php echo terbilang($row->dana_masuk)?> Rupiah</th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;"><?php echo " "?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="white-space: nowrap;">Untuk pembayaran</th>
                                <th>:</th>
                                <?php $temp=1; foreach($this->db->get_where('rumah', array('kode_perumahan'=>$row->kode_perumahan, 'no_psjb'=>$row->no_psjb, 'tipe_produk'=>$row->tipe_produk))->result() as $row4){
                                    if($row4->no_psjb==$row->no_psjb){ $temp = $temp + 1;}?>
                                <?php } foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $row5){ }?>
                                <th><?php echo $row->cara_bayar?> Perumahan <?php echo $row5->nama_perumahan." ".$temp?> Unit Type <?php echo $row2->tipe_rumah?> Blok <?php echo $row2->no_kavling;?> Jl. Desa Durian Kec. Sungai Ambawang Kubu Raya</th>
                            </tr>
                        <?php }?>
                 </tbody>
             </table>
         </div>
     </p>
     <p>
        <span style="width: 120px; border: 1px solid; padding: 5px; margin: 20px; margin-left: 40px; font-size: 18px; font-weight: bold">Rp. <?php echo number_format($row->dana_masuk)?></span>
         <span style="padding-left: 550px">
             <?php foreach($this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_ppjb),1)->result() as $row3){?>
             Pontianak, <?php echo date('d', strtotime($row3->tanggal_bayar))." ".ubahBulan(date('M', strtotime($row3->tanggal_bayar)))." ".date('Y', strtotime($row3->tanggal_bayar))?>
             <?php }?>
        </span>
        <br><br><br><br><br>
        <span style="padding-left: 800px; text-align: center">
             <u>Suciati Eva Yuda</u>
        </span>
        <span style="padding-left: 830px; text-align: center">
             Admin
        </span> <br><br><br>
     </p>
   </div>
  <?php }}?>
</body></html>