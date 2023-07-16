<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</head>

<body>
    <h1>登録</h1>
    {{-- <form action="" method="post"> --}}
        <label>名前</label>
        <input name="name" type="text" required>
        <label>部署</label>
        <select name="department" id="" required>
            <option value="1">未選択</option>
            <option value="2">営業</option>
            <option value="3">生産管理</option>
        </select>
        <label>メールアドレス</label>
        <input type="email" name="email" required>
        <button id="register" type="submit">登録</button>
        {{--
    </form> --}}

    <h1>削除</h1>
    <input class="inputId" type="text" placeholder="idを入力してください">
    <button id="delete" type="submit">削除</button>

    <h1>登録一覧</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>名前</th>
            <th>部署</th>
            <th>メールアドレス</th>
        </tr>
        @foreach ($userInformations as $u)
        <tr class="table">
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->department }}</td>
            <td>{{ $u->mail }}</td>
        </tr>
        @endforeach
    </table>

    <div class="search_area">
        <div class="search_input">
            <h1>検索</h1>
            <label>id</label>
            <input id="search" type="number">
            <button class="search_btn" type="submit">検索</button>
        </div>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>部署</th>
                <th>メールアドレス</th>
            </tr>
            <tr class="search_result">
            </tr>
        </table>
    </div>
</body>
<script>
    // input内の要素削除
    function deleteChar(){
        $('input[name="name"]').val("");
        $('[name="department"]').val("");
        $('input[name="email"]').val("");
    }

    // 非同期処理でデータの追加
    $(document).ready(function() {
        $('#register').on('click', function(){
        var name = $('input[name="name"]').val();
        var department = $('[name="department"]').val();
        var email = $('input[name="email"]').val();

        $.ajax({
            url: "{{ route('store') }}",
            method:"POST",
            data: {name : name, department : department, email : email},
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            }).done(function(res){
                console.log(res);
                $('tr').eq(-1).after('<tr class="table">'+'<td>'+ res.datas['id'] +'</td>'+'<td>'+ res.datas['name'] +'</td>'+'<td>'+ res.datas['department'] +'</td>'+'<td>'+ res.datas['mail'] +'</td>'+'</td>');
                deleteChar();
            }).fail(function(){
                alert('通信に失敗しました');
            });
        });
    });


    // 非同期でデータの削除
    $('#delete').on('click', function() {
        var id = $('.inputId').val();
        $.ajax({
            url: "{{ route('destroy') }}",
            method: "POST",
            data: {id : id},
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(res){
            // idの取得
            const id = res.id[0]['id'];
            // tableタグをすべて取得
            const tableNum = document.querySelectorAll('.table');

            for(let i=0; i < tableNum.length; i++) {
                // tableタグの小要素の1番目の値を取得
                let firstElement = tableNum[i].firstElementChild;

                // firstElementとidが同じかを確認
                if (firstElement.innerHTML == id) {
                    // 要素を削除
                    tableNum[i].remove();
                    break;
                }
            }
        }).fail(function(){
            alert('IDが存在しません');
        });
    });


    // 検索処理
    $('.search_btn').on('click', function(){
        id = $('#search').val();
        
        $.ajax({
            url: "{{ route('search') }}",
            method:"POST",
            data: {id:id},
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(res){
            id_results = res.results;
            id_results.forEach(function(element){
                $('.search_result').before('<tr class="table">'+'<td>'+ element['id'] +'</td>'+'<td>'+ element['name'] +'</td>'+'<td>'+ element['department'] +'</td>'+'<td>'+ element['mail'] +'</td>'+'</td>');
            });
            // console.log(res);
        }).fail(function(){
            alert('IDが存在しません')
        })
    })
    
</script>

</html>