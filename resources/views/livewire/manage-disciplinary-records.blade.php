<div>
    @if(session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Records List</h2>
        <button wire:click="$toggle('showCreateForm')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            {{ $showCreateForm ? 'Cancel' : 'Add New Record' }}
        </button>
    </div>

    @if($showCreateForm)
        <div class="bg-slate-50 dark:bg-slate-700 p-6 rounded-lg mb-8 border border-slate-200 dark:border-slate-600">
            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-4">New Disciplinary / Merit Record</h3>
            <form wire:submit.prevent="saveRecord">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Student</label>
                        <select wire:model="student_id" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white">
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('student_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Type</label>
                        <select wire:model="type" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                            <option value="merit">Merit</option>
                            <option value="warning">Warning</option>
                            <option value="suspension">Suspension</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Title</label>
                        <input type="text" wire:model="title" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white" placeholder="e.g. Excellent participation / Late to class">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description / Remarks</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Date</label>
                        <input type="date" wire:model="date" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                        @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                        Save Record
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-x-auto relative shadow-sm sm:rounded-lg border border-slate-200 dark:border-slate-700">
        <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700 dark:text-slate-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Date</th>
                    <th scope="col" class="py-3 px-6">Student</th>
                    <th scope="col" class="py-3 px-6">Type</th>
                    <th scope="col" class="py-3 px-6">Title</th>
                    <th scope="col" class="py-3 px-6">Author</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600">
                        <td class="py-4 px-6 whitespace-nowrap">{{ $record->date }}</td>
                        <td class="py-4 px-6 font-medium text-slate-900 dark:text-white">{{ $record->student->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6">
                            @if($record->type === 'merit')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Merit</span>
                            @elseif($record->type === 'warning')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">Warning</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Suspension</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-900 dark:text-slate-100">{{ $record->title }}</div>
                            @if($record->description)
                                <div class="text-xs text-slate-500 mt-1">{{ Str::limit($record->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">{{ $record->author->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 px-6 text-center text-slate-500">No disciplinary records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>
