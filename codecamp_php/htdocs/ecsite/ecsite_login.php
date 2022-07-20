<!-- セキュリティ対策 -->

<?php
require_once '../../include/ecsite/conf/ecsite_conf.php';
require_once '../../include/ecsite/model/ecsite_model.php';

// セッションスタート
session_start();

// ログイン確認
if ($_SESSION['user_name'] === 'admin') {
  redirect_admin();
} else if (isset($_SESSION['user_name']) && isset($_SESSION['user_name']) !== '') {
  redirect_top();
}
// DB接続
$link = db_connect();
// トランザクション開始
transuction_start($link);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // バリデーション————入力されているか
  $username = get_post_data('username');
  if ($username === '') {
    $error[] = 'ユーザー名を記載してください';
  }
  $password = get_post_data('password');
  if ($password === '') {
    $error[] = 'パスワードを記載してください';
  }

  if (count($error) === 0) {
    $data = select_where_username($link, $username);
    // 入力されたユーザー名とパスワードがDB登録データと一致しているか
    if (isset($data) && $data !== '') {
      if ($password === $data[0]['password']) {
        // ログイン成功時の処理
        // セッションハイジャック対策
        session_regenerate_id(true);
        // セッションにユーザー名を保存
        $_SESSION['user_name'] = $username;
        if ($username === 'admin') {
          // 管理ページに飛ぶ
          redirect_admin();
        } else {
          // 購入ページに飛ぶ
          redirect_top();
        }
      } else {
        $error[] = 'ユーザー名かパスワードが違います';
      }
    } else {
      $error[] = 'ユーザー名かパスワードが違います';
    }
  }
}

// トランザクションの停止
if (count($error) === 0) {
  transuction_close($link);
} else {
  transuction_rollback($link);
}

// DB接続の停止
db_close($link);

require_once '../../include/ecsite/view/ecsite_login_view.php';