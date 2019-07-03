<?php
  //SEARCH
  if(isset($_POST["search"])){
    $_SESSION["session_search"] = $_POST["keyword"];
    $keyword = $_SESSION["session_search"];
  } else {
    $keyword = $_SESSION["session_search"];
  }

  //PAGING POST
  $per_page = 4;
  $cur_page = 1;
  if(isset($_GET["page-search"])){
    $cur_page = $_GET["page-search"];
    $cur_page = ($cur_page > 1) ? $cur_page : 1;
  }

  $total_data = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM post WHERE title LIKE '%$keyword%'"));
  $total_page = ceil($total_data/$per_page);
  $offset     = ($cur_page - 1) * $per_page;

  //TAMPILKAN DATA POST
  $query = mysqli_query($connection, "SELECT post.*, category.category_name, category.icon 
                                      FROM post, category WHERE category.id = post.category_id AND post.title LIKE '%$keyword%'
                                      ORDER BY id DESC
                                      LIMIT $per_page OFFSET $offset");
?>

<article>
  <?php if(mysqli_num_rows($query)>0) {?>
    <?php while($row = mysqli_fetch_array($query)) {?>
      <div class="row latest-post">
        <div class="col-md-3">
          <?php if($row["image"]==""){ echo "<img src='images/no-image.png' class='img-responsive btn-block'>"; } else { ?>
          <img src="images/<?php echo $row["image"] ?>" class="img-responsive btn-block">
          <?php } ?>
        </div>
        <div class="col-md-9">
          <h2><a href="index.php?detail=<?php echo $row["id"] ?>"><?php echo $row["title"] ?></a></h2>
          <div class="meta"><a href="index.php?category=<?php echo $row["category_id"] ?>">
            <span class="<?php echo $row["icon"] ?>" aria-hidden="true"></span> <?php echo $row["category_name"] ?></a> - <?php echo tanggal_indonesia($row["date"]);  ?></div>
          <p><?php echo $row["description"] ?></p>
        </div>
      </div>
    <?php } ?>
  <?php } ?>
</article>

<?php if(isset($total_page)) {?>
  <?php if($total_page > 1) {?>
    <nav class="text-center">
      <ul class="pagination">
        <?php if($cur_page > 1) {?>
          <li>
              <a href="index.php?page-search=<?php echo $cur_page - 1 ?>" aria-label="Previous">
                  <span aria-hidden="true">Prev</span>
              </a>
          </li>
        <?php } else { ?>
          <li class="disabled"><span aria-hidden="true">Prev</span></li>
        <?php } ?>
        <?php if($cur_page < $total_page) {?>
          <li>
            <a href="index.php?page-search=<?php echo $cur_page + 1 ?>" aria-label="Next">
              <span aria-hidden="true">Next</span>
            </a>
          </li>
          <?php } else { ?>
          <li class="disabled"><span aria-hidden="true">Next</span></li>
        <?php } ?>
      </ul>
    </nav>
  <?php } ?>
<?php } ?>