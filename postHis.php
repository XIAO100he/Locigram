<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　過去の投稿　');
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
$siteTitle='過去の投稿';
require('head.php');
?>
<body>
	<!--ヘッダー-->
	<?php
	require('header.php');
	?>
	<!--	パンくずリスト-->
	<div class="breadcrumd">
		<span class="bread past"><a href="index.php" class=''>トップページ</a></span>
		<span><i class="fas fa-chevron-left"></i></span>
		<span class="bread past"><a href="mypage.php" class=''>マイページ</a></span>
		<span><i class="fas fa-chevron-left"></i></span>
		<span class="bread now"><a href="#" class=''>過去の投稿</a></span>
	</div>
	<div class="main-wrapper">
		<h2>過去の投稿</h2>
		<!--メインボックス-->
		<div class="my-main_wrapper">
			<div class="myPost-wrapper">
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
	</div>
	<?php
	require('footer.php');
	?>
</body>