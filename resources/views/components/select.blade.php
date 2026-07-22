<div class="{{$groupClass}} mb-4 flex flex-col"  x-data="{'oldValue' : '{{old($name) ?? null }}'}">
    @isset($label) 
    <label for="{{$id}}" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">{{$label}}</label>
    @endisset
    @if (!$attributes->has('multiple'))
        <select name="{{$name}}" id="{{$id}}" @class(["$class block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 sm:text-sm transition-colors", 'border-red-500 focus:border-red-500 focus:ring-red-500/20' => $errors->has($name)]) {{$attributes}} @if(old($name) != null) x-model="oldValue" @endif x-init="oldValue !== '' && $dispatch('change', oldValue)">
            {{$slot}}
        </select>
    @else
        <div>
            <select class="hidden" id="{{$id}}">
                {{$slot}}
            </select>
    
            <div x-data="dropdown()" x-init="loadOptions()" class="">
                <div  x-data="{ allSelected : selected }">
                    <template x-for="selected in allSelected ">
                        <input type="hidden" name="{{$name}}" :value="options[selected].value">
                    </template>
                </div>
                    <div class="flex flex-col items-center relative w-full">
                        <div x-on:click="open" class="w-full">
                            <div class="my-1 p-1 flex border border-slate-300 dark:border-slate-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 bg-white dark:bg-slate-900 rounded-lg shadow-sm sm:text-sm transition-colors">
                                {{--display selected items--}}
                                <div class="flex flex-auto flex-wrap">
                                    <template x-for="(option,index) in selected" :key="options[option].value">
                                        <div class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-indigo-700 bg-indigo-100 dark:bg-indigo-900/50 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 ">
                                            <div class="text-xs font-normal leading-none max-w-full flex-initial" x-model="options[option]" x-text="options[option].text"></div>
                                            <div class="flex flex-auto flex-row-reverse">
                                                <button x-on:click="remove(index,option)">
                                                    <i class="fa fa-x mx-2 "></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    {{--display when no items are selected --}}
                                    <div x-show="selected.length  == 0" class="flex-1">
                                        <input disabled placeholder="{{$attributes->get('placeholder') ?? "Select Options"}}"
                                        class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-slate-700 dark:text-slate-300" :value="selectedValues()">
                                    </div>
                                </div>
                            <div class="text-slate-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-slate-300 dark:border-slate-600 svelte-1l8159u">
                                <button type="button" x-show="isOpen() === true" x-on:click="open" class="cursor-pointer w-6 h-6 text-slate-600 dark:text-slate-400 outline-none focus:outline-none hover:text-indigo-500">
                                    <i class="fa fa-angle-up" aria-hidden="true"></i>
                                </button>
                                </button>
                                <button type="button" x-show="isOpen() === false" @click="close" class="cursor-pointer w-6 h-6 text-slate-600 dark:text-slate-400 outline-none focus:outline-none hover:text-indigo-500">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div x-show.transition.origin.top="isOpen()" class="absolute shadow-lg top-100 bg-white dark:bg-slate-800 z-30 w-full rounded-xl border border-slate-200 dark:border-slate-700 max-h-60 overflow-y-auto beautify-scrollbar mt-1" x-on:click.away="close">
                            <div class="flex flex-col w-full">
                                <template x-for="(option,index) in options" :key="index">
                                    <div>
                                        <div class="cursor-pointer w-full hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" @click="select(index,$event)">
                                            <div :class="(option.selected) ? 'bg-indigo-50 dark:bg-indigo-900/30 border-indigo-500' : 'border-transparent'" class="flex w-full items-center p-2 pl-2 border-l-2 relative">
                                                <div class="w-full items-center flex">
                                                    <div class="mx-2 leading-6 text-slate-700 dark:text-slate-300" x-model="option" x-text="option.text"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    @endif
    @error($name)
        <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{$message}}</p>
    @enderror

    <script>
        function dropdown() {
            return {
                options: [],
                selected: [],
                show: false,
                open() { this.show = true },
                close() { this.show = false },
                isOpen() { return this.show === true },
                select(index, event) {
                if (!this.options[index].selected) {
                    this.options[index].selected = true;
                    this.options[index].element = event.target;
                    this.selected.push(index);

                } else {
                    this.selected.splice(this.selected.lastIndexOf(index), 1);
                    this.options[index].selected = false
                }
                },
                remove(index, option) {
                    this.options[option].selected = false;
                    this.selected.splice(index, 1);
                },
                loadOptions() {
                    const options = document.getElementById("{{$id}}").options;
                    for (let i = 0; i < options.length; i++) {
                        this.options.push({
                            value: options[i].value,
                            text: options[i].innerText,
                            selected: options[i].getAttribute('selected') != null  ? true && this.selected.push(i)  : false
                        });
                    }
                },
                selectedValues(){
                    return this.selected.map((option)=>{
                        return this.options[option].value;
                    })
                }
            }
        }
    </script>
</div>