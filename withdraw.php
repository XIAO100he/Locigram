<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　退会ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();



//================================
// 画面処理
//================================
// post送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');
	//例外処理
	try {
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql1 = 'UPDATE users SET  delete_flg = 1 WHERE id = :us_id';
		// データ流し込み
		$data = array(':us_id' => $_SESSION['user_id']);
		// クエリ実行
		$stmt1 = queryPost($dbh, $sql1, $data);


		// クエリ実行成功の場合（最悪userテーブルのみ削除成功していれば良しとする）
		if($stmt1){
			//セッション削除
			session_destroy();
			debug('セッション変数の中身：'.print_r($_SESSION,true));
			debug('トップページへ遷移します。');
			header("Location:index.php");
		}else{
			debug('クエリが失敗しました。');
			$err_msg['common'] = MSG06;
		}

	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>


<?php
$siteTitle = '退会';
require('head.php');
?>
<?php 
require('header.php');
?>

<div class=withdraw-wrapper>
	<h2>退会手続</h2>
	<form action="" methd="post">
		<div class=withdraw-box>
			<input type="submit" class=withdraw-btn value='退会する' name="submit">
		</div>
	</form>
	<p class='back-to'>
		<a href='mypage.php'>&lt; マイページへ戻る</a>
	</p>
</div>

<?php
require('footer.php');
?>


