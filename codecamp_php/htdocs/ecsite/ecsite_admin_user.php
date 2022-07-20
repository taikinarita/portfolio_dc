<?php
require_once '../../include/ecsite/conf/ecsite_conf.php';
require_once '../../include/ecsite/model/ecsite_model.php';


// セッションスタート
session_start();
// ログイン確認
if (!isset($_SESSION['user_name']) || isset($_SESSION['user_name']) === '') {
    redirect_login();
} else if ($_SESSION['user_name'] !== 'admin') {
    redirect_top();
}
// ログアウト押下時ログアウト処理
if ($_POST['type_of_process'] === 'logout') {
    logout();
}
// DB接続
$link = db_connect();

// 一覧表示
$sql = "SELECT user_name, created_date FROM ecsite_user_table";
if (($data = select_sql($link, $sql)) === FALSE) {
    $error[] = '一覧表示のSQLが機能しませんでした';
}

// DB接続の停止
db_close($link);

require_once '../../include/ecsite/view/ecsite_admin_user_view.php';