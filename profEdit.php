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

$dbAreaData = getArea();
debug('エリアデータ：'.print_r($dbAreaData,true));


	if(!empty($_POST)){
		debug('POST送信があります');
		debug('POST情報:'.print_r($_POST, true));

		$name = $_POST['name'];
		$email = $_POST['email'];
		$area = $_POST['area_id'];
		$town = $_POST['town'];
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];

		if($dbFormData['name'] !== $name){
			validMaxLen($name, 'name');
		}
		if($dbFormData['email'] !== $email){
			validMaxLen($email, 'email');
			if(empty($err_msg['email'])){
				validEmailDup($email);
			}
		}
		if($dbFormData['area_id'] !== $area){
			validSelect($area,'area_id');
		}
		if($dbFormData['town'] !== $town){
			validMaxLen($town, 'town');
		}
		if($dbFormData['year'] !== $year){
			validSelect($year, 'year');
		}

		if(empty($err_log)){
			debug('バリデーションOKです');
			try{
				$dbh = dbConnect();
				$sql = 'UPDATE users  SET name = :u_name, email = :email, area_id = :area, town = :town , year = :year, month = :month, day = :day WHERE id = :u_id';
				$data = array(':u_name' => $name,':email' => $email,':year' => $year, ':month' => $month, ':day' => $day, ':area'=> $area,':town' => $town, ':u_id' => $dbFormData['id']);
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
		<!--	パンくずリスト-->
	<div class="breadcrumd">
		<span class="bread past"><a href="index.php" class=''>トップページ</a></span>
		<span><i class="fas fa-chevron-left"></i></span>
		<span class="bread past"><a href="mypage.php" class=''>マイページ</a></span>
		<span><i class="fas fa-chevron-left"></i></span>
		<span class="bread now"><a href="#" class=''>プロフィール編集</a></span>
	</div>
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
							<input type="text" name="name" value="<?php echo getFormData('name'); ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['name'])) echo $err_msg['name'];
							?>
						</div>
	<!--					Email-->
						<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">Email</p>
							</div>
							<input type="text" name="email" value="<?php echo getFormData('email'); ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['email'])) echo $err_msg['email'];
							?>
						</div>
	<!--					都道府県-->
						<label class="<?php if(!empty($err_msg['area_id'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">住所（都道府県）</p>
							</div>
							<select class="profAreaSelect" name="area_id">
								<option value="0" <?php if(getFormData('area_id') ==0){ echo 'selected'; } ?>> 選択してください</option>
								<?php
								foreach($dbAreaData as $key => $val){
								?>
								<option value="<?php echo $val['id'] ?>" <?php if(getFormData('area_id') == $val['id'] ) { echo 'selected'; } ?> >
									<?php echo $val['name']; ?>
								</option>
								<?php
								}
								?>
							</select>
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['area_id'])) echo $err_msg['area_id'];
							?>
						</div>
						
	<!--				市町村-->
						<label class="<?php if(!empty($err_msg['town'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p class="sub_theme">住所（市町村）</p>
							</div>
							<input type="text" name="town" value="<?php echo getFormData('town'); ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['town'])) echo $err_msg['town'];
							?>
						</div>
						
					<!--				生年月日-->
					<label class="<?php if(!empty($err_msg['year'])) echo 'err'; ?>">
						<div class="theme-wrapper">
							<p class="sub_theme">生年月日</p>
						</div>
						<select class="birthday" name='year'>
							<option value="<?php echo getFormData('year'); ?>">--</option>
							<option selected>1980</option>
							<?php foreach(range(1960,2019) as $year): ?>
							<option value="<?=$year?>"><?=$year?></option>
							<?php endforeach; ?>
						</select>
						<select class="birthday" name="month">
							<option value="<?php echo getFormData('month'); ?>">--</option>
							<option selected>1</option>
							<?php foreach(range(1,12) as $month): ?>
							<option value="<?=str_pad($month,2,0,STR_PAD_LEFT)?>"><?=$month?></option>
							<?php endforeach; ?>
						</select>
						<select class="birthday" name="day">
							<option value="<?php echo getFormData('day'); ?>">--</option>
							<option selected>1</option>
							<?php foreach(range(1,31) as $day): ?>
							<option value="<?=str_pad($day,2,0,STR_PAD_LEFT)?>"><?=$day?></option>
							<?php endforeach; ?>
						</select>
					</label>
					<div class="area-msg">
						<?php
						if(!empty($err_msg['year'])) echo $err_msg['year'];
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
