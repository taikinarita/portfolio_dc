<?php
require_once '../../include/ecsite/conf/ecsite_conf.php';
require_once '../../include/ecsite/model/ecsite_model.php';

// DB接続
$link = db_connect();
// トランザクション開始
transuction_start($link);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  // バリデーション————文字数制限英数半角6文字以上正規表現
  $username = get_post_data('username');
  if($username !== ''){
    if(preg_match('/^[a-z\d]{6,}$/i', $username) === 0){
      $error[] = 'ユーザー名は英数半角6文字以上でお願いします';
    }
  }else {
    $error[] = 'ユーザー名を記載してください';
  }
  $password = get_post_data('password');
  if($password !== ''){
    if(preg_match('/^[a-z\d]{6,}$/i', $password) === 0){
      $error[] = 'パスワードは英数半角6文字以上でお願いします';
    }
  }else {
    $error[] = 'パスワードを記載してください';
  }
  
  // DBにデータを保存
  if(count($error) === 0){
    $sql = "INSERT INTO ecsite_user_table(user_name, password, created_date, updated_date) VALUES ('$username', '$password','$date','$date')";
    if(run_sql($link, $sql) !== FALSE){
      $complete[] = '登録完了しました';
    }else{
      $error[] = '登録できませんでした／ユーザー名がが既に使われています';
    }
  }
}


// トランザクションの停止
if(count($error) === 0){
  transuction_close($link);
}else {
  transuction_rollback($link);
}

// DB接続の停止
db_close($link);

require_once '../../include/ecsite/view/ecsite_register_view.php';
