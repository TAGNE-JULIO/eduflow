<nav class="fixed w-0 lg:sticky inset-0 h-screen shadow-[10px_0_30px_rgb(0,0,0,0.1)] flex duration-300 text-slate-300 transition-all z-40" :class="{' w-0 overflow-hidden lg:flex lg:w-24' : menuOpen == false, 'w-full lg:w-72' : menuOpen == true}">
    <aside class="w-4/6 md:w-3/6 lg:w-full bg-slate-950/95 backdrop-blur-3xl border-r border-slate-800/60 overflow-y-auto beautify-scrollbar relative">
        <a href="{{route('home')}}" class="flex lg:hidden items-center justify-center border-b border-slate-800 p-4">
            <img src="{{asset(auth()->user()->school->logoURL ?? config('app.logo'))  }}" alt="" class="rounded-full w-12 h-12 border-2 border-slate-700 shadow-md">
            <h1 class="text-xl font-bold tracking-tight mx-3 text-center capitalize text-white">{{config('app.name')}}</h1>
        </a>
        <div class="p-4 space-y-1">
            @isset ($menu)
                @foreach ($menu as $menuItem)
                    @if (isset($menuItem['header']) & (!isset($menuItem['can']) || auth()->user()->can($menuItem['can'])))
                        <p x-show="menuOpen" x-transition.opacity.duration.300ms class="my-4 text-[10px] font-bold tracking-[0.2em] text-slate-500 uppercase">{{__($menuItem['header'])}}</p> 
                    @elseif(!isset($menuItem['can']) || auth()->user()->can($menuItem['can']))
                        <div @click.outside="submenu = false" x-data="{
                            'submenu'  : {{ isset($menuItem['submenu']) && in_array(Route::currentRouteName() , array_column($menuItem['submenu']  , 'route')) ? '1' : '0'}}
                           }" >
                            @if (!isset($menuItem['submenu']))
                                <a class="flex items-center gap-4 p-3.5 px-4 my-1 rounded-xl transition-all duration-300 group relative overflow-hidden" href="{{route($menuItem['route'])}}" :class="{{Route::currentRouteName() == $menuItem['route'] ? '1' : '0'}} ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/30' : 'hover:bg-slate-800/80 hover:text-white text-slate-400'" aria-label="{{$menuItem['text']}}" wire:navigate>
                                    <i class="{{$menuItem['icon'] ?? 'fa fa-circle'}} text-lg group-hover:scale-110 transition-transform" aria-hidden="true" x-transition></i>
                                    <p x-show="menuOpen" class="font-medium whitespace-nowrap group-hover:translate-x-1 transition-transform duration-300">{{__($menuItem['text'])}}</p>
                                </a>
                            @else
                                <div class="flex items-center justify-between gap-2 p-3.5 my-1 px-4 rounded-xl cursor-pointer transition-all duration-300 group"  @click="submenu = !submenu" :class=" {{in_array(Route::currentRouteName() , array_column($menuItem['submenu'] , 'route'))  ? '1' : '0'}} ? 'bg-slate-800/80 text-white' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' " >
                                    <div class="flex items-center gap-3">
                                        <i class="{{$menuItem['icon'] ?? 'fa fa-circle'}} text-lg group-hover:scale-110 transition-transform" aria-hidden="true" x-transition></i>
                                        <p x-show="menuOpen" class="font-medium whitespace-nowrap group-hover:translate-x-1 transition-transform duration-300">{{__($menuItem['text'])}}</p>
                                    </div>
                                    <i class="transition-transform duration-200" :class="{'rotate-0' : submenu == false , '-rotate-180 ' : submenu == true}" x-show="menuOpen"></i>
                                </div>
                                @foreach ($menuItem['submenu'] as $submenu)
                                    @if ($submenu['can'] && auth()->user()->can($submenu['can']))
                                        <a class="flex items-center gap-3 p-2.5 pl-12 my-1 transition-all duration-300 rounded-xl whitespace-nowrap text-sm font-medium {{( Route::currentRouteName() == $submenu['route'] ? 'bg-primary-500/10 text-primary-400': 'text-slate-400 hover:text-white hover:bg-slate-800/80' )}}" :class="{'h-0 my-auto overflow-hidden py-0 opacity-0' : submenu == false, 'opacity-100 hover:translate-x-1': submenu == true}" x-transition href="{{route($submenu['route'])}}" aria-label="{{$submenu['text']}}" @focus="submenu = true"  @blur="submenu = false"  wire:navigate>
                                            <i class="{{$submenu['icon'] ?? 'far fa-fw fa-circle'}} text-[10px]" aria-hidden="true"></i>
                                            <p x-show="menuOpen">{{__($submenu['text'])}}</p>
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
