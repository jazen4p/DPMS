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
  <link type="text/css" href="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/css/jquery.signature.css" rel="stylesheet">  
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
    .kbw-signature { width: 400px; height: 200px;}
    #sig canvas{
        width: 100% !important;
        height: auto;
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
              Rekap Pencairan Upah <?php echo $st?> 
              <?php ?>

              <?php ?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Rekap Pencairan Upah <?php echo $st?></li>
            </ol>
          </div>
        </div>
        <button type="button" id="button" class="btn btn-flat btn-outline-info">FILTER</button>
        <div id="wrapper">
          <?php if($st == "Borongan"){?>
          <form action="<?php echo base_url()?>Dashboard/filter_kbk_pencairan_dana_management_borongan" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Perumahan</label>
                  <select name="perumahan" class="form-control">
                      <option value="">Semua</option>
                      <?php foreach($this->db->get('perumahan')->result() as $perumahan){
                        echo "<option ";
                        if(isset($kode_perumahan)){
                            if($kode_perumahan == $perumahan->kode_perumahan){
                                echo "selected";
                            }
                        }
                        echo " value='$perumahan->kode_perumahan'>$perumahan->nama_perumahan</option>";
                      }?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control">
                      <option value="">Semua</option>
                      <option value="cat" <?php if($kategori == "cat"){echo "selected";}?>>Cat</option>
                      <option value="plafond" <?php if($kategori == "plafond"){echo "selected";}?>>Plafond</option>
                      <option value="listrik" <?php if($kategori == "listrik"){echo "selected";}?>>Listrik</option>
                      <option value="atap" <?php if($kategori == "atap"){echo "selected";}?>>Atap</option>
                      <option value="groundtank" <?php if($kategori == "groundtank"){echo "selected";}?>>Ground Tank</option>
                      <option value="tambahanbangunan" <?php if($kategori == "tambahanbangunan"){echo "selected";}?>>Tambahan Bangunan</option>
                  </select>
                </div>
              </div>
              <!-- <div class="col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                </div>
                <div class="form-group">
                    <label>Sampai</label>
                    <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                </div>
              </div> -->
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
              </div>
            </div>
          </form>
          <?php } else {?>
          <form action="<?php echo base_url()?>Dashboard/filter_kbk_pencairan_dana_management_harian" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Perumahan</label>
                  <select name="perumahan" class="form-control">
                      <option value="">Semua</option>
                      <?php foreach($this->db->get('perumahan')->result() as $perumahan){
                        echo "<option ";
                        if(isset($kode_perumahan)){
                            if($kode_perumahan == $perumahan->kode_perumahan){
                                echo "selected";
                            }
                        }
                        echo " value='$perumahan->kode_perumahan'>$perumahan->nama_perumahan</option>";
                      }?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control">
                      <option value="">Semua</option>
                      <option value="cat" <?php if($kategori == "cat"){echo "selected";}?>>Cat</option>
                      <option value="plafond" <?php if($kategori == "plafond"){echo "selected";}?>>Plafond</option>
                      <option value="listrik" <?php if($kategori == "listrik"){echo "selected";}?>>Listrik</option>
                      <option value="atap" <?php if($kategori == "atap"){echo "selected";}?>>Atap</option>
                      <option value="groundtank" <?php if($kategori == "groundtank"){echo "selected";}?>>Ground Tank</option>
                      <option value="tambahanbangunan" <?php if($kategori == "tambahanbangunan"){echo "selected";}?>>Tambahan Bangunan</option>
                  </select>
                </div>
              </div>
              <!-- <div class="col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input placeholder="Tanggal Awal" value="<?php if(isset($tglmin)){echo $tglmin;}?>" name="tgl_awal" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                </div>
                <div class="form-group">
                    <label>Sampai</label>
                    <input placeholder="Tanggal Akhir" value="<?php if(isset($tglmax)){echo $tglmax;}?>" name="tgl_akhir" class="textbox-n form-control" onfocus="(this.type='date')" type="text" id="date">
                </div>
              </div> -->
              <!-- <input type="date" class="form-control col-sm-2" placeholder="Tanggal Awal">
              <input type="date" class="form-control col-sm-2" placeholder="Tanggal Akhir"> -->
              <div class="col-md-12">
                <input type="submit" class="btn btn-info btn-flat" value="SEARCH" />
                <button type="button" id="thisPrint" class="btn btn-info btn-flat" style="">CETAK</button>
              </div>
            </div>
          </form>
          <?php }?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

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
                <?php if($st == "Harian"){?>
                  <div class="card-header">
                    <a href="<?php echo base_url()?>Dashboard/form_kontrak_harian" class="btn btn-outline-success btn-sm btn-flat">Tambah Baru</a>
                  </div>
                <?php }?>
                <div class="card-body">
                    <div class="col-12">
                        <div style="text-align: center">
                            <h3>Rekap Upah <?php echo $st?></h3>
                        </div>
                        <table id="example2" class="table table-bordered table-striped" style="font-size: 14px">
                            <div style="text-align: center">
                            </div>
                            <thead>
                              <?php if($st == "Borongan"){?>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tukang</th>
                                    <th>Unit</th>
                                    <th>Tipe (m<sup>2</sup>)</th>
                                    <th>Jenis Pengajuan</th>
                                    <th>Kategori</th>
                                    <th>Nominal Kontrak</th>
                                    <th>Awal Nominal</th>
                                    <th>Pembayaran</th>
                                    <th>Sisa Nominal</th>
                                    <th>Tanggal</th>
                                    <!-- <th>Status</th> -->
                                    <!-- <th>Jmlh Diterima</th> -->
                                    <th>Aksi</th>
                                </tr>
                              <?php } else {?>
                                <tr>
                                    <th>No</th>
                                    <th>Proyek/Perumahan</th>
                                    <th>Kategori</th>
                                    <th>Unit</th>
                                    <th>Nama Tukang</th>
                                    <th>Pekerjaan</th>
                                    <th>Upah</th>
                                    <th>Hari Kerja</th>
                                    <th>Lembur</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <!-- <th>Status</th> -->
                                    <!-- <th>Jmlh Diterima</th> -->
                                    <th>Aksi</th>
                                </tr>
                              <?php }?>
                            </thead>
                            <tbody style="white-space: nowrap">
                              <?php if($st == "Borongan"){ ?>
                                <?php $no=1; foreach($check_all->result() as $row){
                                foreach($this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$row->id_kontrak))->result() as $row1){ ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $row1->nama_tukang;?></td>
                                    <td><?php echo $row1->no_unit;?></td>
                                    <td><?php echo $row1->type_unit;?></td>
                                    <td><?php echo $row->jenis_kontrak;?></td>
                                    <td><?php echo $row1->kategori;?></td>
                                    <td><?php echo "Rp. ".number_format($row->nominal_seharusnya);?></td>
                                    <td><?php echo "Rp. ".number_format($row->awal_nominal);?></td>
                                    <td><?php echo "Rp. ".number_format($row->nominal);?></td>
                                    <td><?php echo "Rp. ".number_format($row->akhir_nominal);?></td>
                                    <td><?php echo date('d F Y', strtotime($row->tgl_pencairan));?></td>
                                    <td>
                                    <?php if($row->tukang_sign == ""){?>
                                      <button type="button" data-id="<?php echo $row->id_pencairan?>" data-kode="<?php echo $row->kode_perumahan?>" data-toggle="modal" data-target="#exampleModal" class="btn btn-flat btn-sm btn-outline-primary">Signature</button>
                                    <?php }?>

                                    <?php
                                    $check = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>"KBK-KK-MSK$row->no_pencairan"));
                                    if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan"){
                                      if($row->status == "menunggu"){?>
                                        <!-- <td> -->
                                            <a href="<?php echo base_url()?>Dashboard/approve_pencairan_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Approve</a>
                                            <a href="<?php echo base_url()?>Dashboard/hapus_pencairan_kbk_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Batal</a>
                                        <!-- </td> -->
                                    <?php } else { ?>
                                        <!-- <td> -->
                                            <a href="<?php echo base_url()?>Dashboard/print_tanda_terima_pencairan_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm" target="_blank">Cetak</a>
                                            <?php 
                                            // foreach($check->result() as $pgl){
                                            if($check->num_rows() == 0){?>
                                              <a href="<?php echo base_url()?>Dashboard/form_pembayaran_pencairan_kbk_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Cairkan</a>
                                              <a href="<?php echo base_url()?>Dashboard/hapus_pencairan_kbk_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Batal</a>
                                            <?php } else {
                                              echo "-Sudah dicairkan-"; 
                                            }?>
                                        <!-- </td>   -->
                                    <?php }} else {
                                        if($row->status == "approved"){
                                            if($check->num_rows() != 0){?>
                                            -Sudah cair-<a href="<?php echo base_url()?>Dashboard/print_tanda_terima_pencairan_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm" target="_blank">Cetak Tanda Terima</a>
                                        <?php } else {
                                            echo "-Pencairan dalam proses-";
                                        }} else {
                                            echo "-Menunggu Pencairan-";
                                        }
                                    }?>
                                    </td>
                                </tr>
                                <?php $no++;}}?>
                              <?php } else {
                                $no = 1;
                                foreach($check_all->result() as $row){?>
                                  <tr>
                                    <td><?php echo $no?></td>
                                    <td><?php echo $row->kode_perumahan?></td>
                                    <td><?php echo $row->kategori?></td>
                                    <td><?php echo $row->keterangan?></td>
                                    <td><?php echo $row->nama_tukang?></td>
                                    <td><?php echo $row->keterangan_utama?></td>
                                    <td><?php echo "Rp. ".number_format($row->upah)?></td>
                                    <td><?php echo $row->masa_kerja?></td>
                                    <td><?php echo "Rp. ".number_format($row->lembur)?></td>
                                    <td><?php echo "Rp. ".number_format($row->total)?></td>
                                    <td><?php echo date('d F Y', strtotime($row->tgl_pencairan))?></td>
                                    <td>
                                    <?php if($row->tukang_sign == ""){?>
                                      <button type="button" data-id="<?php echo $row->id_pencairan?>" data-kode="<?php echo $row->kode_perumahan?>" data-toggle="modal" data-target="#exampleModal1" class="btn btn-flat btn-sm btn-outline-primary">Signature</button>
                                    <?php }?>

                                    <?php 
                                    $check = $this->db->get_where('keuangan_pengeluaran', array('no_pengeluaran'=>"KBK-H-MSK$row->no_pencairan"));
                                    if($this->session->userdata('role')=="superadmin" || $this->session->userdata('role')=="manager keuangan"){
                                      if($row->status == "menunggu"){?>
                                        <!-- <td> -->
                                            <a href="<?php echo base_url()?>Dashboard/approve_pencairan_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Approve</a>
                                            <a href="<?php echo base_url()?>Dashboard/hapus_pencairan_kbk_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Batal</a>
                                        <!-- </td> -->
                                    <?php } else { ?>
                                        <!-- <td> -->
                                            <a href="<?php echo base_url()?>Dashboard/print_tanda_terima_pencairan_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm" target="_blank">Cetak</a>
                                            <?php 
                                            // foreach($check->result() as $pgl){
                                            if($check->num_rows() == 0){?>
                                              <a href="<?php echo base_url()?>Dashboard/form_pembayaran_pencairan_kbk_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Cairkan</a>
                                              <a href="<?php echo base_url()?>Dashboard/hapus_pencairan_kbk_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm">Batal</a>
                                            <?php } else {
                                              echo "-Sudah dicairkan-"; 
                                            }?>
                                        <!-- </td>   -->
                                    <?php }} else {
                                        if($row->status == "approved"){
                                            if($check->num_rows() != 0){?>
                                            -Sudah cair-<a href="<?php echo base_url()?>Dashboard/print_tanda_terima_pencairan_kontrak?id=<?php echo $row->id_pencairan?>&st=<?php echo $row->jenis_kontrak?>" class="btn btn-outline-primary btn-flat btn-sm" target="_blank">Cetak Tanda Terima</a>
                                        <?php } else {
                                            echo "-Pencairan dalam proses-";
                                        }} else {
                                            echo "-Menunggu Pencairan-";
                                        }
                                    }?></td>
                                  </tr>
                              <?php $no++;}}?>
                            </tfoot>
                        </table> 
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tanda Terima Online Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/update_signature_tanda_terima_pencairan_borongan" method="POST">
          <div class="col-md-12">
            <label class="" for="">Tukang signature:</label>
            <br/>
            <div id="sig"></div>
            <br/>
            <button type="button" id="clear" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature64" name="signed" style="display: none"></textarea>
          </div> <br>
          <!-- <div class="col-md-12">
            <label class="" for="">Sub Kontraktor signature:</label>
            <br/>
            <div id="sig1"></div>
            <br/>
            <button type="button" id="clear1" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature641" name="signed1" style="display: none"></textarea>
          </div> -->
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" id="idPSJB" class="idPSJB">
          <input type="hidden" name="kode" id="kode" class="kode">
          <!-- <input type="hidden" name="kode" value="<?php echo $row->kode_perumahan?>"> -->
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

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tanda Terima Online Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url()?>Dashboard/update_signature_tanda_terima_pencairan_harian" method="POST">
          <div class="col-md-12">
            <label class="" for="">Tukang signature:</label>
            <br/>
            <div id="sig1"></div>
            <br/>
            <button type="button" id="clear1" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature641" name="signed1" style="display: none"></textarea>
          </div> <br>
          <!-- <div class="col-md-12">
            <label class="" for="">Sub Kontraktor signature:</label>
            <br/>
            <div id="sig1"></div>
            <br/>
            <button type="button" id="clear1" class="btn btn-outline-danger btn-flat btn-sm">Clear Signature</button>
            <textarea id="signature641" name="signed1" style="display: none"></textarea>
          </div> -->
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id" id="idPSJB" class="idPSJB">
          <input type="hidden" name="kode" id="kode" class="kode">
          <!-- <input type="hidden" name="kode" value="<?php echo $row->kode_perumahan?>"> -->
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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
<!-- jQuery -->
<script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/js/jquery.signature.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery-ui-touch-punch-master/jquery.ui.touch-punch.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>asset/plugins/jquery-ui-touch-punch-master/jquery.ui.touch-punch.min.js"></script>
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
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true
    });
    
  });

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
  })

  $(function() {
    var b = $("#button");
    var w = $("#wrapper");
    var l = $("#list");
    b.click(function() {
      w.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
  });

  $('#exampleModal').on('show.bs.modal', function (e) {
    var myRoomNumber = $(e.relatedTarget).attr('data-id');
    var kode = $(e.relatedTarget).attr('data-kode');

    $(this).find('.idPSJB').val(myRoomNumber);
    $(this).find('.kode').val(kode);
    // alert(myRoomNumber);
  });
</script>
<script type="text/javascript">
  var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
      e.preventDefault();
      sig.signature('clear');
      $("#signature64").val('');
  });
  var sig1 = $('#sig1').signature({syncField: '#signature641', syncFormat: 'PNG'});
    $('#clear1').click(function(e1) {
      e1.preventDefault();
      sig1.signature('clear');
      $("#signature641").val('');
  });
  var sig2 = $('#sig2').signature({syncField: '#signature642', syncFormat: 'PNG'});
    $('#clear2').click(function(e2) {
      e2.preventDefault();
      sig2.signature('clear');
      $("#signature642").val('');
  });
  var sig3 = $('#sig3').signature({syncField: '#signature643', syncFormat: 'PNG'});
    $('#clear3').click(function(e3) {
      e3.preventDefault();
      sig3.signature('clear');
      $("#signature643").val('');
  });
</script>
</body>
</html>
