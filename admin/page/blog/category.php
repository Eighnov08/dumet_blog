<?php
    //INSERT DATA CATEGORY
    if(isset($_POST["submit"])){
        $category_name = $_POST["name"];
        $category_icon = $_POST["icon"];
        mysqli_query($connection, "INSERT INTO category VALUES ('','$category_name','$category_icon')");
        header("location:index.php?category");
    }

    //TAMPIL DATA CATEGORY
    $query = mysqli_query($connection, "SELECT * FROM category ORDER BY id DESC");
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blog &raquo; Category</h1>
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
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" />
                            </div>
                            <div class="form-group">
                                <label>Icon</label>
                                <input class="form-control" type="text" name="icon" />
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
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($query)>0) {?>
                                <?php while($row = mysqli_fetch_array($query)) {?>
                                    <tr>
                                        <td><?php echo $row["category_name"] ?></td>
                                        <td><span class="<?php echo $row["icon"] ?>"></span><?php echo "&nbsp;&nbsp;".$row["icon"] ?></td>
                                        <td class="center"><a href="index.php?category-update=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button" onclick="return confirm('Update Data Category?')">Update</a></td>
                                        <td class="center"><a href="index.php?category-delete=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button" onclick="return confirm('Delete Category??')">Delete</a></td>
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