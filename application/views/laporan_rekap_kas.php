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
              Rekap Piutang Kas/Transfer
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rekap Piutang</li>
            </ol>
          </div>
        </div>
        <!-- <form action="<?php echo base_url()?>Dashboard/filter_laporan_rekap_kas" method="POST">
          <div class="row">
            <label>Perumahan: </label><br>
            <select name="perumahan" class="form-control col-sm-2">
                <option value="">Semua</option>
                <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                <?php }?>
            </select>
            <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
            <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir">
            <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control col-sm-2" onfocus="(this.type='date')" type="text" id="date">
            <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tgl_akhir" class="textbox-n form-control col-sm-2" onfocus="(this.type='date')" type="text" id="date">
            <div>
            <input type="submit" class="btn btn-info btn-flat" value="FILTER" />
            <a href="#" class="btn btn-info btn-flat" style="">CETAK</a>
            </div>
          </div>
        </form> -->
        
        <?php if(isset($kode)){?>
          <span>Pilihan saat ini: <?php if($kode == ""){echo "Semua";} else {echo $kode;}?></span>
        <?php }?>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 14px">
                  <div style="text-align: center">
                  </div>
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Bayar</th>
                        <th>Jadwal Bayar</th>
                        <th>Nama Konsumen</th>
                        <th>Kavling</th>
                        <th>Tahap</th>
                        <th>PPJB</th>
                        <th>Jmlh Tanggungan</th>
                        <th>Jmlh Diterima</th>
                        <th>Sisa</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($check_all->result() as $row){
                      $ts = $this->db->get_where('keuangan_kas_kpr', array('no_ppjb'=>$row->no_psjb));
                      $total = 0;
                      foreach($ts->result() as $rows){
                        $total = $total + $rows->pembayaran;
                      }
                      // echo $total;
                      ?>
                      <?php if($total + $row->uang_awal == $row->harga_jual){?>
                        <tr style="background-color: lightgreen" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $row->no_psjb?>" data-kode="<?php echo $row->kode_perumahan?>">
                      <?php } else {?>
                        <tr data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $row->no_psjb?>" data-kode="<?php echo $row->kode_perumahan?>">
                      <?php }?>
                        <td>
                          <i class="fas fa-plus"></i>
                          <?php echo $no?>
                        </td>
                        <td>v</td>
                        <td>v</td>
                        <td><?php echo $row->nama_pemesan?></td>
                        <td>
                          <?php echo $row->no_kavling?>
                          <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rmh){
                            echo ", ".$rmh->kode_rumah;
                          }?>
                        </td>
                        <td>v</td>
                        <td><?php echo "1-".$row->no_psjb?></td>
                        <td><?php echo "Rp. ".number_format($row->harga_jual)?></td>
                        <td>v</td>
                        <td>v</td>
                      </tr>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Rincian Rencana Pembayaran Konsumen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="fetched-data"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
  
  <?php include "include/footer.php"?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
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
      "scrollX": true
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "scrollX": true
    });
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "300px"
    });
  });

</script>
<script>
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
  });

  $(document).ready(function(){
    $('#exampleModal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).attr('data-id');
        var rowkode = $(e.relatedTarget).attr('data-kode');
        // alert(rowkode);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_rekap_kas",
            data: { id : rowid, kode: rowkode } 
        }).done(function(data){
            $(".fetched-data").html(data);
        });
        // $.ajax({
        //     type: "POST",
        //     url: "<?php echo base_url()?>Dashboard/get_rekap_kas",
        //     data: { id : rowid, kode: rowkode } ,
        //     success : function(data){
        //       $('.fetched-data').html(data);//Show fetched data from database
        //     }
        // })
     });
  });
</script>
</body>
</html>
