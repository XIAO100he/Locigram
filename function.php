<?php
//================================
// ログ
//================================
//ログを取るか
ini_set('log_errors','on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');

//================================
// デバッグ
//================================
//デバッグフラグ
$debug_flg = true;
//デバッグログ関数
function debug($str){
	global $debug_flg;
	if(!empty($debug_flg)){
		error_log('デバッグ：'.$str);
	}
}

//================================
// セッション準備・セッション有効期限を延ばす
//================================
//セッションファイルの置き場を変更する（/var/tmp/以下に置くと30日は削除されない）
session_save_path("/var/tmp/");
//ガーベージコレクションが削除するセッションの有効期限を設定（30日以上経っているものに対してだけ１００分の１の確率で削除）
ini_set('session.gc_maxlifetime', 60*60*24*30);
//ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime ', 60*60*24*30);
//セッションを使う
session_start();
//現在のセッションIDを新しく生成したものと置き換える（なりすましのセキュリティ対策）
session_regenerate_id();

//================================
// 画面表示処理開始ログ吐き出し関数
//================================
function debugLogStart(){
	debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
	debug('セッションID：'.session_id());
	debug('セッション変数の中身：'.print_r($_SESSION,true));
	debug('現在日時タイムスタンプ：'.time());
	if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
		debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
	}
}

//================================
// エラーメッセージ定数
//================================
define('MSG01', '※必ずご入力ください');
define('MSG02', '※正しい形式でご入力ください');
define('MSG03', '※そのメールアドレスは既に登録されています');
define('MSG04', '※半角英数字6文字以上でご入力ください');
define('MSG05', '※パスワードが一致しません');
define('MSG06', 'エラーが発生しました。しばらく経ってからやり直してください');
define('MSG07', 'メールアドレスもしくはパスワードが違います');
define('MSG08', '電話番号の形式が違います');
define('MSG09', '郵便番号の形式が違います');
define('MSG10', '古いパスワードが違います');
define('MSG11', '古いパスワードと同じです');
define('MSG12', '正しくありません');
define('SUC01', 'パスワードを変更しました');
define('SUC02', 'プロフィールを変更しました');
define('SUC03', 'メールを送信しました');
define('SUC04', '登録しました');




//================================
// グローバル変数
//================================
$err_msg = array();

//================================
// バリデーション関数
//================================

//バリデーション関数(未入力チェック)
function validRequired($str, $key){
	if(empty($str)){
		global $err_msg;
		$err_msg[$key] = MSG01;
	}
}
//バリデーション関数（形式チェック）
function validEmail($str, $key){
	if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG02;
	}
}
//バリデーション関数（Email重複チェック）
function validEmailDup($email){
	global $err_msg;
	//例外処理
	try {
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';

		$data = array(':email' => $email);

		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);

		// クエリ結果の値を取得
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty(array_shift($result))){
			$err_msg['email'] = MSG03;
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
		$err_msg['common'] = MSG06;
	}
}

//バリデーションチェック（同値確認）
function validMatch($str1, $str2, $key){
	if($str1 !== $str2){
		global $err_msg;
		$err_msg[$key] = MSG05;
	}
}
//バリデーションチェック（最大文字数）
function validMaxLen($str, $key, $max = 255){
	if(mb_strlen($str) > $max){
		global $err_msg;
		$err_msg[$key] = MSG06;
	}
}
//バリデーションチェック（最小文字数）
function validMinLen($str, $key, $min = 6){
	if(mb_strlen($str) < $min){
		global $err_msg;
		$err_msg[$key] = MSG04;
	}
}
//バリデーション関数（半角チェック）
function validHalf($str, $key){
	if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG04;
	}
}
//電話番号形式チェック
function validTel($str, $key){
	if(!preg_match("/0\d{1,4}\d{1,4}\d{4}/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG08;
	}
}
//郵便番号形式チェック
function validZip($str, $key){
	if(!preg_match("/^\d{7}$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG09;
	}
}
//エラーメッセージ表示
function getErrMsg($key){
	global $err_msg;
	if(!empty($err_msg[$key])){
		return $err_msg[$key];
	}
}
//パスワードチェック
function validPass($str, $key){
	//半角英数字チェック
	validHalf($str, $key);
	//最大文字数チェック
	validMaxLen($str, $key);
	//最小文字数チェック
	validMinLen($str, $key);
}
//selectboxチェック
function validSelect($str, $key){
	if(!preg_match("/^[0-9]+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG12;
	}
}

//================================
// ログイン認証
//================================
function isLogin(){
	// ログインしている場合
	if( !empty($_SESSION['login_date']) ){
		debug('ログイン済みユーザーです。');

		// 現在日時が最終ログイン日時＋有効期限を超えていた場合
		if( ($_SESSION['login_date'] + $_SESSION['login_limit']) < time()){
			debug('ログイン有効期限オーバーです。');

			// セッションを削除（ログアウトする）
			session_destroy();
			return false;
		}else{
			debug('ログイン有効期限以内です。');
			return true;
		}

	}else{
		debug('未ログインユーザーです。');
		return false;
	}
}

//================================
// データベース
//================================
//DB接続関数
function dbConnect(){
	//DBへの接続準備
	$dsn = 'mysql:dbname=locigram;host=localhost;charset=utf8';

	$user = 'root';
	$password = 'root';
	
	$options = array(
		// SQL実行失敗時にはエラーコードのみ設定（自分が指定したエラーコードの方に処理が移るようにする為）
		PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
		// デフォルトフェッチモードを連想配列形式に設定
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		// バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
		// SELECTで得た結果に対してもrowCountメソッドを使えるようにする
		PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
	);
	// PDOオブジェクト生成（DBへ接続）
	$dbh = new PDO($dsn, $user, $password, $options);
	return $dbh;
}
//SQL実行関数
function queryPost($dbh, $sql, $data){
	//クエリー作成
	$stmt = $dbh->prepare($sql);
	//プレースホルダに値をセットし、SQL文を実行
	if(!$stmt->execute($data)){
		debug('クエリに失敗しました。');
		debug('失敗したSQL：'.print_r($stmt,true));
		$err_msg['common'] = MSG07;
		return 0;
	}
	debug('クエリ成功。');
	return $stmt;
}

//ユーザー情報を取る
function getUser($u_id){
	debug('ユーザー情報を取得します');
	
	try{
		$dbh = dbConnect();
		$sql = 'SELECT * FROM users WHERE id = :u_id AND delete_flg = 0';
		$data = array(':u_id'=> $u_id);
		$stmt = queryPost($dbh,$sql,$data);
		
		if($stmt){
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	} catch (Exception $e){
		error_log('エラー発生'.$e-> getMessage());
	}
}

//ポスト情報を取る
function getPost($u_id, $p_id){
	debug('投稿内容を取得します。');
	debug('ユーザーID：'.$u_id);
	debug('投稿ID：'.$p_id);

	try {
		$dbh = dbConnect();
		$sql = 'SELECT * FROM post WHERE user_id = :u_id AND id = :p_id AND delete_flg = 0';
		$data = array(':u_id' => $u_id, ':p_id' => $p_id);
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
	}
}

//全てのポスト情報を取る
function getPosts(){
	debug('全ての投稿内容を取得します');
	try{
		$dbh = dbConnect();
		$sql = 'SELECT * FROM post';
		$data = array();
		$stmt = queryPost($dbh, $sql, $data);
		
		if($stmt){
			return $stmt->fetchAll();
		}else{
			return false;
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
	}
}

//ジャンル情報を取る
function getGenre(){
	debug('ジャンル情報を取得します。');

	try {
		$dbh = dbConnect();
		$sql = 'SELECT * FROM genre';
		$data = array();
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			return $stmt->fetchAll();
		}else{
			return false;
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
	}
}

//エリア情報を取る
function getArea(){
	debug('エリア情報を取得します。');

	try {
		$dbh = dbConnect();
		$sql = 'SELECT * FROM area';
		$data = array();
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			return $stmt->fetchAll();
		}else{
			return false;
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
	}
}

//投稿内容をリストとして取得（トップページ用）
function getPostList($currentMinNum =1, $span=12){
	debug('投稿内容を取得します');
	try{
		$dbh = dbConnect();
		$sql = 'SELECT id FROM post';
		$data = array();
		$stmt = queryPost($dbh,$sql,$data);
		//総件数
		$rst['total'] = $stmt->rowCount();
		//総ページ数ceilは切り上げ関数
		$rst['total_page'] = ceil($rst['total']/$span);
		if($stmt){
			return false;
		}
		
		//ページング用のSQL
		$sql ='SELECT * FROM post';
		$sql ='LIMIT'.$span.'OFFSET'.$currentMinNum;
		$data = array();
		debug('SQL:'.$sql);
		$stmt = queryPost($dbh,$sql,$data);
		
		if($stmt){
			$rst['data']=$stmt->fetchAll();
			return $rst;
		} else {
			return false;
		}
	} catch(Exception, $e){
		error_log('エラー発生：'.$e-> getMessage());
	}
}

//自分の投稿全て取得
function getMyPosts($u_id){
	debug('自分の商品情報を取得します。');
	debug('ユーザーID：'.$u_id);

	try {
		$dbh = dbConnect();
		$sql = 'SELECT * FROM post WHERE user_id = :u_id AND delete_flg = 0';
		$data = array(':u_id' => $u_id);
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			return $stmt->fetchAll();
		}else{
			return false;
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
	}
}
//マイページ用　最新３件だけ取得
function getMyPosts3($u_id){
	debug('自分の商品情報を取得します。');
	debug('ユーザーID：'.$u_id);
	
	try {
		$dbh = dbConnect();
		$sql = 'SELECT * FROM post WHERE user_id = :u_id AND delete_flg = 0 ORDER BY create_date DESC limit 3';
		$data = array(':u_id' => $u_id);
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			return $stmt->fetchAll();
		}else{
			return false;
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
	}
}
//================================
// その他
//================================
// サニタイズ
function sanitize($str){
	return htmlspecialchars($str,ENT_QUOTES);
}
// フォーム入力保持
function getFormData($str, $flg = false){
	if($flg){
		$method = $_GET;
	}else{
		$method = $_POST;
	}
	global $dbFormData;
	// ユーザーデータがある場合
	if(!empty($dbFormData)){
		//フォームのエラーがある場合
		if(!empty($err_msg[$str])){
			//POSTにデータがある場合
			if(isset($method[$str])){
				return sanitize($method[$str]);
			}else{
				//ない場合（基本ありえない）はDBの情報を表示
				return sanitize($dbFormData[$str]);
			}
		}else{
			//POSTにデータがあり、DBの情報と違う場合
			if(isset($method[$str]) && $method[$str] !== $dbFormData[$str]){
				return sanitize($method[$str]);
			}else{
				return sanitize($dbFormData[$str]);
			}
		}
	}else{
		if(isset($method[$str])){
			return sanitize($method[$str]);
		}
	}
}

//画像処理
function uploadImg($file,$key){
	debug('画像アップロード処理開始');
	debug('FILE情報：'.print_r($file,true));
	
	if(isset($file['error']) && is_int($file['error'])){
		try{
			switch($file['error']){
				case UPLOAD_ERR_OK://OKの意味
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('ファイルが選択されていません');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('ファイルサイズが大きすぎます');
				default:
					throw new RuntimeException('その他のエラーが発生しました');
			}
			//ファイルのMIMEタイプを自動チェック。MINEタイプ＝拡張子と同じ。ファイルタイプ。
			//exif_imageタイプは必ず＠をつける。エラーが起きた時に実行させるために
			$type = @exif_imagetype($file['tmp_name']);
			if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) { // 第三引数にはtrueを設定すると厳密にチェックしてくれるので必ずつける
				throw new RuntimeException('画像形式が未対応です');
			}
			$path ='uploads/'.sha1_file($file['tmp_name']).image_type_to_extension($type);
			if (!move_uploaded_file($file['tmp_name'], $path)) {
				throw new RuntimeException('ファイル保持時にエラーが発生しました');
			}
			chmod($path, 0644);
			
			debug('ファイルは正常にアップロードされました');
			debug('ファイルパス：'.$path);
			return $path;
		} catch (RuntimeException $e){
			debug($e->getMessage());
			global $err_msg;
			$err_msg[$key]= $e->getMessage();
		}
	}
}
//画像表示用関数
function showImg($path){
	if(empty($path)){
		return 'img/sample-img.png';
	}else{
		return $path;
	}
}
//GETパラメータ付与
// $del_key : 付与から取り除きたいGETパラメータのキー
function appendGetParam($arr_del_key = array()){
	if(!empty($_GET)){
		$str = '?';
		foreach($_GET as $key => $val){
			if(!in_array($key,$arr_del_key,true)){ //取り除きたいパラメータじゃない場合にurlにくっつけるパラメータを生成
				$str .= $key.'='.$val.'&';
			}
		}
		$str = mb_substr($str, 0, -1, "UTF-8");
		return $str;
	}
}

?>