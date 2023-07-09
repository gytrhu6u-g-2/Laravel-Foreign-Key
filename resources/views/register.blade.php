<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>登録</title>
</head>

<body>
    <h1>登録</h1>
    <form action="" method="post">
        <label>名前</label>
        <input name="name" type="text" required>
        <label>職業</label>
        <select name="department" id="" required>
            <option value="empty">未選択</option>
            <option value="sales">営業</option>
            <option value="produce">生産管理</option>
        </select>
        <label>メールアドレス</label>
        <input type="email" required>
        <button type="submit">登録</button>
    </form>
    <button>登録一覧へ</button>
</body>

</html>