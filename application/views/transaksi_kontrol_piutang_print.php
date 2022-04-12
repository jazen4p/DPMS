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
            Rekap Tagihan Piutang <br>
            <?php if($bulan == ""){?>
                Per. <?php echo date('F Y')?> <br><br>
            <?php } else {?>
                Per. <?php echo date('F Y', strtotime($bulan))?> <br><br>
            <?php }?>

            <table id="example1" class="table table-bordered table-striped" style="font-size: 12px">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Konsumen</th>
                    <th>Unit</th>
                    <th>Tgl Bayar</th>
                    <th>Tahap Pembayaran</th>
                    <th>Tagihan Bulan Ini</th>
                    <th>Total Tagihan</th>
                    <th>Pembayaran diterima</th>
                    <th><?php echo " Krg dari 30 hari";?></th>
                    <th>31-60 hari</th>
                    <th>61-90 hari</th>
                    <th>>90 hari</th>
                    <!-- <th>Total Piutang</th> -->
                    <th>Sisa</th>
                    <th>Persentase</th>
                </tr>
                </thead>
                <tbody style="">
                <?php $no=1; foreach($ppjb as $row){?>
                <tr>
                    <td><?php echo $no?></td>
                    <td><a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>"><?php echo $row->nama_pemesan?></a></td>
                    <td>
                        <?php echo $row->no_kavling?>
                        <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $row2){
                            echo ", ".$row2->kode_rumah;
                        }?>
                    </td>
                    
                    <?php
                        $query = $this->db->query("SELECT * FROM `ppjb-dp` WHERE no_psjb = '$row->no_psjb' AND status='lunas' ORDER BY id_psjb DESC LIMIT 1")->result();
                        // print_r($query);
                        // $penerimaan_biaya = 0;
                        $query2 = $this->db->query("SELECT * FROM `ppjb-dp` WHERE no_psjb = '$row->no_psjb' AND status='lunas'")->result();
                        foreach($query2 as $ppjb){
                            // $penerimaan_biaya = $penerimaan_biaya + $ppjb->dana_masuk;
                        }

                        foreach($query as $psjb){

                        // if($row->status=="belum lunas"){
                        //     $no_ppjb = $row->no_psjb;
                        //     $id_ppjb = $row->id_psjb;
            
                        //     $interval = strtotime($tanggal_masuk) - strtotime($today);
                        //     $day = floor($interval / 86400); // 1 day
                        //     if($day >= 1 && $day <= 7) {
                        //         $data['mendekati']++;
                        //     } elseif($day < 0) {
                        //         $data['melewati']++;
                        //     } elseif($day == 0) {
                        //         $data['hari_ini']++;
                        //     }
                        // }
                        // $time=strtotime($row->tanggal_dana);
                        // $month=date("m",$time);
                        // $year=date("Y",$time);
            
                        // $todays = strtotime($today) - strtotime($tanggal_masuk);
            
                        // $data['melewati'] = array(
                        //     'today'=>strtotime($today),
                        //     'tanggal_masuk'=>strtotime($tanggal_masuk),
                        //     'todays'=>$todays
                        // );

                        // $query = $this->db->get_where('');
                        $query3 = $this->db->query("SELECT * FROM `keuangan_kas_kpr` WHERE no_ppjb = $row->no_psjb ORDER BY id_keuangan DESC LIMIT 1");
                        foreach($query3->result() as $kas){
                            $tgl_kas = $kas->tanggal_bayar;
                        }

                        // $test = $this->db->get_where('psjb-dp', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'DATE_FORMAT(tanggal_dana, "%Y-%m")'=>date("Y-m", strtotime($bulan))));
                        
                        $test = $this->Dashboard_model->get_data($row->no_psjb, $row->kode_perumahan, "Uang Tanda Jadi", "KPR", $bulan);
                        // print_r($test->num_rows());
                        // echo $bulan;
                        
                        $ts = 0; $tls=0; $tls1 = 0;
                        $gets = $this->Dashboard_model->kontrol_piutang($row->no_psjb, $row->kode_perumahan, $bulan);
                        // print_r($gets->result());
                        foreach($gets->result() as $gts){
                            $tls = $tls + $gts->dana_masuk;
                        }

                        $var = $this->Dashboard_model->kontrol_piutang_bayar($row->no_psjb, $row->kode_perumahan, $bulan);
                        foreach($var->result() as $gts1){
                            $tls1 = $tls1 + $gts1->pembayaran;
                        }

                        $ts = $ts + ($tls-$tls1);
                        // print_r($tls);

                        $tl = 0;
                        foreach($this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb, 'tahap <>'=>"KPR", 'kode_perumahan'=>$row->kode_perumahan))->result() as $ks){
                            if(date('Y-m', strtotime($ks->tanggal_bayar)) == date('Y-m', strtotime($bulan))){
                            $tl = $tl + $ks->pembayaran;
                            }
                        }

                        if($test->num_rows() == 0){
                            // echo "<td></td>";
                            echo "<td>-</td><td>-</td><td>-</td><td>".number_format($ts)."</td><td>";
                            echo number_format($tl)."</td>";
                        }
                        else {

                            foreach($test->result() as $test1){
                            
                            $tanggal_masuk = $test1->tanggal_dana;

                            $joined = date("Y-m", strtotime($tanggal_masuk));

                            $monthyear = $bulan; 

                            
                            
                            // if($test1)
                            echo "<td>".$test1->tanggal_dana."</td>";
                            echo "<td>";
                            $query = $this->db->get_where('ppjb-dp', array('no_psjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'status'=>"belum lunas"), 1, 0)->result();
                            // print_r($query);
                            foreach($query as $dp) {
                                if($dp->cara_bayar != "Pembayaran DP (0%)" && $monthyear > date("Y-m", strtotime($dp->tanggal_dana))){
                                echo $dp->cara_bayar." - ";
                            }}
                            echo $test1->cara_bayar;
                            echo "</td>";

                            echo "<td>".number_format($test1->dana_masuk)."</td>";
                            echo "<td>".number_format($test1->dana_masuk + $ts).",-"."</td>";

                            $tl = 0;
                            // $penerimaan_biaya = 0;
                            foreach($this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb, 'tahap <>'=>"KPR", 'kode_perumahan'=>$row->kode_perumahan))->result() as $ks){
                                if(date('Y-m', strtotime($ks->tanggal_bayar)) == date('Y-m', strtotime($bulan))){
                                $tl = $tl + $ks->pembayaran;
                                }
                                // $penerimaan_biaya = $penerimaan_biaya + $ks->pembayaran;
                            }
                            echo "<td>".number_format($tl).",-</td>";
                            // echo "<td>".number_format($test1->dana_bayar).",-"."</td>";
                            
                            // if($test1->cara_bayar!="Uang Tanda Jadi" && $test1->cara_bayar!="KPR") {
                            //   if ($joined == $monthyear) {
                            //     $query = $this->db->get_where('ppjb', array('no_psjb'=>$test1->no_ppjb))->result();
                            //     foreach($query as $row2) {
                            //       ?>
                                    <!-- <td><?php echo $test1->tanggal_dana?></td>
                            //       <td style="white-space: nowrap">
                            //         <?php 
                            //           foreach($this->db->get_where('ppjb-dp', array('no_ppjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, 'status'=>"belum lunas"), 1, 0)-> result() as $dp) {
                            //             if($monthyear > date("Y-m", strtotime($dp->tanggal_dana))){
                            //               echo $dp->cara_bayar." - ";
                            //           }}
                            //           echo $test1->cara_bayar;
                            //         ?>
                            //       </td>
                            //       <td><?php echo number_format($test1->dana_masuk).",-";?></td>
                            //       <td><?php echo number_format($test1->dana_bayar).",-";?></td> -->
                                <?php 
                            //     } 
                            //   } 
                            // }
                            // print_r($test);
                                // echo "<td></td><td></td><td></td><td></td>";
                            }
                        }
                        // print_r($tgl_kas);
                    ?>
                        <!-- <td>
                            <?php if($query3->num_rows() > 0){ 
                                echo date('d', strtotime($kas->tanggal_bayar)); 
                            } else { 
                                echo date('d', strtotime($psjb->tanggal_dana));
                            }?>
                        </td>
                        <td>
                            <?php if($query3->num_rows() > 0){ 
                                echo $kas->tahap; 
                            } else { 
                                echo $psjb->cara_bayar;
                            }?>
                        </td>
                        <td><?php echo number_format($row->total_jual)?>,-</td> -->
                        <!-- <td><?php echo number_format($penerimaan_biaya)?>,-</td> -->
                        <?php 
                            $query4 = $this->db->query("SELECT * FROM `ppjb-dp` WHERE no_psjb = '$row->no_psjb' AND kode_perumahan = '$row->kode_perumahan' AND cara_bayar <> 'KPR' AND cara_bayar <> 'Uang Tanda Jadi'")->result();
                            // print_r($query4);
                            $hari30 = 0;
                            $hari60 = 0;
                            $hari90 = 0;
                            $hari90lbh = 0;
                            $today = $bulan;
                            // print_r($query4);
                            foreach($query4 as $row3){

                                $interval = strtotime($row3->tanggal_dana) - strtotime($today);
                                $day = floor($interval / 86400); // 1 day
                                // echo $day." ";
                                if($day < 0 && $day >= -30) {
                                    // $data['mendekati']++;
                                    $hari30 = $hari30 + $row3->dana_masuk;
                                } elseif($day < -30 && $day >= -60) {
                                    // $data['melewati']++;
                                    $hari60 = $hari60 + $row3->dana_masuk;
                                } elseif($day < -60 && $day >= -89) {
                                    // $data['hari_ini']++;
                                    $hari90 = $hari90 + $row3->dana_masuk;
                                } elseif($day <= -90){
                                    $hari90lbh = $hari90lbh + $row3->dana_masuk;
                                }
                            }

                            // if($hari90lbh > 0){
                            //     $hari90lbh = $hari90lbh + $hari30 + $hari60 + $hari90;
                            //     $hari30 = 0;
                            //     $hari60 = 0;
                            //     $hari90 = 0;
                            // } else if($hari90 > 0){
                            //     $hari90 = $hari90 + $hari30 + $hari60;
                            //     $hari30 = 0;
                            //     $hari60 = 0;
                            //     $hari90lbh = 0;
                            // } else if($hari60 > 0){
                            //     $hari60 = $hari60 + $hari30;
                            //     $hari30 = 0;
                            //     $hari90 = 0;
                            //     $hari90lbh = 0;
                            // } else {
                            //     $hari30 = $hari30;
                            //     $hari60 = 0;
                            //     $hari90 = 0;
                            //     $hari90lbh = 0;
                            // }
                            // echo $hari30." ".$hari60." ".$hari90." ".$hari90lbh;
                            $total_piutang = $hari30+$hari60+$hari90+$hari90lbh;
                        ?>
                        <td><?php echo number_format($hari30)?>,-</td>
                        <td><?php echo number_format($hari60)?>,-</td>
                        <td><?php echo number_format($hari90)?>,-</td>
                        <td><?php echo number_format($hari90lbh)?>,-</td>
                        <!-- <td>Rp. <?php echo number_format($total_piutang)?>,-</td> -->
                        <?php $penerimaan = 0;
                            
                        $keuangan = $this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb, 'kode_perumahan'=>$row->kode_perumahan, "tahap <>"=>"KPR"));
                        foreach($keuangan->result() as $keuangan){
                            $penerimaan = $penerimaan + $keuangan->pembayaran;
                        } ?>

                        <td><?php echo number_format($row->total_jual-$row->uang_awal-$penerimaan)?>,-</td>
                        <td><?php echo number_format((($penerimaan)/($row->total_jual-$row->uang_awal))*100, 2)?> %</td>
                        <!-- <td></td><td></td><td></td><td></td> -->
                    <?php }?>
                </tr>
                <?php $no++;}?>
                </tbody>
            </table>
        </div>
   </div>
</body></html>