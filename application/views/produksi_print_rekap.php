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
   <div id="footer">
      <hr style="border-top: 1px solid">
     <p class="page"><span style="font-weight: bold"><i>Perjanjian Sementara Jual Beli</i></span> <span style="padding-left:410px"> Halaman <?php $PAGE_NUM ?> </span></p>
   </div>
   <div id="content">
        <div style="text-align: center">
            <span style="font-weight: bold">Proyek <?php echo $nama_perumahan?> Residence</span><br>
            Rekap Pembelian Bahan
            Bulan <?php echo date('F Y', strtotime($tgl))?> <br><br>
        </div>
        <table id="example2" class="table table-bordered table-striped" style="font-size: 12px">
            <thead>
            <tr>
                <th rowspan=2>No</th>
                <th rowspan=2>Nama Bahan</th>
                <th colspan=5>Pembelian Minggu Ke</th>
                <th rowspan=2>Total Pembelian</th>
                <th rowspan=2>Satuan</th>
                <th rowspan=2>Harga Satuan</th>
                <th rowspan=2>Total Harga</th>
                <th rowspan=2>Toko Bangunan</th>
                <!-- <th>Status</th> -->
                <!-- <th>Jmlh Diterima</th> -->
                <!-- <th>Aksi</th> -->
            </tr>
            <tr>
                <th><?php echo $week?></th>
                <th><?php echo $week+1?></th>
                <th><?php echo $week+2?></th>
                <th><?php echo $week+3?></th>
                <th><?php echo $week+4?></th>
            </tr>
            </thead>
            <tbody>
            <?php $no=1; $total = 0;
                // $query = $this->db->get('produksi_transaksi');
                // $query = $this->Dashboard_model->
            //   $test = $this->db->get_where('produksi_master_data', array('kategori'=>"barang"));
            //   foreach($test->result() as $tests){
            //     foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $tst_tk){
            //       foreach($this->Dashboard_model->get_rekap_rincian_pembelian($tgl, $id)->result() as $row1){
            //         if($row1->nama_barang == $tests->nama_data && $row1->nama_toko == $tst_tk->nama_data){?>
                    <!-- <tr>
            //           <td><?php echo $no;?></td>
            //           <td><?php echo $row1->nama_barang?></td>
            //         </tr> -->
            <?php 
            // }}}$no++;}

                foreach($querys->result() as $row){
                
            ?>
                <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $row->nama_barang;?></td>
                <?php 
                $w_qty1 = 0;$w_qty2 = 0;$w_qty3 = 0;$w_qty4 = 0;$w_qty5 = 0;
                foreach($this->db->get_where('produksi_transaksi', array('nama_barang'=>$row->nama_barang, 'nama_toko'=>$row->nama_toko, 'kode_perumahan'=>$row->kode_perumahan))->result() as $w_ttl){
                    if($w_ttl->week_num == $week){
                    $w_qty1 = $w_qty1 + $w_ttl->qty;
                    } else if($w_ttl->week_num == $week+1){
                    $w_qty2 = $w_qty2 + $w_ttl->qty;                  
                    } else if($w_ttl->week_num == $week+2){
                    $w_qty3 = $w_qty3 + $w_ttl->qty;
                    } else if($w_ttl->week_num == $week+3){
                    $w_qty4 = $w_qty4 + $w_ttl->qty;
                    } else if($w_ttl->week_num == $week+4) {
                    $w_qty5 = $w_qty5 + $w_ttl->qty;
                    }
                    
                }
                // echo "<td>$w_qty4</td>";
                // if($querys->num_rows() > 0){

                // } else {
                //   "<td></td><td></td><td></td><td></td><td></td>";
                // }
                if($w_qty1 == 0){
                    echo "<td></td>";
                }else {
                    echo "<td>$w_qty1</td>";
                }

                if($w_qty2 == 0){
                    echo "<td></td>";
                }else {
                    echo "<td>$w_qty2</td>";
                }

                if($w_qty3 == 0){
                    echo "<td></td>";
                }else {
                    echo "<td>$w_qty3</td>";
                }

                if($w_qty4 == 0){
                    echo "<td></td>";
                }else {
                    echo "<td>$w_qty4</td>";
                }

                if($w_qty5 == 0){
                    echo "<td></td>";
                }else {
                    echo "<td>$w_qty5</td>";
                }
                    // if($row->week_num == $week){
                    //   echo "<td>".$w_qty1."</td>";
                    //   echo "<td></td><td></td><td></td><td></td>";
                    // } else if($row->week_num == $week+1){
                    //   echo "<td></td>";
                    //   echo "<td>".$w_qty2."</td>";       
                    //   echo "<td></td><td></td><td></td>";                   
                    // } else if($row->week_num == $week+2){
                    //   echo "<td></td><td></td>";
                    //   echo "<td>".$w_qty3."</td>"; 
                    //   echo "<td></td><td></td>";
                    // } else if($row->week_num == $week+3){
                    //   echo "<td></td><td></td><td></td>";
                    //   echo "<td>".$w_qty4."</td>";
                    //   echo "<td></td>";
                    // } else if($row->week_num == $week+4) {
                    //   echo "<td></td><td></td><td></td><td></td>";
                    //   echo "<td>".$w_qty5."</td>";
                    //   // echo "";
                    // }
                ?>
                <td><?php echo $row->totalqty;?></td>
                <td><?php echo $row->nama_satuan;?></td>
                <td><?php echo "Rp. ".number_format($row->harga_satuan);?></td>
                <td><?php echo "Rp. ".number_format($row->total);?></td>
                <td><?php echo $row->nama_toko;?></td>
                </tr>
            <?php $no++;
            $total = $total + $row->total;
            }?>
            <tr style="background-color: lightyellow; font-weight: bold">
                <td colspan=10 style="text-align: center">TOTAL PEMBELIAN BAHAN BULAN <?php echo strtoupper(date('F Y', strtotime($tgl)))?> </td>
                <td colspan=2><?php echo "Rp. ".number_format($total)?></td>
            </tr>
            </tfoot>
        </table>
        <br><br>
        <table id="example2" class="table table-striped table-bordered" style="page-break-before: always; font-size: 12px">
            <thead>
                <tr style="text-align: center">
                    <th>TOKO BANGUNAN</th>
                    <th>TOTAL</th>
                    <th>TOKO BANGUNAN</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php $tl_tk = 0; $tl = 0;
                    $toko = $this->db->get_where('produksi_master_data', array('kategori'=>"toko"));
                    foreach($toko->result() as $tk){
                      $tst = $this->Dashboard_model->rincian_pembelian_tk($id, date('Y-m', strtotime($tgl)), $tk->nama_data);
                    //   print_r($tst);
                      ?>
                      <?php if($tst->num_rows() > 0){?>
                      <tr style="font-weight: bold">
                          <td><?php echo $tk->nama_data?></td>
                          <?php 
                          if($tst->num_rows() > 0){
                            foreach($tst->result() as $rc){?>
                              <td style=""><?php echo "Rp. ".number_format($rc->total)?></td>
                          <?php 
                                $tl_tk = $tl_tk + $rc->total;
                            }
                                } else {
                                    echo "<td>Rp. 0</td>"; 
                          }?>
                      </tr>
                    <?php } else {?>
                      <tr style="">
                        <td><?php echo $tk->nama_data?></td>
                        <?php 
                        if($tst->num_rows() > 0){
                          foreach($tst->result() as $rc){?>
                            <td style=""><?php echo "Rp. ".number_format($rc->total)?></td>
                        <?php $tl_tk = $tl_tk + $rc->total;}} else {
                          echo "<td>Rp. 0</td>"; 
                        }?>
                    </tr>
                    <?php }}?>
                <tr style="background-color: lightyellow; font-weight: bold; text-align: center">
                    <td colspan=2><?php echo "TOTAL KESELURUHAN BULAN ".strtoupper(date('F Y', strtotime($tgl)));?></td>
                    <td colspan=2><?php echo "Rp. ".number_format($tl_tk)?></td>
                </tr>
            </tbody>
        </table>

        <p style="page-break-before: always;">
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
        </p>
   </div>
</body></html>