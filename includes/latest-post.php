<?php
  $query = mysqli_query($connection, "SELECT post.*, category.category_name, category.icon 
                                      FROM post, category WHERE category.id = post.category_id ORDER BY id DESC");
?>

<article>
  <?php if(mysqli_num_rows($query)>0) {?>
    <?php while($row = mysqli_fetch_array($query)) {?>
      <div class="row latest-post">
        <div class="col-md-3">
          <img src="images/<?php echo $row["image"] ?>" class="img-responsive btn-block">
        </div>
        <div class="col-md-9">
          <h2><a href="index.php?detail"><?php echo $row["title"] ?></a></h2>
          <div class="meta"><a href="#">
            <span class="<?php echo $row["icon"] ?>" aria-hidden="true"></span> <?php echo $row["category_name"] ?></a> - <?php echo tanggal_indonesia($row["date"]);  ?></div>
          <p><?php echo $row["description"] ?></p>
        </div>
      </div>
  <?php } ?>
  <?php } ?>
</article>
<nav class="text-center">
  <ul class="pagination">
    <li>
        <a href="#" aria-label="Previous">
            <span aria-hidden="true">Prev</span>
        </a>
    </li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">Next</span>
      </a>
    </li>
  </ul>
</nav>