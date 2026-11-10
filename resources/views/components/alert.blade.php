@props(['colour' => 'bg-red-500', 'title', 'icon' => 'fa fa-ban', 'stackIcons' => [], 'class' => '', 'id' => 'alert', 'timeout' => '5000', 'show' => true])

<div @class(["$colour $class text-white rounded-2xl shadow-xl shadow-black/10 border border-white/20 backdrop-blur-lg w-full overflow-hidden transition-all duration-300"]) 
     aria-role="alert" 
     x-data="{'showAlert' : {{$show}}}" 
     x-show="showAlert" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
     id="{{$id}}" 
     {{$attributes}} 
     style="display:none">
    <div class="flex items-center justify-between p-4 pb-2">
        <div class="flex items-center gap-3">
            @if (!empty($stackIcons))
                <span class="fa-stack text-lg">
                    @foreach ($stackIcons as $stackIcon)
                        <i class="{{$stackIcon}} fa-stack-{{$loop->iteration}}x"></i>
                    @endforeach
                </span>
            @else
                <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                    <i class="text-sm {{$icon}}"></i>
                </div>
            @endif
            <p class="font-bold text-base tracking-tight">
                {{$title}}
            </p>
        </div>
        @if ($attributes->get('dismissOnTimeout') == true)
            <span x-init="setTimeout(() => { showAlert = false }, {{$timeout}});"></span>
        @endif
        
        <button type="button" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors cursor-pointer" aria-label="Fermer" @click="showAlert = false">
            <i class="fas fa-times text-xs" aria-hidden="true"></i>
        </button>
    </div>
    <div class="px-4 pb-4 pt-1 text-sm text-white/90 font-medium">
        {{$slot}}
    </div>
</div>
