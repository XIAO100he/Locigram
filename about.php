<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　アバウトページ　');
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
$siteTitle='Locigramとは';
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
	<div class="about-wrapper">
		<div>
			<h2 class="about-loci">Locigramとは</h2>
			<p class="about-cont">みんなによる、みんなのためのローカル情報を、みんなで作り上げていく場。<br>
				調べても中々出てこない、ローカルの面白い、魅力的な情報をみんなで共有しましょう<br>
			</p>
		</div>
	</div>
	<?php
	require('footer.php');
	?>
</body>