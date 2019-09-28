<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿詳細ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

$p_id =(!empty($_GET['p_id'])) ? $_GET['p_id']:'';
$viewData = getPostOne($p_id);
//if(empty($viewData)){
//	error_log('エラー発生:指定ページに不正な値が入りました');
//	header('Location:index.php');
//}
debug('取得したDBデータ：'.print_r($viewData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<!------------------------ビュー---------------------------------->


<?php
$siteTitle = '投稿詳細';
require('head.php'); 
?>

<?php
require('header.php'); 
?>

<!-- メインコンテンツ -->
<div class="postDetail-all">
	<div class="postSubTitle">
		<span class="postgGenre"><?php echo sanitize($viewData['genre']); ?></span>
		<span class="postArea"><?php echo sanitize($viewData['area']); ?></span>
	</div>
	<div class="postMainTitle">
		<span class="tate-sen"></span><?php echo sanitize($viewData['title']); ?>
		<span class="post-like"><i class="fa fa-heart icn-like js-click-like <?php if(isLike($_SESSION['user_id'], $viewData ['id'])) { echo 'active'; } ?>" aria-hidden="true" 
														data-postid="<?php echo sanitize($viewData ['id']); ?>"> </i></span>
	</div>
	<div class="postImage">
		<div class="img-main">
			<img src="<?php echo showImg(sanitize($viewData['pic1'])); ?>" alt="メイン画像：<?php echo sanitize($viewData['title']); ?>" id="js-switch-img-main">
		</div>
		<div class="img-sub">
			<img src="<?php echo showImg(sanitize($viewData['pic1'])); ?>" alt="画像1：<?php echo sanitize($viewData['title']); ?>" class="js-switch-img-sub">
			<img src="<?php echo showImg(sanitize($viewData['pic2'])); ?>" alt="画像2：<?php echo sanitize($viewData['title']); ?>" class="js-switch-img-sub">
			<img src="<?php echo showImg(sanitize($viewData['pic3'])); ?>" alt="画像3：<?php echo sanitize($viewData['title']); ?>" class="js-switch-img-sub">
		</div>
		<p class="com-user"><span>from:</span><?php echo sanitize($viewData['users']); ?></p>
	</div>
	<div class="postComment">
		<p class="com-title">コメント</p>
		<p class="com-cont"><?php echo sanitize($viewData['comment']); ?></p>
	</div>
	<div class="prevBack">
		<a href="index.php<?php echo appendGetParam(array('p_id')); ?>">&lt; 商品一覧に戻る</a>
	</div>
</div>

<?php
require('footer.php'); 
?>