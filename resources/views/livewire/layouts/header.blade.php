<header class="glass h-16 w-full flex justify-between items-center py-2 border-b border-slate-200/50 dark:border-slate-700/50 shadow-sm transition-all z-20 sticky top-0">
    <div class="flex items-center">
        <button role="button" class="text-xl mx-3 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 px-4 transition-all hover:scale-110 active:scale-95" @click="menuOpen = !menuOpen">
            <p class="sr-only">Menu</p>
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <a href="{{route('home')}}" class="hidden md:flex items-center justify-center" aria-label="Home">
            <img src="{{asset(auth()->user()->school->logoURL ?? config('app.logo'))}}" alt="" class="rounded-full w-12 h-12 border border-slate-200 shadow-lg">
            <h1 class="text-lg font-semibold mx-3 text-center capitalize">{{config('app.name')}}</h1>
        </a>
        <!-- Quick Search Trigger -->
        <button @click="$dispatch('openQuickSearch')" class="hidden md:flex items-center gap-3 px-3 py-1.5 ml-4 rounded-xl bg-slate-100 dark:bg-slate-700/60 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 border border-slate-200/60 dark:border-slate-600/40 text-xs transition-all">
            <i class="fas fa-search text-xs"></i>
            <span>{{ __('Rechercher...') }}</span>
            <kbd class="px-1.5 py-0.5 text-[10px] font-bold bg-white dark:bg-slate-800 rounded border border-slate-200 dark:border-slate-600 shadow-2xs">Ctrl+K</kbd>
        </button>
    </div>
    <div class="flex justify-evenly items-center gap-6 px-5 h-full" x-data="{'dropDownOpen': false, 'notificationsOpen': false, 'darkMode' : $persist(false), 'fullScreen' : $persist(false) }">
        {{--full screen toggle--}}
        <button @click="fullScreen = !fullScreen; fullScreen == true ? document.documentElement.requestFullscreen() :  document.exitFullscreen()" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors hover:scale-110 active:scale-95">
            <i class="fa fa-expand text-xl" aria-hidden="true"></i>
            <p class="sr-only">Full screen mode</p>
        </button>
        {{--Dark mode toggle--}}
        <button @click="darkMode = !darkMode" x-effect="darkMode == true ? document.body.classList.add('dark') :  document.body.classList.remove('dark') " class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors hover:scale-110 active:scale-95">
            <i class="text-xl" :class="{'far fa-moon ' : darkMode == false, 'fas fa-moon' : darkMode == true}" aria-hidden="true"></i>
            <p class="sr-only">Dark mode</p>
        </button>
        {{-- Language Selector --}}
        <div class="relative" x-data="{ langOpen: false }">
            <button @click="langOpen = !langOpen" class="flex items-center gap-1 font-bold text-xs uppercase px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-all">
                <i class="fas fa-globe text-sm mr-1"></i> {{ app()->getLocale() }}
                <i class="fas fa-chevron-down text-[10px] ml-1"></i>
            </button>
            <div class="absolute top-10 right-0 w-32 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl rounded-xl py-1 z-50 origin-top-right transition-all"
                 x-show="langOpen" x-transition @click.outside="langOpen = false" style="display: none">
                <a href="{{ route('locale.switch', 'fr') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 {{ app()->getLocale() == 'fr' ? 'text-primary-600 dark:text-primary-400' : 'text-slate-700 dark:text-slate-300' }}">
                    🇫🇷 Français
                </a>
                <a href="{{ route('locale.switch', 'en') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 {{ app()->getLocale() == 'en' ? 'text-primary-600 dark:text-primary-400' : 'text-slate-700 dark:text-slate-300' }}">
                    🇬🇧 English
                </a>
                <a href="{{ route('locale.switch', 'es') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 {{ app()->getLocale() == 'es' ? 'text-primary-600 dark:text-primary-400' : 'text-slate-700 dark:text-slate-300' }}">
                    🇪🇸 Español
                </a>
            </div>
        </div>
        {{--Click to open profile card--}}
        <div class="relative flex items-center gap-2 md:gap-4">
            {{-- Messages Icon --}}
            @php
                $unreadMessagesCount = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
            @endphp
            <a href="{{ route('messages.index') }}" class="relative text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-all hover:scale-110 active:scale-95">
                <i class="far fa-envelope text-xl" aria-hidden="true"></i>
                @if($unreadMessagesCount > 0)
                    <span class="absolute -top-1.5 -right-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-md shadow-primary-500/30 animate-pulse">{{ $unreadMessagesCount }}</span>
                @endif
                <p class="sr-only">Messages</p>
            </a>

            <button @click="notificationsOpen = !notificationsOpen; dropDownOpen = false" class="relative text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-all hover:scale-110 active:scale-95 mr-2 md:mr-4">
                <i class="far fa-bell text-xl" aria-hidden="true"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1.5 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-md shadow-red-500/30 animate-bounce">{{auth()->user()->unreadNotifications->count()}}</span>
                @endif
                <p class="sr-only">Notifications</p>
            </button>
            <div class="absolute bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl top-12 w-80 right-12 border border-slate-200/50 dark:border-slate-700/50 shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-2xl p-4 z-50 origin-top-right transition-all" 
                 x-show="notificationsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-2" style="display: none" @click.outside="notificationsOpen = false">
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 border-b dark:border-slate-700 pb-2 mb-2">{{ __("Notifications") }}</h3>
                <div class="max-h-64 overflow-y-auto beautify-scrollbar flex flex-col gap-2">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <div class="bg-slate-50 dark:bg-slate-700 p-2 rounded text-sm text-slate-700 dark:text-slate-300 border border-slate-100 dark:border-slate-600">
                            {{ $notification->data['message'] ?? __('Nouvelle notification') }}
                            <div class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 text-center py-3">{{ __("Aucune nouvelle notification.") }}</p>
                    @endforelse
                </div>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{route('notifications.mark-as-read')}}" method="POST" class="mt-3 text-center border-t border-slate-100 dark:border-slate-700 pt-3">
                        @csrf
                        <button type="submit" class="text-primary-600 dark:text-primary-400 text-xs font-bold hover:text-primary-700 transition-colors">{{ __('Tout marquer comme lu') }}</button>
                    </form>
                @endif
            </div>
            
        <button class="h-full flex items-center gap-3 text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group"  @click="dropDownOpen = !dropDownOpen; notificationsOpen = false">
            <p class="sr-only">Open Profile Card</p>
            <div class="flex items-center h-full">
                <img src="{{auth()->user()->profile_photo_url}}" alt="" class="rounded-full w-9 h-9 border-2 border-white dark:border-slate-700 shadow-sm">
                <p class="hidden lg:block px-2 font-medium" >{{auth()->user()->name}}</p>
            </div>
            <i :class="{'transition-all' : true,'fas fa-angle-right' : dropDownOpen == false , 'fas fa-angle-down ' : dropDownOpen == true}" aria-hidden="true"></i>
        </button>
        {{--User profile card--}}
        <div class="absolute bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl top-16 w-5/6 border border-slate-200/50 dark:border-slate-700/50 md:w-2/6 lg:w-[300px] shadow-[0_8px_30px_rgb(0,0,0,0.12)] right-4 flex flex-col items-center justify-center rounded-2xl p-6 text-slate-800 dark:text-slate-100 z-50 origin-top-right" x-show="dropDownOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95 translate-y-2" x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" x-transition:leave-end="transform opacity-0 scale-95 translate-y-2" style="display: none" @click.outside="dropDownOpen = false">
            <img src="{{auth()->user()->profile_photo_url}}" alt="" class="rounded-full w-20 h-20 border-4 border-white dark:border-slate-700 shadow-md mb-3">
            <h2 class="text-lg font-bold tracking-tight">{{auth()->user()->name}}</h2>
            <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-1">
                @isset(auth()->user()->school)
                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ __("Année Académique") }}:</span> {{auth()->user()->school->academicYear?->name}} <br>
                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ __("Semestre") }}:</span> {{auth()->user()->school->semester?->name}}
                @endif
            </p>
            <form action="{{route('logout')}}" class="w-full mt-4" method="POST">
                @csrf
                <button href="" class="w-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-100 font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2"><i class="fa fa-power-off text-red-500" aria-hidden="true"></i>{{ __("Déconnexion") }}</button>
            </form>
        </div>
        </div>
    </div>
</header>