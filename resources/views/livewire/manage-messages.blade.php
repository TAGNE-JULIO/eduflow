<div>
    @section('page_heading', __('Messagerie Interne'))

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <!-- Sidebar Navigation -->
        <div class="col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/70 dark:border-slate-700/70 overflow-hidden">
                <div class="p-4">
                    <button wire:click="setTab('compose')" class="w-full btn-primary py-3 flex items-center justify-center gap-2 text-sm font-bold shadow-md shadow-primary-500/20">
                        <i class="fas fa-plus"></i> {{ __('Nouveau Message') }}
                    </button>
                </div>
                <ul class="flex flex-col text-sm border-t border-slate-100 dark:border-slate-700/60 p-2 space-y-1">
                    <li>
                        <button wire:click="setTab('inbox')" class="w-full text-left px-4 py-3 rounded-xl flex justify-between items-center transition-all {{ $activeTab === 'inbox' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-bold shadow-2xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50' }}">
                            <span class="flex items-center gap-3"><i class="fas fa-inbox w-4 text-primary-500"></i> {{ __('Boîte de réception') }}</span>
                            @if($inbox->where('is_read', false)->count() > 0)
                                <span class="bg-primary-500 text-white text-[11px] font-bold py-0.5 px-2 rounded-full animate-pulse">{{ $inbox->where('is_read', false)->count() }}</span>
                            @endif
                        </button>
                    </li>
                    <li>
                        <button wire:click="setTab('sent')" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all {{ $activeTab === 'sent' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-bold shadow-2xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50' }}">
                            <i class="fas fa-paper-plane w-4 text-primary-500"></i> {{ __('Messages envoyés') }}
                        </button>
                    </li>
                </ul>
                <div class="p-4 border-t border-slate-100 dark:border-slate-700/60 text-xs text-slate-400">
                    <p class="flex items-center gap-1.5 font-medium"><i class="fas fa-lock text-emerald-500"></i> {{ __('Échanges chiffrés & sécurisés') }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-span-1 md:col-span-3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/70 dark:border-slate-700/70 min-h-[520px] flex flex-col">
                
                @if(session('success'))
                    <div class="m-6 p-4 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-sm flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-500 text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Compose Tab -->
                @if($activeTab === 'compose')
                    <div class="p-6 md:p-8 flex-1">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100 dark:border-slate-700/60">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                                    <i class="fas fa-envelope-open-text text-primary-500"></i> {{ __('Rédiger un Message') }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ __('Sélectionnez un destinataire et écrivez votre message confidentiel.') }}</p>
                            </div>
                        </div>

                        <form wire:submit="sendMessage" class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    {{ __('Destinataire') }} <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="receiver_id" class="form-input w-full cursor-pointer" required>
                                    <option value="">-- {{ __('Sélectionnez un destinataire...') }} --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">
                                            {{ $u->name }} ({{ implode(', ', $u->getRoleNames()->toArray()) ?: __('Utilisateur') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('receiver_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    {{ __('Sujet') }}
                                </label>
                                <input type="text" wire:model="subject" class="form-input w-full" placeholder="{{ __('Ex: Demande de renseignements, Devoir, etc.') }}">
                                @error('subject') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    {{ __('Message') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="body" rows="7" class="form-input w-full" placeholder="{{ __('Écrivez votre message ici...') }}" required></textarea>
                                @error('body') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700/60">
                                <button type="button" wire:click="setTab('inbox')" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                                    {{ __('Annuler') }}
                                </button>
                                <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove><i class="fas fa-paper-plane mr-2"></i> {{ __('Envoyer le message') }}</span>
                                    <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i> {{ __('Envoi en cours...') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Inbox Tab -->
                @if($activeTab === 'inbox')
                    <div class="border-b border-slate-100 dark:border-slate-700/60 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <i class="fas fa-inbox text-primary-500"></i> {{ __('Boîte de réception') }}
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">{{ count($inbox) }} {{ __('message(s)') }}</span>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-700/60 flex-1">
                        @forelse($inbox as $message)
                            <div wire:click="readMessage({{ $message->id }})" class="p-4 md:p-5 flex flex-col md:flex-row md:items-center justify-between cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors {{ !$message->is_read ? 'bg-primary-50/40 dark:bg-primary-950/20' : '' }}">
                                <div class="flex items-center gap-4 mb-2 md:mb-0">
                                    <div class="w-10 h-10 rounded-full {{ !$message->is_read ? 'bg-primary-500 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }} flex-shrink-0 flex items-center justify-center font-bold text-sm shadow-2xs">
                                        {{ strtoupper(substr($message->sender->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-semibold {{ !$message->is_read ? 'text-slate-900 dark:text-white font-bold' : 'text-slate-700 dark:text-slate-300' }}">{{ $message->sender->name ?? __('Inconnu') }}</h4>
                                            @if(!$message->is_read)
                                                <span class="inline-block w-2 h-2 rounded-full bg-primary-500"></span>
                                            @endif
                                        </div>
                                        <p class="text-xs {{ !$message->is_read ? 'text-slate-800 dark:text-slate-200 font-medium' : 'text-slate-500 dark:text-slate-400' }}">{{ $message->subject ?: __('(Sans sujet)') }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-400 md:text-right flex items-center gap-2">
                                    <i class="far fa-clock"></i>
                                    <span>{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 flex flex-col items-center justify-center flex-1">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center text-slate-300 dark:text-slate-600 mb-4">
                                    <i class="fas fa-envelope-open text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-700 dark:text-slate-200 text-base mb-1">{{ __('Votre boîte de réception est vide') }}</h4>
                                <p class="text-xs max-w-sm mb-6">{{ __('Vous n\'avez reçu aucun message pour le moment.') }}</p>
                                <button wire:click="setTab('compose')" class="btn-primary text-xs py-2 px-4">
                                    <i class="fas fa-pen mr-2"></i> {{ __('Rédiger un premier message') }}
                                </button>
                            </div>
                        @endforelse
                    </div>
                @endif

                <!-- Sent Tab -->
                @if($activeTab === 'sent')
                    <div class="border-b border-slate-100 dark:border-slate-700/60 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <i class="fas fa-paper-plane text-primary-500"></i> {{ __('Messages envoyés') }}
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">{{ count($sent) }} {{ __('message(s)') }}</span>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-700/60 flex-1">
                        @forelse($sent as $message)
                            <div wire:click="readMessage({{ $message->id }})" class="p-4 md:p-5 flex flex-col md:flex-row md:items-center justify-between cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                                <div class="flex items-center gap-4 mb-2 md:mb-0">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex-shrink-0 flex items-center justify-center text-primary-500 font-bold text-sm">
                                        <i class="fas fa-paper-plane text-xs"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('À:') }} {{ $message->receiver->name ?? __('Inconnu') }}</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $message->subject ?: __('(Sans sujet)') }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-400 md:text-right flex items-center gap-2">
                                    <span>{{ $message->created_at->diffForHumans() }}</span>
                                    @if($message->is_read)
                                        <i class="fas fa-check-double text-primary-500" title="{{ __('Lu') }}"></i>
                                    @else
                                        <i class="fas fa-check text-slate-400" title="{{ __('Envoyé') }}"></i>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 flex flex-col items-center justify-center flex-1">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center text-slate-300 dark:text-slate-600 mb-4">
                                    <i class="fas fa-paper-plane text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-700 dark:text-slate-200 text-base mb-1">{{ __('Aucun message envoyé') }}</h4>
                                <p class="text-xs max-w-sm mb-6">{{ __('Tous vos messages envoyés apparaîtront ici.') }}</p>
                                <button wire:click="setTab('compose')" class="btn-primary text-xs py-2 px-4">
                                    <i class="fas fa-pen mr-2"></i> {{ __('Rédiger un message') }}
                                </button>
                            </div>
                        @endforelse
                    </div>
                @endif

                <!-- Read Message Tab -->
                @if($activeTab === 'read' && $viewMessage)
                    <div class="p-6 md:p-8 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-700/60">
                                <button wire:click="setTab('inbox')" class="text-slate-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm font-semibold flex items-center gap-1.5">
                                    <i class="fas fa-arrow-left"></i> {{ __('Retour') }}
                                </button>
                                <span class="text-xs text-slate-400">{{ $viewMessage->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            
                            <h2 class="text-xl font-extrabold text-slate-800 dark:text-white mb-6">{{ $viewMessage->subject ?: __('(Sans sujet)') }}</h2>
                            
                            <div class="flex items-center gap-3 mb-6 p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30 border border-slate-100 dark:border-slate-700/50">
                                <div class="w-10 h-10 rounded-full bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center font-bold">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="text-xs">
                                    <div class="font-bold text-slate-900 dark:text-white text-sm">
                                        {{ __('De:') }} {{ $viewMessage->sender->name ?? __('Inconnu') }}
                                    </div>
                                    <div class="text-slate-500 dark:text-slate-400">
                                        {{ __('À:') }} {{ $viewMessage->receiver->name ?? __('Inconnu') }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-slate-700 dark:text-slate-200 p-6 bg-slate-50/70 dark:bg-slate-900/40 rounded-2xl border border-slate-100 dark:border-slate-800 leading-relaxed text-sm">
                                {!! nl2br(e($viewMessage->body)) !!}
                            </div>
                        </div>
                        
                        @if($viewMessage->receiver_id === auth()->id())
                            <div class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-700/60 flex justify-end">
                                <button wire:click="replyTo({{ $viewMessage->sender_id }}, '{{ addslashes($viewMessage->subject ?? '') }}')" class="btn-primary">
                                    <i class="fas fa-reply mr-2"></i> {{ __('Répondre') }}
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
