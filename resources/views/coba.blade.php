<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coba</title>
</head>
<body>
<form action="{{ route('car') }}" method="post">
    @csrf
    <input type="text" name="stock_id" id="stock_id">
    <button type="submit">kirim</button>
</form>

@error('stock_id')
    {{ $message }}
@enderror

</body>
</html>
