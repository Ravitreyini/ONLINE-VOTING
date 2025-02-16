<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color:#F1E9D2">
      
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><b>Ballot Position</b></h1>
        <ol class="breadcrumb" style="color:black; font-size: 17px; font-family: Times">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active" style="color:black; font-size: 17px; font-family: Times">Dashboard</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Display messages (Error or Success) -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Error!</h4>
            <?= $_SESSION['error']; ?>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <?= $_SESSION['success']; ?>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Row for content -->
        <div class="row">
          <div class="col-xs-10 col-xs-offset-1" id="content">
            <!-- Dynamic content will be loaded here -->
          </div>
        </div>

      </section>

    </div>
    
    <?php include 'includes/footer.php'; ?>
  </div>

  <?php include 'includes/scripts.php'; ?>

  <script>
    $(function() {
      // Initial fetch to load the ballot data
      fetch();

      // Reset checkboxes when the reset button is clicked
      $(document).on('click', '.reset', function(e) {
        e.preventDefault();
        var desc = $(this).data('desc');
        $('.' + desc).iCheck('uncheck');
      });

      // Move item up in the ballot order
      $(document).on('click', '.moveup', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#'+id).animate({ 'marginTop': "-300px" });

        $.ajax({
          type: 'POST',
          url: 'ballot_up.php',
          data: { id: id },
          dataType: 'json',
          success: function(response) {
            if (!response.error) {
              fetch();
            }
          }
        });
      });

      // Move item down in the ballot order
      $(document).on('click', '.movedown', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#'+id).animate({ 'marginTop': "+300px" });

        $.ajax({
          type: 'POST',
          url: 'ballot_down.php',
          data: { id: id },
          dataType: 'json',
          success: function(response) {
            if (!response.error) {
              fetch();
            }
          }
        });
      });
    });

    // Function to fetch ballot data
    function fetch() {
      $.ajax({
        type: 'POST',
        url: 'ballot_fetch.php',
        dataType: 'json',
        success: function(response) {
          $('#content').html(response).iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
          });
        }
      });
    }
  </script>
</body>
</html>
