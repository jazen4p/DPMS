<html><head>
   <style>
     @page { margin: 55px 50px 80px; }
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
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
   <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/bootstrap.min.css" />
   <script type="text/javascript">
    $(document).ready(function(){ 
        var check = $('#aktiva').val();
        // var i;
        $('#totalAktiva').html("Rp. "+check);
        // $('#volume1').val(check);
        var check2 = $('#passiva').val();
        // var i;
        $('#totalPassiva').html("Rp. "+check2);
        // $('#volume1').val(check);
    })
   </script>
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
            <div style="text-align: center; font-size: 14px">
                <div><b>REKAP PERSEDIAAN BAHAN DI LAPANGAN</b></div>
                <div>PEMBANGUNAN UNIT <?php echo strtoupper($nama_perumahan)?> RESIDENCE</div>
                <div>PERIODE <?php echo date('1 F', strtotime($tgl))." - ".date('t F Y', strtotime($tgl))?> </div>
            </div>
            <?php $ttl_date = date('t', strtotime($tgl));?>
            <table id="example2" class="table" border=1 style="font-size: 12px">
                <thead>
                    <tr style="background-color: lightblue">
                        <th rowspan=2>No</th>
                        <th rowspan=2>Nama Bahan</th>
                        <th colspan=2>Persediaan Bahan Per <?php echo date('1 F', strtotime($tgl))?></th>
                        <th colspan=2>Sisa Bahan Dari Sistem</th>
                        <th colspan=2>Cek Bahan Per <?php echo date('t F', strtotime($tgl))?></th>
                        <th rowspan=2>Selisih</th>
                        <!-- <th style="text-align: center; background-color: lightgreen" colspan=<?php echo (int)$ttl_date?>>BAHAN MASUK</th> -->
                        <!-- <th style="text-align: center; background-color: pink" colspan=<?php echo (int)$ttl_date?>>BAHAN KELUAR</th> -->
                        <th rowspan=2>Total Bahan Masuk</th>
                        <th rowspan=2>Total Bahan Keluar</th>
                    </tr>
                    <tr style="background-color: lightblue">
                        <th>QTY</th>
                        <th>SAT</th>
                        <th>QTY</th>
                        <th>SAT</th>
                        <th>QTY</th>
                        <th>SAT</th>
                        <?php for($i = 1; $i <= (int)$ttl_date; $i++){?>
                        <!-- <th style="background-color: lightgreen"><?php echo $i;?></th> -->
                        <?php }?>
                        <?php for($i = 1; $i <= (int)$ttl_date; $i++){?>
                        <!-- <th style="background-color: pink"><?php echo $i;?></th> -->
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($brg->result() as $row){?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td style="white-space: nowrap"><?php echo $row->nama_data?></td>
                        <?php $stss = 0;
                        // echo $dt;
                        // print_r($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $dt)->result());
                        if($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $dt)->num_rows() > 0){
                        foreach($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $dt)->result() as $sts){?>
                        <td><?php echo $sts->stok;
                            $stss = $stss + $sts->stok;
                        ?></td>
                        <td><?php echo $sts->nama_satuan?></td>
                        <?php }} else {?>
                        <td>0</td>
                        <td><?php echo $row->nama_satuan?></td>
                        <?php }?>

                        <?php $sisa = 0; $s_msk = 0; $s_keluar = 0;
                        $sisa = $sisa + $stss;
                        // print_r($this->Dashboard_model->get_arus_stok($row->nama_data, $kode_perumahan, $tgl, "keluar")->result());
                        foreach($this->Dashboard_model->get_arus_stok($row->nama_data, $kode_perumahan, $tgl, "masuk")->result() as $arus){
                        $sisa = $sisa + $arus->qty;
                        }
                        // echo "<td>".$sisa."</td>";
                        foreach($this->Dashboard_model->get_arus_stok($row->nama_data, $kode_perumahan, $tgl, "keluar")->result() as $arus1){
                        $sisa = $sisa - $arus1->qty;
                        }?>
                        <td><?php echo $sisa;?></td>
                        <td><?php echo $row->nama_satuan?></td>
                        <?php $str = 0;
                        if($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $tgl)->num_rows() > 0){
                        foreach($this->Dashboard_model->cek_stok_akhir_bulan($row->nama_data, $kode_perumahan, $tgl)->result() as $st){?>
                        <td><?php echo $st->stok;
                            $str = $str + $st->stok;
                        ?></td>
                        <td><?php echo $st->nama_satuan?></td>
                        <?php }} else {?>
                        <td>0</td>
                        <td><?php echo $row->nama_satuan?></td>
                        <?php }?>
                        <td><?php echo $str - $sisa?></td>

                        <?php $total_all = 0; 
                        for($i = 1; $i <= (int)$ttl_date; $i++){
                        $ht = date("Y-m-".sprintf('%02d', $i), strtotime($tgl)); $total_msk = 0;
                        // print_r($this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data, 'kode_perumahan'=>$kode_perumahan, 'jenis_arus'=>"masuk"))->result());
                        foreach($this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data, 'kode_perumahan'=>$kode_perumahan, 'jenis_arus'=>"masuk"))->result() as $ar){
                            // echo $ar->tgl_arus."<br>";
                            if(date('Y-m-d', strtotime($ar->tgl_arus)) == $ht){
                            $total_msk = $total_msk + $ar->qty;
                            }
                        }
                        $total_all = $total_all + $total_msk;
                        ?>
                        <?php if($total_msk > 0){?>
                            <!-- <td style="background-color: yellow"><?php echo $total_msk;?></td> -->
                        <?php } else {?>
                            <!-- <td style="background-color: lightgreen"></td> -->
                        <?php }?>
                        <?php }?>

                        <?php $total_all1 = 0;
                        for($i = 1; $i <= (int)$ttl_date; $i++){
                        $ht = date("Y-m-".sprintf('%02d', $i), strtotime($tgl)); $total_msk = 0;
                        foreach($this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data, 'kode_perumahan'=>$kode_perumahan, 'jenis_arus'=>"keluar"))->result() as $ar1){
                            if(date('Y-m-d', strtotime($ar1->tgl_arus)) == $ht){
                            $total_msk = $total_msk + $ar1->qty;
                            }
                        }
                        $total_all1 = $total_all1 + $total_msk;
                        ?>
                        <?php if($total_msk > 0){?>
                            <!-- <td style="background-color: yellow"><?php echo $total_msk;?></td> -->
                        <?php } else {?>
                            <!-- <td style="background-color: pink"></td> -->
                        <?php }?>
                        <?php }?>
                        <td><?php echo $total_all?></td>
                        <td><?php echo $total_all1?></td>
                    </tr>
                    <?php $no++;}?>
                </tbody>
            </table> 
        </div>
   </div>
</body></html>