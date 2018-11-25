<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arizonia" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('css/styles.css') }}">
</head>

<body>
    @include('partials.header')
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
