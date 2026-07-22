@extends('layouts.app', ['title' => 'Assignments'])

@section('content')
    <div class="card bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Assignments</h1>
        @livewire('manage-assignments')
    </div>
@endsection
