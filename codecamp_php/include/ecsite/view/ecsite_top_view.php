<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>商品一覧</title>
</head>

<body>
  <header class="header">
    <h1 class="title"><a href="#" class="header-icon">ECサイト</a></h1>
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
    <section class="items">
      <?php
      foreach ($data as $d) {
        if ((int)$d['status'] === 1) {
      ?>
          <div class="item-box">
            <form method="post">
              <img src="<?php echo $d['img']; ?>" alt="item_image" class="item-image">
              <div class="item-info">
                <h2 class="item-title"><?php echo $d['name']; ?></h2>
                <p class="item-price">￥<?php echo $d['price']; ?></p>
              </div>
              <?php if ($d['stock'] > 0) { ?>
                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                <input type="hidden" name="type_of_process" value="add">
                <input type="submit" value="カートに入れる" class="btn top-btn">
              <?php } elseif ((int)$d['stock'] === 0) { ?>
                <p class="sold-out">売り切れ</p>
              <?php
              }
              ?>
            </form>
          </div>
      <?php
        }
      }
      ?>
    </section>
  </div>
</body>
</html>