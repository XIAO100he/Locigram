<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　マイページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');

$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1 ;
//$category = (!empty($_GET['c_id'])) ? $_GET['c_id'] : '';
//$sort =(!empty($_GET['sort'])) ? $_GET['sort'] : '';

if(!is_int($currentPageNum)){
	error_log('エラー発生：指定ページに不正な値が入りました');
	header('Location:index.php');
}

$listSpan =12;
$currentMinNum = (($currentPageNum-1)*$listSpan);
$dbPostData = getPostList($currentMinNum);


debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<!------------------------ビュー---------------------------------->


<?php
$siteTitle='トップページ';
require('head.php');
?>
<body>
	<!--ヘッダー-->
	<?php
	require('header.php');
	?>
	<?php
	require('menu.php');
	?>
	<div class="index-wrapper">
		<div class="allPost-wrapper">
			<div class="theme-wrapper">すべての投稿</div>
<!--			投稿件数-->
			<div class="postNum">
				<span class="num"><?php echo (!empty($dbPostData['data'])) ? $currentMinNum+1 : 0; ?></span> - <span class="num"><?php echo $currentMinNum+count($dbPostData['data']); ?></span>件 / <span class="num"><?php echo sanitize($dbPostData['total']); ?></span>件中
			</div>
<!--			投稿写真-->
			<div class="photos_wrapper">
				<?php require('photos.php'); ?>
			</div>
<!--			ページネーション-->
			<div class="pagination">
				<?php pagination($currentPageNum, $dbPostData['total_page']); ?>
			</div>
		</div>
	</div>
	<?php
	require('postBtn.php');
	?>
	<?php
	require('footer.php');
	?>
</body>