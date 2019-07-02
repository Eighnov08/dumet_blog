<!-- post -->
<?php
    //INSERT DATA POST
    if(isset($_POST["submit"])){
        $category_id = $_POST["category_id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $date = date("Y-m-d H:i:s");

        //MOVE IMAGE
        $file_name = $_FILES["file"]["name"];
        $tmp_name = $_FILES["file"]["tmp_name"];
        move_uploaded_file($tmp_name, "../images/".$file_name);

        mysqli_query($connection, "INSERT INTO post VALUES ('','$category_id','$title','$description','$file_name','$date')");
        header("location:index.php?post");
    }

    //TAMPIL CATEGORY NAME
    $category = mysqli_query($connection, "SELECT * FROM category ORDER BY id ASC");

    //TAMPIL DATA POST
    $post = mysqli_query($connection, "SELECT post.*, category.category_name FROM post, category
                                        WHERE post.category_id = category.id ORDER BY id DESC");
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blog &raquo; Post</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Input Data
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id">
                                    <option value=""> - choose - </option>
                                    <?php if(mysqli_num_rows($category)>0) {?>
                                        <?php while($row_cat=mysqli_fetch_array($category)) {?>
                                            <option value="<?php echo $row_cat["id"] ?>"> <?php echo $row_cat["category_name"] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title" />
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="file" />
                            </div>
                            <button type="submit" name="submit" class="btn btn-success">Save</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                List Data
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($post)>0){ ?>
                                <?php while($row=mysqli_fetch_array($post)) {?>
                                    <tr>
                                        <td><?php echo $row["category_name"] ?></td>
                                        <td><?php echo $row["title"] ?></td>
                                        <td><?php echo $row["description"] ?></td>
                                        <td>
                                            <?php if($row["image"]=="") { echo "<img src='asset/no-image.png' width='88' />";} else{ ?>
                                                <img src="../images/<?php echo $row["image"] ?>" width="88" class="img-responsive" />
                                            <?php } ?>
                                        </td>
                                        <td class="center"><a href="index.php?post-update=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button">Update</a></td>
                                        <td class="center"><a href="index.php?post-delete=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- DELETE POST -->

<?php
    if(isset($_GET["post-delete"])){
        $post_id = $_GET["post-delete"];
        mysqli_query($connection, "DELETE FROM post WHERE id = '$post_id'");
        header("location:index.php?post");
    }
?>

<!-- UPDATE POST -->

<?php
    //UPDATE DATA POST
    if(isset($_POST["update"])){
        $post_id = $_POST["post_id"];
        $category_id = $_POST["category_id"];
        $title = $_POST["title"];
        $description = $_POST["description"];

        $file_name = $_FILES["file"]["name"];
        $tmp_name = $_FILES["file"]["tmp_name"];
        if($file_name=="" || empty($file_name)){
            mysqli_query($connection, "UPDATE post SET category_id = '$category_id', title = '$title', description = '$description'
                            WHERE id = '$post_id'");
        } else {
            move_uploaded_file($tmp_name, "../images/".$file_name);
            mysqli_query($connection, "UPDATE post SET category_id = '$category_id', title = '$title', description = '$description',
                            image = '$file_name' WHERE id = '$post_id'");
        }
        header("location:index.php?post");
    }

    //TAMPIL DATA UPDATE POST
    $post_id = $_GET["post-update"];
    $update = mysqli_query($connection, "SELECT * FROM post WHERE id = '$post_id'");
    $row_update = mysqli_fetch_array($update);

    //TAMPIL CATEGORY NAME
    $category = mysqli_query($connection, "SELECT * FROM category ORDER BY id ASC");

    //TAMPIL DATA POST
    $post = mysqli_query($connection, "SELECT post.*, category.category_name FROM post, category
                                        WHERE post.category_id = category.id ORDER BY id DESC");
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blog &raquo; Post</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                Input Data
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id">
                                    <option value="<?php $row_update["category_name"] ?>"> - choose - </option>
                                    <?php if(mysqli_num_rows($category)>0) {?>
                                        <?php while($row_cat=mysqli_fetch_array($category)) {?>
                                            <option <?php echo $row_update["category_id"]==$row_cat["id"] ? "selected='select'" : "" ?>
                                            value="<?php echo $row_cat["id"] ?>"> <?php echo $row_cat["category_name"] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title" value="<?php echo $row_update["title"] ?>"/>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="description"><?php echo $row_update["description"] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <p><img src="../images/<?php echo $row_update["image"] ?>" width="88"></p>
                                <input type="file" name="file" value=""/>
                            </div>
                            <button type="submit" name="update" class="btn btn-success">Update</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <input type="hidden" name="post_id" value="<?php echo $row_update["id"] ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                List Data
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($post)>0){ ?>
                                <?php while($row=mysqli_fetch_array($post)) {?>
                                    <tr>
                                        <td><?php echo $row["category_name"] ?></td>
                                        <td><?php echo $row["title"] ?></td>
                                        <td><?php echo $row["description"] ?></td>
                                        <td>
                                            <?php if($row["image"]=="") { echo "<img src='asset/no-image.png' width='88' />";} else{ ?>
                                                <img src="../images/<?php echo $row["image"] ?>" width="88" class="img-responsive" />
                                            <?php } ?>
                                        </td>
                                        <td class="center"><a href="index.php?post-update=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button">Update</a></td>
                                        <td class="center"><a href="index.php?post-delete=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COMMENT -->

<?php
    if(isset($_POST["submit"])){
        $post_id = $_POST["post_id"];
        $username = $_POST["username"];
        $reply = $_POST["reply"];
        $status = $_POST["status"];
        $date = date("Y-m-d H:i:s");

        mysqli_query($connection, "INSERT INTO comment VALUES ('','$post_id','$username','$reply','$status','$date')");
        header("location:index.php?comment");
    }

    $post = mysqli_query($connection, "SELECT * FROM post ORDER BY id ASC");

    $comment = mysqli_query($connection, "SELECT comment.*, post.title FROM comment, post
                                WHERE comment.post_id = post.id ORDER BY comment.id DESC");
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blog &raquo; Comment</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Input Data
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" action="" method="post">
                            <div class="form-group">
                                <label>Post</label>
                                <select class="form-control" name="post_id">
                                    <option value=""> - choose - </option>
                                    <?php if(mysqli_num_rows($post)>0) {?>
                                        <?php while($row_post=mysqli_fetch_array($post)) {?>
                                            <option value="<?php echo $row_post["id"] ?>"> <?php echo $row_post["title"] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>User</label>
                                <input class="form-control" type="text" name="username" />
                            </div>
                            <div class="form-group">
                                <label>Reply</label>
                                <textarea class="form-control" rows="3" name="reply"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="0" name="status" checked /> Not Active
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="1" name="status" /> Active
                                    </label>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success">Save</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                List Data
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Post</th>
                                <th>User</th>
                                <th>Reply</th>
                                <th>Status</th>
                                <th>Datetime</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($comment)>0) {?>
                                <?php while($row_comment=mysqli_fetch_array($comment)) {?>
                                    <tr>
                                        <td><?php echo $row_comment["title"] ?></td>
                                        <td><?php echo $row_comment["name"] ?></td>
                                        <td><?php echo $row_comment["reply"] ?></td>
                                        <td><?php echo $row_comment["status"]== '1' ? "Active" : "Not Active" ?></td>
                                        <td><?php echo $row_comment["date"] ?></td>
                                        <td class="center"><a href="index.php?comment-update=<?php echo $row_comment["id"] ?>" class="btn btn-primary btn-xs" type="button">Update</a></td>
                                        <td class="center"><a href="index.php?comment-delete=<?php echo $row_comment["id"] ?>" class="btn btn-primary btn-xs" type="button">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>