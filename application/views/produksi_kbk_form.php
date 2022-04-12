<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include "include/title.php"?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
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
  </style>
</head>
<!-- <body class="hold-transition sidebar-mini"> -->
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
          <div class="col-sm-6">
            <h1>
                Form KBK - SPK No. <?php echo sprintf('%03d', $no_spk)?>          
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">
                KBK
              </li>
            </ol>
          </div>
        </div>
        <!-- <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button> -->
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_laporan_penerimaan_akuntansi" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Perumahan</label>
                  <select name="perumahan" class="form-control">
                      <option value="">Semua</option>
                      <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                      <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                      <?php }?>
                  </select>
                  <?php if(isset($kode)){?>
                    <span>Pilihan saat ini: <?php if($kode == ""){echo "Semua";} else {echo $kode;}?></span>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control">
                      <option value="">Semua</option>
                      <option value="booking fee">Booking Fee</option>
                      <option value="piutang kas">Piutang Kas</option>
                      <option value="ground tank">Ground Tank</option>
                      <option value="tambahan bangunan">Tambahan Bangunan</option>
                      <option value="penerimaan lain">Penerimaan Lain</option>
                  </select>
                  <?php if(isset($kategori)){
                    echo "Pilihan saat ini: ";
                    if($kategori == ""){ echo "Semua";} else { echo $kategori; }; 
                  }?>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                      <option value="A">Semua</option>
                      <option value="dom">Approved</option>
                      <option value="revisi">Revisi</option>
                      <option value="tutup">Menunggu</option>
                  </select>
                  <?php if(isset($kategori)){
                    echo "Pilihan saat ini: ";
                    if($kategori == ""){ echo "Semua";} else { echo $kategori; }; 
                  }?>
                </div>
              </div>
              <div class="col-md-6">
                <label>Date</label>
                <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                <label>Sampai</label>
                <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
              </div>
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($edit_kbk)){
      foreach($edit_kbk->result() as $row){?>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <a href="<?php echo base_url()?>Dashboard/kbk_management?id=<?php echo $row->kode_perumahan?>" class="btn btn-info btn-flat btn-sm">Kembali</a>
                    <!-- <a href="#" class="btn btn-info btn-flat">Tambah Baru</a> -->
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <form action="<?php echo base_url()?>Dashboard/edit_kbk" method="POST" enctype="multipart/form-data">
                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">Pihak 1 - Developer</div>
                        <div class="col-12 row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Nama</label>
                              <input type="text" class="form-control" value="<?php echo $row->dev_nama?>" name="dev_nama">
                            </div>
                            <div class="form-group">
                              <label>KTP</label>
                              <input type="text" class="form-control" value="<?php echo $row->dev_ktp?>" name="dev_ktp">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Alamat</label>
                              <textarea class="form-control" name="dev_alamat"><?php echo $row->dev_alamat?></textarea>
                            </div>
                            <div class="form-group">
                              <label>Pekerjaan</label>
                              <input type="text" class="form-control" name="dev_pekerjaan" value="<?php echo $row->dev_pekerjaan?>">
                            </div>
                          </div>
                        </div>

                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          <div class="row">
                            <div class="col-sm-7">Pihak 2 - Sub Kontraktor</div>
                            <div class="col-sm-5">
                              <select class="form-control" id="subKon">
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($this->db->get('sub_kon')->result() as $kon){?>
                                  <option value="<?php echo $kon->id_sub_kon?>"><?php echo $kon->nama_sub?></option>
                                <?php }?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div id="response">
                          <div class="col-12 row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="<?php echo $row->nama_sub?>" id="namaSub" placeholder="Nama Sub Kontraktor" name="sub_nama" required readonly>
                              </div>
                              <div class="form-group">
                                <label>KTP</label>
                                <input type="number" class="form-control" value="<?php echo $row->ktp_sub?>" id="ktpSub" placeholder="No KTP" name="sub_ktp" required readonly>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="sub_alamat" id="alamatSub" placeholder="Alamat Sub Kontraktor" required readonly><?php echo $row->alamat_sub?></textarea>
                              </div>
                              <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" value="<?php echo $row->pekerjaan_sub?>" id="pekerjaanSub" name="sub_pekerjaan" placeholder="Pekerjaan Sub Kontraktor" readonly required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">Data KBK</div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>No. KBK</label>
                                    <input type="text" class="form-control" value="<?php echo sprintf('%03d', $row->id_kbk)."/SPK/".$kode_perusahaan."/".$row->kode_perumahan;?>" readonly>
                                    <input type="hidden" value="<?php echo $row->id_spk?>" name="id_spk">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" name="no_unit" value="<?php echo $row->unit?>" readonly>
                                    <!-- <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_spk"> -->
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Harga Total Unit</label>
                                    <input type="text" class="form-control" value="<?php echo "Rp. ".number_format($row->harga_unit)?>" readonly>
                                    <input type="hidden" value="<?php echo $row->harga_unit?>" name="harga_jual">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Bangunan</label>
                                    <input type="number" value="<?php echo $row->luas_bangunan?>" class="form-control" name="luas_bangunan" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Tanah</label>
                                    <input type="number" value="<?php echo $row->luas_tanah?>" class="form-control" name="luas_tanah" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Upah</label>
                                    <input type="text" value="<?php echo "Rp. ".number_format($row->upah)?>" class="form-control" readonly required>
                                    <input type="hidden" value="<?php echo $row->upah?>" class="form-control" id="upah" name="upah" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kontrak Pekerjaan</label>
                                    <textarea class="form-control" name="kontrak_pekerjaan" readonly required><?php echo $row->kontrak_pekerjaan?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Masa Pelaksanaan</label>
                                    <!-- <textarea class="form-control" id="masaPelaksanaan" name="masa_pelaksanaan" readonly required><?php echo $row->masa_pelaksanaan?></textarea> -->
                                    <input type="number" class="form-control" id="masaPelaksanaan" name="masa_pelaksanaan" value="<?php echo $row->masa_pelaksanaan?>" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal BAST</label>
                                  <input type="date" value="<?php echo date('Y-m-d', strtotime($row->tgl_bast))?>" class="form-control" name="tgl_bast" readonly required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <?php if($sistem_pembayaran == "KPR"){?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" value="<?php echo date('Y-m-d', strtotime($row->tgl_akad))?>" class="form-control" name="tgl_akad" readonly>
                                </div>
                              <?php } else { ?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" value="<?php echo date('Y-m-d', strtotime($row->tgl_akad))?>" class="form-control" name="tgl_akad" readonly>
                                </div>
                              <?php }?>
                                <!-- <div class="form-group">
                                  <label class="" for="">Signature</label>
                                  <br/>
                                  <div id="sig"></div>
                                  <br/>
                                  <button type="button" id="clear" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
                                  <textarea id="signature64" name="signed" style="display: none"></textarea>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal Mulai</label>
                                  <input type="date" id="tglMulai" value="<?php echo date('Y-m-d', strtotime($row->tgl_mulai))?>" class="form-control" name="tgl_mulai" required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal Selesai</label>
                                  <input type="date" id="tglSelesai" value="<?php echo date('Y-m-d', strtotime($row->tgl_selesai))?>" class="form-control" name="tgl_selesai" required>
                              </div>
                            </div>
                        </div>

                        <div class="col-12 row" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          <div class="col-10">Ketentuan Pembayaran</div>
                          <div class="col-2" style="text-align: right;">
                              <button type="button" class="btn btn-sm btn-default add" id="add">+</button>
                              <button type="button" class="btn btn-sm btn-default remove" id="remove">-</button>
                          </div>
                        </div>

                        <!-- <div class="col-12 row" style="text-align: center; font-weight: bold; padding-bottom: 10px; padding-top: 10px">
                          <div class="col-sm-1">
                            No
                          </div>
                          <div class="col-sm-3">
                            Termin
                          </div>
                          <div class="col-sm-4">
                            Opname Pembayaran
                          </div>
                          <div class="col-sm-4">
                            Nilai Pembayaran
                          </div>
                        </div> -->
                        <div>
                          <table id="example2" class="table table-bordered" style="font-size: 14px">
                            <thead>
                                <tr>
                                  <th>Termin</th>
                                  <th>Opname Pembayaran (%)</th>
                                  <th>Nilai Pembayaran (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $tl = 0; $ts = 1; foreach($this->db->get_where('kbk_termin', array('id_kbk'=>$row->id_kbk))->result() as $termin){?>
                                <tr>
                                  <td>
                                    <?php echo $termin->tahap?>
                                    <input type="hidden" class="form-control" id="termin<?php echo $ts?>" name="termin[]" value="<?php echo $termin->tahap?>" required>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control" id="opname<?php echo $ts?>" name="opname[]" value="<?php echo $termin->opname?>" required>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control" id="nilaiTermin<?php echo $ts?>" name="nilaitermin[]" value="<?php echo $termin->nilai_pembayaran?>" required>
                                  </td>
                                </tr>
                              <?php $tl = $tl + $termin->nilai_pembayaran; $ts = $ts + 1;}?>

                              <tr>
                                <td colspan=2 style="text-align: right; font-weight: bold">Total Termin</td>
                                <td>
                                  <input type="number" name="total_termin" id="totalTermin" value="<?php echo $row->upah - $tl?>" class="form-control" readonly>
                                  <input type="hidden" value="<?php echo $ts?>" id="checkTermin">
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                        <!-- <?php 
                        // $tl = 0; $ts = 1; foreach($this->db->get_where('kbk_termin', array('id_kbk'=>$row->id_kbk))->result() as $termin){
                          ?>
                          <hr>
                          <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Termin</label>
                                <input type="text" class="form-control" id="termin<?php echo $ts?>" name="termin[]" value="<?php echo $termin->tahap?>" required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Opname Pembayaran (%)</label>
                                <input type="number" class="form-control" id="opname<?php echo $ts?>" name="opname[]" value="<?php echo $termin->opname?>" required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Nilai Pembayaran (Rp.)</label>
                                <input type="number" class="form-control" id="nilaiTermin<?php echo $ts?>" name="nilaitermin[]" value="<?php echo $termin->nilai_pembayaran?>" required>
                              </div>
                            </div>
                          </div>
                        <?php 
                        // $tl = $tl + $termin->nilai_pembayaran; $ts = $ts + 1;}?>
                        <input type="hidden" value="<?php echo $ts?>" id="checkTermin"> -->

                        <!-- <div id="mainKredit">
                          <hr>
                          <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">  
                                <label>Termin</label>
                                <input type="text" class="form-control" id="termin" name="termin[]" >
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Opname Pembayaran (%)</label>
                                <input type="number" class="form-control" id="opname" name="opname[]" >
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Nilai Pembayaran (Rp.)</label>
                                <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin" value="0" >
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="buttonbox"></div> -->
                        <input type="hidden" id="total_chq_kredit" class="total_chq_kredit">

                        <!-- <div class="col-12 row" style="background-color: pink; padding-top: 10px">
                          <hr>
                          <div class="col-sm-8">
                            <div class="form-group" style="text-align: right; padding-top: 8px; font-weight: bold">
                              Total
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="showTotalTermin" class="form-control" value="<?php echo "Rp ".$row->upah?>" readonly>
                                <input type="number" name="total_termin" id="totalTermin" value="<?php echo $row->upah - $tl;?>" class="form-control" readonly>
                            </div>
                          </div>
                        </div> -->
                    </div>  
                  </div>
                </div>
                <div class="card-footer">
                  <!-- <input type="hidden" value="<?php echo $no?>" id="check"> -->
                  <!-- <input type="hidden" value="<?php echo $id?>" name="kode_perumahan"> -->
                  <?php if(isset($succ_msg)){?>
                      <div style="color: green"><?php echo $succ_msg?></div>
                  <?php }?>

                  <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode">
                  <input type="hidden" value="<?php echo $id?>" name="id_form">
                  <input type="hidden" value="<?php echo $row->id_ppjb?>" name="id_ppjb">
                  <input type="submit" value="Tambah" class="btn btn-success btn-flat">
                </div>
                </form>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
    <?php }} else {
     foreach($check_all->result() as $row){?>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <a href="<?php echo base_url()?>Dashboard/view_add_kbk_management?id=<?php echo $row->kode_perumahan?>" class="btn btn-info btn-flat btn-sm">Kembali</a>
                    <!-- <a href="#" class="btn btn-info btn-flat">Tambah Baru</a> -->
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <form action="<?php echo base_url()?>Dashboard/add_kbk" method="POST" enctype="multipart/form-data">
                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">Pihak 1 - Developer</div>
                        <div class="col-12 row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Nama</label>
                              <input type="text" class="form-control" value="Hendra Hartady" name="dev_nama">
                            </div>
                            <div class="form-group">
                              <label>KTP</label>
                              <input type="text" class="form-control" value="6171062706890001" name="dev_ktp">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Alamat</label>
                              <textarea class="form-control" name="dev_alamat">Jl. Sei Raya Dalam, Komp Mitra Indah Utama V Blok C1</textarea>
                            </div>
                            <div class="form-group">
                              <label>Pekerjaan</label>
                              <input type="text" class="form-control" name="dev_pekerjaan" value="Karyawan Swasta / Manager Proyek <?php echo $nama_perumahan?> Residence">
                            </div>
                          </div>
                        </div>

                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          <div class="row">
                            <div class="col-sm-7">Pihak 2 - Sub Kontraktor</div>
                            <div class="col-sm-5">
                              <select class="form-control" id="subKon">
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($this->db->get('sub_kon')->result() as $kon){?>
                                  <option value="<?php echo $kon->id_sub_kon?>"><?php echo $kon->nama_sub?></option>
                                <?php }?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div id="response">
                          <div class="col-12 row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="" id="namaSub" placeholder="Nama Sub Kontraktor" name="sub_nama" required readonly>
                              </div>
                              <div class="form-group">
                                <label>KTP</label>
                                <input type="number" class="form-control" value="" id="ktpSub" placeholder="No KTP" name="sub_ktp" required readonly>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="sub_alamat" id="alamatSub" placeholder="Alamat Sub Kontraktor" required readonly></textarea>
                              </div>
                              <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" value="" id="pekerjaanSub" name="sub_pekerjaan" placeholder="Pekerjaan Sub Kontraktor" readonly required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">Data KBK</div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>No. SPK</label>
                                    <input type="text" class="form-control" value="<?php echo sprintf('%03d', $row->no_spk)."/SPK/".$kode_perusahaan."/".$row->kode_perumahan;?>" readonly>
                                    <input type="hidden" value="<?php echo $row->id_spk?>" name="id_spk">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" name="no_unit" value="<?php echo $row->unit?>" readonly>
                                    <!-- <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_spk"> -->
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Harga Total Unit</label>
                                    <input type="text" class="form-control" value="<?php echo "Rp. ".number_format($row->harga_unit)?>" readonly>
                                    <input type="hidden" value="<?php echo $row->harga_unit?>" name="harga_jual">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Bangunan</label>
                                    <input type="number" value="<?php echo $row->luas_bangunan?>" class="form-control" name="luas_bangunan" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Luas Tanah</label>
                                    <input type="number" value="<?php echo $row->luas_tanah?>" class="form-control" name="luas_tanah" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Upah</label>
                                    <input type="text" value="<?php echo "Rp. ".number_format($row->upah)?>" class="form-control" readonly required>
                                    <input type="hidden" value="<?php echo $row->upah?>" class="form-control" id="upah" name="upah" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kontrak Pekerjaan</label>
                                    <textarea class="form-control" name="kontrak_pekerjaan" readonly required><?php echo $row->kontrak_pekerjaan?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Masa Pelaksanaan (Hari)</label>
                                    <!-- <textarea class="form-control" id="masaPelaksanaan" name="masa_pelaksanaan" readonly required><?php echo $row->masa_pelaksanaan?></textarea> -->
                                    <input type="number" class="form-control" id="masaPelaksanaan" name="masa_pelaksanaan" value="<?php echo $row->masa_pelaksanaan?>" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal BAST</label>
                                  <input type="date" value="<?php echo date('Y-m-d', strtotime($row->tgl_bast))?>" class="form-control" name="tgl_bast" readonly required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <?php if($sistem_pembayaran == "KPR"){?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" value="<?php echo date('Y-m-d', strtotime($row->tgl_akad))?>" class="form-control" name="tgl_akad" readonly>
                                </div>
                              <?php } else { ?>
                                <div class="form-group">
                                    <label>Tanggal Akad (Hanya KPR)</label>
                                    <input type="date" value="<?php echo date('Y-m-d', strtotime($row->tgl_akad))?>" class="form-control" name="tgl_akad" readonly>
                                </div>
                              <?php }?>
                                <!-- <div class="form-group">
                                  <label class="" for="">Signature</label>
                                  <br/>
                                  <div id="sig"></div>
                                  <br/>
                                  <button type="button" id="clear" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
                                  <textarea id="signature64" name="signed" style="display: none"></textarea>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal Mulai</label>
                                  <input type="date" id="tglMulai" value="" class="form-control" name="tgl_mulai" required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal Selesai</label>
                                  <input type="date" id="tglSelesai" value="" class="form-control" name="tgl_selesai" required>
                              </div>
                            </div>
                        </div>

                        <div class="col-12 row" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          <div class="col-12">Ketentuan Pembayaran</div>
                          <!-- <div class="col-2" style="text-align: right;">
                              <button type="button" class="btn btn-sm btn-default add" id="add">+</button>
                              <button type="button" class="btn btn-sm btn-default remove" id="remove">-</button>
                          </div> -->
                        </div>

                        <!-- <div class="col-12 row" style="text-align: center; font-weight: bold; padding-bottom: 10px; padding-top: 10px">
                          <div class="col-sm-1">
                            No
                          </div>
                          <div class="col-sm-3">
                            Termin
                          </div>
                          <div class="col-sm-4">
                            Opname Pembayaran
                          </div>
                          <div class="col-sm-4">
                            Nilai Pembayaran
                          </div>
                        </div> -->
                        <div>
                          <table id="example2" class="table table-bordered" style="font-size: 14px">
                            <thead>
                                <tr>
                                  <th>Termin</th>
                                  <th>Opname Pembayaran (%)</th>
                                  <th>Nilai Pembayaran (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  Termin 1
                                  <input type="hidden" class="form-control" name="termin[]" value="Termin 1" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" id="opname1" name="opname[]" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin1" value="0" required>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Termin 2
                                  <input type="hidden" class="form-control" name="termin[]" value="Termin 2" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" id="opname2" name="opname[]" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin2" value="0" required>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Termin 3
                                  <input type="hidden" class="form-control" name="termin[]" value="Termin 3" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="opname[]" id="opname3" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin3" value="0" required>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Termin 4
                                  <input type="hidden" class="form-control" name="termin[]" value="Termin 4" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="opname[]" id="opname4" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin4" value="0" required>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Retensi / Pemeliharaan
                                  <input type="hidden" class="form-control" name="termin[]" value="Retensi / Pemeliharaan" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="opname[]" id="opname5" required>
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin5" value="0" required>
                                </td>
                              </tr>

                              <tr>
                                <td colspan=2 style="text-align: right; font-weight: bold">Total Termin</td>
                                <td><input type="number" name="total_termin" id="totalTermin" value="<?php echo $row->upah?>" class="form-control" readonly></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                        <!-- <div id="mainKredit">
                          <hr>
                          <div class="col-12 row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Termin</label>
                                <input type="text" class="form-control" name="termin[]" required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Opname Pembayaran (%)</label>
                                <input type="number" class="form-control" name="opname[]" required>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Nilai Pembayaran (Rp.)</label>
                                <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin" value="0" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="buttonbox"></div> -->
                        <input type="hidden" id="total_chq_kredit" class="total_chq_kredit">

                        <!-- <div class="col-12 row" style="background-color: pink; padding-top: 10px">
                          <hr>
                          <div class="col-sm-8">
                            <div class="form-group" style="text-align: right; padding-top: 8px; font-weight: bold">
                              Total
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" id="showTotalTermin" class="form-control" value="<?php echo "Rp ".$row->upah?>" readonly>
                                <input type="number" name="total_termin" id="totalTermin" value="<?php echo $row->upah?>" class="form-control" readonly>
                            </div>
                          </div>
                        </div> -->
                    </div>  
                  </div>
                </div>
                <div class="card-footer">
                  <!-- <input type="hidden" value="<?php echo $no?>" id="check"> -->
                  <!-- <input type="hidden" value="<?php echo $id?>" name="kode_perumahan"> -->
                  <?php if(isset($succ_msg)){?>
                      <div style="color: green"><?php echo $succ_msg?></div>
                  <?php }?>

                  <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode">
                  <input type="hidden" value="<?php echo $id?>" name="id_form">
                  <input type="hidden" value="<?php echo $row->id_ppjb?>" name="id_ppjb">
                  <input type="submit" value="Tambah" class="btn btn-success btn-flat">
                </div>
                </form>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
    <?php }}?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <?php include "include/footer.php"?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail POS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div style="text-align: center">Debet</div>
          </div>
          <div class="col-md-6">
            <div style="text-align: center">Kredit</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

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
<!-- page script -->
<script>
function myFunction(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di approve?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_approve?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}

function myFunction1(id) {
  var txt;
  var base_url = window.location.origin+"/DPMS/Dashboard";
  var r = confirm("Anda akan menetapkan PSJB ini di batalkan?");
  if (r == true) {
    window.location.replace(base_url+"/psjb_pembatalan?id="+id);
  } else {
    window.location.replace(base_url+"/psjb_management")
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
      // "scrollX": true
    });
    
    $("#example3").DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
      // "scrollX": true
    });
  });

</script>
<script>
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
  });

  $(document).ready(function(){
    $('#thisPrint').on('click', function(){
      window.print();
    })
  })

  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });

  $(document).ready(function(){
    $("select#outpost").change(function(){
        var selectedCountry = $("#outpost option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_unit",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response").html(data);
        });
    });

    $("select#namaBahan").change(function(){
        var selectedCountry = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_satuan",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response1").val(data);
        });
    });

    $("select#subKon").change(function(){
        var selectedCountry = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_sub_kon",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response").html(data);
        });
    });
});

  function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }
    
  // });
  $(document).ready(function() {
    var i = 0;
    var last1 = $('.buttonbox').last();
    $(document).on('click', '.add', function() {
      // $('#mainKredit').removeAttr('style');
      var clone = $('#mainKredit').clone().find("input").val("").end().find("textarea").val("").end().find('select option:first-child()').attr('selected','selected').end().attr("id", "mainKredit" + ++i).insertBefore(last1);
          
      // $('#mainKredit').hide();
      // $('#main'+i++).attr('id', 'nominalDebet'+i++);
      // clone.id = "main" + i;
      //   $('#mainKredit input[id="total"]').val(i);
      $('#total_chq_kredit').val(i);
      $('#mainKredit'+i+ ' #noData').val(i+1);

      $('#mainKredit'+i+ ' #nilaiTermin').val(0);

      $('#mainKredit'+i+ ' #termin').attr('required', 'required');
      $('#mainKredit'+i+ ' #opname').attr('required', 'required');
      $('#mainKredit'+i+ ' #nilaiTermin').attr('required', 'required');

      $('#mainKredit'+i+ ' #nilaiTermin').on('blur', function(e) {
        if (e.target.value == '') {
          e.target.value = 0


        }
      })
      
    //   var x = 1;
        $(function () {
            var check = $('#upah').val();

            $('#nilaiTermin').on("input", function(){
              var qt = $(this).val()
              var sum = 0;
              $("input[id^='nilaiTermin']").each(function(){
                  sum += +$(this).val();
              });
              $("#totalTermin").val(check - sum);
            })

            for (var x = 1; x <= i; x++) {
            (function (x) {
                $('#mainKredit'+x+' input[id="nilaiTermin"]').on("input", function () {
                    var qty = $(this).val();
                    // var hargaSatuan = $('#mainKredit'+x+' input[id="hargaSatuan"').val();

                    $('#mainKredit'+x+' input[id="totalTermin"').val(qty);

                    var sum = 0;
                    $("input[id^='nilaiTermin']").each(function(){
                        sum += +$(this).val();
                    });
                    $("#totalTermin").val(check - sum);
                });
            })(x);
            }
        });

        $(function () {
            // var check = $('#check').val();

            for (var y = 1; y <= i; y++) {
            (function (y) {
                $("#mainKredit"+y+ " select#namaBahan").change(function(){
                    var selectedCountry = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url()?>Dashboard/get_satuan",
                        data: { country : selectedCountry } 
                    }).done(function(data){
                        $("#mainKredit"+y+ " input[id='response']").val(data);
                    });
                });
            })(y);
            }
        });

        $(function () {
            // var check = $('#check').val();

            for (var z = 1; z <= i; z++) {
            (function (z) {
                $('#mainKredit'+z+' input[id="hargaSatuan"]').on("input", function () {
                  var qty = $(this).val();
                  var hargaSatuan = $('#mainKredit'+z+' input[id="qty"]').val();

                  $('#mainKredit'+z+' input[id="total"]').val(qty*hargaSatuan);

                  var sum = 0;
                    $("input[id='total']").each(function(){
                        sum += +$(this).val();
                    });
                    $("#totalAll").val(numberWithCommas(sum));
                });
            })(z);
            }
        });
    });

    
      $(".remove").click(function(){
        var termin = $('#totalTermin').val();
        if(i > 0) {
          var check = $('div[id^="mainKredit"]:last #nilaiTermin').val();

          $('#totalTermin').val(parseInt(termin) + parseInt(check));

          $('div[id^="mainKredit"]:last').remove();
          $('#total_chq_kredit').val(--i);
        } 
      });
  });

  $('#nilaiTermin').on("input", function(){
    var check = $('#upah').val();
    gt = $(this).val();

    var sum = 0;
    $("input[id^='nilaiTermin']").each(function(){
        sum += +$(this).val();
    });
    $("#totalTermin").val(check - sum);
  })

    $("select#namaBahan").change(function(){
        var selectedCountry = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_satuan",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("input[id='response']").val(data);
        });
    });

  $(function () {
      var check = $('#total_chq_kredit').val();
      
      // alert(check);

      for (var x = 1; x <= check; x++) {
        (function (i) {
            $('#mainKredit'+x+' input[id="qty"]').on("input", function () {
                var qty = $(this).val();
                var hargaSatuan = $('#mainKredit'+x+' input[id="hargaSatuan"]').val();

                $('#mainKredit'+x+' input[id="total"').val(qty*hargaSatuan);
            });
        })(i);
      }
    });

  $('#nilaiTermin').on('blur', function(e) {
      if (e.target.value == '') {
        e.target.value = 0
      }
    })


    $(document).ready(function () {
      var check = $('#upah').val();

      // $('#nilaiTermin').on("input", function(){
      //   var qt = $(this).val()
      //   var sum = 0;
      //   $("input[id='nilaiTermin']").each(function(){
      //       sum += +$(this).val();
      //   });
      //   $("#totalTermin").val(check - sum);
      // })
      // div[id^="mainKredit"]:last #nilaiTermin
      var i = $('#checkTermin').val()

      for (var x = 1; x <= 5; x++) {
      (function (x) {
          $('#opname'+x).on("input", function(){
            var op = $(this).val();

            if((x-1) == 0){
              p_op = 0;
            } else {
              var p_op = $('#opname'+(x-1)).val();
            }

            $('#nilaiTermin'+x).val(((op-p_op)*check)/100);

            var sum = 0;
            $("input[id^='nilaiTermin']").each(function(){
                sum += +$(this).val();
            });
            $("#totalTermin").val(check - sum);
          })

          $('#nilaiTermin'+x).on("input", function () {
              var qty = $(this).val();
              // var hargaSatuan = $('#mainKredit'+x+' input[id="hargaSatuan"').val();

              $('#mainKredit'+x+' input[id="totalTermin"').val(qty);

              var sum = 0;
              $("input[id^='nilaiTermin']").each(function(){
                  sum += +$(this).val();
              });
              $("#totalTermin").val(check - sum);
          });
      })(x);
      }
  });

  $('#tglMulai').on("input", function(e){
    var gt = $(this).val();
    var string = $('#masaPelaksanaan').val();
    // var num = string.replace( /^\D+/g, '');

    var regex = /\d+/g;
    // var string = "you can enter maximum 500 choices";
    var matches = string.match(regex); 
    // alert(matches);

    var date = new Date(gt);
    date.setDate(date.getDate() + parseInt(matches));
    console.log(date);

    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);

    var today = date.getFullYear()+"-"+(month)+"-"+(day) ;

    $('#tglSelesai').val(today);
    // alert(matches);
  })
</script>
<script type="text/javascript">
  var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
      e.preventDefault();
      sig.signature('clear');
      $("#signature64").val('');
  });
  var sig1 = $('#sig1').signature({syncField: '#signature641', syncFormat: 'PNG'});
    $('#clear1').click(function(e1) {
      e1.preventDefault();
      sig1.signature('clear');
      $("#signature641").val('');
  });
  var sig2 = $('#sig2').signature({syncField: '#signature642', syncFormat: 'PNG'});
    $('#clear2').click(function(e2) {
      e2.preventDefault();
      sig2.signature('clear');
      $("#signature642").val('');
  });
  var sig3 = $('#sig3').signature({syncField: '#signature643', syncFormat: 'PNG'});
    $('#clear3').click(function(e3) {
      e3.preventDefault();
      sig3.signature('clear');
      $("#signature643").val('');
  });
</script>
</body>
</html>
