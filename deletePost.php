<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿削除ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id']: '';
$dbFormData = (!empty($p_id)) ? getPost($_SESSION['user_id'], $p_id) : '';

if(!empty($_POST)){
	debug('POST送信があります。');
	try {
		$dbh = dbConnect();
		$sql = 'DELETE FROM post WHERE id = :p_id';
		$data = array(':p_id' => $p_id);
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			debug('自分の投稿一覧へ遷移します。');
			header("Location:postHis.php");
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
$siteTitle = '投稿削除';
require('head.php');
?>
<?php 
require('header.php');
?>
<div class=withdraw-wrapper>
	<h2>投稿削除</h2>
	<form action="" method="post">
		<p class="deleteMsg">本当に削除しますか？</p>
		<div class=delete-box>
			<input type="submit" class='delete-btn' value='削除する' name="submit">
		</div>
	</form>
	<p class='back-to'>
		<a href='mypage.php'>&lt; マイページへ戻る</a>
	</p>
</div>

<?php
require('footer.php');
?>
