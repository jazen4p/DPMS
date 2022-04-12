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
     <p class="page"><span style="font-weight: bold"><i>Surat Perintah Kerja</i></span> <span style="padding-left:450px"> Halaman <?php $PAGE_NUM ?> </span></p>
   </div>
   <div id="content" style="font-size: 12px">
      <div>Tanggal : <?php echo date('d F Y');?></div> <br>

      <div>
        Kepada Yth, <br>
        Pak. Hendra Hartady
      </div> <br>

      <div>
        <?php foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $ppjb){?>
          <div>Berdasarkan dokumen PPJB No. 1-<?php echo sprintf('%03d', $ppjb->no_psjb)?>/PPJB/KBR/<?php echo $ppjb->kode_perusahaan."/".$ppjb->kode_perumahan."/".date('m', strtotime($ppjb->tgl_psjb))."/".date('y', strtotime($ppjb->tgl_psjb));?></div>
        <?php }?>
        <table style="padding-left: 10px">
          <tr>
            <td>No. Dokumen</td><td>:</td><td>1-<?php echo sprintf('%03d', $row->no_spk)?>/SPK/KBR/<?php echo $ppjb->kode_perusahaan."/".$row->kode_perumahan."/".date('m', strtotime($row->date_by))."/".date('y', strtotime($row->date_by));?></td>
          </tr>
          <tr>
            <td>Nama calon konsumen</td><td>:</td><td><?php echo $ppjb->nama_pemesan?></td>
          </tr>
          <tr>
            <td>Perusahaan / Perumahan / Kavling, Type (Lb|Lt)</td><td>:</td><td><?php echo $pers->nama_perusahaan." / ".$as->nama_perumahan." / ".$row->unit.", Type ".$row->luas_bangunan." | ".$row->luas_tanah?></td>
          </tr>
          <tr>
            <td>Masa pelaksanaan</td><td>:</td><td><?php echo $row->masa_pelaksanaan?></td>
          </tr>
          <tr>
            <td>Kontrak pekerjaan</td><td>:</td><td><?php echo $row->kontrak_pekerjaan?></td>
          </tr>
        </table>
      </div>
      <br>
      <div>
        <div>Dengan telah ditandatanganinya PPJB tersebut dan pembayaran uang muka / KPR telah disetujui pihak bank dengan data :</div> <br>
        <table>
          <tr>
            <td>Harga sepakat</td><td>:</td><td><?php echo "Rp. ".number_format($row->harga_unit)?></td>
          </tr>
          <tr>
            <?php 
              $uang_muka = 0;
              // $this->db->like('cara_bayar', "Pembayaran DP");
              foreach($this->db->get_where('ppjb-dp', array('no_ppjb'=>$ppjb->no_psjb, 'cara_bayar <>'=>"KPR", 'kode_perumahan'=>$row->kode_perumahan))->result() as $muka){
                if($muka->cara_bayar == "Uang Tanda Jadi"){
                  $uang_muka = $uang_muka + $muka->dana_sekarang;
                }
                $uang_muka = $uang_muka + $muka->dana_bayar;
              }
            ?>
            <td>Total pembayaran konsumen</td><td>:</td><td><?php echo "Rp. ".number_format($uang_muka)?></td>
          </tr>
          <?php if($ppjb->sistem_pembayaran == "KPR"){?>
            <tr>
              <td>Tanggal persetujuan pembiayaan bank</td><td>:</td><td><?php echo date('d F Y', strtotime($row->tgl_akad))?> (Bila lewat KPR)</td>
            </tr>
          <?php }?>
        </table>
      </div>
      <br>
      <div>
        <div>Maka diperintahkan kepada Saudara untuk melaksanakan pembangunan kavling proyek tersebut dengan ketentuan :</div> <br>
        <table style="padding-left: 10px">
          <tr>
            <td>Upah</td><td>:</td><td><?php echo "Rp. ".number_format($row->upah);?></td>
          </tr>
          <tr>
            <td>Batas akhir BAST pada tanggal</td><td>:</td><td><?php echo date('d F Y', strtotime($row->tgl_bast))?></td>
          </tr>
        </table>
      </div>
      <br>
      <div>
        Setiap perubahan pelaksanaan yang menyimpang dari Gambar Rencana dan spesifikasi harus dikoordinasikan dengan Bagian Arstiker penjualan / Marketing dan dimintakan persetujuan dengan konsumen.
      </div>
      <br>
      <div>
        Demikian, atas perhatian Saudara diucapkan terima kasih.
      </div>
      <br>
      <table style="width: 100%; table-layout:fixed;">
        <tr>
          <td>Hormat saya,</td>
          <td style="text-align: center">Diterima, <?php echo date('d F Y', strtotime($row->date_by))?></td>
        </tr>
        <tr>
          <td>Direktur Keuangan</td>
          <td style="text-align: center">Manager Produksi</td>
        </tr>
        <tr>
          <td><img src="./gambar/signature/spk/<?php echo $row->owner_sign?>" style="width: 100px; height: 80px"></td>
          <?php if($row->staff_sign != ""){?>
            <td style="text-align: center"><img src="./gambar/signature/spk/<?php echo $row->staff_sign?>" style="width: 100px; height: 80px"></td>
          <?php } else {
            echo "<span><br><br><br><br></span>";
          }?>
        </tr>
        <tr>
          <td>Edi Yanto</td>
          <td style="text-align: center">Hendra Hartady</td>
        </tr>
      <table>
        <br>
      <div style="page-break-inside: avoid">
        <div style="padding-left: 10px">Catatan : </div>
        <div style="padding-left: 10px">
          <ol>
            <li>Mohon konfirmasi ke konsumen, apabila akan memulai pembangunan.</li>
            <li>Kegiatan fisik pembangunan kavling di Lapangan harus sudah dimulai paling lambat 2 minggu setelah surat ini dikeluarkan.</li>
            <li>Dokumen ini digunakan sebagai pedoman dalam pembuatan KBK dengan pihak pemborong.</li>
          </ol>
        </div>
      </div>
   </div>
  <?php }?>
</body></html>