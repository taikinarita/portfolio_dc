<?php
// データベース接続に要する値
define('DB_HOST', 'mysql34.conoha.ne.jp');
define('DB_USER', 'bcdhm_work26');
define('DB_PASSWD', 'Fg3!nHxp');
define('DB_NAME', 'bcdhm_3kr8fdyn');

// 文字設定
define('MY_SQLI_CHARASET', 'UTF8');
define('HTMLSPECIALCHARS_CHARASET', 'utf-8');

// 商品画像の保管ディレクトリ
define('UPLOAD_DIR', 'image/');

// エラーメッセージ・完了メッセージ
$error = [];
$complete = [];

// 時刻
$date = date('Y-m-d H:i:s');

// 合計金額
$total;