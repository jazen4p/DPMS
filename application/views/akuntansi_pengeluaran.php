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
              <h1>POST Pengeluaran</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url()?>Dashboard">Home</a></li>
                <li class="breadcrumb-item active">POST Pengeluaran</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-8">
                  <a href="<?php echo base_url()?>Dashboard/laporan_pengeluaran_akuntansi" class="btn btn-sm btn-success btn-flat">Kembali</a>
                  <button type="button" class="btn btn-sm btn-info btn-flat" data-toggle="modal" data-target=".bd-example-modal-lg">Check</button>
                </div>
                <div class="form-group row col-md-4">
                  <label class="col-sm-6">Balancing:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="nominalKurang" readonly>
                  </div>
                </div>
                <?php if(isset($sendback)){?>
                  <div class="col-md-12"> 
                    <table class="table">
                      <thead>
                        <th>No</th>
                        <th>Catatan Revisi</th>
                        <th>Dibuat Oleh</th>
                        <th>Pada</th>
                      </thead>
                      <tbody>
                        <?php $no=0; foreach($sendback->result() as $sb){?>
                          <tr>
                            <td><?php echo $no?></td>
                            <td><?php echo $sb->catatan?></td>
                            <td><?php echo $sb->created_by?></td>
                            <td><?php echo $sb->date_created?></td>
                          </tr>
                        <?php $no++;}?>
                      </tbody>
                    </table>
                  </div>
                <?php }?>
              </div>
            </div>

            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Check Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body row">
                    <?php foreach($akuntansi->result() as $row){?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Pengeluaran</label>
                            <input type="text" class="form-control" value="<?php echo $row->tgl_pembayaran?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kategori Pengeluaran</label>
                            <?php foreach($this->db->get_where('keuangan_kode_induk_pengeluaran', array('kode_induk'=>$row->kategori_pengeluaran))->result() as $induk){?>
                            <input type="text" class="form-control" value="<?php echo $row->kategori_pengeluaran."-".$induk->nama_induk?>" readonly>
                            <?php }?>
                        </div>
                        <div class="form-group">
                            <label>Jenis Pengeluaran</label>
                            <?php foreach($this->db->get_where('keuangan_kode_pengeluaran', array('kode_pengeluaran'=>$row->jenis_pengeluaran))->result() as $akun){?>
                            <input type="text" class="form-control" value="<?php echo $row->jenis_pengeluaran."-".$akun->nama_pengeluaran?>" readonly>
                            <?php }?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Terima Oleh</label>
                          <input type="text" class="form-control" value="<?php echo $row->terima_oleh?>" readonly>
                        </div>
                        <div class="form-group">
                          <label>Keterangan</label>
                          <textarea class="form-control" readonly><?php echo $row->keterangan?></textarea>
                          <!-- <input type="text" class="form-control" value="<?php echo $row->jenis_terima?>"> -->
                        </div>
                        <div class="form-group">
                          <label>Nominal Pengeluaran</label>
                          <!-- <textarea class="form-control" readonly><?php echo $row->keterangan?></textarea> -->
                          <input type="text" class="form-control" value="<?php echo number_format($row->nominal)?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                  </div>
                </div>
              </div>
            </div>

          <form role="form" method="POST" action="<?php echo base_url()?>Dashboard/add_akuntansi_pengeluaran" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-primary">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-10">
                        <h4>Debet</h4>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn btn-default btn-flat btn-sm add1">+</button>
                        <button type="button" class="btn btn-default btn-flat btn-sm remove1">-</button>
                      </div>
                    </div>
                  </div>
                  <div id="mainDebet">
                  <hr>
                    <div class="card-body" id="addDebet">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-8 form-group">
                              <label class="form-control-label">Nama Akun</label>
                              <select name="nama_akun_debet[]" id="responseDebet" class="form-control selectpicker" required>
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($nama_akun->result() as $anak){?>
                                  <option value="<?php echo $anak->no_akun?>"><?php echo $anak->nama_akun?></option>
                                <?php }?>
                              </select>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Kode Akun</label>
                              <input type="text" class="form-control" id="kodeAkunDebet" name="kode_akun_debet[]" placeholder="Otomatis" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                              <!-- <label>POS</label> -->
                              <input type="hidden" class="form-control" name="pos_debet[]" value="debet" readonly>
                              <!-- <select name="pos" class="form-control" required>
                                <option value="" disabled selected>-Pilih-</option>
                                <option value="Debet">Debet</option>
                                <option value="Kredit">Kredit</option>
                              </select> -->
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <label>Nominal</label>
                              <input type="number" class="form-control nominalDebet" name="nominal_debet[]" id="nominalDebet" required>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="buttonbox1"></div>
                  <input type="hidden" value="" id="total_chq_debet" name="total_chq_debet">
                </div>
              </div>
              <div class="col-md-6">
                <div class="card card-primary">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-10">
                        <h4>Kredit</h4>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn btn-default btn-flat btn-sm add">+</button>
                        <button type="button" class="btn btn-default btn-flat btn-sm remove">-</button>
                      </div>
                    </div>
                  </div>
                  <div id="mainKredit">
                  <hr>
                    <div class="card-body" id="addKredit">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-8 form-group">
                              <label>Nama Akun</label>
                              <select name="nama_akun_kredit[]" id="responseKredit" class="form-control responseKredit" autofocus required>
                                <option value="" disabled selected>-Pilih-</option>
                                <?php foreach($nama_akun->result() as $anak){?>
                                  <option value="<?php echo $anak->no_akun?>"><?php echo $anak->nama_akun?></option>
                                <?php }?>
                              </select>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Kode Akun</label>
                              <input type="text" class="form-control" id="kodeAkunKredit" name="kode_akun_kredit[]" placeholder="Otomatis" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                              <input type="hidden" class="form-control" name="pos_kredit[]" value="Kredit" readonly>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <label>Nominal</label>
                              <input type="number" name="nominal_kredit[]" class="form-control nominalKredit" id="nominalKredit" required>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="buttonbox"></div>
                  <input type="hidden" value="" id="total_chq_kredit" name="total_chq_kredit">
                </div>
              </div>
              <div class="col-md-12">
                <div class="card-footer">
                  <input type="hidden" value="pengeluaran" name="jenis_keuangan">
                  <input type="hidden" value="<?php echo $row->id_pengeluaran?>" name="id">
                  <input type="hidden" value="<?php echo $row->kode_perumahan?>" name="kode_perumahan">
                  <input type="hidden" value="<?php echo $row->tgl_pembayaran?>" name="tanggal_dana">
                              
                  <input type="submit" class="btn btn-sm btn-flat btn-success" value="Tambah">
                </div>
              </div>
            </div>
          </form>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php }?>
    
    
    <?php include "include/footer.php"?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- <form action="<?php echo base_url()?>Dashboard/test" method="POST">
    
    <div class="cloned">
      <input type="text" name="apa[]">
      <input type="text" name="apa2[]">
      <input type="text" name="apa3[]">
    </div>
    <div class="test"></div>
    <button type="button" class="plus">+</button>
    
  </form> -->


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

  <script type="text/javascript">
  // $('.add').on('click', add);
  // $('.remove').on('click', remove);

  // function add() {
  //   var new_chq_no = parseInt($('#total_chq').val()) + 1;
  //   // var new_input = "<input type='text' id='new_" + new_chq_no + "' name='new[]'>";
  //   // $('#addKredit').removeAttr('style');
  //   // var new_input = document.getElementById('addKredit');
  //   var $new_input = $('#addKredit').clone()

  //   // $('#addKredit').clone().appendTo('#new_chq');
  //   $($new_input).appendTo('#new_chq');
  //   // $('#new_chq').html($new_input);

  //   $('#total_chq').val(new_chq_no);
  // }

  // $("#new_chq").on('change', '.changeFields', function() {
      
  //   var $set = $(this).closest('#new_chq'); 
  //   //this is the whole set of inputs
  //   //these get the input values in the set
  //   var categoryName = $set.find('.responseKredit').val();
        
  //   // var chipsTaste = $set.find('.chipsTaste1').val();

  //   // var chipsQty = $set.find('.chipsQty').val();    

  //   // $('#pasteItems').text(categoryName + ' ' + chipsTaste + ' ' + chipsQty);
  //     //do what you need to with the value of the cloned input
  // });

  // function remove() {
  //   var last_chq_no = $('#total_chq').val();

  //   // $('addKredit').attr('style', 'display:none');
  //   var new_input = document.getElementById('addKredit');

  //   if (last_chq_no > 1) {
  //     // $('#new_'+last_chq_no).remove();
  //     $('#new_chq').empty();
  //     $('#total_chq').val(last_chq_no - 1);
  //   }
  // }
  </script>
  <script type="text/javascript">
  // $('.add1').on('click', add);
  // $('.remove1').on('click', remove);

  // function add() {
  //   var new_chq_no = parseInt($('#total_chq1').val()) + 1;
  //   // var new_input = "<input type='text' id='new_" + new_chq_no + "' name='new[]'>";

  //   $('#addDebet').clone().appendTo('#new_chq1');

  //   $('#total_chq1').val(new_chq_no);
  // }

  // function remove() {
  //   var last_chq_no = $('#total_chq1').val();

  //   if (last_chq_no > 1) {
  //     $('#new_chq1').empty();
  //     $('#total_chq1').val(last_chq_no - 1);
  //   }
  // }
  // </script>
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
  $(document).ready(function(){
    $("select.categoryDebet").change(function(){
      var selectedCountry = $(this).val();

      // window.location.href="<?php echo base_url()?>Dashboard/get_anak_akun?id="+selectedCountry;
      // document.getElementById('kodeAkunDebet').value = selectedCountry;
      $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>Dashboard/get_anak_akun",
          data: { country : selectedCountry } 
      }).done(function(data){
          $("#responseDebet").html(data);
      });
    });
    $("select.categoryKredit").change(function(){
      var selectedCountry = $(this).val();

      // window.location.href="<?php echo base_url()?>Dashboard/get_anak_akun?id="+selectedCountry;
      // document.getElementById('kodeAkunDebet').value = selectedCountry;
      $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>Dashboard/get_anak_akun",
          data: { country : selectedCountry } 
      }).done(function(data){
          $("#responseKredit").html(data);
      });
    });
      // $("select.category2").change(function(){
      //     var selectedCountry = $(".category2 option:selected").val();
      //     $.ajax({
      //         type: "POST",
      //         url: "<?php echo base_url()?>Dashboard/get_jenis_pengeluaran",
      //         data: { country : selectedCountry } 
      //     }).done(function(data){
      //         $("#response2").html(data);
      //     });
      // });
  });
  </script>
  <script>
    $(function () {
      $("#date").datepicker();
      $("#checkout").datepicker();
      $('.selectpicker').selectpicker();
    });
    // $(function() {

    function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
      
    // });
    $(document).ready(function () {
      $("input[type='number']").on("input", function(){
        var sumDebet = 0;
        var sumKredit = 0;
        var sum = 0;
        $(".nominalDebet").each(function(){
            sumDebet += +$(this).val();
        });
        $(".nominalKredit").each(function(){
            sumKredit += +$(this).val();
        });
        sum = sumDebet - sumKredit;
        $("#nominalKurang").val(sum);
      });
      // $(".nominalKredit").on("input", function(){
      //   var sumDebet = 0;
      //   var sumKredit = 0;
      //   var sum = 0;
      //   $(".nominalDebet").each(function(){
      //       sumDebet += +$(this).val();
      //   });
      //   $(".nominalKredit").each(function(){
      //       sumKredit += +$(this).val();
      //   });
      //   sum = sumDebet - sumKredit;
      //   $("#nominalKurang").val(sum);
      // });
    });

    // $(document).ready(function(){
    //   var temp = $('#total_chq_kredit').val();
    //   for(i = 1; i <= temp; i++){
    //     $('#mainKredit'+i).find("input[name='nama_akun_kredit[]']").('change', function(){
    //       $('mainKredit'+i).find("input[name='kode_akun_kredit[]']").val($(this).val());
    //     })
    //   }
    // })
    // $(document).ready(function(){
    //   $('#responseKredit').change(function(){
    //     // $('#mainKredit input[name="kode_akun_kredit[]"').val($(this).val());
    //     alert("terganti");
    //   })
    // })
  </script>
  <script type="text/javascript">
  $(document).ready(function() {
    var i = 0;
    var last1 = $('.buttonbox').last();
    $(document).on('click', '.add', function() {
      var clone = $('#mainKredit').clone().find("input").val("").end().find("textarea").val("").end().find('select option:first-child()').attr('selected','selected').end().attr("id", "mainKredit" + ++i).insertBefore(last1);
          
      // $('#main'+i++).attr('id', 'nominalDebet'+i++);
        // clone.id = "main" + i;
      $('#total_chq_kredit').val(i);

      $(function () {
            // var check = $('#check').val();

          for (var x = 1; x <= i; x++) {
          (function (x) {
              $('#mainKredit'+x+' select[id="responseKredit"]').on("change", function () {

                  $('#mainKredit'+x+' input[id="kodeAkunKredit"').val($(this).val());
              });

              $("input[type='number']").on("input", function(){
                var sumDebet = 0;
                var sumKredit = 0;
                var sum = 0;
                $(".nominalDebet").each(function(){
                    sumDebet += +$(this).val();
                });
                $(".nominalKredit").each(function(){
                    sumKredit += +$(this).val();
                });
                sum = sumDebet - sumKredit;
                $("#nominalKurang").val(sum);
              });
          })(x);
          }
      });
    });

    
      $(".remove").click(function(){
        if(i > 0) {
          var total = $('#nominalKurang').val();
          var ch = $('div[id^="mainKredit"]:last .nominalKredit').val();

          $('#nominalKurang').val(parseInt(total) + parseInt(ch));

          $('div[id^="mainKredit"]:last').remove();
          $('#total_chq_kredit').val(--i);
        } 
      });
  });

  $(document).ready(function() {
    var x = 0;
    var last2 = $('.buttonbox1').last();
    $(document).on('click', '.add1', function() {
      var clone2 = $('#mainDebet').clone().find("input").val("").end().find("textarea").val("").end().find('select option:first-child()').attr('selected','selected').end().attr("id", "mainDebet" + ++x).insertBefore(last2);

        //clone.id = "main" + i;
      $('#total_chq_debet').val(x);

      $(function () {
            // var check = $('#check').val();

          for (var i = 1; i <= x; i++) {
          (function (i) {
              $('#mainDebet'+i+' select[id="responseDebet"]').on("change", function () {

                  $('#mainDebet'+i+' input[id="kodeAkunDebet"').val($(this).val());
              });

              $("input[type='number']").on("input", function(){
                var sumDebet = 0;
                var sumKredit = 0;
                var sum = 0;
                $(".nominalDebet").each(function(){
                    sumDebet += +$(this).val();
                });
                $(".nominalKredit").each(function(){
                    sumKredit += +$(this).val();
                });
                sum = sumDebet - sumKredit;
                $("#nominalKurang").val(sum);
              });
          })(i);
          }
      });
    });

    $(".remove1").click(function(){
      if(x>0){
        var total = $('#nominalKurang').val();
        var ch = $('div[id^="mainDebet"]:last .nominalDebet').val();

        $('#nominalKurang').val(parseInt(total) - parseInt(ch));

        $('div[id^="mainDebet"]:last').remove();
        $('#total_chq_debet').val(--x);
      }
    });
  });
  </script>
  <script type="text/javascript">
    // function myFunction(e) {
    //   document.getElementById("kodeAkunDebet").value = e.target.value
    // }
    // function myFunction2(e) {
    //   document.getElementById("kodeAkunKredit").value = e.target.value
    // }

    $('#responseKredit').change(function (){
      $('#kodeAkunKredit').val($(this).val());
    })

    $('#responseDebet').change(function (){
      $('#kodeAkunDebet').val($(this).val());
    })

  </script>
  </body>
  </html>
