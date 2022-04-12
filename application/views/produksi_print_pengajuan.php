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
        <p>
          <div>
            <table style="padding-left: 40px; width: 60%; table-layout:fixed;">
                <?php foreach($check_all->result() as $row){
                    foreach($this->db->get_where('produksi_transaksi', array('id_pengajuan'=>$row->id_pengajuan), 1)->result() as $tr){?>
                    <tr>
                        <td>Transfer Ke</td><td>: <?php echo $tr->nama_toko?></td>
                        <td style="padding-left: 350px">Pembayaran</td>
                    </tr>
                    <tr>
                        <td>Tgl Jatuh Tempo</td><td>: <?php echo strtoupper(date('d F Y', strtotime($tr->tgl_deadline)))?></td>
                        <td style="padding-left: 340px" rowspan=3>
                          <?php if($row->status=="lunas"){ ?>
                          <img src="./gambar/produksi/lunas.PNG" style="width: 75px; height: 50px">
                          <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){?>
                            <td>Proyek</td><td>: <?php echo strtoupper($prmh->nama_perumahan." residence")?></td>
                        <?php }?>
                    </tr>
                    <tr>
                      <td></td>
                    </tr>
                <?php }?>
            </table>
          </div>
        </p>
        <hr>
        <p>
            <table id="" class="table table-bordered table-striped" style="font-size: 14px">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>Nama Bahan</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Tanggal Beli</th>
                    <th>Total Harga</th>
                    <!-- <th>Total Pembelian</th> -->
                    <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; $total=0; 


                    $this->db->order_by('no_faktur', "ASC");
                    $tbl = $this->db->get_where('produksi_transaksi', array('id_pengajuan'=>$row->id_pengajuan));
                    foreach($tbl->result() as $row1){?>
                        <tr>
                            <td><?php echo $no?></td>
                            <td><?php echo $row1->nama_barang?></td>
                            <td><?php echo number_format($row1->qty)?></td>
                            <td><?php echo $row1->nama_satuan?></td>
                            <td><?php echo "Rp. ".number_format($row1->harga_satuan)?></td>
                            <td><?php echo date('d F Y', strtotime($row1->tgl_pesan))?></td>
                            <td>
                                <?php echo "Rp. ".number_format($row1->qty*$row1->harga_satuan);?>
                            </td>
                        </tr>
                    <?php $no++; $total = $total + ($row1->qty*$row1->harga_satuan);}?>
                    
                    <tr style="background-color: cyan">
                        <td colspan=6 style="text-align: center">TOTAL PEMBELIAN <?php echo strtoupper(date('F Y', strtotime($row1->tgl_pesan)));?></td>
                        <td><?php echo "Rp. ".number_format($total)?></td>
                    </tr>
                </tbody>
            </table>
        </p>
        <p style="">
          <table style="width: 100%; table-layout: fixed">
            <tr style="text-align: center">
              <td>Dibuat Oleh,</td>
              <td>Mengetahui,</td>
              <td>Disetujui Oleh,</td>
            </tr>
            <tr style="text-align: center">
              <td>
                <?php if($row->staff_sign == ""){
                  echo "<br><br><br><br>"; 
                } else {?>
                  <img src="./gambar/signature/pengajuan/<?php echo $row->staff_sign?>" style="width: 120px; height: 90px">
                <?php }?>
              </td>
              <td>
                <?php if($row->manager_sign == ""){
                  echo "<br><br><br><br>"; 
                } else {?>
                  <img src="./gambar/signature/pengajuan/<?php echo $row->manager_sign?>" style="width: 120px; height: 90px">
                <?php }?>
              </td>
              <td>
                <?php if($row->owner_sign == ""){
                  echo "<br><br><br><br>"; 
                } else {?>
                  <img src="./gambar/signature/pengajuan/<?php echo $row->owner_sign?>" style="width: 120px; height: 90px">
                <?php }?>  
              </td>
            </tr>
            <tr style="text-align: center">
              <td><u><?php echo $row->staff_sign_by?></u></td>
              <td><u><?php echo $row->manager_sign_by?></u></td>
              <td><u><?php echo $row->owner_sign_by?></u></td>
            </tr>
            <tr style="text-align: center">
              <td>Admin Keuangan</td>
              <td>Manajer Keuangan</td>
              <td>Direktur Keuangan</td>
            </tr>
          </table>
          <!-- <div>
            <span style="padding-left: 100px">Dibuat Oleh,</span>
            <span style="padding-left: 500px">Mengetahui,</span>
            <span style="padding-left: 70px">Disetujui Oleh,</span>
          </div>
          <br><br><br><br>
          <div style="">
            <u><span style="padding-left: 70px"><?php echo $row->staff_sign_by?></span></u>
            <u><span style="padding-left: 460px">Aras Yulita</span></u>
            <u><span style="padding-left: 90px">Edi Yanto</span></u>
          </div>
          <br>
          <div>
            <span style="padding-left: 85px">Admin Keuangan</span>
            <span style="padding-left: 465px">Manajer Keuangan</span>
            <span style="padding-left: 37px">Direktur Keuangan</span>
          </div> -->
        </p>
   </div>
  <?php }?>
</body></html>