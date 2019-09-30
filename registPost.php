<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

require('auth.php');

$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id']: '';
$dbFormData = (!empty($p_id)) ? getPost($_SESSION['user_id'], $p_id) : '';
$edit_flg = (empty($dbFormData)) ? false : true ;

$dbGenreData = getGenre();
debug('投稿ID：'.$p_id);
debug('フォーム用DBデータ：'.print_r($dbFormData,true));
debug('ジャンルデータ：'.print_r($dbGenreData,true));

$dbAreaData = getArea();
debug('投稿ID：'.$p_id);
debug('フォーム用DBデータ：'.print_r($dbFormData,true));
debug('エリアデータ：'.print_r($dbAreaData,true));

if(!empty($p_id) && empty($dbFormData)){
	debug('GETパラメーターのポストIDが違います。マイページ変遷します。');
	header('Location:mypage.php');
}

if(!empty($_POST)){
	debug('POST送信があります');
	debug('POST情報：'.print_r($_POST, true));
	debug('FILE情報：'.print_r($_FILES,true)); //※
	
	$title = $_POST['title'];
	$genre = $_POST['genre_id'];
	$area = $_POST['area_id'];
	$comment = $_POST['comment'];
	debug('変数定義した');
	
	$pic1 = ( !empty($_FILES['pic1']['name']) ) ? uploadImg($_FILES['pic1'],'pic1') : ''; //※
	$pic1 = ( empty($pic1) && !empty($dbFormData['pic1']) ) ? $dbFormData['pic1'] : $pic1;
	$pic2 = ( !empty($_FILES['pic2']['name']) ) ? uploadImg($_FILES['pic2'],'pic2') : ''; //※
	$pic2 = ( empty($pic2) && !empty($dbFormData['pic2']) ) ? $dbFormData['pic2'] : $pic2;
	$pic3 = ( !empty($_FILES['pic3']['name']) ) ? uploadImg($_FILES['pic3'],'pic3') : ''; //※
	$pic3 = ( empty($pic3) && !empty($dbFormData['pic3']) ) ? $dbFormData['pic3'] : $pic3;
	debug('pic関連OK');

	if(empty($dbFormData)){
		validRequired($title, 'title');
		validRequired($genre, 'genre_id');
		validRequired($area, 'area_id');
		debug('未入力チェック完了');
		
		validMaxLen($title,'title');
		validSelect($genre,'genre_id');
		validSelect($area,'area_id');
		validMaxLen($comment, 'comennt', 500); //※
	} else {
		if($dbFormData['title'] !== $title){
			validRequired($title, 'title');
			validMaxLen($title,'title');
		}
		if($dbFormData['genre_id'] !== $genre){
			validSelect($genre,'genre_id');
		}
		if($dbFormData['area_id'] !== $area){
			validSelect($area,'area_id');
		}
		if($dbFormData['comment'] !== $comment){
			validMaxLen($comment, 'comennt', 500);//※
		}
	}
	
	if(empty($err_msg)){
		debug('バリデーションOKです');
		
		try{
			$dbh = dbConnect();
			if($edit_flg){
				debug('DB更新です');
				$sql = 'UPDATE post SET title= :title, genre_id = :genre, area_id = :area, comment = :comment, pic1 =:pic1, pic2 = :pic2, pic3 = pic3 WHERE user_id = :u_id AND id = :p_id';
				$data = array(':title' => $title, ':genre'=> $genre, ':area'=> $area, ':comment' => $comment, ':pic1'=>$pic1, ':pic2'=> $pic2, ':pic3'=> $pic3, ':u_id'=> $_SESSION['user_id'], ':p_id' => $p_id);
			} else {
				debug('DB新規登録です');
				$sql = 'insert into post (title, genre_id, area_id, comment, pic1, pic2, pic3, user_id, create_date ) values (:title, :genre, :area, :comment,  :pic1, :pic2, :pic3, :u_id, :date)';
				$data = array(':title'=>$title, ':genre' =>$genre, ':area'=>$area, ':comment'=>$comment, ':pic1'=>$pic1, ':pic2'=>$pic2, ':pic3'=>$pic3, ':u_id'=>$_SESSION['user_id'], ':date'=> date('Y-m-d H:i:s'));
			}
			debug('SQL:'.$sql);
			debug('流し込みデータ：'.print_r($data,true));
			
			$stmt = queryPost($dbh, $sql, $data);
			
			if($stmt){
				$_SESSION['msg_success'] = SUC04;
				debug('マイページへ遷移します');
				header('Location:mypage.php');
			}
		} catch (Exception $e){
			error_log('エラー発生：'. $e->getMessage());
			$err_msg['common'] =MSG07;
		}
	}
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
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
		<h2><?php echo (!$edit_flg) ? '投稿する' : '編集する'; ?></h2>
		<div class="registPost-wrapper">
			<form action="" method="post" enctype="multipart/form-data">
<!--			全体のエラーメッセージ-->
				<div class="area-msg">
					<?php 
					if(!empty($err_msg['common'])) echo $err_msg['common'];
					?>
				</div>
				<div class="postContent_wrapper">
<!--		タイトル		-->
					<label class="<?php if(!empty($err_msg['title'])) echo 'err'; ?>">
						<div class="theme-wrapper">
							<p class="sub_theme">タイトル<span class="must">必須</span></p>
						</div>
						<input type="text" name="title" placeholder="　東京タワー　(※場所名、店名、イベント名等を入れてください)" value="<?php echo getFormData('title'); ?>">
					</label>
					<div class="area-msg">
						<?php
						if(!empty($err_msg['title'])) echo $err_msg['title'];
						?>
					</div>
<!--		エリア			-->
					<label class="<?php if(!empty($err_msg['area_id'])) echo 'err'; ?>">
						<div class="theme-wrapper">
							<p class="sub_theme area">地域<span class="must">必須</span></p>
						</div>
						<select class="postSelect" name="area_id">
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
<!--		ジャンル			-->
					<label class="<?php if(!empty($err_msg['genre_id'])) echo 'err'; ?>">
						<div class="theme-wrapper">
							<p class="sub_theme genre">ジャンル<span class="must">必須</span></p>
						</div>
						<select class="postSelect" name="genre_id">
							<option value="0" <?php if(getFormData('genre_id') ==0){ echo 'selected'; } ?>> 選択してください</option>
							<?php
							foreach($dbGenreData as $key => $val){
							?>
							<option value="<?php echo $val['id'] ?>" <?php if(getFormData('genre_id') == $val['id'] ) { echo 'selected'; } ?> >
								<?php echo $val['name']; ?>
							</option>
							<?php
							}
							?>
						</select>
					</label>
					<div class="area-msg">
						<?php
						if(!empty($err_msg['genre_id'])) echo $err_msg['genre_id'];
						?>
					</div>
<!--		コメント			-->
					<label class="<?php if(!empty($err_msg['comment'])) echo 'err'; ?>">
						<div class="theme-wrapper">
							<p class="sub_theme comment">コメント</p>
						</div>
						<textarea name="comment" id="js-count" cols="30" rows="10" style="height:150px;"><?php echo getFormData('comment'); ?></textarea>
					</label>
					<p class="counter-text"><span id="js-count-view">0</span>/250文字</p>
					<div class="area-msg">
						<?php
						if(!empty($err_msg['comment'])) echo $err_msg['comment'];
						?>
					</div>
<!--		画像			-->
<!--					１枚目-->
						<div class="imgDrop-container">
							画像１
							<label class="area-drop <?php if(!empty($err_msg['pic1'])) echo 'err'; ?>">
								<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
								<input type="file" name="pic1" class="input-file">
								<img src="<?php echo getFormData('pic1'); ?>" alt="" class="prev-img" style="<?php if(empty(getFormData('pic1'))) echo 'display:none;' ?>">
								ドラッグ＆ドロップ
							</label>
							<div class="area-msg">
								<?php 
								if(!empty($err_msg['pic1'])) echo $err_msg['pic1'];
								?>
							</div>
						</div>
<!--					２枚目-->
						<div class="imgDrop-container">
							画像２
							<label class="area-drop <?php if(!empty($err_msg['pic2'])) echo 'err'; ?>">
								<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
								<input type="file" name="pic2" class="input-file">
								<img src="<?php echo getFormData('pic2'); ?>" alt="" class="prev-img" style="<?php if(empty(getFormData('pic2'))) echo 'display:none;' ?>">
								ドラッグ＆ドロップ
							</label>
							<div class="area-msg">
								<?php 
								if(!empty($err_msg['pic2'])) echo $err_msg['pic2'];
								?>
							</div>
						</div>
<!--					３枚目-->
						<div class="imgDrop-container">
							画像３
							<label class="area-drop <?php if(!empty($err_msg['pic3'])) echo 'err'; ?>">
								<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
								<input type="file" name="pic3" class="input-file">
								<img src="<?php echo getFormData('pic3'); ?>" alt="" class="prev-img" style="<?php if(empty(getFormData('pic3'))) echo 'display:none;' ?>">
								ドラッグ＆ドロップ
							</label>
							<div class="area-msg">
								<?php 
								if(!empty($err_msg['pic3'])) echo $err_msg['pic3'];
								?>
							</div>
						</div>

<!--		画像終了-->
<!--				ボタン-->
					<div class="photoPost">
						<input type="submit" class='photoPost-btn' value="<?php echo (!$edit_flg) ? '投稿する' : '更新する'; ?>">
					</div>
<!--					ボタン終了-->
<!--			削除ボタン-->
					<?php	if(!empty($edit_flg)){ ?>
					<div class="deletePost">
						<p class="deletePost-btn"><a href="deletePost.php" class="deleteBtn">投稿を削除する</a></p>
					</div>
					<?php } ?>
<!--					ボタン終了-->
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