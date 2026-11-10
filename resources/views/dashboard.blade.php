@extends('layouts.app', ['breadcrumbs' => [
    ['href'=> route('dashboard'), 'text'=> __('Tableau de bord'), 'active'],
]])

@section('title', __('Dashboard'))

@section('page_heading', __('Tableau de bord'))

@section('content')

<!-- Dashboard Hero Banner -->
<div class="mb-8 p-6 md:p-8 rounded-3xl bg-gradient-to-r from-primary-600 via-primary-500 to-indigo-600 text-white shadow-xl shadow-primary-500/20 relative overflow-hidden group">
    <!-- Ambient glowing spheres -->
    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700 pointer-events-none"></div>
    <div class="absolute right-1/3 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-xs font-semibold tracking-wide mb-3 border border-white/20">
                <span>👋 {{ date('H') < 18 ? __('Bonjour') : __('Bonsoir') }}</span>
                <span class="w-1 h-1 rounded-full bg-white/60"></span>
                <span>{{ implode(', ', auth()->user()->getRoleNames()->toArray()) }}</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                {{ __('Bienvenue sur EduFlow') }}, {{ auth()->user()->name }} !
            </h2>
            <p class="text-white/80 text-sm mt-1 max-w-xl">
                {{ __('Voici un aperçu de vos activités académiques et des raccourcis de gestion pour votre établissement.') }}
            </p>
        </div>

        @isset(auth()->user()->school)
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/20">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white">
                    <i class="fas fa-university text-lg"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-white">{{ auth()->user()->school->name }}</p>
                    <p class="text-white/70">{{ auth()->user()->school->academicYear?->name }} • {{ auth()->user()->school->semester?->name }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

@can('set school')
    @livewire('set-school')
@endcan

@livewire('dashboard-data-cards')

@livewire('set-academic-year')

@if (auth()->user()->hasRole('student'))
    <div class="mb-4">
        <a href="{{route('students.print-profile',auth()->user()->id)}}" aria-label="Download Profile">
            <div class="card bg-purple-500 dark:bg-purple-600 text-white md:text-xl">
                <div class="card-body flex gap-4 items-center justify-center p-4">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    <p class="font-bold">{{ __("Télécharger le profil") }}</p>
                </div>
            </div>
        </a>
    </div>

    @livewire('student-dashboard')
@endif

@can('read notice')
    @livewire('list-notices-table')
@endcan

@if (auth()->user()->hasRole('applicant'))
    @livewire('application-history', ['applicant' => auth()->user()])
@endif

@can('read applicant')
    @livewire('list-account-applications-table')
@endcan

@endsection
