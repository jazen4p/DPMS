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
        <p class="page"><span style="font-weight: bold; font-size: 13px"><i>Kesepakatan Kontrak Kerja Tambahan Bangunan - <?php echo $pers->nama_perusahaan?></i></span> <span style="padding-left:90px"> Halaman <?php $PAGE_NUM ?> </span></p>
    </div>
    <div id="content" style="font-size: 13px">
        <div style="font-weight: bold; text-align: center; font-size: 16px">Surat Perjanjian Kontrak Kerja</div>
        <br>
        <div>Pada hari ini, <?php echo ubahHari(date('D', strtotime($row->date_by)))?> tanggal <?php echo date('d', strtotime($row->date_by))." ".ubahBulan(date('M', strtotime($row->date_by)))." ".date('Y', strtotime($row->date_by))." ";?>, kami yang bertandatangan dibawah ini :</div>
        <br>
        <div><b><i>Pihak 1 :</i></b></div>
        <div>
            <table style="padding-left: 30px">
                <tr>
                    <td>Nama</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px">Harry Afandy</td>
                </tr>
                <tr>
                    <td>No. KTP</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px">6171060303830001</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px">Jl. Sei. Raya Dalam Komp. Mitra Indah Utama V Blok C, Pontianak, Kalimantan Barat</td>
                </tr>
                <tr>
                    <td>No. HP</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px">0812 578 2967</td>
                </tr>
            </table>
        </div>
        <div style="text-align: justify">Dalam hal ini bertindak atas nama dan kepentingan <?php echo $pers->nama_perusahaan?> dan selanjutnya disebut sebagai ----------------------------------------------------------------------------------------------------------------- <b>PIHAK PERTAMA</b>.</div>
        <br>
        <div><b><i>Pihak 2 :</i></b></div>
        <div>
            <?php foreach($this->db->get_where('kbk', array('unit'=>$row->no_unit, 'kode_perumahan'=>$row->kode_perumahan))->result() as $kbk){
                foreach($this->db->get_where('ppjb', array('id_psjb'=>$kbk->id_ppjb))->result() as $ppjb){?>
            <table style="padding-left: 30px">
                <tr>
                    <td>Nama</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $ppjb->nama_pemesan?></td>
                </tr>
                <tr>
                    <td>No. KTP</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $ppjb->ktp?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $ppjb->alamat_lengkap?></td>
                </tr>
                <tr>
                    <td>No. HP</td>
                    <td style="padding-left: 10px">:</td>
                    <td style="padding-left: 10px"><?php echo $ppjb->telp_hp?></td>
                </tr>
            </table>
            <?php }}?>  
        </div>
        <div style="text-align: justify">Dalam hal ini bertindak atas nama dan kepentingan diri sendiri dan selanjutnya disebut sebagai --------------------------------------------------------------------------------------------------------- <b>PIHAK KEDUA</b>.</div>
        <br>
        <div style="text-align: justify">Dimana Pihak Pertama selaku penerima pekerjaan dan Pihak Kedua sebagai pemberi pekerjaan, sepakat untuk melakukan kerja sama / kontrak kerja tambahan pembangunan unit <?php echo $row->no_unit?> rumah di perumahaan <?php echo $as->nama_perumahan?> Residence yang ada di Jalan <?php echo $as->nama_jalan?>, Kecamatan <?php echo $as->kecamatan?> Kabupaten <?php echo $as->kabupaten?>, dengan kesepakatan sebagai berikut :</div>
        <br>
        <div>
            <div style="page-break-inside: avoid">
              <table style="width: 100%; padding-left: 10px;" border=1>
                <thead style="text-align: center">
                  <tr style="background-color: pink">
                    <th style="width: 35px">NO</th>
                    <th>JENIS PEKERJAAN</th>
                    <th>TOTAL HARGA</th>
                    <!-- <th>NILAI PEMBAYARAN</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; $ttl=0; $hk = 0; foreach($this->db->get_where('kbk_kontrak_kerja', array('status <>'=>"batal",'no_unit'=>$row->no_unit, 'kode_perumahan'=>$row->kode_perumahan, 'kategori'=>"tambahanbangunan"))->result() as $kbks){?>
                    <tr>
                      <td style="text-align: center"><?php echo $no?></td>
                      <td><?php echo $kbks->pekerjaan_ket?></td>
                      <!-- <td style="text-align: center"><?php echo $kbks->opname?> %</td> -->
                      <td style="text-align: center"><?php echo "Rp. ".number_format($kbks->harga_jual, 0, ",", ".")?></td>
                    </tr>
                  <?php $ttl = $ttl + $kbks->harga_jual; 
                  $no++;
                  $hk = $hk + $kbks->masa_kerja;}?>
                    <tr style="background-color: lightgreen; font-weight: bold">
                      <td style="text-align: center" colspan=2>TOTAL</td>
                      <td style="text-align: center"><?php echo "Rp. ".number_format($ttl, 0, ",", ".")?></td>
                    </tr>
                </tbody>
              </table>
            </div>
              
            <div style="padding-left: 10px">
              Adapun cara pembayaran sebagai berikut :
              <ol type="1" style="text-align: justify">
                <li>DP sebesar 40% yaitu Rp <?php echo number_format(($ttl * 40)/100, 0 , ",", ".")?> akan dibayarkan 1 (satu) minggu sebelum dimulainya pekerjaan.</li>
                <li>Selanjutnya pembayaran sebesar 30% yaitu Rp <?php echo number_format(($ttl * 30)/100, 0 , ",", ".")?> yang dibayarkan setelah pekerjaan 50%</li>
                <li>Berikutya 30% pelunasan pembayaran sebesar Rp. <?php echo number_format(($ttl * 30)/100, 0 , ",", ".")?> yang dibayarkan setelah pekerjaan 100% (selesai)</li>
              </ol>
            </div>
            <br>
            <div>
              Lamanya pengerjaan <?php echo $hk?> hari kerja terhitung 1 (satu) minggu setelah penerimaan DP.
            </div>
            <br>
            <div style="page-break-inside: avoid; text-align: justify">
              Apabila ada perselisihan yang timbul dikemudian hari, maka Pihak Pertama dan Pihak Kedua sepakat untuk menyelesaikannya dalam musyawarah untuk mufakat. Demikian Surat kontrak kerja ini dibuat dengan benar dan tanpa ada paksaan dari pihak manapun.
            </div>
            <!-- <br> -->
            <!-- <div style="page-break-inside: avoid; text-align: justify">Demikian Kontrak ini dibuat tanpa adanya paksaan dari pihak manapun dan dalam keadaan sadar untuk dapat dipergunakan sebagaimana mestinya.</div> -->
            <br>
            <div style="page-break-inside: avoid">
              <table style="table-layout: fixed; width: 100%">
                <tr>
                  <td>Menyepakati, </td>
                  <td></td>
                  <!-- <td style="text-align: center"><?php echo "Kubu Raya, ".date('d', strtotime($row->date_by))." ".ubahBulan(date('M', strtotime($row->date_by)))." ".date('Y', strtotime($row->date_by))?></td> -->
                  <td></td>
                </tr>
                <tr>
                  <td>Pihak Kedua</td>
                  <td style="text-align: center"></td>
                  <td style="text-align: center">Pihak Pertama</td>
                </tr>
                <tr>
                  <td>
                    <br><br><br><br>
                  </td>
                  <td style="text-align: center">
                  </td>
                  <td style="text-align: center">
                    <br><br><br><br>
                  </td>
                </tr>
                <tr>
                  <td><?php echo $ppjb->nama_pemesan?></td>
                  <td style="text-align: center"></td>
                  <td style="text-align: center"><?php echo "Harry Afandy"?></td>
                </tr>
              </table>
            </div>
        </div>
    </div>
  <?php }?>
</body></html>