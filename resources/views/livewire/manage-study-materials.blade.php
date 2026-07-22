<div>
    @if(session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Study Materials</h2>
        <button wire:click="$toggle('showCreateForm')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            {{ $showCreateForm ? 'Cancel' : 'Upload Material' }}
        </button>
    </div>

    @if($showCreateForm)
        <div class="bg-slate-50 dark:bg-slate-700 p-6 rounded-lg mb-8 border border-slate-200 dark:border-slate-600">
            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-4">Upload New Material</h3>
            <form wire:submit.prevent="saveMaterial">
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
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:text-white"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">File Attachment</label>
                        <input type="file" wire:model="file" class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-slate-50 dark:text-slate-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400">
                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                        Upload Material
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($materials as $material)
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-shadow duration-200 p-5 flex flex-col h-full">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 p-3 rounded-lg">
                        <i class="fas fa-file-pdf text-xl"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">
                        {{ $material->subject->name ?? 'Subject' }}
                    </span>
                </div>
                <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-2">
                    {{ $material->title }}
                </h4>
                @if($material->description)
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 flex-grow line-clamp-3">
                        {{ $material->description }}
                    </p>
                @endif
                
                <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        {{ $material->section->name ?? 'All Sections' }}
                    </span>
                    @if($material->file_path)
                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
                            Download <i class="fas fa-download ml-1.5"></i>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                <div class="mb-3 text-4xl text-slate-300 dark:text-slate-600">
                    <i class="fas fa-folder-open"></i>
                </div>
                <p>No study materials uploaded yet.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $materials->links() }}
    </div>
</div>
