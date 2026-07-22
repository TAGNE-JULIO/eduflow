<div>
    @if(session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Assignments List</h2>
        <button wire:click="$toggle('showCreateForm')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            {{ $showCreateForm ? 'Cancel' : 'Create Assignment' }}
        </button>
    </div>

    @if($showCreateForm)
        <div class="bg-slate-50 dark:bg-slate-700 p-6 rounded-lg mb-8 border border-slate-200 dark:border-slate-600">
            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-4">New Assignment</h3>
            <form wire:submit.prevent="saveAssignment">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Title</label>
                        <input type="text" wire:model="title" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Subject</label>
                        <select wire:model="subject_id" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Section (Optional)</label>
                        <select wire:model="section_id" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                            <option value="">All Sections</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        @error('section_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description / Instructions</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Due Date</label>
                        <input type="date" wire:model="due_date" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                        @error('due_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Attachment (Optional)</label>
                        <input type="file" wire:model="file" class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-slate-50 dark:text-slate-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400">
                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                        Save Assignment
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-x-auto relative shadow-sm sm:rounded-lg border border-slate-200 dark:border-slate-700">
        <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700 dark:text-slate-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Title</th>
                    <th scope="col" class="py-3 px-6">Subject</th>
                    <th scope="col" class="py-3 px-6">Section</th>
                    <th scope="col" class="py-3 px-6">Due Date</th>
                    <th scope="col" class="py-3 px-6">Attachment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignments as $assignment)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600">
                        <td class="py-4 px-6 font-medium text-slate-900 dark:text-white">
                            {{ $assignment->title }}
                            @if($assignment->description)
                                <p class="text-xs text-slate-500 mt-1 font-normal">{{ Str::limit($assignment->description, 50) }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-6">{{ $assignment->subject->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6">{{ $assignment->section->name ?? 'All Sections' }}</td>
                        <td class="py-4 px-6">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">
                                {{ $assignment->due_date }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($assignment->file_path)
                                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    <i class="fas fa-paperclip mr-1"></i> View File
                                </a>
                            @else
                                <span class="text-slate-400">No file</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 px-6 text-center text-slate-500">No assignments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $assignments->links() }}
    </div>
</div>
