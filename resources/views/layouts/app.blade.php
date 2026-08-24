<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="robots" content="noindex">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset(config('app.favicon'))}}" type="image/x-icon">
        <title>
            @yield('title', config('app.name', 'EduFlow'))
        </title>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
        
        @vite('resources/css/app.css')
        <livewire:styles />
    </head>
    <body>
        <a href="#main" class="sr-only">
            Skip to content
        </a>
        <div x-data="{ menuOpen: window.innerWidth >=  1024 ? $persist(false) : false }">
            <livewire:layouts.header/>
            <div class="lg:flex lg:flex-cols text-slate-900 bg-transparent dark:text-slate-50 min-h-screen" >
                <livewire:layouts.menu />
                <div class="w-full max-w-full overflow-x-hidden overflow-y-auto beautify-scrollbar flex flex-col h-screen">
                    <div class="glass px-6 py-4 w-full z-10 sticky top-0 border-b-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100 capitalize">@yield('page_heading')</h1>
                                <div class="mt-1">
                                    @isset ($breadcrumbs)
                                        <x-breadcrumbs :paths="$breadcrumbs"/>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <x-show-set-school />
                            </div>
                        </div>
                    </div>
                    <main class="flex-1 p-6 lg:p-8 min-w-0" id="main">
                        <div class="max-w-7xl mx-auto w-full min-w-0 fade-in">
                            @yield('content') 
                        </div>
                    </main>
                </div>
            </div>
        </div> 
    @livewire('display-status')
    <livewire:quick-search />
    </body>
    <livewire:scripts />
    @stack('scripts')
</html>