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
  <?php foreach($ppjb_detail as $row) {?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Perjanjian Pendahuluan Jual Beli</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
              <li class="breadcrumb-item active">Detail PSJB</li>
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
          <div class="col-md-12">
            <div class="card">
              <!-- ./card-body -->
              <div class="card-header">
                <div class="row">
                  <a href="<?php echo base_url()?>Dashboard/ppjb_management" class="btn btn-success btn-sm">Kembali</a>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <?php $no=1; if(isset($ppjb_sendback)){?>
                    
                    <div class="col-md-12">  
                      <h4>Catatan Revisi</h4>
                      <table class="table">
                        <thead style="background-color: lightgreen">
                          <td>No</td>
                          <td>Catatan Revisi</td>
                          <td>Oleh</td>
                          <td>Pada</td>
                        </thead>
                        <?php foreach($ppjb_sendback->result() as $row2){?>
                        <tbody>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row2->catatan?></td>
                          <td><?php echo $row2->sendback_by?></td>
                          <td><?php echo $row2->sendback_date?></td>
                        </tbody>
                        <?php $no++;}}?>
                      </table>
                    </div>
                  <div class="col-md-12">
                    <form action="<?php echo base_url()?>Dashboard/ppjb_revisi_data" method="POST">
                    <div class="row">
                      <div class="col-sm-6">
                        <h4 style="font-weight: bold">Informasi Pemesanan</h4>  
                      </div>
                      <div class="col-sm-6" style="text-align: right">
                        <?php if($this->session->userdata('role')=="superadmin"){?>
                          <span style="font-weight: bold">Pengubahan Data Pribadi</span>
                        <?php }?>
                      </div>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr><td>Nomor PSJB</td><td>1-<?php echo $row->no_psjb?>/PSJB/KBR/<?php echo $row->kode_perusahaan."/".$row->kode_perumahan."/".date("m", strtotime($row->tgl_psjb))."/".date("Y", strtotime($row->tgl_psjb))?></td></tr>
                            <tr><td>Tanggal</td><td><?php echo $row->tgl_psjb?></td></tr>
                            <tr>
                              <td>Nama Pemesan</td>
                              <td>
                                <?php echo $row->nama_pemesan?>
                              </td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="text" class="form-control" name="nama_pemesan" value="<?php echo $row->nama_pemesan?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>Nama dalam Sertifikat / PPJB</td>
                              <td><?php echo $row->nama_sertif?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="text" class="form-control" name="nama_sertif" value="<?php echo $row->nama_sertif?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>KTP Pemesan</td>
                              <td><?php echo $row->ktp?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="text" class="form-control" name="ktp" value="<?php echo $row->ktp?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>Alamat KTP</td>
                              <td><?php echo $row->alamat_lengkap?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <textarea name="alamat_lengkap" class="form-control"><?php echo $row->alamat_lengkap?></textarea>
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>Alamat Surat</td>
                              <td><?php echo $row->alamat_surat?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <textarea name="alamat_surat" class="form-control"><?php echo $row->alamat_surat?></textarea>
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>No Telp Rumah</td>
                              <td><?php echo $row->telp_rumah?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="text" class="form-control" name="telp_rumah" value="<?php echo $row->telp_rumah?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>No Handphone</td>
                              <td><?php echo $row->telp_hp?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="text" class="form-control" name="telp_hp" value="<?php echo $row->telp_hp?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>Pekerjaan</td>
                              <td><?php echo $row->pekerjaan?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="text" class="form-control" name="pekerjaan" value="<?php echo $row->pekerjaan?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>NPWP</td>
                              <td><?php echo $row->npwp?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="text" class="form-control" name="npwp" value="<?php echo $row->npwp?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>E-mail</td>
                              <td><?php echo $row->email?></td>
                              <?php if($this->session->userdata('role') == "superadmin"){?>
                                <td>
                                  <input type="email" class="form-control" name="email" value="<?php echo $row->email?>">
                                </td>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>Nama Kavling</td>
                              <td>
                                <?php echo $row->no_kavling?>
                                <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rumah){?>
                                  , <?php echo $rumah->kode_rumah?>
                                <?php }?>
                              </td>
                              <?php if($this->session->userdata('role')=="superadmin"){?>
                                <td style="text-align: center">
                                  <button type="button" class="btn btn-outline-primary btn-flat btn-sm" data-toggle="modal" data-target="#exampleModal">Ubah Blok</button>
                                </td>
                              <?php }?>
                            </tr>
                            <tr><td>Luas Tanah m2</td><td><?php echo $row->luas_tanah?></td></tr>
                            <tr><td>Luas Bangunan m2</td><td><?php echo $row->luas_bangunan?></td></tr>
                            <tr><td>Tipe Standart</td><td><?php echo $row->tipe_rumah?></td></tr>
                            <tr><td>Harga Jual</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                            <tr><td>Hadap Timur</td><td>Rp. <?php echo number_format($row->hadap_timur)?>,-</td></tr>
                            <tr><td>Diskon Jual</td><td>Rp. <?php echo number_format($row->disc_jual)?>,-</td></tr>
                            <tr><td>Total Jual</td><td>Rp. <?php echo number_format($row->total_jual)?>,-</td></tr>
                            <tr><td>Uang Terbayar</td><td>Rp. <?php echo number_format($row->uang_awal)?>,-</td></tr>
                            <tr><td>Biaya Kekurangan</td><td>Rp. <?php echo number_format($row->total_jual-$row->uang_awal)?>,-</td></tr>
                            <tr><td>Sistem Pembayaran</td><td><?php echo $row->sistem_pembayaran?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- /.chart-responsive -->
                  </div>
                  <div class="col-md-12">
                      <h4 style="font-weight: bold;">Catatan</h4>
                      <?php if($row->catatan == ""){?>
                        -
                      <?php } else{?>
                        <span><?php echo $row->catatan?></span>
                      <?php }?>

                      <?php if($this->session->userdata('role')=="superadmin"){?>
                        <textarea class="form-control" name="catatan"><?php echo $row->catatan?></textarea>
                        <span>Last Revised: <?php echo date('Y-m-d H:i:sa', strtotime($row->superadmin_date_rev));?></span>
                      <?php }?>
                      <?php if($this->session->userdata('role')=="superadmin"){?>
                        <div style="text-align: right">
                          <input type="hidden" value="<?php echo $row->id_psjb?>" name="id_psjb">
                          <input type="hidden" value="<?php echo $row->no_psjb?>" name="no_psjb">
                          <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                          
                          <input type="submit" value="Edit" class="btn btn-success btn-flat">
                        </div>
                      <?php }?>
                    </form>
                  </div>
                  <br><br><br><br>
                  <form action="<?php echo base_url()?>Dashboard/edit_ppjb_dp" method="POST">
                    <div class="col-md-12">
                        <!-- <tr><td>Bunga</td><td>:</td><td><?php echo $row->persen_bunga."%"?></td></tr> -->
                        <?php if($row->sistem_pembayaran=="Tempo"){?>
                          <div>Persentase Bunga Tempo : <?php echo $row->persen_bunga?> %</div>
                        <?php }?>
                        <h4 style="font-weight: bold;">Pembayaran</h4>
                        <table class="table">
                          <thead style="color: blue">
                              <td>Tahap Pembayaran</td>
                              <td>Tanggal Pembayaran</td>
                              <td>Jumlah Pembayaran</td>
                              <td>Pembayaran Konsumen</td>
                          </thead>
                          <tbody>
                                <?php if($row->status == "tutup"){?>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      <input type="hidden" value="<?php echo $id?>" name="id">
                                      <input type="hidden" value="<?php echo $kode?>" name="kode">
                                      <input type="submit" value="Edit">
                                    </td>
                                  </tr>
                                <?php ?>
                                    <?php $total_terkini=0; foreach($psjb_detail_dp as $row2){?>
                                    <?php 
                                        $total_terkini = $total_terkini+$row2->dana_masuk;
                                    ?>
                                    <tr>
                                        <td>
                                          <?php echo $row2->cara_bayar?>
                                          <input type="hidden" name="cara_bayar[]" value="<?php echo $row2->cara_bayar?>">
                                        </td>
                                        <td>
                                          <?php echo $row2->tanggal_dana?>
                                          <?php if($row2->cara_bayar != "Uang Tanda Jadi"){?>
                                            <input type="date" name="tanggal_dana[]" class="form-control" value="<?php echo $row2->tanggal_dana?>">
                                          <?php } else if($row2->cara_bayar == "Uang Tanda Jadi") {?>
                                            <input type="hidden" name="tanggal_dana[]" class="form-control" value="<?php echo $row2->tanggal_dana?>">
                                          <?php }?>
                                        </td>
                                        <td>
                                          Rp. <?php echo number_format($row2->dana_masuk)?>,-
                                          <?php if($row->status == "tutup" && $row2->cara_bayar != "Uang Tanda Jadi"){?>
                                            <input type="number" class="form-control qty1" value="<?php echo $row2->dana_masuk?>" id="dana_masuk" name="dana_masuk[]">
                                          <?php } else if($row2->cara_bayar == "Uang Tanda Jadi") {?>
                                            <input type="hidden" class="form-control qty1" value="<?php echo $row2->dana_masuk?>" id="dana_masuk" name="dana_masuk[]">
                                          <?php }?>
                                          <input type="hidden" value="<?php echo $row2->no_ppjb?>" name="no_ppjb[]">
                                          <input type="hidden" value="<?php echo $row2->persen?>" name="persen[]">
                                          <input type="hidden" value="<?php echo $row2->status?>" name="status[]">
                                          <!-- <?php echo $row2->id_psjb;?> -->
                                        </td>
                                        <?php if($row2->status != "lunas"){?>
                                          <!-- <td><a class="btn btn-outline-success btn-flat btn-sm" href="<?php echo base_url()?>Dashboard/detail_custom_biaya_psjb?id=<?php echo $row2->id_psjb?>">Edit</a></td> -->
                                        <?php }?>
                                        <!-- <td>
                                        </td> -->
                                    </tr>
                                <?php }?>
                                <input type="hidden" id="total" class="totals" value="<?php echo $row->harga_jual?>" name="total">
                                <input type="hidden" value="<?php echo $row->harga_jual?>" name="totals">
                              
                              <tr style="background-color: lightgrey">
                                  <td colspan=2 style="text-align: center">Total Terkini</td>
                                  <td>Rp. <?php echo number_format($total_terkini)?>,-</td>
                              </tr>
                              <!-- <tr style="background-color: lightgrey">
                                  <td colspan=2 style="text-align: center">Total Jual</td>
                                  <td>Rp. <?php echo number_format($row->total_jual-$total_terkini)?>,-</td>
                              </tr> -->
                              <?php } else {?>
                                  <?php $total_terkini=0;
                                        $ttl_pembayaran = 0; foreach($psjb_detail_dp as $row2){?>
                                  <?php 
                                      $total_terkini = $total_terkini+$row2->dana_masuk;
                                  ?>
                                  <tr>
                                      <td><?php echo $row2->cara_bayar?></td>
                                      <td><?php echo $row2->tanggal_dana?></td>
                                      <td>Rp. <?php echo number_format($row2->dana_masuk)?>,-</td>
                                      <td>
                                        <?php 
                                        // echo $row2->id_psjb;
                                        // print_r($this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$row2->id_psjb, 'kode_perumahan'=>$row2->kode_perumahan))->result());
                                        foreach($this->db->get_where('keuangan_kas_kpr', array('id_ppjb'=>$row2->id_psjb, 'kode_perumahan'=>$row2->kode_perumahan))->result() as $pmbyr){
                                          echo $pmbyr->tanggal_bayar." Rp. ".number_format($pmbyr->pembayaran)." ".$pmbyr->cara_pembayaran."-".$pmbyr->nama_bank."<br>";
                                          
                                          $ttl_pembayaran = $ttl_pembayaran + $pmbyr->pembayaran;
                                        }?>
                                      </td>
                                  </tr>
                                  <?php }?>
                              <?php }?>
                              <tr style="background-color: ">
                                  <td colspan=2 style="text-align: center">Total Pembayaran</td>
                                  <td>
                                    Rp. <?php echo number_format($row->total_jual)?>,-
                                    <?php if($row->status == "tutup"){?>
                                      <input type="text" id="total" value="<?php echo number_format($row->total_jual)?>" readonly class="total form-control">
                                    <?php }?>
                                  </td>
                                  <td><?php echo "Rp. ".number_format($ttl_pembayaran);?></td>
                              </tr>
                              <tr style="background-color: lightgrey">
                                  <td colspan=2 style="text-align: center">Total Jual</td>
                                  <td>Rp. <?php echo number_format($row->total_jual-$total_terkini)?>,-</td>
                                  <td></td>
                              </tr>
                          </tbody>
                        </table>
                    </div>
                  </form> 
                  <div class="col-md-12">
                      <h4 style="font-weight: bold;">Rincian Harga Terbayar</h4>
                      <table class="table">
                        <tbody>
                            <tr style="background-color: lightpink">
                              <td>Harga Sepakat</td>
                              <td>Rp. <?php echo number_format($row->total_jual)?>,-</td>
                            </tr>
                            <tr>
                              <td>Nilai Terbayar (Tanda Jadi)</td>
                              <td>Rp. <?php echo number_format($row->uang_awal)?>,-</td>
                            </tr>
                            <hr>
                            <tr style="background-color: lightpink">
                              <td>Total Sisa Utang</td>
                              <td>Rp. <?php echo number_format($row->total_jual-$row->uang_awal)?>,-</td>
                            </tr>
                        </tbody>
                      </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Perubahan Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/ppjb_ubah_blok" method="POST">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>No Blok Terkini</label>
                <input type="text" class="form-control" name="no_blok" value="<?php echo $row->no_kavling?>" readonly>
              </div>
              <?php foreach($this->db->get_where('rumah', array('no_psjb'=>$row->psjb, 'kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>$row->tipe_produk))->result() as $rmh){?>
                <div class="form-group">
                  <label>No Blok Terkini</label>
                  <input type="text" class="form-control" name="" value="<?php echo $rmh->kode_rumah?>" readonly>
                </div>
              <?php }?>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Perumahan</label>
                <?php foreach($this->db->get_where('perumahan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $prmh){
                  $nama_perumahan = $prmh->nama_perumahan;
                }?>
                <input type="text" class="form-control" value="<?php echo $nama_perumahan?>" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Blok Tersedia</label>
            <div id="id_kavling" style=" border:2px solid #ccc; width:100%; height: 75px; overflow-y: scroll;">
              <?php 
              $this->db->order_by('kode_rumah', 'ASC');
              $query = $this->db->get_where('rumah', array('kode_perumahan'=>$row->kode_perumahan, 'tipe_produk'=>"rumah", 'status'=>"free"))->result();

              // Display city dropdown based on country name
              // if($category !== 'Select'){
                  // echo "<label>City:</label>";
                  // echo "<select>";
                  // echo "<option value='' disabled selected>-Pilih-</option>";
                  foreach($query as $value){
                      echo "<input type='checkbox' name='id_kavling[]' value=".$value->kode_rumah.">"." ".$value->kode_rumah."-".$value->nama_perumahan." <br>";
                  }
                  // echo "</select>";
              // }?>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" value="<?php echo $row->id_psjb?>" id="idPSJB" class="idPSJB">
          <input type="hidden" name="no_psjb" value="<?php echo $row->no_psjb?>">
          <input type="hidden" name="kode_perumahan" value="<?php echo $row->kode_perumahan?>">
          <input type="hidden" name="psjb" value="<?php echo $row->psjb?>">
          <!-- <input type="text" name=""> -->
          <!-- <input type="hidden" name="id" value="<?php echo $id?>">
          <input type="hidden" name="bln" value="<?php echo $tgl?>"> -->

          <input type="submit" class="btn btn-success" value="Submit">
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<?php }?>
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
<script type="text/javascript">
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).on("change", ".qty1", function() {
  var sum = 0;
  $(".qty1").each(function(){
    sum += +$(this).val();
  });
  $(".total").val(numberWithCommas(sum));
  $(".totals").val(sum);
});
</script>
</body>
</html>
