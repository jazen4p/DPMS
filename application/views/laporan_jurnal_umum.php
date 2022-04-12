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
              Jurnal Umum
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Jurnal Umum</li>
            </ol>
          </div>
        </div>
        <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_jurnal_umum" method="POST">
            <div class="row">
              <div class="col-md-6">
                <!-- <label>Perumahan</label>
                <select name="perumahan" class="form-control">
                    <option value="">Semua</option>
                    <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                    <?php }?>
                </select>
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua</option>
                    <option value="booking fee">Booking Fee</option>
                    <option value="piutang kas">Piutang Kas</option>
                    <option value="ground tank">Ground Tank</option>
                    <option value="tambahan bangunan">Tambahan Bangunan</option>
                    <option value="penerimaan lain">Penerimaan Lain</option>
                </select>
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="A">Semua</option>
                    <option value="booking fee">Approved</option>
                    <option value="piutang kas">Revisi</option>
                    <option value="">Menunggu</option>
                </select> -->
                <label>Date</label>
                <input placeholder="Tanggal Awal" value="<?php if(isset($start)){echo $start;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
              </div>
              <div class="col-md-6">
                <label>Sampai</label>
                <input placeholder="Tanggal Akhir" value="<?php if(isset($end)){echo $end;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
              </div>
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="hidden" value="<?php echo $id?>" name="id">
                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
              </div>
            </div>
          </form>
        </div>
        
        <?php if(isset($kode)){?>
          <span>Pilihan saat ini: <?php if($kode == ""){echo "Semua";} else {echo $kode;}?></span>
        <?php }
        if(isset($kategori)){
          echo ", ".$kategori; 
        }
        
        $debet = 0; $kredit = 0;?>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div>

            </div>
            <hr/>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table">
                </table>
                <table id="example2" class="table table-bordered table-striped" style="font-size: 12px;">
                  <div style="text-align: center">
                    <h3><?php echo $nama_perumahan?> Residence</h3>
                    <h5>Per. <?php echo date('d F Y', strtotime($end));?></h5>
                  </div>
                  <thead>
                    <tr style="">
                      <th colspan=4></th>
                      <th colspan=2 style="font-size: 12px">SALDO MUTASI DEBET</th>
                      <!-- <th>NAMA AKUN</th> -->
                      <th style="white-space: nowrap"><?php 
                          // echo "Rp. ".number_format($debet);
                        ?><div id="tdebet"></div></th>
                      <th colspan=2 style="font-size: 12px">SALDO MUTASI KREDIT</th>
                      <!-- <th>NAMA AKUN</th> -->
                      <th style="white-space: nowrap"><?php 
                          // echo "Rp. ".number_format($kredit);
                        ?><div id="tkredit"></div></th>
                    </tr>
                    
                    <tr>
                        <th>TANGGAL</th>
                        <th>KETERANGAN</th>
                        <th>NAMA BUDGET</th>
                        <th>JUMLAH</th>
                        <th>NO AKUN</th>
                        <th>NAMA AKUN</th>
                        <th>DEBET</th>
                        <th>NO AKUN</th>
                        <th>NAMA AKUN</th>
                        <th>KREDIT</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Jmlh Diterima</th> -->
                    </tr>
                  </thead>
                  <tbody style="white-space: nowrap">
                    <?php $no=1;
                      $arr = array(); 
                      foreach($check_all->result() as $row){
                        $cek = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$row->id_keuangan, 'jenis_keuangan'=>"penerimaan"));
                        $cek1 = $this->db->get_where('akuntansi_pos', array('id_keuangan'=>$row->id_keuangan, 'jenis_keuangan'=>"pengeluaran"));?>
                        <tr>
                          <td><?php echo $row->date_created?></td>
                          <?php if($row->jenis_keuangan == "penerimaan"){
                            foreach($this->db->get_where('keuangan_akuntansi', array('id_keuangan'=>$row->id_keuangan))->result() as $trm){?>
                              <td><?php echo $trm->keterangan?></td>
                          <?php }?>
                            <td></td>
                            <td></td>
                            <td>
                              <?php foreach($cek->result() as $pos){
                                if($pos->pos_akun == "debet"){
                                  echo $pos->id_akun;
                                  echo "<br>";
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek->result() as $pos){
                                if($pos->pos_akun == "debet"){
                                  foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$pos->id_akun))->result() as $akun){
                                    echo $akun->nama_akun;
                                    echo "<br>";
                                  }
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek->result() as $pos){
                                if($pos->pos_akun == "debet"){
                                  echo "Rp. ".number_format($pos->nominal);
                                  echo "<br>";
                                $debet = $debet + $pos->nominal;
                              }}?>
                            </td>
                            <td>
                              <?php foreach($cek->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                  echo $pos->id_akun;
                                  echo "<br>";
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                  foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$pos->id_akun))->result() as $akun){
                                    echo $akun->nama_akun;
                                    echo "<br>";
                                  }
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                  echo "Rp. ".number_format($pos->nominal);
                                  echo "<br>";
                                $kredit = $kredit + $pos->nominal;
                              }}?>
                            </td>
                          <?php } 
                            else if($row->jenis_keuangan == "pengeluaran"){
                              foreach($this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$row->id_keuangan))->result() as $pgl){?>
                                <td><?php echo $pgl->keterangan?></td>
                          <?php }?>
                            <?php 
                              if($row->jenis_keuangan == "pengeluaran"){
                                foreach($this->db->get_where('keuangan_pengeluaran', array('id_pengeluaran'=>$row->id_keuangan))->result() as $pengeluaran){
                                  $asd1 = $this->db->get_where('keuangan_kontrol_budget', array('kode_pengeluaran'=>$pengeluaran->jenis_pengeluaran, 'kode_perumahan'=>$row->kode_perumahan));
                                  // print_r($asd1->result());
                                  if($asd1->num_rows() > 0){
                                    foreach($asd1->result() as $anak){
                                      echo "<td>".$anak->nama_pengeluaran."</td>";
                                      echo "<td>Rp. ".number_format($row->nominal)."</td>";
                                    }
                                  } else {
                                    echo "<td></td><td></td>";
                                  }
                                }
                              }?>
                            <td>
                              <?php foreach($cek1->result() as $pos){
                                if($pos->pos_akun == "debet"){
                                  echo $pos->id_akun;
                                  echo "<br>";
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek1->result() as $pos){
                                if($pos->pos_akun == "debet"){
                                  foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$pos->id_akun))->result() as $akun){
                                    echo $akun->nama_akun;
                                    echo "<br>";
                                  }
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek1->result() as $pos){
                                if($pos->pos_akun == "debet"){
                                  echo "Rp. ".number_format($pos->nominal);
                                  echo "<br>";
                                $debet = $debet + $pos->nominal;
                              }}?>
                            </td>
                            <td>
                              <?php foreach($cek1->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                  echo $pos->id_akun;
                                  echo "<br>";
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek1->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                  foreach($this->db->get_where('akuntansi_anak_akun', array('no_akun'=>$pos->id_akun))->result() as $akun){
                                    echo $akun->nama_akun;
                                    echo "<br>";
                                  }
                                }}?>
                            </td>
                            <td>
                              <?php foreach($cek1->result() as $pos){
                                if($pos->pos_akun == "kredit"){
                                  echo "Rp. ".number_format($pos->nominal);
                                  echo "<br>";
                                $kredit = $kredit + $pos->nominal;
                              }}?>
                            </td>
                          <?php }?>
                        </tr>
                    <?php $no++;}?>
                  </tfoot>
                </table>
                <input type="hidden" value="<?php echo number_format($debet)?>" id="Debet">
                <input type="hidden" value="<?php echo number_format($kredit)?>" id="Kredit">
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
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": false,
      "scrollX": true
    });
    
  });

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
    var check = $('#Debet').val();
    // var i;
    $('#tdebet').html("Rp. "+check);
    // $('#volume1').val(check);
    var check2 = $('#Kredit').val();
    // var i;
    $('#tkredit').html("Rp. "+check2);
    // $('#volume1').val(check);
  })
</script>
</body>
</html>
