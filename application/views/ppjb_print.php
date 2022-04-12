<html><head>
   <style>
     @page { margin: 180px 50px 90px; }
     #header { position: fixed; left: 0px; top: -200px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -130px; right: 0px; height: 150px; }
     #footer .page:after { content: counter(page); }
     input[type=checkbox]:before { font-family: DejaVu Sans; }
     input[type=checkbox] { display: inline; }
     @font-face {
      font-family: 'font2';
      font-style: normal;
      font-weight: bold;
      src: url(dompdf/font/arialbd.ttf);
     }
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

   <div id="header">
    <?php foreach($check_all as $row){?>
      <?php foreach($this->db->get_where('perusahaan', array('kode_perusahaan'=>$row->kode_perusahaan))->result() as $pers){?>
        <img src="./gambar/<?php echo $pers->file_name?>" style="height: 100px; width: 225px">
        <div style="position: fixed; left: 300px; top: -140px; right: 0px; font-size: large; font-weight: bold"><?php echo $pers->nama_perusahaan?></div>
      <?php }?>
      <p>
        MSGroup Business Center<br/>
        Jl. Perdana No. 168 - Pontianak<br/>
        HP: 0813.2793.5678<br/>
      </p>
    <hr>
   </div>
   <div id="footer">
      <hr style="border-top: 1px solid">
     <p class="page"><span style="font-weight: bold"><span style="opacity: 60%"><?php echo $pers->nama_perusahaan?></span> | Perjanjian Pendahuluan Jual Beli</span> <span style="padding-left:160px"> Halaman <?php $PAGE_NUM ?> </span></p>
   </div>
   <div id="content">
      <!-- START OF KPR -->
       <?php if($row->sistem_pembayaran == "KPR"){?>
        <p>
          <div style="font-size: 20px; font-weight: bold">
            PENJELASAN AWAL SEBELUM PERJANJIAN 
          </div>
          <div style="font-size: 11px; text-align: justify; text-justify: inter-word;">
            <i>Halaman ini dipergunakan marketing sebagai acuan dan koreksi dalam pembacaan isi perjanjian yang dijelaskan langsung kepada calon pembeli atau yang mewakili. Dalam tiap pasal PPJB harus diparaf oleh marketing dan calon pembeli.</i>
          </div>
          <div> <br>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">PERJANJIAN PENDAHULUAN JUAL BELI</span> </div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="font-weight: bold">Umum</td><td style="padding-left:20px; white-space: nowrap;">Lokasi perumahan dan letak kavling</td><td style="text-align: right; padding-left:210px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Surat tanah dan luas tanah kavling</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Type / luas bangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 1</td><td style="padding-left:20px; white-space: nowrap;">Harga jual</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Biaya Balik Nama ( BBN )  dan pajak pembelian ( BPHTB )</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 2</td><td style="padding-left:20px; white-space: nowrap;">Cara pembayaran</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 3</td><td style="padding-left:20px; white-space: nowrap;">Pembelian dengan fasilitas Kredit Pemilikan Rumah ( KPR )</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 4</td><td style="padding-left:20px; white-space: nowrap;">Keterlambatan pembayaran dan denda</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 5</td><td style="padding-left:20px; white-space: nowrap;">Pembangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 6</td><td style="padding-left:20px; white-space: nowrap;">Serah terima bangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 7</td><td style="padding-left:20px; white-space: nowrap;">Jaminan PIHAK PERTAMA</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 8</td><td style="padding-left:20px; white-space: nowrap;">Biaya transaksi jual beli</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 9</td><td style="padding-left:20px; white-space: nowrap;">Pajak Pertambahan Nilai (PPN)</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 10</td><td style="padding-left:20px; white-space: nowrap;">Musyawarah dalam hal – hal yang belum diatur dalam perjanjian</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 11</td><td style="padding-left:20px; white-space: nowrap;">Penyelesain perselisihan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 12</td><td style="padding-left:20px; white-space: nowrap;">Tambahan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 13</td><td style="padding-left:20px; white-space: nowrap;">Penutup</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Lampiran</td><td style="padding-left:20px; white-space: nowrap;">Lampiran spesifikasi gambar</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Nomor rekening yang digunakan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div><br/>
          <div>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">SPESIFIKASI MATERIAL FINISHING</span></div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan atap</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan plafond</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan Pintu, jendela dan alat pengunci</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan sanitasi</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan keramik lantai</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan cat</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan listrik</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan Lain-lain</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div><br>
          <div> 
            <br>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">GAMBAR STANDART</span></div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="padding-left:5px; white-space: nowrap;">1. Site Plan</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">2. Denah, ukuran ruang dan elevasi lantai</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">3. Tampak depan, tampak samping kanan dan kiri</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">4. Rencana pondasi</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">5. Penempatan titik lampu dan stop kontak</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">6. Saluran air bersih, meliputi penempatan :</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Sumur / Pengolahan air mandiri</li></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Septictank</li><ol></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Sumur peresapan</li></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Kran air bersih</li><ol></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="text-align: right"><i>Pontianak, <?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></i></div>
            <div style="font-size: 12px; text-align: justify; text-justify: inter-word;"><br><i>Saya menyatakan telah membacakan dan menjelaskan dengan baik seluruh isi dokumen Perjanjian Pendahuluan Jual Beli (PPJB) berikut lampiran yang ada.</i></div><br>
            <table style="padding-left: 20px; table-layout: fixed; width: 60%">
              <tbody>
                <tr><td style="white-space: nowrap;">Tanggal</td><td style="">:</td><td><?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></td></tr>
                <tr><td style="white-space: nowrap;">Nama</td><td style="">:</td><td><?php echo $row->nama_marketing?></td></tr>
                <tr>
                  <td style="white-space: nowrap;">Tanda tangan</td>
                  <td style="">:</td>
                  <td>
                    <div style="width:300px;height:100px;border:1px solid #000;">
                      <?php if($row->marketing_sign != ""){?>
                        <img src="./gambar/signature/ppjb/<?php echo $row->marketing_sign?>" style="padding-left: 5px; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; width: 200px; height: 90px">
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table> 
          </div>
          <div style="font-size: 12px; text-align: justify; text-justify: inter-word;"><br><i>Saya menyatakan telah menerima penjelaskan dengan baik seluruh isi dokumen Perjanjian Pendahuluan Jual Beli (PPJB) berikut lampiran yang ada.</i></div><br>
          <div style="page-break-inside: avoid">
            <table style="padding-left: 20px; table-layout: fixed; width: 60%">
              <tbody>
                <tr><td style="white-space: nowrap;">Tanggal</td><td style="padding-left: 40px">:</td><td><?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></td></tr>
                <tr><td style="white-space: nowrap;">Nama</td><td style="padding-left: 40px">:</td><td><?php echo $row->nama_pemesan?></td></tr>
                <tr>
                  <td style="white-space: nowrap;">Tanda tangan</td>
                  <td style="padding-left: 40px">:</td>
                  <td>
                    <div style="width:300px;height:100px;border:1px solid #000;">
                      <?php if($row->konsumen_sign != ""){?>
                        <img src="./gambar/signature/ppjb/<?php echo $row->konsumen_sign?>" style="padding-left: 5px; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; width: 200px; height: 90px">
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table> 
          </div><br>
        </p>
          <br><br>
        <p>
          <div style="font-weight: bold; font-size: 20px; text-align: center">PERJANJIAN PENDAHULUAN JUAL BELI – PPJB</div><br>
          <div style="font-weight: bold; font-size: 13px; text-align: center">No : 1-<?php echo $row->no_psjb?>/PPJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m")?>/<?php echo date("Y")?></div><br><br>
          <div style="text-align: justify; text-justify: inter-word;">Pada hari ini, <?php echo ubahHari(date("D"))?> tanggal <?php echo date("d")?> bulan <?php echo ubahBulan(date("M"))?> tahun <?php echo date("Y")?> (<?php echo terbilang(date("Y"))?>) yang bertanda - tangan di bawah ini dengan diketahui para saksi yang akan turut menandatangani perjanjian ini :</div>
          <table style="">
            <tbody>
            <tr style="font-weight: bold"><td>Pihak 1</td><td style="">:</td><td>Harry Afandy</td></tr>
            <tr style="font-style: italic"><td>Tempat Tanggal Lahir</td><td style="">:</td><td>Pontianak, 03 Maret 1983</td></tr>
            <tr style="font-style: italic"><td>No. KTP</td><td style="">:</td><td>6171060303830001</td></tr>
            <tr style="font-style: italic"><td>Pekerjaan</td><td style="">:</td><td>Direktur</td></tr>
            <tr><td></td><td colspan=10>Dalam hal ini mewakili <b>PT. Mitra Sejahtera Propertiland</b> dan selaku perusahaan. selanjutnya disebut sebagai :</td></tr>
            </tbody>
          </table>
          <div style="font-weight: bold">--------------------------------------------  PIHAK PERTAMA.</div><br>
          <table style="">
            <tbody>
            <tr style="font-weight: bold"><td>Pihak 2</td><td style="">:</td><td><?php echo $row->nama_pemesan?></td></tr>
            <tr style="font-style: italic"><td>Alamat sekarang / di</td><td style="">:</td><td><?php echo $row->alamat_lengkap?></td></tr>
            <tr style="font-style: italic"><td>Nomor telp rumah / HP</td><td style="">:</td><td><?php echo $row->telp_hp?></td></tr>
            <tr><td></td><td colspan=10>Dalam hal ini bertindak selaku pembeli, selanjutnya disebut sebagai:</td></tr>
            </tbody>
          </table>
          <div style="font-weight: bold">--------------------------------------------  PIHAK KEDUA.</div>
          <p style="padding-left: 100px">
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Bahwa PIHAK PERTAMA dengan ini mengikatkan diri untuk menjual, memindahkan dan mengalihkan serta menyerahkan kepada 
              PIHAK KEDUA, dan PIHAK KEDUA dengan ini pula mengikatkan diri dalam perjanjian ini untuk membeli, menerima pemindahan 
              dan pengalihan serta penyerahan dari PIHAK PERTAMA sebuah rumah seluas ± <?php echo $row->luas_bangunan;?> m2 ( lebih kurang <?php echo terbilang($row->luas_bangunan)?> meter persegi ) 
              dan berdiri di atas sebidang tanah seluas ± <?php echo $row->luas_tanah?> m2 ( lebih kurang <?php echo terbilang($row->luas_tanah)?> meter persegi ) yang terletak di  : 
            </div>
            <br>
            <div style="page-break-inside: avoid">
              <table style="padding-left: 60px;">
                <tbody>
                <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $row2){?>
                  <tr style=""><td>Desa / Kelurahan</td><td style="">:</td><td><?php echo $row2->nama_jalan?></td></tr>
                  <tr style=""><td>Kecamatan</td><td style="">:</td><td><?php echo $row2->kecamatan?></td></tr>
                  <tr style=""><td>Kabupaten</td><td style="">:</td><td><?php echo $row2->kabupaten?></td></tr>
                  <tr style=""><td>Propinsi</td><td style="">:</td><td><?php echo $row2->provinsi?></td></tr>
                <?php }?>
                </tbody>
              </table>
            </div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Yang dikenal sebagai perumahan “ <?php echo $row->perumahan?> “ nomor kavling <?php echo $row->no_kavling?>
            <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){?>
              , <?php echo $rumah->no_unit?>
            <?php }?>, dengan type Lb / Lt <?php echo $row->luas_bangunan?> / <?php echo $row->luas_tanah?> m<sup>2</sup>, spesifikasi dan gambar terlampir yang telah disetujui dan ditandatangani antara kedua belah pihak pada perjanjian ini.
            </div>
            <div style="text-align: justify; text-justify: inter-word">
              Dengan demikian kedua belah pihak telah bersepakat mengikatkan dirinya masing – masing untuk mengadakan Perjanjian Pendahuluan Perikatan Jual Beli ( PPJB ) dengan syarat - syarat dan ketentuan sebagai berikut :
            <div>
          </p>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 1</div>
            <div style="font-size: 14px; text-align: center">HARGA JUAL</div>
            <br>
            <ol style="text-align: justify; text-justify: inter-word">
              <li>
                PIHAK PERTAMA mengikatkan untuk menjual, memindahkan dan mengalihkan kepada PIHAK KEDUA dan PIHAK KEDUA membeli, menerima pemindahan serta penyerahan dari PIHAK PERTAMA atas tanah dan bangunan tersebut dengan harga kesepakatan sebesar :
              </li><br><br>
              <table style="padding-left: 40px">
                <tbody>
                  <tr><td>Rp</td><td style="padding-left: 10px">:</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                  <tr><td>Terbilang</td><td style="padding-left: 10px">:</td><td><?php echo terbilang($row->harga_jual)?> Rupiah</td></tr>
                </tbody>
              </table><br>
              <li>
                Harga tersebut belum termasuk Biaya Balik Nama ( BBN ) dan Biaya Perolehan Hak atas Tanah dan Bangunan ( BPHTB ) sesuai dengan peraturan perundangan yang berlaku yang harus dibayarkan sebelum penandatanganan Akte Jual Beli di Notaris. 
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <!-- <div style="page-break-inside: avoid"> -->
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 2</div>
            <div style="font-size: 14px; text-align: center">CARA PEMBAYARAN</div>
            <!-- <br> -->
            <ol style="text-align: justify; text-justify: inter-word">
              <li>
              PIHAK KEDUA sanggup  melunasi  pembayaran  tersebut dalam pasal 1 dengan  sistem dan cara pembayaran sebagai berikut : 
              </li>
              <table style="padding-left: 40px">
                <thead>
                  <tr>
                    <td style="">Tahap Pembayaran</td>
                    <td style="padding-left: 50px">Tanggal Pembayaran</td>
                    <td style="padding-left: 70px">Jumlah Pembayaran</td>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    foreach($query as $row3){?>
                    <tr>
                      <td><?php echo $row3->cara_bayar?></td>
                      <?php if($row3->cara_bayar == "KPR"){?>
                        <td style="padding-left: 50px">AKAD BANK</td>
                      <?php } else {?>
                        <td style="padding-left: 50px"><?php echo date("d", strtotime($row3->tanggal_dana))." ".ubahBulan(date("M", strtotime($row3->tanggal_dana)))." ".date("Y", strtotime($row3->tanggal_dana))?></td>
                      <?php }?>
                      <td style="padding-left: 70px">Rp. <?php echo number_format($row3->dana_masuk)?>,-</td>
                    </tr> 
                  <?php }?>
                </tbody>
              </table>
              <table>
                <tr><td>Rp</td><td style="padding-left: 10px">:</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                <tr><td>Terbilang</td><td style="padding-left: 10px">:</td><td><?php echo terbilang($row->harga_jual)?> Rupiah</td></tr>
              </table>
              <li>
                PIHAK KEDUA  menjamin bahwa tahapan pembayaran angsuran ini dilaksanakan oleh PIHAK KEDUA sebelum dan sesudah hari dan tanggal perjanjian ini ditandatangani.
              </li>
              <li>
                Untuk tiap – tiap pembayaran ( angsuran, denda dan bunga ) yang dilakukan PIHAK KEDUA kepada PIHAK PERTAMA, harus dilakukan ke alamat PIHAK PERTAMA atau transfer bank ke rekening PIHAK PERTAMA. Pembayaran melalui cek atau transfer baru dianggap sah diterima setelah dana yang bersangkutan efektif diterima oleh PIHAK PERTAMA dan akan diberikan tanda terima berupa kwitansi oleh PIHAK PERTAMA yang merupakan bagian yang tidak terpisahkan dari isi perjanjian ini.
              </li>
            </ol>
          <!-- </div> -->
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 3</div>
            <div style="font-size: 14px; text-align: center">PEMBELIAN DENGAN FASILITAS KREDIT KEPEMILIKAN RUMAH (KPR)</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">Untuk pembelian melalui fasilitas pembiayaan Bank pemberi kredit ( KPR ), maka pihak calon pembeli setuju dan mufakat untuk:</div>
            <ul style="text-align: justify; text-justify: inter-word">
              <li>
                Melengkapi semua persyaratan KPR selambat - lambatnya 30 (tiga puluh hari) dan atau sebelum PPJB ditandatangani agar pengurusan KPR dapat dijalankan oleh pihak perusahaan. 
              </li>
              <li>
                Menerima pengajuan bank pemberi kredit yang menjadi mitra pihak perusahaan.
              </li>
              <li>
                Apabila bank pemberi kredit menganggap pihak konsumen tidak layak untuk dibiayai maka uang tanda jadi akan dikembalikan kepada calon pembeli dan apabila terjadi penurunan plafon pinjaman, maka secara otomatis konsumen sanggup dan bersedia untuk melakukan pelunasan selisih uang muka/plafon.
              </li>
              <li>
                Khusus untuk konsumen yang tidak memiliki data penghasilan yang tercatat (rekap keuangan, mutasi rekening bank, data pendukung lainnya) diberikan waktu maksimal 6 (enam) bulan terhitung pada saat Booking Fee untuk memperbaiki/me-record data KPR nya dengan catatan :
                <ol type="i">
                  <li>
                    Membayar DP sesuai dengan kesepakatan.
                  </li>
                  <li>
                    Membayar Cicilan angsuran sesuai dengan tabel bank BNI Syariah (bunga fix) berdasarkan analisa kemampuan konsumen oleh team komite KPR perusahaan (tempo kpr yang sesuai dengan kemampuan bayar konsumen), dalam hal ini pembayaran tempo DP dan angsuran KPR berjalan (apabila pembayaran DP secara tempo). 
                  </li>
                  <li>
                    Apabila data sudah diperbaiki dan dinilai bank-able oleh team komite, maka data konsumen akan diajukan ke pihak Bank kerjasama perusahaan.
                  </li>
                  <li>
                    Harga unit adalah harga pada saat kesepakatan pembayaran Booking Fee. 
                  </li>
                  <li>
                    Apabila masa treatment 6 (enam) bulan selesai dan konsumen tetap dinyatakan tidak lolos untuk pembiayaan melalui KPR maka perusahaan akan mengembalikan dana konsumen yang bersangkutan apabila unit rumah konsumen tersebut sudah ada pembeli baru dan tanpa ada potongan apapun
                  </li>
                  <li>
                    Dalam masa treatment 6 (enam) bulan, konsumen dilarang membatalkan pembelian unit tersebut. Dalam hal pembatalan, maka perusahaan akan mengembalikan dana konsumen yang bersangkutan apabila unit rumah konsumen tersebut sudah ada pembeli baru dengan membayar biaya pembatalan Rp 2.500.000.
                  </li>
                  <li>
                    Dalam hal pembatalan oleh konsumen, apabila tidak mau menunggu sampai unitnya terjual, maka dana akan dikembalikan 50% dari total jumlah dana yang sudah disetorkan oleh konsumen.
                  </li>
                  <li>
                    Konsumen tidak dalam keadaan collect 3 sampai 5 pada saat BI Checking baik pada saat pembayaran booking fee maupun masa treatment.
                  </li>
                </ol>
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 4</div>
            <div style="font-size: 14px; text-align: center">KETERLAMBATAN DAN PEMBAYARAN DENDA</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                PIHAK KEDUA harus membayar segala pembayaran yang telah disepakati kepada PIHAK PERTAMA sesuai dengan jadwal yang telah disepakati. 
              </li>
              <li>
                Bilamana PIHAK KEDUA membayar kewajibannya melebihi batas waktu tersebut di atas, maka PIHAK KEDUA harus membayar denda sebesar 2,5 % ( dua koma lima persen ) perbulan dari nilai pembayaran yang terlambat dan dihitung secara proporsional harian sejak tanggal jatuh tempo pembayaran dari jadwal yang disepakati di atas.
              </li>
              <li>
                Untuk keterlambatan yang berlangsung 3 ( tiga ) kali angsuran, maka perjanjian ini dianggap batal dan PIHAK KEDUA telah dianggap melepaskan segala hak - haknya termasuk pembayaran tanda jadi dan angsuran yang telah dibayarkan kepada PIHAK PERTAMA, dan PIHAK PERTAMA berhak untuk mengambil alih segala hak - hak tersebut termasuk pembayaran tanda jadi dan angsuran yang telah dibayar oleh PIHAK KEDUA. PIHAK PERTAMA juga dapat mengalihkan hak atas tanah dan bangunan tersebut kepada pihak ketiga.
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 5</div>
            <div style="font-size: 14px; text-align: center">PEMBANGUNAN</div>
            <br>
            <ol type="1" style="line-height: 50px; text-align: justify; text-justify: inter-word">
              <li>
                PIHAK PERTAMA akan melaksanakan pembangunan fisik rumah dimulai atas kesepakatan para pihak dengan melihat kesiapan di lapangan. PIHAK KEDUA membayar pelunasan uang muka dari harga jual yang telah disepakati dan/atau setelah disetujuinya Kredit Pemilikan Rumah ( KPR ).
              </li>
              <li>
                PIHAK PERTAMA  berkewajiban menyelesaikan pembangunan rumah milik PIHAK KEDUA  dalam jangka waktu selambat – lambatnya 120 (seratus dua puluh) hari dihitung sejak pasal 6 ayat 1 terpenuhi. Bila dalam jangka waktu yang telah ditentukan PIHAK PERTAMA belum menyelesaikan pembangunan rumah tersebut, maka PIHAK KEDUA pada bulan setelah bulan penyelesaian rumah yang telah ditentukan dalam adendum akan mendapat ganti - rugi atas keterlambatan penyelesaian PIHAK PERTAMA sebesar 0,05 % ( nol koma nol lima persen ) per hari dari total uang yang telah dibayarkan oleh PIHAK KEDUA kepada PIHAK PERTAMA, dengan nilai setinggi - tingginya sebesar 2% ( dua persen ) dari total uang yang telah dibayarkan PIHAK KEDUA kepada PIHAK PERTAMA.
              </li>
              <li>
                Dalam hal terjadi keterlambatan masa pembangunan sebagaimana diatur dalam pasal 6 ayat 2 perjanjian ini, dikecualikan untuk hal – hal yang di luar kemampuan PIHAK PERTAMA, yakni sambungan listrik dan air yang sepenuhnya tergantung pada ketersediaan jaringan, daya meter dan meter dari pihak PLN atau instansi yang berwenang untuk itu.
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 6</div>
            <div style="font-size: 14px; text-align: center">SERAH TERIMA BANGUNAN</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word; line-height: 50px;">
              <li>
                PIHAK KEDUA menerima dan setuju penyerahan bangunan rumah ( serah terima kunci ) dari PIHAK PERTAMA dilaksanakan, apabila PIHAK KEDUA telah melunasi seluruh kewajibannya kepada PIHAK PERTAMA seperti tercantum dalam pasal 2 perjanjian ini. Sebelum diadakan serah terima dari PIHAK PERTAMA kepada PIHAK KEDUA, maka PIHAK KEDUA tidak diperkenankan melakukan hal - hal sebagai berikut :
                <ul>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk melaksanakan pembangunan, mengubah maupun menambah bangunan, baik yang dilaksanakan sendiri maupun melalui pihak ketiga.
                  </li>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk menempati bangunan atau menempatkan pihak ketiga dengan alasan apapun di lokasi pembangunan.
                  </li>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk memasukkan dan / atau menempatkan barang apapun juga di lokasi pembangunan.
                  </li>
                </ul>
              </li>
              <li>
                Penyerahan kunci rumah akan dibuatkan dengan Berita Acara Serah Terima Rumah tersendiri yang merupakan bagian yang tidak terpisahkan dari perjanjian ini. Sejak diserahkannya bangunan dari PIHAK PERTAMA kepada PIHAK KEDUA, maka segala biaya - biaya yang berkaitan dengan fasilitas pada bangunan tersebut menjadi tanggung jawab PIHAK KEDUA. 
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 7</div>
            <div style="font-size: 14px; text-align: center">JAMINAN PIHAK PERTAMA</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word;">
              <li>
                PIHAK PERTAMA menjamin kepada PIHAK KEDUA bahwa pada saat akan diserahkannya bangunan rumah tersebut kepada  PIHAK KEDUA, tanah dan rumah tersebut  adalah benar - benar dibawah penguasaan dan / atau pengelolaan PIHAK PERTAMA dan bebas dari sitaan, ikatan dan beban apapun lainnya serta tidak dipergunakan  sebagai jaminan hutang dengan  cara apapun.
              </li>
              <li>
                PIHAK PERTAMA akan memberikan jaminan kepada PIHAK KEDUA selama 60 ( enam puluh ) hari apabila terjadi kerusakan yang disebabkan oleh kelalaian PIHAK PERTAMA sejak penandatanganan realisasi penyerahan rumah ( Berita Acara Penyerahan Rumah ), kecuali bila terjadi force majeur ( bencana alam, huru hara, pemogokan, perang, kebakaran ). Bila telah melewati jangka waktu dan masa perawatan 60 ( enam puluh ) hari terjadi keluhan / complain, maka akan menjadi tanggung jawab PIHAK KEDUA secara penuh.
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 8</div>
            <div style="font-size: 14px; text-align: center">BIAYA TRANSAKSI JUAL BELI</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                Pada saat sebelum AKAD Kredit maka PIHAK PERTAMA  berkewajiban  untuk mengalihkan hak atas tanah  dimana  rumah tersebut berdiri kepada  PIHAK KEDUA  dan untuk biaya Akta Jual Beli ( AJB ), biaya Balik Nama ( BBN ) serta Biaya Perolehan Hak atas Tanah dan Bangunan ( BPHTB ) serta Biaya AKAD KPR akan wajib dibayarkan oleh Pihak Pembeli.
              </li>
              <li>
                Status hak atas tanah sepenuhnya menyesuaikan dengan ketentuan peraturan yang berlaku dimana lokasi rumah ini berada dan Badan Pertanahan Nasional ( BPN ) setempat. Apabila dikemudian hari ada penurunan/peningkatan hak, maka biaya sepenuhnya adalah tanggung jawab pembeli.
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 9</div>
            <div style="font-size: 14px; text-align: center">PAJAK PERTAMBAHAN NILAI</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Apabila di kemudian hari terdapat keharusan dalam pemungutan PPN oleh Negara maka PIHAK PERTAMA akan membantu memungut kepada PIHAK KEDUA dan membayarkannya kepada negara sesuai dengan peraturan perundang undangan yang berlaku.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 10</div>
            <div style="font-size: 14px; text-align: center">MUSYAWARAH HAL-HAL YANG BELUM DIATUR DALAM PERJANJIAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Hal – hal yang belum diatur dalam perjanjian ini oleh PIHAK PERTAMA dan PIHAK KEDUA akan diatur dan ditetapkan dikemudian hari, dengan syarat disetujui dan ditandatangani bersama oleh kedua belah pihak dan merupakan bagian yang tidak terpisahkan dari perjanjian ini. Apabila di kemudian hari ternyata terdapat kesalahan dan kekeliruan dalam perjanjian ini akan diadakan perubahan dan pembetulan sebagaimana mestinya.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 11</div>
            <div style="font-size: 14px; text-align: center">PENYELESAIAN PERSELISIHAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Apabila terjadi perselisihan mengenai isi perjanjian ini, para pihak sepakat akan menyelesaikan secara musyawarah, dan apabila tidak mencapai kesepakatan maka akan diselesaikan melalui jalur arbitrase dengan menundukkan diri pada Badan Arbitrase Nasional Indonesia (BANI) Pontianak.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 12</div>
            <div style="font-size: 14px; text-align: center">TAMBAHAN</div>
            <br>
            <div>
              <?php 
                if($row->catatan != ""){
                  echo "Dalam pasal ini menerangkan bahwa Pihak Kedua mendapat ".$row->catatan;
                }
              ?>
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 13</div>
            <div style="font-size: 14px; text-align: center">PENUTUP</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              PIHAK PERTAMA dan PIHAK KEDUA menyatakan dengan sungguh-sungguh bahwa perjanjian pendahuluan tentang pengikatan jual beli ini dibuat dengan tanpa adanya paksaan dari pihak manapun, dan merupakan perjanjian terakhir yang menghapus perjanjian sebelumnya baik lisan maupun tertulis. Demikian perjanjian ini dibuat rangkap 2 dimana masing-masing bermeterai cukup dan mempunyai kekuatan hukum yang sama.
            </div>
          </div>
        </p>
      <!-- END OF KPR -->

      <!-- START OF CASH -->
      <?php } else if($row->sistem_pembayaran == "Cash"){?>
        <p>
          <div style="font-size: 22px; font-weight: bold">
            PENJELASAN AWAL SEBELUM PERJANJIAN 
          </div>
          <div style="font-size: 11px; text-align: justify; text-justify: inter-word;">
            <i>Halaman ini dipergunakan marketing sebagai acuan dan koreksi dalam pembacaan isi perjanjian yang dijelaskan langsung kepada calon pembeli atau yang mewakili. Dalam tiap pasal PPJB harus diparaf oleh marketing dan calon pembeli.</i>
          </div>
          <div> <br>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">PERJANJIAN PENDAHULUAN JUAL BELI</span> </div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="font-weight: bold">Umum</td><td style="padding-left:20px; white-space: nowrap;">Lokasi perumahan dan letak kavling</td><td style="text-align: right; padding-left:210px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Surat tanah dan luas tanah kavling</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Type / luas bangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 1</td><td style="padding-left:20px; white-space: nowrap;">Harga jual</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Biaya Balik Nama ( BBN )  dan pajak pembelian ( BPHTB )</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 2</td><td style="padding-left:20px; white-space: nowrap;">Cara pembayaran</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 3</td><td style="padding-left:20px; white-space: nowrap;">Keterlambatan pembayaran dan denda</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 4</td><td style="padding-left:20px; white-space: nowrap;">Pembatalan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 5</td><td style="padding-left:20px; white-space: nowrap;">Pembangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 6</td><td style="padding-left:20px; white-space: nowrap;">Serah terima bangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 7</td><td style="padding-left:20px; white-space: nowrap;">Jaminan PIHAK PERTAMA</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 8</td><td style="padding-left:20px; white-space: nowrap;">Biaya transaksi jual beli</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 9</td><td style="padding-left:20px; white-space: nowrap;">Pajak Pertambahan Nilai (PPN)</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 10</td><td style="padding-left:20px; white-space: nowrap;">Musyawarah dalam hal – hal yang belum diatur dalam perjanjian</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 11</td><td style="padding-left:20px; white-space: nowrap;">Penyelesain perselisihan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 12</td><td style="padding-left:20px; white-space: nowrap;">Tambahan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Pasal 13</td><td style="padding-left:20px; white-space: nowrap;">Penutup</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold">Lampiran</td><td style="padding-left:20px; white-space: nowrap;">Lampiran spesifikasi gambar</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Nomor rekening yang digunakan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div><br>
          <div>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">SPESIFIKASI MATERIAL FINISHING</span></div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan atap</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan plafond</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan Pintu, jendela dan alat pengunci</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan sanitasi</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan keramik lantai</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan cat</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan listrik</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan Lain-lain</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div><br>
          <div> 
            <br>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">GAMBAR STANDART</span></div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="padding-left:5px; white-space: nowrap;">1. Site Plan</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">2. Denah, ukuran ruang dan elevasi lantai</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">3. Tampak depan, tampak samping kanan dan kiri</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">4. Rencana pondasi</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">5. Penempatan titik lampu dan stop kontak</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">6. Saluran air bersih, meliputi penempatan :</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Sumur / Pengolahan air mandiri</li></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Septictank</li><ol></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Sumur peresapan</li></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Kran air bersih</li><ol></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div>
        </p>
          <br>
        <p>
        <div style="page-break-inside: avoid">
            <div style="text-align: right"><i>Pontianak, <?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></i></div>
            <div style="font-size: 12px; text-align: justify; text-justify: inter-word;"><br><i>Saya menyatakan telah membacakan dan menjelaskan dengan baik seluruh isi dokumen Perjanjian Pendahuluan Jual Beli (PPJB) berikut lampiran yang ada.</i></div><br>
            <table style="padding-left: 20px; table-layout: fixed; width: 60%">
              <tbody>
                <tr><td style="white-space: nowrap;">Tanggal</td><td style="">:</td><td><?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></td></tr>
                <tr><td style="white-space: nowrap;">Nama</td><td style="">:</td><td><?php echo $row->nama_marketing?></td></tr>
                <tr>
                  <td style="white-space: nowrap;">Tanda tangan</td>
                  <td style="">:</td>
                  <td>
                    <div style="width:300px;height:100px;border:1px solid #000;">
                      <?php if($row->marketing_sign != ""){?>
                        <img src="./gambar/signature/ppjb/<?php echo $row->marketing_sign?>" style="padding-left: 5px; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; width: 200px; height: 90px">
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table> 
          </div>
          <div style="font-size: 12px; text-align: justify; text-justify: inter-word;"><br><i>Saya menyatakan telah menerima penjelaskan dengan baik seluruh isi dokumen Perjanjian Pendahuluan Jual Beli (PPJB) berikut lampiran yang ada.</i></div><br>
          <div style="page-break-inside: avoid">
            <table style="padding-left: 20px; table-layout: fixed; width: 60%">
              <tbody>
                <tr><td style="white-space: nowrap;">Tanggal</td><td style="padding-left: 40px">:</td><td><?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></td></tr>
                <tr><td style="white-space: nowrap;">Nama</td><td style="padding-left: 40px">:</td><td><?php echo $row->nama_pemesan?></td></tr>
                <tr>
                  <td style="white-space: nowrap;">Tanda tangan</td>
                  <td style="padding-left: 40px">:</td>
                  <td>
                    <div style="width:300px;height:100px;border:1px solid #000;">
                      <?php if($row->konsumen_sign != ""){?>
                        <img src="./gambar/signature/ppjb/<?php echo $row->konsumen_sign?>" style="padding-left: 5px; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; width: 200px; height: 90px">
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table> 
          </div><br>
        </p>
          <br><br>
        <p>
          <div style="font-weight: bold; font-size: 20px; text-align: center">PERJANJIAN PENDAHULUAN JUAL BELI – PPJB</div><br>
          <div style="font-weight: bold; font-size: 13px; text-align: center">No : 1-<?php echo $row->no_psjb?>/PPJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m")?>/<?php echo date("Y")?></div><br><br>
          <div style="text-align: justify; text-justify: inter-word;">Pada hari ini, <?php echo ubahHari(date("D"))?> tanggal <?php echo date("d")?> bulan <?php echo ubahBulan(date("M"))?> tahun <?php echo date("Y")?> (<?php echo terbilang(date("Y"))?>) yang bertanda - tangan di bawah ini dengan diketahui para saksi yang akan turut menandatangani perjanjian ini :</div>
          <table style="">
            <tbody>
            <tr style="font-weight: bold"><td>Pihak 1</td><td style="">:</td><td>Harry Afandy</td></tr>
            <tr style="font-style: italic"><td>Tempat Tanggal Lahir</td><td style="">:</td><td>Pontianak, 03 Maret 1983</td></tr>
            <tr style="font-style: italic"><td>No. KTP</td><td style="">:</td><td>6171060303830001</td></tr>
            <tr style="font-style: italic"><td>Pekerjaan</td><td style="">:</td><td>Direktur</td></tr>
            <tr><td></td><td colspan=10>Dalam hal ini mewakili <b>PT. Mitra Sejahtera Propertiland</b> dan selaku perusahaan. selanjutnya disebut sebagai :</td></tr>
            </tbody>
          </table>
          <div style="font-weight: bold">--------------------------------------------  PIHAK PERTAMA.</div><br>
          <table style="">
            <tbody>
            <tr style="font-weight: bold"><td>Pihak 2</td><td style="">:</td><td><?php echo $row->nama_pemesan?></td></tr>
            <tr style="font-style: italic"><td>Alamat sekarang / di</td><td style="">:</td><td><?php echo $row->alamat_lengkap?></td></tr>
            <tr style="font-style: italic"><td>Nomor telp rumah / HP</td><td style="">:</td><td><?php echo $row->telp_hp?></td></tr>
            <tr><td></td><td colspan=10>Dalam hal ini bertindak selaku pembeli, selanjutnya disebut sebagai:</td></tr>
            </tbody>
          </table>
          <div style="font-weight: bold">--------------------------------------------  PIHAK KEDUA.</div>
          <p style="padding-left: 100px">
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Bahwa PIHAK PERTAMA dengan ini mengikatkan diri untuk menjual, memindahkan dan mengalihkan serta menyerahkan kepada 
              PIHAK KEDUA, dan PIHAK KEDUA dengan ini pula mengikatkan diri dalam perjanjian ini untuk membeli, menerima pemindahan 
              dan pengalihan serta penyerahan dari PIHAK PERTAMA sebuah rumah seluas ± <?php echo $row->luas_bangunan;?> m2 ( lebih kurang <?php echo terbilang($row->luas_bangunan)?> meter persegi ) 
              dan berdiri di atas sebidang tanah seluas ± <?php echo $row->luas_tanah?> m2 ( lebih kurang <?php echo terbilang($row->luas_tanah)?> meter persegi ) yang terletak di  : 
            </div>
            <br>
            <div style="page-break-inside: avoid">
              <table style="padding-left: 60px">
                <tbody>
                <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $row2){?>
                  <tr style=""><td>Desa / Kelurahan</td><td style="">:</td><td><?php echo $row2->nama_jalan?></td></tr>
                  <tr style=""><td>Kecamatan</td><td style="">:</td><td><?php echo $row2->kecamatan?></td></tr>
                  <tr style=""><td>Kabupaten</td><td style="">:</td><td><?php echo $row2->kabupaten?></td></tr>
                  <tr style=""><td>Propinsi</td><td style="">:</td><td><?php echo $row2->provinsi?></td></tr>
                <?php }?>
                </tbody>
              </table>
            </div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Yang dikenal sebagai perumahan “ <?php echo $row->perumahan?> “ nomor kavling <?php echo $row->no_kavling?>
            <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){?>
              , <?php echo $rumah->no_unit?>
            <?php }?>, dengan type Lb / Lt <?php echo $row->luas_bangunan?> / <?php echo $row->luas_tanah?> m<sup>2</sup>, spesifikasi dan gambar terlampir yang telah disetujui dan ditandatangani antara kedua belah pihak pada perjanjian ini.
            </div>
            <div style="text-align: justify; text-justify: inter-word">
              Dengan demikian kedua belah pihak telah bersepakat mengikatkan dirinya masing – masing untuk mengadakan Perjanjian Pendahuluan Perikatan Jual Beli ( PPJB ) dengan syarat - syarat dan ketentuan sebagai berikut :
            <div>
          </p>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 1</div>
            <div style="font-size: 14px; text-align: center">HARGA JUAL</div>
            <br>
            <ol style="text-align: justify; text-justify: inter-word;">
              <li>
                PIHAK PERTAMA mengikatkan untuk menjual, memindahkan dan mengalihkan kepada PIHAK KEDUA dan PIHAK KEDUA membeli, menerima pemindahan serta penyerahan dari PIHAK PERTAMA atas tanah dan bangunan tersebut dengan harga kesepakatan sebesar :
              </li><br><br>
              <table style="padding-left: 40px">
                <tbody>
                  <tr><td>Rp</td><td style="padding-left: 10px">:</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                  <tr><td>Terbilang</td><td style="padding-left: 10px">:</td><td><?php echo terbilang($row->harga_jual)?> Rupiah</td></tr>
                </tbody>
              </table><br>
              <li>
                Harga tersebut belum termasuk Biaya Balik Nama ( BBN ) dan Biaya Perolehan Hak atas Tanah dan Bangunan ( BPHTB ) sesuai dengan peraturan perundangan yang berlaku yang harus dibayarkan sebelum penandatanganan Akte Jual Beli di Notaris. 
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <!-- <div style="page-break-inside: avoid"> -->
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 2</div>
            <div style="font-size: 14px; text-align: center">CARA PEMBAYARAN</div>
            <ol style="text-align: justify; text-justify: inter-word">
              <li>
              PIHAK KEDUA  sanggup  melunasi  pembayaran  tersebut dalam pasal 1 dengan  sistem dan cara pembayaran sebagai berikut : 
              </li>
              <table style="padding-left: 40px">
                <thead>
                  <tr>
                    <td>No</td>
                    <td style="padding-left: 30px">Tahap Pembayaran</td>
                    <td style="padding-left: 50px">Tanggal Pembayaran</td>
                    <td style="padding-left: 70px">Jumlah Pembayaran</td>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach($query as $row3){?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td style="padding-left: 30px"><?php echo $row3->cara_bayar?></td>
                      <?php if($row3->cara_bayar == "KPR"){?>
                        <td style="padding-left: 50px">AKAD BANK</td>
                      <?php } else {?>
                        <td style="padding-left: 50px"><?php echo date("d", strtotime($row3->tanggal_dana))." ".ubahBulan(date("M", strtotime($row3->tanggal_dana)))." ".date("Y", strtotime($row3->tanggal_dana))?></td>
                      <?php }?>
                      <td style="padding-left: 70px">Rp. <?php echo number_format($row3->dana_masuk)?>,-</td>
                    </tr> 
                  <?php $no++; }?>
                </tbody>
              </table>
              <table>
                <tr><td>Rp</td><td style="padding-left: 10px">:</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                <tr><td>Terbilang</td><td style="padding-left: 10px">:</td><td><?php echo terbilang($row->harga_jual)?> Rupiah</td></tr>
              </table><br>
              <li>
                PIHAK KEDUA  menjamin bahwa tahapan pembayaran angsuran ini dilaksanakan oleh PIHAK KEDUA sebelum dan sesudah hari dan tanggal perjanjian ini ditandatangani.
              </li>
              <li>
                Untuk tiap – tiap pembayaran ( angsuran, denda dan bunga ) yang dilakukan PIHAK KEDUA kepada PIHAK PERTAMA, harus dilakukan ke alamat PIHAK PERTAMA atau transfer bank ke rekening PIHAK PERTAMA. Pembayaran melalui cek atau transfer baru dianggap sah diterima setelah dana yang bersangkutan efektif diterima oleh PIHAK PERTAMA dan akan diberikan tanda terima berupa kwitansi oleh PIHAK PERTAMA yang merupakan bagian yang tidak terpisahkan dari isi perjanjian ini.
              </li>
            </ol>
          <!-- </div> -->
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 3</div>
            <div style="font-size: 14px; text-align: center">KETERLAMBATAN DAN PEMBAYARAN DENDA</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                PIHAK KEDUA harus membayar segala pembayaran yang telah disepakati kepada PIHAK PERTAMA sesuai dengan jadwal yang telah disepakati. 
              </li>
              <li>
                Bilamana PIHAK KEDUA membayar kewajibannya melebihi batas waktu tersebut di atas, maka PIHAK KEDUA harus membayar denda sebesar 2,5 % ( dua koma lima persen ) perbulan dari nilai pembayaran yang terlambat dan dihitung secara proporsional harian sejak tanggal jatuh tempo pembayaran dari jadwal yang disepakati di atas.
              </li>
              <li>
                Untuk keterlambatan yang berlangsung 3(tiga) bulan, maka perjanjian ini dianggap batal dan PIHAK KEDUA telah dianggap melepaskan segala hak - haknya termasuk pembayaran tanda jadi dan angsuran yang telah dibayarkan kepada PIHAK PERTAMA, dan PIHAK PERTAMA berhak untuk mengambil alih segala hak - hak tersebut termasuk pembayaran tanda jadi dan angsuran yang telah dibayar oleh PIHAK KEDUA. PIHAK PERTAMA juga dapat mengalihkan hak atas tanah dan bangunan tersebut kepada pihak ketiga.
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 4</div>
            <div style="font-size: 14px; text-align: center">PEMBATALAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Dalam  hal  terjadi  pembatalan  jual  beli yang dilakukan oleh PIHAK KEDUA, kedua belah pihak sepakat untuk mengecualikan ketentuan pasal 1266 dan 1267 Kitab Undang - Undang Hukum Perdata, sehingga hal tersebut tidaklah diperlukan suatu keputusan atau ketetapan Pengadilan Negeri, dan selanjutnya PIHAK KEDUA setuju untuk membayar biaya pembatalan kepada PIHAK PERTAMA dengan perincian sebagai berikut :  
            </div>
            <ol type="a" style="text-align: justify; text-justify: inter-word">
              <li>
                Perusahaan akan mengembalikan dana pembeli yang bersangkutan apabila unit rumah pembeli tersebut sudah ada pembeli baru dengan membayar biaya pembatalan Rp 5.000.000.
              </li>
              <li>
                Dalam hal pembatalan oleh pembeli, apabila tidak mau menunggu sampai unitnya terjual, maka dana akan dikembalikan 50% dari total jumlah dana yang sudah disetorkan oleh pembeli.
              </li>
              <li>
                Dalam hal take over oleh pembeli lain yang pengganti nya adalah dari pembeli unit itu sendiri, maka biaya pembatalan adalah Rp 0 dengan syarat, Pembeli penganti tetap melanjutkan pembayaran sesuai dengan kesepakatan awal dan dana pembeli pertama sepenuhnya dikembalikan oleh pembeli penganti.
              </li>
              <li>
                Dalam hal perubahan cara bayar menjadi KPR, maka pembeli diberikan waktu maksimal 3 (tiga) bulan.
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 5</div>
            <div style="font-size: 14px; text-align: center">PEMBANGUNAN</div>
            <br>
            <ol type="a" style="line-height: 50px; text-align: justify; text-justify: inter-word">
              <li>
                PIHAK PERTAMA akan melaksanakan pembangunan fisik rumah dimulai atas kesepakatan para pihak dengan melihat kesiapan di lapangan dan PIHAK KEDUA telah membayar 50% dari harga jual yang telah disepakati.
              </li>
              <li>
                PIHAK PERTAMA  berkewajiban menyelesaikan pembangunan rumah milik PIHAK KEDUA  dalam jangka waktu selambat – lambatnya 120 (seratus dua puluh) hari dihitung sejak pembayaran dalam pasal 6 ayat 1 terpenuhi. Bila dalam jangka waktu yang telah ditentukan PIHAK PERTAMA belum menyelesaikan pembangunan rumah tersebut, maka PIHAK KEDUA pada bulan setelah bulan penyelesaian rumah yang telah ditentukan dalam adendum akan mendapat ganti - rugi atas keterlambatan penyelesaian PIHAK PERTAMA sebesar 0,05 % ( nol koma nol lima persen ) per hari dari total uang yang telah dibayarkan oleh PIHAK KEDUA kepada PIHAK PERTAMA, dengan nilai setinggi - tingginya sebesar 2% ( dua persen ) dari total uang yang telah dibayarkan PIHAK KEDUA kepada PIHAK PERTAMA.
              </li>
              <li>
                Dalam hal terjadi keterlambatan masa pembangunan sebagaimana diatur dalam pasal 6 ayat 2 perjanjian ini, dikecualikan untuk hal – hal yang di luar kemampuan PIHAK PERTAMA, yakni sambungan listrik dan air yang sepenuhnya tergantung pada ketersediaan jaringan, daya meter dan meter dari pihak PLN atau instansi yang berwenang untuk itu.
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 6</div>
            <div style="font-size: 14px; text-align: center">SERAH TERIMA BANGUNAN</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word; line-height: 50px;">
              <li>
                PIHAK KEDUA menerima dan setuju penyerahan bangunan rumah ( serah terima kunci ) dari PIHAK PERTAMA dilaksanakan, apabila PIHAK KEDUA telah melunasi seluruh kewajibannya kepada PIHAK PERTAMA seperti tercantum dalam pasal 2 perjanjian ini. Sebelum diadakan serah terima dari PIHAK PERTAMA kepada PIHAK KEDUA, maka PIHAK KEDUA tidak diperkenankan melakukan hal - hal sebagai berikut :
                <ul>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk melaksanakan pembangunan, mengubah maupun menambah bangunan, baik yang dilaksanakan sendiri maupun melalui pihak ketiga.
                  </li>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk menempati bangunan atau menempatkan pihak ketiga dengan alasan apapun di lokasi pembangunan.
                  </li>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk memasukkan dan / atau menempatkan barang apapun juga di lokasi pembangunan.
                  </li>
                </ul>
              </li>
              <li>
                Penyerahan kunci rumah akan dibuatkan dengan Berita Acara Serah Terima Rumah tersendiri yang merupakan bagian yang tidak terpisahkan dari perjanjian ini. Sejak diserahkannya bangunan dari PIHAK PERTAMA kepada PIHAK KEDUA, maka segala biaya - biaya yang berkaitan dengan fasilitas pada bangunan tersebut menjadi tanggung jawab PIHAK KEDUA. 
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 7</div>
            <div style="font-size: 14px; text-align: center">JAMINAN PIHAK PERTAMA</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                PIHAK PERTAMA menjamin kepada PIHAK KEDUA bahwa pada saat akan diserahkannya bangunan rumah tersebut kepada  PIHAK KEDUA, tanah dan rumah tersebut  adalah benar - benar dibawah penguasaan dan / atau pengelolaan PIHAK PERTAMA dan bebas dari sitaan, ikatan dan beban apapun lainnya serta tidak dipergunakan  sebagai jaminan hutang dengan  cara apapun.
              </li>
              <li>
                PIHAK PERTAMA akan memberikan jaminan kepada PIHAK KEDUA selama 60 ( enam puluh ) hari apabila terjadi kerusakan yang disebabkan oleh kelalaian PIHAK PERTAMA sejak penandatanganan realisasi penyerahan rumah ( Berita Acara Penyerahan Rumah ), kecuali bila terjadi force majeur ( bencana alam, huru hara, pemogokan, perang, kebakaran ). Bila telah melewati jangka waktu dan masa perawatan 60 ( enam puluh ) hari terjadi keluhan / complain, maka akan menjadi tanggung jawab PIHAK KEDUA secara penuh.
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 8</div>
              <div style="font-size: 14px; text-align: center">BIAYA TRANSAKSI JUAL BELI</div>
              <br>
              <ol type="1" style="text-align: justify; text-justify: inter-word">
                <li>
                  Setelah pembangunan rumah yang dijanjikan selesai, maka PIHAK PERTAMA  berkewajiban  untuk mengalihkan hak atas tanah  dimana  rumah tersebut berdiri kepada  PIHAK KEDUA  dan untuk biaya Akta Jual Beli ( AJB ), biaya Balik Nama ( BBN ) serta Biaya Perolehan Hak atas Tanah dan Bangunan ( BPHTB ) akan dibayar oleh masing – masing pihak mengikuti peraturan perundang - undangan yang berlaku.
                </li>
                <li>
                  Status hak atas tanah sepenuhnya menyesuaikan dengan ketentuan peraturan yang berlaku dimana lokasi rumah ini berada dan Badan Pertanahan Nasional ( BPN ) setempat. Apabila dikemudian hari ada penurunan/peningkatan hak, maka biaya sepenuhnya adalah tanggung jawab pembeli.
                </li>
              </ol>
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 9</div>
            <div style="font-size: 14px; text-align: center">PAJAK PERTAMBAHAN NILAI</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Apabila di kemudian hari terdapat keharusan dalam pemungutan PPN oleh Negara maka PIHAK PERTAMA akan membantu memungut kepada PIHAK KEDUA dan membayarkannya kepada negara sesuai dengan peraturan perundang undangan yang berlaku.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 10</div>
            <div style="font-size: 14px; text-align: center">MUSYAWARAH HAL-HAL YANG BELUM DIATUR DALAM PERJANJIAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Hal – hal yang belum diatur dalam perjanjian ini oleh PIHAK PERTAMA dan PIHAK KEDUA akan diatur dan ditetapkan dikemudian hari, dengan syarat disetujui dan ditandatangani bersama oleh kedua belah pihak dan merupakan bagian yang tidak terpisahkan dari perjanjian ini. Apabila di kemudian hari ternyata terdapat kesalahan dan kekeliruan dalam perjanjian ini akan diadakan perubahan dan pembetulan sebagaimana mestinya.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 11</div>
            <div style="font-size: 14px; text-align: center">PENYELESAIAN PERSELISIHAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Apabila terjadi perselisihan mengenai isi perjanjian ini, para pihak sepakat akan menyelesaikan secara musyawarah, dan apabila tidak mencapai kesepakatan maka akan diselesaikan melalui jalur arbitrase dengan menundukkan diri pada Badan Arbitrase Nasional Indonesia (BANI) Pontianak.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 12</div>
            <div style="font-size: 14px; text-align: center">TAMBAHAN</div>
            <br>
            <div>
              <?php 
                if($row->catatan != ""){
                  echo "Dalam pasal ini menerangkan bahwa Pihak Kedua mendapat ".$row->catatan;
                }
              ?>
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 13</div>
            <div style="font-size: 14px; text-align: center">PENUTUP</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              PIHAK PERTAMA dan PIHAK KEDUA menyatakan dengan sungguh-sungguh bahwa perjanjian pendahuluan tentang pengikatan jual beli ini dibuat dengan tanpa adanya paksaan dari pihak manapun, dan merupakan perjanjian terakhir yang menghapus perjanjian sebelumnya baik lisan maupun tertulis. Demikian perjanjian ini dibuat rangkap 2 dimana masing-masing bermeterai cukup dan mempunyai kekuatan hukum yang sama.
            </div>
          </div>
        </p>
      <!-- END OF CASH -->

      <!-- START OF TEMPO -->
      <?php } else {?>
        <p>
          <div style="font-size: 20px; font-weight: bold">
            PENJELASAN AWAL SEBELUM PERJANJIAN 
          </div>
          <div style="font-size: 11px; text-align: justify; text-justify: inter-word;">
            <i>Halaman ini dipergunakan marketing sebagai acuan dan koreksi dalam pembacaan isi perjanjian yang dijelaskan langsung kepada calon pembeli atau yang mewakili. Dalam tiap pasal PPJB harus diparaf oleh marketing dan calon pembeli.</i>
          </div>
          <div> <br>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">PERJANJIAN PENDAHULUAN JUAL BELI</span> </div> 
            <table style="font-size: 12px">
              <tbody>
                <tr><td style="font-weight: bold">Umum</td><td style="padding-left:20px; white-space: nowrap;">Lokasi perumahan dan letak kavling</td><td style="text-align: right; padding-left:210px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Surat tanah dan luas tanah kavling</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Type / luas bangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 1</td><td style="padding-left:20px; white-space: nowrap;">Harga jual</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Biaya Balik Nama ( BBN )  dan pajak pembelian ( BPHTB )</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 2</td><td style="padding-left:20px; white-space: nowrap;">Sistem pembayaran</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 3</td><td style="padding-left:20px; white-space: nowrap;">Pembelian dengan fasilitas Kredit Pemilikan Rumah ( KPR )</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 4</td><td style="padding-left:20px; white-space: nowrap;">Keterlambatan pembayaran dan denda</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 5</td><td style="padding-left:20px; white-space: nowrap;">Pembatalan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 6</td><td style="padding-left:20px; white-space: nowrap;">Pembangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 7</td><td style="padding-left:20px; white-space: nowrap;">Serah terima bangunan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 8</td><td style="padding-left:20px; white-space: nowrap;">Jaminan PIHAK PERTAMA</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 9</td><td style="padding-left:20px; white-space: nowrap;">Biaya transaksi jual beli</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 10</td><td style="padding-left:20px; white-space: nowrap;">Pajak Pertambahan Nilai (PPN)</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 11</td><td style="padding-left:20px; white-space: nowrap;">Musyawarah dalam hal – hal yang belum diatur dalam perjanjian</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 12</td><td style="padding-left:20px; white-space: nowrap;">Penyelesain perselisihan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 13</td><td style="padding-left:20px; white-space: nowrap;">Tambahan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Pasal 14</td><td style="padding-left:20px; white-space: nowrap;">Penutup</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold">Lampiran</td><td style="padding-left:20px; white-space: nowrap;">Lampiran spesifikasi gambar</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
                <tr><td style="font-weight: bold"></td><td style="padding-left:20px; white-space: nowrap;">Nomor rekening yang digunakan</td><td style="text-align: right; padding-left:200px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div><br>
          <div>
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">SPESIFIKASI MATERIAL FINISHING</span></div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan atap</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan plafond</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan Pintu, jendela dan alat pengunci</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan sanitasi</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan keramik lantai</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan cat</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan listrik</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:20px; white-space: nowrap;"><li>Pekerjaan Lain-lain</li></td><td style="text-align: right; padding-left:380px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div><br>
          <div> 
            <div style="font-size: 20px">Penjelasan tentang <span style="font-weight: bold">GAMBAR STANDART</span></div>
            <table style="font-size: 12px">
              <tbody>
              <tr><td style="padding-left:5px; white-space: nowrap;">1. Site Plan</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">2. Denah, ukuran ruang dan elevasi lantai</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">3. Tampak depan, tampak samping kanan dan kiri</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">4. Rencana pondasi</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">5. Penempatan titik lampu dan stop kontak</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">6. Saluran air bersih, meliputi penempatan :</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Sumur / Pengolahan air mandiri</li></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Septictank</li><ol></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Sumur peresapan</li></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:30px; white-space: nowrap;"><li>Kran air bersih</li><ol></td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              </tbody>
            </table>
          </div>
        </p>
          <br>
        <p>
        <div style="page-break-inside: avoid">
            <div style="text-align: right"><i>Pontianak, <?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></i></div>
            <div style="font-size: 12px; text-align: justify; text-justify: inter-word;"><br><i>Saya menyatakan telah membacakan dan menjelaskan dengan baik seluruh isi dokumen Perjanjian Pendahuluan Jual Beli (PPJB) berikut lampiran yang ada.</i></div><br>
            <table style="padding-left: 20px; table-layout: fixed; width: 60%">
              <tbody>
                <tr><td style="white-space: nowrap;">Tanggal</td><td style="">:</td><td><?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></td></tr>
                <tr><td style="white-space: nowrap;">Nama</td><td style="">:</td><td><?php echo $row->nama_marketing?></td></tr>
                <tr>
                  <td style="white-space: nowrap;">Tanda tangan</td>
                  <td style="">:</td>
                  <td>
                    <div style="width:300px;height:100px;border:1px solid #000;">
                      <?php if($row->marketing_sign != ""){?>
                        <img src="./gambar/signature/ppjb/<?php echo $row->marketing_sign?>" style="padding-left: 5px; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; width: 200px; height: 90px">
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table> 
          </div>
          <div style="font-size: 12px; text-align: justify; text-justify: inter-word;"><br><i>Saya menyatakan telah menerima penjelaskan dengan baik seluruh isi dokumen Perjanjian Pendahuluan Jual Beli (PPJB) berikut lampiran yang ada.</i></div><br>
          <div style="page-break-inside: avoid">
            <table style="padding-left: 20px; table-layout: fixed; width: 60%">
              <tbody>
                <tr><td style="white-space: nowrap;">Tanggal</td><td style="padding-left: 40px">:</td><td><?php echo date("d")." ".ubahBulan(date("M"))." ".date("Y")?></td></tr>
                <tr><td style="white-space: nowrap;">Nama</td><td style="padding-left: 40px">:</td><td><?php echo $row->nama_pemesan?></td></tr>
                <tr>
                  <td style="white-space: nowrap;">Tanda tangan</td>
                  <td style="padding-left: 40px">:</td>
                  <td>
                    <div style="width:300px;height:100px;border:1px solid #000;">
                      <?php if($row->konsumen_sign != ""){?>
                        <img src="./gambar/signature/ppjb/<?php echo $row->konsumen_sign?>" style="padding-left: 5px; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; width: 200px; height: 90px">
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table> 
          </div><br>
        </p>
          <br><br>
        <p>
          <div style="font-weight: bold; font-size: 20px; text-align: center">PERJANJIAN PENDAHULUAN JUAL BELI – PPJB</div><br>
          <div style="font-weight: bold; font-size: 13px; text-align: center">No : 1-<?php echo $row->no_psjb?>/PPJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m")?>/<?php echo date("Y")?></div><br><br>
          <div style="text-align: justify; text-justify: inter-word;">Pada hari ini, <?php echo ubahHari(date("D"))?> tanggal <?php echo date("d")?> bulan <?php echo ubahBulan(date("M"))?> tahun <?php echo date("Y")?> (<?php echo terbilang(date("Y"))?>) yang bertanda - tangan di bawah ini dengan diketahui para saksi yang akan turut menandatangani perjanjian ini :</div>
          <table style="">
            <tbody>
            <tr style="font-weight: bold"><td>Pihak 1</td><td style="">:</td><td>Harry Afandy</td></tr>
            <tr style="font-style: italic"><td>Tempat Tanggal Lahir</td><td style="">:</td><td>Pontianak, 03 Maret 1983</td></tr>
            <tr style="font-style: italic"><td>No. KTP</td><td style="">:</td><td>6171060303830001</td></tr>
            <tr style="font-style: italic"><td>Pekerjaan</td><td style="">:</td><td>Direktur</td></tr>
            <tr><td></td><td colspan=10>Dalam hal ini mewakili <b>PT. Mitra Sejahtera Propertiland</b> dan selaku perusahaan. selanjutnya disebut sebagai :</td></tr>
            </tbody>
          </table>
          <div style="font-weight: bold">--------------------------------------------  PIHAK PERTAMA.</div><br>
          <table style="">
            <tbody>
            <tr style="font-weight: bold"><td>Pihak 2</td><td style="">:</td><td><?php echo $row->nama_pemesan?></td></tr>
            <tr style="font-style: italic"><td>Alamat sekarang / di</td><td style="">:</td><td><?php echo $row->alamat_lengkap?></td></tr>
            <tr style="font-style: italic"><td>Nomor telp rumah / HP</td><td style="">:</td><td><?php echo $row->telp_hp?></td></tr>
            <tr><td></td><td colspan=10>Dalam hal ini bertindak selaku pembeli, selanjutnya disebut sebagai:</td></tr>
            </tbody>
          </table>
          <div style="font-weight: bold">--------------------------------------------  PIHAK KEDUA.</div>
          <p style="padding-left: 100px">
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Bahwa PIHAK PERTAMA dengan ini mengikatkan diri untuk menjual, memindahkan dan mengalihkan serta menyerahkan kepada 
              PIHAK KEDUA, dan PIHAK KEDUA dengan ini pula mengikatkan diri dalam perjanjian ini untuk membeli, menerima pemindahan 
              dan pengalihan serta penyerahan dari PIHAK PERTAMA sebuah rumah seluas ± <?php echo $row->luas_bangunan;?> m2 ( lebih kurang <?php echo terbilang($row->luas_bangunan)?> meter persegi ) 
              dan berdiri di atas sebidang tanah seluas ± <?php echo $row->luas_tanah?> m2 ( lebih kurang <?php echo terbilang($row->luas_tanah)?> meter persegi ) yang terletak di  : 
            </div>
            <br>
            <div style="page-break-inside: avoid">
              <table style="padding-left: 60px">
                <tbody>
                <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $row2){?>
                  <tr style=""><td>Desa / Kelurahan</td><td style="">:</td><td><?php echo $row2->nama_jalan?></td></tr>
                  <tr style=""><td>Kecamatan</td><td style="">:</td><td><?php echo $row2->kecamatan?></td></tr>
                  <tr style=""><td>Kabupaten</td><td style="">:</td><td><?php echo $row2->kabupaten?></td></tr>
                  <tr style=""><td>Propinsi</td><td style="">:</td><td><?php echo $row2->provinsi?></td></tr>
                <?php }?>
                </tbody>
              </table>
            </div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Yang dikenal sebagai perumahan “ <?php echo $row->perumahan?> “ nomor kavling <?php echo $row->no_kavling?>
            <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){?>
              , <?php echo $rumah->no_unit?>
            <?php }?>, dengan type Lb / Lt <?php echo $row->luas_bangunan?> / <?php echo $row->luas_tanah?> m<sup>2</sup>, spesifikasi dan gambar terlampir yang telah disetujui dan ditandatangani antara kedua belah pihak pada perjanjian ini.
            </div>
            <div style="text-align: justify; text-justify: inter-word">
              Dengan demikian kedua belah pihak telah bersepakat mengikatkan dirinya masing – masing untuk mengadakan Perjanjian Pendahuluan Perikatan Jual Beli ( PPJB ) dengan syarat - syarat dan ketentuan sebagai berikut :
            <div>
          </p>
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 1</div>
            <div style="font-size: 14px; text-align: center">HARGA JUAL</div>
            <br>
            <ol style="text-align: justify; text-justify: inter-word">
              <li>
                PIHAK PERTAMA mengikatkan untuk menjual, memindahkan dan mengalihkan kepada PIHAK KEDUA dan PIHAK KEDUA membeli, menerima pemindahan serta penyerahan dari PIHAK PERTAMA atas tanah dan bangunan tersebut dengan harga kesepakatan sebesar :
              </li><br><br>
              <table style="padding-left: 40px">
                <tbody>
                  <tr><td>Rp</td><td style="padding-left: 10px">:</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                  <tr><td>Terbilang</td><td style="padding-left: 10px">:</td><td><?php echo terbilang($row->harga_jual)?> Rupiah</td></tr>
                </tbody>
              </table><br>
              <li>
                Harga tersebut belum termasuk Biaya Balik Nama ( BBN ) dan Biaya Perolehan Hak atas Tanah dan Bangunan ( BPHTB ) sesuai dengan peraturan perundangan yang berlaku yang harus dibayarkan sebelum penandatanganan Akte Jual Beli di Notaris. 
              </li>
            </ol>
          </div>
        </p>
          <br>
        <p>
          <!-- <div style="page-break-inside: avoid"> -->
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 2</div>
            <div style="font-size: 14px; text-align: center">CARA PEMBAYARAN</div>
            <!-- <br> -->
            <ol style="text-align: justify; text-justify: inter-word">
              <li>
              PIHAK KEDUA  sanggup  melunasi  pembayaran  tersebut dalam pasal 1 dengan  sistem dan cara pembayaran sebagai berikut : 
              </li>
              <table style="padding-left: 40px">
                <thead>
                  <tr>
                    <td>No</td>
                    <td style="padding-left: 30px">Tahap Pembayaran</td>
                    <td style="padding-left: 50px">Tanggal Pembayaran</td>
                    <td style="padding-left: 70px">Jumlah Pembayaran</td>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach($query as $row3){?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td style="padding-left: 30px"><?php echo $row3->cara_bayar?></td>
                        <?php if($row3->cara_bayar == "KPR"){?>
                          <td style="padding-left: 50px">AKAD BANK</td>
                        <?php } else {?>
                          <td style="padding-left: 50px"><?php echo date("d", strtotime($row3->tanggal_dana))." ".ubahBulan(date("M", strtotime($row3->tanggal_dana)))." ".date("Y", strtotime($row3->tanggal_dana))?></td>
                        <?php }?>
                        <td style="padding-left: 70px">Rp. <?php echo number_format($row3->dana_masuk)?>,-</td>
                    </tr> 
                  <?php $no++;}?>
                </tbody>
              </table> <br>
              <table>
                <tr><td>Rp</td><td style="padding-left: 10px">:</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                <tr><td>Terbilang</td><td style="padding-left: 10px">:</td><td><?php echo terbilang($row->harga_jual)?> Rupiah</td></tr>
              </table><br>
              <li>
                PIHAK KEDUA  menjamin bahwa tahapan pembayaran angsuran ini dilaksanakan oleh PIHAK KEDUA sebelum dan sesudah hari dan tanggal perjanjian ini ditandatangani.
              </li>
              <li>
                Untuk tiap – tiap pembayaran ( angsuran, denda dan bunga ) yang dilakukan PIHAK KEDUA kepada PIHAK PERTAMA, harus dilakukan ke alamat PIHAK PERTAMA atau transfer bank ke rekening PIHAK PERTAMA. Pembayaran melalui cek atau transfer baru dianggap sah diterima setelah dana yang bersangkutan efektif diterima oleh PIHAK PERTAMA dan akan diberikan tanda terima berupa kwitansi oleh PIHAK PERTAMA yang merupakan bagian yang tidak terpisahkan dari isi perjanjian ini.
              </li>
            </ol>
          <!-- </div> -->
        </p>
          <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 3</div>
            <div style="font-size: 14px; text-align: center">PEMBELIAN DENGAN FASILITAS KREDIT CASH TEMPO</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                Pembayaran Down Payment (DP) harus dibayarkan lunas selambat-lambatnya 14 (empat belas) hari semenjak tanggal pembayaran tanda jadi atau booking fee. Apabila melebihi 14 hari maka calon pembeli dianggap telah membatalkan perjanjian ini dan uang tanda jadi atau booking fee tidak dapat diambil kembali, dikecualikan ada kesepakatan tertulis mengenai tata cara pembayaran Down Payment.
              </li>
              <li>
                Pembayaran Cash tempo dengan syarat dan ketentuan berlaku :
                <ol type="a" style="text-align: justify; text-justify: inter-word">
                  <li>
                    Cash tempo 12 bulan tanpa bunga dengan DP minimal 20% dari harga jual kesepakatan.
                  </li>
                  <li>
                    Cash tempo 24 bulan dengan bunga 10% pertahun dengan DP minimal 30% dari harga jual kesepakatan.
                  </li>
                  <li>
                    Cash tempo 36 bulan dengan bunga 12% pertahun dengan DP minimal 30% dari harga jual kesepakatan.
                  </li>
                </ol>
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 4</div>
            <div style="font-size: 14px; text-align: center">KETERLAMBATAN DAN PEMBAYARAN DENDA</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                PIHAK KEDUA harus membayar segala pembayaran yang telah disepakati kepada PIHAK PERTAMA sesuai dengan jadwal yang telah disepakati. 
              </li>
              <li>
                Bilamana PIHAK KEDUA membayar kewajibannya melebihi batas waktu tersebut di atas, maka PIHAK KEDUA harus membayar denda sebesar 2,5 % ( dua koma lima persen ) perbulan dari nilai pembayaran yang terlambat dan dihitung secara proporsional harian sejak tanggal jatuh tempo pembayaran dari jadwal yang disepakati di atas.
              </li>
              <li>
                Untuk keterlambatan yang berlangsung 2 ( dua ) kali angsuran, maka perjanjian ini dianggap batal dan PIHAK KEDUA telah dianggap melepaskan segala hak - haknya termasuk pembayaran tanda jadi dan angsuran yang telah dibayarkan kepada PIHAK PERTAMA, dan PIHAK PERTAMA berhak untuk mengambil alih segala hak - hak tersebut termasuk pembayaran tanda jadi dan angsuran yang telah dibayar oleh PIHAK KEDUA. PIHAK PERTAMA juga dapat mengalihkan hak atas tanah dan bangunan tersebut kepada pihak ketiga.
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 5</div>
            <div style="font-size: 14px; text-align: center">PEMBATALAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Dalam  hal  terjadi  pembatalan  jual  beli yang dilakukan oleh PIHAK KEDUA, kedua belah pihak sepakat untuk mengecualikan ketentuan pasal 1266 dan 1267 Kitab Undang - Undang Hukum Perdata, sehingga hal tersebut tidaklah diperlukan suatu keputusan atau ketetapan Pengadilan Negeri, dan selanjutnya PIHAK KEDUA setuju untuk membayar biaya pembatalan kepada PIHAK PERTAMA dengan perincian sebagai berikut :  
            </div>
            <ol type="a" style="line-height: 50px; text-align: justify; text-justify: inter-word">
              <li>
                Perusahaan akan mengembalikan dana pembeli yang bersangkutan apabila unit rumah pembeli tersebut sudah ada pembeli baru dengan membayar biaya pembatalan Rp 5.000.000.
              </li>
              <li>
                Dalam hal pembatalan oleh pembeli, apabila tidak mau menunggu sampai unitnya terjual, maka dana akan dikembalikan 50% dari total jumlah dana yang sudah disetorkan oleh pembeli.
              </li>
              <li>
                Dalam hal take over oleh pembeli lain yang pengganti nya adalah dari pembeli unit itu sendiri, maka biaya pembatalan adalah Rp 0 dengan syarat, Pembeli penganti tetap melanjutkan pembayaran sesuai dengan kesepakatan awal dan dana pembeli pertama sepenuhnya dikembalikan oleh pembeli penganti.
              </li>
              <li>
                Dalam hal perubahan cara bayar menjadi KPR, maka pembeli diberikan waktu maksimal 3 (tiga) bulan dengan tetap melakukan pembayaran tempo sesuai dengan jadwal sampai dengan akad KPR dilakukan.
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 6</div>
            <div style="font-size: 14px; text-align: center">PEMBANGUNAN</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word; line-height: 50px;">
              <li>
                PIHAK PERTAMA akan melaksanakan pembangunan fisik rumah dimulai atas kesepakatan para pihak dengan melihat kesiapan di lapangan dan PIHAK KEDUA telah membayar 50% dari harga jual yang telah disepakati.
              </li>
              <li>
                PIHAK PERTAMA  berkewajiban menyelesaikan pembangunan rumah milik PIHAK KEDUA  dalam jangka waktu selambat – lambatnya 120 (seratus dua puluh) hari dihitung sejak pembayaran dalam pasal 6 ayat 1 terpenuhi. Bila dalam jangka waktu yang telah ditentukan PIHAK PERTAMA belum menyelesaikan pembangunan rumah tersebut, maka PIHAK KEDUA pada bulan setelah bulan penyelesaian rumah yang telah ditentukan dalam adendum akan mendapat ganti - rugi atas keterlambatan penyelesaian PIHAK PERTAMA sebesar 0,05 % ( nol koma nol lima persen ) per hari dari total uang yang telah dibayarkan oleh PIHAK KEDUA kepada PIHAK PERTAMA, dengan nilai setinggi - tingginya sebesar 2% ( dua persen ) dari total uang yang telah dibayarkan PIHAK KEDUA kepada PIHAK PERTAMA.
              </li>
              <li>
                Dalam hal terjadi keterlambatan masa pembangunan sebagaimana diatur dalam pasal 6 ayat 2 perjanjian ini, dikecualikan untuk hal – hal yang di luar kemampuan PIHAK PERTAMA, yakni sambungan listrik dan air yang sepenuhnya tergantung pada ketersediaan jaringan, daya meter dan meter dari pihak PLN atau instansi yang berwenang untuk itu.
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 7</div>
            <div style="font-size: 14px; text-align: center">SERAH TERIMA BANGUNAN</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word; line-height: 50px;">
              <li>
                PIHAK KEDUA menerima dan setuju penyerahan bangunan rumah ( serah terima kunci ) dari PIHAK PERTAMA dilaksanakan, apabila PIHAK KEDUA telah melunasi seluruh kewajibannya kepada PIHAK PERTAMA seperti tercantum dalam pasal 2 perjanjian ini. Sebelum diadakan serah terima dari PIHAK PERTAMA kepada PIHAK KEDUA, maka PIHAK KEDUA tidak diperkenankan melakukan hal - hal sebagai berikut :
                <ul>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk melaksanakan pembangunan, mengubah maupun menambah bangunan, baik yang dilaksanakan sendiri maupun melalui pihak ketiga.
                  </li>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk menempati bangunan atau menempatkan pihak ketiga dengan alasan apapun di lokasi pembangunan.
                  </li>
                  <li>
                    PIHAK KEDUA tidak diperkenankan untuk memasukkan dan / atau menempatkan barang apapun juga di lokasi pembangunan.
                  </li>
                </ul>
              </li>
              <li>
                Penyerahan kunci rumah akan dibuatkan dengan Berita Acara Serah Terima Rumah tersendiri yang merupakan bagian yang tidak terpisahkan dari perjanjian ini. Sejak diserahkannya bangunan dari PIHAK PERTAMA kepada PIHAK KEDUA, maka segala biaya - biaya yang berkaitan dengan fasilitas pada bangunan tersebut menjadi tanggung jawab PIHAK KEDUA. 
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 8</div>
            <div style="font-size: 14px; text-align: center">JAMINAN PIHAK PERTAMA</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                PIHAK PERTAMA menjamin kepada PIHAK KEDUA bahwa pada saat akan diserahkannya bangunan rumah tersebut kepada  PIHAK KEDUA, tanah dan rumah tersebut  adalah benar - benar dibawah penguasaan dan / atau pengelolaan PIHAK PERTAMA dan bebas dari sitaan, ikatan dan beban apapun lainnya serta tidak dipergunakan  sebagai jaminan hutang dengan  cara apapun.
              </li>
              <li>
                PIHAK PERTAMA akan memberikan jaminan kepada PIHAK KEDUA selama 60 ( enam puluh ) hari apabila terjadi kerusakan yang disebabkan oleh kelalaian PIHAK PERTAMA sejak penandatanganan realisasi penyerahan rumah ( Berita Acara Penyerahan Rumah ), kecuali bila terjadi force majeur ( bencana alam, huru hara, pemogokan, perang, kebakaran ). Bila telah melewati jangka waktu dan masa perawatan 60 ( enam puluh ) hari terjadi keluhan / complain, maka akan menjadi tanggung jawab PIHAK KEDUA secara penuh.
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 9</div>
            <div style="font-size: 14px; text-align: center">BIAYA TRANSAKSI JUAL BELI</div>
            <br>
            <ol type="1" style="text-align: justify; text-justify: inter-word">
              <li>
                Setelah pembangunan rumah yang dijanjikan selesai, maka PIHAK PERTAMA  berkewajiban  untuk mengalihkan hak atas tanah  dimana  rumah tersebut berdiri kepada  PIHAK KEDUA  dan untuk biaya Akta Jual Beli ( AJB ), biaya Balik Nama ( BBN ) serta Biaya Perolehan Hak atas Tanah dan Bangunan ( BPHTB ) akan dibayar oleh masing – masing pihak mengikuti peraturan perundang - undangan yang berlaku.
              </li>
              <li>
                Status hak atas tanah sepenuhnya menyesuaikan dengan ketentuan peraturan yang berlaku dimana lokasi rumah ini berada dan Badan Pertanahan Nasional ( BPN ) setempat. Apabila dikemudian hari ada penurunan/peningkatan hak, maka biaya sepenuhnya adalah tanggung jawab pembeli.
              </li>
            </ol>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 10</div>
            <div style="font-size: 14px; text-align: center">PAJAK PERTAMBAHAN NILAI</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Apabila di kemudian hari terdapat keharusan dalam pemungutan PPN oleh Negara maka PIHAK PERTAMA akan membantu memungut kepada PIHAK KEDUA dan membayarkannya kepada negara sesuai dengan peraturan perundang undangan yang berlaku.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 11</div>
            <div style="font-size: 14px; text-align: center">MUSYAWARAH HAL-HAL YANG BELUM DIATUR DALAM PERJANJIAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Hal – hal yang belum diatur dalam perjanjian ini oleh PIHAK PERTAMA dan PIHAK KEDUA akan diatur dan ditetapkan dikemudian hari, dengan syarat disetujui dan ditandatangani bersama oleh kedua belah pihak dan merupakan bagian yang tidak terpisahkan dari perjanjian ini. Apabila di kemudian hari ternyata terdapat kesalahan dan kekeliruan dalam perjanjian ini akan diadakan perubahan dan pembetulan sebagaimana mestinya.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 12</div>
            <div style="font-size: 14px; text-align: center">PENYELESAIAN PERSELISIHAN</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              Apabila terjadi perselisihan mengenai isi perjanjian ini, para pihak sepakat akan menyelesaikan secara musyawarah, dan apabila tidak mencapai kesepakatan maka akan diselesaikan melalui jalur arbitrase dengan menundukkan diri pada Badan Arbitrase Nasional Indonesia (BANI) Pontianak.
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 13</div>
            <div style="font-size: 14px; text-align: center">TAMBAHAN</div>
            <br>
            <div>
              <?php 
                if($row->catatan != ""){
                  echo "Dalam pasal ini menerangkan bahwa Pihak Kedua mendapat ".$row->catatan;
                }
              ?>
            </div>
          </div>
        </p>
        <br>
        <p>
          <div style="page-break-inside: avoid">
            <div style="font-weight: bold; font-size: 18px; text-align: center">PASAL 14</div>
            <div style="font-size: 14px; text-align: center">PENUTUP</div>
            <br>
            <div style="text-align: justify; text-justify: inter-word">
              PIHAK PERTAMA dan PIHAK KEDUA  menyatakan dengan sungguh - sungguh bahwa perjanjian pendahuluan tentang pengikatan jual beli ini dibuat dengan tanpa adanya paksaan dari pihak manapun, dan merupakan perjanjian terakhir yang menghapus perjanjian sebelumnya baik lisan maupun tertulis. Demikian perjanjian ini dibuat rangkap 2 dimana masing - masing bermeterai cukup dan mempunyai kekuatan hukum yang sama. 
            </div>
          </div>
        </p>
      <?php }?>
      <!-- END OF TEMPO -->
      <p>
        <br>
        <div style="page-break-inside: avoid">
          <table style="width: 100%; table-layout: fixed">
            <tr>
              <td>PIHAK KEDUA</td>
              <td style="text-align: center;">PIHAK PERTAMA</td>
            </tr>
            <!-- <div>PIHAK KEDUA<span style="padding-left: 350px">PIHAK PERTAMA</span></div> -->
            <tr>
              <td>
                <?php if($row->konsumen_sign != ""){?>
                  <img src="./gambar/signature/ppjb/<?php echo $row->konsumen_sign?>" style="height: 90px; width: 150px">
                <?php } else {?>
                  <br><br><br><br>
                <?php } ?>
              </td>
              <td style="text-align: center;">
                <?php if($row->owner_sign != ""){?>
                  <img src="./gambar/signature/ppjb/<?php echo $row->owner_sign?>" style="height: 90px; width: 150px">
                <?php } else {?>
                  <br><br><br><br>
                <?php }?>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold;"><?php echo $row->nama_pemesan?></td>
              <td style="text-align: center; font-weight: bold">Harry Afandy</td>
            </tr>
          </table>
        </div>
          <br>
          <!-- <div style="font-weight: bold;"><?php echo $row->nama_pemesan?> <span style="padding-left: 350px; font-weight: bold">Harry Afandy</span></div> -->
        <div style="page-break-inside: avoid">
          <table style="width: 100%; table-layout: fixed">
            <tr>
              <td>Saksi-saksi:</td>
              <td></td>
            </tr>
            <tr>
              <td><i>Marketing</i></td>
              <td></td>
            </tr>
            <tr>
              <td>
                <?php if($row->marketing_sign != ""){?>
                  <img src="./gambar/signature/ppjb/<?php echo $row->marketing_sign?>" style="width: 150px; height: 90px" >
                <?php } else {?>
                  <br><br><br><br>
                <?php }?>
              </td>
            </tr>
            <tr style="font-weight: bold">
              <td><?php echo $row->nama_marketing?></td>
              <td style="text-align: center">....................................</td>
            </tr>
          </table>
          <!-- <br><br><br><br><br> -->
            <!-- <b><?php echo $row->nama_marketing?><span style="padding-left: 335px">..........................................</span></b></div> -->
        </div>
      <br>
      </p>
        <br>
      <p>
      <div style="page-break-before: always">
        <div style="page-break-inside: avoid">
          <div style="font-weight: bold; font-size: 20px">LAMPIRAN</div>
          <!-- <br> -->
          <div style="font-weight: bold; font-size: 15px">DOKUMEN PERJANJIAN PENDAHULUAN JUAL BELI</div> 
          <table style="padding-left: 10px; font-size: 12px">
            <tbody>
              <tr><td style="padding-left:5px; white-space: nowrap;">1. Sampul</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">2. Spesifikasi Material Finishing</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">3. Site plan</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">4. Denah. ukuran ruang dan elevasi lantai</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">5. Tampak depan, tampak samping kanan</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">6. Rencana pondasi</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">7. Penempatan titik lampu dan stop kontak</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
              <tr><td style="padding-left:5px; white-space: nowrap;">8. Saluran air bersih</td><td style="text-align: right; padding-left:350px;"><input type="checkbox"></td></tr>
            </tbody>
          </table>
        </div>
        <br>
        <div style="page-break-inside: avoid">
          <div style="font-weight: bold; font-size: 15px">NOMOR REKENING YANG DIGUNAKAN:</div>
          <div style="width:600px;height:80px;border:1px solid #000;margin-left: 50px;">
            <table style="padding-left: 50px; font-weight: bold;">
              <tbody>
                <tr><td style="white-space: nowrap;">Nama Bank</td><td style="padding-left: 50px">:</td><td>BCA</td></tr>
                <tr><td></td><td></td><td></td></tr>
                <tr><td style="white-space: nowrap;">No rekening</td><td style="padding-left: 50px">:</td><td>1710.666.977</td></tr>
                <tr><td></td><td></td><td></td></tr>
                <tr><td style="white-space: nowrap;">Atas nama</td><td style="padding-left: 50px">:</td><td>Harry Afandy</td></tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- <br> -->
        <div style="font-weight: bold; font-size: 15px">BIAYA YANG TIMBUL AKIBAT TRANSAKSI</div>
        <!-- <br> -->
        <div style="font-size: 12px; padding-left: 20px">Biaya <b>NOTARIS / PPAT :</b></div>
        <div style="font-size: 12px; padding-left: 35px">Yang menjadi kewajiban <b>PIHAK I / PERUSAHAAN</b></div>
        <div style="font-size: 12px; padding-left: 65px">1. Pengecekan sertifikat</div>
        <div style="font-size: 12px; padding-left: 65px">2. Pajak Perusahaan / PPH</div>
        <!-- <br> -->
        <div style="font-size: 12px; padding-left: 35px">Yang menjadi kewajiban <b>PIHAK II / PEMBELI</b></div>
        <div style="font-size: 12px; padding-left: 65px">1. Biaya Akta Jual Beli / AJB</div>
        <div style="font-size: 12px; padding-left: 65px">2. Biaya Balik Nama / BBN</div>
        <div style="font-size: 14px; padding-left: 65px">3. Pajak Pembelian / BPHTB</div>
        <div style="font-size: 12px; padding-left: 65px">4. Pajak Pertambahan Nilai / PPN (bila ada)</div>
        <!-- <br> -->
        <div style="font-size: 12px; padding-left: 20px">Biaya <b>ADMINISTRASI BANK :</b></div>
        <div style="font-size: 12px; padding-left: 35px">Bila pembayaran dengan KPR maka otomatis menjadi kewajiban PIHAK II / PEMBELI</b></div>
        <div style="font-size: 12px; padding-left: 65px">1. Akta Pengakuan Hak Tanggungan / APHT</div>
        <div style="font-size: 12px; padding-left: 65px">2. Pengurusan pemasangan APHT</div>
        <div style="font-size: 12px; padding-left: 65px">3. Administrasi Bank</div>
        <div style="font-size: 12px; padding-left: 65px">4. Biaya Materai</div>
        <div style="font-size: 12px; padding-left: 65px">5. Provisi</div>
        <div style="font-size: 12px; padding-left: 65px">6. Asuransi Jiwa Kredit</div>
        <div style="font-size: 12px; padding-left: 65px">7. Asuransi Kebakaran</div>
        <br>
        <div style="font-weight: bold; font-size: 15px">UNTUK PENJELASAN DAPAT HUBUNGI BAGIAN PERUSAHAAN :</div>
        <!-- <br> -->
        <table>
          <tr><td>Nama</td><td style="padding-left: 10px">:</td><td>..................................................</td></tr>
          <tr style="margin-top: 20px"><td>Nomor telpon</td><td style="padding-left: 10px">:</td><td>..................................................</td></tr>
        </table>
      </div>
      </p>
    <?php }?>
   </div>
</body></html>