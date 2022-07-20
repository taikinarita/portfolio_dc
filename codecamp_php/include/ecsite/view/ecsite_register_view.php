<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>ユーザー登録</title>
</head>

<body>
  <header class="header">
    <h1 class="title header-title"><a href="ecsite_login.php" class="header-icon">ECサイト</a></h1>
  </header>
  <div class="wrapper">
    <?php
    if (count($error) !== 0) {
      foreach ($error as $e) {
    ?>
        <p><?php echo $e; ?></p>
      <?php
      }
    }
    if (count($complete) !== 0) {
      foreach ($complete as $c) {
      ?>
        <p><?php echo $c; ?></p>
    <?php
      }
    }
    ?>
    <h2 class="h2">ユーザー登録</h2>
    <div class="register-form">
      <form method="post">
        <div class="input-register">
          <label for="username">ユーザー名</label>
          <input type="text" name="username">
        </div>
        <div class="input-register">
          <label for="password">パスワード</label>
          <input type="text" name="password">
        </div>
        <input type="submit" value="ユーザーを新規作成する" class="btn login-btn">
      </form>
      <a href="ecsite_login.php" class="btn page-btn">ログインページに移動する</a>
    </div>
  </div>
</body>
</html>