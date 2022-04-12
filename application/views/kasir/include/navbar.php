<nav class="main-header navbar navbar-expand navbar-yellow navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <?php if($this->session->userdata('role')=="kasir"){?>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo base_url()?>Kasir" class="nav-link">Home</a>
        </li>
      <?php }?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url()?>Login/logout" class="nav-link">Logout</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li>
          <a class="nav-link" id="time"></a>
      </li>
    </ul>
  </nav>
  
  <script>
        var timeDisplay = document.getElementById("time");
    
        function refreshTime() {
          var dateString = new Date().toLocaleString("en-GB", {timeZone: "Asia/Jakarta"});
          var formattedString = dateString.replace(", ", " - ");
          timeDisplay.innerHTML = formattedString;
        }
        
        setInterval(refreshTime, 1000);
    </script>