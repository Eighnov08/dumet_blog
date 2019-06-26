<?php
	$comment = mysqli_query($connection, "SELECT * FROM comment WHERE status = '1' ORDER BY id DESC LIMIT 3");
?>

<aside class="col-md-4">
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h3 class="panel-title">Komentar Terbaru</h3>
    	</div>
    	<div class="panel-body latest-comments">
    		<ul>
				<?php if(mysqli_num_rows($comment)) {?>
					<?php while($row_comment=mysqli_fetch_array($comment)) {?>
						<li>
							<a href="index.php?detail">
								<span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 
								<strong><?php echo $row_comment["name"] ?></strong>: <?php echo $row_comment["reply"] ?>
							</a>
						</li>
					<?php } ?>
				<?php } ?>
    		</ul>
    	</div>
    </div>
</aside>

