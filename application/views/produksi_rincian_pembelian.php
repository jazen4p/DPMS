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
              Rincian Pembelian
              <?php if(isset($perumahan)){
                  echo " - ".$perumahan;
              }?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rincian Pembelian</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
            </div>
            <div class="col-sm-2">
              <?php
                // function randomPassword() {
                //     $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                //     $pass = array(); //remember to declare $pass as an array
                //     $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                //     for ($i = 0; $i < 8; $i++) {
                //         $n = rand(0, $alphaLength);
                //         $pass[] = $alphabet[$n];
                //     }
                //     return implode($pass); //turn the array into a string
                // }

                // echo randomPassword();
              ?>
              <button type="button" id="button" class="btn btn-flat btn-outline-info" data-toggle="modal" data-target="#exampleModal">Per Bangunan</button>
            </div>
        </div>
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_rincian_pembelian" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input type="month" class="form-control" value="<?php if(isset($tgl)){echo $tgl;}?>" name="bulan">
                </div>
              </div>
              <div class="col-md-6">
                <!-- <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date"> -->
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
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <!-- /.card-header -->
              <?php if(isset($succ_msg)){?>
                <div class="card-header">
                  <span style="color: green"><?php echo $succ_msg?></span>
                </div>
              <?php }?>
              <?php if(isset($err_msg)){?>
                <div class="card-header">
                  <span style="color: red"><?php echo $err_msg?></span>
                </div>
              <?php }?>
              <?php if(isset($varUtang)){?>
                <div class="card-header">
                  <a class="btn btn-success btn-flat btn-sm" href="<?php echo base_url()?>Dashboard/transaksi_pengeluaran_hutang">Kembali</a>
                </div>
              <?php }?>
              <div class="card-body">
                <div style="text-align: center">
                  <span style="font-weight: bold"><?php echo $nama_perumahan?> Residence</span><br>
                  Rincian Pembelian Bahan <br>
                  Bulan <?php echo date('F Y', strtotime($tgl))?> <br><br>
                </div>
                <form action="<?php echo base_url()?>Dashboard/edit_rincian_pembelian" method="POST">
                <table id="example2" class="table table-bordered table-striped" style="font-size: 13px">
                  <thead>
                    <tr style="background-color: lightyellow; font-weight: bold; white-space: nowrap">
                        <td colspan=9 style="text-align: center">TOTAL PEMBELIAN BAHAN BULAN <?php echo strtoupper(date('F Y', strtotime($tgl)))?> </td>
                        <td colspan=2><div id="total"></div></td>
                    </tr>
                      <tr>
                        <td colspan=9 style="text-align: right">
                          <?php if($this->session->userdata('role') == "superadmin"){?>
                            <!-- <button type="button" id="button" class="btn btn-flat btn-sm btn-outline-info" data-toggle="modal" data-target="#exampleModal3">Daftar Kode Akses</button> -->
                          <?php } 
                            if(isset($edit_prod)){?>
                            <!-- <a type="button" href="<?php echo base_url()?>Dashboard/r_filter_rincian_pembelian?id=<?php echo $id?>&bln=<?php echo $tgl?>" class="btn btn-outline-danger btn-sm btn-flat">Keluar Edit</a> -->
                          <?php } else {?>
                            <!-- <button type="button" id="button" class="btn btn-flat btn-sm btn-outline-info" data-toggle="modal" data-target="#exampleModal2">Edit Akses</button> -->
                          <?php }?>

                          <?php 
                          if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan"){
                            foreach($this->db->get_where('produksi_transaksi', array('status <>'=>"lunas"))->result() as $dt){
                              $dts = date('Y-m-d h:i:sa', strtotime($dt->date_rev));
                            }
                            echo "Last revised: ".$dts;
                          ?>
                            <a href="<?php echo base_url()?>Dashboard/open_akses_edit_pembelian?id=<?php echo $id?>&bln=<?php echo $tgl?>" class="btn btn-flat btn-sm btn-outline-info">Buka Akses Edit</a>
                          <?php }?>
                          <!-- <a href="<?php echo base_url()?>Dashboard/v_edit_rincian_pembelian?id=<?php echo $id?>&bln=<?php echo $tgl?>" class="btn btn-outline-danger btn-sm btn-flat">Akses Edit</a> -->
                        </td>
                        <td>
                          <input type="hidden" value="<?php echo $id?>" name="id">
                          <input type="hidden" value="<?php echo $tgl?>" name="bln">
                          <?php if(isset($edit_prod)){?>
                            <input type="submit" value="Update">
                          <?php } else {?>
                            <input type="submit" value="Update">
                          <?php }?>
                        </td>
                      </tr>
                      <tr>
                          <th>No</th>
                          <th>Nama Bahan</th>
                          <th>Toko Bangunan</th>
                          <th>Nomor Faktur</th>
                          <th>Qty</th>
                          <th>Satuan</th>
                          <th>Harga Satuan</th>
                          <th>Tgl Pesan</th>
                          <th>Jatuh Tempo</th>
                          <th>Total</th>
                          <!-- <th>Status</th> -->
                          <!-- <th>Jmlh Diterima</th> -->
                          <!-- <th>Aksi</th> -->
                      </tr>
                    </thead>
                    <tbody style="white-space: nowrap">
                      <?php $no=1; $total=0; foreach($check_all->result() as $row){ ?>
                        <tr>
                          <td><?php echo $no;?></td>
                          <td style="white-space: nowrap"><?php echo $row->nama_barang?></td>
                          <td style="white-space: nowrap"><?php echo $row->nama_toko?></td>
                          <td><?php echo $row->no_faktur?></td>
                          <td>
                            <?php echo $row->qty?>
                            <?php 
                              if($row->status_rev == "true"){?>
                              <input type="number" style="width: 80px" value="<?php echo $row->qty?>" name="qty[]" id="qty<?php echo $no?>" required>
                            <?php } else {
                              if($row->status == ""){?>
                                <input type="number" style="width: 80px" value="<?php echo $row->qty?>" name="qty[]" id="qty<?php echo $no?>" required>
                              <?php }
                            }?>
                          </td>
                          <td><?php echo $row->nama_satuan?></td>
                          <td>
                            <?php echo "Rp. ".number_format($row->harga_satuan)?>
                            <?php
                              if($row->status_rev == "true"){?>
                              <input type="number" style="width: 100px" value="<?php echo $row->harga_satuan?>" name="harga_satuan[]" required id="hargaSatuan<?php echo $no?>">
                            <?php } else {
                              if($row->status == ""){?>
                                <input type="number" style="width: 100px" value="<?php echo $row->harga_satuan?>" name="harga_satuan[]" required id="hargaSatuan<?php echo $no?>">
                              <?php }
                            }?>
                          </td>
                          <td>
                            <?php echo $row->tgl_pesan?>
                            <?php 
                              if($row->status_rev == "true"){?>
                              <input type="date" value="<?php echo $row->tgl_pesan?>" name="tgl_pesan[]" required>
                            <?php } else {
                              if($row->status == ""){?>
                                <input type="date" value="<?php echo $row->tgl_pesan?>" name="tgl_pesan[]" required>
                              <?php }
                            }?>
                          </td>
                          <td>
                            <?php echo $row->tgl_deadline?>
                            <?php 
                              if($row->status_rev == "true"){?>
                              <input type="date" value="<?php echo $row->tgl_deadline?>" name="tgl_deadline[]" required>
                            <?php } else {
                              if($row->status == ""){?>
                                <input type="date" value="<?php echo $row->tgl_deadline?>" name="tgl_deadline[]" required>
                              <?php }
                            }?>
                          <?php //echo $row->tgl_deadline?>
                          </td>
                          <td style="white-space: nowrap">
                            <?php echo "Rp. ".number_format($row->qty*$row->harga_satuan)?>
                            <?php 
                              if($row->status_rev == "true"){?>
                              <input type="text" style="width: 120px" value="<?php echo "Rp. ".number_format($row->qty*$row->harga_satuan)?>" id="total<?php echo $no?>" readonly>
                            <?php } else {
                              if($row->status == ""){?>
                                <input type="text" style="width: 120px" value="<?php echo "Rp. ".number_format($row->qty*$row->harga_satuan)?>" id="total<?php echo $no?>" readonly>
                              <?php }
                            }?>
                            
                            <?php 
                              if($row->status_rev == "true"){?>
                                <input type="hidden" value="<?php echo $row->id_prod?>" name="id_prod[]">
                            <?php } else {
                              if($row->status == ""){?>
                                <input type="hidden" value="<?php echo $row->id_prod?>" name="id_prod[]">
                              <?php }
                            }?>
                          </td>
                          <!-- <td></td> -->
                          <?php $total = $total + ($row->qty*$row->harga_satuan)?>
                          <!-- <td><?php echo $row->id_prod?></td> -->
                        </tr>
                      <?php $no++;} $ch = $no;?>
                    </tfoot>
                  </form>
                </table>
                
                <input type="hidden" value="<?php echo number_format($total)?>" id="totalAll"> 
                <input type="hidden" value="<?php echo $ch?>" id="check" >
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
        <h5 class="modal-title" id="exampleModalLabel">Per Toko Bangunan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="example2" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Toko Bangunan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $tl_tk = 0; $tl = 0;
                    foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $tk){
                      $tst = $this->Dashboard_model->rincian_pembelian_tk($id, date('Y-m', strtotime($tgl)), $tk->nama_data);
                      // print_r($tst);
                      ?>
                      <?php if($tst->num_rows()>0){?>
                      <tr style="background-color: orange">
                          <td><?php echo $tk->nama_data?></td>
                          <?php 
                          if($tst->num_rows() > 0){
                            foreach($tst->result() as $rc){?>
                              <td style="background-color: orange"><?php echo "Rp. ".number_format($rc->total)?></td>
                          <?php $tl_tk = $tl_tk + $rc->total;}} else {
                            echo "<td>Rp. 0</td>"; 
                          }?>
                      </tr>
                    <?php } else {?>
                      <tr style="">
                        <td><?php echo $tk->nama_data?></td>
                        <?php 
                        if($tst->num_rows() > 0){
                          foreach($tst->result() as $rc){?>
                            <td style="background-color: orange"><?php echo "Rp. ".number_format($rc->total)?></td>
                        <?php $tl_tk = $tl_tk + $rc->total;}} else {
                          echo "<td>Rp. 0</td>"; 
                        }?>
                    </tr>
                    <?php }}?>
                <tr style="background-color: lightyellow; font-weight: bold">
                    <td><?php echo "TOTAL KESELURUHAN"?></td>
                    <td><?php echo "Rp. ".number_format($tl_tk)?></td>
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

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Akses Kode</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <h2>Masukkan Kode Akses</h2>

        <?php if($this->session->flashdata('gagal')){ ?>  
            <span style="color: red;"><?php echo $this->session->flashdata('gagal'); ?></span>
          <?php } ?>

          <?php if($this->session->flashdata('sukses')){ ?>  
            <span style="color: green;"><?php echo $this->session->flashdata('sukses'); ?></span>
          <?php } ?>
          <form action="<?php echo base_url('welcome/validasiproses') ?>" method="post">
            <input type="text" name="kodeotp" class="form-control" placeholder="Masukkan kode OTP" required><br>
            
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="bln" value="<?php echo $tgl?>">

            <button type="submit" class="btn btn-success" name="validasi">Verifikasi</button>
            <p>
              batas waktu <span id="waktu"></span><br>
              Tidak menerima sms kode otp? <a href="<?php echo base_url('index.php/welcome/kirimulang') ?>">kirim ulang</a><br>
              <a href="<?php echo base_url('index.php/welcome') ?>">Kembali Login</a>
            </p>
          </form> -->
        <form action="<?php echo base_url()?>Dashboard/sv_edit_rincian_pembelian" method="POST">
          <div class="form-group">
            <label>Kode Akses</label>
            <input type="password" class="form-control" name="password">
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" value="<?php echo $id?>">
          <input type="hidden" name="bln" value="<?php echo $tgl?>">

          <input type="submit" class="btn btn-success" value="Submit">
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daftar Akses Kode</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/daftar_kode_akses_edit_rincian_pembelian" method="POST">
          <div class="form-group">
            <label>Daftar Kode Akses</label>
            <input type="text" class="form-control" name="otp">
          </div>
          <table class="table table-bordered">
            <div style="text-align: center">Kode Akses Terdaftar</div>
            <thead>
              <tr>
                <th>Kode</th>
                <th>Dibuat Oleh</th>
                <th>Tgl Buat</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($this->db->get('kodeotp')->result() as $otp){?>
                <tr>
                  <td><?php echo $otp->kode;?></td>
                  <td><?php echo $otp->email;?></td>
                  <td><?php echo $otp->tanggal_buat;?></td>
                </tr>
              <?php }?>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" value="<?php echo $id?>">
          <input type="hidden" name="bln" value="<?php echo $tgl?>">

          <input type="submit" class="btn btn-success" value="Submit">
        </form>
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
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true,
      "scrollY": "300px"
    });
    
  });
  
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  $(function () {
    var check = $('#check').val();
    
    // alert(check);

    for (var x = 1; x <= check; x++) {
      (function (x) {
        $('#qty'+x).on("input", function () {
            var qty = $(this).val();
            var hargaSatuan = $('#hargaSatuan'+x).val();

            $('#total'+x).val("Rp. "+numberWithCommas(qty*hargaSatuan));
        });

        $('#hargaSatuan'+x).on("input", function () {
            var qty = $(this).val();
            var hargaSatuan = $('#qty'+x).val();

            $('#total'+x).val("Rp. "+numberWithCommas(qty*hargaSatuan));
        });
      })(x);
    }
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

  $(document).ready(function(){
    var check = $('#totalAll').val();

    $('#total').html("Rp. "+check);
  })

  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });
</script>

<script>
	var minutesToAdd=10;
	var currentDate = new Date();
	var countDownDate = new Date(currentDate.getTime() + minutesToAdd*60000);

	var x = setInterval(function() {

	  var now = new Date().getTime();
	    
	  var distance = countDownDate - now;
	    
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	    
	  document.getElementById("waktu").innerHTML = minutes + ":" + seconds;
	    
	  if (distance < 0) {
	    clearInterval(x);
	    document.getElementById("waktu").innerHTML = "00:00";
	  }
	}, 1000);
	</script>
</body>
</html>
