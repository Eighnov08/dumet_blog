<?php
    //INPUT DATA ADMINISTRATOR
    if(isset($_POST["submit"])){
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        mysqli_query($connection, "INSERT INTO admin VALUES('','$username','$password')");
        header("location:index.php?administrator");
    }

    //TAMPIL DATA ADMINISTRATOR
    $query = mysqli_query($connection, "SELECT * FROM admin ORDER BY id DESC");
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blog &raquo; Administrator</h1>
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
                                <label>Username</label>
                                <input class="form-control" type="text" name="username" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="password" name="password" />
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
                                <th>Username</th>
                                <th>Password</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($query)>0) {?>
                                <?php while($row=mysqli_fetch_array($query)){ ?>
                                    <tr>
                                        <td><?php echo $row["username"] ?></td>
                                        <td><?php echo $row["password"] ?></td>
                                        <td class="center"><a href="index.php?administrator-update=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button" onclick="return confirm('Update Data Administrator?')">Update</a></td>
                                        <td class="center"><a href="index.php?administrator-delete=<?php echo $row["id"] ?>" class="btn btn-primary btn-xs" type="button" onclick="return confirm('Delete Administrator?')">Delete</a></td>
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