<header>
	<div class="header-left">
		<h1><a href="index.php" class="main-theme">ふるさと.com</a></h1>
		<p>〜ふるさと納税返礼品の比較サイト〜</p>
	</div>
	<div class="header-right">
		<?php
			if(empty($_SESSION['user_id'])){
		?>
		<p class="square">
			<a href="login.php" class="login-btn">ログイン</a>
		</p>
		<p class="square">
			<a href="signup.php" class="header-signup-btn">会員登録</a></p>
		<p><i class="far fa-question-circle fa-fw"></i>よくある質問</p>
		<p><i class="far fa-envelope fa-fw"></i>お問い合わせ</p>
		<p><i class="far fa-building fa-fw"></i>会社情報</p>
		<?php
			} else{
		?>
		<p class="square">ログアウト</p>
		<p class="square"><a href="withdraw.php" class="login-btn">退会する</a></p>
		<p><i class="far fa-question-circle fa-fw"></i>よくある質問</p>
		<p><i class="far fa-envelope fa-fw"></i>お問い合わせ</p>
		<p><i class="far fa-building fa-fw"></i>会社情報</p>
		<?php
			}
		?>
	</div>
</header>