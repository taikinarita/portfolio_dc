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

// DB接続
$link = db_connect();
// トランザクション開始
transuction_start($link);

// カート内の商品一覧の表示
$user_id = get_user_id($link);
$sql = "SELECT ecsite_item_table.id, name, price, img, status, stock, amount FROM ecsite_cart_table LEFT JOIN ecsite_stock_table ON ecsite_cart_table.item_id = ecsite_stock_table.item_id LEFT JOIN ecsite_item_table ON ecsite_cart_table.item_id = ecsite_item_table.id WHERE user_id = $user_id";
if (($data = select_sql($link, $sql)) === FALSE) {
  $error[] = '一覧表示のSQLが機能しませんでした';
}
if($data !== null){
  for ($i = 0; $i < count($data); $i++) {
    // ステータスが非公開の場合カートの中身から外す
    if ($data[$i]['status'] === 0) {
      $id = $data[$i]['id'];
      $sql = "DELETE FROM ecsite_cart_table WHERE user_id = $user_id && item_id = $id";
      if (run_sql($link, $sql) !== FALSE) {
        $error[] = "$data[$i]['name']は販売していないため取引が停止されました";
      } else {
        $error[] = 'ステータスエラーによる削除に失敗しました';
      }
    }
    // 在庫数と購入数の比較で購入数が上回る場合購入できないようにする
    if ($data[$i]['stock'] < $data[$i]['amount']) {
      $id = $data[$i]['id'];
      $sql = "DELETE FROM ecsite_cart_table WHERE user_id = $user_id && item_id = $id";
      if (run_sql($link, $sql) !== FALSE) {
        $lack_name = $data[$i]['name'];
        $error[] = "$lack_name は在庫がないため取引が停止されました";
      } else {
        $error[] = '在庫数エラーによる削除に失敗しました';
      }
    }
    if (count($error) === 0) {
      // 合計金額の算出
      $total += $data[$i]['price'] * $data[$i]['amount'];
      // 在庫数を購入数に応じて減らす
      $new_stock = $data[$i]['stock'] - $data[$i]['amount'];
      $id = $data[$i]['id'];
      $sql = "UPDATE ecsite_stock_table SET stock = $new_stock, updated_date = '$date' WHERE item_id = $id";
      if (run_sql($link, $sql) === FALSE) {
        $error[] = '在庫更新失敗';
      }
    }
  }
}

// カート内の商品情報の削除
if (count($error) === 0) {
  $sql = "DELETE FROM ecsite_cart_table WHERE user_id = $user_id";
  if (run_sql($link, $sql) !== FALSE) {
    $complete[] = "ご購入ありがとうございました。";
  } else {
    $error[] = 'カート内情報の削除に失敗しました';
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

require_once '../../include/ecsite/view/ecsite_finish_view.php';