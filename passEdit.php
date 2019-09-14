<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');

$userData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報：'.print_r($userData, true));

if(!empty($_POST)){
	debug('POST送信があります。');
	debug('POST情報：'.print_r($_POST,true));

	$pass_old = $_POST['pass_old'];
	$pass_new = $_POST['pass_new'];
	$pass_new_re = $_POST['pass_new_re'];

	validRequired($pass_old, 'pass_old');
	validRequired($pass_new, 'pass_new');
	validRequired($pass_new_re, 'pass_new_re');
	
	if(empty($err_msg)){
		debug('未入力チェックOK。');

		validPass($pass_old, 'pass_old');

		validPass($pass_new, 'pass_new');

		if(!password_verify($pass_old, $userData['pass'])){
			$err_msg['pass_old'] = MSG10;
		}

		if($pass_old === $pass_new){
			$err_msg['pass_new'] = MSG11;
		}

		validMatch($pass_new, $pass_new_re, 'pass_new_re');

		if(empty($err_msg)){
			debug('バリデーションOK。');

			try {
				$dbh = dbConnect();
				$sql = 'UPDATE users SET pass = :pass WHERE id = :id';
				$data = array(':id' => $_SESSION['user_id'], ':pass' => password_hash($pass_new, PASSWORD_DEFAULT));
				$stmt = queryPost($dbh, $sql, $data);
				if($stmt){
					$_SESSION['msg_success'] = SUC01;
					header("Location:mypage.php");
				}
			} catch (Exception $e) {
				error_log('エラー発生:' . $e->getMessage());
				$err_msg['common'] = MSG07;
			}
		}
	}
}
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
			<div class="passRe-main_wrapper">
				<form action="" method="post">
					<div class="area-msg">
						<?php
						echo getErrMsg('common');
						?>
					</div>
					<div class="passRe_wrapper">
		<!--				古いパスワード-->
						<label class="<?php if(!empty($err_msg['pass_old'])) echo 'err'; ?>">
						<div class="theme-wrapper">
							<p class="sub_theme">古いパスワード</p>
						</div>
						<input type="password" name="pass_old" value="<?php echo getFormData('pass_old'); ?>">
						</label>
						<div class="area-msg">
							<?php 
							echo getErrMsg('pass_old');
							?>
						</div>
		<!--					新しいパスワード-->
						<label class="<?php if(!empty($err_msg['pass_new'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">新しいパスワード</p>
							</div>
							<input type="password" name="pass_new" value="<?php echo getFormData('pass_new'); ?>">
						</label>
						<div class="area-msg">
							<?php 
							echo getErrMsg('pass_new');
							?>
						</div>
		<!--					新しいパスワード（再入力）-->
						<label class="<?php if(!empty($err_msg['pass_new_re'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">新しいパスワード（再入力）</p>
							</div>
							<input type="password" name="pass_new_re" value="<?php echo getFormData('pass_new_re'); ?>">
						</label>
						<div class="area-msg">
							<?php 
							echo getErrMsg('pass_new_re');
							?>
						</div>
		<!--					変更ボタン-->
						<div class="change-prf">
						<input type="submit" class='change-pass-btn' value="変更する">
						</div>
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
