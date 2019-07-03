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
                                    <option value=""> - choose - </option>
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
                                <textarea class="form-control" rows="3" id="myeditor" name="description"><?php echo $row_update["description"] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                    <?php if($row_update["image"]==""){ echo "<p><img src='asset/no-image.png' width='88'/></p>"; }else{ ?>
                                        <p><img src="../images/<?php echo $row_update["image"] ?>" width="88"></p>
                                    <?php } ?>
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
                                        <td><?php echo substr($row["description"], 0, 200)."..." ?></td>
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