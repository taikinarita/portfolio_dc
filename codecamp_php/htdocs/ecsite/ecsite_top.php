<?php
require_once '../../include/ecsite/conf/ecsite_conf.php';
require_once '../../include/ecsite/model/ecsite_model.php';

// セッションスタート
session_start();

// ログイン確認
if (!isset($_SESSION['user_name']) || isset($_SESSION['user_name']) === '') {
  redirect_login();
}
// ログアウト押下時ログアウト処理
if ($_POST['type_of_process'] === 'logout') {
  logout();
}

// リダイレクト前に完了メッセージがあった場合
if (isset($_SESSION['success_message']) && isset($_SESSION['success_message']) !== ''){
  $complete[] = $_SESSION['success_message'];
  $_SESSION['success_message'] = '';
}

// DB接続
$link = db_connect();
// トランザクション開始
transuction_start($link);

// カートに入れる処理
if ($_POST['type_of_process'] === 'add') {
  // cart_tableにINSERTまたはUPDATEするための値をまとめる
  // user_nameからid（user_id）を取得
  if (($user_id = get_user_id($link)) === FALSE) {
    $error[] = 'ユーザーIDを取得できませんでした';
  }
  // item_idをPOSTされたデータから取得する
  $item_id = get_post_data('id');

  // cart_tableへのINSERTまたはUPDATE
  // user_idとitem_idがcart_tableに存在する場合
  $sql = "SELECT amount FROM ecsite_cart_table WHERE user_id = $user_id && item_id = $item_id";
  if (($amount_data = select_sql($link, $sql)) === FALSE) {
    $error[] = '数量データが取得できませんでした';
  }
  $amount = (int)$amount_data[0]['amount'];
  if ($amount !== 0) {
    // 注文数量を１増やす
    $amount++;
    // UPDATE文を実行
    $sql = "UPDATE ecsite_cart_table SET amount = $amount, updated_date = '$date' WHERE user_id = $user_id && item_id = $item_id";
    if (run_sql($link, $sql) !== FALSE) {
      if (run_sql($link, $sql) !== FALSE) {
        $sql = "SELECT name FROM ecsite_item_table WHERE id = $item_id";
        if(($data = select_sql($link, $sql)) !== FALSE){
          $_SESSION['success_message'] = $data[0]['name'] . 'がカートに追加されました';
          transuction_close($link);
          // 二重投稿の防止
          redirect_me();
        }else {
          $error[] = 'カート内容アップデート処理失敗';
        }
      } else {
      $error[] = 'カート内容アップデート処理失敗';
      }
    }
  } else {
    // 注文数量を新たに1と設定
    $amount = 1;
    // INSERT文を実行
    $sql = "INSERT INTO ecsite_cart_table(user_id, item_id, amount, created_date, updated_date) VALUES ($user_id, $item_id, $amount, '$date', '$date')";
    if (run_sql($link, $sql) !== FALSE) {
      $sql = "SELECT name FROM ecsite_item_table WHERE id = $item_id";
      if(($data = select_sql($link, $sql)) !== FALSE){
        $complete[] = $data[0]['name'] . 'がカートに追加されました';
        transuction_close($link);
        // 二重投稿の防止
        redirect_me();
      }else {
        $error[] = 'カート内容追加処理失敗';
      }
    } else {
      $error[] = 'カート内容追加処理失敗';
    }
  }
}

// トランザクションの停止
if (count($error) === 0) {
  transuction_close($link);
} else {
  transuction_rollback($link);
}

// 商品一覧の表示
$sql = "SELECT ecsite_item_table.id, name, price, img, status, stock FROM ecsite_item_table LEFT JOIN ecsite_stock_table ON ecsite_item_table.id = ecsite_stock_table.item_id";
if (($data = select_sql($link, $sql)) === FALSE) {
  $error[] = '一覧表示のSQLが機能しませんでした';
}

// DB接続の停止
db_close($link);

require_once '../../include/ecsite/view/ecsite_top_view.php';