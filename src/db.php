<?php
$host = 'mariadb';
$db = 'php-dev';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>データベース接続テスト</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      color: #333;
      border-bottom: 2px solid #eee;
      padding-bottom: 10px;
    }

    h2 {
      color: #444;
      margin-top: 20px;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    li {
      margin-bottom: 10px;
      padding: 5px;
      border-bottom: 1px solid #eee;
    }

    a {
      display: inline-block;
      padding: 8px 15px;
      background-color: #f5f5f5;
      color: #333;
      text-decoration: none;
      border-radius: 4px;
      border: 1px solid #ddd;
    }

    a:hover {
      background-color: #e9e9e9;
    }

    .success {
      color: green;
      padding: 10px;
      background-color: #d4edda;
      border-radius: 4px;
    }

    .error {
      color: red;
      padding: 10px;
      background-color: #f8d7da;
      border-radius: 4px;
    }

    .info-box {
      background: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
    }
  </style>
</head>

<body>
  <h1>データベース接続テスト</h1>

  <?php
  try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<p class='success'>データベースへの接続に成功しました！</p>";

    // サーバー情報を表示
    echo "<div class='info-box'>";
    echo "<h2>データベース情報:</h2>";
    echo "<ul>";
    echo "<li><strong>サーバーバージョン:</strong> " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "</li>";
    echo "<li><strong>接続ステータス:</strong> " . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "</li>";
    echo "<li><strong>サーバー情報:</strong> " . $pdo->getAttribute(PDO::ATTR_SERVER_INFO) . "</li>";
    echo "</ul>";
    echo "</div>";

    // テーブル一覧を表示
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<div class='info-box'>";
    echo "<h2>テーブル一覧:</h2>";
    if (count($tables) > 0) {
      echo "<ul>";
      foreach ($tables as $table) {
        echo "<li>$table</li>";
      }
      echo "</ul>";
    } else {
      echo "<p>データベースにテーブルがありません。</p>";
    }
    echo "</div>";
  } catch (PDOException $e) {
    echo "<p class='error'>データベース接続エラー: " . $e->getMessage() . "</p>";
  }
  ?>

  <p><a href="index.php">トップページに戻る</a></p>
</body>

</html>