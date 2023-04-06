<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
<?php //phpinfo(INFO_GENERAL);?>
<div id="app"></div>
@vite(['resources/scss/style.scss', 'resources/js/main.ts'])
</body>
</html>
