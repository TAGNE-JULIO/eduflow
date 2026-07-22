<div>
    <x-loading-spinner/>
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-white dark:bg-slate-800 p-4 rounded-t-xl border-b border-slate-200 dark:border-slate-700">
        <div class="flex gap-4 items-center w-full md:w-auto relative">
            <i class="fa fa-search absolute left-3 text-slate-400" aria-hidden="true"></i>
            <input id="datatable-search-{{$uniqueId}}" type="search" wire:model.live.debounce.500ms="search" placeholder="Search..." class="form-input pl-10 pr-4 py-2 w-full md:w-64">
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            <span class="text-sm text-slate-500 dark:text-slate-400">Show</span>
            <select class="form-input py-2 pl-3 pr-8" wire:model.live="perPage">
                @foreach ([5,10,20,25,100] as $item)
                    <option value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="overflow-x-auto beautify-scrollbar bg-white dark:bg-slate-800 rounded-b-xl shadow-sm" >
        <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700/50 dark:text-slate-300">
                <th class="px-6 py-4 font-semibold">S/N</th>
                @foreach ($columns as $column)
                    @if (!isset($column['can']) || auth()->user()->can($column['can']))
                        <th class="px-6 py-4 font-semibold capitalize whitespace-nowrap">{{str_replace('_' , ' ', Str::snake( $column['name'] ??  $column['property']))}}</th>
                    @endif
                @endforeach
            </thead>
            <tbody>
                @if ($collection->isNotEmpty())
                    @foreach ($collection as $item)
                        <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <th class="px-6 py-4 font-medium text-slate-900 dark:text-white whitespace-nowrap">{{ $collection->perPage() * ($collection->currentPage() - 1) + $loop->iteration }}</th>
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
                                        <p class="{{$column['class'] ?? null}}">
                                            @if (array_key_exists('method', $column) && !empty($column['method']))
                                                {{ ($model?->{$column['method']}()) }}
                                            @elseif (array_key_exists('type', $column) && !empty($column['type']))
                                                @if ($column['type'] == 'delete')
                                                    <x-modal title="Confirm {{$column['name']}}" background-colour="bg-red-600">
                                                        <div class="text-gray-700 text-center dark:text-white">
                                                            <i class="fa fa-trash text-7xl" aria-hidden="true"></i>
                                                            <p class="my-2">Are you sure you want to {{Str::lower($column['name'])}} this resource</p>
                                                        </div>
                                                        <x-slot:footer>
                                                            <form action="{{route($column['action'],array_merge(($column['pre-route-parameters'] ?? []),[$model->id], ($column['post-route-parameters'] ?? [])))}}" method="POST">
                                                                <x-button class="bg-red-600" icon="fa fa-trash" >
                                                                    Continue with {{Str::lower($column['name'])}}
                                                                </x-button>
                                                                @method('delete')
                                                                @csrf
                                                            </form>
                                                        </x-slot:footer>
                                                    </x-modal>
                                                @elseif ($column['type'] == 'dropdown')
                                                    <x-dropdown >
                                                        @foreach ($column['links'] as $link)
                                                            @if (!isset($link['can']) || auth()->user()->can($link['can']))
                                                                <a href="{{route($link['href'],array_merge(($link['pre-route-parameters'] ?? []),[$model->id], ($link['post-route-parameters'] ?? [])))}}" class="flex capitalize items-center justify-start gap-2 py-3 px-6 hover:bg-white hover:bg-opacity-20 "><i class="{{$link['icon'] ?? ''}}" aria-hidden="true"></i>{{$link['text']}}</a>
                                                            @endif
                                                        @endforeach
                                                    </x-dropdown>
                                                @elseif($column['type'] == 'boolean-switch')
                                                <form action="{{route($column['action'], $model->id)}}" method="POST" x-data>
                                                    @csrf
                                                    <x-toggle :name="$column['field']" :checked="$model?->{$column['property'] ?? $column['name']}  == true"  :label-checked-text="$column['true-statement'] ?? 'yes'" :label-unchecked-text="$column['false-statement']?? 'no'" @Change="$nextTick(() => $el.form.submit())"/>
                                                </form>
                                                @elseif($column['type'] == 'image')
                                                    <div class="flex justify-center">
                                                        <img class="{{$column['img-class'] ?? " h-14 w-1/2 rounded-full"}}" loading="lazy" src="{{($model?->{$column['property'] ?? $column['name']}) }}" alt="">
                                                    </div>
                                                @endif
                                            @else
                                                @php
                                                    $property = ($model?->{$column['property'] ?? $column['name']})
                                                @endphp
                                                @if ($property instanceof \Carbon\Carbon)
                                                    {{$property->format('Y/m/d')}}
                                                @elseif($property instanceof \Brick\Money\Money)
                                                    {{$property->formatTo(app()->getLocale())}}
                                                @else
                                                    {{$property}}
                                                @endif
                                            @endif
                                        </p>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr class="bg-white dark:bg-slate-800">
                        <td class="px-6 py-8 text-center text-slate-500 dark:text-slate-400" colspan="100%">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa fa-inbox text-4xl mb-3 text-slate-300 dark:text-slate-600" aria-hidden="true"></i>
                                <p class="text-base font-medium">No data found</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="my-3">
        {{$collection->links()}}
    </div>
</div>
