<!DOCTYPE html>
<html>
<head>
    <title>KISSfiles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        html {
            height: 100%;
        }
        body {
            height: 100%;
            margin: 0;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        body {
            min-height: 100%;
            background: linear-gradient(to bottom, #1e5799 0%,#7db9e8 100%);
        }
    </style>
</head>
<body>

<a href="{{ action('Auth\LoginController@logout') }}">Wyloguj</a>

@yield('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

@yield('scripts')
</body>
</html>
