<header class="bg-white dark:bg-slate-800 h-16 w-full flex justify-between items-center py-2 border-b border-slate-200 dark:border-slate-700 shadow-sm transition-colors z-20 sticky top-0">
    <div class="flex items-center">
        <button role="button" class="text-xl mx-3 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-4 transition-colors" @click="menuOpen = !menuOpen">
            <p class="sr-only">Menu</p>
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <a href="{{route('home')}}" class="hidden md:flex items-center justify-center" aria-label="Home">
            <img src="{{asset(auth()->user()->school->logoURL ?? config('app.logo'))}}" alt="" class="rounded-full w-12 h-12 border border-slate-200 shadow-lg">
            <h1 class="text-lg font-semibold mx-3 text-center capitalize">{{config('app.name')}}</h1>
        </a>
    </div>
    <div class="flex justify-evenly items-center gap-6 px-5 h-full" x-data="{'dropDownOpen': false, 'notificationsOpen': false, 'darkMode' : $persist(false), 'fullScreen' : $persist(false) }">
        {{--full screen toggle--}}
        <button @click="fullScreen = !fullScreen; fullScreen == true ? document.documentElement.requestFullscreen() :  document.exitFullscreen()">
            <i class="fa fa-expand text-xl" aria-hidden="true"></i>
            <p class="sr-only">Full screen mode</p>
        </button>
        {{--Dark mode toggle--}}
        <button @click="darkMode = !darkMode" x-effect="darkMode == true ? document.body.classList.add('dark') :  document.body.classList.remove('dark') ">
            <i class="text-xl" :class="{'far fa-moon ' : darkMode == false, 'fas fa-moon' : darkMode == true}" aria-hidden="true"></i>
            <p class="sr-only">Dark mode</p>
        </button>
        {{--Click to open profile card--}}
        <div class="relative flex items-center gap-2 md:gap-4">
            {{-- Messages Icon --}}
            @php
                $unreadMessagesCount = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
            @endphp
            <a href="{{ route('messages.index') }}" class="relative text-slate-600 dark:text-slate-300 hover:text-indigo-600 transition-colors">
                <i class="far fa-envelope text-xl" aria-hidden="true"></i>
                @if($unreadMessagesCount > 0)
                    <span class="absolute -top-1.5 -right-2 bg-indigo-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $unreadMessagesCount }}</span>
                @endif
                <p class="sr-only">Messages</p>
            </a>

            <button @click="notificationsOpen = !notificationsOpen; dropDownOpen = false" class="relative text-slate-600 dark:text-slate-300 hover:text-indigo-600 transition-colors mr-2 md:mr-4">
                <i class="far fa-bell text-xl" aria-hidden="true"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1.5 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{auth()->user()->unreadNotifications->count()}}</span>
                @endif
                <p class="sr-only">Notifications</p>
            </button>
            <div class="absolute bg-white dark:bg-slate-800 top-12 w-72 right-12 border border-slate-200 dark:border-slate-700 shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 rounded-xl p-4 z-50 origin-top-right" 
                 x-show="notificationsOpen" x-transition style="display: none" @click.outside="notificationsOpen = false">
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 border-b dark:border-slate-700 pb-2 mb-2">Notifications</h3>
                <div class="max-h-64 overflow-y-auto beautify-scrollbar flex flex-col gap-2">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <div class="bg-slate-50 dark:bg-slate-700 p-2 rounded text-sm text-slate-700 dark:text-slate-300 border border-slate-100 dark:border-slate-600">
                            {{ $notification->data['message'] ?? 'New notification' }}
                            <div class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 text-center py-3">No new notifications.</p>
                    @endforelse
                </div>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{route('notifications.mark-as-read')}}" method="POST" class="mt-3 text-center border-t dark:border-slate-700 pt-2">
                        @csrf
                        <button type="submit" class="text-indigo-600 dark:text-indigo-400 text-xs font-semibold hover:underline">Mark all as read</button>
                    </form>
                @endif
            </div>
            
        <button class="h-full flex items-center gap-3 text-slate-700 dark:text-slate-300 hover:text-indigo-600 transition-colors"  @click="dropDownOpen = !dropDownOpen; notificationsOpen = false">
            <p class="sr-only">Open Profile Card</p>
            <div class="flex items-center h-full">
                <img src="{{auth()->user()->profile_photo_url}}" alt="" class="rounded-full w-9 h-9 border-2 border-white dark:border-slate-700 shadow-sm">
                <p class="hidden lg:block px-2 font-medium" >{{auth()->user()->name}}</p>
            </div>
            <i :class="{'transition-all' : true,'fas fa-angle-right' : dropDownOpen == false , 'fas fa-angle-down ' : dropDownOpen == true}" aria-hidden="true"></i>
        </button>
        {{--User profile card--}}
        <div class="absolute bg-white dark:bg-slate-800 top-16 w-5/6 border border-slate-200 dark:border-slate-700 md:w-2/6 lg:w-1/5 shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 right-4 flex flex-col items-center justify-center rounded-xl p-6 text-slate-800 dark:text-slate-100 z-50 origin-top-right" x-show="dropDownOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" style="display: none" @click.outside="dropDownOpen = false">
            <img src="{{auth()->user()->profile_photo_url}}" alt="" class="rounded-full w-20 h-20 border-4 border-white dark:border-slate-700 shadow-md mb-3">
            <h2 class="text-lg font-bold tracking-tight">{{auth()->user()->name}}</h2>
            <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-1">
                @isset(auth()->user()->school)
                    <span class="font-medium text-slate-700 dark:text-slate-300">Academic year:</span> {{auth()->user()->school->academicYear?->name}} <br>
                    <span class="font-medium text-slate-700 dark:text-slate-300">Semester:</span> {{auth()->user()->school->semester?->name}}
                @endif
            </p>
            <form action="{{route('logout')}}" class="w-full mt-4" method="POST">
                @csrf
                <button href="" class="w-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-100 font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2"><i class="fa fa-power-off text-red-500" aria-hidden="true"></i>Log out</button>
            </form>
        </div>
        </div>
    </div>
</header>