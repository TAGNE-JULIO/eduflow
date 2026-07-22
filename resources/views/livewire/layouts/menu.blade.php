<nav class="fixed w-0 lg:sticky inset-0 h-screen shadow-2xl lg:shadow-md flex duration-300 text-slate-300 transition-all z-40" :class="{' w-0 overflow-hidden lg:flex lg:w-20' : menuOpen == false, 'w-full lg:w-72' : menuOpen == true}">
    <aside class="w-4/6 md:w-3/6 lg:w-full bg-slate-900 border-r border-slate-800 overflow-y-auto beautify-scrollbar">
        <a href="{{route('home')}}" class="flex lg:hidden items-center justify-center border-b border-slate-800 p-4">
            <img src="{{asset(auth()->user()->school->logoURL ?? config('app.logo'))  }}" alt="" class="rounded-full w-12 h-12 border-2 border-slate-700 shadow-md">
            <h1 class="text-xl font-bold tracking-tight mx-3 text-center capitalize text-white">{{config('app.name')}}</h1>
        </a>
        <div class="p-4 space-y-1">
            @isset ($menu)
                @foreach ($menu as $menuItem)
                    @if (isset($menuItem['header']) & (!isset($menuItem['can']) || auth()->user()->can($menuItem['can'])))
                        <p x-show="menuOpen" x-transition class="my-4 text-xs font-semibold tracking-wider text-slate-500 uppercase">{{$menuItem['header']}}</p> 
                    @elseif(!isset($menuItem['can']) || auth()->user()->can($menuItem['can']))
                        <div @click.outside="submenu = false" x-data="{
                            'submenu'  : {{ isset($menuItem['submenu']) && in_array(Route::currentRouteName() , array_column($menuItem['submenu']  , 'route')) ? '1' : '0'}}
                           }" >
                            @if (!isset($menuItem['submenu']))
                                <a class="flex items-center gap-3 p-3 px-4 my-1 rounded-lg transition-colors group" href="{{route($menuItem['route'])}}" :class="{{Route::currentRouteName() == $menuItem['route'] ? '1' : '0'}} ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-400'" aria-label="{{$menuItem['text']}}" wire:navigate>
                                    <i class="{{$menuItem['icon'] ?? 'fa fa-circle'}} text-lg group-hover:scale-110 transition-transform" aria-hidden="true" x-transition></i>
                                    <p x-show="menuOpen" class="font-medium">{{$menuItem['text']}}</p>
                                </a>
                            @else
                                <div class="flex items-center justify-between gap-2 p-3 my-1 px-4 rounded-lg cursor-pointer transition-colors group"  @click="submenu = !submenu" :class=" {{in_array(Route::currentRouteName() , array_column($menuItem['submenu'] , 'route'))  ? '1' : '0'}} ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' " >
                                    <div class="flex items-center gap-3">
                                        <i class="{{$menuItem['icon'] ?? 'fa fa-circle'}} text-lg group-hover:scale-110 transition-transform" aria-hidden="true" x-transition></i>
                                        <p x-show="menuOpen" class="font-medium">{{$menuItem['text']}}</p>
                                    </div>
                                    <i class="transition-transform duration-200" :class="{'rotate-0' : submenu == false , '-rotate-180 ' : submenu == true}" x-show="menuOpen"></i>
                                </div>
                                @foreach ($menuItem['submenu'] as $submenu)
                                    @if ($submenu['can'] && auth()->user()->can($submenu['can']))
                                        <a class="flex items-center gap-3 p-2.5 pl-11 my-1 transition-all rounded-lg whitespace-nowrap text-sm font-medium {{( Route::currentRouteName() == $submenu['route'] ? 'bg-indigo-600/10 text-indigo-400': 'text-slate-400 hover:text-white hover:bg-slate-800' )}}" :class="{'h-0 my-auto overflow-hidden py-0 opacity-0' : submenu == false, 'opacity-100': submenu == true}" x-transition href="{{route($submenu['route'])}}" aria-label="{{$submenu['text']}}" @focus="submenu = true"  @blur="submenu = false"  wire:navigate>
                                            <i class="{{$submenu['icon'] ?? 'far fa-fw fa-circle'}} text-xs" aria-hidden="true"></i>
                                            <p x-show="menuOpen">{{$submenu['text']}}</p>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </aside>
    <div class="lg:hidden w-2/6 md:w-4/6 bg-slate-900/50 backdrop-blur-sm" @click="menuOpen = false" x-show="menuOpen" x-transition:enter="transition-opacity ease-in duration-200" x-transition:enter-start="opacity-0" >
    </div>
</nav>
