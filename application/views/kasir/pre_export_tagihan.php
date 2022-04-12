<!DOCTYPE html>
<html>
<head>
    <title>DPMS Kasir-Export Laporan Tagihan</title>

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
    <link type="text/css" href="<?php echo base_url()?>asset/plugins/jquery.signature.package-1.2.0/css/jquery.signature.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
     <a class="btn btn-sm btn-danger btn-flat" href="<?php echo base_url()?>Kasir/rekap_laporan_pembayaran"><i class="fa fa-arrow-left"></i> Back</a>
     <a class="btn btn-sm btn-success btn-flat" href="<?php echo base_url()?>Kasir/export_tagihan?bln=<?php echo $bln?>&kode=<?php echo $kode_perumahan?>"><i class="fa fa-file"></i> Export Data</a>
     <table class="table table-bordered table-striped" id="ex1" style="font-size: 12px">
          <thead style="white-space: nowrap">
               <tr>
                    <th rowspan=2 style="width: 5px; text-align: center;">No</th>
                    <th rowspan=2>Unit</th>
                    <th rowspan=2>Nama Konsumen/Penghuni</th>
                    <th colspan=4>Pemakaian</th>
                    <th colspan=4 style="text-align: center;">Pembayaran</th>
                    <th rowspan=2>Tanggal Bayar</th>
                    <th rowspan=2>Keterangan</th>
               </tr>
               <tr>
                    <th>Abodemen</th>
                    <th>Keamanan dan Ketertiban</th>
                    <th>Charge</th>
                    <th>Kubikasi</th>
                    <th>Total Charge</th>
                    <th>Tunai</th>
                    <th>Transfer</th>
                    <th>Total</th>
               </tr>
          </thead>
          <tbody>
               <?php $index = 1; ?>
               <?php foreach($check_all->result() as $pengguna): ?>
                    <tr style="white-space: nowrap">
                         <td style="width: 7%; text-align: center;"><?php echo $index++; ?></td>
                         <td style=""><?php echo $pengguna->kode_rumah; ?></td>
                         <td><?php echo $pengguna->nama_pemilik; ?></td>
                         <td>
                            <?php 
                            $ttl_abod = 0;
                            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $abod){
                                $ttl_abod = $ttl_abod + $abod->nominal;
                            }
                            echo "Rp. ".number_format($ttl_abod);
                            ?>
                         </td>
                         <td>
                            <?php 
                            $ttl_main = 0;
                            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"maintenance"))->result() as $main){
                                $ttl_main = $ttl_main + $main->nominal;
                            }
                            echo "Rp. ".number_format($ttl_main);
                            ?>
                         </td>

                         <?php 
                            $overuse_ttl = 0;
                            foreach($this->db->get_where('konsumen_struk_item', array('id_struk'=>$pengguna->id_struk, 'jenis_tagihan'=>"air"))->result() as $row){
                                foreach($this->db->get_where('konsumen_air', array('id_air'=>$row->id_tagihan))->result() as $air){
                                    if($air->meteran > 20){
                                        $overuse_ttl = $overuse_ttl + (ceil($air->meteran) - 20);
                                    }
                                }
                            }
                         ?>
                         <td <?php if($overuse_ttl > 0){echo "style='background-color: yellow'";}?>>
                            <?php
                            if($overuse_ttl > 0){
                                echo "Rp. 5.000";
                            }
                            ?>
                         </td>
                         <td <?php if($overuse_ttl > 0){echo "style='background-color: yellow'";}?>>
                            <?php 
                            if($overuse_ttl > 0){
                                echo $overuse_ttl." m<sup>3</sup>";
                            }?>
                         </td>
                         <td><?php echo "Rp. ".number_format($overuse_ttl * 5000);?></td>
                         <td <?php if($pengguna->status == "lunas"){echo "style='background-color: pink'";}?>>
                            <?php if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "cash"){
                                echo "Tunai";
                            }?>
                         </td>
                         <td <?php if($pengguna->status == "lunas"){echo "style='background-color: pink'";}?>>
                            <?php if($pengguna->status == "lunas" && $pengguna->jenis_pembayaran == "transfer"){
                                echo "Transfer";
                                foreach($this->db->get_where('bank', array('id_bank'=>$pengguna->id_bank))->result() as $bank){
                                    echo " - ".$bank->nama_bank;
                                }
                            }?>
                         </td>
                         <td><?php echo "Rp. ".number_format($ttl_abod + $ttl_main + ($overuse_ttl * 5000))?></td>
                         <td>
                            <?php if($pengguna->status == "lunas"){
                                echo $pengguna->status_date;   
                            }?>
                         </td>
                         <td><?php echo $pengguna->keterangan?></td>
                    </tr>
               <?php endforeach; ?>
          </tbody>
     </table>
    </div>


    <script src="<?php echo base_url()?>asset/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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

    <script>
    $(function () {
    $("#ex21").DataTable({
        "responsive": false,
        "autoWidth": false,
        "scrollX": true
    });
    $('#ex1').DataTable({
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
</body>
</html>