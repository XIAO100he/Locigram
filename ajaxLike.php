<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　Ajax　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

if(isset($_POST['postId']) && isset($_SESSION['user_id']) && isLogin()){
	debug('POST送信があります');
	$p_id = $_POST['postId'];
	debug('投稿ID：'.$p_id);
	
	try{
		$dbh = dbConnect();
		$sql ='SELECT * FROM `like` WHERE post_id = :p_id AND user_id = :u_id';
		$data = array(':u_id'=> $_SESSION['user_id'], ':p_id' => $p_id);
		$stmt = queryPost($dbh, $sql, $data);
		$resultCount = $stmt->rowCount();
		debug($resultCount);
		//レコードが１件でもある場合
		if(!empty($resultCount)){
			$sql = 'DELETE FROM `like` WHERE post_id = :p_id AND user_id = :u_id';
			$data = array(':u_id' => $_SESSION['user_id'], ':p_id' => $p_id);
			$stmt = queryPost($dbh, $sql, $data);
		} else {
			$sql = 'INSERT INTO `like` (post_id,user_id,create_date) VALUES (:p_id,:u_id,:date)';
			$data = array(':u_id'=> $_SESSION['user_id'], ':p_id' => $p_id, ':date'=> date('Y-m-d H:i:s'));
			$stmt = queryPost($dbh, $sql, $data);
		}
	} catch (Exception $e){
		error_log('エラー発生：'.$e->getMessage());
	}
}

debug('Ajax処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>