<div @class(["$groupClass flex flex-col mb-4"])>
    <label for="{{$id}}" @class(["$labelClass block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1"])>{{$label}}</label>
    <input id="{{$id}}" name="{{$name}}" @class(["$class block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-sm transition-colors", 'border-red-500 focus:border-red-500 focus:ring-red-500/20' => $errors->$errorBag->has($name)]) {{$attributes}} value="{{old($name) ?? ($value != null ? $value : '')}}">
    @error($name, $errorBag)
        <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{$message}}</p>
    @enderror
</div>