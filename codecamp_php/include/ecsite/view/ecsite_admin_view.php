<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>商品管理ページ</title>
</head>

<body>
  <div class="wrapper">
    <h1 class="title">ECサイト 管理ページ</h1>
    <!-- ————————————————ページのリンク———————————————— -->
    <section class="admin-link">
      <form method="post">
        <input type="hidden" name="type_of_process" value="logout">
        <input type="submit" name="logout" value="ログアウト" class="btn admin-logout-btn">
      </form>
      <a href="ecsite_admin_user.php" class="btn admin-link-btn">ユーザー管理ページ</a>
    </section>
    <!-- エラー／完了メッセージ表示 -->
    <?php
    if (count($error) !== 0) {
      foreach ($error as $e) {
    ?>
        <p><? echo $e; ?></p>
    <?php
      }
    }
    ?>
    <?php
    if (count($complete) !== 0) {
      foreach ($complete as $c) {
    ?>
        <p><? echo $c; ?></p>
    <?php
      }
    }
    ?>
    <!-- 商品登録 -->
    <section class="item-register">
      <h2 lass="h2">商品の登録</h2>
      <form method="post" enctype="multipart/form-data">
        <div class="input-form">
          <label for="item_name">商品名：</label>
          <input type="text" name="item_name">
        </div>
        <div class="input-form">
          <label for="item_price">値　段：</label>
          <input type="text" name="item_price">
        </div>
        <div class="input-form">
          <label for="item_number">個　数：</label>
          <input type="text" name="item_number">
        </div>
        <label for="item_image">商品画像：</label>
        <input type="file" name="item_image" class="input-form"><br>
        <label for="item_status">ステータス：</label>
        <select name="item_status" class="select">
          <option value="0">非公開</option>
          <option value="1">公開</option>
        </select><br>
        <input type="hidden" name="type_of_process" value="register">
        <input type="submit" value="商品を登録する" class="btn">
      </form>
    </section>
    <!-- 商品情報の一覧表示と変更 -->
    <section class="item-index">
      <h2 class="h2">商品情報の一覧・変更</h2>
      <table class="table">
        <thead>
          <th class="th admin-image-cell">商品画像</th>
          <th class="th admin-cell">商品名</th>
          <th class="th admin-cell">値段</th>
          <th class="th admin-cell">在庫数</th>
          <th class="th admin-cell">公開ステータス</th>
          <th class="th admin-cell">操作</th>
        </thead>
        <tbody>
          <?php foreach ($data as $d) { ?>
          <tr>
            <td class="td"><img src="<?php echo $d['img']; ?>" alt="商品画像" class="admin-image"></td>
            <td class="td">
              <p><?php echo $d['name']; ?></p>
            </td>
            <td class="td">
              <p>￥<?php echo $d['price']; ?></p>
            </td>
            <td class="td">
              <form method="post">
                <input type="text" name="change_stock" value="<?php echo $d['stock']; ?>" class="admin-input">個<br>
                <input type="hidden" name="change_id" value="<?php echo $d['id']; ?>">
                <input type="hidden" name="type_of_process" value="stock">
                <input type="submit" value="変更する">
              </form>
            </td>
            <td class="td">
              <form method="post">
                <input type="hidden" name="change_id" value="<?php echo $d['id']; ?>">
                <input type="hidden" name="type_of_process" value="status">
                <?php if ((int)$d['status'] === 1) { ?>
                  <p>【公開】</p>
                  <p>公開→非公開にする</p>
                  <input type="hidden" name="change_status" value="0">
                  <input type="submit" value="変更" class="admin-input">
                <?php } else { ?>
                  <p>【非公開】</p>
                  <p>非公開→公開にする</p>
                  <input type="hidden" name="change_status" value="1">
                  <input type="submit" value="変更" class="admin-input">
                <?php } ?>
              </form>
            </td>
            <td class="td">
              <form method="post">
                <input type="hidden" name="change_id" value="<?php echo $d['id']; ?>">
                <input type="hidden" name="type_of_process" value="delete">
                <input type="submit" value="削除する">
              </form>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </div>
  
</body>
</html>