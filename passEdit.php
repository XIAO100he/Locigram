<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');
debug('auth認証完了');
?>


<!-----------------------ビューーーーーーーーーーーーーーーーーーーー-->
<?php
$siteTitle = 'パスワード変更';
require('head.php'); 
?>

<body>
	<?php
	require('header.php'); 
	?>

	<!-- メインコンテンツ -->
	<div class="main-wrapper">
		<h2>パスワード変更</h2>
			<div class="passRe-wrapper">
				<form action="" method="post">
					<div class="area-msg">
						<?php
						echo getErrMsg('common');
						?>
					</div>
<!--				古いパスワード-->
					<label class="<?php if(!empty($err_msg['pass_old'])) echo 'err'; ?>">
					<div class="theme-wrapper">
						<p>古いパスワード</p>
					</div>
					<input type="password" name="pass_old" value="<?php echo getFormData('pass_old'); ?>">
					</label>
					<div class="area-msg">
						<?php
						if(!empty($err_msg['email'])) echo $err_msg['email'];
						?>
					</div>
<!--					新しいパスワード-->
					<label class="<?php if(!empty($err_msg['pass_new'])) echo 'err'; ?>">
						新しいパスワード
						<input type="password" name="pass_new" value="<?php echo getFormData('pass_new'); ?>">
					</label>
					<div class="area-msg">
						<?php 
						echo getErrMsg('pass_new');
						?>
					</div>
<!--					新しいパスワード（再入力）-->
					<label class="<?php if(!empty($err_msg['pass_new_re'])) echo 'err'; ?>">
						新しいパスワード（再入力）
						<input type="password" name="pass_new_re" value="<?php echo getFormData('pass_new_re'); ?>">
					</label>
					<div class="area-msg">
						<?php 
						echo getErrMsg('pass_new_re');
						?>
					</div>
					<div>
						<input type="submit" class="change-prf-btn" value="変更する">
					</div>
				</form>
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
