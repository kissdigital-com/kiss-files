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
            background: white;
        }

        .fileItem {
            border-bottom: 1px solid #ccc;
            padding:4px;
        }

        input {
            border:none;
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
