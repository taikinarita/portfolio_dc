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
// トランザクション開始
transuction_start($link);

// 商品の登録
if ($_POST['type_of_process'] === 'register') {
  // バリデーション
  $item_name = get_post_data('item_name');
  if ($item_name === '') {
    $error[] = '名前を入力してください';
  }

  $item_price = get_post_data('item_price');
  if ($item_price !== '') {
    if (preg_match("/^\d+$/", $item_price) === 1) {
      if ((int)$item_price < 0) {
        $error[] = '金額は0以上の整数を入力してください';
      }
    } else {
      $error[] = '金額は0以上の整数を入力してください';
    }
  } else {
  $error[] = '金額は0以上の整数を入力してください';
  }

  $item_number = get_post_data('item_number');
  if ($item_number !== '') {
    if (($p = preg_match("/^\d+$/", $item_number)) === 1) {
      if ((int)$item_number < 0) {
        $error[] = '個数は0以上の整数を入力してください';
      }
    } else {
      $error[] = '個数は0以上の整数を入力してください';
    }
  } else {
    $error[] = '個数は0以上の整数を入力してください';
  }

  if ($_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
    if (($save_path = get_file_data('item_image')) === FALSE) {
      $error[] = '画像形式はjpegかpngです';
    }
  } else {
    $error[] = '画像ファイルが読み込まれておりません';
  }

  $item_status = (int)get_post_data('item_status');
  if ($item_status !== 0 && $item_status !== 1) {
    $error[] = '公開ステータスが選択されていません';
  }

    // 商品登録
  if (count($error) === 0) {
    // ecsite_item_tableに情報をインサート
    $sql = "INSERT INTO ecsite_item_table(name, price, img, status, created_date, updated_date) VALUES ('$item_name', $item_price, '$save_path', $item_status, '$date', '$date')";
    if (($insert_id = run_sql($link, $sql)) === FALSE) {
      $error[] = 'ecsite_item_tableにINSERT出来ませんでした';
    }
    // ecsite_stock_tableに情報をインサート
    $sql = "INSERT INTO ecsite_stock_table(item_id, stock, created_date, updated_date) VALUES ($insert_id, $item_number, '$date', '$date')";
    if (run_sql($link, $sql) === FALSE) {
      $error[] = 'ecsite_stock_tableにINSERT出来ませんでした';
    }
    if (count($error) === 0) {
      $complete[] = $item_name . '：商品登録完了しました';
    }
  }
}

// 在庫数の変更
if ($_POST['type_of_process'] === 'stock') {
  $change_stock = get_post_data('change_stock');
  if ($change_stock !== '') {
    if (preg_match("/^\d+$/", $change_stock) === 1) {
      if ((int)$change_stock < 0) {
        $error[] = '在庫数更新の0以上の際は整数を記入してください';
      }
    } else {
      $error[] = '在庫数更新の際は0以上の整数を記入してください';
    }
  } else {
    $error[] = '在庫数更新の際は0以上の整数を記入してください';
  }
  if (count($error) === 0) {
    $change_id = get_post_data('change_id');
    $sql = "UPDATE ecsite_stock_table SET stock = $change_stock, updated_date = '$date' WHERE item_id = $change_id";
    if (run_sql($link, $sql) !== FALSE) {
      $sql = "SELECT name FROM ecsite_item_table WHERE id = $change_id";
      if (($data = select_sql($link, $sql)) !== FALSE) {
        $complete_name = $data[0]['name'];
        $complete[] = $complete_name . '在庫更新完了';
      }
    } else {
      $error[] = '在庫更新失敗';
    }
  }
}


// ステータスの変更
if ($_POST['type_of_process'] === 'status') {
  $change_status = (int)get_post_data('change_status');
  if ($change_status === 0 || $change_status === 1) {
    $change_id = get_post_data('change_id');
    $sql = "UPDATE ecsite_item_table SET updated_date = '$date', status = $change_status WHERE id = $change_id";
    if (run_sql($link, $sql) !== FALSE) {
      $sql = "SELECT name FROM ecsite_item_table WHERE id = $change_id";
      if (($data = select_sql($link, $sql)) !== FALSE) {
        $complete_name = $data[0]['name'];
        $complete[] = $complete_name . 'ステータス変更完了';
      }
    } else {
      $error[] = 'ステータス変更失敗';
    }
  } else {
    $error[] = 'ステータスは0か1です';
  }
}


// 操作（項目のデリート）
if ($_POST['type_of_process'] === 'delete') {
  $change_id = get_post_data('change_id');
  $sql = "SELECT name FROM ecsite_item_table WHERE id = $change_id";
  if (($data = select_sql($link, $sql)) !== FALSE) {
    $complete_name = $data[0]['name'];
  }
  $sql = "DELETE FROM ecsite_cart_table WHERE item_id = $change_id";
  if (run_sql($link, $sql) !== FALSE) {
    $sql = "DELETE FROM ecsite_stock_table WHERE item_id = $change_id";
    if (run_sql($link, $sql) !== FALSE) {
      $sql = "DELETE FROM ecsite_item_table WHERE id = $change_id";
      if (run_sql($link, $sql) !== FALSE) {
        $complete[] = $complete_name . '削除完了';
      } else {
        $error[] = 'デリート失敗';
      }
    } else {
      $error[] = 'デリート失敗';
    }
  } else {
    $error[] = 'デリート失敗';
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

if($_SERVER['REQUEST'] === 'POST'){
  // リロードによる多重投稿の防止
  header('Location: ./');
  exit;
}


require_once '../../include/ecsite/view/ecsite_admin_view.php';