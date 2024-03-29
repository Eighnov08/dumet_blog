<?php
    //INSERT DATA POST
    if(isset($_POST["submit"])){
        $category_id = $_POST["category_id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        // print_r($description);
        // die();
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
                                <textarea class="form-control" rows="3" id="myeditor" name="description"></textarea>
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
                    <table id="table_id" class="display">
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
                                        <td><?php echo substr($row["description"], 0, 200)."..." ?></td>
                                        <td>
                                            <?php if($row["image"]=="") { echo "<img src='asset/no-image.png' width='88' />";} else{ ?>
                                                <img src="../images/<?php echo $row["image"] ?>" width="88" class="img-responsive" />
                                            <?php } ?>
                                        </td>
                                        <td class="center"><a href="index.php?post-update=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button" onclick="return confirm('Update Data Post?')">Update</a></td>
                                        <td class="center"><a href="index.php?post-delete=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button" onclick="return confirm('Delete Data Post?')">Delete</a></td>
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