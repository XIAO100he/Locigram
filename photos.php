<?php


debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　トップの画像　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

$dbAllPosts = getPosts();
debug('ポストの中身：'.print_r($dbAllPosts,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<!------------------------ビュー---------------------------------->


<?php
if(!empty($dbAllPosts)):
foreach($dbAllPosts as $key => $val ):
?>
<div class="postCon-wrapper">
	<div class="photo-wrapper">
		<a href="postDetail.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>" class="panel">
			<img src="<?php echo showImg(sanitize($val['pic1'])); ?>" alt="<?php echo sanitize($val['title']); ?>" alt="">
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