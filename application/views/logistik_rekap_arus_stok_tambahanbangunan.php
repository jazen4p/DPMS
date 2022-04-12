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
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>asset/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
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
              Stok Bahan - Tambahan Bangunan
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Stok Bahan</li>
            </ol>
          </div>
        </div>
        <!-- <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button> -->
        <div id="wrapper">
          <form action="<?php echo base_url()?>Dashboard/filter_stok" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Bulan</label>
                  <input type="month" class="form-control" name="bulan" value="<?php if(isset($tgl)){echo $tgl;}?>"> 
                </div>
              </div>
              <div class="col-md-6">

              </div>
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="hidden" value="<?php echo $kode_perumahan?>" name="id">
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

            <!-- <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form action="<?php echo base_url()?>Dashboard/add_neraca_saldo" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-2">Perumahan</label>
                            <select name="kode_perumahan" class="form-control col-sm-10" required>
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($this->db->get('perumahan')->result() as $perumahan){?>
                                    <option value="<?php echo $perumahan->kode_perumahan?>"><?php echo $perumahan->nama_perumahan?></option>
                                <?php }?>
                            </select>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <?php if(isset($succ_msg)){
                    echo "<span style='color: green'>".$succ_msg."</span>";
                } if(isset($err_msg)){
                    echo "<span style='color: red'>".$err_msg."</span>";   
                }?>
                <input type="submit" class="btn btn-success btn-sm" value="Tambah">
              </div>
            </div> -->
            <div class="card">
                <div class="card-header row">
                    <!-- <a href="<?php echo base_url()?>Dashboard/kode_pengeluaran" class="btn btn-outline-success btn-sm btn-flat">Kembali</a> -->
                    <div class="col-md-9">
                      <a href="<?php echo base_url()?>Dashboard/rekap_pemakaian_perunit?id=<?php echo $id?>&kode=<?php echo $kode_perumahan?>" class="btn btn-outline-info btn-flat">Kembali</a>
                      <a href="<?php echo base_url()?>Dashboard/rekap_pemakaian_bahan?id=<?php echo $kode_perumahan?>" class="btn btn-outline-info btn-flat">Kembali ke awal</a>
                    </div>
                    <div class="col-md-3" style="text-align: right">
                      <!-- <button type="button"  class="btn btn-outline-primary btn-flat" data-toggle="modal" data-target="#exampleModal">Masuk</button>
                      <button type="button"  class="btn btn-outline-primary btn-flat" data-toggle="modal" data-target="#exampleModal1">Keluar</button> -->
                      
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12">
                    </div>
                    <div class="col-12">
                        <div style="text-align: center; font-size: 12px">
                            <h6><b>REKAP PEMAKAIAN BAHAN PER UNIT (TAMBAHAN BANGUNAN)</b></h6>
                            <h6>PROYEK <?php echo strtoupper($nama_perumahan)?></h6>
                        </div>
                        <div>
                          <form action="<?php echo base_url()?>Dashboard/update_pengerjaan_tambahan_bangunan" method="POST">
                            <table>
                                <tr>
                                    <td>Unit Kavling</td>
                                    <td style="padding-left: 50px">: 
                                        <?php echo $no_unit?>
                                    </td>
                                </tr>
                                    <tr>
                                        <td>Mulai Pengerjaan</td><td style="padding-left: 50px">: <input type="date" name="awal" value="<?php echo date('Y-m-d', strtotime($awal_kerja))?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Proyek Selesai</td><td style="padding-left: 50px">: <input type="date" name="akhir" value="<?php echo date('Y-m-d', strtotime($selesai_kerja))?>"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" value="<?php echo $ids?>" name="id">
                                            <input type="hidden" value="<?php echo $kode_perumahan?>" name="kode">
                                            <!-- <input type="hidden" value="<?php echo $kategori?>" name="kategori"> -->
                                            <input type="submit" class="btn btn-flat btn-sm btn-success" value="Update">
                                        </td>
                                    </tr>   
                            </table>
                            </form>
                        </div>
                        <?php 
                            $this->db->group_by('DATE(tgl_arus), MONTH(tgl_arus), YEAR(tgl_arus)');
                            // $this->db->group_by('')
                            $ts = $this->db->get_where('logistik_arus_stok', array('jenis_arus'=>"keluar", 'kategori'=>"tambahanbangunan", 'no_unit'=>$no_unit, 'id_kontrak_tb'=>$ids));
                            // print_r($ts->result());
                        ?>
                        <form method="POST" action="<?php echo base_url()?>Dashboard/update_pengerjaan2">
                        <table id="example2" class="table table-striped table-bordered" style="font-size: 13px">
                            <thead>
                                <tr style="">
                                    <th rowspan=2>No</th>
                                    <th rowspan=2>Nama Barang</th>
                                    <th colspan=<?php echo $ts->num_rows()?>>TANGGAL PEMAKAIAN BAHAN</th>
                                    <th rowspan=2>TOTAL QTY</th>
                                    <!-- <th rowspan=2>TOTAL HARGA</th> -->
                                    <th rowspan=2>Harga Satuan 
                                    <!-- <input type="submit" value="Update Harga" class="btn btn-outline-info btn-flat btn-sm"> -->
                                    </th>
                                    <th>Total Harga</th>
                                </tr>
                                <tr>
                                    <?php 
                                    if($ts->num_rows() > 0){
                                        foreach($ts->result() as $tst){?>
                                            <th><?php echo date('d/m-y', strtotime($tst->tgl_arus));?></th>
                                    <?php }} else {?>
                                        <th></th>
                                    <?php }?>
                                    <!-- <th>TES</th> -->
                                    <th><span id="ttlBahan"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; $ttl2 = 0; 
                                $this->db->order_by('nama_data', "ASC");
                                foreach($this->db->get_where('produksi_master_data', array('kategori'=>"barang"))->result() as $row){?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row->nama_data?></td>
                                        <?php 
                                        $total = 0;
                                        if($ts->num_rows() > 0){
                                        // echo "<td>$total</td>";
                                        // print_r($ts->result());
                                        foreach($ts->result() as $tsr){
                                            // $this->db->where("DATE_FORMAT(tanggal_dana,'%Y-%m')", $bulan);
                                            // $this->db->where("DATE_FORMAT(tgl_arus, '%Y-%m-%d')", date('Y-m-d', strtotime($tsr->tgl_arus)));
                                            // $tss = $this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data, 'jenis_arus'=>"keluar", 'no_unit'=>$no_unit, 'kode_perumahan'=>$kode_perumahan));
                                            $tss = $this->Dashboard_model->get_rekap_pemakaian($row->nama_data, "keluar", $no_unit, $kode_perumahan, $tsr->tgl_arus);
                                            // print_r($tss->result());
                                            $ttl = 0;
                                            foreach($tss->result() as $tsd){
                                                $ttl = $ttl + $tsd->qty;
                                            }
                                            
                                            if($ttl > 0){?>
                                              <td style="background-color: yellow"><?php echo $ttl;?></td>
                                            <?php } else {
                                                echo "<td></td>";   
                                            }?>
                                        <?php $total = $total + $ttl;}} else {
                                            echo "<td></td>";   
                                        }?>
                                        <?php if($total > 0){?>
                                            <td style="background-color: yellow"><?php echo $total;?></td>
                                        <?php } else {
                                            echo "<td></td>";   
                                        }?>

                                      <td>
                                      <?php 
                                        $this->db->select_max('harga_satuan');
                                        $query = $this->db->get_where('logistik_arus_stok', array('nama_barang'=>$row->nama_data));

                                        foreach($query->result() as $mas){
                                          echo "Rp. ".number_format($mas->harga_satuan);
                                        }
                                      ?>
                                      <!-- // foreach($this->db->get_where('produksi_master_data', array('nama_data'=>$row->nama_data))->result() as $mas){ -->
                                        <!-- <input type="hidden" value="<?php echo $id?>" name="id">
                                        <input type="hidden" value="<?php echo $kode?>" name="kode">
                                        <input type="hidden" value="<?php echo $kategori?>" name="kategori">
                                        <input type="number" value="<?php echo $row->harga_satuan?>" class="form-control" name="harga_satuan[]">
                                        <input type="hidden" value="<?php echo $row->id_data?>" name="id_data[]">  -->
                                      </td>
                                      <td>
                                        <?php echo "Rp. ".number_format($total * $mas->harga_satuan);
                                        $ttl2 = $ttl2 + ($total * $mas->harga_satuan);?>
                                      </td>
                                      <?php 
                                      // }?>
                                      <?php 
                                        $chs=0;
                                        $chq = $this->db->get_where('produksi_transaksi', array('nama_barang'=>$row->nama_data, 'kode_perumahan'=>$kode_perumahan), 1);
                                        if($chq->num_rows() > 0){
                                          foreach($chq->result() as $ch){
                                          // $chs = $ch->harga_satuan;?>
                                          <!-- <td><?php echo "Rp. ".number_format($chs);?></td> -->
                                          <!-- <td><?php echo "Rp. ".number_format($total * $chs);?></td> -->
                                      <?php }} else {
                                        // echo "<td></td>"; 
                                      }?>
                                    </tr>
                                <?php $no++;}?>
                            </tbody>
                        </table> 
                        <?php if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan" || $this->session->userdata('role')=="manager produksi"){?>
                            <hr>
                            <h5 style="font-weight: bold; text-align: center">Kontrol Budget</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="background-color: lightblue">
                                    <?php foreach($this->db->get_where('kbk_kontrak_kerja', array('no_unit'=>$no_unit, 'kode_perumahan'=>$kode_perumahan))->result() as $rmh){?>
                                        <td>Harga Jual</td>
                                        <td style="text-align: right"><?php echo "Rp. ".number_format($rmh->harga_jual)?></td>
                                    <?php }?>
                                    </tr>
                                    <tr style="background-color: lightblue">
                                    <?php foreach($this->db->get_where('kbk_kontrak_kerja', array('no_unit'=>$no_unit, 'kode_perumahan'=>$kode_perumahan))->result() as $rmh){?>
                                        <td>Nilai Kontrak</td>
                                        <td style="text-align: right"><?php echo "Rp. ".number_format($rmh->nilai_kontrak)?></td>
                                    <?php }?>
                                    </tr>
                                    <tr style="background-color: lightgreen">
                                    <td>Biaya Bahan Yang Digunakan</td>
                                    <td style="text-align: right"><?php echo "Rp. ".number_format($ttl2)?></td>
                                    </tr>
                                    <tr style="background-color: pink">
                                    <td>Sisa Budget</td>
                                    <td style="text-align: right"><?php echo "Rp. ".number_format($rmh->nilai_kontrak - $ttl2)?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php }?>   
                        <input type="hidden" value="<?php echo "Rp. ".number_format($ttl2)?>" id="ttlTemp">
                        </form>
                    </div>
                </div>
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
<!-- ./wrapper -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">List Tambahan Bangunan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No.</th>
              <th>No Unit</th>
              <th>Kontrak Kerja</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $nos=1; $ttl=0; foreach($this->db->get_where('kbk_kontrak_kerja', array('kategori'=>"tambahanbangunan", 'no_unit'=>$no_unit, 'kode_perumahan'=>$kode_perumahan, 'status'=>"approved"))->result() as $ters){?>
              <tr>
                <td><?php echo $nos;?></td>
                <td><?php echo $no_unit?></td>
                <td><?php echo $ters->pekerjaan_ket?></td>
                <td>
                  <a href="<?php echo base_url()?>Dashboard/rekap_pemakaian_tambahanbangunan?id=<?php echo $ters->id_kontrak?>&ids=<?php echo $id?>&kode=<?php echo $kode_perumahan?>" class="btn btn-outline-primary btn-flat btn-sm">Cek Pemakaian</a>
                </td>
              </tr>
            <?php $nos++;}?>
            <!-- <tr>
              <td colspan=2>TOTAL</td>
              <td><?php echo "Rp. ".number_format($ttl);?></td>
            </tr> -->
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

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
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js"></script>
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
      "scrollX": true,
      'scrollY': "300px"
    });
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollCollapse": true,
      "scrollX": true,
      "scrollY": "350px",
    //   fixedColumns:   {
    //     leftColumns: 8,
    //   },
      fixedHeader: true
    });
  });

  // $(document).ready(function() {
  //   var table = $('#example2').DataTable( {
  //       ordering: true,
  //       // info: true,
  //       // scrollY:        "300px",
  //       scrollX:        true,
  //       // scrollCollapse: true,
  //       paging:         false,
  //       fixedColumns:   {
  //         leftColumns: 2,
  //       }
  //   } );
  // } );
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

    $('#ttlBahan').html($('#ttlTemp').val());
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
</body>
</html>
