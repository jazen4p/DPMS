<html><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <style>
     @page { margin: 180px 50px 90px; }
     #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -130px; right: 0px; height: 150px; }
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
   <script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
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
    <div id="header">
        <?php 
        $query = $this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan));
        foreach($query->result() as $as){
            foreach($this->db->get_where('perusahaan', array('kode_perusahaan'=>$as->kode_perusahaan))->result() as $pers) { ?>
            <img src="./gambar/<?php echo $pers->file_name?>" style="height: 100px; width: 225px">
            <div style="position: fixed; left: 300px; top: -140px; right: 0px; font-size: large; font-weight: bold"><?php echo $pers->nama_perusahaan?></div>
        <?php }}?>
        <p>
            MSGroup Business Center<br/>
            Jl. Perdana No. 168 - Pontianak<br/>
            HP: 0813.2793.5678<br/>
        </p>
        <hr>
    </div>
    <div id="footer">
        <hr style="border-top: 1px solid">
        <p class="page"><span style="font-weight: bold; font-size: 13px"><i>Kesepakatan Kontrak Kerja Borongan Upah - <?php echo $pers->nama_perusahaan?></i></span> <span style="padding-left:120px"> Halaman <?php $PAGE_NUM ?> </span></p>
    </div>
    <div id="content" style="font-size: 13px">
        <div style="font-weight: bold; text-align: center; font-size: 16px">KONTRAK BANGUN KAVLING</div>
        <br><br>
        <div>Pada hari ini, <?php echo ubahHari(date('D', strtotime($row->date_by)))?> tanggal <?php echo date('d', strtotime($row->date_by))." ".ubahBulan(date('M', strtotime($row->date_by)))." ".date('Y', strtotime($row->date_by))." ";?>, kami yang bertandatangan dibawah ini :</div>
        <br>
        <div><b><i>Pihak 1 :</i></b></div>
        <div>
            <table style="padding-left: 30px">
                <tr>
                    <td>Nama</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->dev_nama?></td>
                </tr>
                <tr>
                    <td>No. KTP</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->dev_ktp?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->dev_alamat?></td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->dev_pekerjaan?></td>
                </tr>
            </table>
        </div>
        <div style="text-align: justify">Dalam hal ini bertindak atas nama dan kepentingan <?php echo $pers->nama_perusahaan?> dan selanjutnya disebut sebagai ----------------------------------------------------------------------------------------------------------------- <b>DEVELOPER</b>.</div>
        <br>
        <div><b><i>Pihak 2 :</i></b></div>
        <div>
            <table style="padding-left: 30px">
                <tr>
                    <td>Nama</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->sub_nama?></td>
                </tr>
                <tr>
                    <td>No. KTP</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->sub_ktp?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->sub_alamat?></td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $row->sub_pekerjaan?></td>
                </tr>
            </table>
        </div>
        <div style="text-align: justify">Dalam hal ini bertindak atas nama dan kepentingan diri sendiri dan selanjutnya disebut sebagai --------------------------------------------------------------------------------------------------------- <b>SUB KONTRAKTOR</b>.</div>
        <br>
        <div style="text-align: justify">Sepakat untuk melakukan kerja sama / kontrak kerja pembangunan unit rumah di perumahaan <?php echo $as->nama_perumahan?> Residence yang ada di Jalan <?php echo $as->nama_jalan?>, Kecamatan <?php echo $as->kecamatan?> Kabupaten <?php echo $as->kabupaten?>, dengan kesepakatan sebagai berikut :</div>
        <br>
        <div>
            <table>
                <tr>
                    <td>1. Luas Bangunan</td>
                    <td style="padding-left: 38px">:</td>
                    <td style="padding-left: 20px"><?php echo $row->luas_bangunan?> m<sup>2</sup><?php echo " (".terbilang($row->luas_bangunan)." meter persegi)";?></td>
                </tr>
                <tr>
                    <td>2. Unit Rumah / Blok</td>
                    <td style="padding-left: 38px">:</td>
                    <td style="padding-left: 20px"><?php echo $row->unit?></td>
                </tr>
                <tr>
                    <td>3. Nilai Kontrak Upah</td>
                    <td style="padding-left: 38px">:</td>
                    <td style="padding-left: 20px"><?php echo "Rp. ".number_format($row->upah, 0, ",", ".")." (".terbilang($row->upah)." Rupiah)"?></td>
                </tr>
                <tr>
                    <td>4. Kontrak Pekerjaan</td>
                    <td style="padding-left: 38px">:</td>
                    <td style="padding-left: 20px"><?php echo $row->kontrak_pekerjaan?></td>
                </tr>
                <tr>
                    <td>5. Masa Pelaksanaan</td>
                    <td style="padding-left: 38px">:</td>
                    <td style="padding-left: 20px"><?php echo $row->masa_pelaksanaan?></td>
                </tr>
                <tr>
                    <td>6. Tanggal Mulai</td>
                    <td style="padding-left: 38px">:</td>
                    <td style="padding-left: 20px"><?php echo date('d', strtotime($row->tgl_mulai))." ".ubahBulan(date('M', strtotime($row->tgl_mulai)))." ".date('Y', strtotime($row->tgl_mulai))?></td>
                </tr>
                <tr>
                    <td>7. Tanggal Selesai</td>
                    <td style="padding-left: 38px">:</td>
                    <td style="padding-left: 20px"><?php echo date('d', strtotime($row->tgl_selesai))." ".ubahBulan(date('M', strtotime($row->tgl_selesai)))." ".date('Y', strtotime($row->tgl_selesai))?></td>
                </tr>
                <!-- <tr>
                    <td>8. Ketentuan Pembayaran</td>
                    <td style="padding-left: 20px">:</td>
                    <td style="padding-left: 20px">Pembayaran disesuaikan dengan progres pekerjaan di lapangan ketentuan pembayaran sebagai berikut :</td>
                </tr> -->
            </table>
            <div style="">8. Ketentuan Pembayaran <span style="padding-left: 10px">:</span> <span style="padding-left: 18px">Pembayaran disesuaikan dengan progres pekerjaan di lapangan ketentuan pembayaran sebagai berikut :</span></div>

            <div style="page-break-inside: avoid">
              <table style="width: 100%; padding-left: 10px" border=1>
                <thead style="text-align: center">
                  <tr>
                    <th>TERMIN</th>
                    <th>OPNAME PEMBAYARAN</th>
                    <th>NILAI PEMBAYARAN</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($this->db->get_where('kbk_termin', array('id_kbk'=>$row->id_kbk))->result() as $kbks){?>
                    <tr>
                      <td><?php echo $kbks->tahap?></td>
                      <td style="text-align: center"><?php echo $kbks->opname?> %</td>
                      <td><?php echo "Rp. ".number_format($kbks->nilai_pembayaran, 0, ",", ".")?></td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
              
            <div style="padding-left: 10px">
              Proses pembayaran:
              <ol type="a" style="text-align: justify">
                <li>Sub kontraktor mengajukan permohonan Opname untuk pembayaran termin atau pemeliharaan yang dilampiri dengan Berita Acara pemerikasaan bersama dan Progress fisik.</li>
                <li>Pembayaran akan dilakukan setiap hari Jum'at satu (1) minggu berikutnya, apabila melebihi waktu kesepakatan, maka Developer akan dikenakan sanksi dendan 0.05% per hari dari nilai Termin Pembayaran yang diajukan.</li>
                <li>Pembayaran pemeliharaan/retensi adalah 30 (tiga puluh) hari kalender terhitung sejak Serah Terima Pekerjaan ditandatangani.</li>
              </ol>
            </div>
            <br>
            <div>
              9. Tata Tertib Pelaksanaan Pekerjaan Kavling / unit :
              <ol type="a" style="text-align: justify">
                <li>Tidak diperbolehkan menggunakan KM / WC pada unit kavling yang telah selesai dikerjakan, Sub Kontraktor diwajikan menyediakan MCK sendiri.</li>
                <li>Pada progress 90% tenaga kerja Sub Kontraktor dilarang tidur / menggunnakan fasilitas bangunan yang telah selesai dikerjakan.</li>
                <li>Selalu menjaga kebersihan unit kavling dan tidak membuang sampah / sisa bahan sembarangan.</li>
              </ol>
            </div>
            <br>
            <div>
              10. Pernyataan Khusus Sub Kontraktor : <br>
              <span style="padding-left: 15px">Sebagai Sub Kontraktor dengan ini menyatakan hal - hal sebagai berikut :</span>
              <ol type="a" style="text-align: justify">
                <li>Saya setuju dan bersedia secara otomatis menyerahkan pekerjaan apabila terbukti progress pekerjaan mengalami keterlambatan melebihi 15% dari target progress mingguan yang disepakati atau mtidak menyelesaikan pekerjaan dan tidak akan menuntut retensi pekerjaan.</li>
                <li>Apabila ada kelalaian baik yang disengaja maupun tidak sengaja dalam pekerjaan pembangunan unit kavling dan mengharuskan pembongkaran sebagian maupun seluruh bagian unit rumah, Saya bersedia mengganti semua bahan yang telah terpakai atas pekerjaan bagian yang dibongkar tersebut.</li>
                <li>Tidak akan menerima order pekerjaan secara langsung dari End User (Calon pemilik Rumah) tanpa seijin dan sepengetahuan dari pihak Developer.</li>
                <li>Tidak akan memindahtangankan pekerjaan secara keseluruhan kepada Pihak Ketiga atau Sub kontraktor lain.</li>
                <li>Pembayaran upah tukang sepenuhnya menjadi tanggung jawab Sub kontraktor dan tidak dapat melibatkan Pihak Developer.</li>
                <li>Komplain / keberatan atas kualitas pekerjaan selama masa pemeliharaan akan diberitahukan secara tertulis kepada Sub kontraktor dan apabila tidak dikerjakan dalam 7 (tujuh) hari kalender, saya bersedia dikenakan denda 100% dari Biaya Komplain.</li>
              </ol>
            </div>
            <br>
            <div style="page-break-inside: avoid; text-align: justify">Demikian Kontrak ini dibuat tanpa adanya paksaan dari pihak manapun dan dalam keadaan sadar untuk dapat dipergunakan sebagaimana mestinya.</div>
            <br>
            <div style="page-break-inside: avoid">
              <table style="table-layout: fixed; width: 100%">
                <tr>
                  <td>Menyepakati, </td>
                  <td></td>
                  <td style="text-align: center"><?php echo "Kubu Raya, ".date('d', strtotime($row->date_by))." ".ubahBulan(date('M', strtotime($row->date_by)))." ".date('Y', strtotime($row->date_by))?></td>
                </tr>
                <tr>
                  <td>Sub Kontraktor</td>
                  <td style="text-align: center">Manager Produksi</td>
                  <td style="text-align: center">Direktur Keuangan / Developer</td>
                </tr>
                <tr>
                  <td>
                    <?php if($row->sub_sign != ""){?>
                      <img src="./gambar/signature/kbk/<?php echo $row->sub_sign?>" style="width: 200px; height: 115px">
                    <?php } else {
                      echo "<span><br><br><br><br></span>"; 
                    }?>
                  </td>
                  <td style="text-align: center">
                    <?php if($row->staff_sign != ""){?>
                      <img src="./gambar/signature/kbk/<?php echo $row->staff_sign?>" style="width: 200px; height: 115px">
                    <?php } else {
                      echo "<span><br><br><br><br></span>"; 
                    }?>
                  </td>
                  <td style="text-align: center">
                    <?php if($row->owner_sign != ""){?>
                      <img src="./gambar/produksi/<?php echo $row->owner_sign?>" style="width: 200px; height: 115px">
                    <?php } else {
                      echo "<span><br><br><br><br></span>"; 
                    }?>
                  </td>
                </tr>
                <tr>
                  <td><?php echo $row->sub_nama?></td>
                  <td style="text-align: center"><?php echo $row->dev_nama?></td>
                  <td style="text-align: center"><?php echo "Edi yanto"?></td>
                </tr>
              </table>
            </div>
        </div>
    </div>
  <?php }?>
</body></html>