<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>ログイン</title>
</head>

<body>
  <header class="header">
    <h1 class="title header-title"><a href="#" class="header-icon">ECサイト</a></h1>
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
    ?>
    <h2 class="h2">ログイン</h2>
    <div class="login-form">
      <form method="post">
        <input type="text" name="username" placeholder="ユーザー名" class="input-login"><br>
        <input type="password" name="password" placeholder="パスワード" class="input-login"><br>
        <input type="submit" value="ログイン" class="btn login-btn">
      </form>
      <a href="ecsite_register.php" class="btn page-btn">ユーザーの新規登録</a>
    </div>
  </div>
</body>
</html>