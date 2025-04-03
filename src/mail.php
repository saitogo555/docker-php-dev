<?php
$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // フォームから送信されたデータを取得
  $to = $_POST['to'] ?? '';
  $subject = $_POST['subject'] ?? '';
  $content = $_POST['content'] ?? '';
  $from = $_POST['from'] ?? '';

  // 入力チェック
  if (empty($to) || empty($subject) || empty($content)) {
    $status = 'error';
    $message = '宛先、件名、内容は必須です。';
  } else {
    // メールヘッダーの設定
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    if (!empty($from)) {
      $headers .= 'From: ' . $from . "\r\n";
    }

    // メール送信
    $mail_sent = mail($to, $subject, $content, $headers);

    if ($mail_sent) {
      $status = 'success';
      $message = 'メールが送信されました。<a href="http://localhost:8025" target="_blank">MailHogで確認</a>してください。';
    } else {
      $status = 'error';
      $message = 'メール送信に失敗しました。';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メール送信テスト</title>
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

    form {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    button {
      background: #4CAF50;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 15px;
    }

    button:hover {
      background: #45a049;
    }

    .message {
      padding: 10px;
      border-radius: 4px;
      margin: 15px 0;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    textarea {
      height: 150px;
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
  </style>
</head>

<body>
  <h1>メール送信テスト</h1>

  <?php if (!empty($message)): ?>
    <div class="message <?php echo $status; ?>">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <form method="post" action="">
    <div>
      <label for="from">送信元メールアドレス（任意）:</label>
      <input type="email" id="from" name="from" placeholder="example@example.com" value="<?php echo isset($_POST['from']) ? htmlspecialchars($_POST['from']) : ''; ?>">
    </div>

    <div>
      <label for="to">宛先メールアドレス（必須）:</label>
      <input type="email" id="to" name="to" placeholder="recipient@example.com" required value="<?php echo isset($_POST['to']) ? htmlspecialchars($_POST['to']) : ''; ?>">
    </div>

    <div>
      <label for="subject">件名（必須）:</label>
      <input type="text" id="subject" name="subject" placeholder="メールの件名" required value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
    </div>

    <div>
      <label for="content">本文（必須）:</label>
      <textarea id="content" name="content" placeholder="メールの本文" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
    </div>

    <button type="submit">メール送信</button>
  </form>

  <div>
    <p>送信されたメールは <a href="http://localhost:8025" target="_blank">MailHog</a> で確認できます。</p>
    <p><a href="index.php">トップページに戻る</a></p>
  </div>
</body>

</html>