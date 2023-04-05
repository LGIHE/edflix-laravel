<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color:#f8f9fa!important
        }
        h2 {
            font-weight: 800!important;
        }
        .btn {
            color: #856404!important;
            font-weight: bold
        }
    </style>
</head>
<body>
    <div class="container mt-5 pt-5">
        <div class="alert alert-warning text-center">
            <h2 class="display-3">404</h2>
            <h4 class="display-6">Oops!</h4>
            <h4 class="display-6">Looks like you are offline.</h4><br>
            <center><a type="button" class="btn btn-warning" href="{{ route('dashboard') }}">RETRY</a></center>
        </div>
    </div>
</body>
</html>
