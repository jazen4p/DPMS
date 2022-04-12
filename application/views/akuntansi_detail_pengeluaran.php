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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail POS Akuntansi Pengeluaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
              <li class="breadcrumb-item active">Detail POS Akuntansi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php if($sendback->num_rows() > 0){?>
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="col-md-12"> 
                  <table class="table">
                    <thead>
                      <th>No</th>
                      <th>Catatan Revisi</th>
                      <th>Dibuat Oleh</th>
                      <th>Pada</th>
                    </thead>
                    <tbody>
                      <?php $no=0; foreach($sendback->result() as $sb){?>
                        <tr>
                          <td><?php echo $no?></td>
                          <td><?php echo $sb->catatan?></td>
                          <td><?php echo $sb->created_by?></td>
                          <td><?php echo $sb->date_created?></td>
                        </tr>
                      <?php $no++;}?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <div class="row">
                  <a href="<?php echo base_url()?>Dashboard/laporan_pengeluaran_akuntansi" class="btn btn-success btn-sm">Kembali</a>
                </div>
                <!-- /.row -->
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h4 style="font-weight: bold; text-align: center">Debet</h4>  
                    <!-- /.chart-responsive -->
                    <div>       
                      <?php $no=1; foreach($akuntansi_debet->result() as $row){?>              
                      <table>
                        <tr>
                          <td style=""><?php echo $no.".";?></td>
                          <td>Kode Akun</td>
                          <td style="padding-left: 20px">:</td>
                          <td style="padding-left: 20px">
                            <?php foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$row->id_akun))->result() as $akun){
                              echo $akun->no_akun;
                            }?>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Nama Akun</td>
                          <td style="padding-left: 20px">:</td>
                          <td style="padding-left: 20px">
                            <?php foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$row->id_akun))->result() as $akun){
                              echo $akun->nama_akun;
                            }?>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Nominal</td>
                          <td style="padding-left: 20px">:</td>
                          <td style="padding-left: 20px">
                            <?php echo "Rp. ".number_format($row->nominal);?>
                          </td>
                        </tr>
                      </table>
                      <br>
                      <?php $no++;}?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h4 style="font-weight: bold; text-align: center">Kredit</h4>
                    <div>        
                      <?php $no=1; foreach($akuntansi_kredit->result() as $row1){?>             
                      <table>
                        <tr>
                          <td style=""><?php echo $no.".";?></td>
                          <td>Kode Akun</td>
                          <td style="padding-left: 20px">:</td>
                          <td style="padding-left: 20px">
                            <?php foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$row1->id_akun))->result() as $akun){
                              echo $akun->no_akun;
                            }?>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Nama Akun</td>
                          <td style="padding-left: 20px">:</td>
                          <td style="padding-left: 20px">
                            <?php foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$row1->id_akun))->result() as $akun){
                              echo $akun->nama_akun;
                            }?>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Nominal</td>
                          <td style="padding-left: 20px">:</td>
                          <td style="padding-left: 20px">
                            <?php echo "Rp. ".number_format($row1->nominal);?>
                          </td>
                        </tr>
                      </table>
                      <br>
                      <?php $no++;}?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ./card-body -->
              <!-- /.card-footer -->
            </div>
            <?php if(isset($revisi)){?>
                <div class="col-md-8">
                <form method="POST" action="<?php echo base_url()?>Dashboard/akuntansi_revisi_pengeluaran">
                <div class="card">
                    <div class="card-body">
                    <div class="form-group">
                        <label>Keterangan Sendback</label>
                        <textarea class="form-control" name="keterangan"></textarea>
                    </div>
                    </div>
                    <div class="card-footer">
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <input type="submit" class="btn btn-success btn-flat btn-sm" value="Sendback">
                    </div>
                </div>
                </form>
                </div>
            <?php }?>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
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
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>asset/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>asset/dist/js/demo.js"></script>

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
