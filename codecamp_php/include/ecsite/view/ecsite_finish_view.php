<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>購入結果</title>
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
  <div class="wrapper">
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
    <table>
      <thead>
        <th class="th finish-image-cell">商品画像</th>
        <th class="th finish-cell">商品名</th>
        <th class="th finish-cell">値段</th>
        <th class="th finish-cell">数量</th>
      </thead>
      <tbody>
        <?php
        if ($data !== null) {
          for ($i = 0; $i < count($data); $i++) {
        ?>
            <tr>
              <td class="td"><img src="<?php echo $data[$i]['img']; ?>" alt="商品画像" class="finish-image"></td>
              <td class="td">
                <p><?php echo $data[$i]['name']; ?></p>
              </td>
              <td class="td">
                <p>￥<?php echo $data[$i]['price']; ?></p>
              </td>
              <td class="td">
                <p><?php echo $data[$i]['amount']; ?></p>
              </td>
            </tr>
        <?php
          }
        }
        ?>
      </tbody>
      <p class="total">合計<span class="total-money">￥<?php echo $total; ?></span></p>
  </div>
</body>
</html>