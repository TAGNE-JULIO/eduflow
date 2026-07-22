<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        
        <!-- Upcoming Assignments -->
        <div class="col-span-1 md:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                <i class="fas fa-tasks text-indigo-500 mr-2"></i> {{ __('Upcoming Assignments') }}
            </h3>
            @if(count($assignments) > 0)
                <div class="space-y-4">
                    @foreach($assignments as $assignment)
                        <div class="flex items-start p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-100 dark:border-slate-600">
                            <div class="flex-grow">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-semibold text-slate-900 dark:text-white">{{ $assignment->title }}</h4>
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ \Carbon\Carbon::parse($assignment->due_date)->isToday() ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300' }}">
                                        {{ __('Due:') }} {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">{{ __('Subject:') }} {{ $assignment->subject->name ?? __('N/A') }}</p>
                                @if($assignment->file_path)
                                    <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                        <i class="fas fa-paperclip mr-1"></i> {{ __('View Attachment') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-slate-500 dark:text-slate-400">
                    <i class="fas fa-check-circle text-4xl mb-3 text-green-400"></i>
                    <p>{{ __('No upcoming assignments. Great job!') }}</p>
                </div>
            @endif
        </div>

        <!-- Attendance & Discipline -->
        <div class="col-span-1 space-y-6">
            <!-- Recent Absences -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-calendar-times text-red-500 mr-2"></i> {{ __('Recent Absences / Lates') }}
                </h3>
                @if(count($absences) > 0)
                    <ul class="space-y-3">
                        @foreach($absences as $absence)
                            <li class="flex justify-between items-center text-sm">
                                <span class="text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}</span>
                                <span class="font-medium {{ $absence->status === 'absent' ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                    {{ ucfirst($absence->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-4">{{ __('Perfect attendance recently!') }}</p>
                @endif
            </div>

            <!-- Recent Discipline -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-balance-scale text-orange-500 mr-2"></i> Disciplinary Records
                </h3>
                @if(count($disciplinaryRecords) > 0)
                    <div class="space-y-3">
                        @foreach($disciplinaryRecords as $record)
                            <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg text-sm">
                                <div class="flex justify-between mb-1">
                                    <span class="font-semibold text-slate-900 dark:text-white">{{ $record->title }}</span>
                                    <span class="{{ $record->type === 'merit' ? 'text-green-600' : ($record->type === 'warning' ? 'text-yellow-600' : 'text-red-600') }} font-medium">
                                        {{ ucfirst($record->type) }}
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-4">No recent disciplinary records.</p>
                @endif
            </div>
        </div>
        
    </div>
</div>
