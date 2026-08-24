<div>
    <!-- Quick Actions Banner -->
    <div class="mb-6 p-6 glass rounded-2xl border border-white/40 dark:border-slate-700/50 shadow-md">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-4 flex items-center gap-2">
            <i class="fas fa-bolt text-yellow-500"></i> {{ __('Actions Rapides') }}
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
            @can('create student')
                <a href="{{ route('students.create') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white/80 dark:bg-slate-800/80 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-600 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-700/60 transition-all hover:-translate-y-1 shadow-sm group">
                    <i class="fas fa-user-plus text-lg mb-1.5 text-primary-500 group-hover:text-white transition-colors"></i>
                    <span class="text-xs font-semibold text-center">{{ __('Nouvel Élève') }}</span>
                </a>
            @endcan
            @can('create teacher')
                <a href="{{ route('teachers.create') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white/80 dark:bg-slate-800/80 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-600 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-700/60 transition-all hover:-translate-y-1 shadow-sm group">
                    <i class="fas fa-chalkboard-teacher text-lg mb-1.5 text-indigo-500 group-hover:text-white transition-colors"></i>
                    <span class="text-xs font-semibold text-center">{{ __('Ajouter Prof') }}</span>
                </a>
            @endcan
            <a href="{{ route('messages.index') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white/80 dark:bg-slate-800/80 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-600 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-700/60 transition-all hover:-translate-y-1 shadow-sm group">
                <i class="fas fa-paper-plane text-lg mb-1.5 text-blue-500 group-hover:text-white transition-colors"></i>
                <span class="text-xs font-semibold text-center">{{ __('Message') }}</span>
            </a>
            @can('create notice')
                <a href="{{ route('notices.create') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white/80 dark:bg-slate-800/80 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-600 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-700/60 transition-all hover:-translate-y-1 shadow-sm group">
                    <i class="fas fa-bullhorn text-lg mb-1.5 text-amber-500 group-hover:text-white transition-colors"></i>
                    <span class="text-xs font-semibold text-center">{{ __('Annonce') }}</span>
                </a>
            @endcan
            @can('read timetable')
                <a href="{{ route('timetables.index') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white/80 dark:bg-slate-800/80 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-600 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-700/60 transition-all hover:-translate-y-1 shadow-sm group">
                    <i class="fas fa-calendar-alt text-lg mb-1.5 text-emerald-500 group-hover:text-white transition-colors"></i>
                    <span class="text-xs font-semibold text-center">{{ __('Emploi du temps') }}</span>
                </a>
            @endcan
            <a href="{{ route('schools.settings') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white/80 dark:bg-slate-800/80 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-600 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-700/60 transition-all hover:-translate-y-1 shadow-sm group">
                <i class="fas fa-cog text-lg mb-1.5 text-slate-500 group-hover:text-white transition-colors"></i>
                <span class="text-xs font-semibold text-center">{{ __('Paramètres') }}</span>
            </a>
        </div>
    </div>

    @hasanyrole('admin|super-admin')
    <div class="card">
        <div class="card-body">
            @can('read school')
                <h2 class="font-bold text-center text-2xl my-2 ">{{ __('Multi schools') }}</h2>
                <div>
                    <x-info-box :title="$schools" text="{{ __('Schools') }}" icon="fas fa-school text-dark" colour="bg-red-600" text-colour="text-white" :url="route('schools.index')" url-text="{{ __('View schools') }}"/>
                </div>
            @endcan

            @can('manage school settings')
                <h4 class="font-bold text-center text-2xl my-4">{{ __('School data') }}</h4>
            @endcan

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @can('read class group')
                    <x-info-box title="{{$classGroups}}" text="{{ __('Class groups') }}" colour="bg-orange-600"  text-colour="text-white" url="{{route('class-groups.index')}}" url-text="{{ __('View class groups') }}"/>
                @endcan
                @can('read class')
                    <x-info-box title="{{$classes}}" text="{{ __('Classes') }}" url="{{route('classes.index')}}" url-text="{{ __('View classes') }}" colour="bg-green-500"  text-colour="text-white"/>
                @endcan
                @can('read section')
                    <x-info-box title="{{$sections}}" text="{{ __('Sections') }}" url="{{route('sections.index')}}" url-text="{{ __('View sections') }}" colour="bg-lime-600"  text-colour="text-white" />
                @endcan
                @can('read student')
                    <x-info-box title="{{$students}}" text="{{ __('Students (active)') }}" icon=" text-dark" theme="yellow" url="{{route('students.index')}}" url-text="{{ __('View students') }}" colour="bg-blue-700"  text-colour="text-white"/>
                @endcan
                @can('read teacher')
                    <x-info-box title="{{$teachers}}" text="{{ __('Teachers') }}" icon=" text-dark" theme="orange" url="{{route('teachers.index')}}" url-text="{{ __('View teachers') }}" colour="bg-indigo-700"  text-colour="text-white"/>
                @endcan
                @can('read subject')
                    <x-info-box title="{{$parents}}" text="{{ __('Parents') }}" icon=" text-dark" theme="purple" url="{{route('parents.index')}}" url-text="{{ __('View Parents') }}"  colour="bg-violet-700"  text-colour="text-white"/>
                @endcan
                <x-info-box title="{{$assignments}}" text="{{ __('Assignments') }}" icon="fas fa-tasks text-dark" colour="bg-cyan-600" text-colour="text-white" url="{{route('assignments.index')}}" url-text="{{ __('View assignments') }}"/>
                <x-info-box title="{{$studyMaterials}}" text="{{ __('Study Materials') }}" icon="fas fa-book-reader text-dark" colour="bg-teal-600" text-colour="text-white" url="{{route('study-materials.index')}}" url-text="{{ __('View study materials') }}"/>
            </div>
        </div>
    </div>
    @endhasanyrole
</div>
