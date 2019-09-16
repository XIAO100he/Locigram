<header>
	<div class="header-left">
		<h1><a href="index.php" class="main-theme">Locigram</a></h1>
	</div>
	<div class="header-right">
		<?php
		if(empty($_SESSION['user_id'])){
		?>
			<p class="square"><a href="login.php" class="login-btn">ログイン</a></p>
			<p class="square"><a href="signup.php" class="header-signup-btn">会員登録</a></p>
			<p><i class="far fa-question-circle fa-fw"></i>よくある質問</p>
			<p><i class="far fa-envelope fa-fw"></i>お問い合わせ</p>
			<p><i class="far fa-building fa-fw"></i>会社情報</p>
		<?php
			} else {
		?>
		<p class="square"><a href="logout.php" class="logout-btn">ログアウト</a></p>
			<p class="square"><a href="mypage.php" class="myp-btn">マイページ</a></p>
			<p><i class="far fa-question-circle fa-fw"></i>よくある質問</p>
			<p><i class="far fa-envelope fa-fw"></i>お問い合わせ</p>
			<p><i class="far fa-building fa-fw"></i>会社情報</p>
		<?php
			}
		?>
	</div>
</header>