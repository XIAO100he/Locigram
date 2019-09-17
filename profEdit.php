<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　プロフィール編集ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

$dbFormData = getUser($_SESSION['user_id']);

debug('取得したユーザー情報'.print_r($dbFormData,true));

	if(!empty($_POST)){
		debug('POST送信があります');
		debug('POST情報:'.print_r($_POST, true));

		$name = $_POST['name'];
		$last_name = $_POST['last_name'];
		$first_name = $_POST['first_name'];
		$email = $_POST['email'];
		$birthday = $_POST['birthday'];
		$tel = $_POST['tel'];
		$zip = $_POST['zip'];
		$prefecture = $_POST['prefecture'];
		$town = $_POST['town'];
		$section = $_POST['section'];

		if($dbFormData['name'] !== $name){
			validMaxLen($name, 'name');
		}
		if($dbFormData['last_name'] !== $last_name){
			validMaxLen($last_name, 'last_name');
		}
		if($dbFormData['first_name'] !== $first_name){
			validMaxLen($first_name, 'first_name');
		}
		if($dbFormData['email'] !== $email){
			validMaxLen($email, 'email');
			if(empty($err_msg['email'])){
				validEmailDup($email);
			}
		}
		if($dbFormData['tel'] !== $tel){
			validTel($tel, 'tel');
		}
		if( (int)$dbFormData['zip'] !== $zip){
			validZip($zip, 'zip');
		}
		if($dbFormData['prefecture'] !== $prefecture){
			validMaxLen($prefecture, 'prefecture');
		}
		if($dbFormData['town'] !== $town){
			validMaxLen($town, 'town');
		}
		if($dbFormData['section'] !== $section){
			validMaxLen($section, 'section');
		}
		if(empty($err_log)){
			debug('バリデーションOKです');
			try{
				$dbh = dbConnect();
				$sql = 'UPDATE users SET name = :name, last_name = :last_name, first_name = :first_name, email = :email, birthday = :birthday, tel = :tel, zip = :zip, prefecture = :prefecture, town = :town, section = :section WHERE id = :u_id';
				$data = array(':name' => $name , ':last_name' => $last_name,':first_name' => $first_name,':email' => $email,':birthday' => $birthday,':tel' => $tel, ':zip' => $zip, ':prefecture' => $prefecture,':town' => $town,':section' => $section, ':u_id' => $dbFormData['id']);
				$stmt = queryPost($dbh, $sql, $data);

				if($stmt){
					$_SESSION['msg_success'] = SUC02;
					debug('マイページへ遷移します。');
					header("Location:mypage.php");
				}

			} catch (Exception $e) {
				error_log('エラー発生:' . $e->getMessage());
				$err_msg['common'] = MSG07;
			}
		}
	}
	debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>



<!-------------------------------ビュー------------------------------------------->
<?php
$siteTitle = 'プロフィール編集';
require('head.php'); 
?>

<body>
	<?php
	require('header.php'); 
	?>
	<!-- メインコンテンツ -->
	<div class="main-wrapper">
		<h2>プロフィール編集</h2>
		<div class="prof-wrapper">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="area-msg">
					<?php 
					if(!empty($err_msg['common'])) echo $err_msg['common'];
					?>
				</div>
				<div class="profContent_wrapper">
	<!--------ニックネーム-->
						<label class="<?php if(!empty($err_msg['name'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">ニックネーム</p>
							</div>
							<input type="text" name="name" value="<?php if(!empty($_POST['name'])) echo $_POST['name']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['name'])) echo $err_msg['name'];
							?>
						</div>
	<!--					姓-->
						<label class="<?php if(!empty($err_msg['last_name'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">姓</p>
							</div>
							<input type="text" name="last_name" value="<?php if(!empty($_POST['last_name'])) echo $_POST['last_name']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['last_name'])) echo $err_msg['last_name'];
							?>
						</div>
	<!--					名-->
						<label class="<?php if(!empty($err_msg['first_name'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">名</p>
							</div>
							<input type="text" name="first_name" value="<?php if(!empty($_POST['first_name'])) echo $_POST['first_name']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['first_name'])) echo $err_msg['first_name'];
							?>
						</div>
	<!--					Email-->
						<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">Email</p>
							</div>
							<input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['email'])) echo $err_msg['email'];
							?>
						</div>
<!--				生年月日-->
						<label class="<?php if(!empty($err_msg['birthday'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">生年月日</p>
							</div>
							<select>
								<option value="<?php if(!empty($_POST['birthday'])) echo $_POST['birthday']; ?>">--</option>
								<option selected>1960</option>
								<?php foreach(range(1960,2019) as $year): ?>
								<option value="<?=$year?>"><?=$year?></option>
								<?php endforeach; ?>
							</select>
							<select>
								<option value="<?php if(!empty($_POST['birthday'])) echo $_POST['birthday']; ?>">--</option>
								<option selected>1</option>
								<?php foreach(range(1,12) as $month): ?>
								<option value="<?=str_pad($month,2,0,STR_PAD_LEFT)?>"><?=$month?></option>
								<?php endforeach; ?>
							</select>
							<select>
								<option value="<?php if(!empty($_POST['birthday'])) echo $_POST['birthday']; ?>">--</option>
								<option selected>1</option>
								<?php foreach(range(1,31) as $day): ?>
								<option value="<?=str_pad($day,2,0,STR_PAD_LEFT)?>"><?=$day?></option>
								<?php endforeach; ?>
							</select>
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['birthday'])) echo $err_msg['birthday'];
							?>
						</div>
	<!--					TEL-->
						<label class="<?php if(!empty($err_msg['tel'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">TEL<span style="font-size:12px;margin-left:10px;">※ハイフン無しでご入力ください</span></p>
							</div>
							<input type="text" name="tel" value="<?php if(!empty($_POST['tel'])) echo $_POST['tel']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['tel'])) echo $err_msg['tel'];
							?>
						</div>
	<!--					郵便番号-->
						<label class="<?php if(!empty($err_msg['zip'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">郵便番号<span style="font-size:12px;margin-left:10px;">※ハイフン無しでご入力ください</span></p>
							</div>
							<input type="text" name="zip" value="<?php if(!empty($_POST['zip'])) echo $_POST['zip']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['zip'])) echo $err_msg['zip'];
							?>
						</div>
	<!--					都道府県-->
						<label class="<?php if(!empty($err_msg['prefecture'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">住所（都道府県）</p>
							</div>
							<input type="text" name="prefecture" value="<?php if(!empty($_POST['prefecture'])) echo $_POST['prefecture']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['prefecture'])) echo $err_msg['prefecture'];
							?>
						</div>
	<!--				市町村-->
						<label class="<?php if(!empty($err_msg['town'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">住所（市町村）</p>
							</div>
							<input type="text" name="town" value="<?php if(!empty($_POST['town'])) echo $_POST['town']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['town'])) echo $err_msg['town'];
							?>
						</div>
	<!--				番地・マンション名-->
						<label class="<?php if(!empty($err_msg['section'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">住所（番地・マンション名）</p>
							</div>
							<input type="text" name="section" value="<?php if(!empty($_POST['section'])) echo $_POST['section']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['section'])) echo $err_msg['section'];
							?>
						</div>
<!--						変更するボタン-->
						<div class="change-prf">
							<input type="submit" class='change-prf-btn' value="変更する">
						</div>
<!--						ボタン終了-->
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
