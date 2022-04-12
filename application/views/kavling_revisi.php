<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perjanjian Sementara Jual Beli (PSJB)</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item">Operasional</li>
              <li class="breadcrumb-item">Perumahan</li>
              <li class="breadcrumb-item active">PSJB</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($psjb_revisi)) {
        foreach($psjb_revisi as $row){?>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5>Catatan Revisi untuk PSJB No. 1-<?php echo $row->no_psjb?>/PPJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m", strtotime($row->tgl_psjb))?>/<?php echo date("Y", strtotime($row->tgl_psjb))?></h5>
                                </div>
                                <table class="table">
                                    <thead style="background-color: lightgreen">
                                        <td>No</td>
                                        <td>Catatan Revisi</td>
                                        <td>Oleh</td>
                                        <td>Pada</td>
                                    </thead>
                                    <?php $no=1; foreach($this->db->get_where('ppjb_sendback', array('no_psjb'=>$row->no_psjb))->result() as $dt){?>
                                        <tr>
                                            <td><?php echo $no?></td>
                                            <td><?php echo $dt->catatan?></td>
                                            <td><?php echo $dt->sendback_by?></td>
                                            <td><?php echo $dt->sendback_date?></td>
                                        </tr>
                                    <?php $no++;}?>
                                </table>
                            </div>
                        </div>
                    </section>
                
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>PSJB - Detail Pemesan</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <form role="form" action="<?php echo base_url()?>Dashboard/ppjb_revisi" onsubmit="myFunction()" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nomor Kavling</label>
                                    <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_psjb">
                                    <input type="hidden" value="<?php echo $row->psjb?>" name="psjb">
                                    <input type="text" class="form-control" id="id_kavling" placeholder="Nomor Kavling" name="id_kavling" value="<?php echo $row->no_kavling?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Perusahaan</label>
                                    <?php foreach($this->db->get_where('perusahaan', array('kode_perusahaan'=>$row->kode_perusahaan))->result() as $row2){?>
                                        <input type="text" class="form-control" placeholder="Nama Perusahaan" value="<?php echo $row2->nama_perusahaan?>" readonly>
                                    <?php }?>
                                    <input type="hidden" class="form-control" placeholder="Nama Perusahaan" name="nama_perusahaan" value="<?php echo $row->kode_perusahaan?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Perumahan</label>
                                    <!-- <input type="text" id="noKavling" name="nomor_kavling"/> -->
                                    <input type="text" class="form-control" placeholder="Nama Perumahan" name="nama_perumahan" value="<?php echo $row->perumahan?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Marketing</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Marketing" name="nama_marketing" value="<?php echo $row->nama_marketing?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Pemesan</label>
                                    <input type="text" class="form-control" id="inputNamaPemesan" placeholder="Nama Pemesan" name="nama_pemesan" value="<?php echo $row->nama_pemesan?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Dalam Sertifikat/PPJB</label>
                                    <input type="text" class="form-control" id="inputNamaSertifikat" placeholder="Nama Dalam Sertifikasi/PPJB" name="nama_sertif" value="<?php echo $row->nama_sertif?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat Lengkap</label>
                                    <textarea class="form-control" id="exampleInputPassword1" placeholder="Alamat Lengkap" name="alamat_lengkap" required><?php echo $row->alamat_lengkap?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat Surat</label>
                                    <textarea class="form-control" id="exampleInputPassword1" placeholder="Alamat Surat" name="alamat_surat" required><?php echo $row->alamat_surat?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No Telp Rumah</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="No Telp Rumah" name="no_telp" value="<?php echo $row->telp_rumah?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No Handphone</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="No Handphone" name="no_hp" value="<?php echo $row->telp_hp?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No KTP</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="No KTP" name="ktp" value="<?php echo $row->ktp?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Pekerjaan</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Pekerjaan" name="pekerjaan" value="<?php echo $row->pekerjaan?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmailNPWP">NPWP</label>
                                    <input type="text" class="form-control" id="exampleInputEmailNPWP" placeholder="No. NPWP" name="npwp" value="<?php echo $row->npwp?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmailEmail">E-mail</label>
                                    <input type="email" class="form-control" id="exampleInputEmailEmail" placeholder="E-mail" name="email" value="<?php echo $row->email?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Uang Tanda Jadi</label>
                                    <input type="number" class="form-control" id="tandaJadi1" placeholder="Tanda Jadi" name="uang_awal" value="<?php echo $row->uang_awal?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>PSJB - Pembiayaan</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Luas Tanah m<sup>2</sup></label>
                                    <input type="number" class="form-control" id="luas_tanah" placeholder="Luas Tanah" name="luas_tanah" value="<?php echo $row->luas_tanah?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Luas Bangunan m<sup>2</sup></label>
                                    <input type="number" class="form-control" id="luas_bangunan" placeholder="Luas Bangunan" name="luas_bangunan" value="<?php echo $row->luas_bangunan?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tipe Standart</label>
                                    <input type="number" class="form-control" id="tipe_standart" placeholder="Tipe Standart" name="tipe_standart" value="<?php echo $row->tipe_rumah?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Harga Jual Standart (Rp)</label>
                                    <input type="number" class="form-control" id="myInput3" placeholder="0" name="harga_jual_standart" value="<?php echo $row->harga_jual?>" required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Cara Pembayaran</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <select class="form-control" id="myInput4" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <option disabled selected value="">-- Pilih -- </option> 
                                        <option value="Cash">Cash</option>
                                        <option value="Tempo">Tempo</option>
                                        <option value="KPR">KPR</option>
                                    </select>
                                    <span>Cara pembayaran saat ini: <?php echo $row->sistem_pembayaran?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hadap Timur (Rp)</label>
                                    <input type="number" class="form-control" id="hadapTimur" placeholder="0" name="hadap_timur" value="<?php echo $row->hadap_timur?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Diskon Penjualan (Rp)</label>
                                    <input type="number" class="form-control" id="myInput1" placeholder="0" name="diskon_penjualan" value="<?php echo $row->disc_jual?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Total Penjualan (Rp)</label>
                                    <input type="number" class="form-control" id="myInput2" placeholder="NaN" name="total_penjualan" value="<?php echo $row->total_jual?>" readonly>
                                    <!-- <input type="number" id="myInput1" />
                                    <input type="number" id="myInput2" /> -->
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Catatan Pembayaran</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="No Telp" name="telp"> -->
                                    <textarea  class="form-control" id="exampleInputPassword1" placeholder="Catatan Pembayaran" name="catatan"><?php echo $row->catatan?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>PSJB - Pembayaran</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h5>Keterangan Pemesanan Kavling</h5>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Pemesan</label>
                                    <input type="text" class="form-control" id="namaPemesan" placeholder="" value="<?php echo $row->nama_pemesan?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hadap Timur</label>
                                    <input type="number" class="form-control" id="hadapTimurBayar" placeholder="" value="<?php echo $row->hadap_timur?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Sertifikat</label>
                                    <input type="text" class="form-control" id="namaSertifikat" placeholder="" value="<?php echo $row->nama_sertif?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Diskon</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="diskon" placeholder="" value=<?php echo $row->disc_jual?> readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tanggal Tanda Jadi</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="date" class="form-control" id="tglTandaJadi" placeholder="" value="<?php echo $row->tgl_psjb?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Harga Sepakat</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="hargaSepakat" placeholder="" value="<?php echo $row->total_jual?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tipe Pembayaran</label>
                                    <input type="text" class="form-control" id="tipePembayaran" placeholder="" value="<?php echo $row->sistem_pembayaran?>" readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="exampleInputPassword1">Biaya Kekurangan</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                    <input type="number" class="form-control" id="biayaKekurangan" placeholder="" value="<?php echo $row->total_jual-$row->uang_awal?>" readonly>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanda Jadi</label>
                                    <input type="number" class="form-control" id="tandaJadi" placeholder="" value="<?php echo $row->uang_awal?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total Kekurangan Rencana Bayar</label>
                                    <input type="number" class="form-control" id="totalKekuranganRencanaBayar" placeholder="" value="<?php echo $row->total_jual-$row->uang_awal?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h5>Rencana Pembayaran <input type="text" style="border: 0" id="myInput5" value=<?php echo $row->sistem_pembayaran?> readonly/></h5>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <th></th>
                                    <th>Tahap Pembayaran</th>
                                    <th>Persen</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Cara Pembayaran</th>
                                    <th>Lama Bayar</th>
                                    <th>Nominal</th>
                                </thead>

                                <tr>
                                    <td>1.</td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option value="DP">Down Payment</option>
                                            <option value="KPR">KPR</option>
                                        </select> -->
                                        <input type="text" class="form-control" value="Uang Tanda Jadi" name="uang_tandajadi" readonly/>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" readonly/> -->
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" id="tanggalJadiPembayaran" value="<?php echo $row->tgl_psjb?>" readonly/>
                                    </td>
                                    <td>
                                        <?php if(isset($psjb_revisi)){?>
                                            <span>Pembayaran BFee saat ini: <?php echo $row->nama_bank?></span>
                                        <?php } else {?>
                                            <select class="form-control" name="bank_awal" required>
                                                <option disabled selected value="">-Pilih-</option>
                                                <?php foreach($this->db->get('bank')->result() as $row3){?>
                                                    <option value="<?php echo $row3->id_bank?>"><?php echo $row3->nama_bank?></option>
                                                <?php }?>
                                            </select>
                                        <?php }?>
                                    </td><td></td>
                                    <td>
                                        <input type="number" class="form-control" id="tandaJadiPembayaran" value="<?php echo $row->uang_awal?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option value="DP">Down Payment</option>
                                            <option value="KPR">KPR</option>
                                        </select> -->
                                        <input type="text" class="form-control" value="DP" readonly/>
                                    </td>
                                    <td>
                                        <select class="form-control" name="persenDP_selector" id="persenDPSelector" required>
                                            <option value="" disabled selected>-Pilih-</option>
                                            <option value="manual">Auto</option>
                                            <option value="auto">Manual</option>
                                        </select>
                                        <input type="number" class="form-control" id="persenDP" name="persenDP" value="<?php echo $row->persen_dp?>" required/>
                                        <span>Persen DP saat ini: <?php echo $row->persen_dp?></span>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="tglDP" value="<?php echo $row->tgl_dp?>" required/>
                                    </td>
                                    <td>
                                        <select class="form-control" id="caraDP" name="caraDP" required>
                                            <option disabled selected value="">-Pilih-</option>
                                            <option value="cash">Cash Lunas</option>
                                            <option value="cicil">Cicil</option>
                                        </select>
                                        <span>DP saat ini: <?php echo $row->cara_dp?></span>
                                    </td>
                                    <td>
                                        <div id="cicil" class="formLamaDP" style="display:none">
                                            <select class="form-control" id="lamaDP" name="lamaDP">
                                                <!-- <option disabled selected>-Pilih-</option> -->
                                                <!-- <option>1</option> -->
                                                <option value="3">3</option>
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="24">24</option>
                                                <option value="36">36</option>
                                            </select>
                                        </div>
                                        <span>DP saat ini: <?php if($row->cara_dp == "cash"){ echo 1;} else { echo $row->jumlah_dp;}?></span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="totalDP" name="totalDP" value="<?php echo $row->total_dp?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option value="DP">Down Payment</option>
                                            <option value="KPR">KPR</option>
                                        </select> -->
                                        <input type="text" class="form-control" id="byr1" readonly required/>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="persenDP" name="persenDP"/> -->
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="tglKPR" value="<?php echo $row->tgl_kpr?>" required/>
                                    </td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option>Cicil</option>
                                            <option>Cash Lunas</option>
                                        </select> -->
                                        <span>Pembayaran saat ini: <?php echo $row->sistem_pembayaran?></span>
                                    </td>
                                    <td>
                                        <div id="Tempo" class="formLamaTempo" style="display:none">
                                            <select class="form-control" id="lamaTempo" name="lama_tempo" required>
                                                <!-- <option disabled selected>-Pilih-</option> -->
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="24">24</option>
                                                <option value="36">36</option>
                                            </select>
                                        </div>
                                        <div id="Cash" class="formLamaCash" style="display:none">
                                            <select class="form-control" name="lama_cash" required>
                                                <!-- <option disabled selected>-Pilih-</option> -->
                                                <option value="1">1</option>   
                                                <option value="2">2</option>   
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                        <?php if($row->sistem_pembayaran == "Tempo"){?>
                                            <span>Lama pembayaran saat ini: <?php echo $row->lama_tempo?></span>
                                        <?php } else {?>
                                            <span>Lama pembayaran saat ini: <?php echo $row->lama_cash?></span>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="totalKPR" name="totalKPR" value="<?php echo $row->total_kpr?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option value="DP">Down Payment</option>
                                            <option value="KPR">KPR</option>
                                        </select> -->
                                        <input type="text" class="form-control" id="byr1" value="Bunga (Cash Tempo)" readonly required/>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="persenBunga" name="persen_bunga" required readonly value="<?php echo $row->persen_bunga?>"/>
                                    </td>
                                    <td>
                                        <!-- <input type="date" class="form-control" name="tglKPR" required/> -->
                                    </td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option>Cicil</option>
                                            <option>Cash Lunas</option>
                                        </select> -->
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="totalBunga" name="totalBunga" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td></td>
                                    <td colspan=2>
                                        <span>Pastikan nominal berjumlah 0!</span>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                         <input type="number" class="form-control" id="nominalTotal" value="<?php echo $row->total_jual-$row->uang_awal-$row->total_dp-$row->total_kpr?>" readonly/>   
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- <div id="KPR" class="formSelect" style="display:none">
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h2>PSJB - Simulasi Pembayaran (KPR)</h2>
                                        <span style="color:green">Abaikan jika pembayaran selain KPR</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bank</label>
                                        <select class="form-control">
                                            <?php foreach($this->db->get('bank')->result() as $row){?>
                                            <option value="<?php echo $row->id_bank?>"><?php echo $row->nama_bank?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Sertifikat</label>
                                        <input type="text" class="form-control" id="namaSertifikat" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Total Kekurangan Rencana Bayar</label>
                                        <input type="number" class="form-control" id="totalKekuranganRencanaBayar" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Harga Sepakat</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="number" class="form-control" id="hargaSepakat" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tanda Jadi</label>
                                        <input type="number" class="form-control" id="tandaJadi" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tanggal Tanda Jadi</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="date" class="form-control" id="tglTandaJadi" placeholder="" value="<?php echo date("Y-m-d")?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Diskon</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="number" class="form-control" id="diskon" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Biaya Kekurangan</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="number" class="form-control" id="biayaKekurangan" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tipe Pembayaran</label>
                                        <input type="text" class="form-control" id="tipePembayaran" placeholder="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="card-footer">
                        <span style="color: green">Saya selaku <?php echo $role?> menyatakan PPJB ini telah direvisi, ditutup dan menunggu approval.</span><br>
                        <input type="submit" class="btn btn-primary" value="Submit" />
                    </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
    <?php }} else {?>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->
                
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>PSJB - Detail Pemesan</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <form role="form" action="<?php echo base_url()?>Dashboard/get_kavling" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nomor Kavling</label>
                                    <?php if(isset($kavling)){?>
                                        <select class="form-control" id="id_kavling" placeholder="Nomor Kavling" name="id_kavling" required>
                                        <?php foreach($this->db->get('rumah')->result() as $row){?>
                                            <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nomor Kavling" name="nomor_kavling" required> -->
                                            <?php if($row->status == "free"){ 
                                                foreach($kavling as $row2){
                                                    if($row2->kode_rumah == $row2->kode_rumah){?>
                                                    <option value="<?php echo $row->kode_rumah?>"><?php echo $row->kode_rumah?></option>
                                            <?php }}}?>
                                        <?php }?>
                                        </select>
                                    <?php } else{?>
                                        <select class="form-control" id="id_kavling" placeholder="Nomor Kavling" name="id_kavling" required>
                                        <?php foreach($this->db->get('rumah')->result() as $row){?>
                                            <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nomor Kavling" name="nomor_kavling" required> -->
                                            <?php if($row->status == "free"){?>
                                                <option value="<?php echo $row->kode_rumah?>"><?php echo $row->kode_rumah?></option>
                                            <?php }?>
                                        <?php }?>
                                        </select>
                                    <?php }?>
                                    <input class="" type="submit" value="ok">
                                    <?php if(isset($kavling)){ foreach($kavling as $row){?>
                                        Pilihan sekarang: <input type="text" value="<?php echo $row->kode_rumah?>" readonly>
                                    <?php }}?>
                                </div>
                            </form>
                            <form role="form" action="<?php echo base_url()?>Dashboard/add_psjb" onsubmit="myFunction()" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Perusahaan</label>
                                    <?php if(isset($kavling)){ foreach($kavling as $row){?>
                                        <?php foreach($this->db->get_where('perusahaan', array('kode_perusahaan'=>$row->nama_perusahaan))->result() as $row2){?>
                                            <input type="text" class="form-control" value="<?php echo $row2->nama_perusahaan?>" readonly>
                                        <?php }?>
                                        <input type="hidden" value="<?php echo $row->nama_perusahaan?>" name="nama_perusahaan">
                                        <input type="hidden" value="<?php echo $row->kode_rumah?>" name="id_kavling">
                                    <?php }} else{?>
                                        <input type="text" class="form-control" placeholder="Nama Perusahaan" required>
                                    <?php }?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Perumahan</label>
                                    <!-- <input type="text" id="noKavling" name="nomor_kavling"/> -->
                                    <?php if(isset($kavling)){ foreach($kavling as $row){?>
                                        <input type="text" class="form-control" value="<?php echo $row->nama_perumahan?>" name="nama_perumahan" readonly>
                                    <?php }} else{?>
                                        <input type="text" class="form-control" placeholder="Nama Perumahan" required>
                                    <?php }?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Marketing</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Marketing" name="nama_marketing">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Pemesan</label>
                                    <input type="text" class="form-control" id="inputNamaPemesan" placeholder="Nama Pemesan" name="nama_pemesan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Dalam Sertifikat/PPJB</label>
                                    <input type="text" class="form-control" id="inputNamaSertifikat" placeholder="Nama Dalam Sertifikasi/PPJB" name="nama_sertif" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat Lengkap</label>
                                    <textarea class="form-control" id="exampleInputPassword1" placeholder="Alamat Lengkap" name="alamat_lengkap" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat Surat</label>
                                    <textarea class="form-control" id="exampleInputPassword1" placeholder="Alamat Surat" name="alamat_surat" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No Telp Rumah</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="No Telp Rumah" name="no_telp" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No Handphone</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="No Handphone" name="no_hp" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No KTP</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="No KTP" name="ktp" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Uang Tanda Jadi</label>
                                    <input type="number" class="form-control" id="tandaJadi1" placeholder="Tanda Jadi" name="uang_awal" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>PSJB - Pembiayaan</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if(isset($kavling)){
                                    foreach($kavling as $row){?>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Luas Tanah m<sup>2</sup></label>
                                            <input type="number" class="form-control" id="luas_tanah" placeholder="Luas Tanah" name="luas_tanah" value="<?php echo $row->luas_tanah?>" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Luas Bangunan m<sup>2</sup></label>
                                            <input type="number" class="form-control" id="luas_bangunan" placeholder="Luas Bangunan" name="luas_bangunan" value="<?php echo $row->luas_bangunan?>" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Tipe Standart</label>
                                            <input type="number" class="form-control" id="tipe_standart" placeholder="Tipe Standart" name="tipe_standart" value="<?php echo $row->tipe_rumah?>" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Harga Jual Standart (Rp)</label>
                                            <input type="number" class="form-control" id="myInput3" placeholder="0" name="harga_jual_standart" value="<?php echo $row->harga_jual?>" required readonly>
                                        </div>
                                <?php }} else {?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Luas Tanah m<sup>2</sup></label>
                                        <input type="number" class="form-control" id="luas_tanah" placeholder="Luas Tanah" name="luas_tanah" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Luas Bangunan m<sup>2</sup></label>
                                        <input type="number" class="form-control" id="luas_bangunan" placeholder="Luas Bangunan" name="luas_bangunan" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tipe Standart</label>
                                        <input type="number" class="form-control" id="tipe_standart" placeholder="Tipe Standart" name="tipe_standart" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Harga Jual Standart (Rp)</label>
                                        <input type="number" class="form-control" id="myInput3" placeholder="0" name="harga_jual_standart" required readonly>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Cara Pembayaran</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <select class="form-control" id="myInput4" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <option disabled selected value="">-- Pilih -- </option> 
                                        <option value="Cash">Cash</option>
                                        <option value="Tempo">Tempo</option>
                                        <option value="KPR">KPR</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Diskon Penjualan (Rp)</label>
                                    <input type="number" class="form-control" id="myInput1" placeholder="0" name="diskon_penjualan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Total Penjualan (Rp)</label>
                                    <input type="number" class="form-control" id="myInput2" placeholder="NaN" name="total_penjualan" readonly>
                                    <!-- <input type="number" id="myInput1" />
                                    <input type="number" id="myInput2" /> -->
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Catatan Pembayaran</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="No Telp" name="telp"> -->
                                    <textarea  class="form-control" id="exampleInputPassword1" placeholder="Catatan Pembayaran" name="catatan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>PSJB - Pembayaran</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h5>Keterangan Pemesanan Kavling</h5>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Pemesan</label>
                                    <input type="text" class="form-control" id="namaPemesan" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Sertifikat</label>
                                    <input type="text" class="form-control" id="namaSertifikat" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total Kekurangan Rencana Bayar</label>
                                    <input type="number" class="form-control" id="totalKekuranganRencanaBayar" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Harga Sepakat</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="hargaSepakat" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanda Jadi</label>
                                    <input type="number" class="form-control" id="tandaJadi" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tanggal Tanda Jadi</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="date" class="form-control" id="tglTandaJadi" placeholder="" value="<?php echo date("Y-m-d")?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Diskon</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="diskon" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Biaya Kekurangan</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="biayaKekurangan" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tipe Pembayaran</label>
                                    <input type="text" class="form-control" id="tipePembayaran" placeholder="" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h5>Rencana Pembayaran <input type="text" style="border: 0" id="myInput5" readonly/></h5>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <th></th>
                                    <th>Tahap Pembayaran</th>
                                    <th>Persen</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Cara Pembayaran</th>
                                    <th>Lama Bayar</th>
                                    <th>Nominal</th>
                                </thead>

                                <tr>
                                    <td>1.</td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option value="DP">Down Payment</option>
                                            <option value="KPR">KPR</option>
                                        </select> -->
                                        <input type="text" class="form-control" value="Uang Tanda Jadi" name="uang_tandajadi" readonly/>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" readonly/> -->
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" id="tanggalJadiPembayaran" readonly/>
                                    </td>
                                    <td></td><td></td>
                                    <td>
                                        <input type="number" class="form-control" id="tandaJadiPembayaran" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option value="DP">Down Payment</option>
                                            <option value="KPR">KPR</option>
                                        </select> -->
                                        <input type="text" class="form-control" value="DP" readonly/>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="persenDP" name="persenDP" required/>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="tglDP" required/>
                                    </td>
                                    <td>
                                        <select class="form-control" id="caraDP" name="caraDP">
                                            <!-- <option disabled selected>-Pilih-</option> -->
                                            <option value="cash">Cash Lunas</option>
                                            <option value="cicil">Cicil</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div id="cicil" class="formLamaDP" style="display:none">
                                            <select class="form-control" id="lamaDP" name="lamaDP">
                                                <!-- <option disabled selected>-Pilih-</option> -->
                                                <!-- <option>1</option> -->
                                                <option value="3">3</option>
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="24">24</option>
                                                <option value="36">36</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="totalDP" name="totalDP" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option value="DP">Down Payment</option>
                                            <option value="KPR">KPR</option>
                                        </select> -->
                                        <input type="text" class="form-control" id="byr1" readonly required/>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="persenDP" name="persenDP"/> -->
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="tglKPR" required/>
                                    </td>
                                    <td>
                                        <!-- <select class="form-control">
                                            <option>Cicil</option>
                                            <option>Cash Lunas</option>
                                        </select> -->
                                    </td>
                                    <td>
                                        <div id="Tempo" class="formLamaTempo" style="display:none">
                                            <select class="form-control" name="lama_tempo" required>
                                                <!-- <option disabled selected>-Pilih-</option> -->
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="24">24</option>
                                                <option value="36">36</option>
                                            </select>
                                        </div>
                                        <div id="Cash" class="formLamaCash" style="display:none">
                                            <select class="form-control" name="lama_cash" required>
                                                <!-- <option disabled selected>-Pilih-</option> -->
                                                <option value="1">1</option>    
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="totalKPR" name="totalKPR" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td></td>
                                    <td colspan=2>
                                        <span>Pastikan nominal berjumlah 0!</span>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                         <input type="number" class="form-control" id="nominalTotal"  readonly/>   
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- <div id="KPR" class="formSelect" style="display:none">
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h2>PSJB - Simulasi Pembayaran (KPR)</h2>
                                        <span style="color:green">Abaikan jika pembayaran selain KPR</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bank</label>
                                        <select class="form-control">
                                            <?php foreach($this->db->get('bank')->result() as $row){?>
                                            <option value="<?php echo $row->id_bank?>"><?php echo $row->nama_bank?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Sertifikat</label>
                                        <input type="text" class="form-control" id="namaSertifikat" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Total Kekurangan Rencana Bayar</label>
                                        <input type="number" class="form-control" id="totalKekuranganRencanaBayar" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Harga Sepakat</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="number" class="form-control" id="hargaSepakat" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tanda Jadi</label>
                                        <input type="number" class="form-control" id="tandaJadi" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tanggal Tanda Jadi</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="date" class="form-control" id="tglTandaJadi" placeholder="" value="<?php echo date("Y-m-d")?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Diskon</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="number" class="form-control" id="diskon" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Biaya Kekurangan</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                        <input type="number" class="form-control" id="biayaKekurangan" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tipe Pembayaran</label>
                                        <input type="text" class="form-control" id="tipePembayaran" placeholder="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="card-footer">
                        <span style="color: green">Saya selaku <?php echo $role?> menyatakan PPJB ini ditutup dan menunggu approval.</span><br>
                        <input type="submit" class="btn btn-primary" value="Submit" />
                    </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
    <?php }?>
    <!-- /.content -->
    
    </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<script type="text/javascript">
  var input1 = document.getElementById('myInput1');
  var input2 = document.getElementById('myInput2');
  var input3 = document.getElementById('myInput3');

  var input4 = document.getElementById('myInput4');
  var input5 = document.getElementById('myInput5');

  var input6 = document.getElementById('inputNamaPemesan');
  var input7 = document.getElementById('inputNamaSertifikat');
  var input8 = document.getElementById('namaPemesan');
  var hargaSepakat = document.getElementById('hargaSepakat');
  var tglTandaJadi = document.getElementById('tglTandaJadi');
  var biayaKekurangan = document.getElementById('biayaKekurangan');
  var input9 = document.getElementById('namaSertifikat');
  var tandaJadi = document.getElementById('tandaJadi');
  var diskon = document.getElementById('diskon');
  var tipePembayaran = document.getElementById('tipePembayaran');
  var totalKekuranganRencanaBayar = document.getElementById('totalKekuranganRencanaBayar');
  var tandaJadi1 = document.getElementById('tandaJadi1');

  var tanggalJadiPembayaran = document.getElementById('tanggalJadiPembayaran');
  var tandalJadiPembayaran = document.getElementById('tandaJadiPembayaran');
  var nominalTotal = document.getElementById('nominalTotal');
  var persenDP = document.getElementById('persenDP');
  var totalDP = document.getElementById('totalDP');
  var totalKPR = document.getElementById('totalKPR');
  var byr1 = document.getElementById('byr1');
  var formKPR = document.getElementById('formKPR');

  var hadapTimur = document.getElementById('hadapTimur');
  var hadapTimurBayar = document.getElementById('hadapTimurBayar');

  input4.addEventListener('change', function() {
    input5.value = input4.value;
    tipePembayaran.value = input4.value;
    byr1.value = input4.value;

    if(input4.value == "Cash"){
        persenDP.placeholder = 50;
    } else if(input4.value == "KPR"){
        persenDP.placeholder = 15;
    } else {
        persenDP.placeholder = 20;
    }
  });

  input6.addEventListener('input', function() {
    input8.value = input6.value;
  });

  input7.addEventListener('input', function() {
    input9.value = input7.value;
  });

  persenDP.addEventListener('input', function() {
    totalDP.value = ((hargaSepakat.value - tandaJadi.value) * persenDP.value)/100;
    nominalTotal.value = (hargaSepakat.value - tandaJadi.value) - totalDP.value;

    totalKPR.value = hargaSepakat.value - totalDP.value - tandaJadi.value;

    nominalTotal.value = (hargaSepakat.value - tandaJadi.value) - totalDP.value - totalKPR.value;
  });

  hadapTimur.addEventListener('input', function() {
    input2.value = (parseInt(input3.value) + parseInt(hadapTimur.value)) - input1.value;
    // alert(input2.value);

    hadapTimurBayar.value = hadapTimur.value;

    nominalTotal.value = (parseInt(hargaSepakat.value) + parseInt(hadapTimur.value) - tandaJadi.value) - totalDP.value;

    hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - diskon.value;

    // input2.value = (parseInt(input3.value) + parseInt(hadapTimur.value)) - input1.value;
    // diskon.value = input1.value;
    // hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - input1.value;
    // biayaKekurangan.value = hargaSepakat.value - tandaJadi.value;
    totalKekuranganRencanaBayar.value = hargaSepakat.value - tandaJadi.value;

    // nominalTotal.value = hargaSepakat.value-tandaJadi.value;
  });

  tandaJadi1.addEventListener('input', function() {
    input2.value = (parseInt(input3.value) + parseInt(hadapTimur.value)) - input1.value;
    // alert(input2.value);

    tandaJadi.value = tandaJadi1.value;
    tanggalJadiPembayaran.value = tglTandaJadi.value;
    tandaJadiPembayaran.value = tandaJadi1.value;

    nominalTotal.value = (parseInt(hargaSepakat.value) + parseInt(hadapTimur.value) - tandaJadi.value) - totalDP.value - totalKPR.value;
    totalKPR.value = hargaSepakat.value - totalDP.value - tandaJadi1.value; 

    hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - input1.value;

    // biayaKekurangan.value = hargaSepakat.value - diskon.value - tandaJadi.value;
    // hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - input1.value;
    totalKekuranganRencanaBayar.value = hargaSepakat.value - tandaJadi.value;
    // biayaKekurangan.value = hargaSepakat.value - tandaJadi.value;
    // totalKekuranganRencanaBayar.value = biayaKekurangan.value;

    // hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - input1.value;

    nominalTotal.value = (parseInt(hargaSepakat.value) + parseInt(hadapTimur.value) - tandaJadi.value) - totalDP.value - totalKPR.value;
    // nominalTotal.value = (parseInt(hargaSepakat.value) + parseInt(hadapTimur.value) - tandaJadi.value) - totalDP.value;
  });

  input1.addEventListener('input', function() {
    input2.value = (parseInt(input3.value) + parseInt(hadapTimur.value)) - input1.value;
    diskon.value = input1.value;
    hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - input1.value;
    // biayaKekurangan.value = hargaSepakat.value - tandaJadi.value;
    totalKekuranganRencanaBayar.value = hargaSepakat.value - tandaJadi.value;

    nominalTotal.value = hargaSepakat.value-tandaJadi.value;
  });

  totalDP.addEventListener('input', function() {
    nominalTotal.value = (hargaSepakat.value - tandaJadi.value) - totalKPR.value;

    totalKPR.value = hargaSepakat.value - totalDP.value - tandaJadi.value;

    nominalTotal.value = (hargaSepakat.value - tandaJadi.value) - totalDP.value - totalKPR.value;
  });

  const numInputs = document.querySelectorAll('input[type=number]')

    numInputs.forEach(function(input) {
        tandaJadi1.addEventListener('input', function(e) {
            if (e.target.value == '') {
                e.target.value = 0;

                input2.value = (parseInt(input3.value) + parseInt(hadapTimur.value)) - input1.value;

                tandaJadi.value = 0;
                tanggalJadiPembayaran.value = tglTandaJadi.value;
                tandaJadiPembayaran.value = 0;

                nominalTotal.value = (parseInt(hargaSepakat.value) + parseInt(hadapTimur.value) - 0) - totalDP.value - totalKPR.value;
                totalKPR.value = hargaSepakat.value - totalDP.value - tandaJadi1.value; 

                hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - input1.value;

                totalKekuranganRencanaBayar.value = hargaSepakat.value - 0;

                nominalTotal.value = (parseInt(hargaSepakat.value) + parseInt(hadapTimur.value) - 0) - totalDP.value - totalKPR.value;
            }
        })
        hadapTimur.addEventListener('input', function(e) {
            if (e.target.value == '') {
                e.target.value = 0;
                
                input2.value = (parseInt(input3.value) + 0) - input1.value;
                // alert(input2.value);

                hadapTimurBayar.value = hadapTimur.value;

                nominalTotal.value = hargaSepakat.value - tandaJadi.value - totalDP.value - totalKPR.value;

                // hargaSepakat.value = parseInt(input3.value) + 0 - input1.value;
                hargaSepakat.value = parseInt(input3.value) - diskon.value;

                // input2.value = (parseInt(input3.value) + parseInt(hadapTimur.value)) - input1.value;
                // diskon.value = input1.value;
                // hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - input1.value;
                // biayaKekurangan.value = hargaSepakat.value - tandaJadi.value;
                totalKekuranganRencanaBayar.value = hargaSepakat.value - tandaJadi.value;
            }
        })
        input1.addEventListener('input', function(e) {
            if (e.target.value == '') {
                e.target.value = 0;

                input2.value = (parseInt(input3.value) + parseInt(hadapTimur.value)) - 0;
                diskon.value = 0;
                hargaSepakat.value = parseInt(input3.value) + parseInt(hadapTimur.value) - 0;
                // biayaKekurangan.value = hargaSepakat.value - tandaJadi.value;
                totalKekuranganRencanaBayar.value = hargaSepakat.value - tandaJadi.value;

                nominalTotal.value = hargaSepakat.value-tandaJadi.value;
            }
        })
    })
</script>
<script type="text/javascript">
$(function() {
    $('#myInput4').change(function(){
        $('.formSelect').hide();
        $('#' + $(this).val()).show();
    });

    $('#myInput4').change(function(){
        if($(this).val() == "Tempo"){
            $('#persenBunga').removeAttr('readonly');
        } else {
            $('#persenBunga').attr('readonly', 'readonly');
            $('#persenBunga').val(0);
        }
    })

    $('#lamaTempo').change(function(){
        if($(this).val() == "24"){
            $('#persenBunga').val(10);
        } else if($(this).val() == "36"){
            $('#persenBunga').val(12);
        } else {
            $('#persenBunga').val(0);
        }
    })
});
</script>
<script>
$(function() {
    $('#caraDP').change(function(){
        $('.formLamaDP').hide();
        $('#' + $(this).val()).show();
    });
});
</script>
<script>
$(function() {
    $('#myInput4').change(function(){
        $('.formLamaTempo').hide();
        $('.formLamaCash').hide();
        $('#' + $(this).val()).show();
    });
});

$(function() {
    $('#persenDPSelector').change(function (){
        if($(this).val() == "auto"){
            $('#persenDP').val(0);
            $('#persenDP').attr('readonly', 'readonly');
            $('#totalDP').removeAttr('readonly');
        }
        else {
            $('#persenDP').val("");
            $('#persenDP').removeAttr('readonly');
            // $('#totalDP').val("");
            $('#totalDP').attr('readonly', 'readonly');
        }
    });
});

//  function handleSelect() {
//      if (document.getElementById('myInput4').options[document.getElementById('myInput4').selectedIndex].value == 'Tempo') {
//          document.getElementById('caraDP').options[document.getElementById('caraDP').].disabled = true;
//      } else {
//          document.getElementById('caraDP').readonly = false;
//      }
//  }
</script>
<script>
function myFunction() {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PPJB ini ditutup?");
  if (r == true) {
    window.location.replace(base_url+"/add_ppjb");
  } else {
    window.location.replace(base_url+"/ppjb");
  }
//   document.getElementById("demo").innerHTML = txt;
}
</script>
<script>
// function showUser(str) {
//   if (str=="") {
//     document.getElementById("luasTanah").value="";
//     document.getElementById("luasBangunan").value="";
//     document.getElementById("tipeStandart").value="";
//     document.getElementById("myInput3").value="";
//     return;
//   } 
//   var xmlhttp=new XMLHttpRequest();
//   xmlhttp.onreadystatechange=function() {
//     if (this.readyState==4 && this.status==200) {
//       document.getElementById("txtHint").innerHTML=this.responseText;
//     }
//   }
//   xmlhttp.open("GET","psjb.php?q="+str,true);
//   xmlhttp.send();
// }
</script>
<script>
// $(document).ready(function(){
 
//  $('#id_kavling').change(function(){ 
//      var id=$(this).val();
//      $.ajax({
//          url : "<?php echo site_url('Dashboard/get_kavling');?>",
//          method : "POST",
//          data : {id: id},
//          async : true,
//          dataType : 'json',
//          success: function(data){

//             // var html = '';
//             // var i;
//             // for(i=0; i<data.length; i++){
//             //     html += '<option value='+data[i].subcategory_id+'>'+data[i].subcategory_name+'</option>';
//             // }
//             document.getElementById('luas_tanah').value = data[0].luas_tanah;
//             $('#luasTanah').val() = data[0].luas_tanah;

//          }
//      });
//      return false;
//  }); 
  
// });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- jQuery -->
<!-- // <script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap 4 -->
<!-- <script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- DataTables -->

<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url()?>asset/dist/js/demo.js"></script> -->
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
