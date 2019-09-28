<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　お気に入り');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
//ログイン認証
require('auth.php');

$likePost = likePost();

debug('取得した投稿データ：'.print_r($likePost,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');


?>

<!------------------------ビュー---------------------------------->
<?php
$siteTitle='お気に入り';
require('head.php');
?>
<body>
	<!--ヘッダー-->
	<?php
	require('header.php');
	?>
	<div class="main-wrapper">
		<h2>お気に入り</h2>
		<!--メインボックス-->
		<div class="my-main_wrapper">
			<div class="myPost-wrapper">
				<?php
				if(!empty($likePost)):
				foreach($likePost as $key => $val ):
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
	</div>
	<?php
	require('footer.php');
	?>
</body>