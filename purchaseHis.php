<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　購入履歴');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
//ログイン認証
require('auth.php');
?>

<!------------------------ビュー---------------------------------->
<?php
$siteTitle='購入履歴';
require('head.php');
?>
<body>
	<!--ヘッダー-->
	<?php
	require('header.php');
	?>
	<div class="main-wrapper">
		<h2>購入履歴</h2>
		<!--メインボックス-->
		<div class="my-main_wrapper">

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