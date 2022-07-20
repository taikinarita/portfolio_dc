<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>ショッピングカート</title>
</head>

<body>
  <header class="header">
    <h1 class="title"><a href="ecsite_top.php" class="header-icon">ECサイト</a></h1>
    <div class="header-right">
      <p class="header-user">ユーザー名：<?php echo $_SESSION['user_name']; ?></p>
      <a href="ecsite_cart.php"><img src="icon/cart_icon.png" alt="カート" class="header-cart"></a>
      <form method="post">
        <input type="hidden" name="type_of_process" value="logout">
        <input type="submit" value="ログアウト" class="header-logout">
      </form>
    </div>
  </header>
  <!-- エラー／完了メッセージ表示 -->
  <div class="wrapper">
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
    <h1 class="title">ショッピングカート</h1>
    <table class="table">
      <thead>
        <th class="th cart-image-cell">商品画像</th>
        <th class="th cart-cell">商品名</th>
        <th class="th cart-cell">カートから削除</th>
        <th class="th cart-cell">値段</th>
        <th class="th cart-cell">数量</th>
      </thead>
      <tbody>
        <?php
        if ($data !== null) {
          if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
              if ((int)$data[$i]['status'] === 1) {
        ?>
                <tr>
                  <td class="td"><img src="<?php echo $data[$i]['img']; ?>" alt="商品画像" class="cart-image"></td>
                  <td class="td">
                    <p><?php echo $data[$i]['name']; ?></p>
                  </td>
                  <td class="td">
                    <form method="post">
                      <input type="hidden" name="delete_id" value="<?php echo $data[$i]['id']; ?>">
                      <input type="hidden" name="type_of_process" value="delete">
                      <input type="submit" value="削除">
                    </form>
                  </td>
                  <td class="td">
                    <p>￥<?php echo $data[$i]['price']; ?></p>
                  </td>
                  <td class="td">
                    <form method="post">
                      <input type="text" name="change_amount" value="<?php echo $data[$i]['amount']; ?>" class="cart-stock">個
                      <input type="hidden" name="change_id" value="<?php echo $data[$i]['id']; ?>">
                      <input type="hidden" name="type_of_process" value="change_count">
                      <input type="submit" value="変更する">
                    </form>
                    <p>*在庫：<?php echo $data[$i]['stock']; ?>個</p>
                  </td>
                </tr>
        <?php
              }
            }
          }
        }
        ?>
      </tbody>
    </table>
    <p class="total">合計<span class="total-money">￥<?php echo $total; ?></span></p>
    <a href="ecsite_finish.php" class="btn cart-btn">購入する</a>
  </div>
</body>
</html>