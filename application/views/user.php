<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | DataTables</title>
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
</head>
<body class="hold-transition sidebar-mini">
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
            <h1>User Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if(isset($edit_user)) {
        foreach($edit_user as $row){?>
        <section class="content">
          <div class="container-fluid">
              <div class="row">
              <!-- left column -->
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="card card-primary">
                  <!-- /.card-header -->
                  <!-- form start -->
                      <div class="card-body">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#home">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#menu1">Change Password</a>
                            </li>
                            <!-- <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#menu2">Menu 2</a>
                            </li> -->
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="home" class="container tab-pane active"><br>
                            <h3 style="background-color: lightblue; padding-left: 5px; padding-top: 5px; padding-bottom: 5px">Profile</h3>
                            <form role="form" action="<?php echo base_url()?>Dashboard/edit_user" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Gambar Profil</label>
                                            <div class="form-group">
                                                <?php if($row->file_name != ""){?>
                                                    <img src="<?php echo base_url()?>gambar/<?php echo $row->file_name?>" style="width: 180px; height: 200px" alt="Profile Picture">
                                                <?php } else {?>
                                                    <img src="<?php echo base_url()?>asset/dist/img/default-150x150.png" style="width: 150px; height: 150px">
                                                <?php }?>
                                            </div>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="exampleInputFile" name="berkas" />
                                                    <!-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> -->
                                                    <input type="hidden" name="old" value="<?php echo $row->file_name?>">
                                                    <input type="hidden" name="id" value="<?php echo $id?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo $row->username?>" readonly>
                                            <!-- <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $row->username?>" required> -->
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" placeholder="***" name="password" value="<?php echo $row->password?>" required>
                                        </div> -->
                                        <!-- <div class="input-group mb-3">
                                            <input type="password" name="password" value="<?php echo $row->password?>" class="form-control">
                                            <div class="input-group-append">
                                                <input type><i class="fas fa-check"></i></span>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Nama Pribadi</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Pribadi" name="nama_pribadi" value="<?php echo $row->nama?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Jenis Kelamin</label>
                                            <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kecamatan" name="kecamatan" required> -->
                                            <select class="form-control" id="exampleInputEmail1" placeholder="" value="<?php echo $row->jenis_kelamin?>" name="jenis_kelamin" required>
                                                <?php if($row->jenis_kelamin == "Laki-Laki"){?>
                                                    <option value="Laki-Laki" selected>Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                <?php } else {?>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                    <option value="Perempuan" selected>Perempuan</option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Alamat</label>
                                            <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kecamatan" name="kecamatan" required> -->
                                            <textarea class="form-control" placeholder="Alamat" name="alamat" value=""><?php echo $row->alamat?></textarea>
                                            <!-- <input type="text" style="height: 100px;" name="alamat" value="<?php echo $row->alamat?>" class="form-control" /> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">No. Telp</label>
                                            <input type="number" class="form-control" id="exampleInputPassword1" placeholder="No. Telp" name="telp" value="<?php echo $row->telp?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Email</label>
                                            <input type="email" class="form-control" id="exampleInputPassword1" placeholder="@" name="email" value="<?php echo $row->email?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Status</label>
                                            <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="provinsi" required> -->
                                            <?php if($this->session->userdata('role')!="superadmin"){?>
                                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="status" value="<?php echo $row->status?>" readonly>
                                            <?php } else {?>
                                                <select class="form-control" id="exampleInputPassword1" placeholder="" name="status" value="<?php echo $row->status?>" required>
                                                    <?php if($row->status == "active"){?>
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">De-active</option>
                                                    <?php } else {?>
                                                        <option value="active">Active</option>
                                                        <option value="inactive" selected>De-active</option>
                                                    <?php }?>
                                                </select>
                                            <?php }?>
                                        </div>
                                        <?php if($this->session->userdata('role')=="superadmin"){?>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Role</label>
                                                <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="provinsi" required> -->
                                                <select class="form-control" id="exampleInputPassword1" placeholder="" name="role" required>
                                                    <?php if($row->role == "superadmin"){?>
                                                        <option value="superadmin" selected>Superadmin</option>
                                                        <option value="manager marketing">Manager Marketing</option>
                                                        <option value="manager keuangan">Manager Keuangan</option>
                                                        <option value="manager produksi">Manager Produksi</option>
                                                        <option value="kepala admin">Kepala Admin</option>
                                                        <option value="staff marketing">Staff Marketing</option>
                                                        <option value="staff admin">Staff Admin</option>
                                                        <option value="staff admin penagihan">Staff Admin Penagihan</option>
                                                        <option value="accounting">Accounting</option>
                                                        <option value="staff purchasing">Staff Purchasing</option>
                                                        <option value="admin inventory">Admin Inventory</option>
                                                        <option value="qc">QC</option>
                                                        <option value="staff checker">Staff Checker Air</option>
                                                        <option value="staff kasir">Kasir</option>
                                                    <?php } else {?>
                                                        <option value="superadmin">Superadmin</option>
                                                        <option value="manager marketing" <?php if($row->role == "manager marketing"){echo "selected";}?>>Manager Marketing</option>
                                                        <option value="manager keuangan" <?php if($row->role == "manager keuangan"){echo "selected";}?>>Manager Keuangan</option>
                                                        <option value="manager produksi" <?php if($row->role == "manager produksi"){echo "selected";}?>>Manager Produksi</option>
                                                        <option value="kepala admin" <?php if($row->role == "kepala admin"){echo "selected";}?>>Kepala Admin</option>
                                                        <option value="staff marketing" <?php if($row->role == "staff marketing"){echo "selected";}?>>Staff Marketing</option>
                                                        <option value="staff admin" <?php if($row->role == "staff admin"){echo "selected";}?>>Staff Admin</option>
                                                        <option value="staff admin penagihan" <?php if($row->role == "staff admin penagihan"){echo "selected";}?>>Staff Admin Penagihan</option>
                                                        <option value="accounting" <?php if($row->role == "accounting"){echo "selected";}?>>Accounting</option>
                                                        <option value="staff purchasing" <?php if($row->role == "staff purchasing"){echo "selected";}?>>Staff Purchasing</option>
                                                        <option value="admin inventory" <?php if($row->role == "admin inventory"){echo "selected";}?>>Admin Inventory</option>
                                                        <option value="qc" <?php if($row->role == "qc"){echo "selected";}?>>QC</option>
                                                        <option value="staff checker" <?php if($row->role == "staff checker"){echo "selected";}?>>Staff Checker Air</option>
                                                        <option value="staff kasir" <?php if($row->role == "staff kasir"){echo "selected";}?>>Kasir</option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        <?php } else {?>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Role</label>
                                                <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="provinsi" required> -->
                                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="role" value="<?php echo $row->role?>" readonly>
                                            </div>
                                        <?php }?>
                                    </div>
                                <!-- </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div> -->
                                </div>
                            <!-- /.card-body -->

                                <div class="card-footer">
                                        <?php if(isset($succ_msg)){?>
                                            <span style="color: green"><?php echo $succ_msg?></span>
                                        <?php }?>
                                    <input type="submit" class="btn btn-primary" value="Update" />
                                    <?php if($this->session->userdata('role')=="superadmin"){?>
                                        <a href="<?php echo base_url()?>Dashboard/user_management" class="btn btn-primary">Tambah Baru</a>
                                    <?php }?>
                                </div>
                            </div>
                            </form>

                            <div id="menu1" class="container tab-pane fade"><br>
                            <h3 style="background-color: lightblue; padding-left: 5px; padding-top: 5px; padding-bottom: 5px">Ubah Password</h3>
                                <div class="col-md-12">
                                    <form role="form" action="<?php echo base_url()?>Dashboard/edit_password_user" method="post">
                                        <div class="">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Password lama</label>
                                                    <input type="password" class="form-control" name="pass_lama">
                                                </div>
                                                <div class="form-group">
                                                    <label>Password baru</label>
                                                    <input type="password" class="form-control" name="pass_baru">
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <?php if(isset($pass_alert)){?>
                                                    <span style="color: red"><?php echo $pass_alert?></span><br>
                                                <?php } else if(isset($pass_succ_alert)){?>
                                                    <span style="color: green"><?php echo $pass_succ_alert?></span><br>
                                                <?php }?>
                                                <input type="hidden" name="id" value="<?php echo $row->id?>">
                                                <input class="btn btn-success btn-sm" type="submit" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- <div id="menu2" class="container tab-pane fade"><br>
                            <h3>Menu 2</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                            </div> -->
                        </div>
                          
                  </div>
                  <!-- /.card -->
                </div>
                
              </div>
              <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
    <?php }} else {?>
        <section class="content">
          <div class="container-fluid">
              <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="card card-primary">
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" action="<?php echo base_url()?>Dashboard/add_user" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#home">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" data-toggle="pill" href="#menu1">Change Password</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#menu2">Menu 2</a>
                            </li> -->
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="home" class="container tab-pane active"><br>
                                <h3 style="background-color: lightblue; padding-left: 5px; padding-top: 5px; padding-bottom: 5px">Profile</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Gambar Profil</label>
                                                <div>
                                                    <img src="<?php echo base_url()?>asset/dist/img/default-150x150.png" style="width: 150px; height: 150px">
                                                </div> <br>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control" id="exampleInputFile" name="berkas">
                                                        <!-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Username</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" name="username" value="<?php ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="***" name="password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Nama Pribadi</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Pribadi" name="nama_pribadi" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jenis Kelamin</label>
                                                <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kecamatan" name="kecamatan" required> -->
                                                <select class="form-control" id="exampleInputEmail1" placeholder="" name="jenis_kelamin" required>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Alamat</label>
                                                <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kecamatan" name="kecamatan" required> -->
                                                <textarea class="form-control" placeholder="Alamat" name="alamat"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">No. Telp</label>
                                                <input type="number" class="form-control" id="exampleInputPassword1" placeholder="No. Telp" name="telp">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="email" class="form-control" id="exampleInputPassword1" placeholder="@" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Status</label>
                                                <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="provinsi" required> -->
                                                <select class="form-control" id="exampleInputPassword1" placeholder="" name="status" required>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">De-active</option>
                                                </select>
                                            </div>
                                            <?php if($this->session->userdata('role')=="superadmin"){?>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Role</label>
                                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="provinsi" required> -->
                                                    <select class="form-control" id="exampleInputPassword1" placeholder="" name="role" required>
                                                        <option value="superadmin">Superadmin</option>
                                                        <option value="manager marketing">Manager Marketing</option>
                                                        <option value="manager keuangan">Manager Keuangan</option>
                                                        <option value="manager produksi">Manager Produksi</option>
                                                        <option value="kepala admin">Kepala Admin</option>
                                                        <option value="staff marketing">Staff Marketing</option>
                                                        <option value="staff admin">Staff Admin</option>
                                                        <option value="staff admin penagihan">Staff Admin Penagihan</option>
                                                        <option value="accounting">Accounting</option>
                                                        <option value="staff purchasing">Staff Purchasing</option>
                                                        <option value="admin inventory">Admin Inventory</option>
                                                        <option value="qc">QC</option>
                                                        <option value="staff checker">Staff Checker Air</option>
                                                        <option value="staff kasir">Kasir</option>
                                                    </select>
                                                </div>
                                            <?php } else {?>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Role</label>
                                                    <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Provinsi" name="provinsi" required> -->
                                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="role" readonly>
                                                </div>
                                            <?php }?>
                                        </div>
                                    <!-- </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div> -->
                                </div>
                            </div>

                            <div class="card-footer">
                                <?php if(isset($succ_msg)){?>
                                    <span style="color: green"><?php echo $succ_msg?></span>
                                <?php }?>
                                <?php if(isset($err_msg)){?>
                                    <span style="color: red"><?php echo $err_msg?></span>
                                <?php }?>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                                <a href="<?php echo base_url()?>Dashboard/user_management" class="btn btn-primary">Tambah Baru</a>
                            </div>
                            <div id="menu1" class="container tab-pane fade"><br>
                                <h3>Change Password</h3>
                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                            <!-- <div id="menu2" class="container tab-pane fade"><br>
                            <h3>Menu 2</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                            </div> -->
                        </div>
                      <!-- /.card-body -->
                  </form>
                  </div>
                  <!-- /.card -->
              </div>
              <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
    <?php }?>

    <!-- Main content -->
    <?php if($this->session->userdata('role')=="superadmin"){?>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Management</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 14px">
                    <thead>
                        <tr>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Telp</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($user_all as $row){?>
                        <tr>
                        <td><?php echo $row->username?></td>
                        <td><?php echo $row->nama?></td>
                        <td><?php echo $row->telp?></td>
                        <td><?php echo $row->email?></td>
                        <td><?php echo $row->alamat?></td>
                        <td><?php echo $row->status?></td>
                        <td><?php echo $row->role?></td>
                        <td>
                            <a href="<?php echo base_url()?>Dashboard/edit_view_user?id=<?php echo $row->id?>" class="btn btn-default btn-sm">Edit</a>
                            <a href="<?php echo base_url()?>Dashboard/hapus_user?id=<?php echo $row->id?>" class="btn btn-default btn-sm">Hapus</a>
                        </td>
                        </tr>
                        <?php }?>
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
<!-- ./wrapper -->

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
$('[name="Edit"]').on('click', function() {
    var prev = $(this).prev('input'),
        ro   = prev.prop('readonly');
    prev.prop('readonly', !ro).focus();
    $(this).val(ro ? 'Save' : 'Edit');
});
</script>
</body>
</html>
