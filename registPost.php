<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');
?>




<!----------------ビュー--------------------------->


<?php
$siteTitle = (!$edit_flg) ? '投稿内容編集' : '投稿';
require('head.php'); 
?>
<body>
	<?php
	require('header.php'); 
	?>
	<div class="main-wrapper">
		<h2><?php echo (!$edit_flg) ? '投稿する' : '投稿内容を編集する'; ?></h2>
		<div class="registPost-wrapper">
			<form action="" method="post">
<!--			全体のエラーメッセージ-->
				<div class="area-msg">
					<?php 
					if(!empty($err_msg['common'])) echo $err_msg['common'];
					?>
				</div>
				<div class="postContent_wrapper">
<!--				-->
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
<!--					-->
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
<!--					-->
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
<!--					-->
				</div>
			</form>
		</div>
		<?php
		require('side_bar.php');
		?>
	</div>
	<?php
	require('footer.php'); 
	?>
</body>