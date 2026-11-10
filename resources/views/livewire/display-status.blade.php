<div>
    <div class="fixed z-50 flex flex-col gap-3 top-5 right-5 w-11/12 max-w-sm pointer-events-auto" id="status-display">
        @if (session('danger'))
            <x-alert colour="bg-gradient-to-r from-rose-600 to-red-500" title="{{ __('Erreur') }}" icon="fas fa-exclamation-triangle" dismissOnTimeout="true" timeout="6000">
                {{ session('danger') }}
            </x-alert>
        @endif
        @if (session('success'))
            <x-alert colour="bg-gradient-to-r from-emerald-600 to-teal-500" title="{{ __('Succès') }}" icon="fas fa-check-circle" dismissOnTimeout="true" timeout="5000">
                {{ session('success') }}
            </x-alert>
        @endif
        @if (session('info'))
            <x-alert colour="bg-gradient-to-r from-amber-500 to-orange-500" title="{{ __('Information') }}" icon="fas fa-info-circle" dismissOnTimeout="true" timeout="5000">
                {{ session('info') }}
            </x-alert>
        @endif
        @if (session('status'))
            <x-alert colour="bg-gradient-to-r from-emerald-600 to-teal-500" title="{{ __('Statut') }}" icon="fas fa-check-circle" dismissOnTimeout="true" timeout="5000">
                {{ session('status') }}
            </x-alert>
        @endif
        <x-alert colour="bg-gradient-to-r from-slate-800 to-slate-900 border-red-500/30" title="{{ __('Connexion Perdue') }}" icon="fas fa-wifi" show="false">
            <div @offline.window="showAlert = true" @online.window="showAlert = false">
                {{ __('Votre appareil semble hors ligne. Vérifiez votre connexion Internet.') }}
            </div>
        </x-alert>
    </div>
</div>
