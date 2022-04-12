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
  <?php foreach($spk_detail->result() as $row) {?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail KBK</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard/">Home</a></li>
              <li class="breadcrumb-item active">Detail KBK</li>
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
              <!-- /.card-header -->
              <div class="card-header">
                <div class="row">
                  <a href="<?php echo base_url()?>Dashboard/kbk_management?id=<?php echo $row->kode_perumahan?>" class="btn btn-success btn-sm">Kembali</a>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="background-color: lightgreen; padding-left: 5px; padding-bottom: 5px; padding-top: 5px">Detail Revisi</h4>
                    <table class="table table-bordered table-stripped">
                      <thead>
                        <tr>
                          <td>No</td>
                          <td>Keterangan</td>
                          <td>Oleh</td>
                          <td>Pada</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach($this->db->get_where('kbk_sendback', array('id_kbk'=>$row->id_kbk))->result() as $sb){?>
                          <tr>
                            <td><?php echo $no;?></td>
                            <td><?php echo $sb->keterangan?></td>
                            <td><?php echo $sb->created_by?></td>
                            <td><?php echo $sb->date_by?></td>
                          </tr>
                        <?php $no++;}?>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12">
                    <h4 style="font-weight: bold">Informasi KBK (Kontrak Bangun Kavling)</h4>  
                    <table class="table">
                        <tbody>
                            <tr><td>Nomor SPK</td><td>1-<?php echo sprintf('%03d', $no_spk)?>/SPK/KBR/<?php echo $kode_perusahaan."/".$row->kode_perumahan."/".date("m", strtotime($row->date_by))."/".date("Y", strtotime($row->date_by))?></td></tr>
                            <?php foreach($this->db->get_where('ppjb', array('id_psjb'=>$row->id_ppjb))->result() as $ppjb){?>
                                <tr><td>Nomor PPJB</td><td>1-<?php echo sprintf('%03d', $ppjb->no_psjb)?>/PPJB/KBR/<?php echo $kode_perusahaan."/".$ppjb->kode_perumahan."/".date("m", strtotime($ppjb->tgl_psjb))."/".date("Y", strtotime($ppjb->tgl_psjb))?></td></tr>
                                <tr><td>Nama Pemilik Unit</td><td><?php echo $ppjb->nama_pemesan?></td></tr>
                                <tr><td>Sistem Pembayaran</td><td><?php echo $ppjb->sistem_pembayaran?></td></tr>
                                <tr><td>No Unit</td><td><?php echo $row->unit?></td></tr>
                                <tr><td>Harga Jual</td><td><?php echo "Rp. ".number_format($row->harga_unit)?></td></tr>
                                <tr><td>Luas Bangunan (m<sup>2</sup>)</td><td><?php echo $row->luas_bangunan?></td></tr>
                                <tr><td>Luas Tanah (m<sup>2</sup>)</td><td><?php echo $row->luas_tanah?></td></tr>
                                <tr><td>Nilai Upah</td><td><?php echo "Rp. ".number_format($row->upah)?></td></tr>
                                <tr><td>Kontrak Pekerjaan</td><td><?php echo $row->kontrak_pekerjaan?></td></tr>
                                <tr><td>Masa Pelaksanaan</td><td><?php echo $row->masa_pelaksanaan?></td></tr>
                                <tr><td>Tanggal BAST</td><td><?php echo date('Y-m-d', strtotime($row->tgl_bast));?></td></tr>
                            <?php }?>
                            <tr><td>Tanggal Mulai</td><td><?php echo date('d F Y', strtotime($row->tgl_mulai))?></td></tr>
                            <tr><td>Tanggal Selesai</td><td><?php echo date('d F Y', strtotime($row->tgl_selesai))?></td></tr>
                            <!-- <tr><td>Tanggal</td><td><?php echo $row->tgl_psjb?></td></tr>
                            <tr><td>Nama Pemesan</td><td><?php echo $row->nama_pemesan?></td></tr>
                            <tr><td>Nama dalam Sertifikat / PPJB</td><td><?php echo $row->nama_sertif?></td></tr>
                            <tr><td>KTP Pemesan</td><td><?php echo $row->ktp?></td></tr>
                            <tr><td>Alamat KTP</td><td><?php echo $row->alamat_lengkap?></td></tr>
                            <tr><td>Alamat Surat</td><td><?php echo $row->alamat_surat?></td></tr>
                            <tr><td>No Telp Rumah</td><td><?php echo $row->telp_rumah?></td></tr>
                            <tr><td>No Handphone</td><td><?php echo $row->telp_hp?></td></tr>
                            <tr><td>Pekerjaan</td><td><?php echo $row->pekerjaan?></td></tr>
                            <tr><td>Luas Tanah m2</td><td><?php echo $row->luas_tanah?></td></tr>
                            <tr><td>Luas Bangunan m2</td><td><?php echo $row->luas_bangunan?></td></tr>
                            <tr><td>Tipe Standart</td><td><?php echo $row->tipe_rumah?></td></tr>
                            <tr><td>Harga Jual</td><td>Rp. <?php echo number_format($row->harga_jual)?>,-</td></tr>
                            <tr><td>Hadap Timur</td><td>Rp. <?php echo number_format($row->hadap_timur)?>,-</td></tr>
                            <tr><td>Diskon Jual</td><td>Rp. <?php echo number_format($row->disc_jual)?>,-</td></tr>
                            <tr><td>Total Jual</td><td>Rp. <?php echo number_format($row->total_jual)?>,-</td></tr>
                            <tr><td>Uang Terbayar</td><td>Rp. <?php echo number_format($row->uang_awal)?>,-</td></tr>
                            <tr><td>Biaya Kekurangan</td><td>Rp. <?php echo number_format($row->total_jual-$row->uang_awal)?>,-</td></tr> -->
                        </tbody>
                    </table>

                    <div class="col-12 row">
                        <div class="col-sm-6">
                            <div style="background-color: lightblue; padding-bottom: 5px; padding-top: 5px; text-align: center">Pihak 1 - Developer</div>
                            <table>
                                <tr>
                                    <td>Nama</td><td>:</td><td><?php echo $row->dev_nama?></td>
                                </tr>
                                <tr>
                                    <td>No. KTP</td><td>:</td><td><?php echo $row->dev_ktp?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td><td>:</td><td><?php echo $row->dev_alamat?></td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td><td>:</td><td><?php echo $row->dev_pekerjaan?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <div style="background-color: lightblue; padding-bottom: 5px; padding-top: 5px; text-align: center">Pihak 2 - Sub Kontraktor</div>
                            <table>
                                <tr>
                                    <td>Nama</td><td>:</td><td><?php echo $row->sub_nama?></td>
                                </tr>
                                <tr>
                                    <td>No. KTP</td><td>:</td><td><?php echo $row->sub_ktp?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td><td>:</td><td><?php echo $row->sub_alamat?></td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td><td>:</td><td><?php echo $row->sub_pekerjaan?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="col-12 row">
                        <div class="col-12" style="background-color: lightblue; padding-bottom: 5px; padding-top: 5px; text-align: center">Ketentuan Pembayaran</div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>TERMIN</th>
                                    <th>OPNAME PEMBAYARAN (%)</th>
                                    <th>NILAI PEMBAYARAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tl =0 ;
                                $this->db->order_by('id_termin', "ASC");
                                foreach($this->db->get_where('kbk_termin', array('id_kbk'=>$row->id_kbk))->result() as $termin){?>
                                    <tr>
                                        <td><?php echo $termin->tahap?></td>
                                        <td><?php echo $termin->opname?> %</td>
                                        <td><?php echo "Rp. ".number_format($termin->nilai_pembayaran)?></td>
                                    </tr>
                                <?php $tl = $tl + $termin->nilai_pembayaran;}?>
                                <tr>
                                    <td colspan=2 style="text-align: center; font-weight: bold">TOTAL</td>
                                    <td><?php echo "Rp. ".number_format($tl)?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            
            <?php if(isset($edit_kbk)){?>
                <div class="col-12 card">
                    <div class="card-body">
                        <form action="<?php echo base_url()?>Dashboard/kbk_sendback" method="POST">
                            <div class="row">
                                <div class="col-sm-3">
                                    Keterangan Revisi
                                </div>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="ket"></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                            <input type="hidden" value="<?php echo $id?>" name="id">
                            <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode">
                            <input type="submit" class="btn btn-sm btn-flat btn-success">
                        </form>
                    </div>
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
<?php }?>
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
