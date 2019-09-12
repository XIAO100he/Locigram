<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');
debug('auth認証完了');

if(!empty($_POST)){
	debug('POST送信があります');

	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$pass_save = (!empty($_POST['pass_save'])) ? true : false; 

	//emailの形式チェック
	validEmail($email, 'email');

	//パスワードの最小文字数チェック
	validMinLen($pass, 'pass');

	//未入力チェック
	validRequired($email, 'email');
	validRequired($pass, 'pass');

	if(empty($err_msg)){
		debug('バリデーションOKです');

		try{
			$dbh =dbConnect();
			$sql = 'SELECT pass,id FROM users WHERE email = :email, AND delete_flg=0';
			$data = array(':email' => $email);
			$stmt = queryPost($dbh,$sql,$data);
			$result = $stmt-> fetch(PDO::FETCH_ASSOC);

			debug('クエリ結果の中身：'.print_r($result,true));

			if(!empty($result) && password_verify($pass,array_shift($result))){
				debug('パスワードがマッチしました');

				$sessLimit=60*60;
				$_SESSION['login-date'] = time();

				if(pass_save){
					debug('ログイン保持にチェックがあります');
					$_SESSION['login_limit'] = $sessLimit * 24 * 30;
				} else {
					debug('ログイン保持にチェックはありません');
					$_SESSION['login_limit'] = $sessLimit;
				}
				$_SESSION['user_id'] = $result['id'];

				debug('セッション変数の中身：'.print_r($_SESSION, true));
				debug('マイページへ遷移します');
				header('Location:index.php');
			} else {
				debug('パスワードがアンマッチです');
				$err_msg['common'] = MSG07;
			}
		} catch (Exception $e){
			error_log('エラー発生:'.$e->getMessage());
			$err_msg['common'] = MSG06;
		}
	}
}

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>


<?php
$siteTitle = 'ログイン';
require('head.php');
require('header.php');
?>

<div class='login-wrapper'>
	<h2>ログイン</h2>
	<form action="" method="post">
		<div class=login-box>
<!--		メールアドレス-->
			<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
				<div class="theme-wrapper">
					<p>メールアドレス</p>
				</div>
				<input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
			</label>
			<div class="area-msg">
				<?php
				if(!empty($err_msg['email'])) echo $err_msg['email'];
				?>
			</div>
<!--			パスワード-->
			<label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
				<div class="theme-wrapper">
					<p>パスワード</p>
				</div>
				<input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
			</label>
			<div class="area-msg">
				<?php
				if(!empty($err_msg['pass'])) echo $err_msg['pass'];
				?>
			</div>
<!--			次回ログイン-->
			<label class="next-login">
				<input type="checkbox" name="pass_save">次回ログインを省略する
			</label>
			<div>
				<input type="submit" class='login-do-btn' value="ログイン">
			</div>
<!--			-->
		</div>
	</form>
</div>

<?php
require('footer.php');
?>