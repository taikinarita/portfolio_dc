<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>ユーザー管理</title>
</head>

<body>
  <div class="wrapper">
    <h1 class="title">ECサイト　管理ページ</h1>
    <!-- ————————————————ページのリンク———————————————— -->
    <section class="admin-link">
      <form method="post">
        <input type="hidden" name="type_of_process" value="logout">
        <input type="submit" name="logout" value="ログアウト" class="btn admin-logout-btn">
      </form>
      <a href="ecsite_admin.php" class="btn admin-link-btn">商品管理ページ</a>
    </section>
    <!-- エラーコメントの表示 -->
    <?php
    if (count($error) === 0) {
      foreach ($error as $e) {
    ?>
        <p><?php echo $e; ?></p>
    <?php
      }
    }
    ?>
    <!-- 一覧表示 -->
    <section class="users">
      <h2 class="h2">ユーザー情報一覧</h2>
      <table class="table">
        <thead>
          <th class="th">ユーザー名</th>
          <th class="th">登録日時</th>
        </thead>
        <tbody>
          <?php foreach ($data as $d) { ?>
            <tr>
              <td class="td"><?php echo $d['user_name']; ?></td>
              <td class="td"><?php echo $d['created_date']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </div>
</body>
</html>