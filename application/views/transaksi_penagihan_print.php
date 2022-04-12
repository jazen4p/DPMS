<html><head>
   <style>
     @page { margin: 80px 50px 150px; }
     #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -205px; right: 0px; height: 150px; }
     /* #footer .page:after { content: counter(page); } */
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
   <div id="content">
     <p>
        <div style="text-align: center; font-size: 17px; font-weight: bold">
            DAFTAR TAGIHAN BULANAN <br>
            PERIODE <?php echo strtoupper(date('F Y', strtotime($bulan)));?> <br><br>
        </div>
         <div style="">
          <table id="example2" class="table table-bordered table-striped" style="font-size: 14px;">
              <thead>
                <tr>
                  <th colspan=10></th>
                  <th>
                    <input type="submit" class="btn btn-outline-info btn-sm btn-flat" value="Edit">
                  </th>
                </tr>
                <tr>
                  <th>No</th>
                  <th>Nama Konsumen</th>
                  <th>No HP</th>
                  <th>Perumahan</th>
                  <th>Unit</th>
                  <th>Lama Tempo</th>
                  <th>Tgl Jth Tempo</th>
                  <th>Angsuran Ke</th>
                  <th>Angs/Bulan</th>
                  <th>SMS penagihan</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                  <!-- <th>Aksi</th> -->
                </tr>
              </thead>
              <tbody style=" white-space: nowrap;">
                <?php $no=1; foreach($ppjb_dp as $row){?>
                <?php
                    $tanggal_masuk = $row->tanggal_dana;

                    $joined = date("Y-m", strtotime($tanggal_masuk));

                    $monthyear = $bulan; 
                    // $finish = date("Y-m",strtotime($row->finish));
                    // $start = date("Y-m",strtotime($row->start));
                    // if ($joined <= $monthyear) {
                    // }

                    $query = $this->db->get_where('ppjb', array('no_psjb'=>$row->no_psjb))->result();
                    if ($joined <= $monthyear) {
                        if($row->status=="belum lunas" && $row->cara_bayar != "KPR"){
                            foreach($query as $row2) { 
                              ?>
                            <tr>
                                <td><?php echo $no;?></td>
                                <td style="white-space: nowrap;"><a href="<?php echo base_url()?>Dashboard/keuangan_bayar?id=<?php echo $row->id_psjb?>"><?php echo $row2->nama_pemesan?></a></td>
                                <td style="white-space: nowrap;"><?php echo $row2->telp_hp?></td>
                                <td>
                                  <?php 
                                  foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row2->kode_perumahan))->result() as $prmh){
                                    echo $prmh->nama_perumahan;
                                  }?>
                                </td>
                                <td>
                                  <?php echo $row2->no_kavling;
                                  foreach($this->db->get_where('rumah', array('no_psjb'=>$row2->psjb, 'kode_perumahan'=>$row2->kode_perumahan, 'tipe_produk'=>$row2->tipe_produk))->result() as $rmh){
                                    echo ", ".$rmh->kode_rumah;
                                  }
                                  ?>
                                </td>
                                <!--Lama Tempo-->
                                <td>
                                  <?php 
                                    $ttls = 0;
                                    foreach($query as $ttl){
                                      // echo $ttl->jumlah_dp; echo $ttl->lama_cash;
                                      if($ttl->cara_dp == "cash"){
                                        if($ttl->sistem_pembayaran=="KPR"){
                                          echo $ttls = $ttls + 1;
                                        } else if($ttl->sistem_pembayaran=="Cash"){
                                          echo $ttls = $ttls + 1 +$ttl->lama_cash;
                                        } else {
                                          echo $ttls = $ttls + $ttl->lama_tempo + 1;
                                        }
                                      } else {
                                        if($ttl->sistem_pembayaran=="KPR"){
                                          echo $ttls = $ttls + $ttl->jumlah_dp;
                                        } else if($ttl->sistem_pembayaran=="Cash"){
                                          echo $ttls = $ttls + $ttl->jumlah_dp+$ttl->lama_cash;
                                        } else {
                                          echo $ttls = $ttls + $ttl->lama_tempo+$ttl->jumlah_dp;
                                        }
                                      }
                                    }
                                  ?>
                                </td>
                                <!--END OF LAMA TEMPO-->
                                <td><?php echo date('d-m', strtotime($row->tanggal_dana))?></td>
                                <td style="white-space: nowrap;">
                                  <?php echo $row->cara_bayar?>
                                </td>
                                <td><?php echo number_format($row->dana_masuk)?>,-</td>
                                <td></td>
                                <td>
                                  <?php 
                                    // $total
                                    $test = $this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$row->id_psjb));
                                    // echo "<ul>";
                                    foreach($test->result() as $rows){
                                      echo "<li>".$rows->cara_pembayaran."-".$rows->nama_bank." ".$rows->tanggal_bayar." Rp. ".number_format($rows->pembayaran)."</li>";
                                    }
                                    // echo "</ul>";
                                  ?>
                                </td>
                                <td>
                                  <textarea style="height: 30px" name="ket[]"><?php echo $row->keterangan?></textarea> 
                                  <input type="hidden" value="<?php echo $row->id_psjb?>" name="id[]">
                                </td>
                            </tr>
                        <?php $no++;}}}
                  ?>
                <?php }?>
              </tbody>
            </table>
         </div>
     </p>
   </div>
</body></html>