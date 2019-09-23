<?php


debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　トップの画像　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

$dbAllPosts = getPosts();
debug('ポストの中身：'.print_r($dbAllPosts,true));

$userId = array_column($dbAllPosts,'user_id');
debug('ユーザーID：'.print_r($userId,true));


?>




<?php
if(!empty($dbAllPosts)):
foreach($dbAllPosts as $key => $val ):
?>


<div class="postCon-wrapper">
	<div class="photo-wrapper">
		<a href="registPost.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>" class="panel">
			<img src="<?php echo showImg(sanitize($val['pic1'])); ?>" alt="<?php echo sanitize($val['name']); ?>" alt="">
			<div class="panel-body">
				<p class="placeName"><span>@</span> <?php echo sanitize($val['title']); ?></p>
				<p class="postUserName"></p>
			</div>
		</a>
	</div>
</div>

<?php
endforeach;
endif;
?>