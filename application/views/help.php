<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPMS Help Page</title>
    <link rel="icon" href="<?php echo base_url()?>/gambar/MSGLOGO.png" type = "image/x-icon">

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
</head>
<body>
    <div class="container-fluid">
        <?php if($this->session->userdata('role') == "staff kasir"){?>
            <a class="btn btn-danger" style="margin-top: 10px; margin-bottom: 10px" href="<?php echo base_url()?>Kasir">Back to dashboard</a>
        <?php } else if($this->session->userdata('role') == "staff checker"){?>
            <a class="btn btn-danger" style="margin-top: 10px; margin-bottom: 10px" href="<?php echo base_url()?>Kasir/check_air">Back to dashboard</a>
        <?php } else {?>
            <a class="btn btn-danger" style="margin-top: 10px; margin-bottom: 10px" href="<?php echo base_url()?>Dashboard">Back to dashboard</a>
        <?php }?>

        <div class="card">
            <div class="card-header" style="background-color: lightyellow">
                <h4>DPMS Help Page - Table of Contents</h4>
            </div> 
            <div class="card-body">
                <table class="table table-bordered table-striped" id="example1">
                    <thead style="text-align: center">
                        <td>Role</td>
                        <td>Problem / Solution</td>
                        <td>File</td>
                    </thead>
                    <tbody>
                        <!-- ALL USER -->
                        <tr>
                            <td style="text-align: center">All User</td>
                            <td>Penggantian Password (WAJIB - Akun pada saat awal diberi)</td>
                            <td><a href="<?php echo base_url()?>asset/help/Dokumentasi - Perubahan Profil Pribadi.pdf" download><i class="fas fa-download"></i> Download (.pdf <i class="fas fa-file-pdf">)</i></a></td>
                        </tr>
                        <!-- END OF ALL USER -->

                        <!-- SUPERADMIN -->
                        <tr>
                            <td rowspan=11 style="text-align: center; vertical-align: middle">Super Admin</td>
                            <td>Master Data - User Management</td>
                            <td><a href="<?php echo base_url()?>asset/help/Dokumentasi - Dokumentasi - Superadmin (master data-user management).pdf" download><i class="fas fa-download"></i> Download (.pdf <i class="fas fa-file-pdf">)</i></a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Bank Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Perusahaan Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Perumahan Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Kavling Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Siteplan</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Kawasan Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Notaris Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Sub Kontraktor Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Neraca Saldo Awal Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <tr>
                            <td>Master Data - Kontrol Budget Management</td>
                            <td><a>File</a></td>
                        </tr>
                        <!-- END OF SUPERADMIN -->

                        <!-- ADMINISTRASI -->
                        <tr>
                            <td style="text-align: center; vertical-align: middle">Administrasi / Super Admin</td>
                            <td>Instruksi PSJB - PPJB - Surat Perjanjian Kavling - Daftar Balik Nama</td>
                            <td><a>File</a></td>
                        </tr>
                        <!-- END OF ADMINISTRASI -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <footer class="main-footer" style="margin-left: -10px; margin-right: -10px; background-color: lightblue; color: black">
            <div class="float-right d-none d-sm-block">
            <b>Coded by</b> <a href="https://www.instagram.com/jazen4p/">Jasen Aprian Putra</a> For <a href="http://msgroup.co.id/">MS Group</a>
            </div>
            <strong>Copyright &copy; 2020 MS Group.</strong> All rights
            reserved.
        </footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
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
    
    <script>
        $(function () {
            $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "scrollX": true
            });
        });
    </script>
</body>
</html>