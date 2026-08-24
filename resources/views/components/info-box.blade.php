<div class="{{$class}} {{$colour}} {{$textColour}} rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-white/40 dark:border-slate-700/50 backdrop-blur-md relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group">
    <!-- Ambient glow effect -->
    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/20 dark:bg-white/5 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>
    
    <div class="p-5 md:p-6 text-center md:text-left flex flex-col md:flex-row gap-4 items-center justify-between border-b border-black/5 dark:border-white/5 relative z-10">
        <div class="flex-1">
            <p class="text-sm md:text-base font-semibold uppercase tracking-wider opacity-80 mb-1">{{$text}}</p>
            <h3 class="text-3xl md:text-4xl font-bold tracking-tight">{{$title}}</h3>
        </div>
        <div class="w-16 h-16 rounded-2xl bg-black/10 dark:bg-black/20 flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
            <i class="{{$icon}} text-3xl" aria-hidden="true"></i>
        </div>
    </div>
    @isset ($url)
        <div class="w-full bg-black/10 dark:bg-black/30 flex items-center justify-center relative z-10 hover:bg-black/20 dark:hover:bg-black/40 transition-colors">
            <a href="{{$url}}" class="w-full py-3 text-center text-sm font-semibold tracking-wide flex items-center justify-center gap-2">
                {{$urlText ?? 'Voir plus'}} <i class="fa fa-arrow-right group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
            </a>
        </div>
    @endif
</div>