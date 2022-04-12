<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <title>AdminLTE 3 | General Form Elements</title> -->
  <?php include "include/title.php";?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
  <link type="text/css" href="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/css/jquery.signature.css" rel="stylesheet"> 
  <style>
    #wrapper {
      background: #ccc;
      overflow: hidden;
      transition: max-height 300ms;
      max-height: 0;
      padding-left: 50px;
      padding-right: 50px; /* <---hide by default */
    }
    #wrapper.open {
      max-height: 1000px; /* <---when open, allow content to expand to take up as much height as it needs, up to e.g. 100px */
    }
    .kbw-signature { width: 400px; height: 200px;}
    #sig canvas{
        width: 100% !important;
        height: auto;
    }
    .dropzone {
      margin-top: 0px;
      border: 2px dashed #0087F7;
    }
  </style>
</head>
<?php include "include/fixedtop.php"?>
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
          <div class="col-sm-8">
            <h1>Perjanjian Pendahuluan Jual Beli Kavling (PPJB)</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item">Operasional</li>
              <li class="breadcrumb-item">Kavling</li>
              <li class="breadcrumb-item active">PPJB</li>
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
                                    <a href="<?php echo base_url()?>Dashboard/kavling_management" class="btn btn-sm btn-flat btn-danger">Kembali</a>
                                </div>
                                <div class="col-sm-12">
                                    <h5>Catatan Revisi untuk PPJB No. 1-<?php echo $row->no_psjb?>/PPJB/KBR/<?php echo $row->kode_perusahaan?>/<?php echo $row->kode_perumahan?>/<?php echo date("m", strtotime($row->tgl_psjb))?>/<?php echo date("Y", strtotime($row->tgl_psjb))?></h5>
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
                                    <h1>PPJB - Detail Pemesan</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <form role="form" action="<?php echo base_url()?>Dashboard/kavling_revisi" method="post" enctype="multipart/form-data">
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
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir" value="<?php echo $row->tgl_lahir?>">
                                </div>
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
                                    <h1>PPJB - Pembiayaan</h1>
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
                                <!-- <div class="form-group">
                                    <label for="exampleInputPassword1">Luas Bangunan m<sup>2</sup></label>
                                    <input type="number" class="form-control" id="luas_bangunan" placeholder="Luas Bangunan" name="luas_bangunan" value="<?php echo $luas_bangunan?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tipe Standart</label>
                                    <input type="number" class="form-control" id="tipe_standart" placeholder="Tipe Standart" name="tipe_standart" value="<?php echo $tipe_rumah?>" required readonly>
                                </div> -->
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
                                        <option value="Cash" <?php if($row->sistem_pembayaran == "Cash"){echo "selected";}?>>Cash</option>
                                        <option value="Tempo" <?php if($row->sistem_pembayaran == "Tempo"){echo "selected";}?>>Tempo</option>
                                        <!-- <option value="KPR">KPR</option> -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <!-- <label for="exampleInputPassword1">Hadap Timur</label> -->
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <!-- <input type="hidden" class="form-control" id="hadapTimur" placeholder="0" name="hadap_timur" value="0" required> -->
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Diskon Penjualan (Rp)</label>
                                    <input type="number" class="form-control" id="myInput1" placeholder="0" name="diskon_penjualan" value="<?php echo $row->disc_jual?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Pembersihan Lahan</label>
                                    <select name="biaya_pembersihan" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="free" <?php if($row->biaya_pembersihan == "free"){echo "selected";}?>>Free</option>
                                        <option value="nonfree" <?php if($row->biaya_pembersihan == "nonfree"){echo "selected";}?>>Rp. 25.000/6 bln</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Balik Nama</label>
                                    <select name="biaya_balik_nama" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="free" <?php if($row->biaya_balik_nama == "free"){echo "selected";}?>>Free</option>
                                        <option value="nonfree" <?php if($row->biaya_balik_nama == "free"){echo "selected";}?>>Ada Biaya</option>
                                    </select>
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
                                    <!-- <label for="exampleInputEmail1">Hadap Timur</label> -->
                                    <input type="hidden" class="form-control" id="hadapTimurBayar" placeholder="" value="0" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Diskon</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="diskon" placeholder="" value="<?php echo $row->disc_jual?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Sertifikat</label>
                                    <input type="text" class="form-control" id="namaSertifikat" placeholder="" value="<?php echo $row->nama_sertif?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Harga Sepakat</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="hargaSepakat" placeholder="" value="<?php echo $row->total_jual?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tanggal Tanda Jadi</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="date" class="form-control" id="tglTandaJadi" placeholder="" value="<?php echo $row->tgl_psjb?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanda Jadi</label>
                                    <input type="number" class="form-control" id="tandaJadi" placeholder="" value="<?php echo $row->uang_awal?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <!-- <label for="exampleInputPassword1">Biaya Kekurangan</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                    <input type="number" class="form-control" id="biayaKekurangan" placeholder="" readonly>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tipe Pembayaran</label>
                                    <input type="text" class="form-control" id="tipePembayaran" placeholder="" value="<?php echo $row->sistem_pembayaran?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total Kekurangan Rencana Bayar</label>
                                    <input type="number" class="form-control" id="totalKekuranganRencanaBayar" value="<?php echo $row->total_jual - $row->uang_awal?>" placeholder="" readonly>
                                    <!-- <input type="number" class="form-control" id="totalKekuranganRencanaBayar" placeholder="" readonly> -->
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
                                    <!-- <th>Persen</th> -->
                                    <th>Tanggal Pembayaran</th>
                                    <th>Cara Pembayaran</th>
                                    <!-- <th>Lama Bayar</th> -->
                                    <th>Nominal</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>
                                            <!-- <select class="form-control">
                                                <option value="DP">Down Payment</option>
                                                <option value="KPR">KPR</option>
                                            </select> -->
                                            <input type="text" class="form-control" value="Uang Tanda Jadi" name="tahap_tandajadi" readonly/>
                                        </td>
                                        <!-- <td>
                                            <input type="number" class="form-control" readonly/>
                                        </td> -->
                                        <td>
                                            <input type="date" class="form-control" id="tanggalJadiPembayaran" value="<?php echo $row->tgl_psjb?>" name="tgl_tandajadi" readonly/>
                                        </td>
                                        <td>
                                            <select class="form-control" placeholder="" id="caraPembayaran" name="jenis_pembayaran" required disabled>
                                                <option disabled selected value="">-Pilih-</option>
                                                <option value="transfer" <?php if($row->cara_pembayaran == "transfer"){echo "selected";}?>>Transfer</option>
                                                <option value="cash" <?php if($row->cara_pembayaran == "cash"){echo "selected";}?>>Cash</option>
                                            </select>
                                            <!-- <div id="showBank"></div> -->
                                            <input type="hidden" name="bank_awal" id="bankAwal" disabled>
                                            <select class="form-control" name="bank_awal" id="bank" required disabled>
                                                <option disabled selected id="bank_awal_opt" value="">-Pilih-</option>
                                                <?php foreach($this->db->get('bank')->result() as $row3){
                                                    echo "<option ";
                                                    if($row->id_bank == $row3->id_bank){
                                                        echo "selected";
                                                    }
                                                    echo " value='$row3->id_bank'>$row3->id_bank-$row3->nama_bank</option>";
                                                }?>
                                            </select>

                                        </td>
                                        <!-- <td></td> -->
                                        <td>
                                            <input type="number" class="form-control" id="tandaJadiPembayaran" value="<?php echo $row->uang_awal?>" name="nominal_pembayaran_tandajadi" readonly/>
                                        </td>
                                    </tr>

                                <tbody id="Tempo" class="category" <?php if($row->sistem_pembayaran == "Cash"){echo "style='display: none'";}?>>
                                    <tr style="font-weight: bold">
                                        <td></td>
                                        <td>Banyak Tempo (Bulan)</td>
                                        <td>Bulan Mulai Angsuran</td>
                                        <td>Nominal Angsuran/Bln</td>
                                        <td>Total Nominal Angsuran</td>
                                    </tr>
                                    <tr>
                                        <td><span id="numberChq">2.</span></td>
                                        <td>
                                            <input type="number" class="form-control tempoUnrequired" id="tahapByr" value="<?php echo $row->jumlah_dp?>" name="tahaptempo1" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?>/>
                                            <!-- <div class="row">
                                                <input type="number" class="form-control col-sm-5"> <span>to</span> <input type="number" class="form-control col-sm-5">
                                            </div> -->
                                        </td>
                                        <td>
                                            <input type="date" class="form-control tempoUnrequired" id="tanggalJadiPembayaran" value="<?php echo $row->tgl_dp?>" name="tgl_pembayarantempo1" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?>/>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control tempoUnrequired" id="nominalPembayaran" value="<?php echo $row->total_dp?>" name="nominal_tempo1" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?>>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control tempoUnrequired" id="totalNominalPembayaran" value="<?php echo $row->jumlah_dp * $row->total_dp?>" name="total_nominaltempo1" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?> readonly/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span id="numberChq">3.</span></td>
                                        <td>
                                            <input type="number" class="form-control tempoUnrequired" id="tahapByr1" value="<?php echo $row->jumlah_dp2?>" name="tahaptempo2" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?>/>
                                            <!-- <div class="row">
                                                <input type="number" class="form-control col-sm-5"> <span>to</span> <input type="number" class="form-control col-sm-5">
                                            </div> -->
                                        </td>
                                        <td>
                                            <input type="date" class="form-control tempoUnrequired" id="tanggalJadiPembayaran1" value="<?php echo $row->tgl_kpr?>" name="tgl_pembayarantempo2" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?>/>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control tempoUnrequired" id="nominalPembayaran1" value="<?php echo $row->total_kpr?>" name="nominal_tempo2" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?>>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control tempoUnrequired" id="totalNominalPembayaran1" value="<?php echo $row->jumlah_dp2 * $row->total_kpr?>" name="total_nominaltempo1" <?php if($row->sistem_pembayaran == "Tempo"){echo "required";}?> readonly/>
                                        </td>
                                    </tr>
                                </tbody>
                                    <!-- <tr id="buttonbox" class="buttonbox"></tr> -->
                                <tbody id="Cash" class="category" <?php if($row->sistem_pembayaran == "Tempo"){echo "style='display: none'";}?>>
                                    <tr style="font-weight: bold">
                                        <td></td>
                                        <td>Banyak Pembayaran (Bulan)</td>
                                        <td>Bulan Mulai Angsuran</td>
                                        <td>Nominal Angsuran/Bln</td>
                                        <td>Total Nominal Angsuran</td>
                                    </tr>
                                    <tr>
                                        <td><span id="numberChq">2.</span></td>
                                        <td>
                                            <input type="text" class="form-control cashUnrequired" id="tahapByrCash" value="<?php echo $row->lama_cash?>" name="tahapcash" <?php if($row->sistem_pembayaran == "Cash"){echo "required";}?>/>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control cashUnrequired" id="tanggalJadiPembayaran" value="<?php echo date('Y-m-d', strtotime($row->tgl_cash))?>" name="tgl_pembayarancash" <?php if($row->sistem_pembayaran == "Cash"){echo "required";}?>/>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control cashUnrequired" id="nominalCash" value="<?php echo $row->jumlah_cash?>" name="nominal_cash" <?php if($row->sistem_pembayaran == "Cash"){echo "required";}?>>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control cashUnrequired" id="totalNominalCash" value="<?php echo $row->lama_cash * $row->jumlah_cash?>" name="nominal_pembayarancash" <?php if($row->sistem_pembayaran == "Cash"){echo "required";}?> readonly/>
                                        </td>
                                    </tr>
                                </tbody>

                                <tr>
                                    <td>

                                    </td>
                                    <td colspan=2>
                                        <span>Pastikan nominal berjumlah 0!</span>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <?php if($row->sistem_pembayaran == "Tempo"){ ?>
                                            <input type="number" class="form-control" id="nominalTotal" value="<?php echo $row->total_jual - $row->uang_awal - ($row->jumlah_dp * $row->total_dp) - ($row->jumlah_dp2 * $row->total_kpr);?>" readonly/>
                                        <?php } else {?>
                                            <input type="number" class="form-control" id="nominalTotal" value="<?php echo $row->total_jual - $row->uang_awal - ($row->lama_cash * $row->jumlah_cash);?>" readonly/>
                                        <?php }?>
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
                        <!-- <input type="hidden" name="tipe_produk" value="<?php echo $row->tipe_produk?>">
                        <input type="hidden" name="" value="<?php ?>"> -->

                        <span style="color: green">Saya selaku <?php echo $role?> menyatakan PSJB ini telah direvisi, ditutup dan menunggu approval.</span><br>
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
                                    <h1 style="background-color: lightyellow; padding-left: 10px; padding-top: 10px; padding-bottom: 10px">PPJB - Detail Pemesan</h1>
                                </div>
                                <div class="col-sm-6">
                                    <!-- <a href="<?php echo base_url()?>Dashboard/siteplan_view" class="btn btn-sm btn-success">Siteplan</a> -->
                                    <button type="button" class="btn btn-info" data-toggle="modal" style="font-size: 13px" data-target="#pembayaran" data-bbn="bphtb" data-tglbbn="bbn">Siteplan</button>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <form role="form" class="formi" action="<?php echo base_url()?>Dashboard/get_kavling_kav" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Perumahan</label>
                                    <select id="cekPerumahan" class="form-control" name="kode_perumahan" required>
                                        <option value="" disabled selected>-Pilih-</option>
                                        <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                            <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->kode_perumahan."-".$perumahan->nama_perumahan?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nomor Kavling</label>
                                    <?php if(isset($kavling)){?>
                                        <div id="id_kavling" style=" border:2px solid #ccc; width:500px; height: 75px; overflow-y: scroll;">

                                        </div>
                                        <!-- <select class="form-control" id="id_kavling" placeholder="Nomor Kavling" name="id_kavling" required>
                                        <option value="" disabled selected>-Pilih-</option>
                                        </select> -->
                                    <?php } else{?>
                                        <div id="id_kavling" style=" border:2px solid #ccc; width:500px; height: 75px; overflow-y: scroll;">

                                        </div>
                                        <!-- <select class="form-control" id="id_kavling" placeholder="Nomor Kavling" name="id_kavling" required>
                                        <option value="" disabled selected>-Pilih-</option> -->
                                    <?php }?>
                                    <input type="submit" class="btn btn-outline-primary btn-sm" value="Pilih">
                                    <?php if(isset($kavling)){?>
                                        Pilihan sekarang: <input type="text" value="<?php for($i=0; $i < count($kavling); $i++){ echo $kavling[$i].",";}?>" readonly>
                                    <?php } else {?>
                                        Pilihan sekarang: <input type="text" value="" readonly required>
                                    <?php }?>
                                </div>
                            </form>
                            <form role="form" action="<?php echo base_url()?>Dashboard/add_kavling" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Perusahaan</label>
                                    <?php if(isset($kavling)){ ?>
                                        <?php foreach($this->db->get_where('perusahaan', array('kode_perusahaan'=>$kode_perusahaan))->result() as $row2){?>
                                            <input type="text" class="form-control" value="<?php echo $row2->nama_perusahaan?>" readonly>
                                        <?php }?>
                                        <input type="hidden" value="<?php echo $kode_perusahaan?>" name="nama_perusahaan">
                                        <!-- <input type="hidden" value="<?php echo $kavling?>" name="id_kavling[]"> -->
                                        <input type="hidden" value="<?php for($i=0; $i < count($kavling)    ; $i++){ echo $kavling[$i].",";}?>" name="id_kavling">
                                        <input type="hidden" value="<?php echo $tipe_produk?>" name="tipe_produk">
                                    <?php } else{?>
                                        <input type="text" class="form-control" placeholder="Nama Perusahaan" required readonly>
                                    <?php }?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Perumahan</label>
                                    <!-- <input type="text" id="noKavling" name="nomor_kavling"/> -->
                                    <?php if(isset($kavling)){?>
                                        <input type="text" class="form-control" value="<?php echo $nama_perumahan?>" name="nama_perumahan" readonly>
                                    <?php } else{?>
                                        <input type="text" class="form-control" placeholder="Nama Perumahan" required readonly>
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
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir">
                                </div>
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
                                    <label for="exampleInputEmail1">Pekerjaan</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Pekerjaan" name="pekerjaan" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmailNPWP">NPWP</label>
                                    <input type="text" class="form-control" id="exampleInputEmailNPWP" placeholder="No. NPWP" name="npwp" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmailEmail">E-mail</label>
                                    <input type="email" class="form-control" id="exampleInputEmailEmail" placeholder="E-mail" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Uang Tanda Jadi</label>
                                    <input type="number" class="form-control" id="tandaJadi1" placeholder="Tanda Jadi" name="uang_awal" value="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 style="background-color: lightyellow; padding-left: 10px; padding-top: 10px; padding-bottom: 10px">PPJB Kavling - Pembiayaan</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if(isset($kavling)){?>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Luas Tanah m<sup>2</sup></label>
                                            <input type="number" class="form-control" id="luas_tanah" placeholder="Luas Tanah" name="luas_tanah" value="<?php echo $luas_tanah?>" required readonly>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="exampleInputPassword1">Luas Bangunan m<sup>2</sup></label>
                                            <input type="number" class="form-control" id="luas_bangunan" placeholder="Luas Bangunan" name="luas_bangunan" value="<?php echo $luas_bangunan?>" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Tipe Standart</label>
                                            <input type="number" class="form-control" id="tipe_standart" placeholder="Tipe Standart" name="tipe_standart" value="<?php echo $tipe_rumah?>" required readonly>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Harga Jual Standart (Rp)</label>
                                            <input type="number" class="form-control" id="myInput3" placeholder="0" name="harga_jual_standart" value="<?php echo $harga_jual?>" required readonly>
                                        </div>
                                <?php } else {?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Luas Tanah m<sup>2</sup></label>
                                        <input type="number" class="form-control" id="luas_tanah" placeholder="Luas Tanah" name="luas_tanah" required readonly>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="exampleInputPassword1">Luas Bangunan m<sup>2</sup></label>
                                        <input type="number" class="form-control" id="luas_bangunan" placeholder="Luas Bangunan" name="luas_bangunan" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tipe Standart</label>
                                        <input type="number" class="form-control" id="tipe_standart" placeholder="Tipe Standart" name="tipe_standart" required readonly>
                                    </div> -->
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
                                        <!-- <option value="KPR">KPR</option> -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <!-- <label for="exampleInputPassword1">Hadap Timur</label> -->
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="hidden" class="form-control" id="hadapTimur" placeholder="0" name="hadap_timur" value="0" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Diskon Penjualan (Rp)</label>
                                    <input type="number" class="form-control" id="myInput1" placeholder="0" name="diskon_penjualan" value="0" required>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Pembersihan Lahan</label>
                                    <select name="biaya_pembersihan" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="free">Free</option>
                                        <option value="nonfree">Rp. 25.000/6 bln</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Balik Nama</label>
                                    <select name="biaya_balik_nama" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="free">Free</option>
                                        <option value="nonfree">Ada Biaya</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Total Penjualan (Rp)</label>
                                    <?php if(isset($kavling)){?>
                                    <input type="number" class="form-control" id="myInput2" placeholder="NaN" name="total_penjualan" value="<?php echo $harga_jual?>" readonly>
                                    <?php } else {?>
                                    <input type="number" class="form-control" id="myInput2" placeholder="NaN" name="total_penjualan" readonly>
                                    <?php }?>
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
                                    <h1 style="background-color: lightyellow; padding-left: 10px; padding-top: 10px; padding-bottom: 10px">PPJB Kavling - Pembayaran</h1>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h5 style="">Keterangan Pemesanan Kavling</h5>
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
                                    <!-- <label for="exampleInputEmail1">Hadap Timur</label> -->
                                    <input type="hidden" class="form-control" id="hadapTimurBayar" placeholder="" value="0" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Diskon</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="number" class="form-control" id="diskon" placeholder="" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Sertifikat</label>
                                    <input type="text" class="form-control" id="namaSertifikat" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Harga Sepakat</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <?php if(isset($kavling)){?>
                                        <input type="number" class="form-control" id="hargaSepakat" placeholder="" value="<?php echo $harga_jual?>" readonly>
                                    <?php } else {?>
                                        <input type="number" class="form-control" id="hargaSepakat" placeholder="" readonly>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tanggal Tanda Jadi</label>
                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required> -->
                                    <input type="date" class="form-control" id="tglTandaJadi" placeholder="" value="<?php echo date("Y-m-d")?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanda Jadi</label>
                                    <input type="number" class="form-control" id="tandaJadi" placeholder="" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <!-- <label for="exampleInputPassword1">Biaya Kekurangan</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Cara Pembayaran" name="cara_pembayaran" required>
                                    <input type="number" class="form-control" id="biayaKekurangan" placeholder="" readonly>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tipe Pembayaran</label>
                                    <input type="text" class="form-control" id="tipePembayaran" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total Kekurangan Rencana Bayar</label>
                                    <?php if(isset($kavling)){?>
                                        <input type="number" class="form-control" id="totalKekuranganRencanaBayar" value="<?php echo $harga_jual?>" placeholder="" readonly>
                                    <?php } else {?>
                                        <input type="number" class="form-control" id="totalKekuranganRencanaBayar" placeholder="" readonly>
                                    <?php }?>
                                    <!-- <input type="number" class="form-control" id="totalKekuranganRencanaBayar" placeholder="" readonly> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h5 style="background-color: lightyellow; padding-left: 10px; padding-top: 10px; padding-bottom: 10px">Rencana Pembayaran <input type="text" style="border: 0; background-color: lightyellow" id="myInput5" readonly/></h5>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>

                    <div class="card-body">
                        <!-- <div class="col-sm-12 row">
                            <div class="form-group">
                                <label>Tambah Form Angsuran (Bulan)</label>
                                <input type="number" id="formGenerate" class="form-control" name="formGenerateCount">
                                <button type="button" id="generateTempo" class="btn btn-flat btn-outline-primary btn-sm generateTempo">GENERATE</button>
                            </div>
                        </div> -->
                        <!-- <br> -->
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <th></th>
                                    <th>Tahap Pembayaran</th>
                                    <!-- <th>Persen</th> -->
                                    <th>Tanggal Pembayaran</th>
                                    <th>Cara Pembayaran</th>
                                    <!-- <th>Lama Bayar</th> -->
                                    <th>Nominal</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>
                                            <!-- <select class="form-control">
                                                <option value="DP">Down Payment</option>
                                                <option value="KPR">KPR</option>
                                            </select> -->
                                            <input type="text" class="form-control" value="Uang Tanda Jadi" name="tahap_tandajadi" readonly/>
                                        </td>
                                        <!-- <td>
                                            <input type="number" class="form-control" readonly/>
                                        </td> -->
                                        <td>
                                            <input type="date" class="form-control" id="tanggalJadiPembayaran" value="<?php echo date('Y-m-d')?>" name="tgl_tandajadi" readonly/>
                                        </td>
                                        <td>
                                            <select class="form-control" placeholder="" id="caraPembayaran" name="jenis_pembayaran" required>
                                                <option disabled selected value="">-Pilih-</option>
                                                <option value="transfer">Transfer</option>
                                                <option value="cash">Cash</option>
                                            </select>
                                            <!-- <div id="showBank"></div> -->
                                            <input type="hidden" name="bank_awal" id="bankAwal" disabled>
                                            <select class="form-control" name="bank_awal" id="bank" required>
                                                <option disabled selected id="bank_awal_opt" value="">-Pilih-</option>
                                                <?php foreach($this->db->get('bank')->result() as $row3){?>
                                                    <option value="<?php echo $row3->id_bank?>"><?php echo $row3->nama_bank?></option>
                                                <?php }?>
                                            </select>

                                        </td>
                                        <!-- <td></td> -->
                                        <td>
                                            <input type="number" class="form-control" id="tandaJadiPembayaran" value="0" name="nominal_pembayaran_tandajadi" readonly/>
                                        </td>
                                    </tr>

                                    <tbody id="Tempo" class="category" style="display: none">
                                        <tr style="font-weight: bold">
                                            <td></td>
                                            <td>Banyak Tempo (Bulan)</td>
                                            <td>Bulan Mulai Angsuran</td>
                                            <td>Nominal Angsuran/Bln</td>
                                            <td>Total Nominal Angsuran</td>
                                        </tr>
                                        <tr>
                                            <td><span id="numberChq">2.</span></td>
                                            <td>
                                                <input type="number" class="form-control tempoUnrequired" id="tahapByr" value="" name="tahaptempo1" required/>
                                                <!-- <div class="row">
                                                    <input type="number" class="form-control col-sm-5"> <span>to</span> <input type="number" class="form-control col-sm-5">
                                                </div> -->
                                            </td>
                                            <td>
                                                <input type="date" class="form-control tempoUnrequired" id="tanggalJadiPembayaran" value="" name="tgl_pembayarantempo1" required/>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control tempoUnrequired" id="nominalPembayaran" value="" name="nominal_tempo1" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control tempoUnrequired" id="totalNominalPembayaran" value="0" name="total_nominaltempo1" required readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span id="numberChq">3.</span></td>
                                            <td>
                                                <input type="number" class="form-control tempoUnrequired" id="tahapByr1" value="" name="tahaptempo2" required/>
                                                <!-- <div class="row">
                                                    <input type="number" class="form-control col-sm-5"> <span>to</span> <input type="number" class="form-control col-sm-5">
                                                </div> -->
                                            </td>
                                            <td>
                                                <input type="date" class="form-control tempoUnrequired" id="tanggalJadiPembayaran1" value="" name="tgl_pembayarantempo2" required/>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control tempoUnrequired" id="nominalPembayaran1" value="nominal_tempo2" name="nominal_tempo2" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control tempoUnrequired" id="totalNominalPembayaran1" value="0" name="total_nominaltempo1" required readonly/>
                                            </td>
                                        </tr>
                                    </tbody>
                                        <!-- <tr id="buttonbox" class="buttonbox"></tr> -->
                                    <tbody id="Cash" class="category" style="display: none">
                                        <tr style="font-weight: bold">
                                            <td></td>
                                            <td>Banyak Pembayaran (Bulan)</td>
                                            <td>Bulan Mulai Angsuran</td>
                                            <td>Nominal Angsuran/Bln</td>
                                            <td>Total Nominal Angsuran</td>
                                        </tr>
                                        <tr>
                                            <td><span id="numberChq">2.</span></td>
                                            <td>
                                                <input type="text" class="form-control cashUnrequired" id="tahapByrCash" value="" name="tahapcash" required/>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control cashUnrequired" id="tanggalJadiPembayaran" value="" name="tgl_pembayarancash" required/>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control cashUnrequired" id="nominalCash" value="" name="nominal_cash" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control cashUnrequired" id="totalNominalCash" value="0" name="nominal_pembayarancash" required readonly/>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tr>
                                        <td>

                                        </td>
                                        <td colspan=2>
                                            <span>Pastikan nominal berjumlah 0!</span>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <?php if(isset($kavling)){?>
                                                <input type="number" class="form-control" id="nominalTotal" value="<?php echo $harga_jual?>" readonly/>
                                            <?php } else {?>
                                                <input type="number" class="form-control" id="nominalTotal" readonly/>
                                            <?php }?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- <div id="response">

                            </div> -->
                        </div>
                    </div>

                    <div class="card-footer">
                        <span style="color: green">Saya selaku <?php echo $role?> menyatakan PSJB ini ditutup dan menunggu approval.</span><br>
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
    <div class="modal fade" id="pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Siteplan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                    <!-- left column -->
                    <?php 
                    $perumahan = $this->db->get('perumahan')->result();
                    foreach($perumahan as $row){?>
                        <div class="card">
                        <h1><?php echo $row->nama_perumahan?></h1>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-3">
                                    <table class="table table-bordered">
                                    <thead style="background-color: lightblue">
                                        <tr>
                                        <td>Sold</td>
                                        <td>Free</td>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <?php $dipesan=0; $free=0; foreach($this->db->get_where('rumah', array('nama_perumahan'=>$row->nama_perumahan, 'tipe_produk'=>"kavling"))->result() as $row2){
                                        if($row2->status=="free"){
                                            $free=$free+1;
                                        } else{
                                            $dipesan=$dipesan+1;
                                        }?>
                                        <?php }?>
                                        
                                        <tr>
                                        <td><?php echo $dipesan?></td>
                                        <td><?php echo $free?></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    </div>
                                </div>
                                <span style="background-color: yellow">*Kuning/Centang = Sold</span><br>
                            </div>
                            <div class="col-md-12" style="text-align: center">
                                <img style="width: 680px; height: 900px;" src="<?php echo base_url()?>gambar/<?php echo $row->siteplan?>">
                            </div>
                        </div>
                    </div>
                <?php }?>
                <!-- /.row -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <input type="submit" class="btn btn-success" value="Submit"> -->
            </div>
            </div>
        </div>
    </div>

    </div>
  </div>
  <!-- /.content-wrapper -->
  
  <?php include "include/footer.php"?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/js/jquery.signature.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery-ui-touch-punch-master/jquery.ui.touch-punch.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery-ui-touch-punch-master/jquery.ui.touch-punch.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<script src="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.js"></script>

<script type="text/javascript">
  var input1 = document.getElementById('myInput1');
  var input2 = document.getElementById('myInput2');
  var input3 = document.getElementById('myInput3');

  var input4 = document.getElementById('myInput4');
  var input5 = document.getElementById('myInput5');

  var tandaJadi1 = document.getElementById('tandaJadi1');

  input4.addEventListener('change', function() {
    input5.value = input4.value;
    tipePembayaran.value = input4.value;
    byr1.value = input4.value;

    // if(input4.value == "Cash"){
    //     persenDP.placeholder = 50;
    // } else if(input4.value == "KPR"){
    //     persenDP.placeholder = 15;
    // } else {
    //     persenDP.placeholder = 20;
    // }
  });

  //myInput1 = diskon , myInput2 = total_penjualan, myInput3 = harga_standart

//   $('input[id^="nominalPembayaran"]').on("blur", function(){
//     alert('A');
//   })

  $('#tandaJadi1').on("input", function(){
    $('#tandaJadi').val($(this).val());

    $('#totalKekuranganRencanaBayar').val($('#hargaSepakat').val() - $('#tandaJadi').val());

    $('#tandaJadiPembayaran').val($(this).val());

    if($('#myInput4').val() == "Tempo"){
        $('#nominalTotal').val($('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalPembayaran').val()) + parseInt($('#totalNominalPembayaran1').val())));
    } else {
        $('#nominalTotal').val($('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalCash').val())));
    }

    // $('input[id^="nominalPembayaran"]').val($(this).val());
    // $('#input[]')
    // alert('A');
  })

  $('#myInput1').on("input", function(){
    $('#myInput2').val($('#myInput3').val() - $(this).val());

    $('#diskon').val($(this).val());

    $('#hargaSepakat').val($('#myInput3').val() - $(this).val());

    $('#totalKekuranganRencanaBayar').val($('#hargaSepakat').val() - $('#tandaJadi').val());

    if($('#myInput4').val() == "Tempo"){
        $('#nominalTotal').val($('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalPembayaran').val()) + parseInt($('#totalNominalPembayaran1').val())));
    } else {
        $('#nominalTotal').val($('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalCash').val())));
    }
  })

  const numInputs = document.querySelectorAll('input[type=number]');

    numInputs.forEach(function(input) {
        tandaJadi1.addEventListener('blur', function(e) {
            if (e.target.value == '') {
                e.target.value = 0;

                $('#tandaJadi').val(0);
            }
        })
        input1.addEventListener('blur', function(e) {
            if (e.target.value == '') {
                e.target.value = 0;

                $('#diskon').val(0);
            }
        })
    });

    $('#inputNamaPemesan').on("input", function(){
        $('#namaPemesan').val($(this).val());
    });

    $('#inputNamaSertifikat').on("input", function(){
        $('#namaSertifikat').val($(this).val());
    });
</script>
<script type="text/javascript">
$('#tahapByr').on("input", function(){
    var thp = $(this).val();
    var nom = $('#nominalPembayaran').val();

    $('#totalNominalPembayaran').val(thp * nom);

    var ttl = $('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalPembayaran').val()) + parseInt($('#totalNominalPembayaran1').val()));

    $('#nominalTotal').val(ttl);
})

$('#nominalPembayaran').on("input", function(){
    var thp = $(this).val();
    var nom = $('#tahapByr').val();

    $('#totalNominalPembayaran').val(thp * nom);

    var ttl = $('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalPembayaran').val()) + parseInt($('#totalNominalPembayaran1').val()));

    $('#nominalTotal').val(ttl);
})

$('#tahapByr1').on("input", function(){
    var thp = $(this).val();
    var nom = $('#nominalPembayaran1').val();

    $('#totalNominalPembayaran1').val(thp * nom);

    var ttl = $('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalPembayaran').val()) + parseInt($('#totalNominalPembayaran1').val()));

    $('#nominalTotal').val(ttl);
})

$('#nominalPembayaran1').on("input", function(){
    var thp = $(this).val();
    var nom = $('#tahapByr1').val();

    $('#totalNominalPembayaran1').val(thp * nom);

    var ttl = $('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalPembayaran').val()) + parseInt($('#totalNominalPembayaran1').val()));

    $('#nominalTotal').val(ttl);
})

$('#tahapByrCash').on("input", function(){
    var thp = $(this).val();
    var nom = $('#nominalCash').val();

    $('#totalNominalCash').val(thp * nom);

    var ttl = $('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalCash').val()));

    $('#nominalTotal').val(ttl);
})

$('#nominalCash').on("input", function(){
    var thp = $(this).val();
    var nom = $('#tahapByrCash').val();

    $('#totalNominalCash').val(thp * nom);

    var ttl = $('#hargaSepakat').val() - (parseInt($('#tandaJadi1').val()) + parseInt($('#totalNominalCash').val()));

    $('#nominalTotal').val(ttl);
})

// $(document).ready(function(){
//     $('#generateTempo').on("click", function(){
//         $('#response').html("");

//         var selectedCountry = $("#formGenerate").val();
//         $.ajax({
//             type: "POST",
//             url: "<?php echo base_url()?>Dashboard/generate_form_angsuran_kavling",
//             data: { country : selectedCountry } 
//         }).done(function(data){
//             $("#response").append(data);
//         });
//     });
// })
$('#myInput4').on('change', function(){
    $('.category').hide();
    $('#'+$(this).val()).show();

    if($(this).val() == "Cash"){
        $('.tempoUnrequired').removeAttr('required');
        $('.tempoUnrequired').val("");

        $('.cashUnrequired').attr('required', 'required');

        $('#nominalTotal').val($('#hargaSepakat').val() - $('#tandaJadi1').val());
    } else {
        $('.cashUnrequired').removeAttr('required');
        $('.cashUnrequired').val("");

        $('.tempoUnrequired').attr('required', 'required');

        $('#nominalTotal').val($('#hargaSepakat').val() - $('#tandaJadi1').val());
    }
})
</script>
<script>
function myFunction() {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini ditutup?");
  if (r == true) {
    window.location.replace(base_url+"/add_kavling");
  } else {
    window.location.replace(base_url+"/kavling");
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
$(document).ready(function(){
    $("select#cekPerumahan").change(function(){
        var selectedCountry = $("#cekPerumahan option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_psjb_kavling",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#id_kavling").html(data);
        });
    });
});
</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script>
    $(document).ready(function () {
        $("#caraPembayaran").change(function(){
            var selectedCountry = $(this).val();

            if(selectedCountry=="transfer"){
                $("#bank").removeAttr('required');
                $("#bank").removeAttr('disabled');
                $("#showBank").empty();
                $("#bank").attr('required', 'required');
                // $("#bank").html('<option disabled selected value="">-Pilih-</option><option value="transfer">Transfer</option><option value="cash">Cash</option>');
                $("#bankAwal").attr('disabled', 'disabled');
                $('#bankAwal').val("");
            } else {
                $("#bank").attr('disabled', 'disabled');
                $("#bank").removeAttr('required');
                $("#bank").val("");
                // $("#showBank").append('<input type="hidden" name="bank_test" value="AA">');
                // $("#bank").html('<option value="" disabled>-Pilih-</option>');
                $('#bankAwal').removeAttr('disabled');
                $('#bankAwal').val("");
            }
        });
    });

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

    $(document).ready(function() {
        var i = 1;
        var a = 2;
        var count = $('#formGenerate').val();

        var last1 = $('.buttonbox').last();

        $(document).on('click', '.generateTempo', function() {
            // var i = 0;
            // var clone = $('#mainResp').clone();
            // for(var i = 0; i < count; i++){
            // }
            // while (i < count){
            // }
            var clone = $("#mainResp").clone().find("input[id='tahapByr']").val('Angsuran ke-'+ ++i).end().find("#numberChq").html(++a + ".").end().attr("id", "mainResp" + i).insertBefore(last1);

            // $('#mainResp')
            // $('#numberChq').html(++a + ".");
        })
    })
</script>
</body>
</html>
