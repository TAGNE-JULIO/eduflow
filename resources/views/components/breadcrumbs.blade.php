@props(['paths' => []])

<nav class="flex items-center my-2" aria-label="Breadcrumb">
    @isset ($paths)
        <ol class="inline-flex items-center space-x-1.5 md:space-x-2 text-xs font-medium text-slate-500 dark:text-slate-400">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    <i class="fa fa-home mr-1.5 text-xs text-slate-400 dark:text-slate-500" aria-hidden="true"></i>
                    <span>{{ __('Accueil') }}</span>
                </a>
            </li>
            @foreach ($paths as $path)
                <li class="inline-flex items-center">
                    <i class="fa fa-chevron-right text-[10px] text-slate-400 dark:text-slate-600 mx-1.5" aria-hidden="true"></i>
                    @if (!in_array('active', $path))
                        <a href="{{ $path['href'] }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            {{ __($path['text']) }}
                        </a>
                    @else
                        <span class="text-slate-800 dark:text-slate-200 font-semibold" aria-current="page">
                            {{ __($path['text']) }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif
</nav>
