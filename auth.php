<?php

if(!empty($_SESSION['login_date'])){
	debug('ログイン済みユーザーです');
	
	if(($_SESSION['login_data']+$_SESSION['login_limit']) < time()) {
		debug('ログイン有効期限オーバーです');
		session_destroy();
		header('Location:login.php');
	} else {
		debug('有効期限内です');
		$_SESSION['login_data'] = time();
	
		if(basename($_SERVER['PHP_SELF'] === 'login.php')){
			debug('インデックスページへ遷移します');
			header('Location:index.php');
		}
	}
} else {
	debug('未ログインユーザーです');
	if(basename($_SERVER['PHP_SELF']) !== 'login.php'){
		header('Location:login.php');
	}
}
?>