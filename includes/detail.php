<?php
  //INPUT KOMENTAR
  if(isset($_POST["submit"])){
    $post_id = $_POST["post_id"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $date = date("Y-m-d H:i:s");
    mysqli_query($connection, "INSERT INTO comment VALUES ('','$post_id','$name','$comment','0','$date')");
    header("location:index.php?detail=$post_id&success-comment#success");
  }

  //MENAMPILKAN DETAIL
  $detail_id = $_GET["detail"];
  $query = mysqli_query($connection, "SELECT post.*, category.category_name, category.icon FROM
                        post, category WHERE category.id = post.category_id AND post.id = '$detail_id'");
  if(mysqli_num_rows($query) == 0) header("location:index.php");
  $row_detail = mysqli_fetch_array($query);
  
  //MENAMPILKAN KOMENTAR
  $comment = mysqli_query($connection, "SELECT * FROM comment WHERE post_id = '$detail_id' AND status = '1' ORDER BY id DESC");
  $data = mysqli_num_rows($comment);
?>

<article>
    <div class="meta">
        <a href="index.php?category=<?php echo $row_detail["category_id"] ?>"><span class="<?php echo $row_detail["icon"] ?>" aria-hidden="true"></span> <?php echo $row_detail["category_name"] ?></a> - <?php echo tanggal_indonesia($row_detail["date"]) ?>
    </div>
    <h1><?php echo $row_detail["title"] ?></h1>
    <img src="images/<?php echo $row_detail["image"] ?>" class="img-responsive btn-block">
    <p><?php echo $row_detail["description"] ?></p>

    <!-- Komentar -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <?php echo $data ?> Komentar</h3>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <?php if(mysqli_num_rows($comment)) {?>
            <?php while($row_comment=mysqli_fetch_array($comment)) {?>
              <li class="list-group-item">
                <strong><?php echo $row_comment["name"] ?></strong>: <?php echo $row_comment["reply"] ?>
              </li>
            <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>

    <!-- Form Komentar -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Komentar</h3>
      </div>
      <div class="panel-body" id="success">
        <form class="form-horizontal" method="POST">

        <?php if(isset($_GET["success-comment"])){ ?>
          <div class="form-group">
            <div class="col-sm-10">
              <p style="color:blue">Terima Kasih, Komentar Anda Sedang Diteliti...</p>
            </div>
          </div>
        <?php } ?>

          <div class="form-group">
            <label for="inputNama3" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputNama3" name="name">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPesan3" class="col-sm-2 control-label">Pesan</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="3" name="comment"></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default" name="submit">Kirim</button>
              <input type="hidden" name="post_id" value="<?php echo $detail_id ?>">
            </div>
          </div>
        </form>
      </div>
    </div>
</article>
