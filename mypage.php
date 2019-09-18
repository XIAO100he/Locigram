<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　マイページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');

$u_id = $_SESSION['user_id'];

$postData = getMyPosts($u_id);

debug('取得した投稿データ：'.print_r($postData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');


?>

<!------------------------ビュー---------------------------------->
<?php
$siteTitle='マイページ';
require('head.php');
?>
<body>
<!--ヘッダー-->
<?php
require('header.php');
?>
<!--成功時のメッセージ-->

<!--メイン箇所-->
	<div class="main-wrapper">
		<h2>マイページ</h2>
	<!--メインボックス-->
		<div class="my-main_wrapper">
			<div class="myPost-wrapper">
				<h3 class="myPost-title">あなたの投稿</h3>
				<?php
				if(!empty($postData)):
				foreach($postData as $key => $val ):
				?>
				<div class="a_Post">
					<a href="registPost.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>" class="panel">
						<div class="panel-head">
							<img src="<?php echo showImg(sanitize($val['pic1'])); ?>" alt="<?php echo sanitize($val['name']); ?>">
						</div>
						<div class="panel-body">
							<p class="panel-title"><?php echo sanitize($val['title']); ?></p>
						</div>
					</a>
				</div>
				<?php
				endforeach;
				endif;
				?>
			</div>
		</div>
	<!--	サイドボックス-->
	<?php
		require('side_bar.php');
	?>
	<?php
	require('postBtn.php');
	?>
	</div>
	<?php
	require('footer.php');
	?>
</body>