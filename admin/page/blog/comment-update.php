<?php
    $comment_id = $_GET["comment-update"];
    $update = mysqli_query($connection, "SELECT * FROM comment WHERE id = '$comment_id'");
    $row_update = mysqli_fetch_array($update);

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
                                            <option <?php echo $row_update["post_id"]==$row_post["id"] ? "selected= 'selected'" : "" ?>
                                            value="<?php echo $row_post["id"] ?>"> <?php echo $row_post["title"] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>User</label>
                                <input class="form-control" type="text" name="username" value="<?php echo $row_update["name"] ?>"/>
                            </div>
                            <div class="form-group">
                                <label>Reply</label>
                                <textarea class="form-control" rows="3" name="reply"><?php echo $row_update["reply"] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="0" name="status" <?php echo $row_update["status"]== '0' ? "checked" : "" ?>/> Not Active
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="1" name="status" <?php echo $row_update["status"]== '1' ? "checked" : "" ?>/> Active
                                    </label>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success">Save</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <input type="hidden" name="comment_id" value="<?php echo $row_update["id"] ?>">
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