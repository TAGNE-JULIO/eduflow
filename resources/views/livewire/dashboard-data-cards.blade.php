<div>
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
