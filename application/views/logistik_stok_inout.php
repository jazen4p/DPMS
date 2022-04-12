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
                <?php 
                if(isset($edit_flow)){
                  foreach($edit_flow->result() as $ts){
                    if($ts->jenis_arus == "masuk"){
                        echo "Edit input - Masuk Bahan";
                    } else {
                        echo "Edit input - Keluar Bahan";
                    }
                  }
                } else {
                  if(isset($in_stok)){
                      echo "Input - Masuk Bahan";
                  } else {
                      echo "Input - Keluar Bahan";
                  }
                }?>           
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">
                <?php 
                  if(isset($edit_flow)){
                    foreach($edit_flow->result() as $ts){
                      if($ts->jenis_arus == "masuk"){
                          echo "Edit input - Masuk Bahan";
                      } else {
                          echo "Edit input - Keluar Bahan";
                      }
                    }
                  } else {
                    if(isset($in_stok)){
                        echo "Input - Masuk Bahan";
                    } else {
                        echo "Input - Keluar Bahan";
                    }
                  }
                ?> 
              </li>
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
    <?php if(isset($edit_flow)){
      foreach($edit_flow->result() as $row){?>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                  <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/rekap_arus_stok?id=<?php echo $kode?>">Kembali</a>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <?php if($row->jenis_arus == "masuk"){?>
                        <form action="<?php echo base_url()?>Dashboard/edit_arus_stok" method="POST">
                          <div class="col-12 row">
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Data Flow
                                  </div> <br>
                                  <div class="form-group">
                                      <label>Tanggal Masuk Bahan</label>
                                      <input type="text" class="form-control" name="tgl" value="<?php echo $row->tgl_arus?>" required>
                                  </div>
                                  <div class="form-group">
                                      <label>Perumahan</label>
                                      <select name="perumahan" class="form-control" required>
                                          <?php foreach($this->db->get('perumahan')->result() as $pr){
                                            echo "<option ";
                                            if($row->kode_perumahan == $pr->kode_perumahan){
                                              echo "selected";
                                            }
                                            echo " value='$pr->kode_perumahan'>$pr->nama_perumahan</option>";
                                          }?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Informasi Bahan
                                  </div> <br>
                                  <div class="row">
                                      <div class="col-sm-6 form-group">
                                          <label>Bahan</label>
                                          <select name="nama_bahan" id="namaBahan" class="form-control" required>
                                              <!-- <option value="" disabled selected>-Pilih-</option> -->
                                              <?php 
                                              $this->db->order_by('nama_data', "ASC");
                                              foreach($this->db->get_where('produksi_master_data', array('kategori'=>"barang"))->result() as $brg){
                                                echo "<option ";
                                                if($row->nama_barang == $brg->nama_data){
                                                  echo "selected";
                                                }
                                                echo " value='$brg->nama_data'>$brg->nama_data</option>";
                                              }?>
                                          </select>
                                      </div>
                                      <div class="col-sm-6 form-group">
                                          <label>Satuan</label>
                                          <input type="text" class="form-control" id="response1" name="nama_satuan" value="<?php echo $row->nama_satuan?>" readonly>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label>Nama Toko</label>
                                      <select name="nama_toko" class="form-control" required>
                                          <!-- <option value="" disabled selected>-Pilih-</option> -->
                                          <?php 
                                          $this->db->order_by('nama_data', "ASC");
                                          foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $toko){
                                            echo "<option ";
                                            if($row->nama_toko == $toko->nama_data){
                                              echo "selected";
                                            }
                                            echo " value='$toko->nama_data'>$toko->nama_data</option>";
                                          }
                                          foreach($this->db->get_where('perumahan')->result() as $pers){?>
                                            <option value="<?php echo $pers->kode_perumahan?>"><?php echo $pers->nama_perumahan?></option>
                                          <?php }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label>Qty</label>
                                      <input type="number" value="<?php echo $row->qty?>" step="0.01" name="qty" class="form-control" required>
                                  </div>
                              </div>
                          </div>
                      <?php } else {?>
                        <form action="<?php echo base_url()?>Dashboard/edit_arus_stok" method="POST">
                          <div class="col-12 row">
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Data Flow
                                  </div> <br>
                                  <div class="form-group">
                                      <label>Tanggal Keluar Bahan</label>
                                      <input type="text" class="form-control" name="tgl" value="<?php echo $row->tgl_arus?>" required>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label>Kategori</label>
                                    <select id="kategori" name="kategori" class="form-control" required>
                                      <!-- <option value="" >-Pilih-</option> -->
                                      <option value="prasarana" <?php if($row->kategori == "prasarana"){echo "selected";}?>>Prasarana dan Sarana</option>
                                      <option value="unit" <?php if($row->kategori == "unit"){echo "selected";}?>>Unit</option>
                                      <option value="tambahanbangunan" <?php if($row->kategori == "tambahanbangunan"){echo "selected";}?>>Tambahan Bangunan</option>
                                      <option value="lainnya" <?php if($row->kategori == "lainnya"){echo "selected";}?>>Lainnya</option>
                                    </select>
                                  </div>

                                  <div class="kat" id="unit" <?php if($row->kategori != "unit"){ echo "style='display: none'";}?>>
                                    <div class="form-group">
                                        <label>Perumahan</label>
                                        <select name="perumahan" id="outpost" class="form-control" <?php if($row->kategori == "unit"){ echo "required";}?>>
                                          <?php 
                                            // if($row->kategori == "prasarana"){
                                            foreach($this->db->get('perumahan')->result() as $prmh){
                                              echo "<option";
                                              if($row->kode_perumahan == $prmh->kode_perumahan){
                                                echo " selected";
                                              }
                                              echo " value='$prmh->kode_perumahan'>$prmh->nama_perumahan</option>";
                                            }
                                          // } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No Unit</label>
                                        <select name="no_unit" id="response" class="form-control" <?php if($row->kategori == "unit"){ echo "required";}?>>
                                          <?php 
                                            // $this->db->order_by('no_psjb', 'ASC');
                                            $query = $this->db->get_where('kbk', array('kode_perumahan'=>$row->kode_perumahan, 'status'=>"approved"))->result();

                                            // Display city dropdown based on country name
                                            // echo "<label>City:</label>";
                                            // echo "<select>";
                                            // echo "<option value=''>A</option>";
                                            foreach($query as $value){
                                                // $arr = array($value->no_kavling);
                                                // $str = $value->no_kavling;
                                                // foreach($this->db->get_where('kbk', array('no_psjb'=>$value->psjb))->result() as $rmh){
                                                  // echo ", ".$rmh->kode_rumah;
                                                  // if($row->no_unit == $value->no_kavling){
                                                    // array_push($arr, $rmh->kode_rumah);
                                                  // }
                                                // }
                                                echo "<option ";
                                                // print_r($arr);
                                                // implode(", ", $arr);
                                                if($row->no_unit == $value->unit){
                                                  echo "selected";
                                                }
                                                echo " value='$value->unit'>$value->unit</option>";

                                                // $as = $value->psjb;
                                            }
                                            // echo "</select>";
                                          ?>
                                        </select>
                                        <?php 
                                          // print_r($this->db->get_where('rumah', array('no_psjb'=>1))->result());
                                          // echo $as?>
                                    </div>
                                  </div>

                                  <div class="kat" id="prasarana" <?php if($row->kategori != "prasarana"){ echo "style='display: none'";}?>>
                                    <div class="form-group">
                                        <label>Perumahan</label>
                                        <select name="perumahan2" id="outpost2" class="form-control" <?php if($row->kategori == "prasarana"){ echo "required";}?>>
                                            <?php foreach($this->db->get('perumahan')->result() as $pr1){
                                              echo "<option ";
                                              if($row->kode_perumahan == $pr1->kode_perumahan){
                                                echo "selected";
                                              }
                                              echo " value='$pr1->kode_perumahan'>$pr1->nama_perumahan</option>";
                                            }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kawasan</label>
                                        <select name="no_unit2" id="response2" class="form-control" <?php if($row->kategori == "prasarana"){ echo "required";}?>>
                                          <option value="" disabled selected>-Pilih-</option>
                                          <?php foreach($this->db->get_where('kawasan', array('kode_perumahan'=>$row->kode_perumahan))->result() as $unit2){
                                            echo "<option ";
                                            if($row->no_unit == $unit2->id_kawasan){
                                              echo "selected";
                                            }
                                            echo " value='$unit2->id_kawasan'>$unit2->nama</option>";
                                          }?>
                                        </select>
                                    </div>
                                  </div>

                                  <div class="kat" id="tambahanbangunan" <?php if($row->kategori != "tambahanbangunan"){ echo "style='display: none'";}?>>
                                    <div class="form-group">
                                        <label>Perumahan</label>
                                        <select name="perumahan_borongan" id="borongan" class="form-control">
                                            <option value="" selected>-Pilih-</option>
                                            <?php foreach($this->db->get('perumahan')->result() as $pr2){
                                              echo "<option ";
                                              if($row->kode_perumahan == $pr2->kode_perumahan){
                                                echo "selected";
                                              }
                                              echo " value='$pr2->kode_perumahan'>$pr2->nama_perumahan</option>";
                                            }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No Unit</label>
                                        <select name="no_unit_borongan" id="responseBorongan" class="form-control">
                                          <option value="" selected>-Pilih-</option>
                                          <?php 
                                            foreach($this->db->get_where('kbk', array('kode_perumahan'=>$row->kode_perumahan, 'status'=>"approved"))->result() as $units){
                                              echo "<option ";
                                              if($row->no_unit == $units->unit){
                                                echo "selected";
                                              }
                                              echo " value='$units->unit'>$units->unit</option>";
                                            }
                                          ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <select name="id_kontrak" id="kerjaBorongan" class="form-control">
                                          <option value="" selected>-Pilih-</option>
                                          <?php 
                                            foreach($this->db->get_where('kbk_kontrak_kerja', array('id_kontrak'=>$row->id_kontrak_tb))->result() as $pkr){
                                              echo "<option ";
                                              if($row->id_kontrak_tb == $pkr->id_kontrak){
                                                echo "selected";
                                              }
                                              echo " value='$pkr->id_kontrak'>$pkr->pekerjaan_ket</option>";
                                            }
                                          ?>
                                        </select>
                                    </div>
                                  </div>

                                  <div class="kat" id="lainnya" <?php if($row->kategori != "lainnya"){ echo "style='display: none'";}?>>
                                    <div class="form-group">
                                      <label>Perumahan</label>
                                      <select class="form-control" id="perumahanLainnya" name="perumahan_lainnya">
                                        <option value="" selected>-Pilih-</option>
                                        <?php foreach($this->db->get('perumahan')->result() as $pr){
                                          echo "<option ";
                                          if($row->kode_perumahan == $pr->kode_perumahan){
                                            echo "selected";
                                          }
                                          echo " value='$pr->kode_perumahan'>$pr->nama_perumahan</option>";
                                        }?>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                      <label>Yang Menerima Bahan</label>
                                      <input type="text" class="form-control" name="nama_penerima" value="<?php echo $row->nama_pengambil?>" placeholder="Penerima" required>
                                  </div>
                                  <div class="form-group">
                                      <label>Keterangan</label>
                                      <textarea class="form-control" name="keterangan" value="" placeholder="Keterangan" required><?php echo $row->keterangan?></textarea>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Informasi Bahan
                                  </div> <br>
                                  <div class="row">
                                      <div class="col-sm-6 form-group">
                                          <label>Bahan</label>
                                          <select name="nama_bahan" id="namaBahan" class="form-control" required>
                                              <option value="" disabled selected>-Pilih-</option>
                                              <?php 
                                              $this->db->order_by('nama_data', "ASC");
                                              foreach($this->db->get_where('produksi_master_data', array('kategori'=>"barang"))->result() as $brg){
                                                echo "<option ";
                                                if($row->nama_barang == $brg->nama_data){
                                                  echo "selected";
                                                }  
                                                echo " value='$brg->nama_data'>$brg->nama_data</option>";
                                              }?>
                                          </select>
                                      </div>
                                      <div class="col-sm-6 form-group">
                                          <label>Satuan</label>
                                          <input type="text" class="form-control" name="nama_satuan" id="response1" value="<?php echo $row->nama_satuan?>" readonly>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label>Qty</label>
                                      <input type="number" step="0.01" value="<?php echo $row->qty?>" name="qty" class="form-control" required>
                                  </div>
                              </div>
                          </div>
                      <?php }?>
                    </div>  
                  </div>
                </div>
                <div class="card-footer">
                  <!-- <input type="hidden" value="<?php echo $no?>" id="check"> -->
                  <!-- <input type="hidden" value="<?php echo $id?>" name="kode_perumahan"> -->
                  <input type="hidden" value="<?php echo $id?>" name="id">
                  <input type="hidden" value="<?php echo $kode?>" name="kode">
                  <input type="hidden" value="<?php echo $row->jenis_arus?>" name="jenis_arus">
                  <?php if(isset($succ_msg)){?>
                      <div style="color: green"><?php echo $succ_msg?></div>
                  <?php }?>
                  <input type="submit" value="Tambah" class="btn btn-success btn-flat">
                </div>
                </form>
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
    <?php }} else {?>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                  <a class="btn btn-info btn-sm btn-flat" href="<?php echo base_url()?>Dashboard/view_rekap_arus_stok">Menuju Rekap Stok</a>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <?php if(isset($in_stok)){?>
                        <form action="<?php echo base_url()?>Dashboard/add_stok_masuk" method="POST">
                          <div class="col-12 row">
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Data Flow
                                  </div> <br>
                                  <div class="form-group">
                                      <label>Tanggal Masuk Bahan</label>
                                      <input type="date" class="form-control" name="tgl" value="<?php echo date('Y-m-d')?>" readonly required>
                                  </div>
                                  <div class="form-group">
                                      <label>Perumahan</label>
                                      <select name="perumahan" class="form-control" required>
                                          <option value="" disabled selected>-Pilih-</option>
                                          <?php foreach($this->db->get('perumahan')->result() as $pr){?>
                                              <option value="<?php echo $pr->kode_perumahan?>"><?php echo $pr->nama_perumahan?></option>
                                          <?php }?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Informasi Bahan
                                  </div> <br>
                                  <div class="row">
                                      <div class="col-sm-6 form-group">
                                          <label>Bahan</label>
                                          <select name="nama_bahan" id="namaBahan" class="form-control" required>
                                              <option value="" disabled selected>-Pilih-</option>
                                              <?php 
                                              $this->db->order_by('nama_data', "ASC");
                                              foreach($this->db->get_where('produksi_master_data', array('kategori'=>"barang"))->result() as $brg){?>
                                                  <option value='<?php echo $brg->nama_data?>'><?php echo $brg->nama_data?></option>
                                              <?php }?>
                                          </select>
                                      </div>
                                      <div class="col-sm-6 form-group">
                                          <label>Satuan</label>
                                          <input type="text" id="response1" name="nama_satuan" class="form-control" readonly>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label>Nama Toko</label>
                                      <select name="nama_toko" class="form-control" required>
                                          <option value="" disabled selected>-Pilih-</option>
                                          <?php 
                                          $this->db->order_by('nama_data', "ASC");
                                          foreach($this->db->get_where('produksi_master_data', array('kategori'=>"toko"))->result() as $toko){?>
                                              <option value="<?php echo $toko->nama_data?>"><?php echo $toko->nama_data?></option>
                                          <?php }
                                          foreach($this->db->get_where('perumahan')->result() as $pers){?>
                                            <option value="<?php echo $pers->kode_perumahan?>"><?php echo $pers->nama_perumahan?></option>
                                          <?php }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label>Qty</label>
                                      <input type="number" value="" step="0.01" name="qty" class="form-control" required>
                                  </div>
                              </div>
                          </div>
                      <?php }else {?>
                        <form action="<?php echo base_url()?>Dashboard/add_stok_keluar" method="POST">
                          <div class="col-12 row">
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Data Flow
                                  </div> <br>
                                  <div class="form-group">
                                      <label>Tanggal Keluar Bahan</label>
                                      <input type="date" class="form-control" name="tgl" value="<?php echo date('Y-m-d')?>" readonly required>
                                  </div>
                                  <div class="form-group">
                                    <label>Kategori</label>
                                    <select id="kategori" name="kategori" class="form-control" required>
                                      <option value="" disabled selected>-Pilih-</option>
                                      <option value="prasarana">Prasarana dan Sarana</option>
                                      <option value="unit">Unit</option>
                                      <option value="tambahanbangunan">Tambahan Bangunan</option>
                                      <option value="lainnya">Lainnya</option>
                                    </select>
                                  </div>

                                  <div class="kat" id="prasarana" style="display: none">
                                    <div class="form-group">
                                        <label>Perumahan</label>
                                        <select name="perumahan2" id="outpost2" class="form-control">
                                            <option value="" selected>-Pilih-</option>
                                            <?php foreach($this->db->get('perumahan')->result() as $pr){?>
                                                <option value="<?php echo $pr->kode_perumahan?>"><?php echo $pr->nama_perumahan?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Prasarana dan Sarana</label>
                                        <select name="no_unit2" id="response2" class="form-control">
                                          <option value="" selected>-Pilih-</option>
                                        </select>
                                    </div>
                                  </div>

                                  <div class="kat" id="unit" style="display: none">
                                    <div class="form-group">
                                        <label>Perumahan</label>
                                        <select name="perumahan" id="outpost" class="form-control">
                                            <option value="" selected>-Pilih-</option>
                                            <?php foreach($this->db->get('perumahan')->result() as $pr){?>
                                                <option value="<?php echo $pr->kode_perumahan?>"><?php echo $pr->nama_perumahan?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No Unit</label>
                                        <select name="no_unit" id="response" class="form-control">
                                          <option value="" selected>-Pilih-</option>
                                        </select>
                                    </div>
                                  </div>

                                  <div class="kat" id="tambahanbangunan" style="display: none">
                                    <div class="form-group">
                                        <label>Perumahan</label>
                                        <select name="perumahan_borongan" id="borongan" class="form-control">
                                            <option value="" selected>-Pilih-</option>
                                            <?php foreach($this->db->get('perumahan')->result() as $pr){?>
                                                <option value="<?php echo $pr->kode_perumahan?>"><?php echo $pr->nama_perumahan?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No Unit</label>
                                        <select name="no_unit_borongan" id="responseBorongan" class="form-control">
                                          <option value="" selected>-Pilih-</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <select name="id_kontrak" id="kerjaBorongan" class="form-control">
                                          <option value="" selected>-Pilih-</option>
                                        </select>
                                    </div>
                                  </div>

                                  <div class="kat" id="lainnya" style="display: none">
                                    <div class="form-group">
                                      <label>Perumahan</label>
                                      <select class="form-control" id="perumahanLainnya" name="perumahan_lainnya">
                                        <option value="" selected>-Pilih-</option>
                                        <?php foreach($this->db->get('perumahan')->result() as $pr){?>
                                            <option value="<?php echo $pr->kode_perumahan?>"><?php echo $pr->nama_perumahan?></option>
                                        <?php }?>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                      <label>Yang Menerima Bahan</label>
                                      <input type="text" class="form-control" name="nama_penerima" value="" placeholder="Penerima" required>
                                  </div>
                                  <div class="form-group">
                                      <label>Keterangan</label>
                                      <textarea class="form-control" name="keterangan" value="" placeholder="Keterangan" required></textarea>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div style="padding-bottom: 10px; padding-top: 10px; background-color: lightblue; text-align: center; margin-left: 10px; margin-right: 10px">
                                      Informasi Bahan
                                  </div> <br>
                                  <div class="row">
                                      <div class="col-sm-6 form-group">
                                          <label>Bahan</label>
                                          <select name="nama_bahan" id="namaBahan" class="form-control" required>
                                              <option value="" disabled selected>-Pilih-</option>
                                              <?php 
                                              $this->db->order_by('nama_data', "ASC");
                                              foreach($this->db->get_where('produksi_master_data', array('kategori'=>"barang"))->result() as $brg){?>
                                                  <option value='<?php echo $brg->nama_data?>'><?php echo $brg->nama_data?></option>
                                              <?php }?>
                                          </select>
                                      </div>
                                      <div class="col-sm-6 form-group">
                                          <label>Satuan</label>
                                          <input type="text" id="response1" name="nama_satuan" class="form-control" readonly>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label>Qty</label>
                                      <input type="number" value="" step="0.01" name="qty" class="form-control" required>
                                  </div>
                              </div>
                          </div>
                      <?php }?>
                    </div>  
                  </div>
                </div>
                <div class="card-footer">
                  <!-- <input type="hidden" value="<?php echo $no?>" id="check"> -->
                  <!-- <input type="hidden" value="<?php echo $id?>" name="kode_perumahan"> -->
                  <?php if(isset($succ_msg)){?>
                      <div style="color: green"><?php echo $succ_msg?></div>
                  <?php }?>
                  <input type="submit" value="Tambah" class="btn btn-success btn-flat">
                </div>
                </form>
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
    <?php }?>
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

  $('#kategori').on("change", function(){
    // var ch = $(this).val();

    $('.kat').hide();
    $('#'+$(this).val()).show();

    if($(this).val() == "unit"){
      $('#outpost').attr('required', 'required');
      $('#response').attr('required', 'required');

      $('#outpost2').removeAttr('required');
      $('#response2').removeAttr('required');

      $('#borongan').removeAttr('required');
      $('#responseBorongan').removeAttr('required');
      $('#kerjaBorongan').removeAttr('required');

      $('#perumahanLainnya').removeAttr('required');
    } else if($(this).val() == "tambahanbangunan") {
      $('#borongan').attr('required', 'required');
      $('#responseBorongan').attr('required', 'required');
      $('#kerjaBorongan').attr('required', 'required');

      $('#outpost').removeAttr('required');
      $('#response').removeAttr('required');

      $('#outpost2').removeAttr('required');
      $('#response2').removeAttr('required');

      $('#perumahanLainnya').removeAttr('required');
    } else if($(this).val() == "prasarana") {
      $('#outpost2').attr('required', 'required');
      $('#response2').attr('required', 'required');

      $('#outpost').removeAttr('required');
      $('#response').removeAttr('required');

      $('#borongan').removeAttr('required');
      $('#responseBorongan').removeAttr('required');
      $('#kerjaBorongan').removeAttr('required');
      
      $('#perumahanLainnya').removeAttr('required');
    } else {
      $('#perumahanLainnya').attr('required','required');

      $('#outpost2').removeAttr('required');
      $('#response2').removeAttr('required');

      $('#outpost').removeAttr('required');
      $('#response').removeAttr('required');

      $('#borongan').removeAttr('required');
      $('#responseBorongan').removeAttr('required');
      $('#kerjaBorongan').removeAttr('required');
    }
  })

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

  $(function () {
    var check = $('#check').val();

    for (var i = 1; i <= check; i++) {
        (function (i) {
            $('input[id$="volume' + i + '"]').on("input", function () {
              var volume = $(this).val();
              var satuan = $('#satuan'+i).val();
              var hargaSatuan = $('#hargaSatuan'+i).val();

              if(satuan == "%"){
                var total = (volume * hargaSatuan)/100;
              } else {
                var total = volume * hargaSatuan;
              }

              $('#subJumlah'+i).val(total);
            });
        })(i);
    }
  });

  $(function () {
    var check = $('#check').val();

    for (var i = 1; i <= check; i++) {
        (function (i) {
            $('input[id$="hargaSatuan' + i + '"]').on("input", function () {
              var volume = $('#volume'+i).val();
              var satuan = $('#satuan'+i).val();
              var hargaSatuan = $(this).val();

              if(satuan == "%"){
                var total = (volume * hargaSatuan)/100;
              } else {
                var total = volume * hargaSatuan;
              }

              $('#subJumlah'+i).val(total);
            });
        })(i);
    }
  });

  $(document).ready(function(){
    $("select#outpost").change(function(){
        var selectedCountry = $("#outpost option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_unit",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response").html(data);
        });
    });
    
    $("select#outpost2").change(function(){
        var selectedCountry = $("#outpost2 option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_sarana",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response2").html(data);
        });
    });
    
    $("select#borongan").change(function(){
      $('#kerjaBorongan').html("<option value='' disabled selected>-Pilih-</option>");
      var selectedCountry = $("#borongan option:selected").val();
      $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>Dashboard/get_unit",
          data: { country : selectedCountry } 
      }).done(function(data){
          $("#responseBorongan").html(data);
      });
    });

    $('select#responseBorongan').change(function(){
      var kodePerumahan = $('#borongan option:selected').val();
      var kontrak = $(this).val();
      $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>Dashboard/get_unit_tambahan_bangunan",
          data: { kontrak: kontrak, kodePerumahan: kodePerumahan } 
      }).done(function(data){
          $("#kerjaBorongan").html(data);
      });
    })

    $("select#namaBahan").change(function(){
        var selectedCountry = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>Dashboard/get_satuan",
            data: { country : selectedCountry } 
        }).done(function(data){
            $("#response1").val(data);
        });
    });
});
</script>
</body>
</html>
