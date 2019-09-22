<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　マイページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');


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
		<div class="photos-wrapper">
			<div class="theme-wrapper">ジャンルテーマ</div>
			<?php require('photos.php'); ?>
		</div>
	</div>
	<?php
	require('postBtn.php');
	?>
	<?php
	require('footer.php');
	?>
</body>