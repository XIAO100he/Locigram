<?php
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ユーザー登録ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();


if(!empty($_POST)){

	//変数にユーザー情報を代入
	$name = $_POST['name'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];

	//未入力チェック
	validRequired($name, 'name');
	validRequired($email, 'email');
	validRequired($pass, 'pass');
	validRequired($pass_re, 'pass_re');

	if(empty($err_msg)){
		//emailの形式チェック
		validEmail($email, 'email');

		//email重複チェック
		validEmailDup($email);

		//パスワードの最小文字数チェック
		validMinLen($pass, 'pass');

		//パスワード（再入力）の最小文字数チェック
		validMinLen($pass_re, 'pass_re');


		if(empty($err_msg)){

			//パスワードとパスワード再入力が合っているかチェック
			validMatch($pass, $pass_re, 'pass_re');

			if(empty($err_msg)){
				//例外処理
					try{
						// DBへ接続
					$dbh = dbConnect();
					// SQL文作成
					$sql = 'INSERT INTO users (email,password,login_time,create_date) VALUES(:email,:pass,:login_time,:create_date)';
					$data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),
												':login_time' => date('Y-m-d H:i:s'),
												':create_date' => date('Y-m-d H:i:s'));
					// クエリ実行
					$stmt = queryPost($dbh, $sql, $data);

					// クエリ成功の場合
					if($stmt){
						//ログイン有効期限（デフォルトを１時間とする）
						$sesLimit = 60*60;
						// 最終ログイン日時を現在日時に
						$_SESSION['login_date'] = time();
						$_SESSION['login_limit'] = $sesLimit;
						// ユーザーIDを格納
						$_SESSION['user_id'] = $dbh->lastInsertId();

						debug('セッション変数の中身：'.print_r($_SESSION,true));

						header("Location:mypage.php"); //マイページへ
					}else{
						error_log('クエリに失敗しました。');
						$err_msg['common'] = MSG06;
					}

				} catch (Exception $e) {
					error_log('エラー発生:' . $e->getMessage());
					$err_msg['common'] = MSG06;
				}
			}
		}
	}
}
?>
<!--*************ページView内容*******************-->
<?php
require('head.php');
?>
<body>
	<!--ヘッダー-->
	<?php
	require('header.php');
	?>
	<!--	ユーザー登録-->
	<div class="registration">
		<h2>会員登録</h2>
		<p class=regi_explain>必要情報を入力し「会員登録」ボタンを押してください</p>
		<div class="area-msg">
			<?php 
			if(!empty($err_msg['common'])) echo $err_msg['common'];
			?>
		</div>
		<form action="" method='post'class="form">
			<!--		名前-->
			<div class="theme-wrapper">
				<p>ニックネーム</p>
				<p class="must"><span>必須</span></p>
			</div>

				<input type="text" name="name"placeholder="（例）ふるさと太郎">

			<div class="area-msg">
				<?php
				if(!empty($err_msg['name'])) echo $err_msg['name'];
				?>
			</div>
			<!--			メールアドレス-->
			<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
				<div class="theme-wrapper">
					<p>メールアドレス</p>
					<p class="must"><span>必須</span></p>
				</div>
				<input type="text" name="email" placeholder="（例）furusato@mail.com" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
			</label>
			<div class="area-msg">
				<?php
				if(!empty($err_msg['email'])) echo $err_msg['email'];
				?>
			</div>
			<!--			パスワード-->
			<label class="<?php if(!empty($err_msg['password'])) echo 'err'; ?>">
				<div class="theme-wrapper">
					<p>パスワード<span style="font-size:12px">※英数字６文字以上</span></p>
					<p class="must"><span>必須</span></p>
				</div>
				<input type="password" name="password" placeholder="（例）furusato01" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
			</label>
			<div class="area-msg">
				<?php
				if(!empty($err_msg['password'])) echo $err_msg['password'];
				?>
			</div>
			<!--			パスワード（再入力）-->
			<label class="<?php if(!empty($err_msg['password_re'])) echo 'err'; ?>">
				<div class="theme-wrapper">
					<p>パスワード（確認）</p>
					<p class="must"><span>必須</span></p>
				</div>
				<input type="password" name="password_re" placeholder="（例）furusato01" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>">
			</label>
			<div class="area-msg">
				<?php
				if(!empty($err_msg['password_re'])) echo $err_msg['password_re'];
				?>
			</div>
<!--			会員登録ボタン-->
			<input type="submit" value="会員登録">
		</form>
	</div>

	<!--フッター-->
	<?php
		require('footer.php');
	?>
</body>
