<div x-data="{ 
        open: @entangle('isOpen'),
        init() {
            window.addEventListener('keydown', (e) => {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    this.open = true;
                    $wire.openModal();
                }
                if (e.key === 'Escape') {
                    this.open = false;
                    $wire.closeModal();
                }
            });
        }
    }">
    
    <!-- Modal Backdrop -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-50 flex items-start justify-center pt-16 md:pt-24 px-4"
         style="display: none;">
        
        <!-- Modal Card -->
        <div @click.outside="open = false; $wire.closeModal()"
             class="bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border border-slate-200/60 dark:border-slate-700/60 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden flex flex-col">
            
            <!-- Search Input Header -->
            <div class="p-4 border-b border-slate-100 dark:border-slate-700/60 flex items-center gap-3">
                <i class="fas fa-search text-slate-400 text-lg ml-2"></i>
                <input type="text" 
                       wire:model.live.debounce.250ms="query" 
                       placeholder="{{ __('Rechercher un élève, un professeur, une page... (Échap pour fermer)') }}" 
                       class="w-full bg-transparent border-0 focus:ring-0 text-slate-800 dark:text-slate-100 font-medium placeholder-slate-400 text-base"
                       x-ref="searchInput"
                       x-effect="if (open) setTimeout(() => $refs.searchInput.focus(), 100)">
                <kbd class="hidden md:inline-block px-2 py-1 text-xs font-semibold text-slate-400 bg-slate-100 dark:bg-slate-700 rounded-md border border-slate-200 dark:border-slate-600">Échap</kbd>
            </div>

            <!-- Results List -->
            <div class="max-h-96 overflow-y-auto p-4 beautify-scrollbar">
                @if(strlen($query) >= 2)
                    @if(count($results) > 0)
                        <div class="space-y-1">
                            @foreach($results as $item)
                                <a href="{{ $item['url'] }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-primary-500/10 hover:text-primary-600 dark:hover:text-primary-400 text-slate-700 dark:text-slate-300 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                                            <i class="{{ $item['icon'] }} text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm group-hover:text-primary-600 dark:group-hover:text-primary-400">{{ $item['title'] }}</p>
                                            @if(isset($item['subtitle']))
                                                <p class="text-xs text-slate-400">{{ $item['subtitle'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700/50">{{ $item['category'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center text-slate-400">
                            <i class="fas fa-search text-3xl mb-2 opacity-50"></i>
                            <p class="text-sm">{{ __('Aucun résultat trouvé pour') }} "{{ $query }}"</p>
                        </div>
                    @endif
                @else
                    <!-- Default Suggestions -->
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 px-2">{{ __('Raccourcis de navigation') }}</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($defaultNav as $nav)
                            <a href="{{ $nav['url'] }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-300 transition-all">
                                <i class="{{ $nav['icon'] }} text-primary-500"></i>
                                <span class="font-medium text-sm">{{ $nav['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Footer -->
            <div class="px-4 py-2.5 bg-slate-50/50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-700/60 text-xs text-slate-400 flex items-center justify-between">
                <span>{{ __('Astuce: Utilisez Ctrl + K pour ouvrir à tout moment') }}</span>
                <span class="font-semibold text-primary-500">EduFlow QuickSearch</span>
            </div>
        </div>
    </div>
</div>
