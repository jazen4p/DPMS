<html><head>
   <style>
     @page { margin: 55px 50px 110px; }
     #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -155px; right: 0px; height: 150px; }
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
   <!-- <div id="footer">
      <hr style="border-top: 1px solid">
     <p class="page"><span style="font-weight: bold"><i>Perjanjian Sementara Jual Beli</i></span> <span style="padding-left:410px"> Halaman <?php $PAGE_NUM ?> </span></p>
   </div> -->
   <div id="content">
        <div style="text-align: center">
            <span style="font-weight: bold"><?php echo $nama_perumahan?> Residence</span><br>
            Laporan Penjualan Marketing <br>
            Per. <?php 
                  if($tglmin == ""){
                    echo "Awal";
                  } else {
                    echo date('F Y', strtotime($tglmin));
                  }
                  echo " - ";
                  if($tglmax == ""){
                    echo "Akhir Keseluruhan";
                  } else {
                    echo date('F Y', strtotime($tglmax));
                  }
                ?> <br><br>

            <table id="example2" class="table table-bordered table-striped" style="font-size: 12px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Marketing</th>
                    <th>Closing</th>
                    <th>Tipe</th>
                    <th>Blok</th>
                    <th>Harga Jual</th>
                    <!-- <th>Status</th> -->
                    <!-- <th>Jmlh Diterima</th> -->
                </tr>
                </thead>
                <tbody style="white-space: nowrap">
                <?php $no=1; foreach($check_all as $row){?>
                    <tr>
                    <td><?php echo $no?></td>
                    <td><?php echo date("d F Y", strtotime($row->date_by))?></td>
                    <td><?php echo $row->nama_marketing?></td>
                    <td><?php echo $row->sistem_pembayaran?></td>
                    <td>
                    <?php foreach($this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan))->result() as $rmh){
                        echo $rmh->tipe_rumah;
                    }?>
                    </td>
                    <td><?php echo $row->no_kavling?></td>
                    <td><?php echo "Rp. ".number_format($rmh->harga_jual)?></td>
                    </tr>
                    <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $row1){
                    $no = $no + 1;?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td><?php echo date("d F Y", strtotime($row->date_by))?></td>
                        <td><?php echo $row->nama_marketing?></td>
                        <td><?php echo $row->sistem_pembayaran?></td>
                        <td>
                        <?php echo $row1->tipe_rumah;?>
                        </td>
                        <td><?php echo $row1->kode_rumah?></td>
                        <td><?php echo "Rp. ".number_format($row1->harga_jual)?></td>
                    </tr>
                    <?php }?>
                <?php $no++;}?>
                </tfoot>
            </table>
        </div>

        <!-- <p style="">
          <div>
            <span style="padding-left: 100px">Dibuat Oleh,</span>
            <span style="padding-left: 500px">Mengetahui,</span>
            <span style="padding-left: 70px">Disetujui Oleh,</span>
          </div>
          <br><br><br><br>
          <div style="">
            <u><span style="padding-left: 70px">Tiur Sri Rezeki Batubara</span></u>
            <u><span style="padding-left: 460px">Aras Yulita</span></u>
            <u><span style="padding-left: 90px">Edi Yanto</span></u>
          </div>
          <br>
          <div>
            <span style="padding-left: 85px">Admin Keuangan</span>
            <span style="padding-left: 465px">Manajer Keuangan</span>
            <span style="padding-left: 37px">Direktur Keuangan</span>
          </div>
        </p> -->
   </div>
</body></html>