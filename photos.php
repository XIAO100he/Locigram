<?php


debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　トップの画像　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

$dbAllPosts = getPosts();

?>



<?php
if(!empty($dbAllPosts)):
foreach($dbAllPosts as $key => $val ):
?>

<div class="postCon-wrapper">
	<div class="photo-wrapper">
		<img src="<?php echo showImg(sanitize($val['pic1'])); ?>" alt="<?php echo sanitize($val['name']); ?>" alt="">
		<a href="registPost.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>" class="panel">
			<div class="panel-body">
				<p class="placeName"><span>@</span> <?php echo sanitize($val['title']); ?></p>
			</div>
		</a>
	</div>
</div>

<?php
endforeach;
endif;
?>