<div>
    <x-loading-spinner/>
    
    <!-- Table Toolbar -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center bg-white dark:bg-slate-800 p-4 rounded-t-2xl border-b border-slate-100 dark:border-slate-700/60 shadow-xs">
        <div class="flex gap-4 items-center w-full sm:w-auto relative">
            <i class="fas fa-search absolute left-3.5 text-slate-400 text-sm" aria-hidden="true"></i>
            <input id="datatable-search-{{$uniqueId}}" 
                   type="search" 
                   wire:model.live.debounce.400ms="search" 
                   placeholder="{{ __('Rechercher...') }}" 
                   class="form-input pl-10 pr-4 py-2 w-full sm:w-72 text-sm bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
        </div>
        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ __('Afficher') }}</span>
            <select class="form-input py-1.5 pl-3 pr-8 text-xs font-semibold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer" wire:model.live="perPage">
                @foreach ([5,10,20,25,50,100] as $item)
                    <option value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto beautify-scrollbar bg-white dark:bg-slate-800 rounded-b-2xl shadow-sm border border-t-0 border-slate-100 dark:border-slate-700/60">
        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
            <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase font-bold tracking-wider bg-slate-50/80 dark:bg-slate-700/40 border-b border-slate-100 dark:border-slate-700/60">
                <tr>
                    <th class="px-6 py-4 font-bold text-center w-14">#</th>
                    @foreach ($columns as $column)
                        @if (!isset($column['can']) || auth()->user()->can($column['can']))
                            <th class="px-6 py-4 font-bold whitespace-nowrap">{{ __(str_replace('_' , ' ', Str::snake( $column['name'] ??  $column['property']))) }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/40">
                @if ($collection->isNotEmpty())
                    @foreach ($collection as $item)
                        <tr class="bg-white dark:bg-slate-800 hover:bg-primary-50/30 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-400 dark:text-slate-500 text-center text-xs whitespace-nowrap">
                                {{ $collection->perPage() * ($collection->currentPage() - 1) + $loop->iteration }}
                            </td>
                            @foreach ($columns as $column)
                                @if (!isset($column['can']) || auth()->user()->can($column['can']))
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php 
                                            $model = $item;
                                            if (isset($column['relation'])) {
                                                $relations = explode('.',$column['relation']);
                                                foreach ($relations as $relation){
                                                    $model = $model->$relation;
                                                }
                                            }
                                            if (is_array($model)) {
                                                $model = collect($model);
                                            }
                                        @endphp
                                        <div class="{{$column['class'] ?? null}}">
                                            @if (array_key_exists('method', $column) && !empty($column['method']))
                                                {{ ($model?->{$column['method']}()) }}
                                            @elseif (array_key_exists('type', $column) && !empty($column['type']))
                                                @if ($column['type'] == 'delete')
                                                    <x-modal title="{{ __('Confirmer la suppression') }}" background-colour="bg-red-600">
                                                        <div class="text-slate-700 text-center dark:text-slate-200 p-4">
                                                            <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center mx-auto mb-4">
                                                                <i class="fas fa-trash-alt text-2xl" aria-hidden="true"></i>
                                                            </div>
                                                            <h4 class="text-lg font-bold mb-2">{{ __('Êtes-vous sûr ?') }}</h4>
                                                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Cette action est irréversible. Voulez-vous vraiment supprimer cet élément ?') }}</p>
                                                        </div>
                                                        <x-slot:footer>
                                                            <form action="{{route($column['action'],array_merge(($column['pre-route-parameters'] ?? []),[$model->id], ($column['post-route-parameters'] ?? [])))}}" method="POST">
                                                                <button type="submit" class="px-5 py-2.5 rounded-xl font-semibold text-white bg-red-600 hover:bg-red-700 transition-all flex items-center gap-2 shadow-sm">
                                                                    <i class="fas fa-trash-alt text-xs"></i> {{ __('Supprimer définitivement') }}
                                                                </button>
                                                                @method('delete')
                                                                @csrf
                                                            </form>
                                                        </x-slot:footer>
                                                    </x-modal>
                                                @elseif ($column['type'] == 'dropdown')
                                                    <x-dropdown>
                                                        @foreach ($column['links'] as $link)
                                                            @if (!isset($link['can']) || auth()->user()->can($link['can']))
                                                                <a href="{{route($link['href'],array_merge(($link['pre-route-parameters'] ?? []),[$model->id], ($link['post-route-parameters'] ?? [])))}}" class="flex capitalize items-center justify-start gap-2.5 py-2.5 px-4 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-primary-50 dark:hover:bg-slate-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                                                    <i class="{{$link['icon'] ?? ''}} text-xs" aria-hidden="true"></i>
                                                                    <span>{{ __($link['text']) }}</span>
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </x-dropdown>
                                                @elseif($column['type'] == 'boolean-switch')
                                                    <form action="{{route($column['action'], $model->id)}}" method="POST" x-data>
                                                        @csrf
                                                        <x-toggle :name="$column['field']" :checked="$model?->{$column['property'] ?? $column['name']}  == true" :label-checked-text="$column['true-statement'] ?? __('Oui')" :label-unchecked-text="$column['false-statement'] ?? __('Non')" @Change="$nextTick(() => $el.form.submit())"/>
                                                    </form>
                                                @elseif($column['type'] == 'image')
                                                    <div class="flex items-center">
                                                        <img class="{{$column['img-class'] ?? "h-10 w-10 rounded-full object-cover border border-slate-200 dark:border-slate-700 shadow-2xs"}}" loading="lazy" src="{{($model?->{$column['property'] ?? $column['name']}) }}" alt="Avatar">
                                                    </div>
                                                @endif
                                            @else
                                                @php
                                                    $property = ($model?->{$column['property'] ?? $column['name']})
                                                @endphp
                                                @if ($property instanceof \Carbon\Carbon)
                                                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">{{$property->format('d/m/Y')}}</span>
                                                @elseif($property instanceof \Brick\Money\Money)
                                                    <span class="font-bold text-slate-800 dark:text-slate-100">{{$property->formatTo(app()->getLocale())}}</span>
                                                @else
                                                    <span class="font-medium text-slate-800 dark:text-slate-200">{{$property}}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr class="bg-white dark:bg-slate-800">
                        <td class="px-6 py-12 text-center text-slate-500 dark:text-slate-400" colspan="100%">
                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-700/60 flex items-center justify-center mb-3">
                                    <i class="fas fa-folder-open text-2xl text-slate-400 dark:text-slate-500" aria-hidden="true"></i>
                                </div>
                                <h4 class="text-base font-bold text-slate-700 dark:text-slate-200 mb-1">{{ __('Aucune donnée trouvée') }}</h4>
                                <p class="text-xs text-slate-400">{{ __('Il n\'y a actuellement aucun enregistrement à afficher dans cette section.') }}</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex items-center justify-between">
        {{$collection->links()}}
    </div>
</div>
