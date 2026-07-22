<div>
    @if(session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Class</label>
            <select wire:model.live="selectedClass" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Section</label>
            <select wire:model.live="selectedSection" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white">
                <option value="">Select Section</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Date</label>
            <input type="date" wire:model.live="attendanceDate" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
        </div>
    </div>

    @if($selectedSection && count($students) > 0)
        <div class="overflow-x-auto relative shadow-sm sm:rounded-lg border border-slate-200 dark:border-slate-700 mb-4">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700 dark:text-slate-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Student Name</th>
                        <th scope="col" class="py-3 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700">
                            <td class="py-4 px-6 font-medium text-slate-900 whitespace-nowrap dark:text-white">
                                {{ $student->name }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="attendances.{{ $student->id }}" value="present" class="w-4 h-4 text-green-600 bg-slate-100 border-slate-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                        <span class="ml-2 text-sm text-slate-900 dark:text-slate-300">Present</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="attendances.{{ $student->id }}" value="late" class="w-4 h-4 text-yellow-500 bg-slate-100 border-slate-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                        <span class="ml-2 text-sm text-slate-900 dark:text-slate-300">Late</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="attendances.{{ $student->id }}" value="absent" class="w-4 h-4 text-red-600 bg-slate-100 border-slate-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                        <span class="ml-2 text-sm text-slate-900 dark:text-slate-300">Absent</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end">
            <button wire:click="saveAttendance" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                Save Attendance
            </button>
        </div>
    @elseif($selectedSection && count($students) == 0)
        <div class="text-center py-6 text-slate-500 dark:text-slate-400">
            No students found in this section.
        </div>
    @endif
</div>
