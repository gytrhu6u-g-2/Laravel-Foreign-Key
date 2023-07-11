<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <h1>登録</h1>
    {{-- <form action="" method="post"> --}}
        <label>名前</label>
        <input name="name" type="text" required>
        <label>職業</label>
        <select name="department" id="" required>
            <option value=""></option>
            <option value="1">営業</option>
            <option value="2">生産管理</option>
        </select>
        <label>メールアドレス</label>
        <input type="email" name="email" required>
        <button id="register" type="submit">登録</button>
    {{-- </form> --}}

    <h1>登録一覧</h1>
    <table border="1">
        <tr>
            <th>名前</th>
            <th>部署</th>
            <th>メールアドレス</th>
        </tr>
        <tr>
            <td>光希</td>
            <td>営業</td>
            <td>gytrhu6u@gmail.com</td>
        </tr>
    </table>
</body>
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
    })
    $('#register').on('click', function(){
        name = $('input[name="name"]').val();
        department = $('[name="department"]').val();
        email = $('input[name="email"]').val();

        $.ajax({
            url: "{{ route('store') }}",
            method:"POST",
            data: {name : name, department : department, email : email},
            dataType: "json",
        }).done(function(res){
            console.log(res);
        }).faile(function(){
            alert('通信に失敗しました');
        });
    });
</script>

</html>