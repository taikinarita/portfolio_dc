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

// 削除
if ($_POST['type_of_process'] === 'delete') {
  $user_id = get_user_id($link);
  $item_id = get_post_data('delete_id');
  $sql = "SELECT name FROM ecsite_item_table WHERE id = $change_id";
  if (($data = select_sql($link, $sql)) !== FALSE) {
    $complete_name = $data[0]['name'];
  }
  $sql = "DELETE FROM ecsite_cart_table WHERE user_id = $user_id && item_id = $item_id";
  if (run_sql($link, $sql) !== FALSE) {
    $complete[] = $complete_name . '削除完了';
  } else {
    $error[] = '削除に失敗しました';
  }
}

// 数量変更：バリデーション正の整数のみ
if ($_POST['type_of_process'] === 'change_count') {
  $user_id = get_user_id($link);
  $item_id = get_post_data('change_id');
  $change_amount = get_post_data('change_amount');
  if ($change_amount !== '') {
    if (preg_match("/^\d+$/", $change_amount) === 1) {
      if ((int)$change_amount < 0) {
        $error[] = '数量は0以上の整数を入力してください';
      }
    } else {
      $error[] = '数量は0以上の整数を入力してください';
    }
  } else {
    $error[] = '数量は0以上の整数を入力してください';
  }
  if (count($error) === 0) {

    $sql = "SELECT stock FROM ecsite_stock_table WHERE item_id = $item_id";
    if (($data = select_sql($link, $sql)) !== FALSE) {
      $change_stock = $data[0]['stock'];
    }
    if ($change_amount <= $change_stock) {
      $sql = "UPDATE ecsite_cart_table SET amount = $change_amount, updated_date = '$date' WHERE user_id = $user_id && item_id = $item_id";
      if (run_sql($link, $sql) !== FALSE) {
        $sql = "SELECT name FROM ecsite_item_table WHERE id = $item_id";
        if (($data = select_sql($link, $sql)) !== FALSE) {
          $complete_name = $data[0]['name'];
          $complete[] = $complete_name . 'の注文数量が変更されました';
        }
      } else {
        $error[] = '注文数量変更処理失敗';
      }
    } else {
      $error[] = '在庫が足りません';
    }
  }
}


// トランザクションの停止
if (count($error) === 0) {
  transuction_close($link);
} else {
  transuction_rollback($link);
}

// カート内の商品一覧の表示
$user_id = get_user_id($link);
$sql = "SELECT ecsite_item_table.id, name, price, img, status, stock, amount FROM ecsite_cart_table LEFT JOIN ecsite_stock_table ON ecsite_cart_table.item_id = ecsite_stock_table.item_id LEFT JOIN ecsite_item_table ON ecsite_cart_table.item_id = ecsite_item_table.id WHERE user_id = $user_id";
if (($data = select_sql($link, $sql)) === FALSE) {
  $error[] = '一覧表示のSQLが機能しませんでした';
}
if ($data !== null) {
  // 合計金額の算出
  for ($i = 0; $i < count($data); $i++) {
    $total += $data[$i]['price'] * $data[$i]['amount'];
  }
}
// DB接続の停止
db_close($link);

require_once '../../include/ecsite/view/ecsite_cart_view.php';
