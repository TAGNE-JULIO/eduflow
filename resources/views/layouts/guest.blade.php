<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset(config('app.favicon'))}}" type="image/x-icon">
        <title>
            @yield('title', config('app.name', 'EduFlow'))
        </title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite('resources/css/app.css')
        <livewire:styles />
        
        <!--Shortcut icon-->
        <link rel="shortcut icon" href="favicons/favicon.ico" type="image/x-icon">
    </head>
    <body class="bg-gradient-to-br from-indigo-50 via-slate-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-950 flex flex-col justify-center min-h-screen">
        <div class="w-full">
            @yield('body')
        </div>
        <livewire:display-status />
    </body>
    <livewire:scripts />
</html>