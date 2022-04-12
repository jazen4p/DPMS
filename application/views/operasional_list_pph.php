<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <title>AdminLTE 3 | General Form Elements</title> -->
  <?php include "include/title.php";?>
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
  </style>
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
            <h1>Data PPh</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">PPh</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <!-- /.content -->
    
    <section class="content">
      <div class="container-fluid">
        <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
        <div id="wrapper">
            <form action="<?php echo base_url()?>Dashboard/filter_list_pph" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Perumahan</label>
                            <!-- <input type="month" class="form-control" name="bulan" value="<?php if(isset($tgl)){echo $tgl;}?>">  -->
                            <select name="perumahan" class="form-control">
                                <option value="">All</option>
                                <?php 
                                if(isset($kode)){
                                    foreach($this->db->get('perumahan')->result() as $pr){
                                        echo "<option ";
                                        if($kode == $pr->kode_perumahan){
                                            echo "selected";
                                        }
                                        echo " value='$pr->kode_perumahan'>$pr->nama_perumahan</option>";
                                    }
                                } else {
                                    foreach($this->db->get('perumahan')->result() as $pr){
                                        echo "<option value='$pr->kode_perumahan'>$pr->nama_perumahan</option>";
                                    }   
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                    <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
                    <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
                    <div class="col-md-12">
                        <!-- <input type="hidden" value="<?php echo $kode_perumahan?>" name="id"> -->
                        <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                        <!-- <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button> -->
                    </div>
                </div>
            </form>
            <!-- </div> -->
        </div> <hr>
        <div class="row">
          <div class="col-12">
            <!-- <hr/> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">PPh Management</h3>
                <?php if(isset($succ_msg)){?>
                    <br><span style="color: green"><?php echo $succ_msg?></span>
                <?php }?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 14px">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Perumahan</th>
                      <th>Nama Pemesan</th>
                      <th>Unit</th>
                      <th>Harga Unit</th>
                      <th>Nilai Validasi</th>
                      <th>PPh</th>
                      <th>Tanggal Bayar</th>
                      <!-- <th>Tipe Perumahan</th> -->
                      <!-- <th>Dibuat oleh</th> -->
                      <!-- <th>Pada</th> -->
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($check_all->result() as $row){?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td>
                        <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                            echo $prmh->nama_perumahan;
                        } ?>
                      </td>
                      <td><?php echo $row->nama_pemesan?></td>
                      <td><?php echo $row->no_kavling?></td>
                      <td>
                        <?php foreach($this->db->get_where('rumah', array('kode_rumah'=>$row->no_kavling, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rmh){
                            echo "Rp. ".number_format($rmh->harga_jual);
                        }
                        ?>
                      </td>
                      <!-- <td><?php echo $row->tipe_perusahaan?></td> -->
                      <td><?php echo "Rp. ".number_format($row->nilai_validasi);?></td>
                      <td><?php echo "Rp. ".number_format($row->pph);?></td>
                      <td><?php echo $row->tgl_bayar_pajak?></td>
                      <!-- <td><?php echo $row->created_by?></td> -->
                      <!-- <td><?php echo $row->date_by?></td> -->
                      <td>
                        <!-- <a href="<?php echo base_url()?>Dashboard/edit_view_perumahan?id=<?php echo $row->id_perumahan?>" class="btn btn-default btn-sm">Edit</a> -->
                        <!-- <a href="<?php echo base_url()?>Dashboard/hapus_perumahan?id=<?php echo $row->id_perumahan?>" class="btn btn-default btn-sm">Hapus</a> -->
                        <?php 
                        $gt = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>"PPH-$row->kode_perumahan$row->no_psjb"));
                        // print_r($gt->num_rows());
                        if($gt->num_rows() > 0){
                            echo "<span style='color: red'>Terdaftar</span>";
                        } else {
                            if($row->tgl_bayar_pajak == "0000-00-00" || $row->pph == "0"){
                                echo "Data belum lengkap";
                            } else {?>
                                <a href="<?php echo base_url()?>Dashboard/view_add_pengeluaran_pph?id=<?php echo $row->id_psjb?>" class="btn btn-outline-primary btn-sm btn-flat">Form</a>
                        <?php }}?>
                      </td>
                    </tr>
                    <?php $unit = 2; foreach($this->db->get_where('rumah', array('pph <>'=>"0", 'no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rmhs){?>
                        <tr>
                            <td><?php $no++; echo $no;?></td>
                            <td>
                                <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                                    echo $prmh->nama_perumahan;
                                } ?>
                            </td>
                            <td><?php echo $row->nama_pemesan?></td>
                            <td><?php echo $rmhs->kode_rumah?></td>
                            <td>
                                <?php echo "Rp. ".number_format($rmhs->harga_jual);
                                ?>
                            </td>
                            <!-- <td><?php echo $row->tipe_perusahaan?></td> -->
                            <td><?php echo "Rp. ".number_format($rmhs->nilai_validasi);?></td>
                            <td><?php echo "Rp. ".number_format($rmhs->pph);?></td>
                            <td><?php echo $rmhs->tgl_bayar_pajak?></td>
                            <!-- <td><?php echo $row->created_by?></td> -->
                            <!-- <td><?php echo $row->date_by?></td> -->
                            <td>
                                <!-- <a href="<?php echo base_url()?>Dashboard/edit_view_perumahan?id=<?php echo $row->id_perumahan?>" class="btn btn-default btn-sm">Edit</a> -->
                                <!-- <a href="<?php echo base_url()?>Dashboard/hapus_perumahan?id=<?php echo $row->id_perumahan?>" class="btn btn-default btn-sm">Hapus</a> -->
                                <?php 
                                $gt = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>"PPH-$row->kode_perumahan$row->no_psjb-$unit"));
                                // print_r($gt->result());
                                if($gt->num_rows() > 0){
                                    echo "<span style='color: red'>Terdaftar</span>";
                                } else {
                                    if($row->tgl_bayar_pajak == "0000-00-00" || $row->pph == "0"){
                                        echo "Data belum lengkap";
                                    } else {?>
                                        <a href="<?php echo base_url()?>Dashboard/view_add_pengeluaran_pph_unit2?id=<?php echo $rmhs->id_rumah?>&ids=<?php echo $unit?>" class="btn btn-outline-primary btn-sm btn-flat">Form</a>
                                <?php }}?>
                            </td>
                        </tr>
                    <?php $unit++;}?>
                    <?php $no++;}?>
                  </tfoot>
                </table>
              </div>
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

<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
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
        "scrollX": true
        });
        $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "scrollX": true
        });
    });

    $(function() {
        var b = $("#button");
        var w = $("#wrapper");
        var l = $("#list");
        b.click(function() {
            w.toggleClass('open'); /* <-- toggle the application of the open class on click */
        });
    });
</script>
</body>
</html>
