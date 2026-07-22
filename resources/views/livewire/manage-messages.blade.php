<div>
    @section('page_heading', 'Messagerie Interne')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <!-- Sidebar -->
        <div class="col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="p-4">
                    <button wire:click="setTab('compose')" class="w-full btn-primary py-2.5 flex items-center justify-center gap-2">
                        <i class="fas fa-pen"></i> Nouveau Message
                    </button>
                </div>
                <ul class="flex flex-col text-sm border-t border-slate-100 dark:border-slate-700">
                    <li>
                        <button wire:click="setTab('inbox')" class="w-full text-left px-4 py-3 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors {{ $activeTab === 'inbox' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-600 dark:text-slate-300' }}">
                            <span><i class="fas fa-inbox w-5"></i> Boîte de réception</span>
                            @if($inbox->where('is_read', false)->count() > 0)
                                <span class="bg-indigo-500 text-white text-xs py-0.5 px-2 rounded-full">{{ $inbox->where('is_read', false)->count() }}</span>
                            @endif
                        </button>
                    </li>
                    <li>
                        <button wire:click="setTab('sent')" class="w-full text-left px-4 py-3 flex items-center hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors {{ $activeTab === 'sent' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-600 dark:text-slate-300' }}">
                            <i class="fas fa-paper-plane w-5"></i> Messages envoyés
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-span-1 md:col-span-3">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 min-h-[500px]">
                
                @if(session('success'))
                    <div class="m-4 p-3 bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Compose Tab -->
                @if($activeTab === 'compose')
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-6">Nouveau Message</h3>
                        <form wire:submit.prevent="sendMessage">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Destinataire <span class="text-red-500">*</span></label>
                                <select wire:model="receiver_id" class="form-input w-full" required>
                                    <option value="">Sélectionnez un destinataire...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ implode(', ', $user->getRoleNames()->toArray()) }})</option>
                                    @endforeach
                                </select>
                                @error('receiver_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Sujet</label>
                                <input type="text" wire:model="subject" class="form-input w-full" placeholder="Sujet du message...">
                                @error('subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Message <span class="text-red-500">*</span></label>
                                <textarea wire:model="body" rows="6" class="form-input w-full" placeholder="Écrivez votre message ici..." required></textarea>
                                @error('body') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-paper-plane mr-2"></i> Envoyer
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Inbox Tab -->
                @if($activeTab === 'inbox')
                    <div class="border-b border-slate-100 dark:border-slate-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Boîte de réception</h3>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($inbox as $message)
                            <div wire:click="readMessage({{ $message->id }})" class="p-4 flex flex-col md:flex-row md:items-center justify-between cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors {{ !$message->is_read ? 'bg-indigo-50/50 dark:bg-indigo-900/10' : '' }}">
                                <div class="flex items-center gap-4 mb-2 md:mb-0">
                                    <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-600 flex-shrink-0 flex items-center justify-center text-slate-600 dark:text-slate-300">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium {{ !$message->is_read ? 'text-slate-900 dark:text-white font-bold' : 'text-slate-700 dark:text-slate-300' }}">{{ $message->sender->name }}</h4>
                                        <p class="text-sm {{ !$message->is_read ? 'text-slate-800 dark:text-slate-200 font-semibold' : 'text-slate-500 dark:text-slate-400' }}">{{ $message->subject ?: 'Sans sujet' }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 md:text-right">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-500 dark:text-slate-400">
                                <i class="fas fa-envelope-open text-4xl mb-4 text-slate-300 dark:text-slate-600"></i>
                                <p>Votre boîte de réception est vide.</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                <!-- Sent Tab -->
                @if($activeTab === 'sent')
                    <div class="border-b border-slate-100 dark:border-slate-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Messages envoyés</h3>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($sent as $message)
                            <div wire:click="readMessage({{ $message->id }})" class="p-4 flex flex-col md:flex-row md:items-center justify-between cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <div class="flex items-center gap-4 mb-2 md:mb-0">
                                    <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-600 flex-shrink-0 flex items-center justify-center text-slate-600 dark:text-slate-300">
                                        <i class="fas fa-paper-plane text-sm"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300">À: {{ $message->receiver->name }}</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $message->subject ?: 'Sans sujet' }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 md:text-right flex items-center gap-2">
                                    <span>{{ $message->created_at->diffForHumans() }}</span>
                                    @if($message->is_read)
                                        <i class="fas fa-check-double text-blue-500" title="Lu"></i>
                                    @else
                                        <i class="fas fa-check text-slate-400" title="Envoyé"></i>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-500 dark:text-slate-400">
                                <i class="fas fa-paper-plane text-4xl mb-4 text-slate-300 dark:text-slate-600"></i>
                                <p>Vous n'avez envoyé aucun message.</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                <!-- Read Message Tab -->
                @if($activeTab === 'read' && $viewMessage)
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                            <button wire:click="setTab('inbox')" class="text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                <i class="fas fa-arrow-left mr-1"></i> Retour
                            </button>
                            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $viewMessage->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        
                        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">{{ $viewMessage->subject ?: 'Sans sujet' }}</h2>
                        
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-lg">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900 dark:text-white">
                                    De: {{ $viewMessage->sender->name }}
                                </div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">
                                    À: {{ $viewMessage->receiver->name }}
                                </div>
                            </div>
                        </div>

                        <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 p-6 bg-slate-50 dark:bg-slate-700/30 rounded-xl">
                            {!! nl2br(e($viewMessage->body)) !!}
                        </div>
                        
                        @if($viewMessage->receiver_id === auth()->id())
                            <div class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-700">
                                <button wire:click="setTab('compose')" class="btn-primary" wire:click="$set('receiver_id', {{ $viewMessage->sender_id }}); $set('subject', 'Re: {{ $viewMessage->subject }}');">
                                    <i class="fas fa-reply mr-2"></i> Répondre
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
