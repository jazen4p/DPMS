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
      $query = $this->db->get_where('perusahaan', array('kode_perusahaan'=>$row->kode_perusahaan));
      foreach($query->result() as $pers) { ?>
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
     <p class="page"><span style="font-weight: bold"><i>Perjanjian Sementara Jual Beli</i></span> <span style="padding-left:410px"> Halaman <?php $PAGE_NUM ?> </span></p>
   </div>
   <div id="content">
     <p>
      <!-- <div style="text-align: right">
        Untuk PEMBELI
      </div> -->
      <div> <br/>
      <div style="font-weight: bold; font-size: 25px">PERJANJIAN SEMENTARA JUAL BELI (PSJB)</div> <br>
        <!-- <table style="padding-left: 60px; border: 1px solid black;"> -->
        <table style="padding-left: 60px">
          <tbody>
          <tr><td style="padding-left: 20px">Nomor PSJB</td><td style="padding-left:50px">:</td><td style="">1-<?php echo $row->no_psjb?>/PSJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m", strtotime($row->tgl_psjb))?>/<?php echo date("Y", strtotime($row->tgl_psjb))?></td></tr>
          <tr><td style="padding-left: 20px">Sistem pembayaran</td><td style="padding-left:50px;">:</td><td><?php echo $row->sistem_pembayaran?></td></tr>
          <tr><td style="padding-left: 20px">Nama marketing</td><td style="padding-left:50px">:</td><td style=""><?php echo $row->nama_marketing?></td></tr>
          
          <!-- <tr><td style="padding-left: 20px; padding-top: 20px">Nomor PSJB</td><td style="padding-left:50px; padding-top: 20px">:</td><td style="padding-top: 20px; padding-right: 20px">1-<?php echo $row->no_psjb?>/PSJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m", strtotime($row->tgl_psjb))?>/<?php echo date("Y", strtotime($row->tgl_psjb))?></td></tr>
          <tr><td style="padding-left: 20px">Sistem pembayaran</td><td style="padding-left:50px;">:</td><td><?php echo $row->sistem_pembayaran?></td></tr>
          <tr><td style="padding-left: 20px; padding-bottom: 20px">Nama marketing</td><td style="padding-left:50px; padding-bottom: 20px">:</td><td style="padding-bottom: 20px"><?php echo $row->nama_marketing?></td></tr> -->
          </tbody>
        </table>
      </div>
     </p>
      <br>
     <p>
      <div style="font-weight: bold; font-size: 17px">Telah diterima dari Calon Pembeli</div> <br>
      <table style="padding-left: 20px;">
        <tbody>
        <tr><td style="white-space: nowrap;">Pada tanggal</td><td style="padding-left: 20px">:</td><td><?php echo date("d",strtotime($row->tgl_psjb))." ".ubahBulan(date("M",strtotime($row->tgl_psjb)))." ".date("Y",strtotime($row->tgl_psjb))?></td></tr>
        <tr><td style="white-space: nowrap;">Nama Pemesan</td><td style="padding-left: 20px">:</td><td><?php echo $row->nama_pemesan?></td></tr>
        <tr><td style="white-space: nowrap;">Nama dalam sertifikat / PPJB</td><td style="padding-left: 20px">:</td><td><?php echo $row->nama_sertif?></td></tr>
        <tr><td style="white-space: nowrap;">Alamat lengkap</td><td style="padding-left: 20px">:</td><td><?php echo $row->alamat_lengkap?></td></tr>
        <tr><td style="white-space: nowrap;">Alamat surat</td><td style="padding-left: 20px">:</td><td><?php echo $row->alamat_surat?></td></tr>
        <tr><td style="white-space: nowrap;">Nomor telp rumah / kantor</td><td style="padding-left: 20px">:</td><td><?php echo $row->telp_rumah?></td></tr>
        <tr><td style="white-space: nowrap;">Nomor handphone</td><td style="padding-left: 20px">:</td><td><?php echo $row->telp_hp?></td></tr>
        <tr><td style="white-space: nowrap;">Nomor KTP / PASPOR / SIM</td><td style="padding-left: 20px">:</td><td><?php echo $row->ktp?></td></tr>
        <tr><td style="white-space: nowrap;">Uang Sebesar</td><td style="padding-left: 20px">:</td><td>Rp. <?php echo number_format($row->uang_awal)?>,-</td></tr>
        </tbody>
      </table>
      <span style="padding-left: 200px;">(<?php echo terbilang($row->uang_awal)?> Rupiah)</span><br>
     </p>
      <br>
     <p>
      <div style="font-weight: bold; font-size: 17px">Guna membayar pesanan kavling untuk pembelian rumah</div> <br>
      <table style="padding-left: 60px">
        <tbody>
        <tr><td>Perumahan</td><td style="padding-left:20px;">:</td><td><?php echo $row->perumahan?></td></tr>
        <tr>
          <td>Nomor Kavling</td>
          <td style="padding-left:20px;">:</td>
          <td>
            <?php echo $row->no_kavling?>
            <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){?>
              , <?php echo $rumah->no_unit?>
            <?php }?>
          </td>
        </tr>
        <tr><td>Type standard (Lb/Lt)</td><td style="padding-left:20px;">:</td><td><?php echo $row->tipe_rumah?></td></tr>
        <tr><td>Harga jual standard</td><td style="padding-left:20px;">:</td><td>Rp. <?php echo number_format($row->harga_jual+$row->hadap_timur)?>,-</td></tr>
        <tr><td>Diskon penjualan</td><td style="padding-left:20px;">:</td><td>Rp. <?php echo number_format($row->disc_jual)?>,-</td></tr>
        <tr><td>Total penjualan</td><td style="padding-left:20px;">:</td><td>Rp. <?php echo number_format($row->total_jual)?>,-</td></tr>
        </tbody>
      </table>
      <span style="padding-left: 200px;">(<?php echo terbilang($row->total_jual)?> Rupiah)</span><br>
      <p style="padding-left: 100px">
        <br>
        Catatan:
        <ul style="text-align: justify; text-justify: inter-word; padding-left: 88px">
          <li><i>harga tersebut belum termasuk pajak pembelian, biaya balik nama dan PPN.</i></li>
          <li><i>harga tersebut dimuat dalam isi Perjanjian Pengikatan Jual Beli (PPJB) yang akan dibuat kemudian.</i></li>
          <li><i>lampiran PSJB adalah foto copy identitas KTP / PASPOR / SIM.</i></li>
        </ul>
      </p>
     </p>
      <br>
     <p>
      <div style="font-weight: bold; font-size: 17px; page-break-before: always;">JADWAL PEMBAYARAN</div> <br>
      <table style="padding-left: 60px">
        <thead>
          <tr>
          <td style="font-weight: bold">Tahap Pembayaran</td>
          <td style="padding-left:50px; font-weight: bold">Tanggal Pembayaran</td>
          <td style="padding-left:50px; font-weight: bold">Jumlah Pembayaran</td>
          </tr>
        </thead>
        <tbody>
        <?php if($row->sistem_pembayaran == "KPR"){?>
          <?php foreach($psjb_detail_dp as $row2){?>
            <?php if($row2->cara_bayar == "Uang Tanda Jadi"){
                if($row2->dana_masuk != 0){?>
                <tr>
                <td><?php echo $row2->cara_bayar?></td>
                <?php if($row2->cara_bayar == "KPR"){?>
                  <td>AKAD BANK</td>
                <?php } else {?>
                  <td style="padding-left:50px;"><?php echo date("d", strtotime($row2->tanggal_dana))." ".ubahBulan(date("M", strtotime($row2->tanggal_dana)))." ".date("Y", strtotime($row2->tanggal_dana))?></td>
                <?php }?>
                <td style="padding-left:50px;">Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                </tr>
            <?php }} else {?>
                <tr>
                <td><?php echo $row2->cara_bayar?></td>
                <?php if($row2->cara_bayar == "KPR"){?>
                  <td style="padding-left:50px;">AKAD BANK</td>
                <?php } else {?>
                  <td style="padding-left:50px;"><?php echo date("d", strtotime($row2->tanggal_dana))." ".ubahBulan(date("M", strtotime($row2->tanggal_dana)))." ".date("Y", strtotime($row2->tanggal_dana))?></td>
                <?php }?>
                <td style="padding-left:50px;">Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                </tr>
            <?php }?>
        <?php }}elseif($row->sistem_pembayaran == "Cash"){?>
          <?php foreach($psjb_detail_dp as $row2){?>
            <?php if($row2->cara_bayar == "Uang Tanda Jadi"){
                if($row2->dana_masuk != 0){?>
                <tr>
                <td><?php echo $row2->cara_bayar?></td>
                <td style="padding-left:50px;"><?php echo date("d", strtotime($row2->tanggal_dana))." ".ubahBulan(date("M", strtotime($row2->tanggal_dana)))." ".date("Y", strtotime($row2->tanggal_dana))?></td>
                <td style="padding-left:50px;">Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                </tr>
            <?php }} else {?>
                <tr>
                <td><?php echo $row2->cara_bayar?></td>
                <td style="padding-left:50px;"><?php echo date("d", strtotime($row2->tanggal_dana))." ".ubahBulan(date("M", strtotime($row2->tanggal_dana)))." ".date("Y", strtotime($row2->tanggal_dana))?></td>
                <td style="padding-left:50px;">Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                </tr>
            <?php }?>
        <?php }} else{?>
          <?php foreach($psjb_detail_dp as $row2){?>
            <?php if($row2->cara_bayar == "Uang Tanda Jadi"){
                if($row2->dana_masuk != 0){?>
                <tr>
                <td><?php echo $row2->cara_bayar?></td>
                <td style="padding-left:50px;"><?php echo date("d", strtotime($row2->tanggal_dana))." ".ubahBulan(date("M", strtotime($row2->tanggal_dana)))." ".date("Y", strtotime($row2->tanggal_dana))?></td>
                <td style="padding-left:50px;">Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                </tr>
            <?php }} else {?>
                <tr>
                <td><?php echo $row2->cara_bayar?></td>
                <td style="padding-left:50px;"><?php echo date("d", strtotime($row2->tanggal_dana))." ".ubahBulan(date("M", strtotime($row2->tanggal_dana)))." ".date("Y", strtotime($row2->tanggal_dana))?></td>
                <td style="padding-left:50px;">Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                </tr>
            <?php }?>
        <?php }}?>
        </tbody>
      </table>
      <br>
      <p style="">
        <table style="">
          <tbody>
          <tr><td>Total Pembayaran</td><td style="padding-left:10px;">:</td><td>Rp. <?php echo number_format($row->total_jual)?>,-</td></tr>
          <tr><td>Terbilang</td><td style="padding-left:10px;">:</td><td><?php echo terbilang($row->total_jual)?> Rupiah</td></tr>
          </tbody>
        </table>
      </p>
     </p>
      <br>
      <?php if($row->sistem_pembayaran == "KPR"){?>
     <p>
      <div style="font-weight: bold; font-size: 17px">Dengan syarat dan ketentuan :</div><br>
        <div style="text-align: justify; text-justify: inter-word; font-size: 13px">
          <ol>
            <li>
              Pembayaran Down Payment (DP) sebesar 15% harus dibayarkan selambat-lambatnya 14 (empat belas) hari semenjak tanggal pembayaran tanda jadi atau booking fee. Apabila melebihi 14 hari maka calon pembeli dianggap telah membatalkan perjanjian ini dan uang tanda jadi atau booking fee tidak dapat diambil kembali, dikecualikan ada kesepakatan tertulis mengenai tata cara pembayaran Down Payment.
            </li>
            <li>
              Dalam jangka waktu selambat - lambatnya 30 ( tiga puluh ) hari sejak tanggal pembayaran tanda jadi, maka pihak calon pembeli setuju dan mufakat untuk :
              <ul>
                <li>
                  Pesanan letak kavling dan harga jual tersebut di atas mengikat pihak perusahaan. Apabila realisasi pembayaran calon pembeli tidak sesuai dengan jadwal tersebut di atas, maka letak kavling dan harga rumah ditentukan menyesuaikan dengan kavling yang ada dengan harga dan tata - cara pembayaran terbaru yang berlaku.
                </li>
                <li>
                  Denah unit rumah sesuai dengan type unit yang dibeli.
                </li>
              </ul>
            </li>
            <li>
              Pembangunan fisik rumah akan dimulai melihat kesiapan di lapangan, dengan ketentuan :
              <ul>
                <li>
                  Pihak bank pemberi kredit telah mensetujui pembiayaan KPR calon pembeli.
                </li>
                <li>
                  Pembayaran Down Payment 15% telah lunas (dikecualikan ada kesepakatan tertulis mengenai tata cara pembayaran DP antara pihak perusahaan dan pembeli).
                </li>
              </ul>
            </li>
            <li>
              Untuk pembelian melalui fasilitas pembiayaan Bank pemberi kredit ( KPR ),  maka pihak calon pembeli setuju dan mufakat untuk :
              <ul>
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
                    <li>
                      Konsumen apabila dalam tempo 3 (tiga) bulan tidak melakukan pembayaran maka menyatakan membatalkan perjanjian jual beli ini dan seluruh dana yang disetorkan kepada perusahaan akan hangus. 
                    </li>
                  </ol>
                </li>
              </ul>
            </li>
            <li>
              Calon pembeli setuju dan sepakat mengundurkan diri dan pesanan kavling batal dengan sendirinya apabila calon pembeli cedera janji / wanprestasi atas ketentuan waktu pada point nomor 1, 2 dan 4 di atas dan uang tanda jadi / booking fee tidak dapat diambil / dikembalikan.
            </li>
            <li>
              Untuk ketentuan – ketentuan lain yang tidak diatur dalam surat Perjanjian Sementara Jual Beli ini akan diatur dalam Perjanjian Jual Beli (PPJB) yang akan ditandatangani bersama.
            </li>
          </ol>
          Perjanjian Sementara Jual Beli (PSJB) ini dibuat rangkap 2 dan memiliki kekuatan hukum yang sama serta sebagai alat bukti pembayaran yang sah.
        </div>
     </p>
      <?php } elseif($row->sistem_pembayaran == "Cash"){?>
    <p>
      <div style="font-weight: bold; font-size: 17px">Dengan syarat dan ketentuan :</div><br>
        <div style="text-align: justify; text-justify: inter-word; font-size: 13px">
          <ol>
            <li>
              Pembayaran Down Payment (DP) harus dibayarkan lunas selambat-lambatnya 14 (empat belas) hari semenjak tanggal pembayaran tanda jadi atau booking fee. Apabila melebihi 14 hari maka calon pembeli dianggap telah membatalkan perjanjian ini dan uang tanda jadi atau booking fee tidak dapat diambil kembali, dikecualikan ada kesepakatan tertulis mengenai tata cara pembayaran Down Payment.
            </li>
            <li>
              Dalam jangka waktu selambat - lambatnya 30 ( tiga puluh ) hari sejak tanggal pembayaran tanda jadi, maka pihak calon pembeli setuju dan mufakat untuk :
              <ul>
                <li>
                  Pesanan letak kavling dan harga jual tersebut di atas mengikat pihak perusahaan. Apabila realisasi pembayaran calon pembeli tidak sesuai dengan jadwal tersebut di atas, maka letak kavling dan harga rumah ditentukan menyesuaikan dengan kavling yang ada dengan harga dan tata - cara pembayaran terbaru yang berlaku.
                </li>
                <li>
                  Denah unit rumah sesuai dengan type unit yang dibeli.
                </li>
              </ul>
            </li>
            <li>
              Pembangunan fisik rumah akan dimulai apabila Pihak pembeli sudah membayar 50% dari total jumlah harga rumah kesepakatan.
            </li>
            <li>
              Untuk ketentuan – ketentuan lain yang tidak diatur dalam surat Perjanjian Sementara Jual Beli ini akan diatur dalam Perjanjian Jual Beli (PPJB) yang akan ditandatangani bersama.
            </li>
          </ol>
          Perjanjian Sementara Jual Beli (PSJB) ini dibuat rangkap 2 dan memiliki kekuatan hukum yang sama serta sebagai alat bukti pembayaran yang sah.
        </div>
     </p>
      <?php } else{?>
    <p>
      <div style="font-weight: bold; font-size: 17px">Dengan syarat dan ketentuan :</div><br>
        <div style="text-align: justify; text-justify: inter-word; font-size: 13px">
          <ol>
            <li>
              Pembayaran Down Payment (DP) harus dibayarkan lunas selambat-lambatnya 14 (empat belas) hari semenjak tanggal pembayaran tanda jadi atau booking fee. Apabila melebihi 14 hari maka calon pembeli dianggap telah membatalkan perjanjian ini dan uang tanda jadi atau booking fee tidak dapat diambil kembali, dikecualikan ada kesepakatan tertulis mengenai tata cara pembayaran Down Payment.
            </li>
            <li>
              Dalam jangka waktu selambat - lambatnya 30 ( tiga puluh ) hari sejak tanggal pembayaran tanda jadi, maka pihak calon pembeli setuju dan mufakat untuk :
              <ul>
                <li>
                  Pesanan letak kavling dan harga jual tersebut di atas mengikat pihak perusahaan. Apabila realisasi pembayaran calon pembeli tidak sesuai dengan jadwal tersebut di atas, maka letak kavling dan harga rumah ditentukan menyesuaikan dengan kavling yang ada dengan harga dan tata - cara pembayaran terbaru yang berlaku.
                </li>
                <li>
                  Denah unit rumah sesuai dengan type unit yang dibeli.
                </li>
              </ul>
            </li>
            <li>
              Pembangunan fisik rumah akan dimulai apabila Pihak pembeli sudah membayar 50% dari total jumlah harga rumah kesepakatan.
            </li>
            <li>
              Pembayaran Cash tempo dengan syarat dan ketentuan berlaku :
              <ol type="a">
                <li>
                  Cash tempo 12 bulan tanpa bunga dengan DP minimal 20% dari harga jual kesepakatan.
                </li>
                <li>
                  Cash tempo 24 bulan dengan bunga 10% pertahun dengan DP minimal 30% dari harga jual kesepakatan.
                </li>
                <li>
                  Cash tempo 36 bulan dengan bunga 12% pertahun dengan DP minimal 30% dari harga jual kesepakatan.
                </li>
                <li>
                  Pembeli dilarang membatalkan pembelian unit tersebut. Dalam hal pembatalan, maka perusahaan akan mengembalikan dana pembeli yang bersangkutan apabila unit rumah pembeli tersebut sudah ada pembeli baru dengan membayar biaya pembatalan Rp 5.000.000.
                </li>
                <li>
                  Dalam hal pembatalan oleh pembeli, apabila tidak mau menunggu sampai unitnya terjual, maka dana akan dikembalikan 50% dari total jumlah dana yang sudah disetorkan oleh pembeli.
                </li>
                <li>
                  Dalam hal take over oleh pembeli lain yang pengganti nya adalah dari pembeli unit itu sendiri, maka biaya pembatalan adalah Rp 0 dengan syarat, Pembeli penganti tetap melanjutkan pembayaran sesuai dengan kesepakatan awal dan dana pembeli pertama sepenuhnya dikembalikan oleh pembeli penganti.
                </li>
                <li>
                  Dalam hal perubahan cara bayar menjadi KPR, maka pembeli diberikan waktu maksimal 3 bulan dengan tetap melakukan pembayaran tempo sesuai dengan jadwal sampai dengan akad KPR dilakukan.
                </li>
              </ul>
            </li>
            <li>
              Untuk ketentuan – ketentuan lain yang tidak diatur dalam surat Perjanjian Sementara Jual Beli ini akan diatur dalam Perjanjian Jual Beli (PPJB) yang akan ditandatangani bersama.
            </li>
          </ol>
          Perjanjian Sementara Jual Beli (PSJB) ini dibuat rangkap 2 dan memiliki kekuatan hukum yang sama serta sebagai alat bukti pembayaran yang sah.
        </div>
     </p>
      <?php }?> <br>
     <p>
      <div style="page-break-inside: avoid;">
        <div style="text-align: right">Pontianak, <?php echo date("d", strtotime($row->tgl_psjb))." ".ubahBulan(date("M", strtotime($row->tgl_psjb)))." ".date("Y", strtotime($row->tgl_psjb))?></div> <br><br>
        <table class="table-borderless" style="text-align: center; width: 100%; table-layout:fixed;">
          <tr>
            <td>Menyetujui,</td>
            <td></td>
          </tr>
          <tr>
            <td>Calon Konsumen</td>
            <td>Pihak Marketing</td>
          </tr>
          <tr> 
            <td>
              <?php if($row->konsumen_sign != ""){?>
                <img src="./gambar/signature/psjb/<?php echo $row->konsumen_sign?>" style="width: 200px; height: 90px;">
              <?php } else {?>
                <br><br><br><br>
                <span style="height: 80px"></span>
              <?php } ?>
            </td>
            <td>
              <?php if($row->marketing_sign != ""){?>
                <img src="./gambar/signature/psjb/<?php echo $row->marketing_sign?>" style="width: 200px; height: 90px;">
              <?php } else {?>
                <br><br><br><br>
                <span style="height: 80px"></span>
              <?php }?>
            </td> 
          </tr>
          <tr>
            <td style=""><?php echo $row->nama_pemesan?></td>
            <td style=""><?php echo $row->nama_marketing?></td>
          </tr>
        </table> <br>
        <!-- <tr> <td> -->
      </div>
     </p>
     <?php }?>
   </div>
</body></html>