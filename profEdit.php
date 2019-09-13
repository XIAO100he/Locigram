
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
					<div class="">
	<!--------ニックネーム-->
						<label class="<?php if(!empty($err_msg['name'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p>ニックネーム</p>
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
								<p>姓</p>
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
								<p>名</p>
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
								<p>Email</p>
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
								<p>生年月日</p>
							</div>
							<input type="text" name="birthday" value="<?php if(!empty($_POST['birthday'])) echo $_POST['birthday']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['birthday'])) echo $err_msg['birthday'];
							?>
						</div>
	<!--					TEL-->
						<label class="<?php if(!empty($err_msg['tel'])) echo 'err'; ?>">
							<div class="theme-wrapper">
								<p>TEL<span style="font-size:12px;margin-left:5px;">※ハイフン無しでご入力ください</span></p>
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
								<p>郵便番号<span style="font-size:12px;margin-left:5px;">※ハイフン無しでご入力ください</span></p>
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
								<p>住所（都道府県）</p>
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
								<p>住所（市町村）</p>
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
								<p>住所（番地・マンション名）</p>
							</div>
							<input type="text" name="section" value="<?php if(!empty($_POST['section'])) echo $_POST['section']; ?>">
						</label>
						<div class="area-msg">
							<?php
							if(!empty($err_msg['section'])) echo $err_msg['section'];
							?>
						</div>
						<div class="change-prf">
							<input type="submit" class='change-prf-btn' value="変更する">
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
