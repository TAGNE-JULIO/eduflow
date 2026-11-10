<nav class="fixed w-0 lg:sticky inset-0 h-screen shadow-[10px_0_30px_rgb(0,0,0,0.1)] flex duration-300 text-slate-300 transition-all z-40" :class="{'w-0 overflow-hidden lg:flex lg:w-20' : menuOpen == false, 'w-full lg:w-72' : menuOpen == true}">
    <aside class="w-4/6 md:w-3/6 lg:w-full bg-slate-950/95 backdrop-blur-3xl border-r border-slate-800/60 overflow-y-auto beautify-scrollbar relative flex flex-col justify-between">
        <div>
            <!-- Mobile Brand Header -->
            <a href="{{route('home')}}" class="flex lg:hidden items-center justify-center border-b border-slate-800 p-4">
                <img src="{{asset(auth()->user()->school->logoURL ?? config('app.logo'))}}" alt="" class="rounded-full w-10 h-10 border-2 border-slate-700 shadow-md">
                <h1 class="text-lg font-bold tracking-tight mx-3 text-center capitalize text-white">{{config('app.name')}}</h1>
            </a>
            
            <div class="p-3 space-y-1">
                @isset ($menu)
                    @foreach ($menu as $menuItem)
                        @if (isset($menuItem['header']) & (!isset($menuItem['can']) || auth()->user()->can($menuItem['can'])))
                            <p x-show="menuOpen" x-transition.opacity.duration.300ms class="mt-5 mb-2 px-3 text-[10px] font-bold tracking-[0.2em] text-slate-500 uppercase">{{__($menuItem['header'])}}</p> 
                        @elseif(!isset($menuItem['can']) || auth()->user()->can($menuItem['can']))
                            <div @click.outside="submenu = false" x-data="{
                                'submenu' : {{ isset($menuItem['submenu']) && in_array(Route::currentRouteName(), array_column($menuItem['submenu'], 'route')) ? '1' : '0'}}
                               }">
                                @if (!isset($menuItem['submenu']))
                                    <a class="flex items-center gap-3.5 p-3 px-3.5 my-1 rounded-xl transition-all duration-200 group relative overflow-hidden" 
                                       href="{{route($menuItem['route'])}}" 
                                       :class="{{Route::currentRouteName() == $menuItem['route'] ? '1' : '0'}} ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-md shadow-primary-500/20 font-semibold' : 'hover:bg-slate-800/70 hover:text-white text-slate-400 font-medium'" 
                                       aria-label="{{$menuItem['text']}}" 
                                       wire:navigate>
                                        <div class="w-6 flex items-center justify-center shrink-0">
                                            <i class="{{$menuItem['icon'] ?? 'fas fa-circle'}} text-base group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                        </div>
                                        <span x-show="menuOpen" class="text-sm whitespace-nowrap group-hover:translate-x-0.5 transition-transform">{{__($menuItem['text'])}}</span>
                                    </a>
                                @else
                                    <div class="flex items-center justify-between gap-2 p-3 my-1 px-3.5 rounded-xl cursor-pointer transition-all duration-200 group" 
                                         @click="submenu = !submenu" 
                                         :class="{{in_array(Route::currentRouteName(), array_column($menuItem['submenu'], 'route')) ? '1' : '0'}} ? 'bg-slate-800/80 text-white font-semibold' : 'hover:bg-slate-800/70 hover:text-white text-slate-400 font-medium'">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-6 flex items-center justify-center shrink-0">
                                                <i class="{{$menuItem['icon'] ?? 'fas fa-circle'}} text-base group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                            </div>
                                            <span x-show="menuOpen" class="text-sm whitespace-nowrap group-hover:translate-x-0.5 transition-transform">{{__($menuItem['text'])}}</span>
                                        </div>
                                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 opacity-60 group-hover:opacity-100" :class="{'rotate-0' : submenu == false, '-rotate-180' : submenu == true}" x-show="menuOpen"></i>
                                    </div>
                                    @foreach ($menuItem['submenu'] as $submenu)
                                        @if ($submenu['can'] && auth()->user()->can($submenu['can']))
                                            <a class="flex items-center gap-3 py-2 px-3 pl-11 my-0.5 transition-all duration-200 rounded-lg whitespace-nowrap text-xs font-medium {{( Route::currentRouteName() == $submenu['route'] ? 'bg-primary-500/15 text-primary-400 font-bold': 'text-slate-400 hover:text-white hover:bg-slate-800/60' )}}" 
                                               :class="{'h-0 my-0 overflow-hidden py-0 opacity-0' : submenu == false, 'opacity-100 hover:translate-x-1': submenu == true}" 
                                               x-transition 
                                               href="{{route($submenu['route'])}}" 
                                               aria-label="{{$submenu['text']}}" 
                                               @focus="submenu = true" 
                                               @blur="submenu = false" 
                                               wire:navigate>
                                                <i class="{{$submenu['icon'] ?? 'fas fa-angle-right'}} text-[11px] opacity-70" aria-hidden="true"></i>
                                                <span x-show="menuOpen">{{__($submenu['text'])}}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Sidebar Footer / Brand Badge -->
        <div class="p-4 border-t border-slate-800/60 hidden lg:block" x-show="menuOpen" x-transition>
            <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-900/60 border border-slate-800">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <div class="text-[11px] text-slate-400 font-medium">
                    <p class="text-slate-200 font-semibold">EduFlow Platform</p>
                    <p class="text-[10px] text-slate-500">v2.4 Production</p>
                </div>
            </div>
        </div>
    </aside>
    <div class="lg:hidden w-2/6 md:w-4/6 bg-slate-900/50 backdrop-blur-sm" @click="menuOpen = false" x-show="menuOpen" x-transition:enter="transition-opacity ease-in duration-200" x-transition:enter-start="opacity-0" >
    </div>
</nav>
