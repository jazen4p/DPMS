<html><head>
   <style>
     @page { margin: 180px 50px 90px; }
     #header { position: fixed; left: 0px; top: -200px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -115px; right: 0px; height: 150px; }
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
        Jl. Perdana No. 168<br/>
        Pontianak - Kalimantan Barat<br/>
        HP: 0813.2793.5678<br/>
      </p>
    <hr>
   </div>
   <div id="footer" style="font-size: 12px">
      <hr style="border-top: 1px solid">
      <!-- <p class="page"> -->
        <table style="width: 100%">
          <tr>
            <td>
              <b><?php echo $pers->nama_perusahaan?><b>
            </td>
            <td style="text-align: right">Surat Perjanjian Pendahuluan Jual Beli Kavling</td>
          </tr>
        </table>
        <div class="page" style="text-align: right"><b>Halaman <?php $PAGE_NUM?></b></div>
      <!-- </p> -->
   </div>
   <div id="content">
      <p>
        <div style="text-align: center">
          <b style="font-size: 18px"><u>Surat Perjanjian Pendahuluan Jual Beli Kavling</u></b> <br>
          No : <?php echo $row->kode_perusahaan."/".date('Y', strtotime($row->tgl_psjb))."/".date('m', strtotime($row->tgl_psjb))."/".sprintf("%03d", $row->no_psjb);?>
        </div>
      </p>
      <br>
      <p style="font-size: 13px">
        <span>Pada hari ini, <?php echo date('d', strtotime($row->tgl_psjb))." ".ubahBulan(date('M', strtotime($row->tgl_psjb)))." ".date('Y', strtotime($row->tgl_psjb))?> kami yang bertanda tangan dibawah ini :</span><br>
        <span>Bapak/Ibu</span>
        <table style="margin-top: -15px; padding-left: 20px; font-size: 13px">
          <tr>
            <td>I.</td>
            <td style="padding-left: 5px">Nama</td>
            <td>:</td>
            <td>Harry Afandy</td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">Tanggal Lahir</td>
            <td>:</td>
            <td>Pontianak, 03 Maret 1983</td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">No. KTP</td>
            <td>:</td>
            <td>6171060303830001</td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">Pekerjaan</td>
            <td>:</td>
            <td>Direktur</td>
          </tr>
        </table>
        <span style="padding-left: 25px; font-size: 13px">
          Dalam hal ini mewakili Perusahaan CV. Mitra Sejahtera dan selanjutnya disebut sebagai <b>Pihak Pertama.</b>
        </span>

        <table style="margin-top: 10px; padding-left: 20px ;font-size: 13px">
          <tr>
            <td>II.</td>
            <td style="padding-left: 5px">Nama</td>
            <td>:</td>
            <td><?php echo $row->nama_pemesan?></td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo date('d', strtotime($row->tgl_lahir))." ".ubahBulan(date('M', strtotime($row->tgl_lahir)))." ".date('Y', strtotime($row->tgl_lahir))?></td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">No. KTP</td>
            <td>:</td>
            <td><?php echo $row->ktp?></td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">Pekerjaan</td>
            <td>:</td>
            <td><?php echo $row->pekerjaan?></td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">Alamat</td>
            <td>:</td>
            <td><?php echo $row->alamat_lengkap?></td>
          </tr>
          <tr>
            <td></td>
            <td style="padding-left: 5px">No. HP/Telp</td>
            <td>:</td>
            <td><?php echo $row->telp_hp?></td>
          </tr>
        </table>
        <span style="padding-left: 20px; font-size: 13px">
          Dalam hal ini mewakili diri sendiri dan selanjutnya disebut sebagai <b>Pihak Kedua.</b>
        </span>
        <div style="margin-top: 10px; padding-left: 20px;font-size: 13px">Sertipikat tanah dengan data sebagai berikut :</div>
        <table style="padding-left: 20px;font-size: 13px">
          <tr>
            <td>SHM induk No</td>
            <td style="padding-left: 20px">:</td>
            <td>
              <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                echo $prmh->shm_induk." / ".$prmh->kecamatan;
              }?>
            </td>
          </tr>
          <tr>
            <td>Lokasi</td>
            <td style="padding-left: 20px">:</td>
            <td>
              <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                echo $prmh->nama_jalan.", ".$prmh->kecamatan.", Kabupaten ".$prmh->kabupaten;
              }?>
            </td>
          </tr>
        </table>
      </p>
      <p style="margin-top: 10px; text-align: justify;font-size: 13px"> 
        Sampai perjanjian ini ditandatangani, Sertipikat dengan keterangan diatas masih dalam satu kesatuan (induk), akan dipecah kavling dan diberikan kepada Pihak Kedua apabila pembayaran sudah lunas dengan kesepakatan jual beli sebagai berikut:
      </p>  

      <!-- START OF Cash -->
      <?php if($row->sistem_pembayaran == "Cash"){?>
        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 1</span> <br>
            <span>Harga dan Angsuran</span>
          </p>
          <div style="text-align: justify; font-size: 13px">Pihak Pertama telah menjual tanah kavling kepada Pihak Kedua dengan CASH sesuai keterangan sebagai berikut :</div>
          <table style="padding-left: 25px; font-size: 13px">
            <tr>
              <td>a.</td>
              <td>Harga Jual</td>
              <td style="padding-left: 30px">:</td>
              <td><?php echo "Rp. ".number_format($row->total_jual - $row->disc_jual, 0, ",", ".")?></td>
            </tr>
            <tr>
              <td>b.</td>
              <td>Blok</td>
              <td style="padding-left: 30px">:</td>
              <td>
                <?php echo $row->no_kavling;
                  foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $rmh){
                    echo ", ".$rmh->kode_rumah;
                  }
                ?>
              <td>
            </tr>
            <tr>
              <td>c.</td>
              <td>Luas</td>
              <td style="padding-left: 30px">:</td>
              <td><?php echo "± ".$row->luas_tanah?> m<sup>2</sup></td>
            </tr>
            <?php if($row->uang_awal != "0"){?>
              <tr>
                <td>d.</td>
                <td>Booking Fee</td>
                <td style="padding-left: 30px">:</td>
                <td><?php echo "Rp. ".number_format($row->uang_awal, 0, ",", ".")?></td>
              </tr>
            <?php }?>
          </table>
        </div>

        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 2</span> <br>
            <span>Penggantian</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Pihak Pertama akan menggantikan tanah kavlingan lainnya kepada Pihak Kedua apabila ada sertifikat ganda/sengketa atau yang dalam pengurusan sertipikatnya tidak selesai dikarenakan sebab apapun, yang luasannya sesuai dengan yang tertera pada Surat Perjanjian ini.</li>
            <li>Dan Pihak Kedua setuju untuk menerima penggantian kavling sebagaimana maksud Pihak Pertama dengan ketentuan lokasi di jalan yang sama dan jarak yang minimal sama atau lebih dekat.</li>
          </ol>
        </div>

        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 3</span> <br>
            <span>Balik Nama, Perawatan dan Patok Kavling</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Setelah sertifikat selesai pemecahan maka Pihak Pertama akan melakukan proses balik nama terhadap pihak kedua, di mana biaya balik nama akan ditanggung oleh <?php if($row->biaya_balik_nama == "free"){echo "Pihak Pertama selaku penjual";} else {echo "Pihak Kedua selaku pembeli";}?>.</li>
            <li>Setelah sertifikat selesai pemecahan, Pihak Pertama akan menunjukkan patok batas tanah kavling yang dimaksud diatas dan pemeliharaanya baik patok maupun kebersihkan lahan merupakan tanggung jawab dari Pihak Kedua sepenuhnya.</li>
          </ol>
        </div>

        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 4</span> <br>
            <span>Rekening Bank</span>
          </p>
          <div style="padding-left: 25px">
            <div>Pembayaran dapat dilakukan melalui transfer Bank</div>
            <div>a. Bank BCA cab. Pontianak an. Harry Afandy No. Rek 1710.666.977</div>
            <div>b. Bank BRI cab. Pontianak an. Harry Afandy No. Rek 0569.01.007935.507</div>
            <div>c. Bank BNI Cabang Pontianak an. Mitra Sejahtera No. Rek 09198.444.43</div>
            <div>Bukti transfer harus ditukarkan dengan kwitansi asli Mitra Sejahtera.</div>
          </div>
        </div>
          <br>
        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 5</span> <br>
            <span>Balik Nama, Perawatan dan Patok Kavling</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Segala sesuatu yang belum diatur dalam Surat Perjanjian ini akan diselesaikan secara kekeluargaan berdasarkan itikad baik antara Pihak Pertama dan Pihak Kedua.</li>
            <li>Apabila tidak terdapat kesepakatan sebagaimana Pasal 5 (Lima) ayat 1 (Satu), maka permasalahan akan diselesaikan Kedua belah pihak dengan menundukkan diri pada Badan Arbitrase Nasional Indonesia (BANI) Jakarta.</li>
            <li>Perjanjian ini dibuat pada hari dan tanggal seperti tersebut diatas, dalam rangkap 2 (dua) bermaterai dan berkekuatan hukum yang sama.</li>
            <li>Surat Perjanjian ini akan batal dengan sendirinya apabila masa kontrak pembayaran perjanjian ini berakhir.</li>
          </ol>
        </div>
          <br>
        <div style="text-align: justify">
          Demikian Perjanjian Jual-Beli ini kami buat atas dasar kesepakatan bersama tanpa ada unsur paksaan dari pihak manapun juga dan ditanda tangani oleh Pihak Pertama dan Pihak Kedua.
        </div>
      <!-- END OF Cash -->

      <!-- START OF TEMPO -->
      <?php } else {?>
        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 1</span> <br>
            <span>Harga dan Angsuran</span>
          </p>
          <div style="text-align: justify; font-size: 13px">Pihak Pertama telah menjual tanah kavling kepada Pihak Kedua dengan keterangan sebagai berikut:</div>
          <table style="padding-left: 25px; font-size: 13px">
            <tr>
              <td>a.</td>
              <td>Harga Jual</td>
              <td style="padding-left: 30px">:</td>
              <td><?php echo "Rp. ".number_format($row->total_jual - $row->disc_jual, 0, ",", ".")?></td>
            </tr>
            <tr>
              <td>b.</td>
              <td>Blok</td>
              <td style="padding-left: 30px">:</td>
              <td>
                <?php echo $row->no_kavling;
                  foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan))->result() as $rmh){
                    echo ", ".$rmh->kode_rumah;
                  }
                ?>
              <td>
            </tr>
            <tr>
              <td>c.</td>
              <td>Luas</td>
              <td style="padding-left: 30px">:</td>
              <td><?php echo "± ".$row->luas_tanah?>m<sup>2</sup></td>
            </tr>
            <?php if($row->uang_awal != "0"){?>
              <tr>
                <td>d.</td>
                <td>Booking Fee</td>
                <td style="padding-left: 30px">:</td>
                <td><?php echo "Rp. ".number_format($row->uang_awal, 0, ",", ".")?></td>
              </tr>
            <?php }?>
            <tr>
              <td>e.</td>
              <td>
                Angsuran ke
                <?php if($row->jumlah_dp > 1){
                  echo "01-".sprintf("%02d", $row->jumlah_dp);
                } else {
                  echo sprintf("%02d", $row->jumlah_dp);
                }?>
              </td>
              <td style="padding-left: 30px">:</td>
              <td><?php echo "Rp. ".number_format($row->total_dp, 0, ",", ".")?></td>
            </tr>
            <tr>
              <td>f.</td>
              <td>
                Angsuran ke
                <?php if($row->jumlah_dp2 > 1){
                  echo sprintf("%02d", $row->jumlah_dp + 1)."-".sprintf("%02d", $row->jumlah_dp + $row->jumlah_dp2);
                } else {
                  echo sprintf("%02d", $row->jumlah_dp + 1);
                }?>
              </td>
              <td style="padding-left: 30px">:</td>
              <td><?php echo "Rp. ".number_format($row->total_kpr, 0, ",", ".")?></td>
            </tr>
            <tr>
              <td>g.</td>
              <td>
                Lama angsuran
              </td>
              <td style="padding-left: 30px">:</td>
              <td><?php echo $row->jumlah_dp + $row->jumlah_dp2?> Bulan</td>
            </tr>
            <?php if($row->biaya_pembersihan != "free"){?>
              <tr>
                <td>h.</td>
                <td>Biaya Pembersihan Lahan</td>
                <td style="padding-left: 30px">:</td>
                <td><?php echo "Rp. 25.000 / 6 bln"?></td>
              </tr>
            <?php }?>
          </table>
        </div>

        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 2</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Pihak Kedua berkewajiban untuk membayar angsuran sebagaimana tersebut pasal 1e, sebelum tanggal jatuh tempo yaitu tanggal dibuatnya surat perjanjian ini dengan membawa Buku Setoran.</li>
            <li>Apabila Pihak Kedua tidak melakukan pembayaran angsuran selama 3 (tiga) bulan dianggap telah melanggar perjanjian, maka uang yang telah disetorkan dianggap hangus.</li>
          </ol>
        </div>

        <div style="margin-top: 20px; page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 3</span> <br>
            <span>Peralihan Konsumen</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Apabila Pihak Kedua bermaksud mengundurkan diri dan tidak melanjutkan kembali jual beli ini, maka semua uang yang telah disetorkan ke Pihak Pertama tidak dapat ditarik kembali dan menjadi hak milik Pihak Pertama.</li>
            <li>Dikecualikan Pihak Kedua digantikan oleh pihak lain dan diketahui oleh Pihak Pertama maka uang telah disetorkan dapat dikembalikan oleh Pihak Pengganti sesuai kesepakatan antara Pihak Kedua dan Pihak Pengganti.</li>
            <li>Kemudian PIhak Ketiga wajib menyelesaikan seluruh tunggakan Pihak Kedua kepada Pihak Pertama dan melakukan kewajiban Pihak Kedua sesuai kesepakatan Pihak Pertama dan Pihak Kedua yang tertuang pada Perjanjian Jual-Beli ini.</li>
          </ol>
        </div>

        <div style="margin-top: 20px; page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 4</span> <br>
            <span>Penggantian</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Pihak Pertama akan menggantikan tanah kavlingan lainnya kepada Pihak Kedua apabila ada sertifikat ganda/sengketa atau yang dalam pengurusan sertipikatnya tidak selesai dikarenakan sebab apapun, yang luasannya sesuai dengan yang tertera pada Surat Perjanjian ini.</li>
            <li>Dan Pihak Kedua setuju untuk menerima penggantian kavling sebagaimana maksud Pihak Pertama dengan ketentuan lokasi di jalan yang sama dan jarak yang minimal sama atau lebih dekat.</li>
          </ol>
        </div>
          
        <div style="margin-top: 20px; page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 5</span> <br>
            <span>Balik Nama, Perawatan dan Patok Kavling</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Setelah sertifikat selesai pemecahan maka Pihak Pertama akan melakukan proses balik nama terhadap pihak kedua, di mana biaya balik nama akan ditanggung oleh <?php if($row->biaya_balik_nama == "free"){echo "Pihak Pertama selaku penjual";} else {echo "Pihak Kedua selaku pembeli";}?>.</li>
            <li>Konsumen yang mana masih dalam masa angsuran dikenakan biaya pemeliharaan lahan kavling sebesar Rp 25.000 (<?php echo penyebut(25000)?> Rupiah) per 6 (enam) bulan sekali dan disetorkan ke Pihak Pertama.</li>
            <li>Setelah masa angsuran selesai, Pihak Pertama akan menunjukkan patok batas tanah kavling yang dimaksud diatas dan pemeliharaannya baik patok maupun kebersihan lahan merupakan tanggung jawab dari Pihak Kedua sepenuhnya.</li>
          </ol>
        </div>

        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 6</span> <br>
            <span>Rekening Bank</span>
          </p>
          <div style="padding-left: 25px">
            <div>Pembayaran dapat dilakukan melalui transfer Bank</div>
            <div>a. Bank BCA cab. Pontianak an. Harry Afandy No. Rek 1710.666.977</div>
            <div>b. Bank BRI cab. Pontianak an. Harry Afandy No. Rek 0569.01.007935.507</div>
            <div>c. Bank BNI Cabang Pontianak an. Mitra Sejahtera No. Rek 09198.444.43</div>
            <div>Bukti transfer harus ditukarkan dengan kwitansi asli Mitra Sejahtera.</div>
          </div>
        </div>
          <br>
        <div style="page-break-inside: avoid">
          <p style="font-weight: bold; font-size: 16px; text-align: center">
            <span>Pasal 7</span> <br>
            <span>Balik Nama, Perawatan dan Patok Kavling</span>
          </p>
          <ol type="1" style="text-align: justify">
            <li>Segala sesuatu yang belum diatur dalam Surat Perjanjian ini akan diselesaikan secara kekeluargaan berdasarkan itikad baik antara Pihak Pertama dan Pihak Kedua.</li>
            <li>Apabila tidak terdapat kesepakatan sebagaimana Pasal 5 (Lima) ayat 1 (Satu), maka permasalahan akan diselesaikan Kedua belah pihak dengan menundukkan diri pada Badan Arbitrase Nasional Indonesia (BANI) Jakarta.</li>
            <li>Perjanjian ini dibuat pada hari dan tanggal seperti tersebut diatas, dalam rangkap 2 (dua) bermaterai dan berkekuatan hukum yang sama.</li>
            <li>Surat Perjanjian ini akan batal dengan sendirinya apabila masa kontrak pembayaran perjanjian ini berakhir.</li>
          </ol>
        </div>
          <br>
        <div style="text-align: justify">
          Demikian Perjanjian Jual-Beli ini kami buat atas dasar kesepakatan bersama tanpa ada unsur paksaan dari pihak manapun juga dan ditanda tangani oleh Pihak Pertama dan Pihak Kedua.
        </div>
      <?php }?>
      <!-- END OF TEMPO -->
      <br><br><br>
      <div style="page-break-inside: avoid">
        <p>
          <div style="page-break-inside: avoid">
            <table style="width: 100%; table-layout: fixed">
              <tr>
                <td style="text-align: center;">Pihak Kedua</td>
                <td style="text-align: center;">Pihak Pertama</td>
              </tr>
              <!-- <div>PIHAK KEDUA<span style="padding-left: 350px">PIHAK PERTAMA</span></div> -->
              <tr>
                <td style="text-align: center;"><b>Pembeli</b></td>
                <td style="text-align: center;"><b>CV. Mitra Sejahtera</b></td>
              </tr>
              <tr>
                <td style="text-align: center;">
                  <?php if($row->konsumen_sign != ""){?>
                    <img src="./gambar/signature/ppjb/<?php echo $row->konsumen_sign?>" style="height: 90px; width: 150px">
                  <?php } else {?>
                    <br><br><br><br><br>
                  <?php } ?>
                </td>
                <td style="text-align: center;">
                  <?php if($row->owner_sign != ""){?>
                    <img src="./gambar/signature/ppjb/<?php echo $row->owner_sign?>" style="height: 90px; width: 150px">
                  <?php } else {?>
                    <br><br><br><br><br>  
                  <?php }?>
                </td>
              </tr>
              <tr>
                <td style="text-align: center">( <u>____________________</u> )</td>
                <td style="text-align: center">( <u>Harry Afandy</u> )</td>
              </tr>
              <tr>
                <td style="text-align: center; font-size: 12px">Nama Jelas</td>
                <td style="text-align: center;">Direktur</td>
              </tr>
            </table>
          </div>
          <br>  
        </p>
      </div>
      <div style="page-break-inside: avoid">
        <p>
          <div><b>SAKSI - SAKSI :</b><br><br></div>
          <table style="width: 55%">
            <tr style="height: 100%">
              <td>1.</td><td>Saski Pihak Pertama</td><td>:</td><td>........................</td><td></td>
            </tr>
            <tr>
              <td><br><br><br><br><br><br><br><br></td><td>Tandatangan</td><td>:</td><td>.....................</td>
            </tr>
            <tr>
              <td>2.</td><td>Saski Pihak Kedua</td><td>:</td><td>........................</td>
            </tr>
            <tr>
              <td><br><br><br><br><br><br><br><br></td><td>Tandatangan</td><td>:</td><td>.....................</td>
            </tr>
          </table>
        </p>
      </div>
    <?php }?>
   </div>
</body></html>