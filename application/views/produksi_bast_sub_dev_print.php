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
            Jl. Perdana, No. 168 MSGroup Business Center (Samping Kost Bali Agung 3) - Pontianak Kalimantan Barat<br/>
            HP: 0851.0017.7780<br/>
        </p>
        <hr>
    </div>
    <div id="footer">
        <!-- <hr style="border-top: 1px solid">
        <p class="page"><span style="font-weight: bold; font-size: 13px"><i>Kesepakatan Kontrak Kerja Borongan Upah - <?php echo $pers->nama_perusahaan?></i></span> <span style="padding-left:120px"> Halaman <?php $PAGE_NUM ?> </span></p> -->
    </div>
    <div id="content" style="font-size: 13px">
        <?php foreach($this->db->get_where('kbk', array('id_kbk'=>$row->id_kbk))->result() as $kbk){?>
            <div>
                <div style="font-weight: bold; text-align: center">
                    <span style="font-size: 20px">BERITA ACARA SERAH TERIMA BANGUNAN</span> <br>
                    <u>(Bangunan rumah antara sub kontraktor kepada developer)</u>
                </div>
                <br>
                <div>
                    Yang bertanda tangan di bawah ini:
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td style="padding-left: 50px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->dev_nama?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td style="padding-left: 50px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->dev_pekerjaan?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td style="padding-left: 50px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->dev_alamat?></td>
                        </tr>
                    </table>
                    <span style="text-align: justify">Dalam hal ini bertindak sebagai <b>Developer</b> yang selanjutnya disebut sebagai <b>PIHAK PERTAMA</b>.</span>
                    <br> <br>
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td style="padding-left: 50px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->sub_nama?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td style="padding-left: 50px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->sub_pekerjaan?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td style="padding-left: 50px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->sub_alamat?></td>
                        </tr>
                    </table>
                    <span style="text-align: justify">Dalam hal ini bertindak sebagai <b>Pelaksana Pekerjaan</b> yang diatur di dalam <b>Surat Perjanjian Borongan No. <?php echo $row->no_kbk?></b> dan selanjutnya disebut <b>PIHAK KEDUA</b>.</span>
                </div>
                    <br>
                <div style="text-align: justify">
                    Dengan ditandatanganinya surat <b>SERAH TERIMA PEMBANGUNAN</b> ini kedua belah pihak telah saling sepakat dan seuju bahwa:
                </div>
                    <br>
                <div style="text-align: justify">
                    PIHAK KEDUA telah menyerahkan bangunan rumah dalam keadaan baik beserta kunci rumah kepada PIHAK PERTAMA, dan PIHAK PERTAMA menerima dengan baik rumah tinggal yang dimaksud dari PIHAK KEDUA yang terletak di :
                </div>
                    <br>
                <div>
                    
                    <table>
                        <tr>
                            <td>- Bangunan</td>
                            <td style="padding-left: 40px">:</td>
                            <td style="padding-left: 10px">Perumahan <?php echo $as->nama_perumahan?> Residence</td>
                        </tr>
                        <tr>
                            <td>- Alamat</td>
                            <td style="padding-left: 40px">:</td>
                            <td style="padding-left: 10px"><?php echo "Jl. ".$as->nama_jalan.", Kecamatan ".$as->kecamatan." - Kabupaten ".$as->kabupaten?></td>
                        </tr>
                        <tr>
                            <td>- Kavling</td>
                            <td style="padding-left: 40px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->unit?></td>
                        </tr>
                        <tr>
                            <td>- Luas Bangunan</td>
                            <td style="padding-left: 40px">:</td>
                            <td style="padding-left: 10px"><?php echo $kbk->luas_bangunan?> m2</td>
                        </tr>
                    </table>
                </div>
                    <br>
                <div>
                    Dengan diserahkannya rumah tersebut oleh PIHAK KEDUA, maka kunci rumah akan dibawa oleh PIHAK PERTAMA dan akan ditindaklanjuti dengan proses BERITA ACARA SERAH TERIMA (BAST) dengan Konsumen.
                </div>
                    <br>
                <div>
                    Segala hal yang berkaitan dengan perawatan, pemeliharaan dan keamanan lingkungan rumah termasuk garansi berupa kebocoran genting, retak lantai, dan tembok yang disebabkan kelalaian PIHAK KEDUA masih menjadi Tanggung Jawab Penuh PIHAK KEDUA. Masa garansi ini akan dihitung selama 1 (satu) bulan semenjak BAST ditandatangani oleh konsumen.
                </div>
                    <br>
                <div>
                    Demikian Surat <b>SERAH TERIMA PEMBANGUNAN</b> ini dibuat rangkap 2 dan digunakan sebagaimana mestinya..
                </div>
                    <br>
                <div style="page-break-inside: avoid">
                    <table style="table-layout: fixed; width: 100%; padding-left: 30px">
                        <tr>
                            <td></td>
                            <td style="text-align: center"><?php echo "Desa Durian, ".date('d', strtotime($row->date_by))." ".ubahBulan(date('M', strtotime($row->date_by)))." ".date('Y', strtotime($row->date_by))?></td>
                        </tr>
                        <tr>
                            <td>PIHAK KEDUA</td>
                            <td style="text-align: center">PIHAK KESATU</td>
                        </tr>
                        <tr>
                            <td>
                                <span><br><br><br><br></span>
                            </td>
                            <td style="text-align: center">
                                <span><br><br><br><br></span>
                                <!-- <img src="./gambar/qr_code/<?php echo $row->qr_code?>" style="width: 110px; height: 110px"> -->
                            </td>
                        </tr>
                        <tr>
                            <td><u><?php echo $kbk->sub_nama?></u></td>
                            <td style="text-align: center"><u><?php echo strtoupper($kbk->dev_nama)?></u></td>
                            </tr>
                        <tr>
                            <td><?php echo "Sub Kontraktor"?></td>
                            <td style="text-align: center"><?php echo "Project Manager"?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php }?>
    </div>
  <?php }?>
</body></html>