<button @class(["$class $colour inline-flex items-center justify-center py-2 px-4 border border-transparent rounded-lg text-sm font-medium hover:bg-opacity-90 hover:-translate-y-0.5 active:bg-opacity-70 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 shadow-sm my-3"] ) {{$attributes}}>
    @if($icon)
    <i class="{{$icon}} mr-2" aria-hidden="true"></i>
    @endif
    {{$slot}} {{$label}}
</button>