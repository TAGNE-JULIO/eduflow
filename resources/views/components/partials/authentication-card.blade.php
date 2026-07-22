@props(['class' => '', 'width' => 'w-10/12 md:w-8/12 lg:w-5/12 xl:w-4/12', 'height' => 'min-h-[20%]'])
<div class="flex flex-cols justify-center items-center my-12 flex-col">
    <img src="{{@asset(config('app.logo'))}}" alt="Logo" class="rounded-full w-24 h-24 border-4 border-white dark:border-slate-800 shadow-lg my-6 ring-4 ring-slate-50 dark:ring-slate-900">
    <div class="{{$class}} {{$width}} {{$height}} z-10 relative">
        <div class="p-8 w-full flex flex-col justify-center items-center glass rounded-2xl">
            {{$slot}}
        </div>
        <div class="mt-6 text-center text-sm font-medium">
            {{$footer ?? null}}
        </div>
    </div>
</div>