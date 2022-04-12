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
              Kontrol Budget
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Kontrol Budget</li>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div>

            </div>
            <hr/>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                  <a href="<?php echo base_url()?>Dashboard/kontrol_budget" class="btn btn-outline-success btn-sm btn-flat">Kembali</a>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <?php ?>
                        <h3>Pencatatan <?php echo date('d F Y', strtotime("27-08-2020"));?></h3>
                    <?php ?>
                    <table class="table table-bordered table-striped" style="font-size: 12px">
                        <thead>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Sub Jumlah</th>
                            <th>Jumlah</th>
                            <th>Pemakaian</th>
                            <th>Sisa Budget</th>
                        </thead>
                        <tbody>
                            <?php 
                                // $total = 0; foreach($check_all->result() as $totals){
                                //     foreach($this->db->get_where('keuangan_kontrol_budget', array('kode_perumahan'=>$kode_perumahan, 'kode_induk'=>$totals->kode_induk))->result() as $totals1){
                                //         echo $total = $total + $totals1->sub_jumlah;
                                //     }
                                // }
                            ?>

                            <?php $no=1; foreach($check_all->result() as $row){?>
                                <tr style="white-space: nowrap; background-color: yellow">
                                    <td><?php echo $row->kode_induk?></td>
                                    <td><?php echo $row->nama_induk?></td>
                                    <td colspan=4></td>
                                    <td><input type="text" style="border: 0px" id="jumlah<?php echo $no;?>" readonly></td>
                                    <td></td>
                                    <td><input type="text" style="border: 0px" id="jumlahs<?php echo $no;?>" readonly>
                                    </td>
                                </tr>
                                <?php $total = 0; foreach($this->db->get_where('keuangan_kontrol_budget', array('kode_perumahan'=>$kode_perumahan, 'kode_induk'=>$row->kode_induk))->result() as $row1){?>
                                    <tr style="white-space: nowrap">
                                        <td><?php echo $row1->kode_pengeluaran?></td>
                                        <td><?php echo $row1->nama_pengeluaran?></td>
                                        <td><?php echo number_format($row1->volume, 1)?></td>
                                        <td><?php echo $row1->satuan?></td>
                                        <td><?php echo "Rp. ".number_format($row1->harga_satuan)?></td>
                                        <td><?php echo "Rp. ".number_format($row1->sub_jumlah)?></td>
                                        <td></td>
                                        <td>
                                            <?php $pemakaian=0; 
                                            foreach($this->db->get_where('keuangan_pengeluaran', array('jenis_pengeluaran'=>$row1->kode_pengeluaran, 'kode_perumahan'=>$kode_perumahan))->result() as $pakai){
                                                $pemakaian = $pemakaian+$pakai->nominal;
                                            }
                                            echo "Rp. ".number_format($pemakaian); ?>
                                        </td>
                                        <td><?php echo "Rp. ".number_format($row1->sub_jumlah-$pemakaian)?></td>
                                    </tr>
                            <?php $total= $total+$row1->sub_jumlah-$pemakaian;} ?> 
                                <input type="hidden" value="<?php echo $total?>" id="totalJumlah<?php echo $no;?>">
                                
                            <?php $no++;}?>
                            <input type="hidden" value="<?php echo $no?>" id="check">
                        </tbody>
                    </table>
                  </div>
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
<script>
  $(function () {
    $("#date").datepicker();
    $("#checkout").datepicker();
  });

//   $(document).ready(function(){
//     $('#jumlah').html($('#totalJumlah').val());
//   })

  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });

  // $(document).ready(function(){ 
  //   var check = $('#check').val();
  //   var i;
  //   // alert(check);
  //   // $('#volume1').val(check);

  //   for(i = 1; i < check; i++){
  //       $('#volume'+i).on("input", function(){
  //       var volume = $(this).val();
  //       var hargaSatuan = $('#hargaSatuan'+i).val();

  //       var total = volume * hargaSatuan;

  //       $('#subJumlah'+i).val(total);
  //       })

  //       $('#hargaSatuan'+i).on("input", function(){
  //       var volume = $('#volume'+i).val();
  //       var hargaSatuan = $(this).val();

  //       var total = volume * hargaSatuan;

  //       $('#subJumlah'+i).val(total);
  //       })
  //   }
  // })
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

  $(function () {
    var check = $('#check').val();

    for (var i = 1; i < check; i++) {
        (function (i) {
            $(document).ready(function(){
                $('#jumlah'+i).val("Rp. "+numberWithCommas($('#totalJumlah'+i).val()));
            })
        })(i);
    }
  });

  $(function () {
    var check = $('#check').val();

    for (var i = 1; i < check; i++) {
        (function (i) {
            $(document).ready(function(){
                $('#jumlahs'+i).val("Rp. "+numberWithCommas($('#totalJumlah'+i).val()));
            })
        })(i);
    }
  });
</script>
</body>
</html>
