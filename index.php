<?php 

ob_start();
session_start();
include "includes/config.php";
include "includes/head.php"; 
include "function/function_tgl_indo.php";
date_default_timezone_set("Asia/Jakarta");

?>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 wrapper">
          <?php include "includes/menu.php"; ?>
          <?php include "includes/header.php"; ?>
          <div class="row">
            <div class="col-md-8">
              <?php
                if (isset($_GET["home"]) || isset($_GET["page"])) {include "includes/latest-post.php";}
                else if (isset($_GET["detail"])) {include "includes/detail.php";}
                else if (isset($_GET["category"]) || isset($_GET["page-category"])) {include "includes/category.php";}
                else if (isset($_GET["search"]) || isset($_GET["page-search"])) {include "includes/search.php";}
                else {include "includes/latest-post.php";}
              ?>
            </div>
            <?php include "includes/aside.php"; ?>
          </div><!-- /row for article -->
          <?php include "includes/footer.php"; ?>
        </div><!-- /row for wrapper -->
        <div class="col-md-2"></div>
      </div><!-- /row -->
    </div><!-- /container fluid -->
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <script type="text/javascript">
        CKEDITOR.replace('my_editor',
        {
            toolbar :[]
        });
    </script>
  </body>
</html>

<?php
  mysqli_close($connection);
  ob_end_flush();
?>