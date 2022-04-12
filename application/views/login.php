<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Login DPMS MSGroup</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>/assets/css/matrix-login.css" />
        <link href="<?php echo base_url()?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <link rel="icon" href="<?php echo base_url()?>/gambar/MSGLOGO.png" type = "image/x-icon">

    </head>
    <body>
        <div id="loginbox">            
            <form action="<?php echo base_url()?>Login" method="POST">
                <div class="control-group normal_text"> 
                    <h3>
                        <img src="<?php echo base_url()?>gambar/MSGLOGO.png" style="width: 120px; height: 100px; padding: 10px" alt="Logo" />
                    </h3>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" name="username" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php if(isset($log_err)){
                                echo '<span style="color: red">'.$log_err.'</span>';
                            }
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <!-- <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span> -->
                    <span class="pull-right"><input type="submit" class="btn btn-success" value="Login" /></span>
                </div>
            </form>
            <!-- <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                </div>
            </form> -->
        </div>
        
        <script src="<?php echo base_url()?>/assets/js/jquery.min.js"></script>  
        <script src="<?php echo base_url()?>/assets/js/matrix.login.js"></script> 
    </body>

</html>
