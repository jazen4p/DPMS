<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <?php include "include/title.php"?>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>asset/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include "include/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "include/sidebar.php"?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->
    <?php if(isset($edit_pembayaran)){?>
      <?php if(isset($kpr)){?>
        <?php foreach($kpr as $row){?>
        <!-- Main content -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Penerimaan KPR No PPJB <?php echo "1-".substr("000{$row->no_psjb}", -3)?></h1>
                <h5>Penerimaan KPR</h5>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                  <li class="breadcrumb-item active">Transaksi Keuangan KPR</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>

        <section class="content">
          <div class="container-fluid">
            <form action="<?php echo base_url()?>Dashboard/add_pembayaran" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-header">
                    <div class="row">
                      <a href="<?php echo base_url()?>Dashboard/detail_pembayaran?id=<?php echo $id?>" class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <!-- /.row -->
                  </div>
                  <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Konsumen</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" name="nama_konsumen" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No PPJB</label>
                                    <input type="text" class="form-control" value="<?php echo "1-".substr("000{$row->no_psjb}", -3)?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Pencairan KPR (Rp)</label>
                                    <input type="number" class="form-control" id="totalPencairan" value="<?php echo $row->dana_masuk?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Kekurangan (Rp)</label>
                                    <input type="number" class="form-control" id="danaKekurangan" name="dana_saat" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Akumulasi Pencairan Dana (Rp)</label>
                                    <input type="number" class="form-control" value="<?php echo $row->dana_bayar?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Pencairan (Rp)</label>
                                    <input type="number" name="dana_bayar" id="danaBayar" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Sisa Kekurangan (Rp)</label>
                                    <input type="number" name="dana_kurang" class="form-control" id="danaKurang" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tahap Pencairan</label>
                                    <input type="hidden" class="form-control" name="tahap_bayar" value="<?php echo $row->cara_bayar?>" readonly>
                                    <input type="text" class="form-control" name="tahap_pencairan" value="">
                                </div>
                                <div class="form-group">
                                    <label>Persen Pencairan (%)</label>
                                    <input type="number" name="persen_pencairan" id="persenPencairan" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pencairan</label>
                                    <input type="date" class="form-control" name="tanggal_bayar" value="<?php echo date('Y-m-d')?>">
                                </div>
                                <div class="form-group">
                                    <label>Cara Pembayaran</label>
                                    <select class="form-control" placeholder="" id="caraPembayaran" name="cara_pembayaran" required>
                                        <option disabled selected value="">-Pilih-</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <div id="showBank"></div>
                                    <select class="form-control" id="bank" name="bank">
                                        <?php foreach($this->db->get('bank')->result() as $row2){?>
                                            <option value="<?php echo $row2->id_bank?>"><?php echo $row2->nama_bank?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <input type="hidden" value="<?php echo $row->id_psjb?>" name="id_psjb">
                                    <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_ppjb">
                                    <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                    <input type="submit" class="btn btn-success btn-sm" value="Tambah">
                                </div>
                            </div>

                        </div>
                      </div>
                    <!-- /.row -->
                  </div>
                  
                  </form>
                  <!-- ./card-body -->
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!--/. container-fluid -->
        </section>
        <?php }} else {?>
        <?php foreach($test as $row) {?>
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Edit Form Pembayaran No PPJB <?php echo "1-".substr("000{$row->no_psjb}", -3)?></h1>
                  <h5>Pembayaran Piutang</h5>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi Keuangan</li>
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>

          <section class="content">
          <div class="container-fluid">
            <form action="<?php echo base_url()?>Dashboard/add_pembayaran" method="post">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-footer">
                    <div class="row">
                      <a href="<?php echo base_url()?>Dashboard/detail_pembayaran?id=<?php echo $id?>" class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Konsumen</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" name="nama_konsumen" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No PPJB</label>
                                    <input type="text" class="form-control" value="<?php echo "1-".substr("000{$row->no_psjb}", -3)?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tahap Pembayaran</label>
                                    <input type="text" class="form-control" name="tahap_bayar" value="<?php echo $row->cara_bayar?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Biaya Untuk Pembayaran (Rp)</label>
                                    <input type="number" class="form-control" value="<?php echo $row->dana_masuk?>" name="total_patok" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Kekurangan (Rp)</label>
                                    <input type="number" class="form-control" id="danaKekurangan" name="dana_saat" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Akumulasi Biaya Yang Telah Dibayar (Rp)</label>
                                    <input type="number" class="form-control" value="<?php echo $row->dana_bayar?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Terbayar (Rp)</label>
                                    <?php foreach($edit_pembayaran->result() as $res){?>
                                      <input type="number" name="dana_bayar" id="danaBayar" value="<?php echo $res->pembayaran?>" class="form-control" >
                                    <?php }?>
                                </div>
                                <div class="form-group">
                                    <label>Sisa Kekurangan (Rp)</label>
                                    <input type="number" name="dana_kurang" class="form-control" id="danaKurang" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Bayar</label>
                                    <input type="date" class="form-control" name="tanggal_bayar" value="<?php echo date('Y-m-d')?>">
                                </div>
                                <div class="form-group">
                                    <label>Cara Pembayaran</label>
                                    <select class="form-control" placeholder="" id="caraPembayaran" name="cara_pembayaran" required>
                                        <option disabled selected value="">-Pilih-</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <div id="showBank"></div>
                                    <select class="form-control" id="bank" name="bank">
                                        <option value="" disabled selected>-Pilih-</option>
                                        <?php foreach($this->db->get('bank')->result() as $row2){?>
                                            <option value="<?php echo $row2->id_bank?>"><?php echo $row2->nama_bank?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <input type="hidden" value="<?php echo $id;?>" name="id">
                                    <input type="hidden" value="<?php echo $row->id_psjb?>" name="id_psjb">
                                    <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_ppjb">
                                    <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                    <input type="hidden" value="0" name="persen_pencairan">
                                    <input type="hidden" value="a" name="tahap_pencairan">

                                    <input type="submit" class="btn btn-success btn-sm" value="Tambah">
                                </div>
                            </div>

                        </div>
                      </div>
                    <!-- /.row -->
                  </div>
                  
                  </form>
                  <!-- ./card-body -->
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!--/. container-fluid -->
        </section>
        <?php }}?>
    <?php } else {?>
      <?php if(isset($kpr)){?>
        <?php foreach($kpr as $row){?>
        <!-- Main content -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Penerimaan KPR No PPJB <?php echo "1-".substr("000{$row->no_psjb}", -3)?></h1>
                <h5>Penerimaan KPR</h5>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                  <li class="breadcrumb-item active">Transaksi Keuangan KPR</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>

        <section class="content">
          <div class="container-fluid">
            <form action="<?php echo base_url()?>Dashboard/add_pembayaran" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <!-- /.card-header -->
                  <!-- ./card-body -->
                  <div class="card-footer">
                    <div class="row">
                      <a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>"/ class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <!-- /.row -->
                  </div>
                  <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Konsumen</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" name="nama_konsumen" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No PPJB</label>
                                    <input type="text" class="form-control" value="<?php echo "1-".substr("000{$row->no_psjb}", -3)?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Pencairan KPR (Rp)</label>
                                    <input type="number" class="form-control" id="totalPencairan" value="<?php echo $row->dana_masuk?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Kekurangan (Rp)</label>
                                    <input type="number" class="form-control" id="danaKekurangan" name="dana_saat" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Akumulasi Pencairan Dana (Rp)</label>
                                    <input type="number" class="form-control" value="<?php echo $row->dana_bayar?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Pencairan (Rp)</label>
                                    <input type="number" name="dana_bayar" id="danaBayar" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Sisa Kekurangan (Rp)</label>
                                    <input type="number" name="dana_kurang" class="form-control" id="danaKurang" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tahap Pencairan</label>
                                    <input type="hidden" class="form-control" name="tahap_bayar" value="<?php echo $row->cara_bayar?>" readonly>
                                    <input type="text" class="form-control" name="tahap_pencairan" value="">
                                </div>
                                <div class="form-group">
                                    <label>Persen Pencairan (%)</label>
                                    <input type="number" name="persen_pencairan" id="persenPencairan" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pencairan</label>
                                    <input type="date" class="form-control" name="tanggal_bayar" value="<?php echo date('Y-m-d')?>">
                                </div>
                                <div class="form-group">
                                    <label>Cara Pembayaran</label>
                                    <select class="form-control" placeholder="" id="caraPembayaran" name="cara_pembayaran" required>
                                        <option disabled selected value="">-Pilih-</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <div id="showBank"></div>
                                    <select class="form-control" id="bank" name="bank" required>
                                      <option value="" disabled selected>-Pilih-</option>
                                        <?php foreach($this->db->get('bank')->result() as $row2){?>
                                            <option value="<?php echo $row2->id_bank?>"><?php echo $row2->nama_bank?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <input type="hidden" value="<?php echo $row->id_psjb?>" name="id_psjb">
                                    <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_ppjb">
                                    <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                    <input type="submit" class="btn btn-success btn-sm" value="Tambah">
                                </div>
                            </div>

                        </div>
                      </div>
                    <!-- /.row -->
                  </div>
                  
                  </form>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!--/. container-fluid -->
        </section>
        <?php }} else {?>
        <?php foreach($test as $row) {?>
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Form Pembayaran No PPJB <?php echo "1-".substr("000{$row->no_psjb}", -3)?></h1>
                  <h5>Pembayaran Piutang</h5>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi Keuangan</li>
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>

          <section class="content">
          <div class="container-fluid">
            <form action="<?php echo base_url()?>Dashboard/add_pembayaran" method="post">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-footer">
                    <div class="row">
                      <a href="<?php echo base_url()?>Dashboard/view_transaksi?id=<?php echo $row->no_psjb?>&kode=<?php echo $row->kode_perumahan?>"/ class="btn btn-success btn-sm">Kembali</a>
                    </div>
                    <!-- /.row -->
                  </div>
                  <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Konsumen</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_konsumen?>" name="nama_konsumen" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No PPJB</label>
                                    <input type="text" class="form-control" value="<?php echo "1-".substr("000{$row->no_psjb}", -3)?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tahap Pembayaran</label>
                                    <input type="text" class="form-control" name="tahap_bayar" value="<?php echo $row->cara_bayar?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Piutang Yang Harus Diterima (Rp)</label>
                                    <input type="number" class="form-control" value="<?php echo $row->dana_masuk?>" name="total_patok" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Kekurangan Piutang (Rp)</label>
                                    <input type="number" class="form-control" id="danaKekurangan" name="dana_saat" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Akumulasi Piutang Yang Telah Dibayar (Rp)</label>
                                    <input type="number" class="form-control" value="<?php echo $row->dana_bayar?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Piutang yang diterima (Rp)</label>
                                    <!-- <input type="number" name="dana_bayar" id="danaBayar" class="form-control" > -->
                                    <input type="text" name="dana_bayar" id="danaBayar" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" />
                                </div>
                                <div class="form-group">
                                    <label>Sisa Kekurangan (Rp)</label>
                                    <input type="number" name="dana_kurang" class="form-control" id="danaKurang" value="<?php echo $row->dana_sekarang?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Terima</label>
                                    <input type="date" class="form-control" name="tanggal_bayar" value="<?php echo date('Y-m-d')?>">
                                </div>
                                <div class="form-group">
                                    <label>Cara Pembayaran</label>
                                    <select class="form-control" placeholder="" id="caraPembayaran" name="cara_pembayaran" required>
                                        <option disabled selected value="">-Pilih-</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <div id="showBank"></div>
                                    <select class="form-control" id="bank" name="bank">
                                        <option value="" disabled selected>-Pilih-</option>
                                        <?php foreach($this->db->get('bank')->result() as $row2){?>
                                            <option value="<?php echo $row2->id_bank?>"><?php echo $row2->nama_bank?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <input type="hidden" value="<?php echo $id;?>" name="id">
                                    <input type="hidden" value="<?php echo $row->id_psjb?>" name="id_psjb">
                                    <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_ppjb">
                                    <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                                    <input type="hidden" value="0" name="persen_pencairan">
                                    <input type="hidden" value="a" name="tahap_pencairan">

                                    <input type="submit" class="btn btn-success btn-sm" value="Tambah">
                                </div>
                            </div>

                        </div>
                      </div>
                    <!-- /.row -->
                  </div>
                  
                  </form>
                  <!-- ./card-body -->
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!--/. container-fluid -->
        </section>
        <?php }}?>
    <?php }?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
  <?php include "include/footer.php"?>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

<script type="text/javascript">

var danaBayar = document.getElementById('danaBayar');
var danaKurang = document.getElementById('danaKurang');
var danaKekurangan = document.getElementById('danaKekurangan');

var totalPencairan = document.getElementById('totalPencairan');
var persenPencairan = document.getElementById('persenPencairan');

// danaBayar.addEventListener('blur', function() {
//   danaKurang.value = danaKekurangan.value - danaBayar.value;
// });

$(document).ready(function(){
  $("#danaBayar").on("input", function() {
    // danaKurang.value = danaKekurangan.value - danaBayar.value;
    // var temp = 0;
    // var temp = $('#danaKekurangan').val();
    // var temp1 = $('#danaBayar').val();

    var total =  danaKekurangan.value - danaBayar.value;
    // var temp = danaKekurangan.value - danaBayar.value;
    // alert(temp);
    $("#danaKurang").val(total);
  });
});

persenPencairan.addEventListener('blur', function () {
  danaBayar.value = (totalPencairan.value * persenPencairan.value) / 100;
  danaKurang.value = danaKekurangan.value - danaBayar.value;
});
</script>
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
        } else {
            $("#bank").attr('disabled', 'disabled');
            $("#bank").removeAttr('required');
            $("#bank").val("");
            $("#showBank").append('<input type="hidden" name="bank" value="">');
            // $("#bank").html('<option value="" disabled>-Pilih-</option>');
        }
    });
});
</script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url()?>asset/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url()?>asset/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>asset/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/pages/dashboard2.js"></script>
</body>
</html>
