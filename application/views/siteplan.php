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
            <h1>Siteplan</h1>
            <!-- <a href="<?php echo base_url()?>Dashboard/psjb" class="btn btn-sm btn-success">Kembali (PSJB)</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Siteplan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="row">
          <!-- left column -->
            <?php foreach($perumahan as $row){?>
              <div class="col-md-12">
                <!-- <div class="col-md-4"></div>
                <div class="col-md-4"></div> -->
                <div class="card-header" style="background-color: lightyellow">
                  <h1><?php echo $row->nama_perumahan?></h1>
                </div>
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-4"></div>
                  <div class="col-md-3">
                    <table class="table table-bordered" style="font-weight: bold; font-size: 20px">
                      <thead style="background-color: lightblue">
                        <tr>
                          <td>Sold</td>
                          <td>Free</td>
                        <tr>
                      </thead>
                      <tbody>
                        <?php $dipesan=0; $free=0; foreach($this->db->get_where('rumah', array('nama_perumahan'=>$row->nama_perumahan))->result() as $row2){
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
                <div class="col-md-12" style="text-align: center">
                  <img style="width: 680px; height: 900px;" src="<?php echo base_url()?>gambar/<?php echo $row->siteplan?>">
                </div>
              </div>
            </div>
          <?php }?>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
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
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
