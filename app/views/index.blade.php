<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./public/asset/admin/css/style.css">
</head>
<body>
    <h1>Xin Chào Bạn "Chu Minh Hiệp"</h1>
    <table>
        @foreach($users as $key=>$value)
            <tr>
                <td>{{$key}}</td>
                <td>{{$value->name}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>