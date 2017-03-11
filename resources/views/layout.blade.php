<!DOCTYPE html>
<html>
<head>
    <title>KISSfiles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css" />
</head>
<body>

<div class="logout">
    <a href="{{ action('Auth\LoginController@logout') }}">Wyloguj</a>
</div>

@yield('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

@yield('scripts')
</body>
</html>
