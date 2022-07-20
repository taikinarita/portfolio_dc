<?php
// require_once '../../include/ecsite/conf/ecsite_conf.php';


// POSTされた値を格納
function get_post_data($key){
  $str = '';
  if (isset($_POST[$key]) === TRUE) {
    $str = htmlspecialchars($_POST[$key], ENT_QUOTES, HTMLSPECIALCHARS_CHARASET);
  }
  return $str;
}

// 画像ファイルの格納
function get_file_data($key){
  $file = $_FILES[$key];
  if ($file['type'] === 'image/png' || $file['type'] === 'image/jpeg') {
    $save_path = UPLOAD_DIR . date('YmdHis') . $file['name'];
    move_uploaded_file($file['tmp_name'], $save_path);
    return $save_path;
  } else {
    return FALSE;
  }
}

// ログインページへ遷移
function redirect_login(){
  header('Location: ecsite_login.php');
  exit;
}

// ショップページへ遷移
function redirect_top(){
  header('Location: ecsite_top.php');
  exit;
}

// 管理ページへ遷移
function redirect_admin(){
  header('Location: ecsite_admin.php');
  exit;
}

// 二重リロード防止・現在のページにリダイレクト
function redirect_me(){
  header('Location: ' . $_SERVER['SCRIPT_NAME']);
  exit;
}

// ログアウト処理
function logout(){
  $session_name = session_name();
  $_SESSION = [];
  if (isset($_COOKIE['$session_name'])) {
    $params = session_get_cookie_params();
    setcookie(
      $session_name,
      '',
      time() - 42000,
      $params["path"],
      $params["domain"],
      $params["secure"],
      $params["httponly"]
    );
  }
  header('Location: ecsite_login.php');
  exit;
}

// DB接続
function db_connect()
{
  if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
    return FALSE;
  }
  mysqli_set_charset($link, MY_SQLI_CHARASET);
  return $link;
}

// DB接続切断
function db_close($link)
{
  mysqli_close($link);
}

// トランザクション開始
function transuction_start($link)
{
  mysqli_autocommit($link, false);
}

// トランザクション終了
function transuction_close($link)
{
  mysqli_commit($link);
}

// トランザクションロールバック
function transuction_rollback($link)
{
  mysqli_rollback($link);
}

// クエリ実行：INSERT文・UPDATE文・DELETE文
function run_sql($link, $sql)
{
  if (mysqli_query($link, $sql)) {
    $run_id = mysqli_insert_id($link);
    return $run_id;
  } else {
    return FALSE;
  }
}

// SELECT文・データ取得
function select_sql($link, $sql)
{
  if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
      $data[] = $row;
    }
    mysqli_free_result($result);
    return $data;
  } else {
    return FALSE;
  }
}

// ユーザー名でDBから情報検索
function select_where_username($link, $user_name)
{
  $sql = "SELECT * FROM ecsite_user_table WHERE user_name = '$user_name'";
  if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
      $data[] = $row;
    }
    mysqli_free_result($result);
    return $data;
  }
}

// ユーザー名からuser_idを取得(セッション変数にユーザー名が格納されている場合のみ使用可能)
function get_user_id($link)
{
  $user_name = $_SESSION['user_name'];
  $sql = "SELECT id FROM ecsite_user_table WHERE user_name = '$user_name'";
  if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
      $data[] = $row;
    }
    $user_id = $data[0]['id'];
    mysqli_free_result($result);
    return $user_id;
  } else {
    return FALSE;
  }
}