<html><head>
   <style>
     @page { margin: 50px 80px 70px; }
     #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px;}
     #header img { position: fixed; left: 50px; top: -150px; right: 0px; height: 25px; text-align: center}
     #header p { position: fixed; left: 300px; top: -115px; right: 0px}
     #header h1 { position: fixed; left: 300px; top: -160px; right: 0px; font-size: large}
     #header hr { position: fixed; top: -50px; right: 0px; font-size: large; border-top: 1px solid}
     #footer { position: fixed; left: 0px; bottom: -100px; right: 0px; height: 130px; }
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
    <!-- <div id="header">
        MSGROUP
    </div> -->

    <div id="footer">
        <hr style="border-top: 1px solid">
        <p class="page" style='text-align: right'>
            <span style="padding-left:50px; "><b>System Automatic Printed</b></span>
        </p>
    </div>

    <div id="content">
        <?php foreach($check_all->result() as $row){?>
            <table style="width: 100%; table-layout: fixed">
              <tr>
                <td>
                  <img src="./gambar/logo_kencana.jpeg" style="width: 125px; height: 80px">
                </td>
                <td style="text-align: right">
                  MSGROUP
                </td>
              </tr>
            </table>
            <br>
            <div style="font-size: 12px">
                <table style="width: 100%">
                    <tr>
                        <td>Dicetak tanggal</td>
                        <td style='text-align: right'>Kasir</td>
                    </tr>
                    <tr>
                        <td>
                          <?php 
                            if($row->status != "lunas"){
                              echo date('d M Y H:i');
                            } else {
                              echo date('d M Y H:i', strtotime($row->status_date));
                            }?>
                        </td>
                        <td style='text-align: right'><?php echo $row->pembuat_struk?></td>
                    </tr>
                </table>
                <br>
                <table style="width: 100%">
                    <tr>
                        <td><?php echo "No.".sprintf('%09d', $row->id_struk)?></td>
                        <td style='text-align: right'>
                          Konsumen: <?php echo $row->nama_pemilik?> <br>
                          HP: <?php echo $row->hp_pemilik?> <br>
                          No Blok: <?php echo $row->kode_rumah?>
                        </td>
                    </tr>
                </table>
                
                <hr style="margin-bottom: -20px; border: 1px dotted black;">
                <table style="width: 100%">
                    <tr>
                        <td>List Item</td>
                        <td style='text-align: right'>Jumlah</td>
                    </tr>
                </table>
                <hr style="margin-top: 5px; border: 1px dotted black;">

                <table style="width: 100%">
                    <?php $ttl = 0;foreach($check_all_item->result() as $items){?>
                    <tr>
                        <td><?php echo $items->item?></td>
                        <?php if($items->jenis_tagihan=="maintenance"){?>
                          <td style='text-align: right'><?php echo number_format($items->nominal, 0, ",", ".")?></td>
                        <?php } else {?>
                          <td style='text-align: right'><?php echo number_format($items->nominal, 0, ",", ".")?></td>
                        <?php }?>
                    </tr>
                    <?php if($items->jenis_tagihan == "air"){
                        if($items->nominal > 80000){
                          foreach($this->db->get_where('konsumen_air', array('id_air'=>$items->id_tagihan))->result() as $airs){?>
                            <tr>
                              <td style="padding-left: 20px"><?php echo "Overuse Air : ".($airs->meteran-20)." m<sup>3</sup>";?></td>
                            
                          <?php }?>
                            
                              <td style='text-align: right'><?php echo number_format($items->nominal - $items->nominal, 0, ",", ".")?></td>
                            </tr>
                    <?php }}?>
                    <?php $ttl=$ttl+$items->nominal;}?>
                </table>
                
                <hr style="margin-top: 5px; border: 1px dotted black;">

                <table style="width: 100%; margin-top: -15px">
                    <tr>
                        <td>Subtotal</td>
                        <td style='text-align: right'><?php echo number_format($ttl, 0, ",", ".")?></td>
                    </tr>
                </table>

                <table style="width: 100%; margin-top: 10px">
                    <tr>
                        <td>Grand Total</td>
                        <td style='text-align: right'><?php echo "Rp. ".number_format($ttl, 0, ",", ".")?></td>
                    </tr>
                    <?php if($row->status == "lunas"){?>
                      <tr>
                          <?php
                          $banks = "";
                          foreach($this->db->get_where('bank', array('id_bank'=>$row->id_bank))->result() as $bank){
                              $banks = $bank->nama_bank;
                          }?>
                          <td><?php echo ucfirst($row->jenis_pembayaran)." ".$banks?></td>
                          <td style='text-align: right'><?php echo "Rp. ".number_format($row->pembayaran, 0, ",", ".")?></td>
                      </tr>
                    <?php }?>
                </table>
                <?php if($row->status == "diajukan") {?>
                  <br>
                  <div style="text-align: center">
                  ------------------------- TAGIHAN BELUM LUNAS ------------------------- <br><br>
                    <div style="margin-left: auto; margin-right: auto; width: 300px; padding: 5px; border: 2px solid black">
                      Transfer Rek. BCA
                      <table style="margin-left: auto; margin-right: auto">
                        <tr>
                          <td>Atas nama</td>
                          <td>:</td>
                          <td>Ediyanto</td>
                        </tr>
                        <tr>
                          <td>No. Rekening</td>
                          <td>:</td>
                          <td>0292607839</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                <?php } else if($row->status == "dibatalkan"){?>
                  <br>
                  <div style="text-align: center">
                  ------------------------- TAGIHAN DIBATALKAN -------------------------
                  </div>
                <?php } else if($row->status == "cicilan"){?>
                  <br>
                    <div style="text-align: center">
                    --------------------- TAGIHAN BELUM LUNAS (CICILAN) -------------------- <br><br>
                    </div>
                <?php } else {?>
                  <br>
                    <div style="text-align: center">
                    ----------------------------------------------------------------
                    </div>
                <?php }
                
                $qs = $this->db->get_where('konsumen_struk_cicil', array('no_struk'=>$row->id_struk));
                if($qs->num_rows() > 0){
                  ?>
                      <table style="width: 100%;">
                        <tr>
                          <th>Tgl Pembayaran</th>
                          <th>Keterangan</th>
                          <th>Pembayaran</th>
                          <th>Nominal</th>
                        </tr>
                        <?php foreach($this->db->get_where('konsumen_struk_cicil', array('no_struk'=>$row->id_struk))->result() as $cicil){?>
                          <tr>
                            <td><?php echo date('d-m-Y', strtotime($cicil->tgl_bayar))?></td>
                            <td><?php echo $cicil->keterangan?></td>
                            <td>
                              <?php echo $cicil->cara_pembayaran;
                                foreach($this->db->get_where('bank', array('id_bank'=>$cicil->id_bank))->result() as $bank){
                                  echo $bank->nama_bank;
                                }
                              ?>
                            </td>
                            <td><?php echo "Rp. ".number_format($cicil->nominal)?></td>
                          </tr>
                        <?php }?>
                      </table>
                    </div>
                <?php }?>
            </div>
        <?php }?>
    </div>
</body></html>