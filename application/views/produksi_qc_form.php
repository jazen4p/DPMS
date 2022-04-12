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
                Form QC Untuk KBK No. <?php echo sprintf('%03d', $no_spk)?>          
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">
                QC
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
                    <a href="<?php echo base_url()?>Dashboard/qc_detail?id=<?php echo $id_kbk?>&kode=<?php echo $kode?>" class="btn btn-info btn-flat btn-sm">Kembali</a>
                    <!-- <a href="#" class="btn btn-info btn-flat">Tambah Baru</a> -->
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <form action="<?php echo base_url()?>Dashboard/add_qc" method="POST" enctype="multipart/form-data">
                        <div class="col-12 row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Konsumen</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No Unit</label>
                                    <input type="text" class="form-control" value="<?php echo $no_unit?>" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tgl Mulai Pembangunan</label>
                                    <input type="date" value="<?php echo $tgl_mulai?>" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tgl Mulai Pembangunan</label>
                                    <input type="date" value="<?php echo $tgl_selesai?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          Rincian Progress - <?php echo $row->tahap?>
                        </div>
                        <div class="col-12">
                          <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Progress Yang Harus Dicapai (%)</label>
                                    <input type="number" class="form-control" value="<?php echo $row->opname?>" name="opname" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Realisasi Progress (%)</label>
                                    <input type="number" name="realisasi_progress" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tgl Mulai Progress</label>
                                    <input type="date" name="tgl_mulai" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Tgl Selesai Progress</label>
                                    <input type="date" name="tgl_selesai" class="form-control" required>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 row" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          <div class="col-10">Progress - <?php echo $row->tahap?></div>
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
                          <table id="example2" class="table table-bordered" style="font-size: 13px">
                            <thead>
                                <tr>
                                  <th>Termin</th>
                                  <th>Hasil Sesuai [Check (Iya) / Tidak Check (Tidak)]</th>
                                  <!-- <th>Nilai Pembayaran (Rp.)</th> -->
                                </tr>
                            </thead>
                            <tbody>
                              <?php if($row->tahap == "Termin 1"){?>
                                <tr>
                                    <td style="width: 80%">
                                    <!-- Termin 1 -->
                                        <input type="text" class="form-control" name="termin[]" value="Galian Pondasi" required>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="opname1" name="opname[]" required> -->
                                        <input type="checkbox" name="hasil[]" value="true" class="form-control">
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin1" value="0" required>
                                    </td> -->
                                </tr>
                              <?php }?>
                              <tr>
                                <td style="width: 80%">
                                  <!-- Termin 2 -->
                                  <input type="text" class="form-control" name="termin[]" value="Pembesian Pondasi" required>
                                </td>
                                <td>
                                  <!-- <input type="number" class="form-control" id="opname2" name="opname[]" required> -->
                                    <input type="checkbox" name="hasil[]" value="true" class="form-control">
                                </td>
                                <!-- <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin2" value="0" required>
                                </td> -->
                              </tr>
                              <tr>
                                <td style="width: 80%">
                                  <!-- Termin 3 -->
                                  <input type="text" class="form-control" name="termin[]" value="Pengerjaan Batu Kolong" required>
                                </td>
                                <td>
                                  <!-- <input type="number" class="form-control" name="opname[]" id="opname3" required> -->
                                    <input type="checkbox" name="hasil[]" value="true" class="form-control">
                                </td>
                                <!-- <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin3" value="0" required>
                                </td> -->
                              </tr>
                              <tr>
                                <td style="width: 80%">
                                  <!-- Termin 4 -->
                                  <input type="text" class="form-control" name="termin[]" value="Pemberian Sloof & Wiremesh" required>
                                </td>
                                <td>
                                  <!-- <input type="number" class="form-control" name="opname[]" id="opname4" required> -->
                                    <input type="checkbox" name="hasil[]" value="true" class="form-control">
                                </td>
                                <!-- <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin4" value="0" required>
                                </td> -->
                              </tr>
                              <tr>
                                <td style="width: 80%">
                                  <!-- Retensi / Pemeliharaan -->
                                  <input type="text" class="form-control" name="termin[]" value="Cor Lantai" required>
                                </td>
                                <td>
                                  <!-- <input type="number" class="form-control" name="opname[]" id="opname5" required> -->
                                    <input type="checkbox" name="hasil[]" value="true" class="form-control">
                                </td>
                                <!-- <td>
                                  <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin5" value="0" required>
                                </td> -->
                              </tr>
                              
                              <!-- <div id="mainKredit"> -->
                                <tr id="mainKredit">
                                    <td style="width: 80%">
                                        <input type="text" class="form-control" name="termin[]">
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" name="opname[]" required> -->
                                        <input type="checkbox" name="hasil[]" value="true" class="form-control">
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin" value="0" required>
                                    </td> -->
                                </tr>
                              <!-- </div> -->
                              <!-- <div class="buttonbox"></div> -->
                              <tr class="buttonbox"></tr>

                              <!-- <tr>
                                <td colspan=2 style="text-align: right; font-weight: bold">Total Termin</td>
                                <td><input type="number" name="total_termin" id="totalTermin" value="" class="form-control" readonly></td>
                              </tr> -->
                            </tbody>
                          </table>
                        </div>

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

                  <input type="hidden" value="<?php echo $kode?>" name="kode">
                  <input type="hidden" value="<?php echo $id?>" name="id_termin">
                  <input type="hidden" value="<?php echo $id_kbk?>" name="id_kbk">
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
                <div class="card-header row">
                    <div class="col-6">
                      <a href="<?php echo base_url()?>Dashboard/qc_detail?id=<?php echo $id_kbk?>&kode=<?php echo $kode?>" class="btn btn-info btn-flat btn-sm">Kembali</a>
                      <a href="<?php echo base_url()?>Dashboard/qc_management?id=<?php echo $kode?>" class="btn btn-info btn-flat btn-sm">Kembali ke awal</a>
                    </div>
                    <!-- <a href="#" class="btn btn-info btn-flat">Tambah Baru</a> --> <br>
                    <div class="col-6" style="text-align: right">
                      <button type="button" class="btn btn-info btn-flat btn-sm" data-toggle="modal" data-target="#uploadModal">Upload Foto Progress</button>
                      <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager produksi"){?>
                        <a href="<?php echo base_url()?>Dashboard/kbk_pencairan?id=<?php echo $id?>&ids=<?php echo $id_kbk?>&kode=<?php echo $kode?>" class="btn btn-success btn-flat btn-sm">Pencairan</a>
                        <button type="button" class="btn btn-info btn-flat btn-sm" data-target="#exampleModal" data-toggle="modal">Detail Pencairan</button>
                      <?php }?>
                    </div>
                    <?php if(isset($succ_msg)){?>
                      <div class="col-12">
                        <div style="color: green"><?php echo $succ_msg?></div>
                      </div>
                    <?php }?>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <?php 
                      $this->db->order_by('id_qc', "ASC");
                      $gt = $this->db->get_where('kbk_qc', array('id_termin'=>$row->id_termin));
                      if($gt->num_rows() > 0){?>
                        <form action="<?php echo base_url()?>Dashboard/edit_qc" method="POST" enctype="multipart/form-data">
                      <?php } else {?>
                        <form action="<?php echo base_url()?>Dashboard/add_qc" method="POST" enctype="multipart/form-data">
                      <?php }?>
                        <div class="col-12 row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Konsumen</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No Unit</label>
                                    <input type="text" class="form-control" value="<?php echo $no_unit?>" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tgl Mulai Pembangunan</label>
                                    <input type="date" value="<?php echo $tgl_mulai?>" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tgl Mulai Pembangunan</label>
                                    <input type="date" value="<?php echo $tgl_selesai?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          Rincian Progress - <?php echo $row->tahap?>
                        </div>
                        <div class="col-12">
                          <div class="row">
                            <?php if($gt->num_rows() > 0){?>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Progress Yang Harus Dicapai (%)</label>
                                        <input type="number" class="form-control" value="<?php echo $row->opname?>" name="opname" readonly>
                                    </div>
                                    <?php 
                                    // foreach($gt->result() as $qc){?>
                                    <div class="form-group">
                                        <label>Realisasi Progress (%)</label>
                                        <input type="number" name="realisasi_progress" class="form-control" value="<?php echo $row->realisasi_progress?>" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Tgl Mulai Progress</label>
                                        <input type="date" name="tgl_mulai" class="form-control" value="<?php echo $row->tgl_mulai?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tgl Selesai Progress</label>
                                        <input type="date" name="tgl_selesai" class="form-control" value="<?php echo $row->tgl_selesai?>" required>
                                    </div>
                                    <?php 
                                // }?>
                                </div>
                            <?php } else {?>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Progress Yang Harus Dicapai (%)</label>
                                        <input type="number" class="form-control" value="<?php echo $row->opname?>" name="opname" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Realisasi Progress (%)</label>
                                        <input type="number" name="realisasi_progress" class="form-control" value="<?php echo $row->realisasi_progress?>" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Tgl Mulai Progress</label>
                                        <input type="date" name="tgl_mulai" class="form-control" value="<?php echo $row->tgl_mulai?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tgl Selesai Progress</label>
                                        <input type="date" name="tgl_selesai" class="form-control" value="<?php echo $row->tgl_selesai?>" required>
                                    </div>
                                </div>
                            <?php }?>
                          </div>
                        </div>

                        <div class="col-12 row" style="background-color: lightblue; text-align: center; padding-bottom: 5px; padding-top: 5px">
                          <div class="col-10">Progress - <?php echo $row->tahap?></div>
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
                        <?php if($gt->num_rows() > 0) {?>
                          <table id="example2" class="table table-bordered" style="font-size: 13px">
                            <thead>
                                <tr>
                                  <th>Termin</th>
                                  <th>Hasil Sesuai [Check (Iya) / Tidak Check (Tidak)]</th>
                                  <!-- <th>Nilai Pembayaran (Rp.)</th> -->
                                  <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager produksi"){?>
                                    <th>Approval</th>
                                  <?php }?>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $no=1; 
                              // $this->db->order_by('id_qc', "ASC");
                              foreach($gt->result() as $qcs){?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="id_qc[]" value="<?php echo $qcs->id_qc?>">
                                        <input type="hidden" name="status[]" value="<?php echo $qcs->status_approved?>">

                                        <input type="text" class="form-control" name="termin[]" value="<?php echo $qcs->jenis_pekerjaan?>">
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" name="opname[]" required> -->
                                        <input type="hidden" name="hasil[]" id="hasilOpnameHidden<?php echo $no?>" class="form-control" value="<?php if($qcs->status_approved == "true"){echo "true";} else {echo "false";}?>" <?php if($qcs->hasil_sesuai == "true"){ echo "disabled";}?>>
                                        <input type="hidden" name='hasil[]' id="hasilOpnameHidden2<?php echo $no?>" value="true" <?php if($qcs->status_approved != 'true'){echo 'disabled';}?>>
 
                                        <input type="checkbox" name="hasil[]" id="hasilOpname<?php echo $no?>" class="form-control" value="true" <?php if($qcs->status_approved == "true"){echo "disabled";}?> <?php if($qcs->hasil_sesuai == "true"){ echo "checked='true'";}?>>
                                    </td>
                                    <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager produksi"){?>
                                        <td>
                                            <input type="hidden" name="app[]" class="form-control" value="false" id="appOpnameHidden<?php echo $no?>" <?php if($qcs->status_approved == "true"){ echo "disabled";}?>>
                                            <input type="checkbox" name="app[]" <?php if($qcs->status_approved == "true"){ echo "checked='true'";}?> <?php if($qcs->hasil_sesuai == "false"){echo "disabled";}?> value="true" id="appOpname<?php echo $no?>" class="form-control">
                                        </td>
                                    <?php }?>
                                </tr>
                              <?php $no++;}?>
                              <input type="hidden" id="hasil_chq" value="<?php echo $no?>">

                              <!-- <div id="mainKredit"> -->
                                <tr id="mainKredit">
                                    <td style="width: 80%">
                                        <input type="text" class="form-control" name="termin[]">
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" name="opname[]" required> -->
                                        <!-- <input type="checkbox" name="hasil[]" value="true" class="form-control"> -->
                                        <!-- <input type="hidden" name="hasil[]" class="form-control" value="false" id="hasilOpnameHidden<?php echo $no?>" <?php if($qcs->hasil_sesuai == "true"){ echo "disabled";}?>> -->
                                        <input type="hidden" name="hasil[]" id="hasilOpnameHidden<?php echo $no?>" class="form-control" value="<?php if($qcs->status_approved == "true"){echo "true";} else {echo "false";}?>" <?php if($qcs->hasil_sesuai == "true"){ echo "disabled";}?>>
                                        <input type="hidden" name='hasil[]' id="hasilOpnameHidden2<?php echo $no?>" value="true" <?php if($qcs->status_approved != 'true'){echo 'disabled';}?>>
                                        
                                        <!-- <input type="checkbox" name="hasil[]" <?php if($qcs->hasil_sesuai == "true"){ echo "checked='true'";}?> value="true" id="hasilOpname<?php echo $no?>" class="form-control"> -->
                                        <input type="checkbox" name="hasil[]" id="hasilOpname<?php echo $no?>" class="form-control" value="true" <?php if($qcs->status_approved == "true"){echo "disabled";}?> <?php if($qcs->hasil_sesuai == "true"){ echo "checked='true'";}?>>
                                    </td>
                                    <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager produksi"){?>
                                        <td>
                                            <input type="hidden" name="app[]" class="form-control" value="false" id="appOpnameHidden<?php echo $no?>" <?php if($qcs->status_approved == "true"){ echo "disabled";}?>>
                                            <input type="checkbox" name="app[]" <?php if($qcs->status_approved == "true"){ echo "checked='true'";}?> value="true" id="appOpname<?php echo $no?>" class="form-control">
                                        </td>
                                    <?php }?>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin" value="0" required>
                                    </td> -->
                                </tr>
                              <!-- </div> -->
                              <!-- <div class="buttonbox"></div> -->
                              <tr class="buttonbox"></tr>

                              <!-- <tr>
                                <td colspan=2 style="text-align: right; font-weight: bold">Total Termin</td>
                                <td><input type="number" name="total_termin" id="totalTermin" value="" class="form-control" readonly></td>
                              </tr> -->
                            </tbody>
                          </table>
                        <?php } else { ?>
                            <table id="example2" class="table table-bordered" style="font-size: 13px">
                            <thead>
                                <tr>
                                  <th>Termin</th>
                                  <th>Hasil Sesuai [Check (Iya) / Tidak Check (Tidak)]</th>
                                  <!-- <th>Nilai Pembayaran (Rp.)</th> -->
                                </tr>
                            </thead>
                            <tbody>
                              <?php $no=1; if($row->tahap == "Termin 1"){?>
                                <tr>
                                    <td style="width: 80%">
                                    <!-- Termin 1 -->
                                        <input type="text" class="form-control" name="termin[]" value="Galian Pondasi" required>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="opname1" name="opname[]" required> -->
                                        <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                        <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin1" value="0" required>
                                    </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 2 -->
                                    <input type="text" class="form-control" name="termin[]" value="Pembesian Pondasi" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" id="opname2" name="opname[]" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin2" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 3 -->
                                    <input type="text" class="form-control" name="termin[]" value="Pengerjaan Batu Kolong" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname3" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin3" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 4 -->
                                    <input type="text" class="form-control" name="termin[]" value="Pemberian Sloof & Wiremesh" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname4" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin4" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Retensi / Pemeliharaan -->
                                    <input type="text" class="form-control" name="termin[]" value="Cor Lantai" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname5" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin5" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <input type="hidden" id="hasil_chq" value="<?php echo $no?>">
                              <?php } else if($row->tahap == "Termin 2"){ ?>
                                <tr>
                                    <td style="width: 80%">
                                    <!-- Termin 1 -->
                                        <input type="text" class="form-control" name="termin[]" value="Pemasangan Batako Dinding" required>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="opname1" name="opname[]" required> -->
                                        <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                        <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin1" value="0" required>
                                    </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 2 -->
                                    <input type="text" class="form-control" name="termin[]" value="Kolong Praktis" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" id="opname2" name="opname[]" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin2" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 3 -->
                                    <input type="text" class="form-control" name="termin[]" value="Ring Balok" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname3" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin3" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 4 -->
                                    <input type="text" class="form-control" name="termin[]" value="Plester Dinding" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname4" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin4" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Retensi / Pemeliharaan -->
                                    <input type="text" class="form-control" name="termin[]" value="Pengerjaan Tiang Dinding Minimalis" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname5" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin5" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Retensi / Pemeliharaan -->
                                    <input type="text" class="form-control" name="termin[]" value="Pemasangan Bata Tebing Layar & Plester" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname5" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin5" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <input type="hidden" id="hasil_chq" value="<?php echo $no?>">
                              <?php } else if($row->tahap == "Termin 3"){ ?>
                                <tr>
                                    <td style="width: 80%">
                                    <!-- Termin 1 -->
                                        <input type="text" class="form-control" name="termin[]" value="Plafon" required>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="opname1" name="opname[]" required> -->
                                        <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                        <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin1" value="0" required>
                                    </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 2 -->
                                    <input type="text" class="form-control" name="termin[]" value="Listrik" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" id="opname2" name="opname[]" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin2" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 3 -->
                                    <input type="text" class="form-control" name="termin[]" value="Acian Minimalis" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname3" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin3" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <input type="hidden" id="hasil_chq" value="<?php echo $no?>">
                              <?php } else if($row->tahap == "Termin 4"){ ?>
                                <tr>
                                    <td style="width: 80%">
                                    <!-- Termin 1 -->
                                        <input type="text" class="form-control" name="termin[]" value="Keramik Lantai Dalam 40x40" required>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="opname1" name="opname[]" required> -->
                                        <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                        <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin1" value="0" required>
                                    </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 2 -->
                                    <input type="text" class="form-control" name="termin[]" value="Keramik Teras Depan & Belakang 30x30" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" id="opname2" name="opname[]" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin2" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 3 -->
                                    <input type="text" class="form-control" name="termin[]" value="Keramik WC 20x20 & 20x25" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname3" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin3" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <tr>
                                  <td style="width: 80%">
                                    <!-- Termin 3 -->
                                    <input type="text" class="form-control" name="termin[]" value="Pemasangan Pintu dan Jendela" required>
                                  </td>
                                  <td>
                                    <!-- <input type="number" class="form-control" name="opname[]" id="opname3" required> -->
                                          <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                          <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                  </td>
                                  <!-- <td>
                                    <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin3" value="0" required>
                                  </td> -->
                                </tr>
                                <?php $no++?>
                                <input type="hidden" id="hasil_chq" value="<?php echo $no?>">
                              <?php } else { ?>
                                <tr>
                                    <td style="width: 80%">
                                    <!-- Termin 1 -->
                                        <input type="text" class="form-control" name="termin[]" value="Pengecekan Penyelesaian Unit" required>
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" id="opname1" name="opname[]" required> -->
                                        <input type="hidden" id="hasilOpnameHidden<?php echo $no?>" name="hasil[]" value="false">
                                        <input type="checkbox" id="hasilOpname<?php echo $no?>" name="hasil[]" value="true" class="form-control">
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin1" value="0" required>
                                    </td> -->
                                </tr>
                                <input type="hidden" id="hasil_chq" value="<?php echo $no?>"> 
                              <?php } $no++;?>

                              <!-- <div id="mainKredit"> -->
                                <tr id="mainKredit">
                                    <td style="width: 80%">
                                        <input type="text" class="form-control" name="termin[]">
                                    </td>
                                    <td>
                                        <!-- <input type="number" class="form-control" name="opname[]" required> -->
                                        <input type="hidden" id="hasilOpnameHidden" name="hasil[]" value="false">
                                        <input type="checkbox" id="hasilOpname" name="hasil[]" value="true" class="form-control">
                                        <!-- <input type="checkbox" name="hasil[]" value="true" class="form-control"> -->
                                    </td>
                                    <!-- <td>
                                        <input type="number" class="form-control" name="nilaitermin[]" id="nilaiTermin" value="0" required>
                                    </td> -->
                                </tr>
                              <!-- </div> -->
                              <!-- <div class="buttonbox"></div> -->
                              <tr class="buttonbox"></tr>

                              <!-- <tr>
                                <td colspan=2 style="text-align: right; font-weight: bold">Total Termin</td>
                                <td><input type="number" name="total_termin" id="totalTermin" value="" class="form-control" readonly></td>
                              </tr> -->
                            </tbody>
                          </table>
                        <?php }?>
                        </div>

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

                  <input type="hidden" value="<?php echo $kode?>" name="kode">
                  <input type="hidden" value="<?php echo $id?>" name="id_termin">
                  <input type="hidden" value="<?php echo $id_kbk?>" name="id_kbk">
                  <?php if($gt->num_rows() > 0){ ?>
                    <input type="submit" value="Update" class="btn btn-success btn-flat">
                  <?php } else { ?>
                    <input type="submit" value="Tambah" class="btn btn-success btn-flat">
                  <?php } ?>
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
        <h5 class="modal-title" id="exampleModalLabel">Detail Pencairan Untuk <?php echo $row->tahap?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No.</th>
              <th>Tanggal</th>
              <th>Nominal</th>
            </tr>
          </thead>
          <tbody>
            <?php $nos=1; $ttl=0; foreach($this->db->get_where('kbk_pencairan', array('id_termin'=>$id))->result() as $ters){?>
              <tr>
                <td><?php echo $nos;?></td>
                <td><?php echo $ters->tgl_pencairan;?></td>
                <td><?php echo "Rp. ".number_format($ters->nominal);?></td>
              </tr>
            <?php $nos++; $ttl=$ttl+$ters->nominal;}?>
            <tr>
              <td colspan=2>TOTAL</td>
              <td><?php echo "Rp. ".number_format($ttl);?></td>
            </tr>
          </tbody>
        </table>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Foto Progress</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>Preview foto yang telah diupload! (Uploaded: <?php echo $files->num_rows()?> pics) <a href="<?php echo base_url()?>Dashboard/remove_all_foto_termin?id=<?php echo $id?>&ids=<?php echo $id_kbk?>&kode=<?php echo $kode?>"><u>Delete All</u></a></div>
        <div class="row">
        <?php foreach($files->result() as $row){?>
          <div class="card">
            <div class="card-body">
              <a href="<?php echo base_url()?>gambar/termin/<?php echo $row->file_name?>" download>
                <img src="<?php echo base_url()?>gambar/termin/<?php echo $row->file_name?>" style="width: 70px; height: 50px">
              </a>
            </div>
          <!-- <br> -->
            <div class="card-footer" style="text-align: center">
              <u><a href="<?php echo base_url()?>Dashboard/remove_foto_termin?img=<?php echo $row->id_img?>&file=<?php echo $row->file_name?>&id=<?php echo $id?>&ids=<?php echo $id_kbk?>&kode=<?php echo $kode?>">Hapus</a></u>
            </div>
          </div>
        <?php }?>
        </div>
        <br>
        <!-- <div>Tarik atau pilih gambar yang akan di upload!</div> -->
        <!-- <div class="dropzone" id="fileupload" method="POST">

        </div>     -->
        <div class="dropzone">
          <div class="dz-message">
            <h3> Klik atau Drop gambar disini</h3>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" value="<?php echo $id?>" name="id_termin" id="idTermin">
          <input type="hidden" value="<?php echo $id_kbk?>" name="id_kbk" id="idKBK">
          <input type="hidden" value="<?php echo $kode?>" name="kode_perumahan" id="kodePerumahan">

          <!-- <input type="submit" value="Upload" class="btn btn-success"> -->
        <!-- </form> -->
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

<script src="<?php echo base_url()?>assets/dropzone-5.7.0/dist/dropzone.js"></script>

<script type="text/javascript">
    // Add restrictions
    Dropzone.autoDiscover = false;

    var foto_upload= new Dropzone(".dropzone",{
      url: "<?php echo base_url()?>Dashboard/upload_foto_termin?id=<?php echo $id?>",
      maxFilesize: 2,
      method:"post",
      acceptedFiles:"image/*",
      paramName:"userfile",
      dictInvalidFileType:"Type file ini tidak dizinkan",
      addRemoveLinks:true,
    });

    // var id = $('#idTermin').val();
    // var idKBK = $('#idKBK').val();
    // var kode = $('#kode').val();
    //Event ketika Memulai mengupload
    foto_upload.on("sending",function(a,b,c){
      a.token=Math.random();
      c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
      // c.append("id_termin",id);
      // c.append("id_kbk", $idKBK);
      // c.append("kode", $kode);
    });


    //Event ketika foto dihapus
    foto_upload.on("removedfile",function(a){
      var token=a.token;
      $.ajax({
        type:"post",
        data:{token:token},
        url:"<?php echo base_url('Dashboard/remove_file_termin') ?>",
        cache:false,
        dataType: 'json',
        success: function(){
          console.log("Foto terhapus");
        },
        error: function(){
          console.log("Error");

        }
      });
    });
</script>
<!-- page script -->
<script type="text/javascript">
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
<script type="text/javascript">
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
      "scrollX": true,
      "scrollY": "400px"
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

  $(function () {
    var check = $('#hasil_chq').val();
    
    // alert(check);

    for (var x = 0; x <= check; x++) {
      (function (x) {
          $('#hasilOpname'+x).on("click", function(){
              if($('#hasilOpname'+x).prop('checked') == true){
                  $('#hasilOpnameHidden'+x).attr("disabled", "disabled");
              } else {
                  $('#hasilOpnameHidden'+x).removeAttr("disabled");
              }
              
          });
          $('#appOpname'+x).on("click", function(){
              if($('#appOpname'+x).prop('checked') == true){
                  $('#appOpnameHidden'+x).attr("disabled", "disabled");
                  $('#hasilOpname'+x).attr("disabled", "disabled");
                  $('#hasilOpnameHidden2'+x).removeAttr("disabled");
              } else {
                  $('#appOpnameHidden'+x).removeAttr("disabled");
                  $('#hasilOpname'+x).removeAttr("disabled");
                  $('#hasilOpnameHidden2'+x).attr("disabled", "disabled");
              }
              
          });
      })(x);
    }
  });

  $(function(){
    $('#hasilOpname').on("click", function(){
        if($('#hasilOpname').prop('checked') == true){
            $('#hasilOpnameHidden').attr("disabled", "disabled");
        } else {
            $('#hasilOpnameHidden').removeAttr("disabled");
        }
        
    });
    $('#appOpname').on("click", function(){
        if($('#appOpname').prop('checked') == true){
            $('#appOpnameHidden').attr("disabled", "disabled");
            $('#hasilOpname').attr("disabled", "disabled");
            $('#hasilOpnameHidden2').removeAttr("disabled");
        } else {
            $('#appOpnameHidden').removeAttr("disabled");
            $('#hasilOpname').removeAttr("disabled");
            $('#hasilOpnameHidden2').attr("disabled", "disabled");
        }
        
    });
  })
</script>
<script type="text/javascript">
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
      var clone = $('#mainKredit').clone().attr("id", "mainKredit" + ++i).insertBefore(last1);
          
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
              $('#mainKredit'+x+' #hasilOpname').on("click", function(){
                  if($('#mainKredit'+x+' #hasilOpname').prop('checked') == true){
                      $('#mainKredit'+x+' #hasilOpnameHidden').attr("disabled", "disabled");
                  } else {
                      $('#mainKredit'+x+' #hasilOpnameHidden').removeAttr("disabled");
                  }
                  
              });
              $('#mainKredit'+x+' #appOpname').on("click", function(){
                  if($('#mainKredit'+x+' #appOpname').prop('checked') == true){
                      $('#mainKredit'+x+' #appOpnameHidden').attr("disabled", "disabled");
                      $('#mainKredit'+x+' #hasilOpname').attr("disabled", "disabled");
                      $('#mainKredit'+x+' #hasilOpnameHidden2').removeAttr("disabled");
                  } else {
                      $('#mainKredit'+x+' #appOpnameHidden').removeAttr("disabled");
                      $('#mainKredit'+x+' #hasilOpname').removeAttr("disabled");
                      $('#mainKredit'+x+' #hasilOpnameHidden2').attr("disabled", "disabled");
                  }
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

          $('tr[id^="mainKredit"]:last').remove();
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
