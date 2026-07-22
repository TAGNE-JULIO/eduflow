@props(['head' => ['key' , 'value'], 'body' => [['value' , 'another value'], ['value', 'another value']]])

<div class="overflow-x-auto beautify-scrollbar w-full bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
    <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
        @isset($head)
            <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700/50 dark:text-slate-300">
                <tr>
                    @foreach ($head as $th)
                        <th class="px-6 py-4 font-semibold capitalize">{{$th}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($body as $item)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors last:border-0">
                        @foreach ($item as $value)
                            <td class="px-6 py-4 whitespace-nowrap {{ $loop->first ? 'font-medium text-slate-900 dark:text-white' : '' }}">{{$value}}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        @endisset
    </table>
</div>